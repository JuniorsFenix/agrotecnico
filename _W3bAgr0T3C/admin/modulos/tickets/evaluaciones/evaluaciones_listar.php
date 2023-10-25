<?php

require_once("../../../herramientas/seguridad/seguridad.php");

require_once("../../../herramientas/paginar/class.paginaZ.php");

require_once("../../../herramientas/paginar/dbquery.inc.php");

require_once("../../../funciones_generales.php");

require_once("../../../vargenerales.php");

$IdCiudad = $_SESSION["IdCiudad"];



$idsede = isset($_GET["idsede"])?$_GET["idsede"]:"todas";

$idempresa = isset($_GET["idempresa"])?$_GET["idempresa"]:"todas";

$filtro = isset($_GET["filtro"])?$_GET["filtro"]:"";



$where = "where 1=1 ";

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



$page = new sistema_paginacion('tbltk_evaluaciones_vals a 

    join tbltk_sedes b on (a.idsede=b.idsede) 

    join tbltk_pevaluaciones c on (b.idevaluacion=c.idevaluacion)

    join tbltk_zonas d on (b.idzona=d.idzona) 

    join tbltk_regiones e on (d.idregion=e.idregion)

    join tbltk_empresas f on (e.idempresa=f.idempresa)');

$page->set_campos("a.idsede,a.idevaluacion,a.fechahora,b.nombre as sede,c.nombre as plantilla_evaluacion,f.nombre as empresa,d.nombre as zona,e.nombre as region");

$page->ordenar_por('a.idevaluacion');

$page->set_condicion($where);

$page->set_limite_pagina(20);

$rsEvaluaciones = $page->obtener_consulta();

if (!$rsEvaluaciones) {

    die("Fallo consultando evaluaciones realizadas");

}

$page->set_color_tabla("#FEF1E2");

$page->set_color_texto("black");

$page->set_color_enlaces("black", "#FF9900");







$nConexion = Conectar();

$ca=new DbQuery($nConexion);

$ca->prepareSelect("tbltk_sedes", "*");

$ca->exec();

$rSedes = $ca->fetchAll();



$ca->prepareSelect("tbltk_empresas", "*");

$ca->exec();

$rEmpresas = $ca->fetchAll();

?>



<html>

    <head>

        <link href="../../../css/administrador.css" rel="stylesheet" type="text/css">

        <style type="text/css">

            <!--

            body {

                margin-top: 0px;

                margin-bottom:0px;

                margin-left:0px;

                margin-right:0px;

            }

            -->

        </style>



        <title>Lista de Evaluaciones Realizadas</title>



    </head>

    <body>

        <?php require_once("../../../system_menu.php"); ?><br>

            

        <form action="evaluaciones_listar.php" method="post" name="formT">

            Empresa: <select id="idempresa" name="idempresa">

                <option value="todas" <?php echo $idempresa=="todas"?"selected":"";?>>Todas</option>

                <?php foreach ( $rEmpresas as $r):?>

                <option value="<?php echo $r["idempresa"];?>" <?php echo $idempresa==$r["idempresa"]?"selected":"";?>><?php echo $r["nombre"];?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Sede: <select id="idsede" name="idsede">

                <option value="todas" <?php echo $idsede=="todas"?"selected":"";?>>Todas</option>

                <?php foreach ( $rSedes as $r):?>

                <option value="<?php echo $r["idsede"];?>" <?php echo $idsede==$r["idsede"]?"selected":"";?>><?php echo $r["nombre"];?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Filtro: <input id="filtro" name="filtro" type="text" value="<?php echo $filtro;?>"/>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                

            <input TYPE="button" VALUE="Filtrar" onClick="var filtro = document.getElementById('filtro');

                var s = document.getElementById('idsede');

                var e = document.getElementById('idempresa');

                window.location = 'evaluaciones_listar.php?idsede='+s.value+'&idempresa='+e.value+'&filtro='+filtro.value;"/>

        </form>



        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td colspan="10" align="center" class="tituloFormulario">

                    <b>LISTA DE EVALUACIONES REALIZADAS</b>

                    <br/>

                    <?php 

                    $page->mostrar_numero_pagina();

                    ?>

                    <br/>

                </td>

            </tr>

            <tr>

                <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

                <td bgcolor="#FEF1E2"><b>Id Sede.</b></td>

                <td bgcolor="#FEF1E2"><b>Id Evaluaci�n.</b></td>

                <td bgcolor="#FEF1E2"><b>Empresa</b></td>

                <td bgcolor="#FEF1E2"><b>Region</b></td>

                <td bgcolor="#FEF1E2"><b>Zona</b></td>

                <td bgcolor="#FEF1E2"><b>Sede</b></td>

                <td bgcolor="#FEF1E2"><b>Plantilla Evaluaci�n</b></td>

                <td bgcolor="#FEF1E2"><b>Fecha</b></td>

                <!--td bgcolor="#FEF1E2"><b>Seleccionar</b></td-->

                <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

            </tr>

            <?php

            $ContFilas = 0;

            $ColorFilaPar = "#FFFFFF";

            $ColorFilaImpar = "#F0F0F0";

            while ($row = mysqli_fetch_object($rsEvaluaciones)) {

                $ContFilas = $ContFilas + 1;

                if (fmod($ContFilas, 2) == 0) {

                    $ColorFila = $ColorFilaPar;

                } else {

                    $ColorFila = $ColorFilaImpar;

                }

                ?>

                <tr>

                    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;</td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->idsede; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->idevaluacion; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->empresa; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->region; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->zona; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->sede; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->plantilla_evaluacion; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->fechahora; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;</td>

                </tr>

                <?

            }

            ?>

            <tr>

                <td colspan="10">

                    <?php 

                        $page->mostrar_enlaces();

                    ?>

                </td>

            </tr>

            <tr>

                <td colspan="10">&nbsp;</td>

            </tr>

            <tr>

                <td colspan="10" class="nuevo">

                    <input TYPE="button" VALUE="Generar Graficas" onClick="

                        var filtro = document.getElementById('filtro');

                        var s = document.getElementById('idsede');

                        var e = document.getElementById('idempresa');

                        window.location = 'evaluaciones.php?Accion=GenerarGraficas&idsede='+s.value+'&idempresa='+e.value+'&filtro='+filtro.value;"/>

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <input TYPE="button" VALUE="Generar PDF" onClick="

                        var filtro = document.getElementById('filtro');

                        var s = document.getElementById('idsede');

                        var e = document.getElementById('idempresa');

                        window.location = 'evaluaciones.php?Accion=GenerarPDF&idsede='+s.value+'&idempresa='+e.value+'&filtro='+filtro.value;"/>

                </td>

            </tr>

        </table>

        <br/><br/><br/><br/><br/>

        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones inform�ticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

            </tr>

        </table>

    </body>

</html>

