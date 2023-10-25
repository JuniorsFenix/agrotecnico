<?php
	include_once("templates/includes.php");
	$certificados = certificadosQuery($_GET["usuario"]);
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
    <title>Certificados laborales - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/data.table.css" rel="stylesheet" type="text/css" />
	<link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/jqueryui.css" rel="stylesheet" type="text/css" />   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
    	<h1>Certificados laborales</h1>
        <table class="display datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Usuario</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
                    <th>Correo</th>
                    <th>Fecha</th>
                    <th>Ver</th>
                    <!--<th>Eliminar</th>-->
                </tr>
            </thead>
     
            <tbody>
				<?php
                foreach($certificados as $row) { ?>
                <tr>
                    <td><?php echo $row["idcertificado"]; ?></td>
                    <td><?php echo "$row[nombre] $row[apellido]"; ?></td>
                    <td><?php echo $row["asunto"]; ?></td>
                    <td><?php echo substr(strip_tags($row["mensaje"]),0,280)."..."; ?></td>
                    <td><?php echo $row['correo']; ?></td>
                    <td><?php echo $row["fechahora"]; ?></td>
                    <td><a target="_blank" href="/<?php echo $sitioCfg["carpeta"]; ?>/fotos/certificados/<?php echo $row['certificado']; ?>">Ver certificado</a></td>
                    <!--<td><a class="eliminar" href="/eliminarHistorial/<?php //echo $row['idhistorial']; ?>"><img src="/imagenes/eliminar.png" alt="Eliminar" width="15px"/></a></td>-->
                </tr>
            	<?php
				}
				?>
            </tbody>
        </table>
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