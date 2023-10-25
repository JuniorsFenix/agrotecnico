<?php

  // https://tirssa.fenixpuntonet.info/php/mis-comprasV2.php?ciudad=1


	include("../include/funciones_public.php");
	ValCiudad();
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	include("../admin/vargenerales.php");
	require_once("inc/functions.php");
	require_once ("../admin/herramientas/seguridad/validate.php");
	require_once("funciones.php");	

  $sesion = session_id();
  if(!$sesion) session_start();
	if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true) {
		header("Location: /");
		exit;
	}
	
	$IdCiudad=varValidator::validateReqInt("get","ciudad",true);
	if(is_null($IdCiudad)){
		echo "Valor de entrada invalido para la variable ciudad";
		exit;
	}

  	$nConexion   = Conectar();
  
  $imagenes=array();
  $ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0 ");
  while( $imagen = mysqli_fetch_assoc($ras) ){
    $imagenes[ $imagen["idproducto"] ] = $imagen;
  }
	$mensaje="";

	if (isset ($_POST["carro"]) && !empty($_POST["carro"])){
		require_once ("../admin/herramientas/phpmailer/class.phpmailer.php");
		
			$sql="SELECT c.*, cd.item, cd.precio, cd.talla, cd.color FROM tblti_carro c LEFT JOIN tblti_carro_detalle cd ON c.carro=cd.carro WHERE cd.detalle={$_POST["detalle"]} AND cd.carro={$_POST["carro"]}";
      
			$ra = mysqli_query($nConexion,$sql);
			$producto = mysqli_fetch_assoc($ra);
		$precio = "$". number_format( round($producto["precio"]), 0, '', '.' );
		
			$mail = new PHPMailer();
			$mail->CharSet = "UTF-8";
			$mail->From      = "info@banglio.com";
			$mail->FromName  = "Banglio";
			$mail->AddAddress($_SESSION['usuario']['correo_electronico']);
			$mail->Subject   = "Proceso de devolución - Banglio";
			$mail->Body      = "Ha iniciado un proceso de devolución de producto en Banglio. Pronto nos comunicarémos con usted.";
			$mail->IsHTML(true);
			$mail->Send();
		
			$mail2 = new PHPMailer();
			$mail2->CharSet = "UTF-8";
			$mail2->From      = "info@banglio.com";
			$mail2->FromName  = "Banglio";
			$mail2->AddAddress("info@banglio.com");
			$mail2->Subject   = "Proceso de devolución - Banglio";
			$mail2->Body      = "Se ha iniciado un proceso de devolución en Banglio:<br><br>
			<p><strong>Pedido #:</strong> {$producto["carro"]}</p>
			<p><strong>Fecha de pedido #:</strong> {$producto["fecha"]}</p>
			<p><strong>Producto:</strong> {$producto["item"]}</p>
			<p><strong>Talla #:</strong> {$producto["talla"]}</p>
			<p><strong>Color #:</strong> {$producto["color"]}</p>
			<p><strong>Precio #:</strong> $precio</p>";
			$mail2->IsHTML(true);
			$mail2->Send();
		
		$sql="UPDATE tblti_carro_detalle SET estado='En proceso de devolución', razon='{$_POST["razon"]}', fecha=NOW() WHERE detalle={$_POST["detalle"]} AND carro={$_POST["carro"]}";
		mysqli_query($nConexion,$sql);
		$mensaje="<p>Ha iniciado el proceso de devolución para este producto. Pronto nos comunicarémos con usted</p>";
	}
  
  $usuario = $_SESSION['usuario']['idusuario'];
  //$usuario = 17; //Test

  $sql="SELECT  c.carro as Pedido,
                f.factura as Cotización,
                c.fecha as Fecha, 
                CONCAT(c.nombre,' ',c.apellido) as Cliente,
                c.telefono as Teléfono,
                c.direccion as Dirección, 
                c.ciudad as Ciudad,                 
                c.precio_total as Precio,
                count(cd.unidades) as Cantidad,
                c.extra as Observaciones
          FROM  tblti_carro c 
     LEFT JOIN  tblti_carro_detalle cd 
            ON  c.carro=cd.carro
     LEFT JOIN  tblti_cotizaciones f 
            ON  c.carro=f.carro             
         WHERE  c.idusuario = {$usuario}
           AND  (c.estado ='COTIZADO' OR c.estado ='ENVIADA')
      GROUP BY  c.carro  
      ORDER BY `Pedido`  DESC";

  $nConexion   = Conectar();

  $result = mysqli_query($nConexion,$sql);
  $campos = ["Cotización", "Fecha", "Cliente", "Teléfono", "Dirección", "Ciudad", "Precio", "Cantidad", "Observaciones"];  
  $count = count($campos);

	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));


	if (isset ($_GET["id"]) && !empty($_GET["id"])){
    $nConexion   = Conectar();

    $sql = "DELETE FROM tblti_baskets WHERE basketSession = '$sesion' ";
    mysqli_query($nConexion,$sql);

    $sql="SELECT  c.carro as Pedido,
                  c.fecha as Fecha, 
                  CONCAT(c.nombre,' ',c.apellido) as Cliente,
                  c.direccion as Direccion, 
                  c.ciudad as Ciudad,                 
                  cd.precio as Precio, 
                  p.idproducto, 
                  p.nombre as Producto, 
                  p.url,
                  count(p.idproducto) as Cantidad
            FROM  tblti_carro c 
       LEFT JOIN  tblti_carro_detalle cd 
              ON  c.carro=cd.carro 
       LEFT JOIN  tblti_productos p 
              ON  cd.idproducto=p.idproducto 
       LEFT JOIN  tblti_facturas f 
              ON  c.carro=f.carro 
           WHERE  c.carro = '{$_GET["id"]}'
             AND  c.estado !='CARRO'
        GROUP BY  c.carro, idproducto ";  

    $sql="SELECT * 
            FROM tblti_carro_detalle A
      INNER JOIN tblti_productos B 
              ON A.idproducto = B.idproducto
           WHERE A.carro = '{$_GET["id"]}' ";

    $result = mysqli_query($nConexion,$sql);

    while( ($cotizacion = mysqli_fetch_assoc($result)) ) {
      switch ($_SESSION["cotizacion"]) {
        case "Bodega":
          $productPrice = $cotizacion["precio2"];
          break;
        case "Mayorista":
          $productPrice = $cotizacion["precio3"];
          break;
        case "Distribuidor":
          $productPrice = $cotizacion["precio"];
          break;
      }
      
      $sql = "INSERT INTO tblti_baskets 
                   VALUES ('', '{$sesion}', '{$cotizacion["idproducto"]}', '', '', '{$productPrice}' ) ";
      mysqli_query($nConexion,$sql);
    }
    
		header("Location: /carrito");
		exit;    
  }
  
