<?php
	include("../../herramientas/seguridad/seguridad.php");
	include ("../../vargenerales.php");
  include("../../funciones_generales.php");

	$nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
  $rs_contenidos = mysqli_query($nConexion,"SELECT * FROM plantillas");
	
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

		<title>Lista de Plantillas</title>

  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
<?php include("../../system_menu.php"); ?><br>
    <h1 class="tituloFormulario">LISTA DE PLANTILLAS</h1>
    <table id="listado" class="display hover cell-border" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Archivo</th>
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
            <td><?php echo $row->idplantilla; ?></td>
            <td><?php echo $row->nombre; ?></td>
            <td><?php echo $row->estilo; ?></td>
            <td align="center"><a href="plantillas.php?Accion=Editar&Id=<?php echo $row->idplantilla; ?>"><img src="../../image/seleccionar.gif" border="0"></a></td>
	    	<td align="center"><a href="plantillas.php?Accion=Eliminar&Id=<?=$row->idplantilla;?>" onClick="return confirm('¿Seguro que desea eliminar este registro?');"><img src="../../image/borrar.gif" border="0" ></a></td>
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
                <a href="plantillas.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
                </td>
            </tr>
            <tr>
                <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
            </tr>
        </table>
  	</body>
</html>