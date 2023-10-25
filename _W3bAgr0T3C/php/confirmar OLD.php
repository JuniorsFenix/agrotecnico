<?php
  include("diasiniva.php");

    if(!session_id()) session_start();

    /* Forzar pais y lenguaje */
   	$_SESSION["pais"] = "CO";
    $_SESSION["lenguaje"] = "es";

//var_dump($_SESSION["pais"]);
//var_dump($_POST);

	include("../include/funciones_public.php");
  
	require_once("inc/functions.php");
	ValCiudad();
	include("../admin/vargenerales.php");
	require_once ("../admin/herramientas/seguridad/validate.php");
	
	$IdCiudad=varValidator::validateReqInt("get","ciudad",true);
	if(is_null($IdCiudad)){
		echo "Valor de entrada invalido para la variable ciudad";
		exit;
	}
	
	$generales = datosGenerales();
	$sitioCfg = sitioAssoc();
    $nConexion = Conectar();
    mysqli_set_charset($nConexion,'utf8');

	if (isset($_POST["actualizarCarro"])) {		
		nuevoCarro($_POST);
	}
	$sessionID = $_COOKIE['PHPSESSID'];
	
	$d = $_POST;
	
	$ca = new DbQuery($nConexion);
	$ca->prepareSelect("tblti_carro", "*", "session_id='$sessionID'", "carro desc");
	$ca->exec();
	$pedido = $ca->fetch();


  if($_SESSION["pais"] == "CO"){
    $divisa = "COP";
    $lang = "es";
    $monto = $pedido["precio_total"];
  }else{
    $divisa = "USD";
    $lang = "en";
    $monto = $pedido["precio_totalEN"] + $d["valorEnvioEN"];
  }


  $imagenes=array();
  $ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
  while( $imagen = mysqli_fetch_assoc($ras) ){
    $imagenes[ $imagen["idproducto"] ] = $imagen;
  }
  

  	$query = "SELECT p.url,p.idproducto,p.nombre,p.precio,p.diasiniva,
                     pa.unidades,pa.talla,pa.color,pa.flete 
                FROM tblti_carro_detalle pa, 
                     tblti_productos p 
               WHERE pa.carro = {$pedido["carro"]} 
                 AND p.idproducto = pa.idproducto";
                 
  	$asociados  = mysqli_query($nConexion,$query);	
    $asociados2 = mysqli_query($nConexion,$query);
    $asociados3 = mysqli_query($nConexion,$query);


    $fleteTotal = 0;
    $envio = true;
    while($rax=mysqli_fetch_assoc($asociados3)) { 
      if($rax["flete"]==0){
        $envio=false;
      }
      $fleteTotal += $rax["flete"] * $rax["unidades"] ;
    }

    switch ($_POST["metodo"]){
      case "bulerias":
        $envio = false;
        $mensaje = "El cliente retirará su compra en la sede de Bulerías (Medellín)";
        break;
      case "sanpedro":
        $envio = false;
        $mensaje = "El cliente retirará su compra en la sede de San Pedro (Medellín)";
        break;
      case "sanjuan":
        $envio = false;
        $mensaje = "El cliente retirará su compra en la sede de San Juan (Medellín)";
        break;
      case "rionegro":
        $envio = false;
        $mensaje = "El cliente retirará su compra en la sede de Rionegro (Antioquia)";
        break;
      case "noflete":
        $envio = false;
        $mensaje = "El cliente pagará el envío contra-entrega";
        break;
      case "flete":
        if($envio){
          $mensaje = "Su pedido incluye el costo del envío por Coordinadora";
        }else{
          $envio = false;
          $mensaje = "Su pedido no incluye el envío, deberá pagarlo contra-entrega";
        }
        break;
    }


//$envio=true;
    if($envio) {
      $monto += $fleteTotal;
    }    


    // Payu del Cliente
    $test = 0;
    $account_Id = 697658;
    $merchant_Id = 694703;
    $api_key     = "h8p5IenLM7dYuBLye3GhPeGkTE";
    $action_form = "https://gateway.payulatam.com/ppp-web-gateway/";

