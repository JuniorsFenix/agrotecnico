<?php  
  // https://agrotecnico.com.co/php/actualizarEstado_WOMPI.php?test=1&pedido=Agrotecnico00611CO
  // https://agrotecnico.com.co/actualizar-orden-WOMPI?test=1&pedido=Agrotecnico00611CO
  // /v1/transactions/12747-1594477326-39245

  include("diasiniva.php");
  
  $adjuntar_CO = true;
  $adjuntar_US = true;
  $impuesto    = true;
  $enviar_correo = true;

	require_once dirname(__FILE__).("/../include/connect.php");
	require_once dirname(__FILE__).("/../include/funciones_public.php");
  $nConexion    = Conectar();
	/*$nConexionPub = Conectar();*/

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../admin/herramientas/phpmailer/src/Exception.php';
	require '../admin/herramientas/phpmailer/src/PHPMailer.php';
	require '../admin/herramientas/phpmailer/src/SMTP.php';
  include("../admin/herramientas/html2pdf/html2pdf.class.php");
	  
  /* EFP Test */
  if($_GET["test"] == 1) {
    $referenciaPayU = 'Agrotecnico01855CO'; 
    $estado = 'Aprobada';   
  }

  if(!session_id()) session_start();
  $_SESSION["pais"] = substr($referenciaPayU,-2);
  
  // Establece el lenguaje de la factura en funcion del pais remitido 
  $_SESSION["pais"] = "CO";
  if($_SESSION["pais"] != "CO"){
    $_SESSION["lenguaje"] = "en";
  }else{
    $_SESSION["lenguaje"] = "es";
  }

	$d = $_POST;


