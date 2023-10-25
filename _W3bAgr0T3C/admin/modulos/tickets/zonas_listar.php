<?php

require_once("../../herramientas/seguridad/seguridad.php");

require_once("../../herramientas/paginar/class.paginaZ.php");

require_once("../../funciones_generales.php");

require_once("../../vargenerales.php");

$IdCiudad = $_SESSION["IdCiudad"];

$page = new sistema_paginacion('tbltk_zonas a join tbltk_regiones b on (a.idregion=b.idregion) join tbltk_empresas c on (b.idempresa=c.idempresa)');



$page->set_campos("a.idzona,b.nombre as region,c.nombre as empresa,a.nombre");

$page->ordenar_por('a.idzona');

$page->set_limite_pagina(20);

$rsZonas = $page->obtener_consulta();

if (!$rsZonas) {

    die("Fallo consultando zonas");

}

$page->set_color_tabla("#FEF1E2");

$page->set_color_texto("black");

$page->set_color_enlaces("black", "#FF9900");





/*

$nConexion = Conectar();

$ca=new DbQuery($nConexion);

$ca->prepare($sql);

$ca->bindValue(":codigo", 1);

$ca->exec();

*/







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

        <title>Lista de Zonas</title>



    </head>

    <body>

        <?php require_once("../../system_menu.php"); ?><br>



        <form action="zonas_listar.php" method="post"></form>



        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td colspan="8" align="center" class="tituloFormulario">

                    <b>LISTA DE ZONAS</b>

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

                <td bgcolor="#FEF1E2"><b>Nombre</b></td>

                <td bgcolor="#FEF1E2"><b>Region</b></td>

                <td bgcolor="#FEF1E2"><b>Empresa</b></td>

                <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>

                <td bgcolor="#FEF1E2"><b>Eliminar</b></td>

                <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

            </tr>

            <?php

            $ContFilas = 0;

            $ColorFilaPar = "#FFFFFF";

            $ColorFilaImpar = "#F0F0F0";

            while ($row = mysqli_fetch_object($rsZonas)) {

                $ContFilas = $ContFilas + 1;

                if (fmod($ContFilas, 2) == 0) {

                    $ColorFila = $ColorFilaPar;

                } else {

                    $ColorFila = $ColorFilaImpar;

                }

                ?>

                <tr>

                    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;</td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->idzona; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->nombre; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->region; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->empresa; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>" align="center"><a href="zonas.php?Accion=Editar&Id=<?php echo $row->idzona;?>">

                            <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar"></a></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"align="center">

                        <a href="zonas.php?Accion=Eliminar&Id=<?php echo $row->idzona;?>" onclick="return confirm('�Seguro que desea eliminar este registro?');">

                            <img src="../../image/borrar.gif" border="0" />

                        </a>

                    </td>

                    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;</td>

                </tr>

                <?

            }

            ?>

            <tr>

                <td colspan="8">

                    <?php 

                        $page->mostrar_enlaces();

                    ?>

                </td>

            </tr>

            <tr>

                <td colspan="8">&nbsp;</td>

            </tr>

            <tr>

                <td colspan="8" class="nuevo">

                    <a href="zonas.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."/></a>

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

