<?



  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  include("../../vargenerales.php");

  include_once("db.php");

  $IdCiudad = $_SESSION["IdCiudad"];

  $db = new DB();

?>





<html>

  <head>

    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

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

	



});

</script>

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





		<title>Lista de Fondos</title>









  </head>

  <body>

<? include("../../system_menu.php"); ?><br>





  <form action="fondos_listar.php" method="post">

  </form>





    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="9" align="center" class="tituloFormulario">

          <b>LISTA DE FONDOS</b>

          <br>

	<a href="javascript:void(0);" class="btn outlined mleft_no reorder_link" id="save_reorder">Ordenar Cabezotes</a>

    <div id="reorder-helper" class="light_box" style="display:none;">1. Arrastre para ordenar.<br>2. Click en 'Guardar Orden' cuando termine.</div>

        </td>

      </tr>

      <tr>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

	<td bgcolor="#FEF1E2"><b>Categoria</b></td>

        <td align="center" bgcolor="#FEF1E2"><b>Imagen</b></td>

        <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>

	<td bgcolor="#FEF1E2"><b>Eliminar</b></td>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

      </tr>

      </tbody>

        <tbody class="reorder_ul reorder-photos-list">

      <?



	$ContFilas = 0;

	$ColorFilaPar = "#FFFFFF";

	$ColorFilaImpar	= "#F0F0F0";

		$rows = $db->getRows();

		foreach($rows as $row):



	    $ContFilas = $ContFilas+ 1 ;

	    if ( fmod( $ContFilas,2 ) == 0 ) {



	      $ColorFila = $ColorFilaPar;

	    }



	    else {



	      $ColorFila = $ColorFilaImpar;

	    }



	    ?>

	    <tr id="image_li_<?php echo $row['idimagen']; ?>" class="ui-sortable-handle">

	    <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?php echo $row['idimagen']; ?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"><?php echo $row['nombre']; ?></td>

	    <td bgcolor="<? echo $ColorFila; ?>" align="center">

	    <?



	    if ( !empty($row['imagen']) ) {



	      ?><a target="_blank" href="<?php echo $cRutaImgFondos.$row['imagen'];?>">Ver</a>

	      <img src="<?php echo $cRutaImgFondos.$row['imagen'];?>" alt="" height="100" hspace="0" align="center" border="0" />

	    <?



	    }



	    else {



	      echo "No Asignada";

	    }



	    ?>

	    



	    </td>

	    <td bgcolor="<? echo $ColorFila; ?>" align="center"><a href="fondos.php?Accion=Editar&Id=<?php echo $row['idimagen'];?>">

	    <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<?php echo $row['imagen'];?>"></a></td>

	    <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="fondos.php?Accion=Eliminar&Id=<?php echo $row['idimagen'];?>" onClick="return confirm('¿Seguro que desea eliminar este registro?');">

	    <img src="../../image/borrar.gif" border="0" ></a></td>

	    <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>

	    </tr>

        <?php endforeach; ?>

        </tbody>

      <tr>

        <td colspan="9">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="9" class="nuevo">

          <a href="fondos.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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

