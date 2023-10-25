<?php
  include("diasiniva.php");

  $_POST["accesorios_423"][0] = "439";

  /*
  $_POST["accesorios_426"][0] = "435";
  $_POST["accesorios_426"][1] = "436";
  $_POST["accesorios_426"][2] = "437";
  
  $_POST["accesorios_34"][0] = "438";
  $_POST["accesorios_34"][1] = "439";
  $_POST["accesorios_34"][2] = "440";

  $_POST["accesorios_406"][0] = "471";
  $_POST["accesorios_406"][1] = "472";
  $_POST["accesorios_406"][2] = "473";

  $_POST["observaciones"] = "Ldcdscdsc  c jvj jhj jj h  n jj hj hj hjhjhj jhjh jhjhjhj hjhjh hu gyu yuf uftftfytfytfytf yfytfytfytf tyf.";
*/

  setlocale(LC_ALL, 'es_CO.UTF-8');
  date_default_timezone_set ("America/Bogota");

  if(!session_id()) session_start();

  /* Forzar pais y lenguaje */
  $_SESSION["pais"] = "CO";
  $_SESSION["lenguaje"] = "es";

  //var_dump($_SESSION);
  //var_dump($_POST);

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../admin/herramientas/phpmailer/src/Exception.php';
	require '../admin/herramientas/phpmailer/src/PHPMailer.php';
  include("../admin/herramientas/html2pdf/html2pdf.class.php");
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


  if(isset($_POST["cotizacion"])){
//  break;

  	$result = mysqli_query($nConexion,"select * from tblti_config");
    $mensajes = mysqli_fetch_assoc($result);

    $nombre = "Cotizacion-".VerSitioConfig("factura_prefijo").$_POST["cotizacion"].".pdf";
    $correos = explode(',', $mensajes['correosCompra']);

    $mail = new PHPMailer(true);
    $mail->CharSet   = "UTF-8";
    $mail->From      = VerSitioConfig('correo');
    $mail->FromName  = VerSitioConfig('correo_nombre');
    
    $mail->AddAddress($pedido["correo_electronico"]);  
    //$mail->addBcc("comunicaciones@agrotecnico.com.co");
    //$mail->addBcc("Administracion@agrotecnico.com.co");
    $mail->addBcc("edgarfranco01@gmail.com");  
    $mail->addBcc("atobon@fenixpuntonet.com");  
    
    $mail->AddAttachment(__DIR__."/../fotos/tienda/cotizaciones/$nombre");

    $body = '<table align="center" border="0" cellpadding="1" cellspacing="1" style="width:500px">
              <tbody>
                <tr>
                  <td style="text-align:center;">
                    <img alt="Agrotecnico" src="https://agrotecnico.com.co/fotos/Image/mail-logo.png" width="200px" />
                  </td>
                </tr>
                <tr>
                  <td style="text-align:center">Has cotizado en Agrotécnico j.o.</td>
                </tr>
              </tbody>
            </table>
            ';
    
    $mail->Subject   = "Has cotizado en Agrotécnico j.o.";
    $mail->Body      = $body;
    
    $mail->IsHTML(true);

    if($mail->Send()){
      $sql="UPDATE tblti_carro SET estado = 'COTIZADO' WHERE carro = '{$pedido["carro"]}'";	
      $r = mysqli_query($nConexion,$sql);	
      $sql="DELETE FROM tblti_baskets WHERE basketSession = '{$sessionID}'";	
      $r = mysqli_query($nConexion,$sql);	

      trigger_error("CORREO1: TRUE");
    }else{
      trigger_error("ERROR CORREO1: FALSE");
    }

    header("Location: /productos",TRUE,301);
    
  }


  $divisa = "COP";
  $lang = "es";
  $monto = $pedido["precio_total"];

  $imagenes=array();
  $ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
  while( $imagen = mysqli_fetch_assoc($ras) ){
    $imagenes[ $imagen["idproducto"] ] = $imagen;
  }
  
  $query = "SELECT  * 
              FROM  tblti_carro_detalle A
        INNER JOIN  tblti_productos B
                ON  A.idproducto = B.idproducto
             WHERE  A.carro = {$pedido["carro"]} 
          ORDER BY  A.detalle DESC";
                
  $asociados  = mysqli_query($nConexion,$query);	
  $asociados2 = mysqli_query($nConexion,$query);
  $asociados3 = mysqli_query($nConexion,$query);

  $fleteTotal = 0;
  $envio = false;

  $titulo = VerSitioConfig('titulo');
  $descripcion_payu = "Cotización de producto en $titulo";
  
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));

  $hora = date("h:m A");
  $fecha = date("d/m/Y");
  $fechaven = date("d/m/Y", strtotime("+8 day"));


  $nConexion = conectar();
  $sql="INSERT into tblti_cotizaciones (carro) VALUES ({$pedido["carro"]})";

	$r = mysqli_query($nConexion,$sql);

  //$id = mysqli_insert_id($nConexion);*/
  $query = "SELECT MAX(id) AS id FROM tblti_cotizaciones";
  $result = mysqli_query($nConexion,$query);
  if ($row = mysqli_fetch_row($result)) {
    $id = trim($row[0]);
  }
    
	$nFactura = str_pad($id, 6, "0", STR_PAD_LEFT);

	$sql="INSERT into tblti_cotizaciones (id, carro, factura) VALUES ({$id}, {$pedido["carro"]}, {$nFactura})";
	$r = mysqli_query($nConexion,$sql);


	ob_start();  

