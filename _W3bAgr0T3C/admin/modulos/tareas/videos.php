<?php
	include_once("templates/includes.php");
	$videos = videosQuery();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="google-site-verification" content="" />
    <title>Videos - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/data.table.css" rel="stylesheet" type="text/css" />
	<link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/jqueryui.css" rel="stylesheet" type="text/css" />   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
    	<h1>Lista de Videos</h1>
        <table class="display datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Activo</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
     
            <tbody>
            	<?php
					foreach($videos as $row) {
					$imagen="<img src='/$sitioCfg[carpeta]/imagenes/encuesta-inactiva.png' alt='Video inactivo' width='15px'/>";
					if ($row['activo']==1) {
						$imagen="<img src='/$sitioCfg[carpeta]/imagenes/encuesta-activa.png' alt='Video activo' width='15px'/>";
					}
				?>
                <tr>
                    <td><?php echo $row['id_video']; ?></td>
                    <td><?php echo $row['titulo']; ?></td>
                    <td><?php echo substr(strip_tags($row['descripcion']),0,150); ?></td>
                    <td><img src="<?=videosYoutubePreview($row["url"]);?>" alt="<?=$row["titulo"];?>" style="width:150px" /></td>
                    <td><?php echo $imagen; ?></td>
                    <td><a href="/<?php echo $sitioCfg["carpeta"]; ?>/editar-video/<?php echo $row['id_video']; ?>"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/editar.png" alt="Editar" width="16px"/></a></td>
                    <td><a class="eliminar" href="/<?php echo $sitioCfg["carpeta"]; ?>/eliminarVideo/<?php echo $row['id_video']; ?>"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/eliminar.png" alt="Eliminar" width="15px"/></a></td>
                </tr>
            	<?php
					}
				?>
            </tbody>
        </table>
        <a style="margin:11px auto; display:block; width:96px;" href="/<?php echo $sitioCfg["carpeta"]; ?>/nuevo-video"><img src="/<?php echo $sitioCfg["carpeta"]; ?>/imagenes/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
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