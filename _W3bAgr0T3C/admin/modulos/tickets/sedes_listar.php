<?php

require_once("../../herramientas/seguridad/seguridad.php");

require_once("../../herramientas/paginar/class.paginaZ.php");

require_once("../../funciones_generales.php");

require_once("../../vargenerales.php");

$IdCiudad = $_SESSION["IdCiudad"];



$filtro = isset($_GET["filtro"])?$_GET["filtro"]:"";



$where = "where 1=1 ";

if ( $filtro != "" ) {

    $where .= "and (upper(b.nombre) like upper('%{$filtro}%') or upper(a.nombre) like upper('%{$filtro}%') 

            or upper(a.ciudad) like upper('%{$filtro}%') or upper(a.contacto) like upper('%{$filtro}%')

            or upper(c.nombre) like upper('%{$filtro}%') or upper(d.nombre) like upper('%{$filtro}%')

            ) ";

}



$page = new sistema_paginacion('tbltk_sedes a 

    join tbltk_zonas b on (a.idzona=b.idzona) 

    join tbltk_regiones c on (b.idregion=c.idregion)

    join tbltk_empresas d on (c.idempresa=d.idempresa)');

$page->set_campos("a.idsede,b.nombre as zona,d.nombre as empresa,c.nombre as region,a.nombre,a.contacto,a.correo_contacto,a.ciudad,a.direccion,a.telefono");

$page->ordenar_por('a.idsede');

$page->set_condicion($where);

$page->set_limite_pagina(20);

$rsSedes = $page->obtener_consulta();

if (!$rsSedes) {

    die("Fallo consultando sedes");

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



        <title>Lista de Sedes</title>



    </head>

    <body>

        <?php require_once("../../system_menu.php"); ?><br>

            

        <form action="sedes_listar.php" method="post" name="formT">

            Filtro: <input id="filtro" name="filtro" type="text"/>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                

            <input TYPE="button" VALUE="Filtrar" onClick="var filtro = document.getElementById('filtro');

                window.location = 'sedes_listar.php?filtro='+filtro.value;"/>

        </form>



        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td colspan="15" align="center" class="tituloFormulario">

                    <b>LISTA DE SEDES</b>

                    <br/>

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

                <td bgcolor="#FEF1E2"><b>Zona</b></td>

                <td bgcolor="#FEF1E2"><b>Region</b></td>

                <td bgcolor="#FEF1E2"><b>Empresa</b></td>

                <td bgcolor="#FEF1E2"><b>Contacto</b></td>

                <td bgcolor="#FEF1E2"><b>Correo Contacto</b></td>

                <td bgcolor="#FEF1E2"><b>Ciudad</b></td>

                <td bgcolor="#FEF1E2"><b>Direcci�n</b></td>

                <td bgcolor="#FEF1E2"><b>Tel�fono</b></td>

                <td bgcolor="#FEF1E2"><b>Evaluar</b></td>

                <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>

                <td bgcolor="#FEF1E2"><b>Eliminar</b></td>

                <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

            </tr>

            <?php

            $ContFilas = 0;

            $ColorFilaPar = "#FFFFFF";

            $ColorFilaImpar = "#F0F0F0";

            while ($row = mysqli_fetch_object($rsSedes)) {

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

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->nombre; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->zona; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->region; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->empresa; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->contacto; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->correo_contacto; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->ciudad; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->direccion; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->telefono; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>" align="center">

                        <a href="evaluaciones/p_evaluaciones.php?Accion=Evaluar&idsede=<?php echo $row->idsede;?>">

                            <img src="../../image/nuevasubcat.gif" border="0" alt="Evaluar"/>

                        </a>

                    </td>

                    <td bgcolor="<?php echo $ColorFila; ?>" align="center">

                        <a href="sedes.php?Accion=Editar&Id=<?php echo $row->idsede;?>">

                            <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar"/>

                        </a>

                    </td>

                    <td bgcolor="<?php echo $ColorFila; ?>"align="center">

                        <a href="sedes.php?Accion=Eliminar&Id=<?php echo $row->idsede;?>" onclick="return confirm('�Seguro que desea eliminar este registro?');">

                            <img src="../../image/borrar.gif" border="0" />

                        </a>

                    </td>

                    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;</td>

                </tr>

                <?

            }

            ?>

            <tr>

                <td colspan="15">

                    <?php 

                        $page->mostrar_enlaces();

                    ?>

                </td>

            </tr>

            <tr>

                <td colspan="15">&nbsp;</td>

            </tr>

            <tr>

                <td colspan="15" class="nuevo">

                    <a href="sedes.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."/></a>

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

