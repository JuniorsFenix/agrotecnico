<?php
class DbException extends Exception {

}

;

class DbQuery {

	var $m_db;
	var $v_rs = null;
	var $v_at;
	var $v_preparedQuery;
	var $v_boundValues;
	var $v_boundTypes;
	var $v_lastErrorText;

	function __construct(&$db) {
		$this->m_db = &$db;
		$this->clear();
		return;
	}

	public function clear() {
		$this->v_lastErrorText = 'no error';
		$this->v_preparedQuery = '';
		$this->v_at = -1;
		$this->v_boundValues = array();
		$this->v_boundTypes = array();
		if ($this->v_rs !== null && $this->v_rs!==false && $this->v_rs!==true) {
                    mysqli_free_result($this->v_rs);
		}
		$this->v_rs = null;
	}

	public function lastErrorText() {
		return $this->v_lastErrorText;
	}


	public function preparedQuery() {
		$sql = $this->v_preparedQuery;

		$boundValues = $this->v_boundValues;
		foreach ($this->v_boundTypes as $k => $v) {

			if ($v === true) {
				$boundValues[$k] = "'".mysqli_real_escape_string($this->m_db,$boundValues[$k])."'";
			}
		}


		//SQL Others
		$callbackOthers = function($c) use ($boundValues) {
			$field = $c[0];
			if(!isset($boundValues[$field])) throw new Exception("No bind value for field {$field}");
			return $boundValues[$field];
		};

		$sql = preg_replace_callback("/(?<!:)(:[a-zA-Z]{1}[a-zA-Z0-9_]+)/", $callbackOthers,$sql);
		unset($callbackOthers);

		return $sql;
	}

	public function exec($sql='') {
		$this->v_at = -1;
		$this->v_lastErrorText = '';

		if (trim($sql) == '' && trim($this->v_preparedQuery) != '') {
			$sql = $this->preparedQuery();
		}

		@ $this->v_rs = mysqli_query($this->m_db,$sql);
		if (!$this->v_rs) {
			echo $sql;
			$this->v_lastErrorText = "query failed, " . mysqli_error($this->m_db);
			throw new Exception($this->v_lastErrorText);
		}

		return true;
	}

	public function at() {
		return $this->v_at;
	}

	public function size() {
		return mysqli_num_rows($this->v_rs);
	}

	public function affectedRows() {
		return mysqli_affected_rows($this->v_rs);
	}


	public function fetch() {
		$this->v_at +=1;

		if ($this->v_at < 0 || ($this->v_at + 1) > $this->size()) {
			$size = $this->size();
			throw new Exception("DbQuery::assoc Index out of range index={$this->v_at} records={$size}");
		}

		return mysqli_fetch_assoc($this->v_rs);
	}

	public function assoc() {
		return $this->fetch();
	}

	public function fetchAll() {

		if ($this->v_rs === null) {
			throw new Exception("No executed query");
		}

		$result = array();
		while ($rax = mysqli_fetch_assoc($this->v_rs)) {
			$result[] = $rax;
		}
		return $result;
	}

	public function assocAll() {
		return $this->fetchAll();
	}

	public function bindValue($k, $v, $quote='auto') {
		//$v = addslashes($v);

		if ($quote === 'auto' && !is_bool($v) && !is_null($v)) {

			if (array_search(strtolower($v), array("current_time", "current_date", "current_timestamp")) !== false) {
				$this->bindValue($k, $v, false);
				return;
			}

			$match = array();
			preg_match("/[0-9\.,]+/", $v, $match);
			if (count($match) == 0 || $match[0] != $v) {
				$this->bindValue($k, $v, true);
				return;
			} else {
				$quote = false;
			}
		}

		if (is_bool($v)) {
			$quote = false;
			$v = $v === true ? "true" : "false";
		}

		if (is_null($v)) {
			$quote = false;
			$v = "null";
		}

		//error_log($v." ".addslashes($v));

		//$this->v_boundValues[$k] = $quote === true ? addslashes((string) $v) : $v;
		$this->v_boundValues[$k] = $v;
		$this->v_boundTypes[$k] = $quote;
	}

	public function boundValues() {
		return $this->v_boundValues;
	}

	public function prepare($sql) {
		$this->clear();
		$this->v_preparedQuery = $sql;
		return true;
	}

	public function prepareSelect($tableName, $fields, $where='', $order='', $extra='') {
		$this->clear();
		$sql = "select {$fields} from {$tableName} ";

		if (trim($where) != "") {
			$sql .= " where {$where} ";
		}

		if (trim($order) != "") {
			$sql .= " order by {$order} ";
		}

		if (trim($extra) != "") {
			$sql .=" {$extra} ";
		}


		$this->v_preparedQuery = $sql;
		return true;
	}

	public function prepareSelectForUpdate($tableName, $fields, $where, $order='', $extra='') {
		$extra.=" for update";
		return $this->prepareSelect($tableName, $fields, $where, $order, $extra);
	}

