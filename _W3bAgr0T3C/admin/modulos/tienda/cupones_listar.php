<?php
  include("../../herramientas/seguridad/seguridad.php");
  include("../../herramientas/paginar/class.paginaZ.php");
  include ("../../vargenerales.php");
  require_once("../../funciones_generales.php");

  $idcategoria=-1;
  if( isset($_GET["idcategoria"]) )
    $idcategoria = $_GET["idcategoria"];

  $nConexion = Conectar();

  $page=new sistema_paginacion('tblti_cupones');
  $page->set_limite_pagina(200);
  $rs_contenidos=$page->obtener_consulta();
  $page->set_color_tabla("#FEF1E2");
  $page->set_color_texto("black");
  $page->set_color_enlaces("black","#FF9900");

?>

<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
	body,td,th {
    font-family: Raleway, sans-serif;
}
    </style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  	<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body>

  <?php include("../../system_menu.php"); ?><br/>
    <h1 class="tituloFormulario">LISTA DE CUPONES</h1>
    <table id="listado" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descuento</th>
                <th>Codigo</th>
                <th>Estado</th>
                <th>Usos restantes</th>
				<th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
    <?php
    while ($row = mysqli_fetch_object($rs_contenidos)) {?>
        <tr>
            <td><?php echo $row->nombre; ?></td>
            <td>-<?php echo "$row->efecto"; ?>%</td>
            <td><?php echo "$row->codigo"; ?></td>
            <td><?=$row->activo==1?"Activo":"Inactivo";?></td>
            <td><?php echo "$row->usos"; ?></td>
			<td align="center"><a href="cupones.php?Accion=Eliminar&Id=<?=$row->id;?>" class="eliminar"><img src="../../image/borrar.gif" border="0" ></a></td>
        </tr>
		<?
		}
		?>
        </tbody>
	</table>
	<script>
		$(document).ready(function() {
			$('#listado').DataTable( {
				"sScrollY": 400,
				"sScrollX": true,
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

    	$('.eliminar').on('click', function () {
    		return confirm('¿Está seguro de que desea eliminar permanentemente esta entrada?');
    	});
	</script> 
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td class="nuevo">
          <a href="cupones.php?Accion=Adicionar&idcategoria=<?=$idcategoria;?>"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
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