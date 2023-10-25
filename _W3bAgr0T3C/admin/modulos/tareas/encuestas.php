<?php
	include_once("templates/includes.php");
	$perfil = datosPerfil($_SESSION["perfil"]);
	$encuestas = encuestasQuery();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Encuestas - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/data.table.css" rel="stylesheet" type="text/css" />
	<link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/jqueryui.css" rel="stylesheet" type="text/css" />   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
    	<h1>Lista de Encuestas</h1>
        <table class="display datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Fecha</th>
                    <th>Encuesta</th>
					<?php if($perfil["editar"]==1){ ?><th>Enviar</th><?php } ?>
                    <th>Realizada</th>
                    <th>Activa</th>
                    <th>Estadísticas</th>
                    <?php if($perfil["crear"]==1){ ?><th>Preguntas</th><?php } ?>
					<?php if($perfil["editar"]==1){ ?><th>Editar</th><?php } ?>
					<?php if($perfil["eliminar"]==1){ ?><th>Eliminar</th><?php } ?>
                </tr>
            </thead>
     
            <tbody>
            	<?php
					foreach($encuestas as $row) {
					$imagen="<img src='/$sitioCfg[carpeta]/imagenes/encuesta-inactiva.png' alt='Encuesta inactiva' width='15px'/>";
					if ($row['estado']==1) {
						$imagen="<img src='/$sitioCfg[carpeta]/imagenes/encuesta-activa.png' alt='Encuesta activa' width='15px'/>";
					}
				?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['fecha_creacion']; ?></td>
                    <td><a href="/<?php echo $sitioCfg["carpeta"]; ?>/encuesta/<?php echo $row['id']; ?>" target="_blank"><?php echo $row['titulo']; ?></a></td>
                    <?php if($perfil["editar"]==1){ ?><td><a href="/<?php echo $sitioCfg["carpeta"]; ?>/enviarEncuesta/<?php echo $row['id']; ?>">Enviar</a></td><?php } ?>
                    <td><?php echo $row['veces_realizada']; ?></td>
                    <td><?php echo $imagen; ?></td>
                    <td><a href="/<?php echo $sitioCfg["carpeta"]; ?>/estadisticas/<?php echo $row['id']; ?>"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/estadisticas.png" alt="Estadísticas" width="15px"/></a></td>
                    <?php if($perfil["crear"]==1){ ?><td><a href="/<?php echo $sitioCfg["carpeta"]; ?>/preguntas/<?php echo $row['id']; ?>"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/add.png" alt="Añadir Preguntas" width="15px"/></a></td><?php } ?>
					<?php if($perfil["editar"]==1){ ?><td><a href="/<?php echo $sitioCfg["carpeta"]; ?>/editar-encuesta/<?php echo $row['id']; ?>"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/editar.png" alt="Editar" width="16px"/></a></td><?php } ?>
					<?php if($perfil["eliminar"]==1){ ?><td><a class="eliminar" href="/<?php echo $sitioCfg["carpeta"]; ?>/eliminarEncuesta/<?php echo $row['id']; ?>"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/eliminar.png" alt="Eliminar" width="15px"/></a></td><?php } ?>
                </tr>
            	<?php
					}
				?>
            </tbody>
        </table>
        <?php if($perfil["crear"]==1){ ?><a style="margin:11px auto; display:block; width:96px;" href="/<?php echo $sitioCfg["carpeta"]; ?>/nueva-encuesta"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a><?php } ?>
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