	public function prepareInsert($tableName, $fields, $extra='') {
		$this->clear();

		$sql = "";
		$fieldList = explode(",", $fields);
		$valueList = $fieldList;
		$tmp = null;
		$tmp2 = null;

		for ($i = 0; $i < count($fieldList); $i++) {

			if (strpos($fieldList[$i], "=") !== false) {
				$tmp2 = explode("=", $fieldList[$i]);
				$fieldList[$i] = $tmp2[0];
				$valueList[$i] = $tmp2[1];
			} else {
				$fieldList[$i] = trim($fieldList[$i]);
				$valueList[$i] = ":" . trim($fieldList[$i]);
			}
		}

		/* if( trim($v_userName)!="" ){
		 fieldList << "r_iusuario" << "r_ifechahora" << "r_uusuario" << "r_ufechahora";
		 valueList << ":r_iusuario" << ":r_ifechahora" << ":r_uusuario" << ":r_ufechahora";

		 bindValue(":r_iusuario",v_userName);
		 bindValue(":r_ifechahora","CURRENT_TIMESTAMP");
		 bindValue(":r_uusuario",v_userName);
		 bindValue(":r_ufechahora","CURRENT_TIMESTAMP");

		 } */

		$sql = "insert into " . $tableName . " ( "
		. implode(",", $fieldList) . " ) values ( "
		. implode(",", $valueList) . " ) {$extra}";

		$this->v_preparedQuery = $sql;
		return true;
	}

	public function prepareUpdate($tableName, $fields, $where='', $extra='') {
		$this->clear();

		$sql = '';
		$fieldList = explode(",", $fields);
		$tmp = null;

		$sql = "update " . $tableName . " set ";

		for ($i = 0; $i < count($fieldList); $i++) {
			$fieldList[$i] = trim($fieldList[$i]);
			if (strpos($fieldList[$i], "=") !== false) {
				$sql .= $fieldList[$i] . ",";
			} else {
				$sql .= $fieldList[$i] . " = :" . $fieldList[$i] . ",";
			}
		}

		/* if( !v_userName.trimmed().isEmpty() ){
		 sql += "r_uusuario=:r_uusuario,r_ufechahora=:r_ufechahora,";
		 bindValue(":r_uusuario",v_userName);
		 bindValue(":r_ufechahora","CURRENT_TIMESTAMP");
		 } */


		$sql = substr(trim($sql), 0, -1);


		if (trim($where) != "") {
			$sql .= " where " . $where;
		}

		$sql.=" {$extra} ";




		$this->v_preparedQuery = $sql;
		return true;
	}

	public function prepareDelete($tableName, $where) {
		$this->clear();

		$sql = "delete from " . $tableName . " ";
		if (trim($where) != '') {
			$sql .= " where " . $where;
		}

		$sql = trim($sql);
		$this->v_preparedQuery = $sql;
		return true;
	}

	public function execPage($p) {
		$page = isset($p["page"]) ? $p["page"] : 1;
		$count = isset($p["count"]) ? $p["count"] : 100;
		$sort = $p["sort"] ? "order by {$p["sort"]}" : "";

		$pager = isset($p["pager"]) ? $p["pager"] : false;
		$pagerVars = isset($p["pagerVars"]) ? $p["pagerVars"] : "";

		if ($page < 1) {
			throw new Exception("Invalid page number {$page}");
		}

		$sql = $this->preparedQuery();

		$limit = $count;
		$offset = ( $page - 1 ) * $count;

		$ca = new DbQuery($this->m_db);

		$ca->clear();
		$ca->exec("select count(*) as records from ({$sql}) execPage");
		
		//$ca->next();
		//$r = $ca->assoc();
		$r = $ca->fetch();
		$recordCount = $r["records"];
		$pageCount = ceil($recordCount / $count);


		$ca->clear();
		//echo "{$sql} limit {$limit} offset {$offset}";
		$ca->exec("select execPage.* from ({$sql}) execPage {$sort} limit {$limit} offset {$offset}");
		$records = $ca->assocAll();




		$result = array(
            "currentPage" => $page,
            "pageCount" => $pageCount,
            "recordCount" => $recordCount,
            "recordsPerPage" => $count,
            "records" => $records,
            "pagerVars" => $pagerVars
		);

		if ($pager) {
			require_once dirname(__FILE__) . '/pager.inc.php';
			$result["pager"] = Pager::htmlPager($result["pageCount"], $result["currentPage"], $pagerVars);
		}

		return $result;
	}

	/**
	 *
	 * @param string $fieldList cadena separada por comas
	 * @param string $value
	 * @return string
	 */
	public static function sqlFieldsFilters($fieldList, $value) {
		if (is_string($fieldList)) {
			$fields = explode(",", $fieldList);
		}

		$filtro = strtolower($value);

		$sqlFilters = array();
		foreach ($fields as $f) {
			$sqlFilters[] = "lower({$f}::text) like lower('%{$value}%')";
		}
		$sqlFilters = implode(" or ", $sqlFilters);
		return "( {$sqlFilters} )";
	}

}

?>