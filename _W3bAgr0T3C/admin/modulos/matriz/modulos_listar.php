<?php
  include("../../herramientas/seguridad/seguridad.php");
  include("../../herramientas/paginar/class.paginaZ.php");
  include("../../funciones_generales.php");
  include("../../vargenerales.php");
  $IdCiudad = $_SESSION["IdCiudad"];
  $nId = $_GET["modulo"];
	$nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
	$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE id = '$nId'" );
	$Registro     = mysqli_fetch_array( $Resultado );
	$campos    = mysqli_query($nConexion, "SELECT cm.* FROM campos ca JOIN campos_matriz cm on (ca.campo=cm.campo) WHERE cm.idmatriz = '$nId' ORDER BY cm.id ASC" );
	$tabla = $Registro["tabla"];
?>

<!DOCTYPE HTML>
<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" />  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

		<title>Lista de modulos</title>


  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
<?php include("../../system_menu.php"); ?><br>
	  
    <h1 class="tituloFormulario"><?=$Registro["titulo"]?></h1>
	<a href="javascript:void(0);" class="btn outlined mleft_no reorder_link" id="save_reorder">Cambiar orden</a>
    <div id="reorder-helper" class="light_box" style="display:none;">1. Arrastre para ordenar.<br>2. Click en 'Guardar Orden' cuando termine.</div>
    <table id="listado" class="display hover cell-border" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Orden</th>
                <th>Id</th>
				<?php while($r = mysqli_fetch_assoc($campos)): $camposA[] = $r["campo"];?><th><?php echo $r["campo"];?></th><?php endwhile; ?>
                <th>Publicado</th>
                <th>Seleccionar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody class="reorder_ul reorder-photos-list">
      <?php
	  $columns = "orden, id, ";
		$columns.= implode(', ', $camposA);
		$columns.= ", publicar";
		$result_page    = mysqli_query($nConexion, "SELECT $columns FROM `$tabla`" );
        while($row = mysqli_fetch_object($result_page)) {?>
	    <tr id="image_li_<?php echo $row->id; ?>" class="ui-sortable-handle">
        <?php foreach ($row as $data)  
      {  
        echo "<td>".substr(strip_tags($data),0,150)."</td>";  
      } ?>
	    <td><a href="modulos.php?Accion=Editar&amp;modulo=<?php echo $Registro["id"]?>&amp;Id=<?php echo $row->id;?>">
	    <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<?=$row->archivo;?>"></a></td>
	    <td><a href="modulos.php?Accion=Eliminar&amp;modulo=<?php echo $Registro["id"]?>&amp;Id=<?php echo $row->id;?>" onClick="return confirm('¿Seguro que desea eliminar este registro?');">
	    <img src="../../image/borrar.gif" border="0" ></a></td>
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
var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
};
	$('.reorder_link').on('click',function(){
		$("tbody.reorder-photos-list").sortable({ tolerance: 'pointer', helper: fixHelper });
		$('.reorder_link').html('guardar orden');
		$('.reorder_link').attr("id","save_reorder");
		$('#reorder-helper').slideDown('slow');
		$('.ui-sortable-handle').css("cursor","move");
		$("#save_reorder").click(function( e ){
			if( !$("#save_reorder i").length )
			{
				$(this).html('').prepend('<img src="images/refresh-animated.gif"/>');
				$("tbody.reorder-photos-list").sortable('destroy');
				$("#reorder-helper").html( "Reordenando fotos. Esto puede tomar un momento, por favor no salga de esta página" ).removeClass('light_box').addClass('notice notice_error');
	
				var h = [];
				$("tbody.reorder-photos-list tr").each(function() {  h.push($(this).attr('id').substr(9));  });
				$.ajax({
					type: "POST",
					url: "order_update.php",
					data: {ids: " " + h + "", tabla: "<?php echo $tabla ?>"},
					success: function(html) 
					{
						window.location.reload();
						/*$("#reorder-helper").html( "Reorder Completed - Image reorder have been successfully completed. Please reload the page for testing the reorder." ).removeClass('light_box').addClass('notice notice_success');
						$('.reorder_link').html('reorder photos');
						$('.reorder_link').attr("id","");*/
					}
					
				});	
				return false;
			}	
			e.preventDefault();		
		});
	});
			} );
	  </script>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="11" class="nuevo">
          <a href="modulos.php?Accion=Adicionar&amp;modulo=<?php echo $Registro["id"]?>"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
        </td>
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
