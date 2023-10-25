<?php
	include("../../herramientas/seguridad/seguridad.php");
	include("../../herramientas/paginar/class.paginaZ.php");
	include ("../../vargenerales.php");
  include("../../funciones_generales.php");
	$IdCiudad = $_SESSION["IdCiudad"];
	$page=new sistema_paginacion('tblcontenidos');
	$page->set_condicion( "WHERE idciudad = ". $IdCiudad );
	$page->ordenar_por('clave');
	$page->set_limite_pagina(400);
	$rs_contenidos=$page->obtener_consulta();
	$page->set_color_tabla("#FEF1E2");
	$page->set_color_texto("black");
	$page->set_color_enlaces("black","#FF9900");
	$permisos  = permisos("Contenidos");
	
?>

<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
		<link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>
  </head>
  <body>
<? include("../../system_menu.php"); ?><br>
    <h1 class="tituloFormulario">LISTA DE CONTENIDOS GENERALES</h1>
    <table id="listado" class="display hover cell-border" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Clave</th>
                <th>Titulo</th>
                <th>Publicado</th>
                <th>Home</th>
                <th>Seleccionar</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>
      <?php
        while( $row = mysqli_fetch_object( $rs_contenidos ) )
        {
        ?>
        <tr>
            <td><?php echo $row->clave; ?></td>
            <td><?php echo $row->titulo; ?></td>
            <td><?php echo $row->publicar; ?></td>
            <td><?php echo $row->verhome; ?></td>
            <td><?php if($permisos["editar"]==1):?><a href="contenidos.php?Accion=Editar&Id=<?php echo $row->clave; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<?php echo $row->titulo; ?>"></a><?php endif;?></td>
            <td>
            <?php
            if ( !empty( $row->imagen ) )
            {
            echo "<a href='$cRutaVerImgContenidos$row->imagen' target='_blank'>Ver</a>";
            }
            else
            {
            echo "No Asignada";
            }
            ?>
            </td>
        </tr>
        <?php
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
        		"order": [[ 1, "asc" ]],
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
      <?php if($permisos["crear"]==1):?>
            <tr>
                <td colspan="6" class="nuevo">
                <a href="contenidos.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
                </td>
            </tr>
	  <?php endif;?>
            <tr>
                <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
            </tr>
        </table>
  	</body>
</html>