if ($estado == 'Aprobada') {
  $query = "select * from tblti_carro where referenciaPayU = '{$referenciaPayU}'";
	$result = mysqli_query($nConexion,$query);
	$pedido = mysqli_fetch_assoc($result);

	$sinIva=$pedido["sin_iva"];
	$iva=$pedido["iva"];
	
 	date_default_timezone_set('America/Bogota');
  
	setlocale(LC_ALL, 'en_US.UTF8');

	$fecha = date("d/m/Y");
	ob_start();  
?>

<style type="text/css">
	.factura thead{
		text-align: left;
	}
	.factura th{
		//border-bottom: 1px dotted #000;
	}
	.factura h2{
		text-align: right;
		margin-bottom: 40px;
	}
	.factura h3{
		font-size:10pt;
	}
	.factura table {
		width: 100%;
	}
	.factura .info th{
	}
	.factura .precios th{
		background: #F1F1F1;
	}
	.factura .pedido td{
	}
	.factura .precios th, .factura .precios td{
		//border: 1px dotted #d4d4d4;
		padding: 5px;
	}
	.factura .right, .factura .right th{
		text-align: right;
	}
	.factura .width th{
	}
  
  .productos td, th{
    border:1px solid black;
    font-size:8pt;
  }
</style>
<page style="font-size: 10pt">
	<div class="factura">
  
		<table class="pedido" cellspacing="0" width="100%" cellpadding="6">

      <tbody>
        <tr>
          <td style="width:240px;text-align: left; vertical-align:top;">
            <br><br><br>
            PRE-FACTURA DE VENTA<br><br>
            E-commerce Agrotécnico<br><br>
            Número de pedido:<br>
            <b><?php echo VerSitioConfig("factura_prefijo").$nFactura ?> </b>
          </td>
          <td style="width:240px;">
            <br><br><br>
            Cliente: <?php echo $pedido["nombre"]." ".$pedido["apellido"] ?><br>
            Cedula: <?php echo $pedido["identificacion"] ?><br>
            Ciudad: <?php echo $pedido["ciudad"] ?><br>
            Dirección: <?php echo $pedido["direccion"] ?><br>
            Teléfono: <?php echo $pedido["telefono"] ?><br>
            E-mail: <?php echo $pedido["correo_electronico"] ?><br><br>
            <strong><?php echo ("Fecha del documento");?>: </strong> <?php echo $fecha ?>
          </td>
          <td style="width:240px;">
            <img alt="" src="<?php echo VerSitioConfig("factura_logo");?>" style="width:200px;margin:auto;" />
            <br>
            <?php echo utf8_encode(verContenidoEFP("factura-datos-vendedor"));?>
          </td>
        </tr>

			</tbody>      
		</table>

<!--    
    <br><br><br>

		<table class="productos" cellspacing="" width="100%" cellpadding="6">
			<thead>
				<tr>
					<th style="width:180px;"><?php echo mb_strtoupper(("Vendedor"));?></th>
					<th style="width:180px;"><?php echo mb_strtoupper(("Órden de pedido"));?></th>
					<th style="width:180px;"><?php echo mb_strtoupper(("Fecha"));?></th>
					<th style="width:180px;"><?php echo mb_strtoupper(("Paquetes"));?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><?php echo VerSitioConfig("factura_vendedor");?></td>
					<td><?php echo $pedido["carro"] ?></td>
					<td><?php echo $fecha ?></td>
					<td>1</td>
				</tr>
				<tr>
					<th><?php echo mb_strtoupper(("Pago"));?></th>
					<th><?php echo mb_strtoupper(("Envío"));?></th>
					<th colspan="2"><?php echo mb_strtoupper("Dirección");?></th>
				</tr>
				<tr>
					<td><?php echo ($pedido["medio"]); ?></td>
					<td></td>
					<td colspan="2"><?php echo $pedido["direccion"] . ", " . $pedido["ciudad"]; ?></td>
				</tr>
			</tbody>
		</table>
-->    
    <br><br>

    <div style="width:100%; padding:0px; text-align:center; border:2px solid black;" >
          <b>DETALLE DEL DOCUMENTO</b>
    </div>
    <br>
    
		<table class="productos" style="border:1px solid black;" cellspacing="0" width="100%" cellpadding="6">
			<thead>
				<tr>
					<th style="width:90px;text-align:center;"><?php echo mb_strtoupper(("Cantidad"));?></th>
					<th style="width:100px;text-align:center;"><?php echo mb_strtoupper(("Referencia"));?></th>
					<th style="width:200px;text-align:center;"><?php echo mb_strtoupper(("Descripción"));?></th>
					<th style="width:100px;text-align:center;"><?php echo mb_strtoupper(("Valor (COP)"));?></th>
					<th style="width:100px;text-align:center;"><?php echo mb_strtoupper(("IVA"));?></th>
					<th style="width:100px;text-align:center;"><?php echo mb_strtoupper(("Total (COP)"));?></th>
				</tr>
			</thead>
      
			<tbody>
			<?php 
        $query = "SELECT  a.detalle, a.item, a.talla, a.unidades, 
                          a.precio, a.color, a.idproducto, a.flete,
                          b.referencia,
                          b.diasiniva,
                          b.iva,
                          t.id as idtalla, 
                          c.id as idcolor, 
                          e.id as idestilo 
                    FROM  tblti_carro_detalle a 
                    JOIN  tblti_productos b 
                      ON  (a.idproducto=b.idproducto) 
               LEFT JOIN  tblti_tallas t 
                      ON  (a.talla=t.nombre) 
               LEFT JOIN  tblti_colores c 
                      ON  (a.color=c.nombre) 
               LEFT JOIN  tblti_estilos e 
                      ON  (a.estilo=e.nombre) 
                   WHERE  a.carro = {$pedido["carro"]}
                     AND  a.stihl = 0";
				$result = mysqli_query($nConexion,$query);

        $flete=0;
        $envio = true;
        $total = 0;
        $totaliva = 0;

				while ($row = mysqli_fetch_assoc($result)) {	 
          if($row["flete"]==0){
            $envio=false;
          }                
          $flete += $row["flete"];
        		$divisor = 1 + ($row['iva'] / 100);

 				  if($row["idtalla"]=="")$row["idtalla"]=0;
				  if($row["idcolor"]=="")$row["idcolor"]=0;
				  if($row["idestilo"]=="")$row["idestilo"]=0;
				  $sql="insert into tblti_inventario ( idproducto, operacion, idtalla, idcolor, idestilo, cantidad, motivo, fecha) values ('{$row["idproducto"]}', '-', {$row["idtalla"]}, {$row["idcolor"]}, {$row["idestilo"]}, 1, 'Compra de producto', NOW())";
				  mysqli_query($nConexion,$sql);

          /* INVENTARIO */
          /* $sql="SELECT * from tblti_inventario WHERE idproducto = {$row["idproducto"]}"; */

          $sql="SELECT * from tblti_productos WHERE idproducto = {$row["idproducto"]}";

					$ra = mysqli_query($nConexion,$sql);
         	$in = mysqli_fetch_assoc($ra);

/*
					$inventario = 0;
					if(mysqli_num_rows($ra)>0){
						while($rax=mysqli_fetch_assoc($ra)):
							if($rax["operacion"]=="+"){
								$inventario = $inventario+$rax["cantidad"];
							}
							else{
								$inventario = $inventario-$rax["cantidad"];
							}
						endwhile;
					}
*/          
/*
					$sql = mysqli_query($nConexion,"select porcentaje from tblti_convenios");
					$convenio = mysqli_fetch_assoc($sql);
					$decimal = $convenio["porcentaje"] / 100;
					$comision = $decimal * $row["precio"];
					$pago = $row["precio"]-$comision;
		
					$sql="SELECT idusuario FROM tblti_productos_convenios WHERE idproducto={$row["idproducto"]}";
					$ra = mysqli_query($nConexion,$sql);

					while($rax=mysqli_fetch_assoc($ra)):
						$sql="insert into tblti_convenios_ventas ( idusuario, idproducto, producto, referencia, precio, porcentaje, pago, comision) values ('{$rax["idusuario"]}', '{$row["idproducto"]}', '{$row["item"]}', '{$row["referencia"]}', '{$row["precio"]}', '{$convenio["porcentaje"]}', '$pago', '$comision')";
						mysqli_query($nConexion,$sql);
					endwhile;
					
					if(!empty($pedido["codigo"])){
						$sql = mysqli_query($nConexion,"select comision from tblti_codconfig");
						$codigo = mysqli_fetch_assoc($sql);
						$decimal = $codigo["comision"] / 100;
						$comision = $decimal * $row["precio"];

						$sql="SELECT idusuario FROM tblusuarios_externos WHERE codigo='{$pedido["codigo"]}'";
						$ra = mysqli_query($nConexion,$sqlPub);

						while($rax=mysqli_fetch_assoc($ra)):
							$sql="insert into tblti_codigos_ventas (idusuario, idproducto, producto, referencia, precio, porcentaje, comision) values ('{$rax["idusuario"]}', '{$row["idproducto"]}', '{$row["item"]}', '{$row["referencia"]}', '{$row["precio"]}', '{$codigo["comision"]}', '$comision')";
							mysqli_query($nConexion,$sql);
						endwhile;
					}
*/
        
		    $row["precio"] = $row["precio"]*$row["unidades"];
          if($_SESSION["pais"] == "CO"){
            $precio = number_format( ($row["precio"]), 0, ',', '.' );
          }else{
            $precio = number_format( ($row["precioEN"]), 2, '.', '' );
          }
				?>
        
				<tr>
					<td style="width:90px;"><?php echo $row["unidades"] ?></td>
					<td style="width:100px;">
            <?php 
              if($_SESSION["pais"] == "CO"){
                echo $row["referencia"];
              }else{
                echo $row["referenciaEN"];
              }              
            ?>
          </td>
					<td style="width:200px;" >
            <?php 
              // Mensaje dia sin Iva al lado del nombre del producto 
              $m="";
              if(DIASINIVA AND $row["diasiniva"]) {
                $m = "(Día Sin IVA)";
              }
              if($_SESSION["pais"] == "CO"){
                echo "{$row["item"]} {$m}";
              }else{
                echo "{$row["itemEN"]}";
              }
            ?>
          </td>
					<td style="width:100px;text-align: right">
            <?php 
              if(DIASINIVA AND $row["diasiniva"]) {
                $p = $row["precio"];
              }else{
                $p = $row["precio"]/$divisor;
              }
              $total += $p;
              echo number_format(round($p), 0, ',', '.' );                 
            ?>
          </td>
					<td style="width:100px;text-align: right">
            <?php
              if(DIASINIVA AND $row["diasiniva"]) {
                $i = 0;
                $porcentaje = '(0%)';
              }else{
                $i = $row["precio"] - round($row["precio"]/$divisor);
                $porcentaje = "({$row["iva"]}%)";
              }
              $totaliva += $i;
              echo number_format($i, 0, ',', '.' ).' '.$porcentaje; 
            ?>
          </td>
					<td style="width:100px;text-align: right"><?php echo number_format($row["precio"], 0, ',', '.' ); ?></td>
				</tr>
			<?php } ?>
				<?php if ($pedido["regalo"]==1){ ?>
				<tr>
					<td>1</td>
					<td></td>
					<td><?php echo ("Envoltura y personalización de regalo");?></td>
					<td><?php echo verContenidoEFP("factura-costo-regalo");?></td>
					<td><?php echo verContenidoEFP("factura-costo-regalo");?></td>
          <td></td>
				</tr>
				<?php } ?>
        
        <tr>
          <td colspan=5></td>
          <td style="text-align:right;">
            <b><?php echo number_format( round($total+$totaliva), 0, '', '.' ) ?></b>
          </td>
        </tr>
        
			</tbody>
		</table>

    <br><br>
    
    <table class="productos" style="border:1px solid black;width:100%;" cellspacing="0" cellpadding="6">
      <tr>
        <th colspan=3 style="text-align:center; width:100%">OBSERVACIONES Y TOTALES</th>
      </tr>
      <tr>
        <td style="text-align:left; width:50%; padding:10px;">
        <br>
        Observaciones:<br>
        <?php
          switch ($pedido["observaciones"]){
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
                $mensaje = "El pedido incluye el costo del envío por Coordinadora";
              }else{
                $envio = false;
                $mensaje = "El pedido no incluye el envío, deberá pagarlo contra-entrega";
              }
              break;
          }        
          echo $mensaje."<br><br>";    
        ?>
        <br>        
        CONSULTE EL ESTADO DE SU ENVÍO:<br>
        - http://www.coordinadora.com
        </td>
        <td style="text-align:left; width:25%; border-right:0px; padding:10px;">
          <br>
          SubTotal:<br><br>
          <?php if(!empty($pedido["descuento"])){ echo "Descuento:<br><br>"; } ?>
          IVA:<br><br>
          <?if($envio) {?>
            Envío:<br><br>
          <?}?>
          Total:<br>
          <br>
        </td>
        <td style="text-align:right; width:25%;border-left:0px; padding:10px;">
          <br>
          <?php echo number_format( round($total), 0, '', '.' );?><br><br>
          <?php if(!empty($pedido["descuento"])){ echo "-".number_format( round($valorDescuento), 0, '', '.' )."<br><br>"; } ?>
          <?php echo number_format( round($totaliva), 0, '', '.' ) ?><br><br>
          <?php if($envio) { echo number_format( round($flete), 0, '', '.' ) . "<br><br>" ;} ?>
          <?php 
            if(!$envio){$flete=0;}
            echo number_format( round($pedido["precio_total"]+$flete), 0, '', '.' ) 
          ?><br>
          <br>
          
        </td>
      </tr>
    </table>

    Referencia de pago (WOMPI): <?=$referenciaPayU?>
    
    <br><br><br><br>

