<?php

include("../../herramientas/seguridad/seguridad.php");

include("../../herramientas/paginar/class.paginaZ.php");

include ("../../vargenerales.php");

require_once("../../funciones_generales.php");





$rEstados = array(array("idestado" => "CARRO", "nombre" => "Carro"),
    array("idestado" => "ENVIADA", "nombre" => "Enviada"),
    array("idestado" => "COTIZADO", "nombre" => "Cotizado"),
    array("idestado" => "Aprobada", "nombre" => "Aprobada"),
    array("idestado" => "Rechazada", "nombre" => "Rechazada")

);





$filtro = isset($_GET["filtro"]) ? $_GET["filtro"] : "";

$idestado = isset($_GET["idestado"]) ? $_GET["idestado"] : "todos";



$where = "where 1=1 ";

if ($filtro != "") {

    $where .= "and (upper(a.nombre) like upper('%{$filtro}%') or upper(a.direccion) like upper('%{$filtro}%')

    or upper(a.ciudad) like upper('%{$filtro}%') or upper(a.telefono) like upper('%{$filtro}%')) ";

}

if ($idestado != "todos") {

    $where .= "and a.estado='{$idestado}' ";

}





$nConexion = Conectar();



$page = new sistema_paginacion('tblti_carro a');

//$page->set_condicion("where idcategoria<>0");

$page->ordenar_por('carro desc');

$page->set_condicion($where);

$page->set_limite_pagina(20);

$rs_contenidos = $page->obtener_consulta();

$page->set_color_tabla("#FEF1E2");

$page->set_color_texto("black");

$page->set_color_enlaces("black", "#FF9900")

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

        <? include("../../system_menu.php"); ?><br/>





        <form action="listar_pedidos.php" method="post" name="formT">

            Estado: <select id="idestado" name="idestado">

                <option value="todos" <?php echo $idestado == "todos" ? "selected" : ""; ?>>Todos</option>

                <?php foreach ($rEstados as $r): ?>

                    <option value="<?php echo $r["idestado"]; ?>" <?php echo $estado == $r["idestado"] ? "selected" : ""; ?>><?php echo $r["nombre"]; ?></option>

                <?php endforeach; ?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Filtro: <input id="filtro" name="filtro" type="text"/>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;



            <input TYPE="button" VALUE="Filtrar" onClick="var filtro = document.getElementById('filtro');

            var e = document.getElementById('idestado');

            window.location = 'listar_pedidos.php?idestado='+e.value+'&filtro='+filtro.value;"/>

        </form>





        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td colspan="10" align="center" class="tituloFormulario">

            <center>

                <b>LISTA DE PEDIDOS</b>

                <br>

                <? $page->mostrar_numero_pagina() ?><br>

            </center>

        </td>

    </tr>

    <tr>

        <td bgcolor="#FEF1E2"><b>Id</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>

        <td bgcolor="#FEF1E2"><b>Nombre</b></td>

        <td bgcolor="#FEF1E2"><b>Direccion</b></td>

        <td bgcolor="#FEF1E2"><b>Ciudad</b></td>

        <td bgcolor="#FEF1E2"><b>Telefono</b></td>

        <td bgcolor="#FEF1E2"><b>Medio de pago</b></td>

        <td bgcolor="#FEF1E2"><b>Estado</b></td>

        <td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>

        <td bgcolor="#FEF1E2" align="center"><b>Productos</b></td>

    </tr>

    <?

    $ContFilas = 0;

    $ColorFilaPar = "#FFFFFF";

    $ColorFilaImpar = "#F0F0F0";

    while ($row = mysqli_fetch_object($rs_contenidos)) {

        $ContFilas = $ContFilas + 1;

        if (fmod($ContFilas, 2) == 0) { // Si devuelve cero el numero es par

            $ColorFila = $ColorFilaPar;

        } else {

            $ColorFila = $ColorFilaImpar;

        }

        ?>

        <tr>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->carro"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fecha"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nombre"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->direccion"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->destino_descripcion"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->telefono"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->medio"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->estado"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="pedidos.php?Accion=Editar&Id=<? echo "$row->carro"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->carro"; ?>"></a></td>

            <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="listar_pedidos_detalle.php?carro=<? echo "$row->carro"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="">Ver productos</a></td>

        </tr>

    <?

}

?>

    <tr>

        <td colspan="10"><? $page->mostrar_enlaces(); ?></td>

    </tr>

    <tr>

        <td colspan="10">&nbsp;</td>

    </tr>

</table>

<br><br><br><br><br>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

    <tr>

        <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

    </tr>

</table>

</body>

</html>









