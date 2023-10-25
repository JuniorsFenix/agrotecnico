<?php
  if(!session_id()) session_start();
	if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
		header("Location: /");
		exit;
	}
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

  if(!empty($_POST["correo_electronico"])){
    $nConexion = Conectar();

    $sql="INSERT INTO tblti_cotizaciones_clientes (correo_electronico, nombre, apellido, tipoid, identificacion, direccion, iddepartamento, idciudad, departamento, ciudad, telefono)
    VALUES ('{$_POST["correo_electronico"]}', '{$_POST["nombre"]}', '{$_POST["apellido"]}', '{$_POST["tipoid"]}', '{$_POST["identificacion"]}', '{$_POST["direccion"]}', '{$_POST["iddepartamento"]}', '{$_POST["idciudad"]}', '{$_POST["departamento"]}', '{$_POST["ciudad"]}', '{$_POST["telefono"]}')";
    
    mysqli_query($nConexion,$sql);
    header("Location: /clientes");
    exit;
  }
  
  $RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));
?>
<!DOCTYPE html>
<html lang="es"> 
<head>
  <meta charset="utf-8">
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title>Nuevo cliente - <?php echo $sitioCfg["titulo"]; ?></title>
    <meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
    <meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
  <?php echo $RegContenido->contenido; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
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
      <div class="container container-producto">
        <h3>Nuevo cliente</h3>
        <form method="post">
        <input type="hidden" value="" id="departamento" name="departamento" />
        <input type="hidden" value="" id="ciudad" name="ciudad" />
        <div class="row formPaypal">
          <label class="col-md-12"><input id="correo" name="correo_electronico" required type="email" placeholder="Correo*" /></label>
          
          <label class="col-md-6" style="border: none;"><input id="nombre" name="nombre" required type="text" placeholder="Nombres*" /></label>
          <label class="col-md-6"><input id="apellido" name="apellido" required type="text" placeholder="Apellidos*" /></label>

          <label class="col-md-6">
            <select name="tipoid" id="tipoid" onchange="">
              <option disabled selected>Tipo de identificación *</option>
              <option value="Cédula">Cédula</option>
              <option value="NIT">NIT</option>
            </select>
          </label>                  
          <label class="col-md-6"><input id="identificacion" name="identificacion" required type="text" placeholder="Número de Identificación*" /></label>
          
          <label class="col-md-6">
            <select id="iddepartamento" name="iddepartamento">
              <option  disabled selected  >Departamento</option>
            </select>
          </label>

          <label class="col-md-6">
            <select id="idciudad" name="idciudad">
              <option  disabled selected >Ciudad</option>
            </select>
          </label>
          
          <label class="col-md-6">
            <input id="direccion" name="direccion" required type="text" placeholder="Dirección*" />
          </label>
          
          <label class="col-md-6">
            <input id="telefono" name="telefono" required type="text" placeholder="Teléfono*" />
          </label>
        
          <div class="col-md-12">
            <input style="margin:20px 0;" class="action-button" id="cmdEnviar" name="Submit" type="submit" value="Registrar" size="100">
          </div>
        </div>
        </form>
      </div>
    </div>
    <!--- Sección de Creado por --->
    <?php require_once("footer.php");?>
    <!--- Sección de Creado por --->
  </div>
<script>
  var dataDepartamentos
  var dataCiudades

  function get_departamentos(){
    //console.log("get_departamentos")
    url = '../php/fletes/coo/calculo.php?listarDepartamentos=true'
    $.getJSON(url,{},
      CB_get_departamentos
    );
  }
  function CB_get_departamentos(data, textStatus, jqXHR){
    dataDepartamentos = data
    data["item"].forEach(function(key){
      $("#iddepartamento").append( new Option( key["nombre"] , key["codigo"] ) );
    });
    get_ciudades()
  }    

  function get_ciudades(){
    //console.log("get_ciudades")
    url = '../php/fletes/coo/calculo.php?listarCiudades=true'
    $.getJSON(url,{},
      CB_get_ciudades
    );
  }
  function CB_get_ciudades(data, textStatus, jqXHR){      
    dataCiudades = data
  }

  function listarCiudadesDpt(dpt){    
    $('#idciudad').html('');
    $('#idciudad').append('<option value="" disabled selected="selected">Ciudad</option>');

    dataCiudades["item"].forEach(function(key){              
      if(dpt==key["codigo_departamento"]) {
        $("#idciudad").append( new Option( key["nombre"] , key["codigo"] ) );
      }
    })
  }
  $(document).ready(function(){
    get_departamentos()
  });

		$('body').on('change', '#iddepartamento', function(event) {
			event.preventDefault();
      
			var departamento = $('#iddepartamento').val();
      document.getElementById("departamento").value = $("#iddepartamento option:selected" ).text();

      listarCiudadesDpt(departamento);      
		});

		$('body').on('change', '#idciudad', function(event) {
			event.preventDefault();
      
      document.getElementById("ciudad").value= $("#idciudad option:selected" ).text();
		});
</script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>