<!--    
		<table class="productos" cellspacing="" width="100%" cellpadding="6">
			<tbody>
        <tr>
          <td style="width:510px;"></td>
          <td style="width:100px; text-align:right">Subtotal (COP)</td>
          <td style="width:100px; text-align:right"><?php echo number_format( ($sinIva), 0, ',', '.' );?></td>
        </tr>
        <tr>
          <td style="width:510px;"></td>
          <td style="width:100px; text-align:right">IVA (19%)</td>
          <td style="width:100px; text-align:right"><?php echo number_format( ($iva), 0, ',', '.' );?></td>
        </tr>
        <tr>
          <td style="width:510px;"></td>
          <td style="width:100px; text-align:right">Total (COP)</td>
          <td style="width:100px; text-align:right"><?php echo number_format( $pedido["precio_total"], 0, ',', '.' );?></td>
        </tr>
			</tbody>
		</table>
    
    <br><br>

    
    <?php if( $_SESSION["pais"] == "CO" && $impuesto ){ ?>
      <table class="productos" cellspacing="" width="100%" cellpadding="6">
        <thead>
          <tr>
            <th style="width:180px;text-align:center"><?php echo mb_strtoupper(("Mercancía gravada"))?></th>
            <th style="width:180px;text-align:center"><?php echo mb_strtoupper(("Valor (COP)"))?></th>
            <th style="width:180px;text-align:center"><?php echo mb_strtoupper(("IVA (19%)"))?></th>
            <th style="width:180px;text-align:center"><?php echo mb_strtoupper(("Total IVA incluído (COP)"))?></th>
          </tr>
        </thead>
        
        <tbody>
          <tr>        
            <td><?php echo ("Parte gravable para IVA")?></td>
            <td style="text-align: right">COP <?php echo number_format( round($sinIva), 0, '', '.' );?></td>
            <td style="text-align: right">COP <?php echo number_format( round($iva), 0, '', '.' ) ?></td>
            <td style="text-align: right">COP <?php echo number_format( round($pedido["precio_total"]), 0, '', '.' ) ?></td>
          </tr>
        </tbody>
      </table>
    <?php }?>
    
    <br><br><br><br>
