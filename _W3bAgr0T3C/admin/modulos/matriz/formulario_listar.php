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
	$campos    = mysqli_query($nConexion, "SELECT * FROM campos_form WHERE idform = '$nId' ORDER BY idcampo ASC" );
	$tabla = $Registro["tabla"];
	
	if(isset($_GET["Accion"])){
		$setCounter = 0;
		$setExcelName = $tabla;
		$setSql = "SELECT * FROM `$tabla`";
		$setRec = mysqli_query($nConexion,$setSql);
		$setCounter = mysqli_num_fields($setRec);
		
		for ($i = 0; $i < $setCounter; $i++) {
			$setMainHeader .= mysqli_field_name($setRec, $i)."\t";
		}
		
		while($rec = mysqli_fetch_row($setRec))  {
		  $rowLine = '';
		  foreach($rec as $value)       {
			if(!isset($value) || $value == "")  {
			  $value = "\t";
			}   else  {
		//It escape all the special charactor, quotes from the data.
			  $value = strip_tags(str_replace('"', '""', $value));
			  $value = '"' . $value . '"' . "\t";
			}
			$rowLine .= $value;
		  }
		  $setData .= trim($rowLine)."\n";
		}
		  $setData = str_replace("\r", "", $setData);
		
		if ($setData == "") {
		  $setData = "no matching records found";
		}
		
		$setCounter = mysqli_num_fields($setRec);
		
		
		
		//This Header is used to make data download instead of display the data
		 header("Content-type: application/vnd.ms-excel");
		
		header("Content-Disposition: attachment; filename=".$setExcelName.".xls");
		
		//It will print all the Table row as Excel file row with selected column name as header.
		echo $setData;
	}
?>

<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
	<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" />
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

		<title>Lista de modulos</title>


  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
<?php include("../../system_menu.php"); ?><br>

  <form action="modulos_listar.php" method="post">
  </form>
    <h1 class="tituloFormulario"><?=$Registro["titulo"]?></h1>
    <table id="listado" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Fecha</th>
				<?php while($r = mysqli_fetch_assoc($campos)): $camposA[] = $r["campo"];?><th><?php echo $r["campo"];?></th><?php endwhile; ?>
            </tr>
        </thead>
        <tbody>
      </tr>
      <?php
	  $columns = "`fecha`, `";
		$columns .= implode('`, `', $camposA);
	  $columns.= "`";
		$page=new sistema_paginacion("`$tabla`");
		$page->set_campos($columns);
		$page->set_limite_pagina(500);
		$result_page=$page->obtener_consulta();
        while($row = mysqli_fetch_object($result_page)) {?>
	    <tr>
        <?php foreach ($row as $data)  
      {  
        echo "<td>$data</td>";  
      } ?>
	    </tr>
        <?php
        }
      ?>
        </tbody>
    </table>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>
	  <script>
		 $(document).ready(function() {
			$('#listado').DataTable( {
				"sScrollX": true,
				"bScrollCollapse": true,
				"bRetrieve": true,
        		"order": [[ 0, "desc" ]],
				"iDisplayLength": 25,
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
        <td colspan="11" class="nuevo">
          <a href="formulario_configurar.php?modulo=<?php echo $Registro["id"]?>">Configuración</a>  
          <a href="formulario_listar.php?Accion=Exportar&amp;modulo=<?php echo $Registro["id"]?>">Exportar</a>
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
