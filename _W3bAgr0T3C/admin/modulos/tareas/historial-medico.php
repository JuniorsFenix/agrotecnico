<?php
	include_once("templates/includes.php");
	$historial = historialQuery($_GET["usuario"]);
	$link = "";
	if(isset($_GET["usuario"])){
		$link = "/$_GET[usuario]";
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Historial médico - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/data.table.css" rel="stylesheet" type="text/css" />
	<link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/jqueryui.css" rel="stylesheet" type="text/css" />   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
    	<a class="admin" target="_blank" href="/<?php echo $sitioCfg["carpeta"]; ?>/estadisticas-historial">Ver estadísticas</a>
    	<h1>Historial médico</h1>
        <table class="display datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Descripción</th>
                    <th>Recomendaciones</th>
                    <th>Enviar</th>
                    <th>Fecha</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
     
            <tbody>
				<?php
                foreach($historial as $row) { ?>
                <tr>
                    <td><?php echo "$row[nombre] $row[apellido]"; ?></td>
                    <td><?php echo substr(strip_tags($row["descripcion"]),0,280)."..."; ?></td>
                    <td><?php echo substr(strip_tags($row["recomendaciones"]),0,280)."..."; ?></td>
                    <td><a href="/<?php echo $sitioCfg["carpeta"]; ?>/enviar-recomendacion/<?php echo $row['idhistorial']; ?>">Enviar recomendación</a></td>
                    <td><?php echo $row["fecha"]; ?></td>
                    <td><a href="/<?php echo $sitioCfg["carpeta"]; ?>/editar-historial/<?php echo $row['idhistorial']; ?>"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/editar.png" alt="Editar" width="16px"/></a></td>
                    <td><a class="eliminar" href="/<?php echo $sitioCfg["carpeta"]; ?>/eliminarHistorial/<?php echo $row['idhistorial']; ?>"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/eliminar.png" alt="Eliminar" width="15px"/></a></td>
                </tr>
            	<?php
				}
				?>
            </tbody>
        </table>
        <a style="margin:11px auto; display:block; width:96px;" href="/<?php echo $sitioCfg["carpeta"]; ?>/nuevo-historial<?php echo $link; ?>"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
    </div>
	<script type="text/javascript" src="/<?php echo $sitioCfg["carpeta"]; ?>/js/DataTables/jquery.dataTables.js"></script>
	<script>
     $(document).ready(function() {
            var oTable = $('.datatable').dataTable( {
                    "bJQueryUI": true,
                    "sScrollX": "",
                    "bSortClasses": false,
                    "aaSorting": [[0,'desc']],
                    "bAutoWidth": true,
                    "bInfo": true,
                    "sScrollY": "100%",	
                    "sScrollX": "100%",
                    "bScrollCollapse": true,
                    "sPaginationType": "full_numbers",
                    "bRetrieve": true,
                    "oLanguage": {
                                    "sSearch": "Búsqueda:",
                                    "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                                    "sInfoEmpty": "Información vacia",
                                    "sZeroRecords": "No se encontraron resultados",
                                    "sInfoFiltered": "(<?=DT_FILTER1?> _MAX_ <?=DT_FILTER2?>)",
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
    <?php get_footer() ?>
</body>
</html>