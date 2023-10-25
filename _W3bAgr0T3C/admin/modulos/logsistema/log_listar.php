<?
	include("../../funciones_generales.php");
  include("../../herramientas/seguridad/seguridad.php");
  include("../../herramientas/paginar/class.paginaZ.php");
	
	if ( isset( $_GET["cboModulo"] ) ) // Filtro por Modulo
	{
		$cWHERE = "WHERE modulo = '" . $_GET["cboModulo"] ."'";
		$cOrden = $_GET["cboOrdenar"] ." ". $_GET["cboOrdenarTipo"] ;
	}
	else
	{
		$cWHERE = "WHERE fecha_hora >= '" . $_GET["date"] ."'" ;
		$cOrden = $_GET["cboOrdenar"] ." ". $_GET["cboOrdenarTipo"] ;
	}
	
	
  $page=new sistema_paginacion('tbllog');
  $page->ordenar_por( $cOrden );
  $page->set_limite_pagina(8000);
	$page->set_condicion( $cWHERE );
  $result_page=$page->obtener_consulta();
  $page->set_color_tabla("#FEF1E2");
  $page->set_color_texto("black");
  $page->set_color_enlaces("black","#FF9900")
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
    <h1 class="tituloFormulario">LOG DEL SISTEMA</h1>
    <table id="listado" class="display hover cell-border" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><b>ID</b></th>
                <th><b>MODULO</b></th>
				<th><b>ACCI&Oacute;N</b></th>
				<th><b>USUARIO</b></th>
				<th><b>FECHA</b></th>
				<th><b>IP</b></th>
				<th><b>DESCRIPCI&Oacute;N</b></th>
            </tr>
        </thead>
        <tbody>
		  <?php while($row=mysqli_fetch_object($result_page)) { ?>
            <tr>
              	<td><?php echo "$row->id"; ?></td>
                <td><?php echo "$row->modulo"; ?></td>
                <td><?php echo "$row->accion"; ?></td>
                <td><?php echo "$row->usuario"; ?></td>
                <td><?php echo "$row->fecha_hora"; ?></td>
                <td><?php echo "$row->ip"; ?></td>
                <td><?php echo "$row->descripcion"; ?></td>
            </tr>
            <?
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
			<br>
			<a href="log_buscar.php"><img src="../../image/cancelar.gif" border="0"></a>
			<br><br><br><br><br>
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
			</tr>
			</table>
      
  	</body>
</html>