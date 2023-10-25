<?php
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
			}
			else{
			$total=$total-$descuento["efecto"];
			$_SESSION["descuento"] = $descuento["efecto"];
			}
		}
		else
		{
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

    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">

  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  

    <script type="text/javascript" src="<?php echo $home; ?>/php/inc/js/custom.js"></script>
    <script type="text/javascript" src="<?php echo $home; ?>/php/js/mustache.min.js"></script>

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

  <!-- Global site tag (gtag.js) - Google Ads: 665003357 --> 
  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-665003357"></script> 
  <script> 
    window.dataLayer = window.dataLayer || []; 
    function gtag(){dataLayer.push(arguments);} 
      gtag('js', new Date());
      gtag('config', 'AW-665003357'
    );
  </script>

  <!-- Event snippet for Agregar al carrito conversion page -->
  <script>
    gtag('event', 'conversion', {'send_to': 'AW-665003357/GH9eCPWv1MgBEN3KjL0C'});
  </script>

	<script type="text/javascript">

		$(function()
    {
          $('input:radio[name=optradio]').change(function() 
          {
            var ck1 = ( $("#chkdhl").is(':checked') ? "inline-block" : "none" );
            var ck2 = ( $("#chkusps").is(':checked') ? "inline-block" : "none" );
            $("#dhl").attr({ style : "display:" + ck1 })
            $("#usps").attr({ style : "display:" + ck2 })

          });

          var Depmentos = [];
          var Municipios = [];

          $.ajax({
              url: "https://www.datos.gov.co/resource/krpp-ufw8.json",
              type: "GET",
              data: {
                "$$app_token" : "9oK7vjZHrJphwZ93PwWxeBoCh"
              }
          }).done(function(Pais) 
          {
                for(var Depto in Pais)
                {
                  var NewDepto = {
                     Code: Pais[Depto].codigo_departamento,
                     Name: Pais[Depto].nombre_departamento
                  }
                   
                  if( getKeyByDepto(Depmentos, Pais[Depto].nombre_departamento) == -1 )
                    Depmentos.push( NewDepto );
                }

                Depmentos.sort(sort);

                for( Dep in Depmentos )
                  $("#Depto").append( new Option( Depmentos[Dep].Name , Depmentos[Dep].Code ) );
          });

          function LoadSelect(Code)
          {
             Municipios = []

             $.ajax({
               url: "https://www.datos.gov.co/resource/krpp-ufw8.json?tipo=Urbano&codigo_departamento="+Code,
               type: "GET",
               data: {
                "$$app_token" : "9oK7vjZHrJphwZ93PwWxeBoCh"
               },
               success: function(json)
               {
                      for(var Munic in json)
                  {
                        var Vr = json[Munic]. veredas_contenidas_en_el_codigo_postal
                    var Nm = ( Vr != "Sin Informacion de Veredas" ? Vr : json[Munic].nombre_municipio )

                    var NewDepto = {
                      Code: json[Munic].codigo_postal,
                      Name: "[" + json[Munic].nombre_municipio + "] " + Nm
                    }
                       
                    if( getKeyByDepto(Municipios, "[" + json[Munic].nombre_municipio + "] " + Nm) == -1 )
                      Municipios.push( NewDepto );
                  }

                      Municipios.sort(sort);
                      $("#Muni").html("");

                      for( Mun in Municipios )
                        $("#Muni").append( new Option( Municipios[Mun].Name , Municipios[Mun].Code ) );
               }
             });
          }

          $("#Depto").change(function()
          {
            LoadSelect( $(this).val() )
          });

          $("#btnSned").click(function()
          {
            var ZipCode = $("#cities").val();

            if( parseInt(ZipCode) > 0 )
            {
              ZipCodeValidate(ZipCode)

              var xml = "https://secure.shippingapis.com/ShippingAPI.dll?API=RateV4&XML= " +
                          "<RateV4Request USERID='216LEGAT2177'> " +
                            "<Package ID='0'> " +
                              "<Service>Priority Mail</Service> " +
                              "<FirstClassMailType>RETAIL</FirstClassMailType> " +
                              "<ZipOrigination>33436</ZipOrigination> " +
                              "<ZipDestination>"+ZipCode+"</ZipDestination> " +
                              "<Pounds>1</Pounds> " +
                              "<Ounces>0.00</Ounces> " +
                              "<Container>Variable</Container> " +
                              "<Size>Regular</Size> " +
                              "<Width>9</Width> " +
                              "<Length>3</Length> " +
                              "<Height>9</Height> "+
                            "</Package> " +
                          "</RateV4Request>";
                $.ajax({
                  url : xml,
                  type : 'GET',
                  dataType : 'xml',
                  success : function(xml) 
                  {
                    $(xml).find('Package').each(function()
                    {
                      var sError = $(this).find('Error').text();
                      if( sError.length > 0 )
                      {
                        $(this).find('Description').each(function()
                        {
                           alert( $(this).text() ); 
                        });
                      }
                      else
                      {
                         $("#vlrenvio").html($(this).find('Rate').text());
                         $("#valorEnvio").val($(this).find('Rate').text());
                         document.getElementById("pedido").submit();
                      }
                    });
                  }
                });
            }
            else
              alert("Select your Country for your shipment");
          });

          $("#btnDHL").click(function()
          {
             if( $("#Muni").val() != "" )
             {
                $.ajax({
                  url : "https://legattofashion.com/php/DHL/CalRN.php",
                  type: 'POST',
                  data: {
                     Zip: ( $("#Muni").val().length == 5 ? '0' : '' )+$("#Muni").val()
                  },
                  dataType : 'json',
                  success : function(xml) 
                  {
                     $("#vlrenvio").html( (xml.GetQuoteResponse.BkgDetails.QtdShp[0].ShippingCharge.replace(".", "") / 3000 ).toFixed(2));
                     $("#valorEnvio").val( (xml.GetQuoteResponse.BkgDetails.QtdShp[0].ShippingCharge.replace(".", "") / 3000 ).toFixed(2));
                     document.getElementById("pedido").submit();
                  }
              });
             }
             else 
              alert("Seleccione Municipio");
          });

          //Load Estado
          var template = '<select name="province" id="province" class="form-control">'+
                           '{{#options}}' +
                             '<option value="{{title}}">{{title}}</option>' + 
                           '{{/options}}'+
                         '</select>';
          // Load Condado
          var templete = '<select name="city" id="city" class="form-control">'+
                           '{{#options}}' +
                             '<option value="{{County}}">{{County}}</option>' + 
                           '{{/options}}'+
                         '</select>';
          //Ciudad
          var templeti = '<select name="cities" id="cities" class="form-control">'+
                           '{{#options}}' +
                             '<option value="{{ZIP Code}}">{{City Name}}</option>' + 
                           '{{/options}}'+
                         '</select>';
          
          //Load Estado
          $.ajax({
              url : 'https://usa.youbianku.com/state-json',
              type : 'GET',
              dataType : 'json',
              success : function(json) 
              {
                var state = [{title : 'Select State'}];
                for(var nod in json.nodes)
                  state.push(json.nodes[nod].node); 

                var data = {
                  options:state
                }
                var html = Mustache.to_html(template, data);
                $("#stateusp").html(html);
              }
          });

          // Load Condado
          $("#stateusp").on('change','select', function()
          {
             $("#cities").html("");
             $("#rate").val("");
             $("#descrip").val("");
             $.ajax({
                url : 'https://usa.youbianku.com/state-county-json/'+$(this).val(),
                type : 'GET',
                dataType : 'json',
                success : function(json) 
                {
                  var city = [{County : 'Select County'}];
                  for(var nod in json.nodes)
                    city.push(json.nodes[nod].node); 

                  var data = {
                    options:city
                  }
                  var html = Mustache.to_html(templete, data);
                  $("#dcity").html(html);
                }
             });
          });

          //Ciudad
          $("#dcity").on('change','select', function()
          {
             $("#rate").val("");
             $("#descrip").val("");
             $.ajax({
                url : 'https://usa.youbianku.com/county-city-json/'+$(this).val(),
                type : 'GET',
                dataType : 'json',
                success : function(json) 
                {
                  var city = [];
                  for(var nod in json.nodes)
                    city.push(json.nodes[nod].node); 

                  var data = {
                    options:city
                  }
                  var html = Mustache.to_html(templeti, data);
                  $("#dcities").html(html);
                }
             });
          });

          //Validar
          $("#dcities").on('change','select', function()
          {
              ZipCodeValidate($(this).val())
          });

          function ZipCodeValidate(ZipCode)
          {
             var xml = "https://secure.shippingapis.com/ShippingAPI.dll?API=CityStateLookup&XML=" +
                        "<CityStateLookupRequest USERID=\"216LEGAT2177\"> " +
                          "<ZipCode ID='0'> " +
                             "<Zip5>"+ZipCode+"</Zip5> " +
                          "</ZipCode> " +
                        "</CityStateLookupRequest>";
             $.ajax({
                url : xml,
                type : 'GET',
                dataType : 'xml',
                success : function(xml) 
                {
                  $(xml).find('ZipCode').each(function()
                  {
                    var sError = $(this).find('Error').text();
                    if( sError.length > 0 )
                    {
                      $(this).find('Description').each(function()
                      {
                         alert( $(this).text() ); 
                      });
                    }
                  });
                }
             });
          }

          var getKeyByDepto = function(obj, Depto) 
          {
              var returnKey = -1;

              $.each(obj, function(key, info) {
                  if (info.Name == Depto) {
                     returnKey = key;
                      return false; 
                  };   
              });
              
              return returnKey;          
          }

          function sort(a,b)
          {
            a = a.Name;
            b = b.Name;

            if(a < b)  {
              return -1;
            } 
            else if (a > b) {
              return 1;
            }
            return 0;
          }

    		  $("#cantidad").change(function()
    		  {
    		   var id=$(this).val();
    		   var dataString = 'id='+ id;
    		   $(".cesta a").removeClass();
    		   $(".cesta a").addClass(id);
    		  });

		});
	</script>

</head>

<body>  
<!--- Sección de menú --->
<?php require_once("header.php");?>
	<!--- Sección de menú --->
	<div class="principal">
		<div id="skrollr-body">
<!--- Sección de banner --->
      <?php echo cabezoteJqueryIn(2,"carousel"); ?>
<!--- Sección de banner --->   

<!--- Sección de Noticias/tendencias ---> 
<!-- carro.php -->
      <section class="contenidoInterno">     
        <div class="container">
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
              
              <div class="col-md-6" style="margin-left:auto;margin-right:auto;margin-bottom:40px">
                <div class="table-responsive">
                  <table id="shopping-cart-table" class="data-table cart-table shopping-cart" cellspacing="0" cellpadding="0">
                    <thead>
                      <tr class="first last">
                        <th class="a-center" rowspan="1"> </th>
                        <th class="a-center">
                          <span class="nobr">IMAGEN</span>
                        </th>

                        <th rowspan="1">
                          <span class="nobr">PRODUCTO</span>
                        </th>
                                        
                        <th class="a-center" rowspan="1">
                          <!--COLOR-->
                        </th>
                        
                        <th class="a-center">
                          <span class="nobr">
                            <!--TALLA-->
                          </span>
                        </th>
                                        
                        <th class="a-center" colspan="1">SUBTOTAL</th>
                          <th rowspan="1"> </th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php carro(); ?>

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

              <div class="col-md-6" style="margin-left:auto; margin-right:auto;">
                <div class="formPaypal">
                  <h3>Información del cliente</h3> 
                  <label class="col-md-12"><input id="correo" name="correo_electronico" required type="email" placeholder="Correo*" /></label>
                  
                  <label class="col-md-4"><input id="nombre" name="nombre" required type="text" placeholder="Nombres*" /></label>
                  <label class="col-md-8"><input id="apellido" name="apellido" required type="text" placeholder="Apellidos*" /></label>
                  <label class="col-md-12"><input id="identificacion" name="identificacion" required type="text" placeholder="Cedula de identidad*" /></label>
                  
                  <label class="col-md-12"><input id="direccion" name="direccion" required type="text" placeholder="Dirección*" /></label>
                  
                  <label class="col-md-4"><input id="extra" name="extra" type="text" placeholder="Apt, piso, etc. (opcional)" /></label>
                  <label class="col-md-8"><input id="ciudad2" name="ciudad2" type="text" required placeholder="Ciudad*" /></label>
                  
                  <label class="col-md-4">      
                    <select name="country" id="country">
                      <option value="">País</option>
                    <?php
                      $sql="select id,country from countries order by country";
                      $ra = mysqli_query($nConexion,$sql);
                      while($rax=mysqli_fetch_assoc($ra)):?>
                      <option value="<?=$rax["id"];?>"><?=$rax["country"];?></option>
                    <?php endwhile;?>
                    </select>
                  </label>
                  <label class="col-md-4">
                    <select name="state" id="state">
                      <option value="">Estado</option>
                    </select>
                  </label>
                  <label class="col-md-4"><input id="zipcode" name="zipcode" type="text" placeholder="Código postal" /></label>
                  
                  <label class="col-md-12"><input id="telefono" name="telefono" required type="text" placeholder="Teléfono*" /></label>
                  <div  style="width:100%; text-align:center;">
                    <input type="button" class="btn btn-dark" id="cmdEnviar" value="Comprar" onclick="elclickdelboton()";  />
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
<?php require_once("footer.php");?>
	<!--- Sección de Creado por --->

		</div>
	</div>

	<script>
		$('body').on('change', '#country', function(event) {
			event.preventDefault();
			var pcategoria = $('#country').val();
			$.post(
				'<?php echo $home;?>/php/ajaxDepartamentos.php', {
				categoria: pcategoria
			},
			function(data) {
				$('#state').html(data);
			});
		});
		$('body').on('change', '#country2', function(event) {
			event.preventDefault();
			var pcategoria = $('#country2').val();
			$.post(
				'<?php echo $home;?>/php/ajaxDepartamentos.php', {
				categoria: pcategoria
			},
			function(data) {
				$('#state2').html(data);
			});
		});

		$(document).ready(function() 
    {
			$("#sameBilling").click(function() 
      {
				if($(this).is(":checked")) {
					$("#billing").hide(200);
				} else {
					$("#billing").show(300);
				}
			});
		});
		
	  $( function() 
    {
    		$( "#dialog" ).dialog({
    		  autoOpen: false,
    		  show: {
    			effect: "blind",
    			duration: 1000
    		  },
    		  hide: {
    			effect: "explode",
    			duration: 1000
    		  }
    		});

		    $( "#opener" ).on( "click", function() {
		      $( "#dialog" ).dialog( "open" );
		    });
	  });
		  
		function buscarcostoenvio() 
    {
			var vpais = $("#pais").val();

			var varurl = '/tasas/fletestnt.php?pais=';
			var res = varurl.concat(vpais);

			$.ajax({
				url:   res,
				type:  'post',
				beforeSend: function () {
				  //$("#resultado").html("Procesando, espere por favor...");
				},
				success:  function (response) 
				{
					if (response != "No se puede calcular") {
					  $("#vlrenvio").html(response);
					  $("#valorEnvio").val(response);
					  document.getElementById("pedido").submit();
					} 
                    else {
						alert("El costo de ese envio no se ha podido calcular, asegurese de que los datos ingresados sean correctos")
					}
				}
			});
		}
	</script>

  <script>
    function submitForm(action)
    {
        document.getElementById('pedido').action = action;
        document.getElementById('pedido').submit();
    }
  </script>

  <script>
    $(document).ready(function(){
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
    });   
  </script>

  <script type="text/javascript">
    function elclickdelboton() {
      
      <?php if($_SESSION["pais"] != "CO") { ?>                      
        if( $('#valorEnvio').val() == 0) {  
          alert('You have to calculate the shipping cost'); 
          return false;
        }
      <?php }?>
      
      if( $('#correo').val() == 0) {  
        alert('Por favor coloque su correo electrónico'); 
        return false;
      }
      if( $('#nombre').val() == 0) {  
        alert('Por favor coloque su nombre'); 
        return false;
      }      
      if( $('#apellido').val() == 0) {  
        alert('Por favor coloque su apellido'); 
        return false;
      }

      if( $('#identificacion').val() == 0) {  
        alert('Por favor coloque su identificación'); 
        return false;
      }
      
      if( $('#direccion').val() == 0) {  
        alert('Por favor coloque su dirección'); 
        return false;
      }
      if( $('#ciudad2').val() == 0) {  
        alert('Por favor coloque su ciudad'); 
        return false;
      }      
      if( $('#country').val() == 0) {  
        alert('Por favor coloque su país'); 
        return false;
      }
      if( $('#telefono').val() == 0) {  
        alert('Por favor coloque su teléfono'); 
        return false;
      }
      else{
        submitForm('<?php echo $home;?>/confirmar-pedido');
      }
    }
  </script>

</body>
</html>