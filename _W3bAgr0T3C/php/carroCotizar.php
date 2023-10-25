<?php
  include("diasiniva.php");

  if(!session_id()) session_start();

  $_SESSION["pais"] = "CO";

//var_dump ($_SESSION);

  include("../include/funciones_public.php");
	require_once("inc/functions.php");
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	include("../admin/vargenerales.php");
	
	$generales = datosGenerales();
    $nConexion = Conectar();

    $sql="SELECT * FROM tblti_cotizaciones_clientes ORDER BY nombre";
    $result = mysqli_query($nConexion,$sql);
    $clientes = array();
    while($row = mysqli_fetch_array($result)) {
        $clientes[] = $row;
    }

	if(isset($_POST['delete'])) {
		unset($_SESSION["descuento"]);
	}

	//$total=totalCarro();
  /* EFP Lenguaje */
  //$tot = totalCarro();  // Devuelve un array con los precios es y en
  $total = totalCarro();
  //$totalEN = $tot["en"];

	$sinIva = $total;	
	$iva = $sinIva * .19;
	$total = $total;

	if( isset( $_SESSION["descuento"] ) && $_SESSION["descuento"]!="" ) {
		$total=totalCarro()-$_SESSION["descuento"];
	}  

	if( isset( $_POST['descuento'] ) && $_POST['descuento']!="" && !isset($_SESSION["descuento"]) ) {
	  $codigo=$_POST['descuento'];
    
		//Verificar el código en la base de datos
		$ip_sql=mysqli_query($nConexion,"select * from tblti_cupones where codigo='$codigo' and activo='1'");
		$count=mysqli_num_rows($ip_sql);
		$descuento=mysqli_fetch_assoc($ip_sql);		

		if($count==1){
			// Aplicar descuento.
			if($descuento["tipo"]==0){
        $valorDescuento=$_POST['total']*($descuento["efecto"] / 100);
        $total=$total-$valorDescuento;
        $_SESSION["descuento"] = $valorDescuento;
			}else{
        $total=$total-$descuento["efecto"];
        $_SESSION["descuento"] = $descuento["efecto"];
			}
		}else{
      echo "<script>alert('Este código no es válido o ya ha sido usado');</script>";
		}
	}	
  
  $envio = $_POST["valorEnvio"] * 3000;
  $envioEN = $_POST["valorEnvio"] ;
  
	$total = $total ;
	//$totalEN = $totalEN;
  
	/*$precioEN = $_POST["valorEnvio"];
  $precio = $_POST["valorEnvio"] * 3000;*/

	$imagenes=array();
  $ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
  while( $imagen = mysqli_fetch_assoc($ras) ){
    $imagenes[ $imagen["idproducto"] ] = $imagen;
  }

	if(!empty($rxProducto["titulo"])){
		$titulo = $rxProducto["titulo"];
	}else{
		$titulo = $sitioCfg["titulo"];
	}
	
	if(!empty($rxProducto["metaDescripcion"])){
		$descripcion = $rxProducto["metaDescripcion"];
	}else{
		$descripcion = $generales['descripcion_productos'];
	}	

	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title>Shopping cart - <?php echo $titulo; ?></title>
    <meta name="description" content="<?php echo $descripcion; ?>">
    <meta name="keywords" content="<?php echo $palabras; ?>">
	<?php echo $RegContenido->contenido; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">    

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $home; ?>/php/slim-select/dist/slimselect.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">

  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  

    <script type="text/javascript" src="<?php echo $home; ?>/php/inc/js/custom.js"></script>
    <script type="text/javascript" src="<?php echo $home; ?>/php/slim-select/dist/slimselect.min.js"></script>

    <style type="text/css">
      #opener {
          background: #C9AF34;
          color: #FFF;
          margin-top: 11px;
          overflow: hidden;
          border: none;
          padding: 10px 20px;
          border-radius: 5px;
          /*box-shadow: 0 0 3px black;*/
          transition: all 0.3s ease 0s;
          cursor: pointer;              
      }
      #opener:hover{
        transform:scale(1.1);          
      }
    </style>

  <!-- Event snippet for Agregar al carrito conversion page 
  <script>
    gtag('event', 'conversion', {'send_to': 'AW-665003357/GH9eCPWv1MgBEN3KjL0C'});
  </script>-->

	<script type="text/javascript">

    // Envios por Coordinadora

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
        $("#departamento").append( new Option( key["nombre"] , key["codigo"] ) );
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
      //console.log("listarCiudadesDpt: " + dpt)      
      $('#ciudadDpt').html('');
      $('#ciudadDpt').append('<option value="" disabled selected="selected">Ciudad</option>');

      dataCiudades["item"].forEach(function(key){              
        if(dpt==key["codigo_departamento"]) {
          $("#ciudadDpt").append( new Option( key["nombre"] , key["codigo"] ) );
        }
      })
    }

    function populate(frm, data) {
      $.each(data, function(key, value){
        if(key=='departamento'){
          $('[name='+key+']', frm).val(value);
          listarCiudadesDpt(value);
        } else {
          $('[name='+key+']', frm).val(value);
        }
      });
    }

	</script>
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?php echo $sitioCfg["analytics"]; ?>');</script>
    <!-- End Google Tag Manager -->
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $sitioCfg["analytics"]; ?>"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
<!--- Sección de menú --->
<?php require_once("header.php");?>
	<!--- Sección de menú --->
	<div class="principal">
		<div id="skrollr-body">

