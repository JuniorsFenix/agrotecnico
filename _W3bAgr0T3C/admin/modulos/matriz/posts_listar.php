<?php
	require_once("../../herramientas/seguridad/seguridad.php");
	require_once("../../herramientas/paginar/class.paginaZ.php");
	require_once ("../../vargenerales.php");
	$IdCiudad = $_SESSION["IdCiudad"];
	$page=new sistema_paginacion('wp_posts');
	$page->set_condicion( "WHERE post_type = 'post' and post_status !='auto-draft' and post_status !='trash' and post_status !='draft'" );
	$page->set_limite_pagina(400);
	$rs_contenidos=$page->obtener_consulta();
	$page->set_color_tabla("#FEF1E2");
	$page->set_color_texto("black");
	$page->set_color_enlaces("black","#FF9900");
	
?>

<!DOCTYPE HTML>
<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
    <link href="../../css/data.table.css" rel="stylesheet" type="text/css" />
	<link href="../../css/jqueryui.css" rel="stylesheet" type="text/css" />  
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  </head>
  <body>
<?php require_once("../../system_menu.php"); ?><br>
    <h1 class="tituloFormulario">LISTA DE CONTENIDOS GENERALES</h1>
    <table class="display datatable" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Titulo</th>
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
		<script type="text/javascript" src="../../herramientas/DataTables/jquery.dataTables.min.js"></script>
        <script>
         $(document).ready(function() {
                var oTable = $('.datatable').dataTable( {
                        "bJQueryUI": true,
                        "sScrollX": "",
                        "bSortClasses": false,
                        "aaSorting": [[0,'asc']],
                        "bAutoWidth": true,
                        "bInfo": true,
                        "sScrollY": "100%",	
                        "sScrollX": "100%",
                        "bScrollCollapse": true,
                        "sPaginationType": "full_numbers",
                        "bRetrieve": true,
                        "oLanguage": {
                                        "sSearch": "Búsqueda:",
                                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                                        "sInfoEmpty": "Información vacia",
                                        "sZeroRecords": "<?=DT_ZERORECORD?>",
                                        "sInfoFiltered": "(<?=DT_FILTER1?> _MAX_ <?=DT_FILTER2?>)",
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
                <a href="wp-admin/post-new.php?wtlwp_token=84ade2f76256a66e1e0cc5a392dc5275"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
                </td>
            </tr>
            <tr>
                <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
            </tr>
        </table>
  	</body>
</html>