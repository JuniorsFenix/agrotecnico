<?php
include("../../herramientas/seguridad/seguridad.php");
include ("../../vargenerales.php");
require_once("../../funciones_generales.php");

	$nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');

	$sql="select * from tblti_categorias where idcategoria = 0";
	$ra = mysqli_query($nConexion,$sql);
	if( mysqli_num_rows($ra) == 0 )
	{
		$sql="insert into tblti_categorias (idciudad,idcategoria,nombre,vpath,descripcion) values (1,-1,'--CATEGORIA PRINCIPAL--','/','')";
		$r = mysqli_query($nConexion, $sql);
		$sql="update tblti_categorias set idcategoria=0 where idcategoria=-1";
		$r = mysqli_query($nConexion, $sql);
	}
	$rs_contenidos = mysqli_query($nConexion,"SELECT * FROM tblti_categorias WHERE idcategoria<>0");
?>
<!DOCTYPE HTML>
<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" />  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>

		<title>Lista de Categorías</title>

  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
  <?php include("../../system_menu.php"); ?><br>
    <h1 class="tituloFormulario">LISTA DE CATEGORÍAS</h1>
	<a href="javascript:void(0);" class="btn outlined mleft_no reorder_link" id="save_reorder">Cambiar orden</a>
    <div id="reorder-helper" class="light_box" style="display:none;">1. Arrastre para ordenar.<br>2. Click en 'Guardar Orden' cuando termine.</div>
    <table id="listado" class="display hover cell-border" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Orden</th>
				<th>Id</th>
				<th>Nombre</th>
				<th>Descripción</th>
				<th>Path</th>
				<th>Seleccionar</th>
				<th>Productos</th>
			</tr>
		</thead>
        <tbody class="reorder_ul reorder-photos-list">
      <?php
        while($row = mysqli_fetch_object($rs_contenidos))
        {
        ?>
        <tr id="image_li_<?php echo $row->idcategoria; ?>" class="ui-sortable-handle">
          <td><?php echo "$row->orden"; ?></td>
          <td><?php echo "$row->idcategoria"; ?></td>
          <td><?php echo "$row->nombre"; ?></td>
          <td><div style="max-height:85px; overflow-y:scroll;"><?php echo "$row->metaDescripcion"; ?></div></td>
          <td><?php echo "$row->vpath"; ?></td>
          <td><a href="categorias.php?Accion=Editar&Id=<? echo "$row->idcategoria"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->idcategoria"; ?>"></a></td>
          <td><a href="listar_productos.php?idcategoria=<? echo "$row->idcategoria"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="">Ver productos</a></td>
        </tr>
        <?
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
                "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
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
        				$("#reorder-helper").html( "Reordenando entradas. Esto puede tomar un momento, por favor no salga de esta página" ).removeClass('light_box').addClass('notice notice_error');
        	
        				var h = [];
        				$("tbody.reorder-photos-list tr").each(function() {  h.push($(this).attr('id').substr(9));  });
        				$.ajax({
        					type: "POST",
        					url: "order_update_cat.php",
        					data: {ids: " " + h + ""},
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
        <td colspan="6" class="nuevo">
          <a href="categorias.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
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