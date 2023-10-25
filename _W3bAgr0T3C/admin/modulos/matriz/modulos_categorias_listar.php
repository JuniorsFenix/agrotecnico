<?php
  include("../../herramientas/seguridad/seguridad.php");
  include("../../herramientas/paginar/class.paginaZ.php");
  include("../../funciones_generales.php");

  $sitioCfg = sitioAssoc2();
  $home = $sitioCfg["url"];

  include("../../vargenerales.php");
  $IdCiudad = $_SESSION["IdCiudad"];
  $nId = $_GET["modulo"];
	$nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
	$sql = "SELECT * FROM tblmatriz WHERE idcategoria=$nId ";
	$Resultado = mysqli_query($nConexion,$sql);

	$sql    = mysqli_query($nConexion, "SELECT titulo, tabla FROM tblmatriz WHERE id=$nId" );
	$Registro     = mysqli_fetch_array($sql);
?>

<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" />  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>

		<title>Lista de modulos</title>


  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
<?php include("../../system_menu.php"); ?><br>

  <form action="modulos_listar.php" method="post">
  </form>
    <h1 class="tituloFormulario">Categorías</h1>
    <table id="listado" class="display hover cell-border" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Editar</th>
                <th>Ver contenidos</th>
            </tr>
        </thead>
        <tbody>
      <?php
        while($row = mysqli_fetch_array($Resultado)) {?>
	    <tr>
	    <td><?php echo $row["titulo"];?></td>
	    <td align="center"><img src="<?php echo $cRutaVerImgGeneral.$row["tabla"]."/p_".$row["imagen"]; ?>" height="80"/></td>
	    <td align="center"><a href="modulos_categorias_editar.php?id=<?php echo $row["id"];?>"><img src="../../image/seleccionar.gif" border="0" alt="Editar:<?php echo $row["titulo"];?>"></a></td>
	    <td align="center"><a href="modulos_listar.php?modulo=<?php echo $row["id"]?>">Ver</a></td>
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
	<br><br><br><br><br>
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
	</tr>
	</table>
  	</body>
</html>
