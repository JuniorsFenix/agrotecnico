<?php
require_once("../../herramientas/seguridad/seguridad.php");
require_once("../../funciones_generales.php");
$sitioCfg = sitioAssoc2();
$home = $sitioCfg["url"];
require_once ("../../vargenerales.php");

  if(empty($_GET["id"])){
	header("Location: listar_productos.php");
	exit;
  }
  $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');

	$sql="SELECT nombre, correo_electronico, telefono FROM tblusuarios_externos WHERE idusuario IN (SELECT idusuario FROM tblti_wishlist WHERE idproducto={$_GET["id"]})";
	$rs_contenidos = mysqli_query($nConexion,$sql);
	
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

		<title>Lista de Usuarios</title>

  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
  <?php include("../../system_menu.php"); ?><br>
    <h1 class="tituloFormulario">LISTA DE USUARIOS</h1>
    <table id="listado" class="display hover cell-border" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Correo</th>
				<th>Teléfono</th>
			</tr>
		</thead>
        <tbody>
      <?php
        while($row = mysqli_fetch_object($rs_contenidos)){?>
        <tr>
          <td><?php echo $row->nombre; ?></td>
          <td><?php echo $row->correo_electronico; ?></td>
          <td><?php echo $row->telefono; ?></td>
        </tr>
        <?
        }
      ?>
        </tbody>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="8" class="nuevo">
              <a href="listar_productos.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
            </td>
        </tr>
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
                title: 'Listado de usuarios'
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
    	} );
    </script>
    </body>
</html>
