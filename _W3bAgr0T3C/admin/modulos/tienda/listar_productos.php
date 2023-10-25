<?php
require_once("../../herramientas/seguridad/seguridad.php");
require_once("../../funciones_generales.php");
$sitioCfg = sitioAssoc2();
$home = $sitioCfg["url"];
require_once ("../../vargenerales.php");
  $idcategoria=-1;
  if( isset($_GET["idcategoria"]) )
    $idcategoria = $_GET["idcategoria"];

  $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');

	$sql="SELECT * FROM tblti_productos";
  if($idcategoria!=-1){
	$sql.=" WHERE idcategoria=$idcategoria";
  }

	$rs_contenidos = mysqli_query($nConexion,$sql);
  
  $marcas=array();
  $r = mysqli_query($nConexion,"select * from tblti_marcas where idmarca<>0 order by nombre");
  while( $marca = mysqli_fetch_assoc($r) ){
    $marcas[ $marca["idmarca"] ] = $marca;
  }
  $categorias=array();
  $ra = mysqli_query($nConexion,"select * from tblti_categorias where idcategoria<>0 order by vpath");
  while( $categoria = mysqli_fetch_assoc($ra) ){
    $categorias[ $categoria["idcategoria"] ] = $categoria;
  }
  
  $imagenes=array();
  $ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
  while( $imagen = mysqli_fetch_assoc($ras) ){
    $imagenes[ $imagen["idproducto"] ] = $imagen;
	}
	
$permisos  = permisos("Productos");
?>
<!DOCTYPE HTML>
<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

		<title>Lista de Productos</title>

  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
  <?php include("../../system_menu.php"); ?><br>
    <h1 class="tituloFormulario">LISTA DE PRODUCTOS</h1>
	  Categoría:
	  <select name="idcategoria" onChange="location='?idcategoria='+this.value;">
	  <?php
	  foreach($categorias as $r){
		?><option value="<?=$r["idcategoria"];?>"  <?=$r["idcategoria"]==$idcategoria?"selected":"";?> ><?=$r["vpath"];?></option><?
	  }
	  ?>
	  </select><br>
	<a href="javascript:void(0);" class="btn outlined mleft_no reorder_link" id="save_reorder">Cambiar orden</a>
    <div id="reorder-helper" class="light_box" style="display:none;">1. Arrastre para ordenar.<br>2. Click en 'Guardar Orden' cuando termine.</div>
    <table id="listado" class="display hover cell-border" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Orden</th>
				<th>Nombre</th>
				<th>Descripción</th>
				<th>Precio</th>
				<th>Precio Ant.</th>
				<th>Marca</th>
				<th>Categoría</th>
				<th>Rating</th>
				<th>Deseos</th>
				<th>Imagen</th>
				<th>Seleccionar</th>
				<th>Vista previa</th>
			</tr>
		</thead>
        <tbody class="reorder_ul reorder-photos-list">
      <?php
        while($row = mysqli_fetch_object($rs_contenidos))
        {
            $result = mysqli_query($nConexion,"SELECT COUNT(*) AS total FROM tblti_wishlist WHERE idproducto=$row->idproducto");
            $deseos = mysqli_fetch_array($result);
            
			$sql="SELECT ROUND(AVG(rating),1) as averageRating FROM tblti_rating WHERE idproducto=$row->idproducto";
			$ra = mysqli_query($nConexion,$sql);
			$fetchAverage = mysqli_fetch_assoc($ra);
			$averageRating = $fetchAverage['averageRating'];
			if($averageRating <= 0){
				$averageRating = 0;
			}
        ?>
        <tr id="image_li_<?php echo $row->idproducto; ?>" class="ui-sortable-handle">
          <td><?php echo "$row->orden"; ?></td>
          <td><?php echo "$row->nombre"; ?></td>
          <td><?php echo $row->metaDescripcion; ?></td>
          <td><?php echo $row->precio; ?></td>
          <td><?php echo $row->precioant; ?></td>
          <td><?php echo $marcas[$row->idmarca]["nombre"]; ?></td>
          <td><?php echo $categorias[$row->idcategoria]["nombre"]; ?></td>
          <td><?php echo $averageRating; ?></td>
          <td><?php echo $deseos[0]; ?> <a href="<?php echo "usuarios-deseos.php?id=$row->idproducto"; ?>">Ver</a></td>
          <td>
			<?php
			if ( isset( $imagenes[$row->idproducto]["imagen"] ) )
			{
			?><img src="../../../fotos/tienda/productos/p_<? echo $imagenes[$row->idproducto]["imagen"];?>" height="50px">
			<?	
			}
			else{
			?>
			<img src="../../image/default.jpg" alt="<?=$row->nombre;?>" height="50px"/>
			<?	
			}
			?>
		</td>
          <td><?php if($permisos["editar"]==1):?><a href="productos.php?Accion=Editar&Id=<? echo "$row->idproducto"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->idproducto"; ?>"></a><?php endif;?></td>
          <td><a href="<?php echo "$home/productos/$row->url"; ?>" target="_blank">Ver</a></td>
        </tr>
        <?
        }
      ?>
        </tbody>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <?php if($permisos["crear"]==1):?>
        <tr>
            <td colspan="8" class="nuevo">
              <a href="productos.php?Accion=Adicionar&idcategoria=<?=$idcategoria;?>"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
            </td>
        </tr>
    <?php endif;?>
    </table>
    <br><br><br><br><br>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
        </tr>
    </table>
     <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>
    <script>
     $(document).ready(function() {
    	$('#listado').DataTable( {
            dom: 'Bfrtip',
    		"sScrollY": '100%',
    		"sScrollX": '100%',
    		"bScrollCollapse": true,
    		"bRetrieve": true,
      		"pageLength": 50,
              buttons:[{
                extend: 'excelHtml5',
                title: 'Listado de productos',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8]
                }
              }],
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
    						data: {ids: " " + h + "", categoria: "<?php echo $idcategoria ?>"},
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
    </body>
</html>
