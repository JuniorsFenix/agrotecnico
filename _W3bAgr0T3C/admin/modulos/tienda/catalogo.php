<?php
include("../../herramientas/seguridad/seguridad.php");
include_once("../../funciones_generales.php");
include_once("../../herramientas/html2pdf/html2pdf.class.php");

$nConexion = Conectar();

$imagenes=array();
$ras = mysqli_query($nConexion,"select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
while( $imagen = mysqli_fetch_assoc($ras) ){
	$imagenes[ $imagen["idproducto"] ] = $imagen;
}

ob_start(); ?>
<style type="text/css">
	.page{
		padding: 0px;
		background: url("catalogo/fondo-productos.png") top left no-repeat;
		background-size: 100% 100%;
		position: relative;
		display: block;
		box-sizing: border-box;
		margin: auto;
		color: #000;
	}
	table, thead, tbody {
		border-collapse: collapse;
		width: 100%;
		table-layout: fixed;
	}
	th, td{
		border: none;
		padding: 3px;
		/*white-space: nowrap;
		word-wrap: break-word;*/
  	vertical-align: top;
	}
	.titulo{
		color: #6CB71A;
		font-size: 18.3pt;
		font-weight: bold;
		margin-bottom: 10px;
	}
	.tituloProducto{
		color: #6CB71A;
		font-size: 13pt;
		font-weight: bold;
    height: 40px;
	}
	.tituloGeneral{
		color: #6CB71A;
		font-size: 13pt;
		font-weight: bold;
	}
	.header{
		color: #FFF;
		font-weight: bold;
		font-size: 21pt;
		margin-bottom: 40px;
	}
	.imagen{
		height: 165px;
		max-width: 100%;
	}
	.especificaciones div{
		padding: 1px 5px;
	}
</style>
<page class="page" backimg="catalogo/fondo-portada.jpg" style="font-size: 11pt">
	<page_footer>
		<table cellspacing="0" style="width:100%" class="noborder">
				<tr>
					<td>
						<div style="text-align: right; padding-right: 200px;">
							<a style="color: #FFF; font-size: 18pt;" href="http://www.agrotecnico.com.co/" target="_blank">www.agrotecnico.com.co</a>
						</div>
					</td>
				</tr>
		</table>
  </page_footer>
	<table cellspacing="0">
		<tbody>
			<tr>
				<td style="width: 50%; text-align: center; font-size: 17pt; color: #FFF; padding-top: 111px;">
					<img src="catalogo/agrotecnico.png" style="width: 575px;"/><br>
					Tecnología innovadora para el agro, <br>
					la industria y el hogar.
				</td>
				<td style="width: 50%">
				</td>
			</tr>
		</tbody>
	</table>
</page>
<?php
	$nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
	$catSQL = "SELECT * FROM tblti_categorias WHERE idcategoria!=0 AND idcategoria_superior=0 AND (idcategoria IN (SELECT idcategoria FROM tblti_productos) OR idcategoria IN (SELECT c.idcategoria_superior FROM tblti_categorias c INNER JOIN tblti_productos p ON c.idcategoria=p.idcategoria)) ORDER BY orden";
    if(!empty($_POST["categorias"])){
        $categorias = array_map('intval', $_POST["categorias"]);
        $categorias = implode("','",$categorias);
	    $catSQL = "SELECT * FROM tblti_categorias WHERE idcategoria IN ('".$categorias."') ORDER BY orden";
    }
	$cat = mysqli_query($nConexion, $catSQL);
	while($rax=mysqli_fetch_assoc($cat)):
	    $prodSQL = "SELECT * FROM tblti_productos WHERE idcategoria={$rax["idcategoria"]} AND activo=1 ORDER BY orden";
	    if(!empty($_POST["marcas"])){
            $marcas = array_map('intval', $_POST["marcas"]);
            $marcas = implode("','",$marcas);
	        $prodSQL = "SELECT * FROM tblti_productos WHERE idcategoria={$rax["idcategoria"]} AND idmarca IN ('".$marcas."') AND activo=1 ORDER BY orden";
        }
		$result= mysqli_query($nConexion, $prodSQL);
		$num_rows = mysqli_num_rows($result);
		$columns = 3;
		$i = 0;
		$count = 0;
		$newPage = "</tr></tbody></table></page><page class='page' footer='page' backimg='catalogo/fondo-productos.png' style='font-size: 11pt'><table cellspacing='0' style='width: 100%;'><tbody><tr><td colspan='3'><div class='header'>{$rax["nombre"]}</div></td></tr>";
		if($num_rows > 0) { ?>
		<page class="page" footer="page" backimg="catalogo/fondo-productos.png" style="font-size: 11pt">
        	<page_footer>
        		<table cellspacing="0" style="width:100%" class="noborder">
    				<tr>
    					<td>
    						<div style="text-align: left">
    							<a style="color: #FFF" href="http://www.agrotecnico.com.co/" target="_blank">www.agrotecnico.com.co</a>
    						</div>
    					</td>
    				</tr>
        		</table>
            </page_footer>
			<table cellspacing="0" style="width: 100%;">
				<tbody>
				<tr>
					<td colspan='3'>
						<div class='header'><?php echo $rax["nombre"] ?></div>
					</td>
				</tr>
				<?php
					while($row=mysqli_fetch_assoc($result)):
						$espec = mysqli_query($nConexion,"SELECT * FROM tblti_espec WHERE idproducto={$row["idproducto"]} LIMIT 14");
						$num_espec = mysqli_num_rows($espec);
						$i++;
						$count++;
						if ($i % $columns == 1) { echo '<tr>'; } ?>
						<td style="width: 33.3%; padding: 0 19px;">
							<div class="tituloProducto"><?php echo $row["nombre"] ?></div>
							<div class="referencia">Ref: <?php echo $row["referencia"] ?></div>
							<div style="text-align: center;">
							<?php if(empty($imagenes[$row["idproducto"]]["imagen"])){
								echo "<img class='imagen' src='../../../fotos/Image/contenidos/default.jpg' />";
							} else {
								$size = getimagesize("../../../fotos/tienda/productos/m_{$imagenes[$row["idproducto"]]["imagen"]}");
								$ratio = $size[0]/$size[1];
								
								$width = 165*$ratio;
								$height = 165;
		
								if($width > 296) { $width = 296; }
								echo "<img class='imagen' src='../../../fotos/tienda/productos/m_{$imagenes[$row["idproducto"]]["imagen"]}' alt='{$row["nombre"]}' width='$width' height='$height' />";
							} ?>
							</div>
							<div class="tituloGeneral">DESCRIPCIÓN:</div>
							<div><?php echo $row["metaDescripcion"] ?></div>
							<?php if($num_espec > 0) { ?>
							<div class="tituloGeneral">ESPECIFICACIONES:</div>
							<table class="especificaciones" style="width: 100%;">
							<?php
							$bgcolor="#DFDFDF";
							while($campos = mysqli_fetch_object($espec)):?>
								<tr><td style="width: 100%; background: <?php echo $bgcolor;?>"><?php echo "$campos->nombre: $campos->descripcion" ?></td></tr>
							<?php
								if ($bgcolor=="#DFDFDF") $bgcolor="#C5C5C5";
								elseif ($bgcolor=="#C5C5C5") $bgcolor="#DFDFDF";
							endwhile;?>
							</table>
							<?php } ?>
						</td>
						<?php if ($i % $columns == 0) {
							if ($num_rows == $count) { echo "</tr>"; $i = 0; } else { echo $newPage; $i = 0; }
							};
					endwhile; 
					$spacercells = $columns - ($i % $columns);
					if ($spacercells < $columns) {
							for ($j=1; $j<=$spacercells; $j++) {
									echo "<td style='width: 33.3%; padding: 0 19px;'></td>";
							}
							echo "</tr>";
					} ?>
				</tbody>
			</table>
		</page>
		<?php } 
		$sql= mysqli_query($nConexion,"SELECT * FROM tblti_categorias WHERE idcategoria_superior={$rax["idcategoria"]} AND idcategoria IN (SELECT idcategoria FROM tblti_productos)");
		while($sub=mysqli_fetch_assoc($sql)){
	    $prodSQL = "SELECT * FROM tblti_productos WHERE idcategoria={$sub["idcategoria"]} AND activo=1 ORDER BY orden";
	    if(!empty($_POST["marcas"])){
            $marcas = array_map('intval', $_POST["marcas"]);
            $marcas = implode("','",$marcas);
	        $prodSQL = "SELECT * FROM tblti_productos WHERE idcategoria={$sub["idcategoria"]} AND idmarca IN ('".$marcas."') AND activo=1 ORDER BY orden";
        }
		$result= mysqli_query($nConexion, $prodSQL);
		$num_rows = mysqli_num_rows($result);
		$count = 0;
		$i = 0;
		$newPage = "</tr></tbody></table></page><page class='page' footer='page' backimg='catalogo/fondo-productos.png' style='font-size: 11pt'><div class='header'>{$rax["nombre"]}</div><table cellspacing='0' style='width: 100%;'><thead><tr><th colspan='3'><div class='titulo'>{$sub["nombre"]}</div></th></tr></thead><tbody>";
		if($num_rows > 0) { ?>
		<page class="page" footer="page" backimg="catalogo/fondo-productos.png" style="font-size: 11pt">
        	<page_footer>
        		<table cellspacing="0" style="width:100%" class="noborder">
    				<tr>
    					<td>
    						<div style="text-align: left">
    							<a style="color: #FFF" href="http://www.agrotecnico.com.co/" target="_blank">www.agrotecnico.com.co</a>
    						</div>
    					</td>
    				</tr>
        		</table>
            </page_footer>
			<div class='header'><?php echo $rax["nombre"] ?></div>
			<table cellspacing="0" style="width: 100%;">
				<thead>
					<tr>
						<th colspan="3"><div class="titulo"><?php echo $sub["nombre"] ?></div></th>
					</tr>
				</thead>
				<tbody>
				<?php
					while($row=mysqli_fetch_assoc($result)):
						$espec = mysqli_query($nConexion,"SELECT * FROM tblti_espec WHERE idproducto={$row["idproducto"]} LIMIT 14");
						$num_espec = mysqli_num_rows($espec);
						$i++;
						$count++;
						if ($i % $columns == 1) { echo '<tr>'; } ?>
						<td style="width: 33.3%; padding: 0 19px;">
							<div class="tituloProducto"><?php echo $row["nombre"] ?></div>
							<div class="referencia">Ref: <?php echo $row["referencia"] ?></div>
							<div style="text-align: center;">
							<?php if(empty($imagenes[$row["idproducto"]]["imagen"])){
								echo "<img class='imagen' src='../../../fotos/Image/contenidos/default.jpg' />";
							} else {
								$size = getimagesize("../../../fotos/tienda/productos/m_{$imagenes[$row["idproducto"]]["imagen"]}");
								$ratio = $size[0]/$size[1];
								
								$width = 165*$ratio;
								$height = 165;
		
								if($width > 296) { $width = 296; }
								echo "<img class='imagen' src='../../../fotos/tienda/productos/m_{$imagenes[$row["idproducto"]]["imagen"]}' alt='{$row["nombre"]}' width='$width' height='$height' />";
							} ?>
							</div>
							<div class="tituloGeneral">DESCRIPCIÓN:</div>
							<div><?php echo $row["metaDescripcion"] ?></div>
							<?php if($num_espec > 0) { ?>
							<div class="tituloGeneral">ESPECIFICACIONES:</div>
							<table class="especificaciones" style="width: 100%;">
							<?php
							$bgcolor="#DFDFDF";
							while($campos = mysqli_fetch_object($espec)):?>
								<tr><td style="width: 100%; background: <?php echo $bgcolor;?>"><?php echo "$campos->nombre: $campos->descripcion" ?></td></tr>
							<?php
								if ($bgcolor=="#DFDFDF") $bgcolor="#C5C5C5";
								elseif ($bgcolor=="#C5C5C5") $bgcolor="#DFDFDF";
							endwhile;?>
							</table>
							<?php } ?>
						</td>
						<?php if ($i % $columns == 0) {
							if ($num_rows == $count) { echo "</tr>"; $i = 0; } else { echo $newPage; $i = 0; }
							};
					endwhile; 
					$spacercells = $columns - ($i % $columns);
					if ($spacercells < $columns) {
							for ($j=1; $j<=$spacercells; $j++) {
									echo "<td style='width: 33.3%; padding: 0 19px;'></td>";
							}
							echo "</tr>";
					} ?>
				</tbody>
			</table>
		</page>
	<?php } }
endwhile; ?>
<?php 
	$catalogo = ob_get_clean();
	
    try
    {			
    	$html2pdf = new HTML2PDF('L', 'Letter', 'es', true, 'UTF-8', array(7, 6, 7, 4));
    	$html2pdf->setDefaultFont('helvetica');
    	$html2pdf->writeHTML($catalogo);
    	if(!empty($_POST["categorias"]) || !empty($_POST["marcas"])){
        	$html2pdf->Output("catalogo.pdf", 'D');
    	} else {
        	$html2pdf->Output(__DIR__."/../../../fotos/Image/archivos/catalogo.pdf", 'F');
        	header("Location: /fotos/Image/archivos/catalogo.pdf");
    	}
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	exit;
?>