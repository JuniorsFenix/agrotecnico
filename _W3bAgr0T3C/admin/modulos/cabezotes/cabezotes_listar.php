<?php
  include("../../herramientas/seguridad/seguridad.php");
require_once("../../herramientas/paginar/dbquery.inc.php");
  include("../../funciones_generales.php");
  include("../../vargenerales.php");
	include_once("db.php");
  $IdCiudad = $_SESSION["IdCiudad"];
	$db = new DB();
    $idcategoria = $_GET["idcategoria"];
  
  	$categorias = array();
	$nConexion = Conectar();
$permisos  = permisos("Cabezotes");
?>
<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<title>Lista de Cabezotes</title>
  </head>
  <body>
<?php include("../../system_menu.php"); ?><br>
  <form action="cabezotes_listar.php" method="post">
  <input type="hidden" name="categoria" value="<?php echo $idcategoria ?>">
  </form>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
    	<tbody>
      <tr>
        <td colspan="10" align="center" class="tituloFormulario">
          <b>LISTA DE CABEZOTES</b> Categoria:
          <select name="idcategoria" onChange="location='?idcategoria='+this.value;">
          <?php 
			$ca = new DbQuery($nConexion);
			$ca->prepareSelect("tblcabezotes_categorias","*","","nombre");
			$ca->exec();
			$categorias = $ca->fetchAll();
		  foreach ( $categorias as $r):?>
           <option value="<?=$r["idcategoria"];?>"  <?=$r["idcategoria"]==$idcategoria?"selected":"";?> ><?=$r["nombre"];?></option>
          <?php endforeach;?>
          </select>
          <br>
	<a href="javascript:void(0);" class="btn outlined mleft_no reorder_link" id="save_reorder">Ordenar Cabezotes</a>
    <div id="reorder-helper" class="light_box" style="display:none;">1. Arrastre para ordenar.<br>2. Click en 'Guardar Orden' cuando termine.</div>
        </td>
      </tr>
      <tr>
	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>
    <td bgcolor="#FEF1E2"><b>Id.</b></td>
    <td bgcolor="#FEF1E2"><b>Descripcion</b></td>
	<td bgcolor="#FEF1E2"><b>Categoria</b></td>
	<td bgcolor="#FEF1E2"><b>URL</b></td>
	<td bgcolor="#FEF1E2"><b>Target</b></td>
	<td bgcolor="#FEF1E2"><b>Archivo</b></td>
    <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>
    <td align="center" bgcolor="#FEF1E2"><b>Imagen</b></td>
	<td bgcolor="#FEF1E2"><b>Eliminar</b></td>
	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>
      </tr>
      </tbody>
        <tbody class="reorder_ul reorder-photos-list">
      <?php
	$ContFilas = 0;
	$ColorFilaPar = "#FFFFFF";
	$ColorFilaImpar	= "#F0F0F0";
			$rows = $db->getRows($idcategoria);
			foreach($rows as $row):
	    $ContFilas = $ContFilas+ 1 ;
	    if ( fmod( $ContFilas,2 ) == 0 ) {
	      $ColorFila = $ColorFilaPar;
	    }
	    else {
	      $ColorFila = $ColorFilaImpar;
	    }
	    ?>
	    <tr id="image_li_<?php echo $row['idcabezote']; ?>" class="ui-sortable-handle">
	    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;</td>
	    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row['idcabezote']; ?></td>
	    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row['descripcion']; ?></td>
	    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row['nombre']; ?></td>
	    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row['url']; ?></td>
	    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row['target']; ?></td>
	    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row['archivo']; ?></td>
	    <td bgcolor="<?php echo $ColorFila; ?>" align="center"><?php if($permisos["editar"]==1):?><a href="cabezotes.php?Accion=Editar&Id=<?php echo $row['idcabezote'];?>">
	    <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<?php echo $row['archivo'];?>"></a><?php endif;?></td>
	    <td bgcolor="<?php echo $ColorFila; ?>" align="center">
	    <?php
	    if ( !empty($row['archivo']) ) {
	      ?><a target="_blank" href="<?php echo $cRutaImgCabezotesjq.$row['archivo'];?>">Ver</a>
	      <img src="<?php echo $cRutaImgCabezotesjq.$row['archivo'];?>" alt="" width="100" height="100" hspace="0" align="center" border="0" />
	    <?php
	    }
	    else {
	      echo "No Asignada";
	    }
	    ?>    
	    </td>
	    <td bgcolor="<?php echo $ColorFila; ?>"align="center"><?php if($permisos["eliminar"]==1):?><a href="cabezotes.php?Accion=Eliminar&Id=<?php echo $row['idcabezote'];?>" onClick="return confirm('¿Seguro que desea eliminar este registro?');">
	    <img src="../../image/borrar.gif" border="0" ></a><?php endif;?></td>
	    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;</td>
	    </tr>
        <?php endforeach; ?>
        </tbody>
      <tr>
        <td colspan="10">&nbsp;</td>
      </tr>
      <?php if($permisos["crear"]==1):?>
      <tr>
        <td colspan="10" class="nuevo">
          <a href="cabezotes.php?Accion=Adicionar&Id=<?php echo $idcategoria;?>"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
	    <a href="categorias_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script type="text/javascript">
$(document).ready(function(){
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
	
});
</script>
  	</body>
</html>
