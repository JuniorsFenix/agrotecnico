<?php
    if(!session_id()) session_start();
	include("../include/funciones_public.php");
	require_once("inc/functions.php");
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	include("../admin/vargenerales.php");
	
	$generales = datosGenerales();
    $nConexion = Conectar();

	$total=totalCarro();
		
	if( isset( $_SESSION["descuento"] ) && $_SESSION["descuento"]!="" ) {
		$total=totalCarro()-$_SESSION["descuento"];
	}
  
	if( isset( $_POST['descuento'] ) && $_POST['descuento']!="" ) {
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
			// Desactivar el código de descuento.
			$activo = "update tblti_cupones set activo='0' where codigo='$codigo'";
			mysqli_query($nConexion, $activo);
		}
		else
		{
		echo "<script>alert('Este código no es válido o ya ha sido usado');</script>";
		}
	}	
	
	$imagenes=array();
  $ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
  while( $imagen = mysqli_fetch_assoc($ras) ){
    $imagenes[ $imagen["idproducto"] ] = $imagen;
  }
	
	if(!empty($rxProducto["titulo"]))
	{
		$titulo = $rxProducto["titulo"];
	}
	else
	{
		$titulo = $sitioCfg["titulo"];
	}
	
	if(!empty($rxProducto["metaDescripcion"]))
	{
		$descripcion = $rxProducto["metaDescripcion"];
	}
	else
	{
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
    
    <link href="<?php echo $home; ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo $home; ?>/php/inc/style.css" rel="stylesheet" type="text/css" />    
	<script src="<?php echo $home; ?>/js/modernizr.custom.37797.js"></script> 
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  
    <script type="text/javascript" src="<?php echo $home; ?>/php/inc/js/custom.js"></script>
	<script type="text/javascript">
		$(function(){
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
<section class="contenidoInterno">
        <div class="container">
        <div class="cart">

            <form method="post" id="pedido" action="">
            <input type="hidden" value="<?=$total;?>" name="total" />
            <input type="hidden" value="<?=$descuento["efecto"];?>" name="valorDescuento" />
            <input type="hidden" value="" name="actualizarCarro" />
            
            <div class="col-md-6" style="margin-left:auto;margin-right:auto;margin-bottom:40px">
                <div class="table-responsive">
                    <table id="shopping-cart-table" class="data-table cart-table shopping-cart" cellspacing="0" cellpadding="0">
						<thead>
							<tr class="first last">
                                <th class="a-center" rowspan="1"> </th>
                                <th class="a-center">
                                    <span class="nobr">IMAGE</span>
                                </th>
                                <th rowspan="1">
                                    <span class="nobr">PRODUCT</span>
                                </th>
                                <th class="a-center" rowspan="1">COLOR</th>
                                <th class="a-center">
                                    <span class="nobr">SIZE</span>
                                </th>
                                <th class="a-center" colspan="1">SUBTOTAL</th>
                                <th rowspan="1"> </th>
                            </tr>
                        </thead>                        
						<tbody>
                            <?php carro(); ?>
                        </tbody>
                        <tfoot>
                        <tr class="first last">
							<th align="right" colspan="7">
								DISCOUNT CODE
                        <?php 
                            if( isset( $_SESSION["descuento"] ) && $_SESSION["descuento"]!="" ) {?>
								You can only use one code per order
                        <span class="nobr"><input type="button" id="usarDescuento" value="USE" disabled /></span>
                        <?php
                            }
                            else{
                        ?>
                        <input type="text" value="" name="descuento" id="descuento" />
                        <span class="nobr"><input type="button" id="usarDescuento" value="USE" /></span>
                        <?php
                        }
                        ?>
                        <?="$ ".$_SESSION["descuento"];?>
							</th>
                        </tr>
                        <tr class="first last">
							<th align="right" colspan="7">
                        <span class="nobr">TOTAL </span>$ <?php echo $total;?>
                        	</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-md-6" style="margin-left:auto;margin-right:auto;margin-bottom:40px">
                <div class="formPaypal">
					<h3>Customer information</h3>
					<label class="col-md-12"><input id="correo" name="correo_electronico" required="" type="email" placeholder="Email*" /></label>
					<label class="col-md-6"><input id="nombre" name="nombre" required="" type="text" placeholder="First Name*" /></label>
					<label class="col-md-6"><input id="apellido" name="apellido" required="" type="text" placeholder="Last Name*" /></label>
					<label class="col-md-8"><input id="direccion" name="direccion" required="" type="text" placeholder="Address*" /></label>
					<label class="col-md-4"><input id="extra" name="extra" type="text" placeholder="Apt, suite, etc. (optional)" /></label>
					<label class="col-md-12"><input id="ciudad2" name="ciudad2" type="text" required="" placeholder="City*" /></label>
					<label class="col-md-5">      
						<select name="country" id="country">
							<option value="">Country</option>
						<?php
							$sql="select id,country from countries order by country";
							$ra = mysqli_query($nConexion,$sql);
							while($rax=mysqli_fetch_assoc($ra)):?>
							<option value="<?=$rax["id"];?>"><?=$rax["country"];?></option>
						<?php endwhile;?>
						</select>
					</label>
					<label class="col-md-5">
						<select name="state" id="state">
						<option value="">State</option>
						</select>
					</label>
					<label class="col-md-2"><input id="zipcode" name="zipcode" type="text" placeholder="Zipcode" /></label>
					<label class="col-md-12"><input id="telefono" name="telefono" type="text" placeholder="Phone (optional)" /></label>
                    <input type="button" id="cmdEnviar" value="Checkout" onclick="elclickdelboton()";  />
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
	});   


</script>
<script type="text/javascript">

function elclickdelboton() {
	if( $('#nombre').val() == 0) {  
		alert('Please fill out your name'); 
		return false;
	}
	if( $('#cedula').val() == 0) {  
		alert('Please fill out your id'); 
		return false;
	}
	if( $('#correo').val() == 0) {  
		alert('Please fill out your e-mail'); 
		return false;
	}
	if( $('#telefono').val() == 0) {  
		alert('Please fill out your phone number'); 
		return false;
	}
	if( $('#direccion').val() == 0) {  
		alert('Please fill out your address'); 
		return false;
	}
	if( $('#ciudad2').val() == 0) {  
		alert('Please first calculate shipping cost'); 
		return false;
	}
	if( $('#metodoEnvio').val() == 0) {  
		alert('Please fill out your details'); 
		return false;
	}			
	else{
		submitForm('<?php echo $home;?>/confirm-order');
	}
}
</script>
</body>
</html>