<!--- Sección de Noticias/tendencias ---> 
<!-- carro.php -->
      <section class="contenidoInterno">     
        <div class="container container-producto">
          <div class="cart">
        
            <form method="post" id="pedido" action="">
              <!-- EFP Lenguaje-->
              <input type="hidden" value="<?=$total;?>" name="total" />
              <input type="hidden" value="<?=$totalEN;?>" name="totalEN" />
              
              <input type="hidden" value="<?php echo sprintf("%.2f", $total);?>" name="total" />
              <input type="hidden" value="<?php echo sprintf("%.2f", $sinIva);?>" name="sinIva" />
              <input type="hidden" value="<?php echo sprintf("%.2f", $iva);?>" name="iva" />
              
              <input type="hidden" value="<?=$_SESSION["descuento"];?>" name="valorDescuento" />
              <input type="hidden" value="<?=$envio;?>" name="valorEnvio" id="valorEnvio" required />
              <input type="hidden" value="<?=$envioEN;?>" name="valorEnvioEN" id="valorEnvioEN" required />
              <input type="hidden" value="" name="actualizarCarro" />
              
              <div class="col-md-12" style="margin-left:auto;margin-right:auto;margin-bottom:40px">
                <div class="table-responsive">
                  <table id="shopping-cart-table" class="data-table cart-table shopping-cart" cellspacing="0" cellpadding="0">
                    <thead>
                      <tr class="first last">
                        <th class="a-center" rowspan="1"> </th>
                        <th class="a-center">
                        </th>

                        <th rowspan="1">
                          <span class="nobr">Producto</span>
                        </th>
                                        
                        <th class="a-center" rowspan="1">
                          Precio
                        </th>
                        
                        <th class="a-center">
                          <span class="nobr">
                            Cantidad
                          </span>
                        </th>

                        <th class="a-center" colspan="1">Descuento</th>

                        <th class="a-center" colspan="1">Accesorios</th>
                                        
                        <th class="a-center" colspan="1">Subtotal</th>
                          <th rowspan="1"> </th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php echo carro(); ?>

                    </tbody>

                    <tfoot>
<!--                    
                      <tr class="first last">
                        <th colspan="7" style="text-align: right;">
                          <span class="nobr">SUBTOTAL: </span><?php echo "COP ".number_format( ($sinIva), 0, ',', '.' );?>
                        </th>
                      </tr>
                      <tr class="first last" style="text-align: right;">
                        <th colspan="7" >
                          <span class="nobr">IVA(19%): </span><?php echo "COP ".number_format( ($iva), 0, ',', '.' );?>
                        </th>
                      </tr>
