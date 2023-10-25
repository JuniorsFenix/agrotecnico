<?php

ini_set('memory_limit','512M');



require_once("../../../funciones_generales.php");

require_once("../../../herramientas/paginar/dbquery.inc.php");

require_once("../../../herramientas/fpdf/fpdf.php");

require_once("../../../vargenerales.php");



$colores = "#0000FF,#8A2BE2,#A52A2A,#DEB887,#5F9EA0,#7FFF00,#D2691E,#FF7F50,#6495ED,#FFF8DC,#DC143C,#00FFFF,#00008B,#008B8B,#B8860B,#A9A9A9,#006400,#BDB76B,#8B008B";

$colores = str_replace("#", "", $colores);

$colores = explode(",", $colores);



function EvaluacionesGenerarGraficas($idsede,$idempresa,$filtro) {

    global $colores;

    $IdCiudad = $_SESSION["IdCiudad"];

    $nConexion = Conectar();

    $ca = new DbQuery($nConexion);

    

    $where = "1=1 ";

    if ( $filtro != "" ) {

        $where .= "and ( upper(b.nombre) like upper('%{$filtro}%') or upper(c.nombre) like upper('%{$filtro}%') 

        or upper(f.nombre) like upper('%{$filtro}%') or upper(e.nombre) like upper('%{$filtro}%') 

        or upper(d.nombre) like upper('%{$filtro}%') ) ";

    }

    if ( $idsede != "todas" ) {

        $where .= "and a.idsede='{$idsede}' ";

    }

    if ( $idempresa != "todas" ) {

        $where .= "and f.idempresa='{$idempresa}' ";

    }

    

    $campos = "a.idsede,a.idevaluacion,a.fechahora,b.nombre as sede,c.nombre as plantilla_evaluacion,f.nombre as empresa,d.nombre as zona,e.nombre as region,

        b.idevaluacion as codigo_plantilla";

    

    

    $ca->prepareSelect("tbltk_evaluaciones_vals a 

    join tbltk_sedes b on (a.idsede=b.idsede) 

    join tbltk_pevaluaciones c on (b.idevaluacion=c.idevaluacion)

    join tbltk_zonas d on (b.idzona=d.idzona) 

    join tbltk_regiones e on (d.idregion=e.idregion)

    join tbltk_empresas f on (e.idempresa=f.idempresa)", 

            $campos, $where);

    

    $ca->exec();



    $rEvaluaciones = $ca->fetchAll();

    

    ?>



<br/>

<table>



