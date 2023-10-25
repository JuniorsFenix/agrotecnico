<?php
require_once("../../herramientas/seguridad/seguridad.php");
require_once("../../herramientas/paginar/class.paginaZ.php");
require_once ("../../vargenerales.php");
require_once("../../funciones_generales.php");
$page = new sistema_paginacion('tblusuarios');
$page->ordenar_por('nombres');
$page->set_limite_pagina(20);
$result_page = $page->obtener_consulta();
$page->set_color_tabla("#FEF1E2");
$page->set_color_texto("black");
$page->set_color_enlaces("black", "#FF9900");
?>
<html>
    <head>
        <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>
	<style type="text/css">
			.siglas{
				width: 35px;
				height: 35px;
				text-align: center;
				color: #FFF;
				display: inline-block;
				border-radius: 50%;
				font-size: 1.3em;
				padding-top: 7px;
				box-sizing: border-box;
			}
		</style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <?php include("../../system_menu.php"); ?><br>
    <h1 class="tituloFormulario">LISTA DE USUARIOS</h1> 
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="6" class="nuevo">
			<a href="perfiles.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
			</td>
		</tr>
	</table>
    <table id="listado" class="display hover cell-border" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Cargo</th>
                <th>Cédula</th>
                <th>Correo</th>
                <th>Firma</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_object($result_page)) { ?>
                <tr>
                    <td><?php echo $row->nombres; ?></td>
                    <td><?php echo $row->cargo; ?></td>
                    <td><?php echo $row->cedula; ?></td>
                    <td><?php echo $row->correo_electronico; ?></td>
					<td align="center">
					<?php
					if ( !empty( $row->firma ) )
					{
						echo "<a href='$cRutaVerFirmas{$row->firma}' target='_blank'>Ver</a>";
					}
					else
					{
						echo "No Asignada";
					}
					?>
					</td>
                    <td align="center"><a href="usuarios.php?Accion=Editar&Id=<?php echo "$row->idusuario"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<?php echo "$row->nombres"; ?>"></a>
                    </td>
                </tr>
				<?php } ?>
        </tbody>
    </table>
	<script>
		$(document).ready(function() {
			$('#listado').DataTable( {
				"sScrollY": 400,
				"sScrollX": true,
				"bScrollCollapse": true,
				"bRetrieve": true,
        		"order": [[ 1, "asc" ]],
				"oLanguage": {
					"sSearch": "Búsqueda:",
					"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
					"sInfoEmpty": "Información vacia",
					"sZeroRecords": "No hay entradas",
					"sEmptyTable": "No hay entradas",
					"sLengthMenu": "Mostrar _MENU_ entradas",
					"oPaginate": {
						"sFirst":    "Primero",
						"sPrevious": "Anterior",
						"sNext":     "Siguiente",
						"sLast":     "Último"
						  }
					 }
				} );
		} );
	</script> 
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="6" class="nuevo">
                    <a href="usuarios.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
                </td>
            </tr>
            <tr>
                <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
            </tr>
        </table>
    </body>
</html>
