<?php
require_once("../../herramientas/seguridad/seguridad.php");
require_once("../../herramientas/paginar/class.paginaZ.php");
require_once("../../vargenerales.php");
require_once("../../funciones_generales.php");;
$IdCiudad = $_SESSION["IdCiudad"];
$page=new sistema_paginacion('perfiles');
if($_SESSION["UsrPerfil"]!=1){
	$page=new sistema_paginacion('perfiles');
	$page->set_condicion( 'WHERE id!=1' );
}
$page->set_limite_pagina(400);
$rs_contenidos=$page->obtener_consulta();
$page->set_color_tabla("#FEF1E2");
$page->set_color_texto("black");
$page->set_color_enlaces("black","#FF9900");
$permisos  = permisos("Perfiles");
	
?>

<html>
  <head>
        <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>
  </head>
  <body>
<? include("../../system_menu.php"); ?><br>
    <h1 class="tituloFormulario">LISTA DE PERFILES</h1>
    <table id="listado" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Perfil</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
      <?php
        while( $row = mysqli_fetch_object( $rs_contenidos ) )
        {
        ?>
        <tr>
            <td><?php echo $row->id; ?></td>
            <td><?php echo $row->perfil; ?></td>
            <td align="center"><?php if($permisos["editar"]==1):?><a href="perfiles.php?Accion=Editar&Id=<?php echo $row->id; ?>"><img src="../../image/editar.png" border="0" alt="Editar" width="15px"></a><?php endif;?></td>
            <td align="center"><?php if($row->id!=1):?><?php if($permisos["eliminar"]==1):?><a class="eliminar" href="perfiles.php?Accion=Eliminar&Id=<?php echo $row->id; ?>"><img src="../../image/eliminar.png" border="0" alt="Eliminar" width="15px"></a><?php endif;?><?php endif;?></td>
        </tr>
        <?php
        }
      ?>
        </tbody>
    </table>
	<script>
		$(document).ready(function() {
			$('#listado').DataTable( {
				"sScrollY": 400,
				"sScrollX": true,
				"bScrollCollapse": true,
				"bRetrieve": true,
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
		$('.eliminar').on('click', function () {
			return confirm('¿Está seguro de que desea eliminar permanentemente esta entrada?');
		});
	</script>  
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
        	<?php if($permisos["crear"]==1):?>
            <tr>
                <td colspan="6" class="nuevo">
                <a href="perfiles.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
                </td>
            </tr>
        	<?php endif;?>
            <tr>
                <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
            </tr>
        </table>
  	</body>
</html>