<?php

    $j = 0;

    foreach ($rEvaluaciones as $evaluacion) {

        shuffle(&$colores);

        $ca->prepareSelect("tbltk_evaluaciones_vals_det a 

            join tbltk_pevaluaciones_det b on (a.idconcepto=b.idconcepto)", 

                "a.valor,b.descripcion as pregunta", 

                "a.idevaluacion=:idevaluacion");

        $ca->bindValue(":idevaluacion", $evaluacion["idevaluacion"], false);

        

        $ca->exec();

        $cantidad = $ca->size();

        

        

        $rPreguntas = $ca->fetchAll();

        

        

        $url = "http://chart.apis.google.com/chart

            ?chf=a,s,000000

            &chxl=0:|0|1|2|3|4|5

            &chxr=0,0,6

            &chxs=0,676767,12.5,-1,l,676767

            &chxt=y

            &cht=bvg

            &chg=-1,20

            &chma=|6";

        

        $chbh = "&chbh=a,9";

        if ( $cantidad == 1 ) {

            $chbh = "&chbh=100,9,10";

        }

        

        $url .= $chbh;

        $url .= "&chtt={$evaluacion["sede"]}";

        

        $h = 250;

        if ( $cantidad > 11 ) {

            $h = $h + (20*($cantidad-11));

        }

        

        $url .= "&chs=400x{$h}";

        

        $chds = "&chds=".substr(str_repeat('0,5,',$cantidad),0,strlen(str_repeat('0,5,',$cantidad))-1);

        

        $url .= $chds;

        

        $url .= "&chco=".implode(',',array_slice($colores,0,$cantidad));

        

        $chd = "&chd=t:";

        $chdl = "&chdl=";

        $chm = "&chm=";

        $i = 1;

        $htmlPreguntas = "";

        foreach ($rPreguntas as $pregunta) {

            $chd .= "{$pregunta["valor"]}|";

            $chdl .= "p+{$i}|";

            $tmp = $i - 1;

            $chm .= "N,000000,{$tmp},-1,14|";

            $htmlPreguntas .= "{$i}-{$pregunta["pregunta"]}<br/>";

            $i++;

            

        }

        $chd = substr($chd, 0, strlen($chd)-1);

        $chdl = substr($chdl, 0, strlen($chdl)-1);

        $chm = substr($chm, 0, strlen($chm)-1);

        

        

        $url .= "{$chd}{$chdl}{$chm}";

        

        $url = str_replace(" ", "", $url);

        

        ?>

    <?php if ($j == 0){?>

    <tr>

        <td style="width: 15%;">&nbsp;</td>

        <td>

    <?php }else{?>

        </td>

        <td>

    <?php }?>

        <table>

            <tr>

                <td>

                    <strong>Empresa:</strong> <?php echo $evaluacion["empresa"];?><br/>

                    <strong>Sede:</strong> <?php echo $evaluacion["sede"];?><br/>

                    <strong>Fecha:</strong> <?php echo $evaluacion["fechahora"];?><br/>

                    <strong>Plantilla evaluación:</strong> <?php echo $evaluacion["plantilla_evaluacion"];?><br/>

                    <br/>

                    <strong>Preguntas:</strong><br/><br/>

                    <?php echo $htmlPreguntas;?>

                    <br/>

                </td>

            </tr>

            <tr>

                <td>

                    <img src="<?php echo $url;?>" alt='img.'/><br/><br/>

                </td>

            </tr>

        </table>

    <?php if ($j == 0){?>

        </td>

    <?php }else{?>

        </td>

        <td style="width: 15%;">&nbsp;</td>

    <tr>

    <?php 

        $j = -1;

    }?>

    

    <?php

        $j++;

    }

?>



</table>

<br/><br/>

<a href="evaluaciones_listar.php"><img src="../../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>

<br/><br/>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

    <tr>

        <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

    </tr>

</table>

<br/><br/>

<br/><br/>

<?php

}

?>



<?php

