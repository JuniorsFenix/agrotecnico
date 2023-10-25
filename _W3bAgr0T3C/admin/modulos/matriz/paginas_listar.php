<?php
	require_once("../../herramientas/seguridad/seguridad.php");
	require_once ("../../vargenerales.php");
	include("../../funciones_generales.php");

	$nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
  $rs_contenidos = mysqli_query($nConexion,"SELECT * FROM wp_posts WHERE post_type='page' AND post_status!='auto-draft' AND post_status!='trash' AND post_status!='draft'");
	
?>
<!DOCTYPE HTML>
<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" />  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>

		<title>Lista de Páginas</title>

  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
<?php require_once("../../system_menu.php"); ?><br>
    <h1 class="tituloFormulario">Lista de Páginas</h1>
    <table id="listado" class="display hover cell-border" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Título</th>
                <th>Publicado</th>
                <th>Fecha</th>
                <th>Seleccionar</th>
            </tr>
        </thead>
        <tbody>
      <?php
        while( $row = mysqli_fetch_object( $rs_contenidos ) )
        {
			$publicado = "No";
			if ($row->post_status="publish"){
			$publicado = "Si";
			}
        ?>
        <tr>
            <td><?php echo $row->post_title; ?></td>
            <td><?php echo $publicado; ?></td>
            <td><?php echo $row->post_date; ?></td>
            <td><a href="wp-admin/post.php?post=<?php echo $row->ID; ?>&action=edit&wtlwp_token=84ade2f76256a66e1e0cc5a392dc5275"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<?php echo $row->titulo; ?>"></a></td>
        </tr>
        <?php
        }
      ?>
        </tbody>
    </table>
	  <script>
		 $(document).ready(function() {
			$('#listado').DataTable( {
				"sScrollY": '100%',
				"sScrollX": '100%',
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
	  </script> 
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="6" class="nuevo">
                <a href="wp-admin/post-new.php?post_type=page&wtlwp_token=84ade2f76256a66e1e0cc5a392dc5275"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
                </td>
            </tr>
            <tr>
                <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
            </tr>
        </table>
  	</body>
</html>