-->    

    <div style="width:720px; border:1px solid black; padding:10px">
      <?php echo verContenidoEFP("factura-info");?>
    </div>
    <br>
    
    <div style="width:720px; border:1px solid black; padding:10px">
      <b>Políticas de cambio:</b><br>
      -Para realizar tu cambio es indispensable presentar tu factura de compra, certificado de regalo o proporcionar número de cédula del comprador.<br>
      -El plazo máximo para realizar cambio es de 5 días calendario contados a partir de la expedición de la factura.<br>
      -El producto no debe ser usado, modificado o alterado de su estado original.<br>
      -Los equipos en promoción, así como los accesorios y consumibles no tienen cambio.<br>
      -No se hace devolución de dinero.<br><br>
      <b>Políticas de garantía:</b><br>
      -Para hacer efectiva la garantía es indispensable presentar tu factura de compra, certificado de regalo o proporcionar número de cédula del comprador.<br>
      -El término de la garantía de los equipos adquiridos es 6 meses o 1 año (Dependiendo la marca, será especificado en la factura) contados a partir de la expedición de la factura. Los accesorios y consumibles no tienen garantía.<br>
      -Para atender tu reclamo por garantía deberás traer el equipo en buen estado y limpia.<br>
      -El producto no debe estar modificado o alterado de su condición original.<br>
    </div>
	</div>