-->
                      <!--
                      <tr class="first last descuento">
                        <th align="right" colspan="7">
                          <?php 
                            if( isset( $_SESSION["descuento"] ) && $_SESSION["descuento"]!="" ) { ?>
                              You can only use one discount code per order
                              <span class="nobr"><input type="hidden" name="delete" value="1" /><input type="button" id="delete" class="usarDescuento" value="DELETE" /></span>
                            <?php }else{ ?>
                              DISCOUNT CODE 
                              <input type="text" value="" name="descuento" id="descuento" />
                              <span class="nobr"><input type="button" id="usarDescuento" class="usarDescuento" value="USE" /></span>
                          <?php } ?>
                          <?="$ ".$_SESSION["descuento"];?>
                        </th>
                      </tr>
                      -->
                      
                      <?php if($_SESSION["pais"] != "CO") { ?>
                        <tr class="first last" id="envios">
                          <th align="right" colspan="7">ENVÍO: 
                            <span id="vlrenvio">                            
                              <?php 
                                if($_SESSION["pais"] == "CO"){
                                  echo "COP ".number_format( $envio, 0, ',', '.' );
                                }else{
                                  echo "USD ".number_format( $envioEN, 2, '.', '' );
                                }                  
                              ?>
                            </span>
                          </th>
                        </tr>
                      <?php }?>
                      
                      <tr class="first last">
                        <th colspan="7" style="text-align: right; text-align: right;color: #38892F;font-weight: bold;font-size: 1.4rem;">
                          <span class="nobr">TOTAL: </span>
                            <?php 
                              if($_SESSION["pais"] == "CO"){
                                echo "COP ".number_format( $total, 0, ',', '.' );
                              }else{
                                echo "USD ".number_format( $totalEN + $envioEN, 2, '.', '' );
                              }                  
                            ?>                          
                        </th>
                      </tr>                    

                    </tfoot>
                  </table>
                </div>
              </div>

              <div class="col-md-9" style="margin-left:auto; margin-right:auto;">
                <div class="formPaypal">
                  <h3>Información del cliente</h3>

                  <div class="row">
                  <label class="col-md-6">
                    <select class="buscarCliente" id="buscarNombre">
                      <option disabled selected>Buscar por nombre</option>
                      <?php
                        foreach($clientes as $row) {
                          echo "<option value='{$row['id']}'>{$row['nombre']} {$row['apellido']}</option>";
                      } ?>
                    </select>
                  </label>
                  <label class="col-md-6 border-left-0">
                    <select class="buscarCliente" id="buscarId">
                      <option disabled selected>Buscar por identificación</option>
                      <?php
                        foreach($clientes as $row) {
                          echo "<option value='{$row['id']}'>{$row['identificacion']}</option>";
                      } ?>
                    </select>
                  </label>
                  </div>

                  <label class="col-md-12"><input id="correo" name="correo_electronico" required type="email" placeholder="Correo*" /></label>
                  
                  <label class="col-md-4"><input id="nombre" name="nombre" required type="text" placeholder="Nombres*" /></label>
                  <label class="col-md-8"><input id="apellido" name="apellido" required type="text" placeholder="Apellidos*" /></label>

                  <label class="col-md-4" style="margin-bottom:0">
                    <select name="tipoid" id="tipoid" onchange="">
                      <option disabled selected>Tipo de identificación *</option>
                      <option value="Cédula">Cédula</option>
                      <option value="NIT">NIT</option>
                    </select>
                  </label>                  
                  <label class="col-md-8" style="margin-bottom:0"><input id="identificacion" name="identificacion" required type="text" placeholder="Número de Identificación*" /></label>
                  <label class="col-md-12" id="infotipoid" style="color:green; font-size:0.8rem"></label>
                  
                  <label class="col-md-12"><input id="direccion" name="direccion" required type="text" placeholder="Dirección*" /></label>
                  
                  <label class="col-md-4">
                    <select id="departamento" name="departamento">
                      <option  disabled selected  >Departamento</option>
                    </select>
                  </label>

                  <label class="col-md-8">
                    <select id="ciudadDpt" name="ciudadDpt">
                      <option  disabled selected >Ciudad</option>
                    </select>
                  </label>
                  
                  <input type="hidden" value="" id="strdepartamento" name="strdepartamento" />
                  <input type="hidden" value="" id="strciudad" name="strciudad" />
                  <input type="hidden" value="" id="codigocoor" name="codigocoor" />
                  
                  <label class="col-md-4">
                    <input id="telefono" name="telefono" required type="text" placeholder="Teléfono*" />
                  </label>

                  <label class="col-md-4">      
                    <input id="metodoPago" name="metodoPago" type="text" placeholder="Método de pago" />
                  </label>

                  <label class="col-md-12">
                    <input id="garantia" name="garantia" required type="text" placeholder="Garantía *" />
                  </label>
                  <label class="col-md-12">
                    <input id="flete" name="flete" required type="text" placeholder="Flete *" />
                  </label>
                  <label class="col-md-12">
                    <input id="descuentoTXT" name="descuentoTXT" required type="text" placeholder="Descuento *" />
                  </label>
                  <label class="col-md-12">
                    <input id="validez" name="validez" required type="text" placeholder="Validez de la oferta *" />
                  </label>
                  <label class="col-md-12">
                    <input id="entrega" name="entrega" required type="text" placeholder="Tiempo de entrega *" />
                  </label>


                  <label class="col-md-12">
                    <input id="extra" name="extra" type="text" placeholder="Observaciones" />
                  </label>
                                    
                  <label class="col-md-12" style="text-align:center;font-size: 0.9rem; color: #c0c0c0; padding: 0 1vw 0 4vw;">
                  <br>
                
                  <div  style="width:100%; text-align:center;">
                    <input type="button" class="btn btn-dark" id="cmdEnviar" value="Cotizar" onclick="elclickdelboton()";  />
                  </div>
                  <br><br><br>
                </div>
              </div>

            </form>

            <div class="clear"></div>
          </div>
        </div>
        
      </section>    

  <!--- Sección de Creado por --->
