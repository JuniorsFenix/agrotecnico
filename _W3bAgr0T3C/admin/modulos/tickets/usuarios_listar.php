<?php

require_once("../../herramientas/seguridad/seguridad.php");

require_once("../../herramientas/paginar/class.paginaZ.php");

require_once("../../herramientas/paginar/dbquery.inc.php");

require_once("../../funciones_generales.php");

require_once("../../vargenerales.php");

$IdCiudad = $_SESSION["IdCiudad"];



$filtro = isset($_GET["filtro"])?$_GET["filtro"]:"";

$idempresa = isset($_GET["idempresa"])?$_GET["idempresa"]:"todas";

$idsede = isset($_GET["idsede"])?$_GET["idsede"]:"todas";

$tipo = isset($_GET["tipo"])?$_GET["tipo"]:"todos";



$where = "where 1=1 ";

if ( $filtro != "" ) {

    $where .= "and (upper(CONCAT(a.nombre,' ',a.apellido)) like upper('%{$filtro}%') or upper(a.correo_electronico) like upper('%{$filtro}%')) ";

}

if ( $idempresa != "todas" ) {

    $where .= "and f.idempresa='{$idempresa}' ";

}

if ( $idsede != "todas" ) {

    $where .= "and c.idsede='{$idsede}' ";

}

if ( $tipo != "todos" ) {

    $where .= "and b.tipo='{$tipo}' ";

}



$page = new sistema_paginacion('tblusuarios_externos a 

    left join tbltk_sedes_usuarios b on (a.idusuario=b.idusuario)

    left join tbltk_sedes c on (b.idsede=c.idsede)

    left join tbltk_zonas d on (d.idzona=c.idzona)

    left join tbltk_regiones e on (e.idregion=d.idregion)

    

    left join tbltk_empresas f on (e.idempresa=f.idempresa)');

$page->set_campos("a.idusuario,b.tipo,CONCAT(a.nombre,' ',a.apellido) as nombre,a.correo_electronico,c.nombre as sede,f.nombre as empresa");

$page->ordenar_por("CONCAT(a.nombre,' ',a.apellido)");

$page->set_condicion($where);

$page->set_limite_pagina(20);

$rsUsuarios = $page->obtener_consulta();

if (!$rsUsuarios) {

    die("Fallo consultando usuarios");

}

$page->set_color_tabla("#FEF1E2");

$page->set_color_texto("black");

$page->set_color_enlaces("black", "#FF9900");







$nConexion = Conectar();

$ca = new DbQuery($nConexion);

$ca->prepareSelect("tbltk_empresas", "*");

$ca->exec();

$rEmpresas = $ca->fetchAll();

$ca = new DbQuery($nConexion);

$ca->prepareSelect("tbltk_sedes", "*");

$ca->exec();

$rSedes = $ca->fetchAll();

mysqli_close($nConexion);

$rTiposUsuario = array("admin"=>"Administrador","operador"=>"Operario");

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



        <title>Lista de Usuarios</title>



    </head>

    <body>

        <?php require_once("../../system_menu.php"); ?><br>



        <form action="usuarios_listar.php" method="post" name="formT">

            Empresa: <select id="idempresa" name="idempresa">

                <option value="todas" <?php echo $idempresa=="todas"?"selected":"";?>>Todas</option>

                <?php foreach ( $rEmpresas as $r):?>

                <option value="<?php echo $r["idempresa"];?>" <?php echo $idempresa==$r["idempresa"]?"selected":"";?>><?php echo $r["nombre"];?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Sedes: <select id="idsede" name="idsede">

                <option value="todas" <?php echo $idsede=="todas"?"selected":"";?>>Todas</option>

                <?php foreach ( $rSedes as $r):?>

                <option value="<?php echo $r["idsede"];?>" <?php echo $idsede==$r["idsede"]?"selected":"";?>><?php echo $r["nombre"];?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Perfil: <select id="tipo" name="tipo">

                <option value="todos" <?php echo $tipo=="todos"?"selected":"";?>>Todos</option>

                <?php foreach ( $rTiposUsuario as $k => $v ):?>

                <option value="<?php echo $k;?>" <?php echo $tipo==$k?"selected":"";?>><?php echo $v;?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Filtro: <input id="filtro" name="filtro" type="text"/>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                

            <input TYPE="button" VALUE="Filtrar" onClick="var filtro = document.getElementById('filtro');

                var e = document.getElementById('idempresa');

                var s = document.getElementById('idsede');

                var t = document.getElementById('tipo');

                window.location = 'usuarios_listar.php?idempresa='+e.value+'&idsede='+s.value+'&tipo='+t.value+'&filtro='+filtro.value;"/>

        </form>



        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td colspan="10" align="center" class="tituloFormulario">

                    <b>LISTA DE USUARIOS</b>

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

                <td bgcolor="#FEF1E2"><b>Correo</b></td>

                <td bgcolor="#FEF1E2"><b>Sede</b></td>

                <td bgcolor="#FEF1E2"><b>Empresa</b></td>

                <td bgcolor="#FEF1E2"><b>Perfil</b></td>

                <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>

                <td bgcolor="#FEF1E2"><b>Eliminar</b></td>

                <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

            </tr>

            <?php

            $ContFilas = 0;

            $ColorFilaPar = "#FFFFFF";

            $ColorFilaImpar = "#F0F0F0";

            while ($row = mysqli_fetch_object($rsUsuarios)) {

                $ContFilas = $ContFilas + 1;

                if (fmod($ContFilas, 2) == 0) {

                    $ColorFila = $ColorFilaPar;

                } else {

                    $ColorFila = $ColorFilaImpar;

                }

                ?>

                <tr>

                    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;</td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->idusuario; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->nombre; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->correo_electronico; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->sede; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->empresa; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->tipo; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>" align="center"><a href="usuarios.php?Accion=Editar&Id=<?php echo $row->idusuario;?>">

                            <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar"></a></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"align="center">

                        <a href="usuarios.php?Accion=Eliminar&Id=<?php echo $row->idusuario;?>" onclick="return confirm('�Seguro que desea eliminar este registro?');">

                            <img src="../../image/borrar.gif" border="0" />

                        </a>

                    </td>

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

        </table>

        <br/><br/><br/><br/><br/>

        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones inform�ticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

            </tr>

        </table>

    </body>

</html>

