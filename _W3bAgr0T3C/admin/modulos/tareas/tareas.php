<?php
	include_once("templates/includes.php");
	if(isset($_POST["actualizar"])){
        actualizarTarea($_POST);
	}
	if(isset($_POST["guardar"])){
        guardarTarea($_POST);
	}
	if(($_GET["accion"]=="eliminar")){
        eliminarTarea($_GET["idaccion"]);
	}
	$accion = tareasQuery();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Tareas - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="estilos/estilo.css" rel="stylesheet" type="text/css" />
    <link href="estilos/data.table.css" rel="stylesheet" type="text/css" />
	<link href="estilos/jqueryui.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
	<?php include("../../system_menu.php"); ?><br>
    <div id="container-inside">
    	<h1>Tareas</h1>
        <table class="display datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tarea</th>
                    <th>Prioridad</th>
                    <th>Cliente</th>
                    <th>Responsable</th>
                    <th>Inicio</th>
                    <th>Entrega</th>
                    <th>Culminación</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
     
            <tbody>
				<?php
                foreach($accion as $row) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['tarea']; ?></td>
                    <td><?php echo $row['prioridad']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['nombres']; ?></td>
                    <td><?php echo $row['inicio']; ?></td>
                    <td><?php echo $row['entrega']; ?></td>
                    <td><?php echo $row['culminacion']; ?></td>
                    <td><?php echo $row['estado']; ?></td>
                    <td><a href="editar-tarea.php?tarea=<?php echo $row['id']; ?>"><img src="imagenes/editar.png" alt="Editar" width="16px"/></a></td>
                    <td><a class="eliminar" href="tareas.php?accion=eliminar&tarea=<?php echo $row['id']; ?>"><img src="imagenes/eliminar.png" alt="Eliminar" width="15px"/></a></td>
                </tr>
            	<?php
				}
				?>
            </tbody>
        </table>
        <a style="margin:11px auto; display:block; width:96px;" href="nueva-tarea.php"><img src="imagenes/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
    </div>
	<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script>
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
                                    "sZeroRecords": "<?=DT_ZERORECORD?>",
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