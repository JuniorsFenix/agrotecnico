<?php

class Pager {

    public static function htmlPager($pageCount, $currentPage,$pageVars="", $p=array()) {
        $p["maxVisiblePages"] = isset($p["maxVisiblePages"]) ? $p["maxVisiblePages"] : 10;
        $p["recordCount"] = isset($p["recordCount"]) ? $p["recordCount"]:false;
        
        $html = "";
        $htmlPrevPage="";
        $htmlNextPage="";
        
        $htmlFirstPage="";
        $htmlLastPage="";
        
        $prevPage = $currentPage - 1;
        $nextPage = $currentPage + 1;

        $prevGroup = "";
        $nextGroup = "";

        $pageVars = trim($pageVars) != "" ? ("&" . trim($pageVars)) : "";

        //echo "currentPage={$currentPage} pageCount={$pageCount} nextPage={$nextPage} prevPage={$prevPage}";

        if ($currentPage < $pageCount) {
            $htmlNextPage = "<li class=\"jlib-pager-next\"><a href=\"?pag={$nextPage}{$pageVars}\" >Siguiente »</a></li>";
            $htmlLastPage = "<li class=\"jlib-pager-last\"><a href=\"?pag={$pageCount}{$pageVars}\" >Página final</a></li>";
        }

        if ($currentPage > 1) {
            $htmlPrevPage = "<li class=\"jlib-pager-prev\"><a href=\"?pag={$prevPage}{$pageVars}\" >« Anterior</a></li>";
            $htmlFirstPage = "<li class=\"jlib-pager-firstt\"><a href=\"?pag=1{$pageVars}\" >Página inicial</a></li>";
        }

        $html.="<div class=\"jlib-pager\">";
        //$html.="Paginas: {$pageCount} | {$prevGroup}";


        $startAt = $currentPage;
        $endAt = $currentPage;

        $maxPagesOffset = intval($p["maxVisiblePages"] / 2);
        $maxPagesLeftOffset = $maxPagesOffset;
        $maxPagesRightOffset = $maxPagesOffset;

        while ($maxPagesLeftOffset > 0 && $startAt > 1) {
            $startAt--;
            $maxPagesLeftOffset--;
        }

        $maxPagesRightOffset+=$maxPagesLeftOffset;
        while ($maxPagesRightOffset > 0 && $endAt < $pageCount) {
            $endAt++;
            $maxPagesRightOffset--;
        }

        //me devuelvo a la izquierda
        $maxPagesLeftOffset = $maxPagesRightOffset;
        while ($maxPagesLeftOffset > 0 && $startAt > 1) {
            $startAt--;
            $maxPagesLeftOffset--;
        }
        
        
        $htmlGotoPage="<li class=\"goto-page\">Ir a la pagina:<input type=\"text\" onkeypress=\"if(event.keyCode==13) location='?pag='+this.value+'{$pageVars}';\"></li>";
        
        
        $html.="<ul>{$htmlFirstPage}{$htmlPrevPage}";

        for ($i = $startAt; $i <= $endAt; $i++) {
            if ($i == $currentPage ) {
                $html.="<li class=\"jlib-pager-current\"><a href=\"javascript:;\" >{$i}</a></li>";
                continue;
            }
            $html.="<li class=\"jlib-pager-page\"><a href=\"?pag={$i}{$pageVars}\"  >{$i}</a></li>";
        }
        
        $html.="{$htmlNextPage}{$htmlLastPage}{$htmlGotoPage}</ul>";

        /*if ( $currentPage < ( $pageCount - $itemsPerPage )) {
            $html.="<a href=\"?pag={$pageCount}&{$pageVars}\" class=\"wqueryPagerLast\" >Ultima &gt;&gt;</a>";
        }*/

        if( $p["recordCount"]!==false ){
            $html.="{$nextGroup} | Registros: {$p["recordCount"]}<br/>";
        }

        //$html.="<br/>{$htmlPrevPage} Pagina Actual: {$currentPage} {$htmlNextPage}";
        $html.="</div>";

        return $html;
    }
	
	
	/*
	
    public static function htmlPager($pageCount, $currentPage,$pageVars="", $p=array()) {
        $p["maxVisiblePages"] = isset($p["maxVisiblePages"]) ? $p["maxVisiblePages"] : 10;
        $p["recordCount"] = isset($p["recordCount"]) ? $p["recordCount"]:false;
        
        $html = "";
        $htmlPrevPage="";
        $htmlNextPage="";
        
        $prevPage = $currentPage - 1;
        $nextPage = $currentPage + 1;

        $prevGroup = "";
        $nextGroup = "";

        $pageVars = trim($pageVars) != "" ? ("&" . trim($pageVars)) : "";

        //echo "currentPage={$currentPage} pageCount={$pageCount} nextPage={$nextPage} prevPage={$prevPage}";

        if ($currentPage < $pageCount) {
            $htmlNextPage = "| <a href=\"?pag={$nextPage}{$pageVars}\" class=\"jlib-pager-next\">Siguiente ></a>";
        }

        if ($currentPage > 1) {
            $htmlPrevPage = "<a href=\"?pag={$prevPage}{$pageVars}\" class=\"jlib-pager-prev\">< Anterior</a> |";
        }

        $html.="<div class=\"jlib-pager\">";
        $html.="Paginas: {$pageCount} | {$prevGroup}";


        $startAt = $currentPage;
        $endAt = $currentPage;

        $maxPagesOffset = intval($p["maxVisiblePages"] / 2);
        $maxPagesLeftOffset = $maxPagesOffset;
        $maxPagesRightOffset = $maxPagesOffset;

        while ($maxPagesLeftOffset > 0 && $startAt > 1) {
            $startAt--;
            $maxPagesLeftOffset--;
        }

        $maxPagesRightOffset+=$maxPagesLeftOffset;
        while ($maxPagesRightOffset > 0 && $endAt < $pageCount) {
            $endAt++;
            $maxPagesRightOffset--;
        }

        //me devuelvo a la izquierda
        $maxPagesLeftOffset = $maxPagesRightOffset;
        while ($maxPagesLeftOffset > 0 && $startAt > 1) {
            $startAt--;
            $maxPagesLeftOffset--;
        }

        for ($i = $startAt; $i <= $endAt; $i++) {
            if ($i == $currentPage ) {
                $html.="<a href=\"javascript:;\" class=\"jlib-pager-current\">{$i}</a>";
                continue;
            }
            $html.="<a href=\"?pag={$i}{$pageVars}\" class=\"jlib-pager-page\" >{$i}</a>";
        }


        if( $p["recordCount"]!==false ){
            $html.="{$nextGroup} | Registros: {$p["recordCount"]}<br/>";
        }

        $html.="<br/>{$htmlPrevPage} Pagina Actual: {$currentPage} {$htmlNextPage}";
        $html.="</div>";

        return $html;
    }
	*/
}
?>