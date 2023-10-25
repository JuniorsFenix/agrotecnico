<?php
  include("../../herramientas/seguridad/seguridad.php");
  include("../../funciones_generales.php");
  include("../../vargenerales.php");

	$nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
  $rsCategorias = mysqli_query($nConexion,"SELECT * FROM tblmatriz");
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

		<title>Lista de Categorias</title>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
<?php include("../../system_menu.php"); ?><br>
    <h1 class="tituloFormulario">LISTA DE CATEGORIAS</h1>
    <table id="listado" class="display hover cell-border" cellspacing="0" width="100%">
		<thead>
			<tr>
				<td bgcolor="#FEF1E2"><b>Id.</b></td>
				<td bgcolor="#FEF1E2"><b>Nombre</b></td>
				<td bgcolor="#FEF1E2"><b>Tabla</b></td>
				<td bgcolor="#FEF1E2"><b>Tipo</b></td>
				<td bgcolor="#FEF1E2"><b>Seleccionar</b></td>
				<td bgcolor="#FEF1E2"><b>Eliminar</b></td>
			</tr>
		</thead>
        <tbody>
      <?php
        while($row=mysqli_fetch_object($rsCategorias))
		{
			$tipo="Contenido";
			if($row->tipo==2)
			{
				$tipo="Formulario";
			}
	    ?>
	    <tr>
			<td><?=$row->id; ?></td>
			<td><?=$row->titulo; ?></td>
			<td><?=$row->tabla; ?></td>
			<td><?=$tipo; ?></td>
			<td align="center"><a href="categorias.php?Accion=Editar&Id=<?=$row->id;?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar"></a></td>
			<td align="center"><a href="categorias.php?Accion=Eliminar&Id=<?=$row->id;?>" onClick="return confirm('¿Seguro que desea eliminar este registro?');"><img src="../../image/borrar.gif" border="0" ></a></td>
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
			<td colspan="12" class="nuevo">
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