<?php //require_once("footer.php");?>
	<!--- Sección de Creado por --->
			<style>
			    .logo{
			        display:none !important;
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


  <script>
    function submitForm(action) {
        document.getElementById('pedido').action = action;
        document.getElementById('pedido').submit();
    }
  </script>

  <script>
    $(document).ready(function(){

      get_departamentos()

      $('#usarDescuento').click(function() {
        if( $('#descuento').val() == 0) {  
          alert('Debe ingresar el código'); 
          return false;
        }
        else{
          submitForm('<?php echo $home;?>/shopping-cart');
        }
      }); 
      $('#delete').click(function() {
        submitForm('<?php echo $home;?>/shopping-cart');
      });
        new SlimSelect({
            select: '#buscarNombre',
            searchPlaceholder: 'Buscar',
            searchText: 'No hay resultados'
        });
        new SlimSelect({
            select: '#buscarId',
            searchPlaceholder: 'Buscar',
            searchText: 'No hay resultados'
        });
    });

    
		$('body').on('change', '#departamento', function(event) {
			event.preventDefault();
      
			var departamento = $('#departamento').val();
      document.getElementById("strdepartamento").value = $("#departamento option:selected" ).text();

      listarCiudadesDpt(departamento);
		});

		$('body').on('change', '#ciudadDpt', function(event) {
			event.preventDefault();
      
      document.getElementById("strciudad").value= $("#ciudadDpt option:selected" ).text();
		});

    $('body').on('change', '.buscarCliente', function(event) {
      event.preventDefault();

			var val = $(this).val();
      $.ajax({
        type:"POST",
        url:"/php/ajax_clientes.php",
        data: 'id='+val,
        success: function(data){
          populate('#pedido', $.parseJSON(data));
        }
      });
    });

    
  </script>

  <script type="text/javascript">

    $( "select" )
      .change(function() {
        
        var str = "";
        $( "select option:selected" ).each(function() {
          str += $( this ).text() + " ";
        });
    })

    function elclickdelboton() {
      if( !$('#tipoid').val() ) {  
        alert('Por favor seleccione el tipo de identificación'); 
        return false;
      }      
      if( $('#correo').val() == 0) {  
        alert('Por favor coloque el correo electrónico'); 
        return false;
      }
      if( $('#nombre').val() == 0) {  
        alert('Por favor coloque el nombre'); 
        return false;
      }      
      if( $('#apellido').val() == 0) {  
        alert('Por favor coloque el apellido'); 
        return false;
      }

      if( $('#identificacion').val() == 0) {  
        alert('Por favor coloque la identificación'); 
        return false;
      }
      
      if( $('#direccion').val() == 0) {  
        alert('Por favor coloque la dirección'); 
        return false;
      }

      if( !$('#departamento').val()  ) {  
        alert('Por favor coloque el departamento'); 
        return false;
      }      
      if( !$('#ciudadDpt').val() ) {  
        alert('Por favor coloque la ciudad'); 
        return false;
      }      

      if( $('#telefono').val() == 0) {  
        alert('Por favor coloque el teléfono'); 
        return false;
      }

      else{
        submitForm('<?php echo $home;?>/confirmar-cotizacion');
      }
    }
  </script>

</body>
</html>