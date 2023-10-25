<?php

require_once("../../herramientas/seguridad/seguridad.php");

require_once("../../herramientas/paginar/class.paginaZ.php");

require_once("../../herramientas/paginar/dbquery.inc.php");

require_once("../../funciones_generales.php");

require_once("../../vargenerales.php");

$IdCiudad = $_SESSION["IdCiudad"];





$idevaluacion = isset($_GET["idevaluacion"])?$_GET["idevaluacion"]:"todas";

$filtro = isset($_GET["filtro"])?$_GET["filtro"]:"";



$where = "where 1=1 ";

if ( $filtro != "" ) {

    $where .= "and ( upper(b.nombre) like upper('%{$filtro}%') or upper(a.pregunta) like upper('%{$filtro}%') ) ";

}

if ( $idevaluacion != "todas" ) {

    $where .= "and a.idevaluacion='{$idevaluacion}' ";

}



$page = new sistema_paginacion('tbl_pevaluaciones_publicas_det a join tbl_pevaluaciones_publicas b on (a.idevaluacion=b.idevaluacion)');

$page->set_campos("a.idpregunta,a.pregunta,b.nombre as evaluacion");

$page->ordenar_por('a.idevaluacion');

$page->set_condicion($where);

$page->set_limite_pagina(20);

$rsPreguntas = $page->obtener_consulta();

if (!$rsPreguntas) {

    die("Fallo consultando preguntas");

}



$page->set_color_tabla("#FEF1E2");

$page->set_color_texto("black");

$page->set_color_enlaces("black", "#FF9900");





$nConexion = Conectar();

$ca=new DbQuery($nConexion);

$ca->prepareSelect("tbl_pevaluaciones_publicas", "*");

$ca->exec();

$rEvaluaciones = $ca->fetchAll();



?>



<html>

    <head>

        <link href="../../css/administrador.css" rel="stylesheet" type="text/css"/>

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



        <title>Lista de Preguntas Evaluaciones</title>



    </head>

    <body>

        <?php require_once("../../system_menu.php"); ?><br>



        <form action="preguntas_listar.php" method="post" name="formT">

            Evaluaci�n: <select id="idevaluacion" name="idevaluacion">

                <option value="todas" <?php echo $idevaluacion=="todas"?"selected":"";?>>Todas</option>

                <?php foreach ( $rEvaluaciones as $r):?>

                <option value="<?php echo $r["idevaluacion"];?>" <?php echo $idevaluacion==$r["idevaluacion"]?"selected":"";?>><?php echo $r["nombre"];?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Filtro: <input id="filtro" name="filtro" type="text"/>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                

            <input TYPE="button" VALUE="Filtrar" onClick="var filtro = document.getElementById('filtro');

                var e = document.getElementById('idevaluacion');

                window.location = 'preguntas_listar.php?idevaluacion='+e.value+'&filtro='+filtro.value;"/>

        </form>



        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td colspan="7" align="center" class="tituloFormulario">

                    <b>LISTA DE PREGUNTAS EVALUACIONES PUBLICAS</b>

                    <br>

                    <?php 

                    $page->mostrar_numero_pagina();

                    ?>

                    <br/>

                </td>

            </tr>

            <tr>

                <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

                <td bgcolor="#FEF1E2"><b>Id.</b></td>

                <td bgcolor="#FEF1E2"><b>Pregunta</b></td>

                <td bgcolor="#FEF1E2"><b>Evaluacion</b></td>

                <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>

                <td bgcolor="#FEF1E2"><b>Eliminar</b></td>

                <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

            </tr>

            <?php

            $ContFilas = 0;

            $ColorFilaPar = "#FFFFFF";

            $ColorFilaImpar = "#F0F0F0";

            while ($row = mysqli_fetch_object($rsPreguntas)) {

                $ContFilas = $ContFilas + 1;

                if (fmod($ContFilas, 2) == 0) {

                    $ColorFila = $ColorFilaPar;

                } else {

                    $ColorFila = $ColorFilaImpar;

                }

                ?>

                <tr>

                    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;</td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->idpregunta; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->pregunta; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->evaluacion; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>" align="center">

                        <a href="preguntas.php?Accion=Editar&Id=<?php echo $row->idpregunta;?>">

                            <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar"/>

                        </a>

                    </td>

                    <td bgcolor="<?php echo $ColorFila; ?>"align="center">

                        <a href="preguntas.php?Accion=Eliminar&Id=<?php echo $row->idpregunta;?>" onclick="return confirm('�Seguro que desea eliminar este registro?');">

                            <img src="../../image/borrar.gif" border="0" />

                        </a>

                    </td>

                    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;</td>

                </tr>

                <?php

            }

            ?>

            <tr>

                <td colspan="7">

                    <?php 

                        $page->mostrar_enlaces();

                    ?>

                </td>

            </tr>

            <tr>

                <td colspan="7">&nbsp;</td>

            </tr>

            <tr>

                <td colspan="7" class="nuevo">

                    <a href="preguntas.php?Accion=Adicionar">

                        <img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."/>

                    </a>

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

