<?php
  include("../../herramientas/seguridad/seguridad.php");
  include("../../funciones_generales.php");
	include("../../vargenerales.php");

	$IdCiudad = $_SESSION["IdCiudad"];

	$nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $tags = mysqli_query($nConexion,"SELECT * FROM tbltags_palabras WHERE idciudad=$IdCiudad");
	echo mysqli_error($nConexion);
	$permisos  = permisos("Tags");
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

		<title>Lista de Tags/Palabras</title>

  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
<?php include("../../system_menu.php"); ?><br>
    <h1 class="tituloFormulario">LISTA TAGS/PALABRAS</h1>
    <table id="listado" class="display hover cell-border compact" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tag</th>
                <th>Keyword</th>
                <th>Seleccionar</th>
            </tr>
        </thead>
        <tbody>
      <?php
        while( $row = mysqli_fetch_object( $tags ) )
        {
			$tag="X";
			$keyword="X";
			if($row->tag==1){
				$tag="✓";
			}
			if($row->keyword==1){
				$keyword="✓";
			}
        ?>
        <tr>
          <td align="left"><? echo "$row->nombre"; ?></td>
          <td><? echo $tag; ?></td>
		  <td><? echo $keyword; ?></td>
          <td><?php if($permisos["editar"]==1):?><a href="tags.php?Accion=Editar&Id=<? echo "$row->idpalabra"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->titulo"; ?>"></a><?php endif;?></td>
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
				"pageLength": 25,
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
        <td colspan="4">&nbsp;</td>
      </tr>
      <?php if($permisos["crear"]==1):?>
      <tr>
        <td colspan="4" class="nuevo">
          <a href="tags.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
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
  	</body>
</html>