function EvaluacionesGenerarPDF($idsede,$idempresa,$filtro){

    

    global $cRutaTicketsAdjunto;

    ob_clean();

    ob_start();

    global $colores;

    $IdCiudad = $_SESSION["IdCiudad"];

    $nConexion = Conectar();

    $ca = new DbQuery($nConexion);

    

    $where = "1=1 ";

    if ( $filtro != "" ) {

        $where .= "and ( upper(b.nombre) like upper('%{$filtro}%') or upper(c.nombre) like upper('%{$filtro}%') 

        or upper(f.nombre) like upper('%{$filtro}%') or upper(e.nombre) like upper('%{$filtro}%') 

        or upper(d.nombre) like upper('%{$filtro}%') ) ";

    }

    if ( $idsede != "todas" ) {

        $where .= "and a.idsede='{$idsede}' ";

    }

    if ( $idempresa != "todas" ) {

        $where .= "and f.idempresa='{$idempresa}' ";

    }

    

    $campos = "a.idsede,a.idevaluacion,a.fechahora,b.nombre as sede,c.nombre as plantilla_evaluacion,f.nombre as empresa,d.nombre as zona,e.nombre as region,

        b.idevaluacion as codigo_plantilla";

    

    

    $ca->prepareSelect("tbltk_evaluaciones_vals a 

    join tbltk_sedes b on (a.idsede=b.idsede) 

    join tbltk_pevaluaciones c on (b.idevaluacion=c.idevaluacion)

    join tbltk_zonas d on (b.idzona=d.idzona) 

    join tbltk_regiones e on (d.idregion=e.idregion)

    join tbltk_empresas f on (e.idempresa=f.idempresa)", 

            $campos, $where);

    

    

    $ca->exec();



    $rEvaluaciones = $ca->fetchAll();

    

    

    $pdf = new fpdf();

    $pdf->AddPage();

    $pdf->SetFont('Arial','B',11);

    

    $rFiles = array();

    

    foreach ($rEvaluaciones as $evaluacion) {

        shuffle(&$colores);

        $ca->prepareSelect("tbltk_evaluaciones_vals_det a 

            join tbltk_pevaluaciones_det b on (a.idconcepto=b.idconcepto)", 

                "a.valor,b.descripcion as pregunta", 

                "a.idevaluacion=:idevaluacion");

        $ca->bindValue(":idevaluacion", $evaluacion["idevaluacion"], false);

        

        $ca->exec();

        $cantidad = $ca->size();

        

        

        $rPreguntas = $ca->fetchAll();

        

        

        $url = "http://chart.apis.google.com/chart

            ?chf=a,s,000000

            &chxl=0:|0|1|2|3|4|5

            &chxr=0,0,6

            &chxs=0,676767,12.5,-1,l,676767

            &chxt=y

            &cht=bvg

            &chg=-1,20

            &chma=|6";

        

        $chbh = "&chbh=a,9";

        if ( $cantidad == 1 ) {

            $chbh = "&chbh=100,9,10";

        }

        

        $url .= $chbh;

        $url .= "&chtt={$evaluacion["sede"]}";

        

        $h = 250;

        if ( $cantidad > 11 ) {

            $h = $h + (20*($cantidad-11));

        }

        

        $url .= "&chs=400x{$h}";

        

        $chds = "&chds=".substr(str_repeat('0,5,',$cantidad),0,strlen(str_repeat('0,5,',$cantidad))-1);

        

        $url .= $chds;

        

        $url .= "&chco=".implode(',',array_slice($colores,0,$cantidad));

        

        $chd = "&chd=t:";

        $chdl = "&chdl=";

        $chm = "&chm=";

        

        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(5);$pdf->Cell(22, 5, ("Empresa: "));

        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(100, 5, ("{$evaluacion["empresa"]}"));

        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(5);$pdf->Cell(15, 5, ("Sede: "));

        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(100, 5, ("{$evaluacion["sede"]}"));

        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(5);$pdf->Cell(17, 5, ("Fecha: "));

        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(100, 5, ("{$evaluacion["fechahora"]}"));

        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(5);$pdf->Cell(44, 5, ("Plantilla evaluación: "));

        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(125, 5, ("{$evaluacion["plantilla_evaluacion"]}"));

        $pdf->Ln();

        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(5);$pdf->Cell(60, 5, ("Preguntas"));

        $pdf->Ln();

        $pdf->SetFont('Arial', '', 12);

        $i = 1;

        

        foreach ($rPreguntas as $pregunta) {

            $chd .= "{$pregunta["valor"]}|";

            $chdl .= "p+{$i}|";

            $tmp = $i - 1;

            $chm .= "N,000000,{$tmp},-1,14|";

            $pdf->Cell(5);$pdf->Cell(60, 5, ("{$i}-{$pregunta["pregunta"]}"));

            $pdf->Ln();

            $i++;

        }

        $chd = substr($chd, 0, strlen($chd)-1);

        $chdl = substr($chdl, 0, strlen($chdl)-1);

        $chm = substr($chm, 0, strlen($chm)-1);

        

        $url .= "{$chd}{$chdl}{$chm}";

        

        $url = trim(str_replace("\n", "", $url));

        $url = trim(str_replace("\r", "", $url));

        $url = trim(str_replace(" ", "", $url));

        

        $filename = "../{$cRutaTicketsAdjunto}{$evaluacion["sede"]}_{$evaluacion["fechahora"]}.png";

        file_put_contents($filename, file_get_contents($url));

        

        $rFiles[] = $filename;

        

        if ( $pdf->GetY() + 60 > 280 ) {

            $pdf->AddPage();

        }

        

        $pdf->Ln(2);

        $pdf->Cell(60, 60, $pdf->Image($filename,$pdf->GetX(),$pdf->GetY(),95,60,'PNG'));

        $pdf->SetY($pdf->GetY()+60);

        $pdf->Ln(10);

    }

    

    foreach ($rFiles as $filename) {

        unlink($filename);

    }

    

    $pdf->Output();

}

?>