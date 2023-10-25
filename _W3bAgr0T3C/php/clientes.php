<?php
  if(!session_id()) session_start();
	if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
		header("Location: /");
		exit;
  }
  $_GET["ciudad"]=1;
  include("../include/funciones_public.php");
  ValCiudad();
  $sitioCfg = sitioAssoc();
  $home = $sitioCfg["url"];
  include("../admin/vargenerales.php");
  require_once("inc/functions.php");
  require_once("../admin/herramientas/seguridad/validate.php");
  
  $IdCiudad=varValidator::validateReqInt("get","ciudad",true);
  if(is_null($IdCiudad)){
    echo "Valor de entrada invalido para la variable ciudad";
    exit;
  }

  if(!empty($_GET["eliminar"])){
    $nConexion = Conectar();
		
		$sql="DELETE FROM tblti_cotizaciones_clientes WHERE id={$_GET["eliminar"]}";
		mysqli_query($nConexion,$sql);
    
    header("Location: /clientes");
    exit;
  }

  $sql="SELECT * FROM tblti_cotizaciones_clientes";

  $nConexion   = Conectar();
  $result = mysqli_query($nConexion,$sql);
  
  $RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
?>
<!DOCTYPE html>
<html lang="es"> 
<head>
  <meta charset="utf-8">
  <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
  <title>Clientes - <?php echo $sitioCfg["titulo"]; ?></title>
  <meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
  <meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
  <?php echo $RegContenido->contenido; ?>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">

	<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" />
  
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    
</head>
<body>
  <!--- Sección de menú --->
  <?php require_once("header.php");?>
  <!--- Sección de menú --->
  <div class="principal">
    <div id="cabezote">
    <?php echo cabezoteJqueryIn(4,"carousel"); ?>
    </div>
    <div class="contenidoGeneral">
      <div class="container">
        <h3>Clientes</h3> 
        <div class="row">
          <div class="col-md-12">
            <table id="listado" >
              <thead>
                <tr>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <th>Correo</th>
                  <th>Tipo ID</th>
                  <th>Número ID</th>
                  <th>Departamento</th>
                  <th>Ciudad</th>
                  <th>Dirección</th>
                  <th>Teléfono</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  while( ($row = mysqli_fetch_assoc($result)) ) {
                    echo "<tr>
                    <td>{$row['nombre']}</td>
                    <td>{$row['apellido']}</td>
                    <td>{$row['correo_electronico']}</td>
                    <td>{$row['tipoid']}</td>
                    <td>{$row['identificacion']}</td>
                    <td>{$row['departamento']}</td>
                    <td>{$row['ciudad']}</td>
                    <td>{$row['direccion']}</td>
                    <td>{$row['telefono']}</td>
                    <td><a href='/editar-cliente/{$row['id']}'>Editar</a></td>
                    <td><a href='/clientes?eliminar={$row['id']}'>Eliminar</a></td>
                    </tr>"; 
                             
                  
                } ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-12 text-center">
            <a style="margin:20px 0;" class="btn btn-primary" id="cmdEnviar" href="/nuevo-cliente">Nuevo cliente</a>
          </div>
        </div>
      </div>
    </div>
    <!--- Sección de Creado por --->
    <?php require_once("footer.php");?>
    <!--- Sección de Creado por --->
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>

<script>
  $(document).ready(function() {
    var table = $( '#listado').DataTable( {

    lengthMenu: [
        [ 5, 10, 25, 50, 100, -1 ],
        [ "5", "10", "25", "50", "100", "Todo" ]
    ],

      "order": [[ 1, 'asc' ]],
/*
      "columnDefs": [
        {
          "targets": [ 7,9 ],
          "visible": false,
          "searchable": false
        }
      ],
*/
      
      "orderCellsTop": true,
      "fixedHeader": true,
      "autoWidth": true,

      "bScrollCollapse": true,
      "bRetrieve": true,

    "pageLength": 5 ,
    //"sScrollX": true,

    "sPaginationType": "full_numbers",                   

      "oLanguage": {
        "sSearch": "Búsqueda:",
        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
        "sInfoEmpty": "Tabla vacía",
        "sZeroRecords": "No hay coincidencias",
        "sEmptyTable": "No hay coincidencias",
        "sLengthMenu": "Mostrar _MENU_ entradas",
        "oPaginate": {
          "sFirst":    "<<",
          "sPrevious": "<",
          "sNext":     ">",
          "sLast":     ">>"
        }
      }
    });    
  });
</script>
</body>
</html>