/*
    // PAYU Solo ambiente de Pruebas
    $test = 1;
    $account_Id  = 512321;
    $merchant_Id = 508029;
    $api_key     = "4Vj8eK4rloUd272L48hsrarnUA";
    $action_form = "https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/";
*/

    $signat = "$api_key~$merchant_Id";

    $signature = md5("$signat~{$pedido["referenciaPayU"]}~{$monto}~{$divisa}");

    $url_confirmacion = "https://" . $_SERVER['HTTP_HOST'] . "/actualizar-orden";
    $url_respuesta    = "https://" . $_SERVER['HTTP_HOST'] . "/gracias-por-su-compra";
    $titulo = VerSitioConfig('titulo');
    $descripcion_payu = "Compra de producto en $titulo";

  
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));

?>

<!DOCTYPE HTML>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title>Confirmar compra - <?php echo $sitioCfg["titulo"]; ?></title>
    <meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
    <meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
	<?php echo $RegContenido->contenido; ?>
   <script>
		function gtag_report_conversion(url) {
		  var callback = function () {
			if (typeof(url) != 'undefined') {
			  window.location = url;
			}
		  };
		  gtag('event', 'conversion', {
			  'send_to': 'AW-825081245/WFHWCKOcgnoQnfu2iQM',
			  'value': <?php echo $pedido["precio_total"] ?>,
			  'currency': 'COP',
			  'event_callback': callback
		  });
		return true;
		}
	</script>
    <meta content="on" http-equiv="cleartype">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:300,400&subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <!--<link href="<?php echo $home; ?>/sadminc/modulos/matriz/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">-->
    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
	
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="<?php echo $home; ?>/php/bar-rating/jquery.barrating.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="<?php echo $home; ?>/php/js/generales.js"></script>        
</head>
<body>
	<!--- Sección de menú --->
	<?php require_once("header.php");?>
	<!--- Sección de menú ---> 
    <div class="principal">
		<div id="cabezote">
		<?php echo cabezoteJqueryIn(4,"carousel"); ?>
		</div>			
	<div id="skrollr-body">
        <section class="contenidoInterno cuenta">
        <div class="container">
            <h2>
              Confirme su orden:
            </h2>

			<div class="row justify-content-center">
				<div id="confirmar" class="col-md-7">
				Su pedido es: <br />
			  <?php while($rax=mysqli_fetch_assoc($asociados2)) { ?>

          <div class="productoC">
            <div class="row">
              <a class="urlProducto col-md-3" href="/productos/<?=$rax["url"];?>">
              <img src="<? echo $cRutaVerImagenTienda."p_".$imagenes[$rax["idproducto"]]["imagen"]; ?>" alt="<?=$rax["nombre"];?>" /> </a>
              <div class="col-md-8">
                <h2>
                  <?php
                    if($_SESSION["lenguaje"] == "es"){
                      echo $rax["nombre"];
                    }else{
                      echo $rax["nombreEN"];
                    }           
                  ?>
                </h2>
                <!--
                <p style="display:"><strong> Talla: </strong> <?=$rax["talla"];?></p>
                <p style="display:"><strong> Color: </strong> <?=$rax["color"];?></p>
                <p style="display:none"><strong>Estilo: </strong> <?=$rax["estilo"];?></p>
                -->
                <p><strong>Precio:</strong> 
                  <?php 
                    if($_SESSION["pais"] == "CO"){
                      if(DIASINIVA AND $rax["diasiniva"]==true) {
                        echo "COP ".number_format( ($rax["precio"]/1.19), 0, ',', '.' );
                      }else{                        
                        echo "COP ".number_format( ($rax["precio"]), 0, ',', '.' );
                      }
                    }else{
                      echo "USD ".number_format( ($rax["precioEN"]), 2, '.', '' );
                    }           
                  ?>
                </p>
                <p><strong>Cantidad:</strong> 
                  <?php echo $rax["unidades"]; ?>
                </p>
                <p><strong>Subtotal:</strong> 
                  <?php 
                    if($_SESSION["pais"] == "CO"){
                      if(DIASINIVA AND $rax["diasiniva"]==true) {
                        echo "COP ".number_format( ($rax["precio"]/1.19*$rax["unidades"]), 0, ',', '.' );
                      }else{
                        echo "COP ".number_format( ($rax["precio"]*$rax["unidades"]), 0, ',', '.' );
                      }
                    }else{
                      echo "USD ".number_format( ($rax["precioEN"]*$rax["unidades"]), 2, '.', '' );
                    }           
                  ?>
                </p>

                <?if($envio) {?>
                  <p><strong>Envío:&nbsp&nbsp</strong> 
                    <?php 
                      if($_SESSION["pais"] == "CO"){
                        echo "COP ".number_format( ($rax["flete"] * $rax["unidades"]), 0, ',', '.' );
                      }else{
                        echo "USD ".number_format( ($rax["flete"]), 2, '.', '' );
                      }           
                    ?>
                  </p>
                <? } ?>
              </div>
              
            </div>
          </div>
			  <?php } ?>
        
                <div class="resumen">
					<?php if($pedido["regalo"]==1){echo "<p style='text-align: right'><strong>Envoltura y perzonalización de regalo:</strong> $4.000</p>";} ?>
					<!-- <p style='text-align: right'><strong>Envío:</strong> $0</p> -->

                  <?php if($_SESSION["pais"] != "CO") {?>
                  <p><strong>Envío:</strong> 
                    <?php                     
                      if($_SESSION["pais"] == "CO"){
                        echo "COP ".number_format( ($d[""]), 0, ',', '.' );
                      }else{
                        echo "USD ".number_format( ($d["valorEnvioEN"]), 2, '.', '' );
                      }                
                    ?>
                  </p>
                  <?php }?>
              
                  <h5 style='text-align: right;'><strong>Total Productos:
                    <?php 
                      if($_SESSION["pais"] == "CO"){
                        echo "COP ".number_format( ($pedido["precio_total"]), 0, ',', '.' );
                      }else{
                        echo "USD ".number_format( ($pedido["precio_totalEN"] + $d["valorEnvioEN"]), 2, '.', '' );
                      }
                    ?></strong>
                  </h5>
                  
                  <?if($envio) {?>
                    <h5 style='text-align: right;'><strong>Total Envío:
                      <?php 
                        if($_SESSION["pais"] == "CO"){
                          echo "COP ".number_format( $fleteTotal, 0, ',', '.' );
                        }else{
                          echo "USD ".number_format( $fleteTotal, 2, '.', '' );
                        }
                      ?></strong>
                    </h4>                  
                  <? } ?>
                
                  <?if($envio) {?>
                    <h3 style='text-align: right;color:#38892F'><strong>Total General:
                      <?php 
                        if($_SESSION["pais"] == "CO"){
                          echo "COP ".number_format( ($pedido["precio_total"] + $fleteTotal), 0, ',', '.' );
                        }else{
                          echo "USD ".number_format( ($pedido["precio_totalEN"] + $fleteTotal), 2, '.', '' );
                        }
                      ?></strong>
                    </h3>
                    <h3 style='text-align: right; font-size: 16px; margin-top: -5px; '>
                      <?php 
                        if($_SESSION["pais"] == "CO"){
                          echo "<b>$mensaje</b>";
                        }
                      ?>
                    </h3>
                  <? }else{ ?>
                    <h3 style='text-align: right;color:#38892F'><strong>Total General:
                      <?php 
                        if($_SESSION["pais"] == "CO"){
                          echo "COP ".number_format( ($pedido["precio_total"] ), 0, ',', '.' );
                        }else{
                          echo "USD ".number_format( ($pedido["precio_totalEN"] ), 2, '.', '' );
                        }
                      ?></strong>
                    </h3>                  

                    <h3 style='text-align: right; font-size: 16px; margin-top: -5px; '>
                      <?php 
                        if($_SESSION["pais"] == "CO"){
                          echo "<b>$mensaje</b>";
                          echo "<br>Una vez realizada la compra, nos pondremos en contacto con Usted, para coordinar el retiro en tienda o el envío del producto";
                        }
                      ?>
                    </h3>

                  <? } ?>
                  
                </div>
				</div>
				<div class="formularioPayu" class="col-md-5">
					<div class="margen">
						<strong>Nombre completo:</strong> <? echo $pedido["nombre"]." ".$pedido["apellido"];?><br>
						<strong>Cédula: </strong> <? echo $pedido["identificacion"];?><br>
						<strong>Correo: </strong> <? echo $pedido["correo_electronico"];?><br>
						<strong>Teléfono: </strong> <? echo $pedido["telefono"];?><br>
						<strong>Dirección: </strong> <? echo $pedido["direccion"];?><br>
						<strong>Información: </strong> <? echo $pedido["extra"];?><br>
            <strong>Departamento: </strong> <? echo $pedido["state"];?><br>            
						<strong>Ciudad: </strong> <? echo $pedido["ciudad"];?><br>
						<strong>Envío: </strong> <? echo $mensaje;?><br>

					 <form id="pedido" method="post" action="<?php echo $action_form;?>">            
						<input value="<?php echo $test;?>" name="test" type="hidden">
						<input value="<?php echo $account_Id;?>" name="cuentaId" type="hidden">
						<input value="<?php echo $merchant_Id;?>" name="merchantId" type="hidden">
						<input value="<?php echo $pedido["referenciaPayU"];?>" name="UNIQUE_REFERENCE" type="hidden">
            
            <input value="<?php echo $pedido["referenciaPayU"];?>" name="referenceCode" type="hidden">                        
						<input value="<?php echo $descripcion_payu;?>" name="description" type="hidden">
						<input value="<?php echo $monto;?>" name="amount" type="hidden">
						<input value="0" name="tax" type="hidden">
						<input value="0" name="taxReturnBase" type="hidden">
						<input value="<?php echo $pedido["correo_electronico"];?>" name="buyerEmail" type="hidden">
						<input value="<?php echo $pedido["nombre"];?>" name="buyerFullName" type="hidden" >
						<input value="<?php echo $pedido["telefono"];?>" name="telephone" type="hidden" >
						<input value="<?php echo $divisa;?>" name="currency" type="hidden">
						<input value="<?php echo $lang;?>" name="lng" type="hidden">
						<input value="<?php echo $signature;?>" name="signature" type="hidden">
            <input value="<?php echo $url_confirmacion;?>" name="confirmationUrl" type="hidden">
            <input value="<?php echo $url_respuesta;?>" name="responseUrl" type="hidden">