?>


<style>
  table { 
    border-spacing: 0px;
    border-collapse: collapse;
  }
  th, td {
    padding: 2px 5px;
    vertical-align:top;
  }
  th {
    text-align:center;
  }
  #productos td{
    vertical-align:middle;
    overflow-wrap: break-word;
  }
  .derecha {
    text-align:right;
  }
  .centro {
    text-align:center;
  }
  .izquierda {
    text-align:left;
  }

  #accesorios{
    border-spacing:60px 0 ;
    border-collapse:separate;
  }
  .accesorios{
    width:30%; 
    height:25mm;
    text-align:center;
    
    border-style: groove;
    border-image: linear-gradient(to right, #AAC148, #509F4E);
    border-image-slice: 1;
    border-image-width: 10px;
    padding: 10px;
    
    border-color: #509F4E;
    border-radius: 15px;
    border-style: solid;
    border-width: 10px;
    border-image-slice: 1;
  }
  .accesorios-h {
    width:30%; 
    height:25mm;
  }
  .accesorios img{
    object-fit: cover;
    height: 20mm;
    display: block;
    margin: auto;
    /*padding: 15mm;*/    
  }
  .accesorios h3{
    font-size:14px;
    font-weight:bold;
    margin:0;
    background-color:white;
    background-image: linear-gradient(to right, #AAC148, #509F4E);
    width: fit-content;
    margin: auto;
    padding: 3px;
    border-radius: 5px;
    color: black;
  }
  .accesorios h4{
    font-size:20px;
    margin:0;
  }
  .titulo {
    color:#7db04b; 
    font-size:24px; 
    font-weight:bold;    
  }
  .boton{
    background-image: linear-gradient(to right, #AAC148, #509F4E);
    color: white;
    border-radius: 5px;
    padding: 10px 20px;
    cursor:pointer;
  }
  .imgCarro{
    height:190px;
  }
</style>


<page backcolor="" backimg="../fotos/Image/cotizador/plantilla.jpg" backimgx="center" backimgy="bottom" backimgw="100%" backtop="0" footer="date;time;page" style="font-size: 12pt; font-family:Arial;">
  <page_header>    
    <h3 style="margin-top:-48mm;"><?=$nFactura?></h3>
    <h2 style="margin-top:25mm; text-align:right;"><?= $nFactura;?></h2>
  </page_header>

  <table style="margin-top:5mm; width:100%;">
    <tr>
      <td style="width:50%;" ><b>CLIENTE:</b> <?= $pedido["nombre"]." ".$pedido["apellido"];?></td>
      <td><b>ASESOR:</b>  <?= $_SESSION["usuario"]["nombre"];?></td>
    </tr>
    <tr>
      <td><b>NIT:</b>  <?= $pedido["identificacion"];?></td>
      <td><b>HORA:</b> <?= $hora;?></td>
    </tr>
    <tr>
      <td><b>TELÉFONO:</b>         <?= $pedido["telefono"];?></td>
      <td><b>FECHA DOCUMENTO:</b>  <?= $fecha;?></td>
    </tr>
    <tr>
      <td style="width:50%;"><b>DIRECCIÓN:</b>          <?= $pedido["direccion"]." - ".$pedido["ciudad"];?></td>
      <td><b>FORMA DE PAGO:</b>  <?= $d["metodoPago"];?></td>
    </tr>
    <tr>
      <td><b>CORREO:</b>         <?= $pedido["correo_electronico"];?></td>
      <td style="width:50%;"></td>
    </tr>
  </table>

  <h1 style="text-align:center;margin-top:10mm">Respetado cliente:</h1>
  <p>
    Agradecemos su confianza hacia nosotros para presentarle una propuesta a su solicitud. Agrotecnico j.o., es reconocida en la prestación de servicio técnico, variedad de maquinaria para el agro, industria y hogar; cuenta con personal especializado en las sedes Bulerías, San Juan, Rionegro y San Pedro, ofreciéndole a nuestros clientes cumplimiento, precios justos, respaldo de repuestos, garantía de servicio, asesoría en prevención y postventa.
  </p>

  <table style="margin-top:0mm; width:100%;" cellpadding="5" cellspacing="5">
    <thead>
      <tr>
        <th>Item</th>
        <th>Cant</th>
        <th>Descripción</th>
        <th>Valor IVA</th>
        <th>Dcto %</th>
        <th>IVA</th>
        <th>Sin IVA/Dcto </th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php while($rax=mysqli_fetch_assoc($asociados)) { 
        $item++;
        if($item % 2 == 0){
          $color="lightgray";
        }else{
          $color="white";
        }

        $precio = $rax["precioant"];
        $precio_sin_iva = round($precio /1.19 , 0);
        $iva = round(($precio - $precio_sin_iva) * $rax["unidades"] , 0 );
        $descuento = round($precio_sin_iva * $rax["descuento"]/100 , 0) * $rax["unidades"];
        $precio_sin_iva_con_descuento = $precio_sin_iva - round($precio_sin_iva * $rax["descuento"]/100 , 0 ) * $rax["unidades"];
        $iva_des = round($precio_sin_iva_con_descuento * 19/100) * $rax["unidades"];
        $subtotal_sin_iva = $precio_sin_iva_con_descuento * $rax["unidades"];
        $subtotal = round($precio_sin_iva_con_descuento * 1.19 , 0) * $rax["unidades"];

        $tot_iva += $iva_des;
        $tot_descuento += $descuento;
        $tot_subtotal_sin_iva += $subtotal_sin_iva;
        $tot_total += $subtotal;

        $productos.= "<tr style='background-color:{$color};'>";
        $productos.= "  <td class='centro'>{$item}</td>";
        $productos.= "  <td class='centro'>{$rax["unidades"]}</td>";
        $productos.= "  <td style='width:220px'>{$rax["nombre"]}</td>";
        $productos.= "  <td class='derecha'>" .number_format($precio,0,',','.'). "</td>";
        $productos.= "  <td class='derecha'>{$rax["descuento"]}</td>";
        $productos.= "  <td class='derecha'>19%</td>";
        $productos.= "  <td class='derecha'>" .number_format($precio_sin_iva_con_descuento,0,',','.'). "</td>";
        $productos.= "  <td class='derecha'>" .number_format($subtotal,0,',','.'). "</td>";
        $productos.= "</tr>";
      }?>
      <?=$productos?>

      <tr>
        <td style="height: 1mm; vertical-align: bottom;"></td>
      </tr>
      <tr style='background-color:lightgray;'>
        <td colspan=3>Subtotal: </td>
        <td colspan=5 class="derecha"><?=number_format($tot_subtotal_sin_iva + $tot_descuento,0,',','.')?></td>
      </tr>
      <tr style='background-color:lightgray;'>
        <td colspan=3>Descuentos: </td>
        <td colspan=5 class="derecha"><?=number_format($tot_descuento,0,',','.')?></td>
      </tr>
      <tr style='background-color:lightgray;'>
        <td colspan=3>Base Impuesto: </td>
        <td colspan=5 class="derecha"><?=number_format($tot_subtotal_sin_iva,0,',','.')?></td>
      </tr>
      <tr style='background-color:lightgray;'>
        <td colspan=3>IVA: </td>
        <td colspan=5 class="derecha"><?=number_format($tot_iva,0,',','.')?></td>
      </tr>
      <tr>
        <td colspan=6 class="derecha titulo" >TOTAL:</td>
        <td colspan=2 class="derecha titulo" ><?=number_format($tot_total,0,',','.')?></td>
      </tr>
    </tbody>
  </table>

<div>
  <table id="productos" style="margin-top:30mm; width:100%;" cellpadding="5" cellspacing="5">
    <?php while($rax=mysqli_fetch_assoc($asociados2)) { 
      $nConexion = Conectar();
      $sql = "SELECT * FROM tblti_espec WHERE idproducto={$rax["idproducto"]} order by nombre asc" ;
      $espec = mysqli_query($nConexion,$sql);

      $a_usoscat = explode("," , $rax["usoscat"]);
      sort($a_usoscat);
      $usoscat = implode($a_usoscat);
      $i_usoscat = "../fotos/Image/cotizador/".$usoscat.".jpg";

      $id_accesorios = "accesorios_".$rax["idproducto"];
    ?>
      <tr>
        <td style="width:33%;">
          <h2><?=$rax["nombre"]?></h2>
          <?=$rxProducto["referencia"];?><br>
            <?php while($campos = mysqli_fetch_object($espec)):?>
              <?php echo "<strong>$campos->nombre: </strong> $campos->descripcion " ?><br>
            <?php endwhile;?>
        </td>
        <td style="text-align:center;width:66%;">
          <img class="imgCarro" style="" src="../fotos/tienda/productos/m_<?=$imagenes[$rax["idproducto"]]['imagen']?>" alt="<?=$rax["idproducto"]?>" >
        </td>
      </tr>

      <tr>
        <td colspan=2 style="text-align: center;">
          <img src="<?=$i_usoscat?>" style="width:65%;">
        </td>
      </tr> 

<? if(count($_POST[$id_accesorios])>0) {?>  
      <tr>
        <td colspan=2>
          <table id="accesorios" style="margin-top:0mm;width:100%;" cellpadding="0" cellspacing="20">
            <tr>
              <td colspan=3 class="titulo" style="text-align:center;">
                ACCESORIOS RECOMENDADOS (NO INCLUIDOS)
              </td>
            </tr>
            <tr>
              <?php
                $i=0;
                foreach($_POST[$id_accesorios] as $accesorio){
                  $i++;
                  $sql = "SELECT * FROM tblti_productos where idproducto='{$accesorio}' ";
                  $result = mysqli_query($nConexion,$sql);
                  $html = "";
                  while($accesorios=mysqli_fetch_assoc($result)) {
                    $precio_acc = number_format($accesorios['precio'],0,',','.');
                    $html .= "<td class='accesorios'>
                                  <img src='../fotos/tienda/productos/p_{$imagenes[$accesorios["idproducto"]]['imagen']}' >
                                  <h3>{$accesorios['nombre']}</h3>
                                  <h4>$ {$precio_acc}</h4>
                              </td>" ;
                  }
                  echo $html;
                  if($i==3){break;};
                }

                $cuenta = count($_POST[$id_accesorios]);
                if($cuenta>3){$cuenta=3;}
                $vacios = 3 - $cuenta;
                for($i=1 ; $i<=$vacios ; $i++) {
                  echo "<td class='accesorios-h'></td>" ;
                }
              ?>
            </tr>
          </table>
        </td>
      </tr>
<? } ?>

    <? } ?>
  </table>
</div>

<div style="margin:0;">
  <table id="condiciones" style="width:100%;" cellpadding="5" cellspacing="5">
    <tr>
      <td colspan=2><h1 class="titulo" >CONDICIONES COMERCIALES:</h1></td>
    </tr>
    <tr>
      <td style="width:50%;"><b>Garantía:</b></td>
      <td style="text-align:right;"><?=$_POST["garantia"]?></td>
    </tr>
    <tr>
      <td><b>Flete:</b></td>
      <td style="text-align:right;"><?=$_POST["flete"]?></td>
    </tr>
    <tr>
      <td><b>Descuento:</b></td>
      <td style="text-align:right;"><?=$_POST["descuentoTXT"]?></td>
    </tr>
    <tr>
      <td><b>Validez de la oferta:</b></td>
      <td style="text-align:right;"><?=$_POST["validez"]?></td>
    </tr>
    <tr>
      <td><b>Tiempo de entrega:</b></td>
      <td style="text-align:right;"><?=$_POST["entrega"]?></td>
    </tr>
    <tr>
      <td colspan=2 ><p>Favor consignar en Bancolombia cuenta de ahorros Nº 12476065907 Agrotécnico j.o. o Banco Agrario cuenta corriente 313850001063 a nombre de Agrotécnico j.o. S.A.S.</p></td>
    </tr>
    <tr>
      <td style="border-right: 4px solid lightgray;"><a href="https://www.agrotecnico.com.co/blog"><img src="../fotos/Image/cotizador/blog.jpg"></a></td>
      <td><a href="https://www.youtube.com/channel/UCndVz9KDKqK2d73yFSrtezw"><img src="../fotos/Image/cotizador/youtube.jpg"></a></td>
    </tr>
  </table>
</div>

<div style="margin:0">
  <p class="titulo">OBSERVACIONES:</p>
  <div style="width:99%; height:30mm; background-color:lightgray;padding:10px;border-radius: 15px;">
    <?=$_POST["extra"]?>
  </div>
</div>

  <page_footer>
  </page_footer>

</page>

<? $factura = ob_get_clean(); ?>

<div style="width:70%;margin:auto;border:1px solid gray;padding:10mm;box-shadow: 5px 5px 15px grey;">
  <h1>COTIZACIÓN N° <?=$nFactura?></h1><br><br>";
  <?=$factura?>  
</div>

<form method="post" id="cotizar" action="" style="text-align:center;margin:40px;">
  <input type="hidden" value="<?=$nFactura;?>" name="cotizacion" />
  <input type="submit" class="boton" id="cmdEnviar" value="Enviar" />
  <input type="button" class="boton" id="cmdPrevio" value="Vista Previa" onclick="vistaPrevia('<?=$nFactura;?>')"/>
</form>


<?php
	$html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(10, 62, 10, 30));// left, top, right, bottom
	$html2pdf->setDefaultFont('Arial');
	$html2pdf->writeHTML($factura);

	$nombre = "Cotizacion-".VerSitioConfig("factura_prefijo")."$nFactura.pdf";

  //$nombre = "Cotizacion-TEST.pdf";
	$html2pdf->Output(__DIR__."/../fotos/tienda/cotizaciones/$nombre", 'F');

  trigger_error("PDF: ".$nombre);


	$sql="UPDATE tblti_cotizaciones SET factura = '$nombre' WHERE id = $id";
	$r = mysqli_query($nConexion,$sql);
?>

<script>
  function vistaPrevia(nFactura){
    console.log(nFactura)
    window.open("../fotos/tienda/cotizaciones/Cotizacion-AT" + nFactura + ".pdf");
  }
</script>