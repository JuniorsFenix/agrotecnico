<?php
require_once("../../herramientas/seguridad/seguridad.php");
require_once("../../herramientas/paginar/class.paginaZ.php");
require_once("../../herramientas/paginar/dbquery.inc.php");
require_once("../../funciones_generales.php");
require_once("../../vargenerales.php");
$IdCiudad = $_SESSION["IdCiudad"];

$filtro = isset($_GET["filtro"]) ? $_GET["filtro"] : "";
$idmembresia = isset($_GET["idmembresia"]) ? $_GET["idmembresia"] : "todas";

$where = "where 1=1 ";
if ($filtro != "") {
    $where .= "and (upper(CONCAT(a.nombre,' ',a.apellido)) like upper('%{$filtro}%') or upper(a.correo_electronico) like upper('%{$filtro}%')) ";
}
if ($idmembresia != "todas") {
    $where .= "and f.idmembresia='{$idmembresia}' ";
}

$page = new sistema_paginacion('tblusuarios_externos a 
    left join tblmb_membresias b on (a.idmembresia=b.idmembresia)');
$page->set_campos("a.idusuario,CONCAT(a.nombre,' ',a.apellido) as nombre,a.correo_electronico,b.nombre as membresia,a.ip_habilitada");
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
$ca->prepareSelect("tblmb_membresias", "*");
$ca->exec();
$rMembresias = $ca->fetchAll();
?>

<html>
    <head>
        <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
        <style type="text/css">
            <!--
            body {
                margin-top: 0px;
                margin-bottom: 0px;
                margin-left: 0px;
                margin-right: 0px;
            }

            -->
        </style>

        <title>Lista de Usuarios - Membresias</title>

    </head>
    <body>
        <?php require_once("../../system_menu.php"); ?><br>

        <form action="usuarios_listar.php" method="post" name="formT">
            Membresia: <select id="idmembresia" name="idmembresia">
                <option value="todas" <?php echo $idmembresia == "todas" ? "selected" : ""; ?>>Todas</option>
                <?php foreach ($rMembresias as $r): ?>
                    <option
                        value="<?php echo $r["idmembresia"]; ?>" <?php echo $idmembresia == $r["idmembresia"] ? "selected" : ""; ?>><?php echo $r["nombre"]; ?></option>
                    <?php endforeach; ?>
            </select>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Filtro: <input id="filtro" name="filtro" type="text"/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <input TYPE="button" VALUE="Filtrar" onClick="var filtro = document.getElementById('filtro');
            var m = document.getElementById('idmembresia');
            window.location = 'usuarios_listar.php?idmembresia='+m.value+'&filtro='+filtro.value;"/>
        </form>

        <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="8" align="center" class="tituloFormulario">
                    <b>LISTA DE USUARIOS - MEMBRESIAS</b>
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
                <td bgcolor="#FEF1E2"><b>Membresia</b></td>
                <td bgcolor="#FEF1E2"><b>Ip habilitada</b></td>
                <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>
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
                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->membresia; ?></td>
                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row->ip_habilitada; ?></td>
                    <td bgcolor="<?php echo $ColorFila; ?>" align="center">
                        <a href="usuarios.php?Accion=Editar&Id=<?php echo $row->idusuario; ?>">
                            <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar"/>
                        </a>
                    </td>
                    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;</td>
                </tr>
                <?php
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
        </table>
        <br/><br/><br/><br/><br/>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="tablaCreditos">&copy; todos los derechos reservados por clickee &nbsp;&nbsp;
                    <a href="mailto:info@clickee.com" title="Esc&iacute;benos!!!" class="botonAbajo">info@clickee.com
                    </a> 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="http://www.clickee.com" title="Agencia que realiz&oacute; este Administrador de Contenidos..."
                        target="_blank" class="botonAbajo">www.clickee.com
                    </a>
                </td>
            </tr>
        </table>
    </body>
</html>