<!--
<br>
            <input class="pagar" name="entrega" type="button" value="Pagar Contra Entrega" onclick="elclickdelboton(this)" >
            <i>(El pago contra entrega está únicamente disponible en el área Metropolitana de Aburrá)</i>
<br><br>
-->
            <input class="pagar" name="payu" type="button" value="Pagar (Payu)" onclick="elclickdelboton(this)" >

            <span class="terminos">*Al hacer click en "Pagar" usted indica que ha leído y aceptado nuestros
              <a href="/terminos-y-condiciones" target="_blank">Términos y condiciones
              </a>
            </span>
					</form>
			   		</div>
				</div>
            </div>
			</div>
        </section>
        <!--Inicio Footer-->
		<?php require_once("footer.php");?>
        <!--Final Footer-->
			<style>
			    .logo{
			        display:none;
			    }
			    .logoBarra {
							opacity: 1;
					}
					header {
							background: #fff;
							opacity: 1;
					}
					.menu-ppal li a {
							color: #333;
					}
					.menu-ppal .activo {
							background: #38892F;
					}
					.menu-ppal .activo a, .menu-ppal .activo:hover a {
							color: #fff;
					}
					@media only screen and (max-width: 820px){
						.logoBarra {
							opacity: 1;
							display: block;
    					right: 70px;
						}
						.logoBarra img {
							height: 38px!important;
							width: auto!important;
						}
					}
			</style>
    </div>
    </div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>		

  <script type="text/javascript">
    function elclickdelboton(e) {
      console.log(e.name)

    <? if($monto>0) { ?>
      if(e.name == "payu"){
        document.getElementById('pedido').action = "<?=$action_form?>";
        document.getElementById('pedido').submit();      
      }
      if(e.name == "entrega"){
        document.getElementById('pedido').action = "actualizar-contra-entrega";
        document.getElementById('pedido').submit();      
      }      
    <? }else{ ?>
      alert("El carro de compras está vacío...")
    <? } ?>

    }
  </script>
  
</body>
</html>