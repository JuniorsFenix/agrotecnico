<?php

require_once ("../../herramientas/seguridad/seguridad.php");

require_once ("../../herramientas/paginar/class.paginaZ.php");

require_once ("../../vargenerales.php");

$IdCiudad = $_SESSION["IdCiudad"];

$page = new sistema_paginacion('tblmb_contenidos');

$page->set_condicion("where tipo='archivo'");

$page->ordenar_por('nombre');

$page->set_limite_pagina(20);

$rs_archivos = $page->obtener_consulta();

$page->set_color_tabla("#FEF1E2");

$page->set_color_texto("black");

$page->set_color_enlaces("black", "#FF9900");

?>



<html>

    <head>

        <link href="../../css/administrador.css" rel="stylesheet" type="text/css">

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



    </head>

    <body>

        <?php include("../../system_menu.php"); ?><br/>

        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td colspan="9" align="center" class="tituloFormulario">

                    <b>LISTA DE ARCHIVOS MEMBRESIAS</b>

                    <br>

                    <?php $page->mostrar_numero_pagina(); ?><br>

                </td>

            </tr>

            <tr>

                <td bgcolor="#FEF1E2">&nbsp;</td>

                <td bgcolor="#FEF1E2"><b>Id</b></td>

                <td bgcolor="#FEF1E2"><b>Nombre</b></td>

                <td bgcolor="#FEF1E2"><b>Fecha publicaci�n</b></td>

                <td bgcolor="#FEF1E2"><b>URL</b></td>

                <td bgcolor="#FEF1E2"><b>Estado</b></td>

                <td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>

                <td align="center" bgcolor="#FEF1E2"><b>Archivo</b></td>

                <td bgcolor="#FEF1E2">&nbsp;</td>

            </tr>

            <?php

            $ContFilas = 0;

            $ColorFilaPar = "#FFFFFF";

            $ColorFilaImpar = "#F0F0F0";

            while ($row = mysqli_fetch_object($rs_archivos)) {

                $ContFilas = $ContFilas + 1;

                if (fmod($ContFilas, 2) == 0) { // Si devuelve cero el numero es par

                    $ColorFila = $ColorFilaPar;

                } else {

                    $ColorFila = $ColorFilaImpar;

                }

                ?>

                <tr>

                    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->idcontenido; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->nombre; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->fecha_publicacion; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->url_informacion; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->estado; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"align="center">

                        <a href="archivos.php?Accion=Editar&Id=<?php echo $row->idcontenido;?>">

                            <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<?php echo $row->nombre; ?>"/>

                        </a>

                    </td>

                    <td bgcolor="<?php echo $ColorFila; ?>"align="center">

                        <?php

                        if (!empty($row->archivo)) {

                            echo "<a href='{$cRutaVerImgMbContenidos}{$row->archivo}' target='_blank'>Descargar Archivo</a>";

                        } else {

                            echo "No Asignado";

                        }

                        ?>

                    </td>

                    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                </tr>

                <?php

            }

            ?>

            <tr>

                <td colspan="9"><?php $page->mostrar_enlaces(); ?></td>

            </tr>

            <tr>

                <td colspan="9">&nbsp;</td>

            </tr>

            <tr>

                <td colspan="9" class="nuevo">

                    <a href="archivos.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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