?>

<!DOCTYPE html>
<html lang="es"> 
<head>
	<meta charset="utf-8">
    <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle()?>" />
    <title>Mis cotizaciones - <?php echo $sitioCfg["titulo"]; ?></title>
    <meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
    <meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
	<?php echo $RegContenido->contenido; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script type="text/javascript" src="<?php echo $home; ?>/php/inc/js/custom.js"></script>

	<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo $home; ?>/css/data.tables.css" rel="stylesheet" type="text/css">
    
</head>
<body>
	<!--- Sección de menú --->
	<?php require_once("header.php");?>
	<!--- Sección de menú ---> 
	<div class="principal" id="mis-compras">
		<div id="cabezote">
		<?php echo cabezoteJqueryIn(4,"carousel"); ?>
		</div>		
    <?=$session?>
		<div class="contenidoGeneral cuenta" style="min-height: 800px">
			<div class="container">
				<div class="row">
				<div class="col-sm-3">
					<nav>
					<h2>Configuración</h2>
						<ul>
							<li><a href="/mi-cuenta/datos-personales">Datos personales</a></li>
							<li><a href="/mi-cuenta/cambiar-clave">Cambio de clave</a></li>
							<li><a href="/mi-cuenta">Recientes</a></li>
							<!--<li><a href="/mi-cuenta/datos-facturacion">Datos de facturación</a></li>-->
							<!--<li><a href="/mi-cuenta/direcciones">Direcciones</a></li>-->
              <?php if($_SESSION["usuario"]["perfil"] == 1) {
                echo "<li><a href='$home/cotizaciones'>Cotizaciones</a></li>";
              } ?>
							<li><a class="activo" href="/mi-cuenta/mis-compras">Mis cotizaciones</a></li>
						</ul>
					</nav>
				</div>
        
        
				<div class="col-sm-12">
					<h3>Mis cotizaciones</h3>
          
            <table id="listado" >
              <thead>
                <tr>
                  <?
                    foreach ($campos as $clave => $valor) {
                      echo "<th>{$valor}</th>";
                    }
                  ?>
                </tr>
              </thead>
              <tbody>
                <?php
                  while( ($row = mysqli_fetch_assoc($result)) ) {?>
                  <tr>
                    <?php foreach ($row as $campo => $valor) {

                      switch ($campo){
                        case "Pedido":
                          //echo "<td style='text-align:right;'><a target='_blank' href='../php/mis-compras.php?ciudad=1&id=$valor'>Modificar</a></td>";  
                          break;
                        case "Precio":
                          echo "<td style='text-align:right;'>".number_format( $valor, 0, '', '.' )."</td>";  
                          break;
                        case "Cantidad":
                          echo "<td style='text-align:right;'>$valor</td>";  
                          break;
                        case "Cotización":   
                          $factura = str_replace("Cotizacion-","",$valor);
                          echo "<td style='text-align:right;'><a target='_blank' href='/fotos/tienda/cotizaciones/{$valor}'>$factura</a></td>";  
                          break;                          
                        default:
                          echo "<td>$valor</td>";  
                      }                     
                    } ?>            
                  </tr>
                <? } ?>
              </tbody>
            </table>

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

        "order": [[ 1, 'desc' ]],
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
      
      // Setup - add a text input to each footer cell
      $('#listado thead tr').clone(true).appendTo( '#listado thead' );
      $('#listado thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" style="font-style:italic; width: 100%;background-color:#f6f6f6" placeholder="Buscar '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {            
          if ( table.column(i).search() !== this.value ) {
            table
              .column(i)
              .search( this.value )
              .draw();
          }
        } );
      } );
   
      
    });
    
  </script>
  
</body>
</html>