</page>
<?php
  
  $factura = ob_get_clean();

	$html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(10, 10, 10, 10));// left, top, right, bottom
	$html2pdf->setDefaultFont('Arial');
	$html2pdf->writeHTML($factura);

	$nombre = "Factura-".VerSitioConfig("factura_prefijo")."$nFactura.pdf";
	$html2pdf->Output('my_doc.pdf', 'D');

trigger_error("PDF: ".$nombre);

	$sql="UPDATE tblti_facturas SET factura = '$nombre' WHERE id = $id";
	$r = mysqli_query($nConexion,$sql);

	$result = mysqli_query($nConexion,"select * from tblti_config");
	$mensajes = mysqli_fetch_assoc($result);

	$correos = explode(',', $mensajes['correosCompra']);

	$mail = new PHPMailer(true);
	$mail->CharSet   = "UTF-8";
	$mail->From      = VerSitioConfig('correo');
	$mail->FromName  = VerSitioConfig('correo_nombre');
  
	$mail->AddAddress($pedido["correo_electronico"]);
  $mail->AddAddress("comunicaciones@agrotecnico.com.co");
  $mail->AddAddress("Administracion@agrotecnico.com.co");
  $mail->addBcc("atobon@fenixpuntonet.com");
  $mail->addBcc("edgarfranco01@gmail.com");  
  
  if($_SESSION["pais"] == "CO"){
    if($adjuntar_CO) {
      $mail->AddAttachment(__DIR__."/../fotos/tienda/facturas/$nombre");
    }
    $mail->Subject   = $mensajes["asuntoCompra"];
    $mail->Body      = $mensajes["mensajeCompra"];
  }else{
    if($adjuntar_US) {
      $mail->AddAttachment(__DIR__."/../fotos/tienda/facturas/$nombre");
    }
    $mail->AddAttachment(__DIR__."/../fotos/tienda/facturas/$nombre");
    $mail->Subject   = $mensajes["asuntoCompraEN"];
    $mail->Body      = $mensajes["mensajeCompraEN"];    
  }
  
	$mail->IsHTML(true);

