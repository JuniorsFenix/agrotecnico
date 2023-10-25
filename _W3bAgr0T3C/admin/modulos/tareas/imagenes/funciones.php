<?php
    if(!session_id()) session_start();
	require_once dirname(__FILE__).("/connect.php");
	require_once dirname(__FILE__).("/password.php");
	require_once dirname(__FILE__).("/phpmailer/class.phpmailer.php");
	require_once dirname(__FILE__).("/SimpleImage.php");

$db = get_db();
$sitioCfg = sitioFetch();

function in_array_r($needle, $haystack, $strict = false){
foreach($haystack as $item){
   if(is_array($item)){
     if(in_array_r($needle, $item, $strict)){
       return true;
     }
   }else{
     if(($strict ? $needle === $item : $needle == $item)){
       return true;
     }
   }
}
return false;
}

function nuevaLinea() {
  if (defined('PHP_EOL')) {
    return PHP_EOL;
  }
  $newline = "\r\n";
  if (strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), 'win')) {
    $newline = "\r\n";
  } else if (strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), 'mac')) {
    $newline = "\r";
  } else {
    $newline = "\n";
  }
  return $newline;
}
function generate_password( $length = 6 ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$password = substr( str_shuffle( $chars ), 0, $length );
	return $password;
}
function sitioFetch(){
	global $db;
	$stmt = $db->query("select * from tblsitio");
	return $stmt->fetch(PDO::FETCH_ASSOC);		
}
function encuestasQuery(){
	global $db;
	return $stmt = $db->query("SELECT * from encuestas");
}
function preguntasQuery($idencuesta){
	global $db;
	return $stmt = $db->query("SELECT * from preguntas WHERE id_encuesta=$idencuesta");
}
function documentosQuery(){
	global $db;
	return $stmt = $db->query("SELECT * from documentos");
}
function campanasQuery(){
	global $db;
	return $stmt = $db->query("SELECT * from campanas");
}
function videosQuery(){
	global $db;
	return $stmt = $db->query("SELECT * from videos");
}
function mensajesQuery($id){
	global $db;
	return $stmt = $db->query("SELECT * from campanas_mensajes cm join usuarios u on cm.correo=u.correo WHERE id_campana=$id");
}
function muroQuery($id){
	global $db;
	return $stmt = $db->query("SELECT * from mensajes m join usuarios u on m.idusuario2=u.id WHERE idusuario=$id");
}
function pizarraQuery(){
	global $db;
	return $stmt = $db->query("SELECT * from mensajes_generales m join usuarios u on m.idusuario=u.id");
}
function categoriasQuery(){
	global $db;
	return $stmt = $db->query("SELECT * from acciones_categorias");
}
function diagnosticosQuery(){
	global $db;
	return $stmt = $db->query("SELECT r.*, rc.categoria from diagnosticos r join diagnosticos_categorias rc on r.idcategoria=rc.idcategoria");
}
function cRiesgosQuery(){
	global $db;
	return $stmt = $db->query("SELECT * from riesgos_categorias");
}
function riesgosQuery(){
	global $db;
	return $stmt = $db->query("SELECT * from riesgos");
}
function diagnosticosQuery2($idcategoria){
	global $db;
	return $stmt = $db->query("SELECT * from diagnosticos WHERE idcategoria=$idcategoria");
}
function historialQuery($id='', $limit=''){
	global $db;
	$query= "SELECT hm.*, u.nombre, u.apellido, u.correo from historial_medico hm join usuarios u on hm.idusuario=u.id";
	if($id!=""){
		$query.= " WHERE hm.idusuario=$id";
	}
		$query.= " order by idhistorial desc";
	if($limit!=""){
		$query.= " LIMIT $limit";
	}
	return $stmt = $db->query($query);
}
function certificadosQuery($id=''){
	global $db;
	$query= "SELECT c.*, u.nombre, u.apellido from certificados c join usuarios u on c.idusuario=u.id";
	if($id!=""){
		$query.= " WHERE c.idusuario=$id";
	}
		$query.= " order by idcertificado desc";
	return $stmt = $db->query($query);
}
function adjuntosQuery($id_campana=-1, $id_mensaje=-1){
	global $db;
	if($id_campana!=-1){
	return $stmt = $db->query("SELECT * from adjuntos WHERE id_campana=$id_campana AND id_mensaje=0");
	}
	if($id_mensaje!=-1){
	return $stmt = $db->query("SELECT * from adjuntos WHERE id_mensaje=$id_mensaje");
	}
}
function adjuntosAprobados($id_campana){
	global $db;
	return $stmt = $db->query("SELECT * from adjuntos WHERE id_campana=$id_campana AND estado='Aprobado'");
}
function categoriasMembresiasQuery(){
	global $db;
	return $stmt = $db->query("SELECT * from tblmb_categorias");
}
function datosCategoriaMembresias($id){
	global $db;
	$stmt = $db->prepare("SELECT * FROM tblmb_categorias WHERE idcategoria=?");
	$stmt->execute(array($id));
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function guardarCategoriaMembresias($d){
	global $db;
	$stmt = $db->prepare("INSERT INTO tblmb_categorias(nombre) VALUES(:categoria)");
	$stmt->bindValue(':categoria', $d["categoria"], PDO::PARAM_STR);
	$stmt->execute();
	return;
}
function actualizarCategoriaMembresias($d){
	global $db;
	$stmt = $db->prepare("UPDATE tblmb_categorias SET nombre=:categoria WHERE idcategoria=:id");	
	$stmt->bindValue(':categoria', $d["nombre"], PDO::PARAM_STR);
	$stmt->bindValue(':id', $d["idcategoria"], PDO::PARAM_INT);
	$stmt->execute();
	return;
}
function eliminarCategoriaMembresias($idcategoria){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM tblmb_categorias WHERE idcategoria=:id");
	$stmt->bindValue(':id', $idcategoria, PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/categorias-membresias");
	exit();
}

function membresiasCategoriasQuery($idmembresia){
	global $db;
	$stmt = $db->query("SELECT idcategoria from tblmb_membresias_categorias WHERE idmembresia=$idmembresia");
	return $stmt;
}
function MembresiasQuery(){
	global $db;
	return $stmt = $db->query("SELECT * from tblmb_membresias");
}
function datosMembresias($id){
	global $db;
	$stmt = $db->prepare("SELECT * FROM tblmb_membresias WHERE idmembresia=?");
	$stmt->execute(array($id));
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function guardarMembresias($d){
	global $db;
	$stmt = $db->prepare("INSERT INTO tblmb_membresias(nombre) VALUES(:membresia)");
	$stmt->bindValue(':membresia', $d["nombre"], PDO::PARAM_STR);
	$stmt->execute();
	
	$d["idmembresia"] = $db->lastInsertId();
	$idcategoria=0;
	$stmt = $db->prepare("INSERT INTO tblmb_membresias_categorias(idmembresia,idcategoria) VALUES(:idmembresia,:idcategoria)");
	$stmt->bindValue(':idmembresia', $d["idmembresia"], PDO::PARAM_INT);
	$stmt->bindParam(':idcategoria', $idcategoria, PDO::PARAM_INT);
	foreach($d["idscategorias"] as $k => $v) {
		$idcategoria = $v;
		$stmt->execute();
	}
	return;
}
function actualizarMembresias($d){
	global $db;
	$stmt = $db->prepare("UPDATE tblmb_membresias SET nombre=:membresia WHERE idmembresia=:id");	
	$stmt->bindValue(':membresia', $d["membresia"], PDO::PARAM_STR);
	$stmt->bindValue(':id', $d["idmembresia"], PDO::PARAM_INT);
	$stmt->execute();
	
	$stmt = $db->prepare("DELETE FROM tblmb_membresias_categorias WHERE idmembresia=:id");
	$stmt->bindValue(':id', $d["idmembresia"], PDO::PARAM_INT);
	$stmt->execute();
	
	$idcategoria=0;
	$stmt = $db->prepare("INSERT INTO tblmb_membresias_categorias(idmembresia,idcategoria) VALUES(:idmembresia,:idcategoria)");
	$stmt->bindValue(':idmembresia', $d["idmembresia"], PDO::PARAM_INT);
	$stmt->bindParam(':idcategoria', $idcategoria, PDO::PARAM_INT);
	foreach($d["idscategorias"] as $k => $v) {
		$idcategoria = $v;
		$stmt->execute();
	}
	return;
}
function eliminarMembresias($idmembresia){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM tblmb_membresias WHERE idmembresia=:id");
	$stmt->bindValue(':id', $idmembresia, PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/categorias-membresias");
	exit();
}

function membresiasVideosQuery($idvideo){
	global $db;
	$stmt = $db->query("SELECT idcategoria from tblmb_videos_categorias WHERE idvideo=$idvideo");
	return $stmt;
}
function membresiasContenidosQuery($idcontenido){
	global $db;
	$stmt = $db->query("SELECT idcategoria from tblmb_contenidos_categorias WHERE idcontenido=$idcontenido");
	return $stmt;
}
function contenidosMembresiasQuery($contenido){
	global $db;
	return $stmt = $db->query("SELECT * from tblmb_contenidos where tipo='$contenido'");
}
function datosContenidoMembresias($id){
	global $db;
	$stmt = $db->prepare("SELECT * FROM tblmb_contenidos WHERE idcontenido=?");
	$stmt->execute(array($id));
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function guardarContenidoMembresias($d,$f){
	global $db;
	global $sitioCfg;
	$imagen = "";
	$archivo = "";
	if( isset( $f["imagen"]["tmp_name"] ) && $f["imagen"]["tmp_name"]!="" ) {
	$imagen = $f["imagen"]["name"];
		$image = new SimpleImage();
		$image->load($f["imagen"]["tmp_name"]);
		$image->resizeToWidth(800);
		$image->save("./fotos/documentos/$imagen");
	}
	if ($f["archivo"]["name"] != "") {
		$archivo = $f["archivo"]["name"];
		if (!move_uploaded_file($f["archivo"]["tmp_name"], "./fotos/archivos/$archivo")) {
			die("Fallo cargando archivo al servidor");
		}
	}
	$stmt = $db->prepare("INSERT INTO tblmb_contenidos(nombre,contenido,fecha_publicacion,url_informacion,imagen,archivo,estado,tipo) VALUES(:nombre,:contenido,NOW(),:url,:imagen,:archivo,:estado,:tipo)");	
	$stmt->bindValue(':nombre', $d["nombre"], PDO::PARAM_STR);	
	$stmt->bindValue(':contenido', $d["contenido"], PDO::PARAM_STR);
	$stmt->bindValue(":url", $d["url_informacion"], PDO::PARAM_STR);
	$stmt->bindValue(':imagen', $imagen, PDO::PARAM_STR);
	$stmt->bindValue(':archivo', $archivo, PDO::PARAM_STR);
	$stmt->bindValue(':estado', $d["estado"], PDO::PARAM_INT);
	$stmt->bindValue(':tipo', $d["tipo"], PDO::PARAM_STR);
	$stmt->execute();
	
	$d["idcontenido"] = $db->lastInsertId();
	$idcategoria=0;
	$stmt = $db->prepare("INSERT INTO tblmb_contenidos_categorias(idcontenido,idcategoria) VALUES(:idcontenido,:idcategoria)");
	$stmt->bindValue(':idcontenido', $d["idcontenido"], PDO::PARAM_INT);
	$stmt->bindParam(':idcategoria', $idcategoria, PDO::PARAM_INT);
	foreach($d["idscategorias"] as $k => $v) {
		$idcategoria = $v;
		$stmt->execute();
	}
	return;
}
function actualizarContenidoMembresias($d,$f){
	global $db;
	$imagen = "";
	$archivo = "";
	if( isset( $f["imagen"]["tmp_name"] ) && $f["imagen"]["tmp_name"]!="" ) {
	$imagen = $f["imagen"]["name"];
		$image = new SimpleImage();
		$image->load($f["imagen"]["tmp_name"]);
		$image->resizeToWidth(800);
		$image->save("./fotos/documentos/$imagen");
	}
	if ($f["archivo"]["name"] != "") {
		$archivo = $f["archivo"]["name"];
		if (!move_uploaded_file($f["archivo"]["tmp_name"], "./fotos/archivos/$name")) {
			die("Fallo cargando archivo al servidor");
		}
	}
	$stmt = $db->prepare("UPDATE tblmb_contenidos SET nombre=:nombre,contenido=:contenido,url_informacion=:url,imagen=:imagen,archivo=:archivo,estado=:estado WHERE idcontenido=:id");		
	$stmt->bindValue(':nombre', $d["titulo"], PDO::PARAM_STR);	
	$stmt->bindValue(':contenido', $d["contenido"], PDO::PARAM_STR);
	$stmt->bindValue(":url", $d["url_informacion"], PDO::PARAM_STR);
	$stmt->bindValue(':imagen', $imagen, PDO::PARAM_STR);
	$stmt->bindValue(':archivo', $archivo, PDO::PARAM_STR);
	$stmt->bindValue(':estado', $d["estado"], PDO::PARAM_INT);
	$stmt->bindValue(':id', $d["idcontenido"], PDO::PARAM_STR);
	$stmt->execute();
	
	$stmt = $db->prepare("DELETE FROM tblmb_contenidos_categorias WHERE idcontenido=:id");
	$stmt->bindValue(':id', $d["idcontenido"], PDO::PARAM_INT);
	$stmt->execute();
	
	$idcategoria=0;
	$stmt = $db->prepare("INSERT INTO tblmb_contenidos_categorias(idcontenido,idcategoria) VALUES(:idcontenido,:idcategoria)");
	$stmt->bindValue(':idcontenido', $d["idcontenido"], PDO::PARAM_INT);
	$stmt->bindParam(':idcategoria', $idcategoria, PDO::PARAM_INT);
	foreach($d["idscategorias"] as $k => $v) {
		$idcategoria = $v;
		$stmt->execute();
	}
	return;
}
function eliminarContenidoMembresias($idcontenido){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM tblmb_contenidos WHERE idcontenido=:id");
	$stmt->bindValue(':idcontenido', $idcontenido, PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/documentos-membresias");
	exit();
}

function datosEncuesta($id){
	global $db;
	$stmt = $db->prepare("SELECT * FROM encuestas WHERE id=?");
	$stmt->execute(array($id));
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function guardarEncuesta($d){
	global $db;
	global $sitioCfg;
	date_default_timezone_set('America/Bogota');
	$stmt = $db->prepare("INSERT INTO encuestas(titulo, ver_estadisticas, introduccion, mensaje_completo, estado, fecha_creacion) VALUES(:titulo,:ver_estadisticas,:introduccion,:mensaje_completo,:estado,:fecha)");	
	$stmt->bindValue(':titulo', $d["titulo"], PDO::PARAM_STR);
	$stmt->bindValue(':ver_estadisticas', $d["ver_estadisticas"], PDO::PARAM_INT);
	$stmt->bindValue(':introduccion', $d["introduccion"], PDO::PARAM_STR);
	$stmt->bindValue(':mensaje_completo', $d["mensaje_completo"], PDO::PARAM_STR);
	$stmt->bindValue(':estado', $d["estado"], PDO::PARAM_INT);
	$stmt->bindValue(':fecha', date('Y-m-d H:i:s'), PDO::PARAM_STR);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/encuestas");
	exit();
}
function actualizarEncuesta($d){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("UPDATE encuestas SET titulo=:titulo, ver_estadisticas=:ver_estadisticas, introduccion=:introduccion, mensaje_completo=:mensaje_completo, estado=:estado WHERE id=:id");	
	$stmt->bindValue(':titulo', $d["titulo"], PDO::PARAM_STR);
	$stmt->bindValue(':ver_estadisticas', $d["ver_estadisticas"], PDO::PARAM_INT);
	$stmt->bindValue(':introduccion', $d["introduccion"], PDO::PARAM_STR);
	$stmt->bindValue(':mensaje_completo', $d["mensaje_completo"], PDO::PARAM_STR);
	$stmt->bindValue(':estado', $d["estado"], PDO::PARAM_INT);
	$stmt->bindValue(':id', $d["idencuesta"], PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/encuestas");
	exit();
}
function eliminarEncuesta($idencuesta){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM encuestas WHERE id=:id");
	$stmt->bindValue(':id', $idencuesta, PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/encuestas");
	exit();
}
function enviarEncuesta($idencuesta){
	global $db;
	global $sitioCfg;
	
	$mensaje   = "<table border='0' cellpadding='5' cellspacing='0' style='height:196px; width:604px'>
	<tbody>
		<tr>
			<td>
			<p><img src='http://www.miendomarketing.com/$sitioCfg[carpeta]/fotos/transloyola.png' style='height:138px; width:226px' /></p>
			</td>
			<td>
			<p>Se ha creado una nueva encuesta en la zona endom&aacute;rketing de Transloyola<br />
			<br />
			Puede ingresar <a href='http://www.miendomarketing.com/$sitioCfg[carpeta]/encuesta/$idencuesta'>aquí</a> para realizarla:<br />
			<br />
			<br /></p>
			</td>
		</tr>
	</tbody>
</table>
";
	$mail = new PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->From      = $sitioCfg["correo"];
	$mail->FromName  = $sitioCfg["nombre"];
	$stmt = $db->query("SELECT correo from usuarios");
    foreach($stmt as $row) {
	$mail->AddAddress( $row["correo"] );
	}
	$mail->Subject   = "Nueva encuesta para Transloyola";
	$mail->Body      = $mensaje;
	$mail->IsHTML(true);
	$mail->Send();
	header("Location: /$sitioCfg[carpeta]/encuestas");
	exit();
}
function enviarRecomendacion($id){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("SELECT hm.*, u.nombre, u.apellido, u.correo, r.diagnostico, rc.categoria from historial_medico hm join usuarios u on hm.idusuario=u.id join diagnosticos r on hm.iddiagnostico=r.iddiagnostico join diagnosticos_categorias rc on r.idcategoria=rc.idcategoria WHERE hm.idhistorial=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	global $sitioCfg;
	
	$mensaje   = "<table border='0' cellpadding='5' cellspacing='0' style='height:196px; width:604px'>
	<tbody>
		<tr>
			<td>
			<p><img src='http://www.miendomarketing.com/$sitioCfg[carpeta]/fotos/transloyola.png' style='height:138px; width:226px' /></p>
			</td>
			<td>
			Recomendaciones para su salud:<br />
			<br />
			<p>$row[recomendaciones]</p>
			</td>
		</tr>
	</tbody>
</table>
";
	$mail = new PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->From      = $sitioCfg["correo"];
	$mail->FromName  = $sitioCfg["nombre"];
	$mail->AddAddress( $row["correo"] );
	$mail->Subject   = "Recomendaciones para su salud";
	$mail->Body      = $mensaje;
	$mail->IsHTML(true);
	$mail->Send();
	header("Location: /$sitioCfg[carpeta]/historial-medico");
	exit();
}
function opcionesQuery($idpregunta) {
	global $db;
	$string = '';
	$stmt = $db->query("SELECT * from opciones WHERE id_pregunta=$idpregunta ORDER BY id_opciones");
	foreach($stmt as $row) {
		$string .= $row["texto"].nuevaLinea();
	}
	return trim($string);
}
function datosPregunta($id){
	global $db;
	$stmt = $db->prepare("SELECT * FROM preguntas WHERE id=?");
	$stmt->execute(array($id));
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function guardarPregunta($d){
	global $db;
	global $sitioCfg;
  	$vars  = ($d['var_text'] ? explode(nuevaLinea(),$d['var_text']) : '');
	$stmt = $db->prepare("INSERT INTO preguntas(id_encuesta, texto, tipo_respuesta, requerido) VALUES(:id_encuesta,:texto,:tipo_respuesta,:requerido)");
	$stmt->bindValue(':id_encuesta', $d["idencuesta"], PDO::PARAM_INT);
	$stmt->bindValue(':texto', $d["texto"], PDO::PARAM_STR);
	$stmt->bindValue(':tipo_respuesta', $d["tipo_respuesta"], PDO::PARAM_INT);
	$stmt->bindValue(':requerido', $d["requerido"], PDO::PARAM_INT);
	$stmt->execute();
	$insertId = $db->lastInsertId();
	if (is_array($vars)) {
		$vars = array_map('trim',$vars);
		$value = '';		
		$i = 1;
		$stmt = $db->prepare("INSERT INTO opciones(id_opciones, id_pregunta, texto) VALUES(:id_opciones,:id_pregunta,:texto)");
		$stmt->bindParam(':id_opciones', $i, PDO::PARAM_INT);
		$stmt->bindValue(':id_pregunta', $insertId, PDO::PARAM_INT);
		$stmt->bindParam(':texto', $value, PDO::PARAM_STR);
		foreach($vars as $key => $value) {
		   $stmt->execute();
		   $i++;
		}
	}  
	header("Location: /$sitioCfg[carpeta]/preguntas/$d[idencuesta]");
	exit();
}
function eliminarOpciones($idpregunta){
	global $db;
	$stmt = $db->prepare("DELETE FROM opciones WHERE id_pregunta=:id");
	$stmt->bindValue(':id', $idpregunta, PDO::PARAM_INT);
	$stmt->execute();
}
function actualizarPregunta($d){
	global $db;
	global $sitioCfg;
  	$vars  = ($d['var_text'] ? explode(nuevaLinea(),$d['var_text']) : '');
	$stmt = $db->prepare("UPDATE preguntas SET texto=:texto, tipo_respuesta=:tipo_respuesta, requerido=:requerido WHERE id=:id");
	$stmt->bindValue(':texto', $d["texto"], PDO::PARAM_STR);
	$stmt->bindValue(':tipo_respuesta', $d["tipo_respuesta"], PDO::PARAM_INT);
	$stmt->bindValue(':requerido', $d["requerido"], PDO::PARAM_INT);
	$stmt->bindValue(':id', $d["idpregunta"], PDO::PARAM_INT);
	$stmt->execute();
    eliminarOpciones($d["idpregunta"]);
	if (is_array($vars)) {
		$vars = array_map('trim',$vars);
		$value = '';		
		$i = 1;
		$stmt = $db->prepare("INSERT INTO opciones(id_opciones, id_pregunta, texto) VALUES(:id_opciones,:id_pregunta,:texto)");
		$stmt->bindParam(':id_opciones', $i, PDO::PARAM_INT);
		$stmt->bindValue(':id_pregunta', $d["idpregunta"], PDO::PARAM_INT);
		$stmt->bindParam(':texto', $value, PDO::PARAM_STR);
		foreach($vars as $key => $value) {
		   $stmt->execute();
		   $i++;
		}
	}  
	header("Location: /$sitioCfg[carpeta]/preguntas/$d[idencuesta]");
	exit();
}
function eliminarPregunta($idencuesta,$idpregunta){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM preguntas WHERE id=:id");
	$stmt->bindValue(':id', $idpregunta, PDO::PARAM_INT);
	$stmt->execute();
	eliminarOpciones($idpregunta);
	header("Location: /$sitioCfg[carpeta]/preguntas/$idencuesta");
	exit();
}

function listarRespuestas($idpregunta,$tipo) {
	global $db;
	$string = '';
	$stmt = $db->query("SELECT * from opciones WHERE id_pregunta=$idpregunta ORDER BY id_opciones");
	foreach($stmt as $row) {
		$string .= "<label class='{clase}'>$row[texto]<input name='{nombre}' value='$row[id_opciones]' type='{tipo}'></label>";
	}
	switch($tipo)
	{
		case 1:
			$find     = array('{clase}','{nombre}','{tipo}');
			$replace  = array("radio","campo_$idpregunta","radio");
			$string   = str_replace($find,$replace,$string);
			break;
		case 2:
			$find     = array('{clase}','{nombre}','{tipo}');
			$replace  = array("radio","campo_$idpregunta","radio");
			$string   = str_replace($find,$replace,$string);
			$string   .= "
			<br>
			<label>Otra respuesta:</label><input name='campo_otro_$idpregunta' type='text'>";
			break;
		case 3:
			$find     = array('{clase}','{nombre}','{tipo}');
			$replace  = array("checkbox","campo_$idpregunta"."[]","checkbox");
			$string   = str_replace($find,$replace,$string);
			break;
		case 4:
			$find     = array('{clase}','{nombre}','{tipo}');
			$replace  = array("checkbox","campo_$idpregunta"."[]","checkbox");
			$string   = str_replace($find,$replace,$string);
			$string   .= "
			<br>
			<label>Otra respuesta:</label><input name='campo_otro_$idpregunta' type='text'>";
			break;
		case 5:
			$string   = "<input type='text' name='campo_$idpregunta'>";
			break;
		case 6:
			$string   = "<textarea cols='20' rows='4' name='campo_$idpregunta'></textarea>";
			break;
	}
	return $string;
}
function respuestasEncuesta($d){
	global $db;
	global $sitioCfg;
	foreach ($d["idpregunta"] as $i) {
		$campo = $d['campo_'.$i];
		$otro = $d['campo_otro_'.$i];
		if (isset($campo) && is_array($campo)) {
			if (isset($otro) && $otro) { 
			  $campo[] = $otro;
			}
			$idVar = '0';
			$texto = '';
			$stmt = $db->prepare("INSERT INTO respuestas(id_encuesta,id_pregunta,id_var,texto,id_usuario) VALUES(:id_encuesta,:id_pregunta,:id_var,:texto,:usuario)");
			$stmt->bindValue(':id_encuesta', $d["idencuesta"], PDO::PARAM_INT);
			$stmt->bindValue(':id_pregunta', $i, PDO::PARAM_INT);
			$stmt->bindParam(':id_var', $idVar, PDO::PARAM_INT);
			$stmt->bindParam(':texto', $texto, PDO::PARAM_STR);
			$stmt->bindValue(':usuario', $_SESSION["id"], PDO::PARAM_INT);
			foreach($campo as $value) {
				$idVar = (ctype_digit($value) ? $value : '0');
				$texto = (!ctype_digit($value) ? $value : '');
				$stmt->execute();
			}
		} 
		else {
		if (isset($otro) && $otro) {
		  unset($campo);
		  $campo  = '';
		  $campo  = $otro;
		}
			$pregunta = datosPregunta($i);
			if (in_array($pregunta["tipo_respuesta"],array(5,6))) {
				$idVar = '0';
				$texto = (!ctype_digit($campo) ? $campo : '');
			} else {
				$idVar = (ctype_digit($campo) ? $campo : '0');
				$texto = (!ctype_digit($campo) ? $campo : '');
			}
			if (isset($d['campo_'.$i])) {
				$stmt = $db->prepare("INSERT INTO respuestas(id_encuesta,id_pregunta,id_var,texto,id_usuario) VALUES(:id_encuesta,:id_pregunta,:id_var,:texto,:usuario)");
				$stmt->bindValue(':id_encuesta', $d["idencuesta"], PDO::PARAM_INT);
				$stmt->bindValue(':id_pregunta', $i, PDO::PARAM_INT);
				$stmt->bindValue(':id_var', $idVar, PDO::PARAM_INT);
				$stmt->bindValue(':texto', $texto, PDO::PARAM_STR);
				$stmt->bindValue(':usuario', $_SESSION["id"], PDO::PARAM_INT);
				$stmt->execute();
			}
		}
	}
	$stmt = $db->prepare("UPDATE encuestas SET veces_realizada = veces_realizada + 1 WHERE id=:id");
	$stmt->bindValue(':id', $d["idencuesta"], PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/encuesta-realizada/$d[idencuesta]");
	
}
function conteoOpciones($idpregunta,$idencuesta,$opcion){
	global $db;
	$stmt = $db->query("SELECT count(*) AS o_count FROM respuestas WHERE id_pregunta = $idpregunta AND id_var = $opcion AND id_encuesta = $idencuesta");
	return $stmt->fetch(PDO::FETCH_ASSOC);
}
function opciones($idpregunta,$idencuesta){
	global $db;
	$opciones="";
	$stmt = $db->query("SELECT DISTINCT o.texto,o.id_opciones from opciones o join respuestas r on (o.id_opciones=r.id_var) WHERE o.id_pregunta=$idpregunta ORDER BY id_opciones");
    foreach($stmt as $row) {
		$conteo=conteoOpciones($idpregunta,$idencuesta,$row["id_opciones"]);
		$opciones.="
				['$row[texto]', $conteo[o_count]],";
	}
	return $opciones;
}
function conteoDiagnosticos($iddiagnostico){
	global $db;
	$stmt = $db->query("SELECT count(*) AS o_count FROM historial_medico WHERE iddiagnostico = $iddiagnostico");
	return $stmt->fetch(PDO::FETCH_ASSOC);
}
function diagnosticos(){
	global $db;
	$opciones="";
	$stmt = $db->query("SELECT iddiagnostico,diagnostico from diagnosticos ORDER BY iddiagnostico");
    foreach($stmt as $row) {
		$conteo=conteoDiagnosticos($row["iddiagnostico"]);
		$opciones.="
				['$row[diagnostico]', $conteo[o_count]],";
	}
	return $opciones;
}
function perfilesQuery(){
	global $db;
	return $stmt = $db->query("SELECT * FROM perfiles");
}
function categoriasGustosQuery(){
	global $db;
	return $stmt = $db->query("SELECT * FROM gustos_categorias");
}
function categoriasDiagQuery(){
	global $db;
	return $stmt = $db->query("SELECT * FROM diagnosticos_categorias");
}
function gustosQuery($idcategoria){
	global $db;
	return $stmt = $db->query("SELECT * FROM gustos WHERE id_categoria=$idcategoria");
}
function salariosQuery($id=''){
	global $db;
	$query= "SELECT s.*, u.nombre, u.apellido from salarios s join usuarios u on s.idusuario=u.id";
	if($id!=""){
		$query.= " WHERE s.idusuario=$id";
	}
		$query.= " order by salario_desde desc";
	return $stmt = $db->query($query);
}
function reingresosQuery($id=''){
	global $db;
	$query= "SELECT r.*, u.nombre, u.apellido from reingresos r join usuarios u on r.idusuario=u.id";
	if($id!=""){
		$query.= " WHERE r.idusuario=$id";
	}
		$query.= " order by reingreso_desde desc";
	return $stmt = $db->query($query);
}
function datosUsuario($idusuario){
	global $db;
	$stmt = $db->prepare("SELECT u.*, s.salario FROM usuarios u left join salarios s on s.idusuario=u.id WHERE u.id=:id order by s.salario_desde desc");
	$stmt->bindValue(':id', $idusuario, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function copiasQuery($historial){
	global $db;
	return $stmt = $db->query("SELECT * FROM historial_copias WHERE id_historial=$historial");
}
function datosDocumento($iddocumento){
	global $db;
	$stmt = $db->prepare("SELECT * FROM documentos WHERE id_documento=:id");
	$stmt->bindValue(':id', $iddocumento, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function guardarDocumento($d,$f){
	global $db;
	global $sitioCfg;
	$nombre = $f["imagen"]["name"];
	if( isset( $f["imagen"]["tmp_name"] ) && $f["imagen"]["tmp_name"]!="" ) {
		$image = new SimpleImage();
		$image->load($f["imagen"]["tmp_name"]);
		$image->resizeToWidth(600);
		$image->save("./fotos/documentos/$nombre");
	}
	$stmt = $db->prepare("INSERT INTO documentos(titulo,documento,imagen,activo) VALUES(:titulo,:documento,:imagen,:activo)");	
	$stmt->bindValue(':titulo', $d["titulo"], PDO::PARAM_STR);	
	$stmt->bindValue(':documento', $d["documento"], PDO::PARAM_STR);
	$stmt->bindValue(':imagen', $nombre, PDO::PARAM_STR);
	$stmt->bindValue(':activo', $d["activo"], PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/documentos");
	exit();
}
function actualizarDocumento($d,$f){
	global $db;
	global $sitioCfg;
	$nombre = $f["imagen"]["name"];
	if( isset( $f["imagen"]["tmp_name"] ) && $f["imagen"]["tmp_name"]!="" ) {
		$image = new SimpleImage();
		$image->load($f["imagen"]["tmp_name"]);
		$image->resizeToWidth(600);
		$image->save("./fotos/documentos/$nombre");
	}
	$stmt = $db->prepare("UPDATE documentos SET titulo=:titulo, documento=:documento, imagen=COALESCE(NULLIF(:imagen, ''),imagen), activo=:activo WHERE id_documento=:id");	
	$stmt->bindValue(':titulo', $d["titulo"], PDO::PARAM_STR);	
	$stmt->bindValue(':documento', $d["documento"], PDO::PARAM_STR);
	$stmt->bindValue(':imagen', $nombre, PDO::PARAM_STR);
	$stmt->bindValue(':activo', $d["activo"], PDO::PARAM_INT);
	$stmt->bindValue(':id', $d["id"], PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/documentos");
	exit();
}
function eliminarDocumento($id){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM documentos WHERE id_documento=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/documentos");
	exit();
}

function datosVideo($idvideo){
	global $db;
	if($idvideo!=-1){
		$stmt = $db->prepare("SELECT * FROM videos WHERE id_video=:id");
		$stmt->bindValue(':id', $idvideo, PDO::PARAM_INT);
	}
	else{
		$stmt = $db->prepare("SELECT * FROM videos ORDER BY rand()");
	}
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function guardarVideo($d){
	global $db;
	global $sitioCfg;
	date_default_timezone_set('America/Bogota');
	$stmt = $db->prepare("INSERT INTO videos(titulo,descripcion,fecha,url,id_encuesta,activo) VALUES(:titulo,:descripcion,:fecha,:url,:encuesta,:activo)");	
	$stmt->bindValue(':titulo', $d["titulo"], PDO::PARAM_STR);	
	$stmt->bindValue(':descripcion', $d["descripcion"], PDO::PARAM_STR);
	$stmt->bindValue(':fecha', date('Y-m-d'), PDO::PARAM_STR);
	$stmt->bindValue(':url', $d["url"], PDO::PARAM_STR);
	$stmt->bindValue(':encuesta', $d["encuesta"], PDO::PARAM_INT);
	$stmt->bindValue(':activo', $d["activo"], PDO::PARAM_INT);
	$stmt->execute();
	
	$d["idvideo"] = $db->lastInsertId();
	$idcategoria=0;
	$stmt = $db->prepare("INSERT INTO tblmb_videos_categorias(idvideo,idcategoria) VALUES(:idvideo,:idcategoria)");
	$stmt->bindValue(':idvideo', $d["idvideo"], PDO::PARAM_INT);
	$stmt->bindParam(':idcategoria', $idcategoria, PDO::PARAM_INT);
	foreach($d["idscategorias"] as $k => $v) {
		$idcategoria = $v;
		$stmt->execute();
	}
	header("Location: /$sitioCfg[carpeta]/videosAdmin");
	exit();
}
function actualizarVideo($d){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("UPDATE videos SET titulo=:titulo, descripcion=:descripcion, url=:url, id_encuesta=:encuesta, activo=:activo WHERE id_video=:id");	
	$stmt->bindValue(':titulo', $d["titulo"], PDO::PARAM_STR);	
	$stmt->bindValue(':descripcion', $d["descripcion"], PDO::PARAM_STR);
	$stmt->bindValue(':url', $d["url"], PDO::PARAM_STR);
	$stmt->bindValue(':encuesta', $d["encuesta"], PDO::PARAM_INT);
	$stmt->bindValue(':activo', $d["activo"], PDO::PARAM_INT);
	$stmt->bindValue(':id', $d["id"], PDO::PARAM_INT);
	$stmt->execute();
	
	$stmt = $db->prepare("DELETE FROM tblmb_videos_categorias WHERE idvideo=:id");
	$stmt->bindValue(':id', $d["id"], PDO::PARAM_INT);
	$stmt->execute();
	
	$idcategoria=0;
	$stmt = $db->prepare("INSERT INTO tblmb_videos_categorias(idvideo,idcategoria) VALUES(:idvideo,:idcategoria)");
	$stmt->bindValue(':idvideo', $d["id"], PDO::PARAM_INT);
	$stmt->bindParam(':idcategoria', $idcategoria, PDO::PARAM_INT);
	foreach($d["idscategorias"] as $k => $v) {
		$idcategoria = $v;
		$stmt->execute();
	}
	
	header("Location: /$sitioCfg[carpeta]/videosAdmin");
	exit();
}
function eliminarVideo($id){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM videos WHERE id_video=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/videosAdmin");
	exit();
}
function videoEncuesta(){
	global $db;
		$stmt = $db->prepare("SELECT * FROM videos WHERE id_encuesta!=:id");
		$stmt->bindValue(':id', -1, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}

function datosCampana($idcampana){
	global $db;
	$stmt = $db->prepare("SELECT * FROM campanas c join usuarios u on c.correo=u.correo WHERE id_campana=:id");
	$stmt->bindValue(':id', $idcampana, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function guardarCampana($d,$f){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("INSERT INTO campanas(titulo,descripcion,estado,correo) VALUES(:titulo,:descripcion,:estado,:correo)");	
	$stmt->bindValue(':titulo', $d["titulo"], PDO::PARAM_STR);	
	$stmt->bindValue(':descripcion', $d["descripcion"], PDO::PARAM_STR);
	$stmt->bindValue(':estado', "Por Aprobar", PDO::PARAM_STR);
	$stmt->bindValue(':correo', $_SESSION["correo"], PDO::PARAM_STR);
	$stmt->execute();
	
	$id = $db->lastInsertId();

	$adjuntos = array();
	if (isset($f["adjunto"])) {
		$upload_dir = "./fotos/campanas/";
		$i = 0;
		$a = $f["adjunto"];
		for ($i = 0; $i < count($a["name"]); $i++) {
			if ( $a["name"][$i] != "" ) {
			$name = "c_{$id}_{$a["name"][$i]}";
			$adjuntos[] = $name;
				if ($a["error"][$i] == UPLOAD_ERR_OK) {
					if (!move_uploaded_file($a["tmp_name"][$i], $upload_dir . $name)) {
						die("Fallo cargando archivo al servidor");
					}
				}
			 }
		}
	}
	
	$stmt = $db->prepare("INSERT INTO adjuntos(id_campana,adjunto) VALUES(:id_campana,:adjunto)");
	$stmt->bindValue(":id_campana", $id, PDO::PARAM_INT);
	$stmt->bindParam(":adjunto", $adjunto, PDO::PARAM_STR);
	foreach($adjuntos as $value) {
		$adjunto = $value;
		$stmt->execute();
	}

	
	header("Location: /$sitioCfg[carpeta]/campanas");
	exit();
}
function responderCampana($d,$f){
	global $db;
	global $sitioCfg;
	if(!empty($d["descripcion"])){
	$stmt = $db->prepare("INSERT INTO campanas_mensajes(id_campana,descripcion,correo) VALUES(:id,:descripcion,:correo)");	
	$stmt->bindValue(':id', $d["id"], PDO::PARAM_INT);
	$stmt->bindValue(':descripcion', $d["descripcion"], PDO::PARAM_STR);
	$stmt->bindValue(':correo', $_SESSION["correo"], PDO::PARAM_STR);
	$stmt->execute();
	
	$id = $db->lastInsertId();
	}
	
	$adjuntos = array();
	if (isset($f["adjunto"])) {
		$upload_dir = "./fotos/campanas/";
		$i = 0;
		$a = $f["adjunto"];
		for ($i = 0; $i < count($a["name"]); $i++) {
			if ( $a["name"][$i] != "" ) {
			$name = "m_{$id}_{$a["name"][$i]}";
			$adjuntos[] = $name;
				if ($a["error"][$i] == UPLOAD_ERR_OK) {
					if (!move_uploaded_file($a["tmp_name"][$i], $upload_dir . $name)) {
						die("Fallo cargando archivo al servidor");
					}
				}
			 }
		}
	}

	$stmt = $db->prepare("INSERT INTO adjuntos(id_campana,id_mensaje,adjunto) VALUES(:id_campana,:id_mensaje,:adjunto)");
	$stmt->bindValue(":id_campana", $d["id"], PDO::PARAM_INT);
	$stmt->bindValue(":id_mensaje", $id, PDO::PARAM_INT);
	$stmt->bindParam(":adjunto", $adjunto, PDO::PARAM_STR);
	foreach($adjuntos as $value) {
		$adjunto = $value;
		$stmt->execute();
	}
		
	$stmt = $db->prepare("UPDATE campanas SET estado=:estado WHERE id_campana=:id");
	$stmt->bindValue(":estado", $d["estado"], PDO::PARAM_STR);
	$stmt->bindValue(":id", $d["id"], PDO::PARAM_INT);
	$stmt->execute();
	
	$stmt = $db->prepare("UPDATE adjuntos SET estado=:estado WHERE id=:id");
	$stmt->bindParam(":id", $id, PDO::PARAM_INT);
	$stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
	foreach($d["estadoA"] as $id => $estado) {
		$stmt->execute();
	}
	
	header("Location: /$sitioCfg[carpeta]/responder-campana/$d[id]");
	exit();
}
function eliminarCampana($id){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM campanas WHERE id_campana=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/campanas");
	exit();
}

function guardarUsuario($d,$f){
	global $db;
	global $sitioCfg;
	$nacimiento = "$d[anio]-$d[mes]-$d[dia]";
    $clave = generate_password();
	$password = password_hash($clave, PASSWORD_BCRYPT);
	$nombre = $f["foto"]["name"];
	if( isset( $f["foto"]["tmp_name"] ) && $f["foto"]["tmp_name"]!="" ) {
    	$ext  = pathinfo($nombre, PATHINFO_EXTENSION);
		$nombre = "$d[cedula].$ext";
		$image = new SimpleImage();
		$image->load($f["foto"]["tmp_name"]);
		$image->resizeToWidth(110);
		$image->save("./fotos/perfiles/$nombre");
	}
	$firma = $d["firma"];
	if( isset( $d["firma"] ) && $d["firma"]!="" ) {
		$data_uri = $d["firma"];
		$encoded_image = explode(",", $data_uri)[1];
		$decoded_image = base64_decode($encoded_image);
		file_put_contents("./fotos/perfiles/firma_{$d['cedula']}.png", $decoded_image);
	}
	$stmt = $db->prepare("INSERT INTO usuarios(nombre,apellido,cedula,fecha_expedicion,lugar_expedicion,correo,telefono,celular,pais,ciudad,direccion,sexo,nacimiento,cargo,departamento,contrato,salario,desde,hasta,firma,foto,password,id_perfil,idmembresia) VALUES(:nombre,:apellido,:cedula,:fecha_expedicion,:lugar_expedicion,:correo,:telefono,:celular,:pais,:ciudad,:direccion,:sexo,:nacimiento,:cargo,:departamento,:contrato,:salario,:desde,:hasta,COALESCE(NULLIF(:firma, ''),firma),:foto,:password,:id_perfil,:idmembresia)");	
	$stmt->bindValue(':nombre', $d["nombre"], PDO::PARAM_STR);
	$stmt->bindValue(':apellido', $d["apellido"], PDO::PARAM_STR);
	$stmt->bindValue(':cedula', $d["cedula"], PDO::PARAM_STR);
	$stmt->bindValue(':fecha_expedicion', $d["fecha_expedicion"], PDO::PARAM_STR);
	$stmt->bindValue(':lugar_expedicion', $d["lugar_expedicion"], PDO::PARAM_STR);
	$stmt->bindValue(':correo', $d["correo"], PDO::PARAM_STR);
	$stmt->bindValue(':telefono', $d["telefono"], PDO::PARAM_STR);
	$stmt->bindValue(':celular', $d["celular"], PDO::PARAM_STR);
	$stmt->bindValue(':pais', $d["pais"], PDO::PARAM_STR);
	$stmt->bindValue(':ciudad', $d["ciudad"], PDO::PARAM_STR);	
	$stmt->bindValue(':direccion', $d["direccion"], PDO::PARAM_STR);	
	$stmt->bindValue(':sexo', $d["sexo"], PDO::PARAM_STR);
	$stmt->bindValue(':nacimiento', $nacimiento, PDO::PARAM_STR);
	$stmt->bindValue(':cargo', $d["cargo"], PDO::PARAM_STR);
	$stmt->bindValue(':departamento', $d["departamento"], PDO::PARAM_STR);
	$stmt->bindValue(':contrato', $d["contrato"], PDO::PARAM_STR);
	$stmt->bindValue(':salario', $d["salario"], PDO::PARAM_STR);
	$stmt->bindValue(':desde', $d["desde"], PDO::PARAM_STR);
	$stmt->bindValue(':hasta', $d["hasta"], PDO::PARAM_STR);
	$stmt->bindValue(':firma', $firma, PDO::PARAM_STR);
	$stmt->bindValue(':foto', $nombre, PDO::PARAM_STR);
	$stmt->bindValue(':password', $password, PDO::PARAM_STR);
	$stmt->bindValue(':id_perfil', $d["perfil"], PDO::PARAM_INT);
	$stmt->bindValue(':idmembresia', $d["membresia"], PDO::PARAM_INT);
	$stmt->execute();
	
	$insertId = $db->lastInsertId();
	
	if (is_array($d["riesgos"])) {
		$riesgos = array_map('trim',$d["riesgos"]);
		$value = '';
		$stmt = $db->prepare("INSERT INTO riesgos_usuario(id_riesgo,id_usuario) VALUES(:id_riesgo,:id_usuario)");
		$stmt->bindParam(':id_riesgo', $value, PDO::PARAM_INT);
		$stmt->bindValue(':id_usuario', $insertId, PDO::PARAM_INT);
		foreach($riesgos as $key => $value) {
		   $stmt->execute();
		}
	} 
	
	if (is_array($d["categorias"])) {
		$categorias = array_map('trim',$d["categorias"]);
		$value = '';
		$stmt = $db->prepare("INSERT INTO riesgos_usuario(id_categoria,id_usuario) VALUES(:id_categoria,:id_usuario)");
		$stmt->bindParam(':id_categoria', $value, PDO::PARAM_INT);
		$stmt->bindValue(':id_usuario', $insertId, PDO::PARAM_INT);
		foreach($categorias as $key => $value) {
		   $stmt->execute();
		}
	}
	
	$find     = array('{correo}','{password}',);
	$replace  = array($d["correo"],$clave);
	$mensaje   = str_replace($find,$replace,$sitioCfg["mensaje"]);
	
	$retorno="\n";
	$mail = new PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->From      = $sitioCfg["correo"];
	$mail->FromName  = $sitioCfg["nombre"];
	$mail->AddAddress( $d["correo"] );
	$mail->Subject   = $sitioCfg["asunto"];
	$mail->Body      = $mensaje;
	$mail->IsHTML(true);
	$mail->Send();
	header("Location: /$sitioCfg[carpeta]/usuarios");
	exit();
}

function importarUsuarios($f){
	global $db;
	global $sitioCfg;
    $clave = generate_password();
	$password = password_hash($clave, PASSWORD_BCRYPT);
	
	if ($f["csv"]["size"] > 0) {
		
    //get the csv file
    $file = $f["csv"]["tmp_name"];
    $handle = fopen($file,"r");
	
    // read the first line
    $data = fgetcsv($handle,1000,";","'");
    // if the first line is a header, discard it and read the next
       $data = fgetcsv($handle,1000,";","'");
    
    //loop through the csv file and insert into database
		do {
			if ($data[0]) {
				/*$nacimiento = DateTime::createFromFormat('d/m/Y', $data[5])->format('Y-m-d');
				$ingreso = DateTime::createFromFormat('d/m/Y', $data[6])->format('Y-m-d');
				
				$stmt = $db->prepare("INSERT INTO usuarios(nombre,apellido,cedula,correo,sexo,nacimiento,ingreso,cargo,password,id_perfil) VALUES(:nombre,:apellido,:cedula,:correo,:sexo,:nacimiento,:ingreso,:cargo,:password,:id_perfil)");	
				$stmt->bindValue(':nombre', $data[0], PDO::PARAM_STR);
				$stmt->bindValue(':apellido', $data[1], PDO::PARAM_STR);
				$stmt->bindValue(':cedula', $data[2], PDO::PARAM_STR);
				$stmt->bindValue(':correo', $data[3], PDO::PARAM_STR);
				$stmt->bindValue(':sexo', $data[4], PDO::PARAM_STR);
				$stmt->bindValue(':nacimiento', $nacimiento, PDO::PARAM_STR);
				$stmt->bindValue(':ingreso', $ingreso, PDO::PARAM_STR);
				$stmt->bindValue(':cargo', $data[7], PDO::PARAM_STR);
				$stmt->bindValue(':password', $password, PDO::PARAM_STR);
				$stmt->bindValue(':id_perfil', 2, PDO::PARAM_INT);
				$stmt->execute();*/
				$stmt = $db->prepare("INSERT INTO usuarios(nombre,ciudad,pais,correo,password,id_perfil) VALUES(:nombre,:ciudad,:pais,:correo,:password,:id_perfil)");	
				$stmt->bindValue(':nombre', $data[0], PDO::PARAM_STR);
				$stmt->bindValue(':ciudad', $data[1], PDO::PARAM_STR);
				$stmt->bindValue(':pais', $data[2], PDO::PARAM_STR);
				$stmt->bindValue(':correo', $data[3], PDO::PARAM_STR);
				$stmt->bindValue(':password', $password, PDO::PARAM_STR);
				$stmt->bindValue(':id_perfil', 2, PDO::PARAM_INT);
				$stmt->execute();
				$find     = array('{correo}','{password}',);
				$replace  = array($data[3],$clave);
				$mensaje   = str_replace($find,$replace,$sitioCfg["mensaje"]);
				
				$retorno="\n";
				$mail = new PHPMailer();
				$mail->CharSet = "UTF-8";
				$mail->From      = $sitioCfg["correo"];
				$mail->FromName  = $sitioCfg["nombre"];
				$mail->AddAddress( $data[3] );
				$mail->Subject   = $sitioCfg["asunto"];
				$mail->Body      = $mensaje;
				$mail->IsHTML(true);
				$mail->Send();
			}
		} while ($data = fgetcsv($handle,1000,";","'"));
		//
	} 
	header("Location: /$sitioCfg[carpeta]/usuarios");
	exit();
}

function resetPassword(){
	global $db;
	global $sitioCfg;
	
	$usuarios = usuariosQuery();
		
		foreach($usuarios as $row) {
			$clave = generate_password();
			$password = password_hash($clave, PASSWORD_BCRYPT);
			
			$stmt = $db->prepare("UPDATE usuarios SET password=:password WHERE id=:id");
			$stmt->bindValue(':password', $password, PDO::PARAM_STR);
			$stmt->bindValue(':id', $row["id"], PDO::PARAM_INT);
			$stmt->execute();
			
			$find     = array('{correo}','{password}',);
			$replace  = array($row["correo"],$clave);
			$mensaje   = str_replace($find,$replace,$sitioCfg["mensaje"]);
			
			$mail = new PHPMailer();
			$mail->CharSet = "UTF-8";
			$mail->From      = $sitioCfg["correo"];
			$mail->FromName  = $sitioCfg["nombre"];
			$mail->AddAddress( $row["correo"] );
			$mail->Subject   = $sitioCfg["asunto"];
			$mail->Body      = $mensaje;
			$mail->IsHTML(true);
			$mail->Send();
			$mail->clearAddresses();
		}
	header("Location: /$sitioCfg[carpeta]/usuarios");
	exit();
}

function actualizarUsuario($d,$f){
	global $db;
	global $sitioCfg;
	$nacimiento="$d[anio]-$d[mes]-$d[dia]";
	$password = "";
	if(!empty($d["password"])){
	$password = password_hash($d["password"], PASSWORD_BCRYPT);
	}
	$nombre = $f["foto"]["name"];
	if( isset( $f["foto"]["tmp_name"] ) && $f["foto"]["tmp_name"]!="" ) {
    	$ext  = pathinfo($nombre, PATHINFO_EXTENSION);
		$nombre = "$d[cedula].$ext";
		$image = new SimpleImage();
		$image->load($f["foto"]["tmp_name"]);
		$image->resizeToWidth(110);
		$image->save("./fotos/perfiles/$nombre");
	}
	$firma = $d["firma"];
	if( isset( $d["firma"] ) && $d["firma"]!="" ) {
		$data_uri = $d["firma"];
		$encoded_image = explode(",", $data_uri)[1];
		$decoded_image = base64_decode($encoded_image);
		$firma = "firma_{$d['cedula']}.png";
		file_put_contents("./fotos/perfiles/$firma", $decoded_image);
	}
	$stmt = $db->prepare("UPDATE usuarios SET nombre=:nombre, apellido=:apellido, cedula=:cedula, fecha_expedicion=:fecha_expedicion, lugar_expedicion=:lugar_expedicion, correo=:correo, telefono=:telefono, celular=:celular, pais=:pais, ciudad=:ciudad, direccion=:direccion, sexo=:sexo, nacimiento=:nacimiento, cargo=:cargo, departamento=:departamento, contrato=:contrato, salario=:salario, desde=:desde, hasta=:hasta, firma=COALESCE(NULLIF(:firma, ''),firma), foto=COALESCE(NULLIF(:foto, ''),foto), tiempo_libre=:tiempo_libre, pereza=:pereza, regalos=:regalos, password=COALESCE(NULLIF(:password, ''),password), id_perfil=:id_perfil, idmembresia=:idmembresia, eps=:eps, pensiones=:pensiones, compensacion=:compensacion, estado_civil=:estado_civil, conyugue=:conyugue, ocupacion_conyugue=:ocupacion_conyugue, nacimiento_conyugue=:nacimiento_conyugue, ciudad_nacimiento=:ciudad_nacimiento WHERE id=:id");	
	$stmt->bindValue(':nombre', $d["nombre"], PDO::PARAM_STR);
	$stmt->bindValue(':apellido', $d["apellido"], PDO::PARAM_STR);
	$stmt->bindValue(':cedula', $d["cedula"], PDO::PARAM_STR);
	$stmt->bindValue(':fecha_expedicion', $d["fecha_expedicion"], PDO::PARAM_STR);
	$stmt->bindValue(':lugar_expedicion', $d["lugar_expedicion"], PDO::PARAM_STR);
	$stmt->bindValue(':correo', $d["correo"], PDO::PARAM_STR);
	$stmt->bindValue(':telefono', $d["telefono"], PDO::PARAM_STR);
	$stmt->bindValue(':celular', $d["celular"], PDO::PARAM_STR);
	$stmt->bindValue(':pais', $d["pais"], PDO::PARAM_STR);
	$stmt->bindValue(':ciudad', $d["ciudad"], PDO::PARAM_STR);	
	$stmt->bindValue(':direccion', $d["direccion"], PDO::PARAM_STR);	
	$stmt->bindValue(':sexo', $d["sexo"], PDO::PARAM_STR);
	$stmt->bindValue(':nacimiento', $nacimiento, PDO::PARAM_STR);
	$stmt->bindValue(':cargo', $d["cargo"], PDO::PARAM_STR);
	$stmt->bindValue(':departamento', $d["departamento"], PDO::PARAM_STR);
	$stmt->bindValue(':contrato', $d["contrato"], PDO::PARAM_STR);
	$stmt->bindValue(':salario', $d["salario"], PDO::PARAM_STR);
	$stmt->bindValue(':desde', $d["desde"], PDO::PARAM_STR);
	$stmt->bindValue(':hasta', $d["hasta"], PDO::PARAM_STR);
	$stmt->bindValue(':firma', $firma, PDO::PARAM_STR);
	$stmt->bindValue(':foto', $nombre, PDO::PARAM_STR);
	$stmt->bindValue(':tiempo_libre', $d["tiempo_libre"], PDO::PARAM_STR);
	$stmt->bindValue(':pereza', $d["pereza"], PDO::PARAM_STR);
	$stmt->bindValue(':regalos', $d["regalos"], PDO::PARAM_STR);
	$stmt->bindValue(':password', $password, PDO::PARAM_STR);
	
	$stmt->bindValue(':eps', $d["eps"], PDO::PARAM_STR);
	$stmt->bindValue(':pensiones', $d["pensiones"], PDO::PARAM_STR);
	$stmt->bindValue(':compensacion', $d["compensacion"], PDO::PARAM_STR);
	$stmt->bindValue(':estado_civil', $d["estado_civil"], PDO::PARAM_STR);
	$stmt->bindValue(':conyugue', $d["conyugue"], PDO::PARAM_STR);
	$stmt->bindValue(':ocupacion_conyugue', $d["ocupacion_conyugue"], PDO::PARAM_STR);
	$stmt->bindValue(':nacimiento_conyugue', $d["nacimiento_conyugue"], PDO::PARAM_STR);
	$stmt->bindValue(':ciudad_nacimiento', $d["ciudad_nacimiento"], PDO::PARAM_STR);
	
	$stmt->bindValue(':id_perfil', $d["perfil"], PDO::PARAM_INT);
	$stmt->bindValue(':idmembresia', $d["membresia"], PDO::PARAM_INT);
	$stmt->bindValue(':id', $d["idusuario"], PDO::PARAM_INT);
	$stmt->execute();
	
	$stmt = $db->prepare("DELETE FROM gustos_usuarios WHERE id_usuario=:id");
	$stmt->bindValue(':id', $d["idusuario"], PDO::PARAM_INT);
	$stmt->execute();
	
	if (is_array($d["gustos"])) {
		$gustos = array_map('trim',$d["gustos"]);
		$value = '';
		$stmt = $db->prepare("INSERT INTO gustos_usuarios(id_gusto,id_usuario) VALUES(:id_gusto,:id_usuario)");
		$stmt->bindParam(':id_gusto', $value, PDO::PARAM_INT);
		$stmt->bindValue(':id_usuario', $d["idusuario"], PDO::PARAM_INT);
		foreach($gustos as $key => $value) {
		   $stmt->execute();
		}
	}
	
	$stmt = $db->prepare("DELETE FROM riesgos_usuario WHERE id_usuario=:id");
	$stmt->bindValue(':id', $d["idusuario"], PDO::PARAM_INT);
	$stmt->execute();
	
	if (is_array($d["riesgos"])) {
		$riesgos = array_map('trim',$d["riesgos"]);
		$value = '';
		$stmt = $db->prepare("INSERT INTO riesgos_usuario(id_riesgo,id_usuario) VALUES(:id_riesgo,:id_usuario)");
		$stmt->bindParam(':id_riesgo', $value, PDO::PARAM_INT);
		$stmt->bindValue(':id_usuario', $d["idusuario"], PDO::PARAM_INT);
		foreach($riesgos as $key => $value) {
		   $stmt->execute();
		}
	} 
	
	if (is_array($d["categorias"])) {
		$categorias = array_map('trim',$d["categorias"]);
		$value = '';
		$stmt = $db->prepare("INSERT INTO riesgos_usuario(id_categoria,id_usuario) VALUES(:id_categoria,:id_usuario)");
		$stmt->bindParam(':id_categoria', $value, PDO::PARAM_INT);
		$stmt->bindValue(':id_usuario', $d["idusuario"], PDO::PARAM_INT);
		foreach($categorias as $key => $value) {
		   $stmt->execute();
		}
	} 
	header("Location: /$sitioCfg[carpeta]/usuarios");
	exit();
}
function eliminarUsuario($idusuario){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM usuarios WHERE id=:id");
	$stmt->bindValue(':id', $idusuario, PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/usuarios");
	exit();
}
function check($idusuario){
	global $db;
	$stmt = $db->prepare("SELECT id_gusto FROM gustos_usuarios WHERE id_usuario=:id_usuario");
	$stmt->bindValue(':id_usuario', $idusuario, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}
function checkHistorial($idusuario,$idhistorial){
	global $db;
	$stmt = $db->prepare("SELECT id_diagnostico FROM diagnosticos_historial WHERE id_usuario=:id_usuario AND id_historial=:id_historial");
	$stmt->bindValue(':id_usuario', $idusuario, PDO::PARAM_INT);
	$stmt->bindValue(':id_historial', $idhistorial, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}
function checkRiesgos($idusuario){
	global $db;
	$stmt = $db->prepare("SELECT id_riesgo FROM riesgos_usuario WHERE id_usuario=:id_usuario");
	$stmt->bindValue(':id_usuario', $idusuario, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}
function checkRiesgosC($idusuario){
	global $db;
	$stmt = $db->prepare("SELECT id_categoria FROM riesgos_usuario WHERE id_usuario=:id_usuario");
	$stmt->bindValue(':id_usuario', $idusuario, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}
function datosPerfil($id){
	global $db;
	$stmt = $db->prepare("SELECT * FROM perfiles WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function guardarPerfil($d){
	global $db;
	global $sitioCfg;
	$campana= isset($d["campana"])?1:0;
	$usuarios= isset($d["usuarios"])?1:0;
	$ver= isset($d["ver"])?1:0;
	$editar= isset($d["editar"])?1:0;
	$eliminar= isset($d["eliminar"])?1:0;
	$crear= isset($d["crear"])?1:0;
	$configuracion= isset($d["configuracion"])?1:0;
	$documentos= isset($d["documentos"])?1:0;
	$videos= isset($d["videos"])?1:0;
	$stmt = $db->prepare("INSERT INTO perfiles(perfil,campana,usuarios,editar,eliminar,crear,configuracion,documentos,videos) VALUES(:perfil,:campana,:usuarios,:editar,:eliminar,:crear,:configuracion,:documentos,:videos)");
	$stmt->bindValue(':perfil', $d["perfil"], PDO::PARAM_STR);	
	$stmt->bindValue(':campana', $campana, PDO::PARAM_INT);	
	$stmt->bindValue(':usuarios', $usuarios, PDO::PARAM_INT);
	$stmt->bindValue(':editar', $editar, PDO::PARAM_INT);	
	$stmt->bindValue(':eliminar', $eliminar, PDO::PARAM_INT);	
	$stmt->bindValue(':crear', $crear, PDO::PARAM_INT);	
	$stmt->bindValue(':configuracion', $configuracion, PDO::PARAM_INT);
	$stmt->bindValue(':documentos', $documentos, PDO::PARAM_INT);
	$stmt->bindValue(':videos', $videos, PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/perfiles");
	exit();
}
function actualizarPerfil($d){
	global $db;
	global $sitioCfg;
	$campana= isset($d["campana"])?1:0;
	$usuarios= isset($d["usuarios"])?1:0;
	$editar= isset($d["editar"])?1:0;
	$eliminar= isset($d["eliminar"])?1:0;
	$crear= isset($d["crear"])?1:0;
	$configuracion= isset($d["configuracion"])?1:0;
	$documentos= isset($d["documentos"])?1:0;
	$videos= isset($d["videos"])?1:0;
	$stmt = $db->prepare("UPDATE perfiles SET perfil=:perfil, campana=:campana, usuarios=:usuarios, editar=:editar, eliminar=:eliminar, crear=:crear, configuracion=:configuracion, documentos=:documentos, videos=:videos WHERE id=:id");
	$stmt->bindValue(':perfil', $d["perfil"], PDO::PARAM_STR);	
	$stmt->bindValue(':campana', $campana, PDO::PARAM_INT);	
	$stmt->bindValue(':usuarios', $usuarios, PDO::PARAM_INT);	
	$stmt->bindValue(':editar', $editar, PDO::PARAM_INT);	
	$stmt->bindValue(':eliminar', $eliminar, PDO::PARAM_INT);	
	$stmt->bindValue(':crear', $crear, PDO::PARAM_INT);	
	$stmt->bindValue(':configuracion', $configuracion, PDO::PARAM_INT);
	$stmt->bindValue(':documentos', $documentos, PDO::PARAM_INT);
	$stmt->bindValue(':videos', $videos, PDO::PARAM_INT);
	$stmt->bindValue(':id', $d["id"], PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/perfiles");
	exit();
}
function eliminarPerfil($id){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM perfiles WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/perfiles");
	exit();
}

function guardarMensaje($d){
	global $db;
	date_default_timezone_set('America/Bogota');
	$stmt = $db->prepare("INSERT INTO mensajes(idusuario, idusuario2, mensaje, fecha) VALUES(:idusuario,:idusuario2,:mensaje,:fecha)");	
	$stmt->bindValue(':idusuario', $d["idusuario"], PDO::PARAM_STR);	
	$stmt->bindValue(':idusuario2', $d["idusuario2"], PDO::PARAM_INT);	
	$stmt->bindValue(':mensaje', $d["mensaje"], PDO::PARAM_STR);
	$stmt->bindValue(':fecha', date('Y-m-d H:i:s'), PDO::PARAM_STR);
	$stmt->execute();
	return;
}

function guardarSalario($d){
	global $db;
	$stmt = $db->prepare("INSERT INTO salarios(idusuario, salario, salario_desde, salario_hasta) VALUES(:idusuario,:salario,:salario_desde,:salario_hasta)");	
	$stmt->bindValue(':idusuario', $d["idusuario"], PDO::PARAM_STR);
	$stmt->bindValue(':salario', $d["salario"], PDO::PARAM_STR);	
	$stmt->bindValue(':salario_desde', $d["salario_desde"], PDO::PARAM_STR);	
	$stmt->bindValue(':salario_hasta', $d["salario_hasta"], PDO::PARAM_STR);
	$stmt->execute();
	return;
}
function actualizarSalario($d){
	global $db;
	$stmt = $db->prepare("UPDATE salarios SET  idusuario=:idusuario, salario=:salario, salario_desde=:salario_desde, salario_hasta=:salario_hasta WHERE idsalario=:id");	
	$stmt->bindValue(':idusuario', $d["idusuario"], PDO::PARAM_STR);
	$stmt->bindValue(':salario', $d["salario"], PDO::PARAM_STR);	
	$stmt->bindValue(':salario_desde', $d["salario_desde"], PDO::PARAM_STR);	
	$stmt->bindValue(':salario_hasta', $d["salario_hasta"], PDO::PARAM_STR);
	$stmt->bindValue(':id', $d["idsalario"], PDO::PARAM_INT);
	$stmt->execute();
	return;
}

function guardarReingreso($d){
	global $db;
	$stmt = $db->prepare("INSERT INTO reingresos(idusuario, detalle, reingreso_desde, reingreso_hasta) VALUES(:idusuario,:detalle,:reingreso_desde,:reingreso_hasta)");	
	$stmt->bindValue(':idusuario', $d["idusuario"], PDO::PARAM_STR);
	$stmt->bindValue(':detalle', $d["detalle"], PDO::PARAM_STR);	
	$stmt->bindValue(':reingreso_desde', $d["reingreso_desde"], PDO::PARAM_STR);	
	$stmt->bindValue(':reingreso_hasta', $d["reingreso_hasta"], PDO::PARAM_STR);
	$stmt->execute();
	return;
}
function actualizarReingreso($d){
	global $db;
	$stmt = $db->prepare("UPDATE reingresos SET  idusuario=:idusuario, detalle=:detalle, reingreso_desde=:reingreso_desde, reingreso_hasta=:reingreso_hasta WHERE idreingreso=:id");	
	$stmt->bindValue(':idusuario', $d["idusuario"], PDO::PARAM_STR);
	$stmt->bindValue(':detalle', $d["detalle"], PDO::PARAM_STR);	
	$stmt->bindValue(':reingreso_desde', $d["reingreso_desde"], PDO::PARAM_STR);	
	$stmt->bindValue(':reingreso_hasta', $d["reingreso_hasta"], PDO::PARAM_STR);
	$stmt->bindValue(':id', $d["idreingreso"], PDO::PARAM_INT);
	$stmt->execute();
	return;
}

function guardarPizarra($d){
	global $db;
	date_default_timezone_set('America/Bogota');
	$stmt = $db->prepare("INSERT INTO mensajes_generales(idusuario, mensaje, fecha) VALUES(:idusuario,:mensaje,:fecha)");	
	$stmt->bindValue(':idusuario', $d["idusuario"], PDO::PARAM_INT);
	$stmt->bindValue(':mensaje', $d["mensaje"], PDO::PARAM_STR);
	$stmt->bindValue(':fecha', date('Y-m-d H:i:s'), PDO::PARAM_STR);
	$stmt->execute();
	return;
}

function guardarCategoria($d){
	global $db;
	$stmt = $db->prepare("INSERT INTO acciones_categorias(categoria) VALUES(:categoria)");
	$stmt->bindValue(':categoria', $d["categoria"], PDO::PARAM_STR);
	$stmt->execute();
	return;
}
function actualizarCategoria($d){
	global $db;
	$stmt = $db->prepare("UPDATE acciones_categorias SET  categoria=:categoria WHERE id=:id");
	$stmt->bindValue(':categoria', $d["categoria"], PDO::PARAM_STR);
	$stmt->bindValue(':id', $d["id"], PDO::PARAM_INT);
	$stmt->execute();
	return;
}
function guardarDiagnosticos($d){
	global $db;
	$stmt = $db->prepare("INSERT INTO diagnosticos(idcategoria, diagnostico) VALUES(:idcategoria,:diagnostico)");
	$stmt->bindValue(':idcategoria', $d["idcategoria"], PDO::PARAM_INT);
	$stmt->bindValue(':diagnostico', $d["diagnostico"], PDO::PARAM_STR);
	$stmt->execute();
	return;
}
function actualizarDiagnosticos($d){
	global $db;
	$stmt = $db->prepare("UPDATE diagnosticos SET idcategoria=:idcategoria, diagnostico=:diagnostico WHERE iddiagnostico=:id");
	$stmt->bindValue(':idcategoria', $d["idcategoria"], PDO::PARAM_INT);
	$stmt->bindValue(':diagnostico', $d["diagnostico"], PDO::PARAM_STR);
	$stmt->bindValue(':id', $d["iddiagnostico"], PDO::PARAM_INT);
	$stmt->execute();
	return;
}
function datosDiagnosticos($id){
	global $db;
	$stmt = $db->prepare("SELECT * FROM diagnosticos WHERE iddiagnostico=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function datosSalarios($id){
	global $db;
	$stmt = $db->prepare("SELECT * FROM salarios WHERE idsalario=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function datosReingresos($id){
	global $db;
	$stmt = $db->prepare("SELECT * FROM reingresos WHERE idreingreso=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function datosCategorias($id){
	global $db;
	$stmt = $db->prepare("SELECT * FROM acciones_categorias WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function guardarHistorial($d,$f){
	global $db;
	date_default_timezone_set('America/Bogota');
	$archivo = "";
	if(isset($d["alerta"])){
		$errors     = array();
		$acceptable = array(
			'application/pdf',
			'application/msword',
			'application/rtf',
			'application/vnd.ms-excel',
			'application/vnd.ms-powerpoint',
			'image/jpeg',
			'image/jpg',
			'image/gif',
			'image/png'
		);
		$alerta= 1;
		$enviado= isset($d["enviado"])?1:0;
	  
		if( isset( $f["archivo"]["tmp_name"] ) && $f["archivo"]["tmp_name"]!="" ) {
		
			if(!in_array($f["archivo"]["type"], $acceptable) && (!empty($f["archivo"]["type"]))) {
				$errors[] = 'Tipo de archivo inválido';
			}
		
			if(count($errors) === 0) {
				$archivo = $f["archivo"]["name"];
				/*$name  = pathinfo($archivo, PATHINFO_FILENAME);
				$name = slug($name);
				$ext  = pathinfo($archivo, PATHINFO_EXTENSION);
				$archivo = $name.$ext;*/
				move_uploaded_file($f["archivo"]['tmp_name'], "./fotos/historial/$archivo");
			} else {
				foreach($errors as $error) {
					echo '<script>alert("'.$error.'");</script>';
				}
			}
		}
		$stmt = $db->prepare("INSERT INTO historial_medico(idusuario,descripcion,recomendaciones,fecha,alerta,examen,archivo,fecha_limite,recordatorio,horas,enviado) VALUES(:idusuario,:descripcion,:recomendaciones,:fecha,:alerta,:examen,:archivo,:fecha_limite,:recordatorio,:horas,:enviado)");
		$stmt->bindValue(':idusuario', $d["idusuario"], PDO::PARAM_INT);
		$stmt->bindValue(':descripcion', $d["descripcion"], PDO::PARAM_STR);
		$stmt->bindValue(':recomendaciones', $d["recomendaciones"], PDO::PARAM_STR);
		$stmt->bindValue(':fecha', date('Y-m-d H:i:s'), PDO::PARAM_STR);
		$stmt->bindValue(':alerta', $alerta, PDO::PARAM_INT);
		$stmt->bindValue(':examen', $d["examen"], PDO::PARAM_STR);
		$stmt->bindValue(':archivo', $archivo, PDO::PARAM_STR);
		$stmt->bindValue(':fecha_limite', $d["fecha_limite"], PDO::PARAM_STR);
		$stmt->bindValue(':recordatorio', $d["recordatorio"], PDO::PARAM_STR);
		$stmt->bindValue(':horas', $d["horas"], PDO::PARAM_INT);
		$stmt->bindValue(':enviado', $enviado, PDO::PARAM_INT);
		$stmt->execute();
	}
	else{
		$stmt = $db->prepare("INSERT INTO historial_medico(idusuario, descripcion, recomendaciones, fecha) VALUES(:idusuario,:descripcion,:recomendaciones,:fecha)");
		$stmt->bindValue(':idusuario', $d["idusuario"], PDO::PARAM_INT);
		$stmt->bindValue(':descripcion', $d["descripcion"], PDO::PARAM_STR);
		$stmt->bindValue(':recomendaciones', $d["recomendaciones"], PDO::PARAM_STR);
		$stmt->bindValue(':fecha', date('Y-m-d H:i:s'), PDO::PARAM_STR);
		$stmt->execute();
	}
	$insertId = $db->lastInsertId();
	if (is_array($d["diagnosticos"])) {
		$diagnosticos = array_map('trim',$d["diagnosticos"]);
		$value = '';
		$stmt = $db->prepare("INSERT INTO diagnosticos_historial(id_diagnostico,id_usuario,id_historial) VALUES(:id_diagnostico,:id_usuario,:id_historial)");
		$stmt->bindParam(':id_diagnostico', $value, PDO::PARAM_INT);
		$stmt->bindValue(':id_usuario', $d["idusuario"], PDO::PARAM_INT);
		$stmt->bindValue(':id_historial', $insertId, PDO::PARAM_INT);
		foreach($diagnosticos as $key => $value) {
		   $stmt->execute();
		}
	}
	if (is_array($d["copia"])) {
		$copias = array_map('trim',$d["copia"]);
		$value = '';
		$stmt = $db->prepare("INSERT INTO historial_copias(id_historial,correo) VALUES(:id_historial,:correo)");
		$stmt->bindValue(':id_historial', $insertId, PDO::PARAM_INT);
		$stmt->bindParam(':correo', $value, PDO::PARAM_STR);
		foreach($copias as $key => $value) {
		   $stmt->execute();
		}
	}
	return;
}
function datosHistorial($id){
	global $db;
	$stmt = $db->prepare("SELECT * FROM historial_medico WHERE idhistorial=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);	
}
function actualizarHistorial($d,$f){
	global $db;
	$archivo = "";
	$alerta= isset($d["alerta"])?1:0;
	if(isset($d["alerta"])){
		$errors     = array();
		$acceptable = array(
			'application/pdf',
			'application/msword',
			'application/rtf',
			'application/vnd.ms-excel',
			'application/vnd.ms-powerpoint',
			'image/jpeg',
			'image/jpg',
			'image/gif',
			'image/png'
		);
		$enviado= isset($d["enviado"])?1:0;
	  
		if( isset( $f["archivo"]["tmp_name"] ) && $f["archivo"]["tmp_name"]!="" ) {
		
			if(!in_array($f["archivo"]["type"], $acceptable) && (!empty($f["archivo"]["type"]))) {
				$errors[] = 'Tipo de archivo inválido';
			}
		
			if(count($errors) === 0) {
				$archivo = $f["archivo"]["name"];
				/*$name  = pathinfo($archivo, PATHINFO_FILENAME);
				$name = slug($name);
				$ext  = pathinfo($archivo, PATHINFO_EXTENSION);
				$archivo = $name.$ext;*/
				move_uploaded_file($f["archivo"]['tmp_name'], "./fotos/historial/$archivo");
			} else {
				foreach($errors as $error) {
					echo '<script>alert("'.$error.'");</script>';
				}
			}
		}
		$stmt = $db->prepare("UPDATE historial_medico SET idusuario=:idusuario,descripcion=:descripcion,recomendaciones=:recomendaciones,alerta=:alerta,examen=:examen,archivo=:archivo,fecha_limite=:fecha_limite,recordatorio=:recordatorio,horas=:horas,enviado=:enviado WHERE idhistorial=:id");
		$stmt->bindValue(':idusuario', $d["idusuario"], PDO::PARAM_INT);
		$stmt->bindValue(':descripcion', $d["descripcion"], PDO::PARAM_STR);
		$stmt->bindValue(':recomendaciones', $d["recomendaciones"], PDO::PARAM_STR);
		$stmt->bindValue(':alerta', $alerta, PDO::PARAM_INT);
		$stmt->bindValue(':examen', $d["examen"], PDO::PARAM_STR);
		$stmt->bindValue(':archivo', $archivo, PDO::PARAM_STR);
		$stmt->bindValue(':fecha_limite', $d["fecha_limite"], PDO::PARAM_STR);
		$stmt->bindValue(':recordatorio', $d["recordatorio"], PDO::PARAM_STR);
		$stmt->bindValue(':horas', $d["horas"], PDO::PARAM_INT);
		$stmt->bindValue(':enviado', $enviado, PDO::PARAM_INT);
		$stmt->bindValue(':id', $d["idhistorial"], PDO::PARAM_INT);
		$stmt->execute();
	}
	else{
		$stmt = $db->prepare("UPDATE historial_medico SET idusuario=:idusuario,descripcion=:descripcion,recomendaciones=:recomendaciones,alerta=:alerta WHERE idhistorial=:id");
		$stmt->bindValue(':idusuario', $d["idusuario"], PDO::PARAM_INT);
		$stmt->bindValue(':descripcion', $d["descripcion"], PDO::PARAM_STR);
		$stmt->bindValue(':recomendaciones', $d["recomendaciones"], PDO::PARAM_STR);
		$stmt->bindValue(':alerta', $alerta, PDO::PARAM_INT);
		$stmt->bindValue(':id', $d["idhistorial"], PDO::PARAM_INT);
		$stmt->execute();
	}
	
	$stmt = $db->prepare("DELETE FROM diagnosticos_historial WHERE id_usuario=:id AND id_historial=:id_historial");
	$stmt->bindValue(':id', $d["idusuario"], PDO::PARAM_INT);
	$stmt->bindValue(':id_historial', $d["idhistorial"], PDO::PARAM_INT);
	$stmt->execute();
	
	if (is_array($d["diagnosticos"])) {
		$diagnosticos = array_map('trim',$d["diagnosticos"]);
		$value = '';
		$stmt = $db->prepare("INSERT INTO diagnosticos_historial(id_diagnostico,id_usuario,id_historial) VALUES(:id_diagnostico,:id_usuario,:id_historial)");
		$stmt->bindParam(':id_diagnostico', $value, PDO::PARAM_INT);
		$stmt->bindValue(':id_usuario', $d["idusuario"], PDO::PARAM_INT);
		$stmt->bindValue(':id_historial', $d["idhistorial"], PDO::PARAM_INT);
		foreach($diagnosticos as $key => $value) {
		   $stmt->execute();
		}
	} 
	
	$stmt = $db->prepare("DELETE FROM historial_copias WHERE id_historial=:id");
	$stmt->bindValue(':id', $d["idhistorial"], PDO::PARAM_INT);
	$stmt->execute();
	
	if (is_array($d["copia"])) {
		$copias = array_map('trim',$d["copia"]);
		$value = '';
		$stmt = $db->prepare("INSERT INTO historial_copias(id_historial,correo) VALUES(:id_historial,:correo)");
		$stmt->bindValue(':id_historial', $d["idhistorial"], PDO::PARAM_INT);
		$stmt->bindParam(':correo', $value, PDO::PARAM_STR);
		foreach($copias as $key => $value) {
		   $stmt->execute();
		}
	}
	return;
}
function eliminarDiagnostico($id){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM diagnosticos WHERE iddiagnostico=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/diagnosticos");
	exit();
}
function eliminarHistorial($id){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM historial_medico WHERE idhistorial=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	header("Location: /$sitioCfg[carpeta]/historial-medico");
	exit();
}
function eliminarCategoria($id){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM acciones_categorias WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
}

function confirmarCorreo($correo){
	global $db;
	$stmt = $db->prepare("SELECT 1 FROM usuarios WHERE correo=:correo");
	$stmt->bindValue(':correo', $correo, PDO::PARAM_STR);
	$stmt->execute();
	$row=$stmt->fetch();
	if ($row) {
		echo 'duplicado';
	}	
}
function confirmarCedula($cedula){
	global $db;
	$stmt = $db->prepare("SELECT 1 FROM usuarios WHERE cedula=:cedula");
	$stmt->bindValue(':cedula', $cedula, PDO::PARAM_STR);
	$stmt->execute();
	$row=$stmt->fetch();
	if ($row) {
		echo 'duplicado';
	}	
}
function confirmarEncuesta(){
	global $db;
	$stmt = $db->prepare("SELECT 1 FROM respuestas WHERE id_usuario=:usuario");
	$stmt->bindValue(':usuario', $_SESSION["id"], PDO::PARAM_INT);
	$stmt->execute();
	$row=$stmt->fetch();
	if ($row) {
		return true;
	}
	return false;
}
function login($correo, $password) {
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("SELECT * FROM usuarios WHERE correo=:correo");
	$stmt->bindValue(':correo', $correo, PDO::PARAM_STR);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if (!$row) {
		return 'correo';
	}
	if (password_verify($password, $row["password"])) {
    if(!session_id()) session_start();
        $_SESSION["usuario"] = "si";
        $_SESSION["id"] = $row["id"];
        $_SESSION["nombre"] = $row["nombre"];
        $_SESSION["apellido"] = $row["apellido"];
        $_SESSION["perfil"] = $row["id_perfil"];
        $_SESSION["idmembresia"] = $row["idmembresia"];
        $_SESSION["foto"] = $row["foto"];
        $_SESSION["correo"] = $row["correo"];
        $_SESSION["sexo"] = $row["sexo"];
		if(!empty($_SESSION['loc'])){
			$url = $_SESSION['loc'];
		}
		else{
			$url = "/$sitioCfg[carpeta]/inicio";
		}
        header("Location: $url");
        exit;
    } else {
		return 'password';
    }
}
function configuracion($d,$f){
	global $db;
	$nombre = $f["logo"]["name"];
	if( isset( $f["logo"]["tmp_name"] ) && $f["logo"]["tmp_name"]!="" ) {
		$image = new SimpleImage();
		$image->load($f["logo"]["tmp_name"]);
		$image->resizeToWidth(200);
		$image->save("./fotos/$nombre");
	}
	$stmt = $db->prepare("UPDATE generales SET titulo=:titulo, nombre=:nombre, asunto=:asunto, correo=:correo, logo=COALESCE(NULLIF(:logo, ''),logo), mensaje=:mensaje WHERE id=:id");	
	$stmt->bindValue(':titulo', $d["titulo"], PDO::PARAM_STR);	
	$stmt->bindValue(':nombre', $d["nombre"], PDO::PARAM_STR);	
	$stmt->bindValue(':asunto', $d["asunto"], PDO::PARAM_STR);	
	$stmt->bindValue(':correo', $d["correo"], PDO::PARAM_STR);
	$stmt->bindValue(':logo', $nombre, PDO::PARAM_STR);
	$stmt->bindValue(':mensaje', $d["mensaje"], PDO::PARAM_STR);
	$stmt->bindValue(':id', 1, PDO::PARAM_INT);
	$stmt->execute();
	return true;
}
function get_header(){
	global $sitioCfg;
	$fecha = date("d/m/Y");
	if($_SESSION["foto"]!=""){ 
		$foto = "http://$_SERVER[HTTP_HOST]/$sitioCfg[carpeta]/fotos/perfiles/$_SESSION[foto]";
	} else { 
		$foto = "http://$_SERVER[HTTP_HOST]/$sitioCfg[carpeta]/fotos/perfiles/$_SESSION[sexo].png";
	} 
	echo "
	<header>
    	<h1 class='logo'><img src='/$sitioCfg[carpeta]/fotos/$sitioCfg[logo]' alt='$sitioCfg[nombre]'/></h1>
        <div class='perfil'>
        	<div class='datos'>
                <a href='/$sitioCfg[carpeta]/editar-usuario' class='imagenPerfil'><img src='$foto' alt='$_SESSION[nombre] $_SESSION[apellido]'/></a>
            </div>
            <div class='empresa'>
                Nombre: $_SESSION[nombre] $_SESSION[apellido]<br>
                Empresa: $sitioCfg[nombre]<br>
				Fecha: $fecha<br>
				<a href='/$sitioCfg[carpeta]/cerrar-sesion'>Cerrar Sesión</a>
            </div>
        </div>
    </header>";
}
function get_footer(){
	global $sitioCfg;
	include_once("templates/footer.php");
}
function menu(){
	global $sitioCfg;
	//$perfil = datosPerfil($_SESSION["perfil"]);
	?>
	<link rel="stylesheet" type="text/css" href="include/menu/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="include/menu/css/menu.css">
	
	<script type="text/javascript" src="include/menu/js/function.js"></script>
	
	<nav id="navigation">
		<ul id="main-menu">
			<li class="current-menu-item"><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/contenedor.php">Inicio</a></li>
			<li class="parent">
				<a href="#">Sitio</a>
				<ul class="sub-menu">
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/sitio/sitio_listar.php"><i class="icon-wrench"></i> Información General Sitio</a></li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/ciudades/ciudades_listar.php"><i class="icon-credit-card"></i>  Opciones Generales</a></li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/usuarios/usuarios_listar.php"><i class="icon-gift"></i> Administrar Usuarios</a></li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/logsistema/log_buscar.php"><i class="icon-gift"></i> Ver Log Sistema</a></li>
				</ul>
			</li>
			<li class="parent">
				<a href="#">Módulos</a>
				<ul class="sub-menu">
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Archivos de descarga</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/archivos/archivos_categorias_listar.php">Categorías</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/archivos/archivos_listar.php">Archivos</a></li>
						</ul>
					</li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Mapa</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/mapa/mapas_listar.php">Imagen</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/mapa/lugares_listar.php">Lugares</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/cabezotes/cabezotes_listar.php"><i class="icon-wrench"></i> Cabezote Animado</a></li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Cabezotes JQuery</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/cabezotesjq/categorias_listar.php">Categorías</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/cabezotesjq/cabezotes_listar.php">Cabezotes</a></li>
						</ul>
					</li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Cinta Transportadora</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/cinta_transportadora/categorias_listar.php">Categorías</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/cinta_transportadora/cabezotes_listar.php">Imágenes</a></li>
						</ul>
					</li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Pantalla Led</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/pantalla_led/categorias_listar.php">Categorías</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/pantalla_led/frases_listar.php">Frases</a></li>
						</ul>
					</li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Fondos</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/fondos/categorias_listar.php">Categorías</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/fondos/fondos_listar.php">Imágenes</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/contenidos/contenidos_listar.php"><i class="icon-wrench"></i> Contenidos</a></li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/noticias/noticias_listar.php"><i class="icon-wrench"></i> Noticias/Notas</a></li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/editorial/editorial_listar.php"><i class="icon-wrench"></i> Editoriales/Artículos</a></li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Eventos</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/eventos/eventos_categorias_listar.php">Categorías</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/eventos/eventos_listar.php">Eventos</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/encuestas/encuestas_listar.php"><i class="icon-wrench"></i> Encuestas y Estadísticas</a></li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Zona usuarios</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/usuariosExternos/usuarios_listar.php">Usuarios</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/usuariosExternosArchivos/usuarios_listar.php">Archivos usuarios</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/faqs/faqs_listar.php"><i class="icon-wrench"></i> Faqs</a></li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Galería Fotos</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/imagenes/imagenes_categorias_listar.php">Categorías</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/imagenes/imagenes_listar.php">Imágenes</a></li>
						</ul>
					</li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Tarjetas de cumpleaños</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tarjetas/tarjetas_listar.php">Tarjetas</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/frases/frases_listar.php">Frases</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tarjetas/enviar.php">Enviar</a></li>
						</ul>
					</li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Tips/Trucos/Consejo</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/dmin/modulos/servicios/servicios_categorias_listar.php">Categorías</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/servicios/servicios_listar.php">Tips</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li class="parent">
				<a href="#">Especiales</a>
				<ul class="sub-menu">
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Tickets</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tickets/empresas_listar.php">Empresas</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tickets/regiones_listar.php">Regiones</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tickets/zonas_listar.php">Zonas</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tickets/empresas_listar.php">Sedes</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tickets/usuarios_listar.php">Usuarios</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tickets/tickets_empresas.php">Tickets</a></li>
						</ul>
					</li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Membresías</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/membresias/membresías_listar.php">Membresías</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/membresias/categorias_listar.php">Categorias</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/membresias/contenidos_listar.php">Documentos</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/membresias/arhivos_listar.php">Archivos</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/membresias/usuarios_listar.php">Usuarios</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/videosyoutube/listar_categorias.php"><i class="icon-wrench"></i> Videos Youtube</a></li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Música/MP3</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/musica/categorias_listar.php">Categorías</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/musica/listar.php">Archivos</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/radioblog/listar.php"><i class="icon-wrench"></i> RadioBlog</a></li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/mensajes/listar.php"><i class="icon-wrench"></i> Pizarra Virtual</a></li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Boletines Electrónicos</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/generador_boletines/boletines_listar.php">Boletines</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/boletines/registrar_correo.php">Correos Electrónicos</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/boletines/registrar_lista.php">Listas de Correos</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/registrodatos/registros_listar.php"><i class="icon-wrench"></i> Registro de Personas</a></li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Preguntas al Especialista</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/especialistas/listar_profesiones.php">Profesiones</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/especialistas/listar_especialistas.php">Especialistas</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/especialistasPreguntas/listar.php">Preguntas</a></li>
						</ul>
					</li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Tienda</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tienda/listar_categorias.php">Categorías</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tienda/marcas_listar.php">Marcas</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tienda/colores_listar.php">Colores</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tienda/tecnologias_listar.php">Tecnologías</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tienda/cupones_cat_listar.php">Cupones</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tienda/listar_pedidos.php">Pedidos</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tienda/configurar.php">Configurar</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/css/css_listar.php"><i class="icon-wrench"></i> Modificar CSS</a></li>
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Documentos Especiales</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/documentos/plantillas_listar.php">Plantillas</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/documentos/contenidos_listar.php">Contenidos</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/documentos/enviar.php">Enviar</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/documentos/registros_listar.php">Ver Registro</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tags/tags_listar.php"><i class="icon-wrench"></i> Tags/Palabras Claves</a></li>
				</ul>
			</li>
			<li class="parent">
				<a href="#">Tareas</a>
				<ul class="sub-menu">
					<li>
						<a class="parent" href="#"><i class="icon-file-alt"></i> Acciones</a>
						<ul class="sub-menu">
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tareas/acciones-categorias.php">Categorías</a></li>
							<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tareas/acciones.php">Acciones</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $sitioCfg["carpeta"]; ?>/admin/modulos/tareas/tareas.php"><i class="icon-wrench"></i> Tareas</a></li>
				</ul>
			</li>
		</ul>
	</nav>
	<?php
}
function reasignarClave($correo) {
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("SELECT * FROM usuarios WHERE correo=:correo");
	$stmt->bindValue(':correo', $correo, PDO::PARAM_STR);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);	

	if (!$row) {
		return 'correo';
	}
	$clave = substr(base64_encode(crypt('', '')), 0, 16);
		
	$stmt = $db->prepare("UPDATE usuarios SET reset_code=:reset_code WHERE correo=:correo");	
	$stmt->bindValue(':reset_code', $clave, PDO::PARAM_STR);
	$stmt->bindValue(':correo', $correo, PDO::PARAM_STR);
	$stmt->execute();
	$host = "www.miendomarketing.com/".$sitioCfg["carpeta"];
	$asunto = "Recuperar contraseña";
		
	$html = "<html><head><title>Clave Zona Endomarketing Transloyola</title></head>
	<body>Hola, $row[nombre] $row[apellido]:<br><br>
	Recientemente pediste recuperar tu contrase&ntilde;a de $host. Para completar el proceso, sigue este enlace:<br><br>
	<a href='http://$host/password?n=$clave&id={$row["id"]}'>http://$host/password?n=$clave&id={$row["id"]}</a><br><br>
	Si no has pedido una contrase&ntilde;a nueva, sigue este enlace y para cancelar la solicitud:<br><br>
	<a href='http://$host/cancelReset?n=$clave&id={$row["id"]}'>http://$host/cancelReset?n=$clave&id={$row["id"]}</a><br><br>
	Gracias,<br>
	$host</body></html>";
	
	$mail = new PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->From      = $sitioCfg["correo"];
	$mail->FromName  = $sitioCfg["nombre"];
	$mail->AddAddress( $correo );
	$mail->Subject   = $asunto;
	$mail->Body      = $html;
	$mail->IsHTML(true);
	$mail->Send();
	if (!$mail) {
		die("Error enviando mensaje");
	}
	return;
}

function cambiarClave($cClaveNueva, $clave, $id) {
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("SELECT * FROM usuarios WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if ( $clave == $row["reset_code"]) {
		$password = password_hash($cClaveNueva, PASSWORD_BCRYPT);

		$stmt = $db->prepare("UPDATE usuarios SET password=:password, reset_code=:reset_code WHERE id=:id");	
		$stmt->bindValue(':password', $password, PDO::PARAM_STR);	
		$stmt->bindValue(':reset_code', '', PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
		header("Location: /$sitioCfg[carpeta]/");
		exit;
	} else {
		die("Este link ya no es v&aacute;lido");
	}
	exit;
}

function cancelar($clave, $id) {
	global $db;
	$stmt = $db->prepare("UPDATE usuarios SET reset_code=:reset_code WHERE id=:id");	
	$stmt->bindValue(':reset_code', '', PDO::PARAM_STR);
	$stmt->bindValue(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
	return;
}

function videosYoutubePreview($raVideo){
    $url = explode("watch?v=",$raVideo);
    $url = explode("&",$url[1]);
    $url = $url[0];
    return "http://img.youtube.com/vi/{$url}/mqdefault.jpg";
}

function enviarCampana($d){
	global $db;
	global $sitioCfg;
	$usuarios = usuariosQuery();
	$backup = "
				<tr>
					<td>
						<img src='http://www.miendomarketing.com/$sitioCfg[carpeta]/fotos/transloyola.png' align='left' width='200' height='119' alt='Widetech' style='margin-bottom:20px;'>
					</td>
				</tr>";	
	$mensaje = "
		<div>
		<table cellspacing='0' cellpadding='0' border='0' style='padding:2% 5%;color:#000;font-weight:bold;font-size:1.5em;font-family:Myriad Pro;'>
			<tbody>
				<tr>
					<td>
						<img src='http://www.miendomarketing.com/$sitioCfg[carpeta]/campanas/{$d["adjunto"]}' align='center' alt='{$d["adjunto"]}' style='margin-bottom:20px;'>
					</td>
				</tr>
				<tr>
					<td>{$d["mensaje"]}</td>
				</tr>
			</tbody>
		</table>
	    </div>";

		$mail = new PHPMailer();
		$mail->CharSet = "UTF-8";
		$mail->From      = $sitioCfg["correo"];
		$mail->FromName  = $sitioCfg["nombre"];
		$mail->Subject   = $d["asunto"];
		$mail->Body      = $mensaje;
		$mail->IsHTML(true);
		
		foreach($usuarios as $row) {
			$mail->AddAddress( $row["correo"] );
			$mail->Send();
			$mail->clearAddresses();
		}
		
	return;
}

function datosAccion($id){
	global $db;
	$stmt = $db->prepare("SELECT * FROM acciones WHERE id=?");
	$stmt->execute(array($id));
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function accionesQuery($id=''){
	global $db;
	$query= "SELECT * from acciones";
	if($id!=""){
		$query.= " WHERE a.idcategoria=$id";
	}
	return $stmt = $db->query($query);
}

function guardarAccion($d){
	global $db;
	$stmt = $db->prepare("INSERT INTO acciones(accion) VALUES(:accion)");
	$stmt->bindValue(':accion', $d["accion"], PDO::PARAM_STR);
	$stmt->execute();
	
	$insertId = $db->lastInsertId();
	
		$value = '';
		$stmt = $db->prepare("INSERT INTO categorias_acciones(idcategoria,idaccion) VALUES(:idcategoria,:idaccion)");
		$stmt->bindParam(':idcategoria', $value, PDO::PARAM_INT);
		$stmt->bindValue(':idaccion', $insertId, PDO::PARAM_INT);
		foreach($d["categorias"] as $key => $value) {
		   $stmt->execute();
		}
	return;
}

function accionesCategoriasQuery($id){
	global $db;
	$stmt = $db->query("SELECT idcategoria from categorias_acciones WHERE idaccion=$id");
	return $stmt;
}

function actualizarAccion($d){
	global $db;
	$stmt = $db->prepare("UPDATE acciones SET accion=:accion WHERE id=:id");	
	$stmt->bindValue(':accion', $d["accion"], PDO::PARAM_STR);
	$stmt->bindValue(':id', $d["id"], PDO::PARAM_INT);
	$stmt->execute();
	
	$stmt = $db->prepare("DELETE FROM categorias_acciones WHERE idaccion=:id");
	$stmt->bindValue(':id', $d["id"], PDO::PARAM_INT);
	$stmt->execute();
	
	$value = '';
	$stmt = $db->prepare("INSERT INTO categorias_acciones(idcategoria,idaccion) VALUES(:idcategoria,:idaccion)");
	$stmt->bindParam(':idcategoria', $value, PDO::PARAM_INT);
	$stmt->bindValue(':idaccion', $d["id"], PDO::PARAM_INT);
	foreach($d["categorias"] as $key => $value) {
	   $stmt->execute();
	}
	return;
}

function eliminarAccion($id){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM acciones WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	return;
}

function tareasQuery(){
	global $db;
	$query= "SELECT t.*, u.nombres, e.nombre from tareas t join tblusuarios u on t.idusuario=u.idusuario join tbltk_empresas e on t.idempresa=e.idempresa";
	return $stmt = $db->query($query);
}

function guardarTarea($d){
	global $db;
	global $sitioCfg;
	
	$stmt = $db->prepare("INSERT INTO tareas(tarea, prioridad, idempresa, idusuario, creacion, inicio, entrega, anotaciones, estado) VALUES(:tarea, :prioridad, :idempresa, :idusuario, NOW(), :inicio, :entrega, :anotaciones,'En Proceso')");	
	$stmt->bindValue(':tarea', $d["tarea"], PDO::PARAM_STR);
	$stmt->bindValue(':prioridad', $d["prioridad"], PDO::PARAM_STR);
	$stmt->bindValue(':idempresa', $d["idempresa"], PDO::PARAM_INT);
	$stmt->bindValue(':idusuario', $d["idusuario"], PDO::PARAM_INT);
	$stmt->bindValue(':inicio', $d["inicio"], PDO::PARAM_STR);
	$stmt->bindValue(':entrega', $d["entrega"], PDO::PARAM_STR);
	$stmt->bindValue(':anotaciones', $d["anotaciones"], PDO::PARAM_STR);
	$stmt->execute();
	
	$insertId = $db->lastInsertId();
	
	if (is_array($d["acciones"])) {
		$acciones = array_map('trim',$d["acciones"]);
		$value = '';
		$stmt = $db->prepare("INSERT INTO acciones_tareas(idtarea,idaccion) VALUES(:idtarea,:idaccion)");
		$stmt->bindValue(':idtarea', $insertId, PDO::PARAM_INT);
		$stmt->bindParam(':idaccion', $value, PDO::PARAM_INT);
		foreach($acciones as $key => $value) {
		   $stmt->execute();
		}
	}
	return;
}

function actualizarTarea($d){
	global $db;
	$stmt = $db->prepare("UPDATE acciones SET accion=:accion, idcategoria=:categoria WHERE id=:id");	
	$stmt->bindValue(':categoria', $d["categoria"], PDO::PARAM_INT);
	$stmt->bindValue(':accion', $d["accion"], PDO::PARAM_STR);
	$stmt->bindValue(':id', $d["id"], PDO::PARAM_INT);
	$stmt->execute();
	return;
}

function eliminarTarea($id){
	global $db;
	global $sitioCfg;
	$stmt = $db->prepare("DELETE FROM acciones WHERE id=:id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	return;
}

function empresasQuery(){
	global $db;
	return $stmt = $db->query("SELECT idempresa,nombre from tbltk_empresas ORDER BY nombre");
}

function usuariosQuery(){
	global $db;
	return $stmt = $db->query("SELECT idusuario,nombres from tblusuarios ORDER BY nombres");
}
?>