//var_dump($mail);

  if($enviar_correo==true){    
    if($mail->Send()){
      trigger_error("CORREO1: TRUE");
    }
  }
  
	ob_start(); ?>
	<strong><?php echo ("Cliente")?></strong><br>
	Nombre: <?php echo $pedido["nombre"]." ".$pedido["apellido"] ?><br>
  Identificación:<?php echo $pedido["identificacion"] ?><br>
	Dirección: <?php echo $pedido["direccion"] ?><br>
	Ciudad: <?php echo $pedido["ciudad"] ?><br>
  Correo: <?php echo $pedido["correo_electronico"] ?><br>
	Teléfono: <?php echo $pedido["telefono"] ?><br><br>
  
  <strong><?php echo (("Referencia"))?></strong><br>
    <?php echo str_pad($pedido["carro"], 5, "0", STR_PAD_LEFT) ?><br>
	<strong><?php echo (("Factura"))?></strong><br>
    <?php echo $nFactura ?><br>
  
	<strong><?php echo ("Productos")?></strong><br>
	<table cellspacing="0" width="100%" border="1" cellpadding="2">
    <thead>
      <tr>
        <td><strong><?php echo mb_strtoupper(("Cantidad"))?></strong></td>
        <td><strong><?php echo mb_strtoupper(("Referencia"))?></strong></td>
        <td><strong><?php echo mb_strtoupper(("Descripcion"))?></strong></td>
				<td><strong><?php echo mb_strtoupper((""));?></strong></td>
				<td><strong><?php echo mb_strtoupper((""));?></strong></td>
        <td><strong><?php echo mb_strtoupper(("Valor Unidad"))?></strong></td>
        <td><strong><?php echo mb_strtoupper(("IVA"))?></strong></td>
        <td><strong><?php echo mb_strtoupper(("Valor Total"))?></strong></td>        
      </tr>
    </thead>
  
    <tbody>
      <?php 
        $query = "SELECT  a.observaciones, a.detalle, a.item, b.referencia, 
                          a.talla,a.unidades,a.precio,a.color,
                          b.diasiniva
                    FROM  tblti_carro_detalle a 
                    JOIN  tblti_productos b 
                      ON  (a.idproducto=b.idproducto) 
                   WHERE  a.carro = {$pedido["carro"]}
                     AND  a.stihl = 0";

        $result = mysqli_query($nConexion,$query);

        while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?php echo $row["unidades"] ?></td>
            <td>
              <?php 
                if($_SESSION["pais"] == "CO"){
                  echo $row["referencia"];
                }else{
                  echo $row["referenciaEN"];
                }              
              ?>              
            </td>
            <td style="width: 40%;">
              <?php 
                $m="";
                if(DIASINIVA AND $row["diasiniva"]) {
                  $m = "(Día Sin IVA)";
                }
                if($_SESSION["pais"] == "CO"){
                  echo "{$row["item"]} {$m}";
                }else{
                  echo "{$row["itemEN"]}";
                }
              ?>
            </td>
            <td><?php echo $row["color"] ?></td> 
            <td><?php echo $row["talla"] ?></td> 
            <td style="text-align: right">
              <?php 
                if(DIASINIVA AND $row["diasiniva"]) {
                  $p = $row["precio"];
                }else{
                  $p = $row["precio"]/$divisor;
                }
                echo number_format(round($p), 0, ',', '.' );                 
              ?>
            </td>
            <td style="text-align: right">
              <?php 
                if(DIASINIVA AND $row["diasiniva"]) {
                  $i = 0;
                  $porcentaje = '0%';
                }else{
                  $i = $row["precio"] - round($row["precio"]/$divisor);
                  $porcentaje = "({$row["iva"]}%)";
                }
                echo number_format($i, 0, ',', '.' ).' '.$porcentaje; 
              ?>
            </td>
            <td style="text-align: right">
              <?= number_format($row["precio"], 0, ',', '.' )?>
            </td>
          </tr>
        <?php } ?>
        
        <?php if ($pedido["regalo"]==1){ ?>
          <tr>
            <td>1</td>
            <td></td>
            <td style="width: 40%;"><?php echo ("Envoltura y personalización de regalo");?></td>
            <td style="text-align: right"><?php echo verContenidoEFP("factura-costo-regalo");?></td>
            <td style="text-align: right"><?php echo verContenidoEFP("factura-costo-regalo");?></td>            
          </tr>
      <?php } ?>

    </tbody>
	</table>

  <?php if( $_SESSION["pais"] == "CO" && $impuesto ){ ?>
    <table cellspacing="0" width="100%" border="1" cellpadding="2">
      <thead>
        <tr>
          <td><strong>MERCANCÍA GRAVADA</strong></td>
          <td><strong>VALOR</strong></td>
          <td><strong>TASA IVA 19%</strong></td>
          <td><strong>Total IVA incluído</strong></td>
        </tr>
      </thead>
      
      <tbody>
        <tr>
          <td>Parte gravable para IVA</td>
          <td style="text-align: right">COP <?php echo number_format( round($total), 0, '', '.' );?></td>
          <td style="text-align: right">COP <?php echo number_format( round($totaliva), 0, '', '.' ) ?></td>
          <td style="text-align: right">COP <?php echo number_format( round($pedido["precio_total"]), 0, '', '.' ) ?></td>
        </tr>
      </tbody>
    </table>
    <? 
      if($envio) {
        echo "Costo del envío: COP " . number_format( $flete, 0, '', '.' ) ."<br>";
      } 
    ?>
    Referencia de pago (WOMPI): <?=$referenciaPayU?><br>
    <?=$mensaje?>
    
  <?php } ?>

<?php 
    $mensaje = ob_get_clean();

    if($_GET["test"] == 1) {
      echo $mensaje;
      die();
    }
    $mail2 = new PHPMailer(true);

/*
    foreach($correos as $value) {
      $mail2->AddAddress($value);
    }    
*/
    $mail2->AddAddress("comunicaciones@agrotecnico.com.co");
    $mail2->AddAddress("Administracion@agrotecnico.com.co");

    $mail2->addBcc("atobon@fenixpuntonet.com");
    $mail2->addBcc("cmanager@fenixpuntonet.com");
    $mail2->addBcc("edgarfranco01@gmail.com");

    $mail2->CharSet = "UTF-8";
    $mail2->From      = $mail->From;
    $mail2->FromName  = $mail->FromName;    
    $mail2->Subject   = $mail->Subject;
    $mail2->Body      = $mensaje;
    $mail2->IsHTML(true);
  
//var_dump($mail2);

    if($enviar_correo==true){
      if($mail2->Send()){
        trigger_error("CORREO2: TRUE");
      }
    }  
    
  } /* endif (Aprobada)*/
?>