<?php
    if(!session_id()) session_start();
	include("../include/funciones_public.php");
	ValCiudad();
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	include("../admin/vargenerales.php");
	require_once ("../admin/herramientas/seguridad/validate.php");
	
	$IdCiudad=varValidator::validateReqInt("get","ciudad",true);
	if(is_null($IdCiudad)){
		echo "Valor de entrada invalido para la variable ciudad";
		exit;
	}
	
	
	$generales = datosGenerales();
    $nConexion = Conectar();
	
function imagenAleatoria($idcategoria){
    $nConexion = Conectar();

    $sql="select imagen from tblimagenes where idcategoria = {$idcategoria} order by rand() limit 1";
    $rsImagen = mysqli_query($nConexion,$sql);

    if( mysqli_num_rows($rsImagen)==0){
        return "";
    }
    
    $rx = mysqli_fetch_assoc($rsImagen);
    return $rx["imagen"];
}


function imageThumbSize($width,$height,$newwidth,$newheight) {
    $factorh = ( $newheight * 100 ) / $height;
    $factorw = ( $newwidth * 100 ) / $width;

    //escalado automatico

    if ( ($newwidth == 0 && $newheight > 0) ||  ($factorw > $factorh && $factorh > 0) ){
      $newwidth = ($width * $factorh ) / 100;
    }
    else if ( ($newheight == 0 && $newwidth > 0)  ||  ($factorh > $factorw && $factorw > 0) ){
      $newheight = ($height * $factorw ) / 100;
    }

    return array($newwidth,$newheight);
}

function imageAttrs($imgPath,$maxWith,$maxHeight){
    $size = getimagesize($imgPath);        
    $newSize = imageThumbSize($size[0], $size[1], $maxWith, $maxHeight);

    return " width=\"{$newSize[0]}\" height=\"{$newSize[1]}\" ";
}


	
    if( !isset($_GET["categoria"]) ){
        /*$sql="SELECT *,
        (select imagen from tblimagenes where idcategoria = tblcategoriasimagenes.idcategoria
        order by rand() limit 1) as imagen_galeria
        FROM tblcategoriasimagenes ORDER BY idcategoria";
        $rsCategorias = mysqli_query($nConexion,$sql);*/

        
	$sql = "SELECT * from tblcategoriasimagenes WHERE 1=1 and idcategoria in (select distinct idcategoria from tblimagenes) order by idcategoria desc";
	$ca = new DbQuery($nConexion);
	$ca->prepare($sql);	
        //echo "XXXX ".$ca->preparedQuery();
		
	
	$pag = isset($_GET["pag"]) ? $_GET["pag"]:1;
	$page = $ca->execPage(array("pager"=>true,"page"=>$pag,"count"=>9,"pagerVars"=>""));
    	
    }
    else {
	
		$cCategoria = $_GET["categoria"];
		
		$rxCategoria = galeriaCategoriaAssoc($cCategoria);
		
		
		$sql="select * from tblimagenes where idcategoria = $cCategoria AND idciudad = $IdCiudad";
		$rsImagenes = mysqli_query($nConexion,$sql);
		//$rsImagenes =  mysqli_fetch_assoc($ra);
		
		/*$page=new sistema_paginacion('tblimagenes');
		$page->set_condicion("WHERE idcategoria = '$cCategoria' AND (idciudad = $IdCiudad)");
		$page->ordenar_por('idimagen desc');
		$page->set_limite_pagina(8);
		$rsImagenes = $page->obtener_consulta();
		$page->set_tabla_transparente();
		$page->set_color_texto("black");
		$page->set_color_enlaces("black","#FF9900");*/
		
    }
  
	$RegContenido = mysqli_fetch_object(VerContenido( "metaTags" ));

?>

<!DOCTYPE html>
<html lang="es"> 
<head>
	<meta charset="utf-8">
    <title>Galería de fotos - <?php echo $sitioCfg["titulo"]; ?></title>
    <meta name="description" content="<?php echo $sitioCfg["descripcion"]; ?>">
    <meta name="keywords" content="<?php echo $sitioCfg["palabras_clave"]; ?>">
	<?php echo $RegContenido->contenido; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    
    <!--- <link href="https://fonts.googleapis.com/css?family=Rock+Salt" rel="stylesheet"> --->
    <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:300,400&subset=latin-ext" rel="stylesheet">
    <link href="<?php echo $home; ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo $home; ?>/css/galeria.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $home; ?>/css/paginador.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $home; ?>/js/modernizr.custom.37797.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $home; ?>/php/js/jquery.galleriffic.js"></script>
    <script type="text/javascript" src="<?php echo $home; ?>/php/js/jquery.opacityrollover.js"></script>
    <!-- We only want the thunbnails to display when javascript is disabled -->
    <script type="text/javascript">
        document.write('<style>.noscript { display: none; }</style>');
    </script>

</head>

<body>  
<!--- Sección de menú --->
<?php require_once("header.php");?>
<!--- Sección de menú --->   

<!--- Sección de banner --->
   <?php echo cabezoteJqueryIn(5,"carousel"); ?>
<!--- Sección de banner --->
    
<!--- Sección de Noticias/tendencias ---> 
<section class="contenidoInterno">
    <div class="container">
        <h2>
            <!-- Imprimir Contenido=TituloGaleria-->
            <?
            $RegContenido = mysqli_fetch_object(VerContenido( "titulo-galeria" ));
            echo $RegContenido->contenido;
            ?>
            <!-- Fin Imprimir Contenido=TituloGaleria-->
        </h2>
						<?php
						if( isset($page) ):?>
                        <ul id="top-side-Album">
                	<?php
                    if ( $page["error"] == false )
                    {
                    foreach($page["records"] as $rax){
                    ?>
                        <?php $imagen = imagenAleatoria($rax["idcategoria"]);?>

                            <li><span><img src="<?="{$cRutaVerImgGaleria}{$imagen}";?>" width="150" border="0"/>
                            <a id="full-size" href="<?php echo $home; ?>/galeria/categoria<?=$rax["idcategoria"];?>" style="text-decoration:none;color:black;"></a></span><br>
                            <a href="<?php echo $home; ?>/galeria/categoria<?=$rax["idcategoria"];?>"><?=$rax["categoria"];?></a>
                            </li>
                          
						<?
                        }
                        ?>
                        </ul>
                        <?php    
						echo $page["pager"];
                        }
                        else
                        {
                          echo "No se encontraron Categorias.";
                        }
                        ?>
                        <?php else:?>
            				<!-- Start Advanced Gallery Html Containers -->
				<div id="gallery" class="cont">
					<div id="controls" class="controls"></div>
					<div class="slideshow-container">
						<div id="loading" class="loader"></div>
						<div id="slideshow" class="slideshow"></div>
					</div>
					<div id="caption" class="caption-container"></div>
				</div>
				<div id="thumbs" class="navigation">
                    <?=$rxCategoria["categoria"];?><br/>
					<ul class="thumbs noscript">
                        <?php $i=0;while($rax=mysqli_fetch_assoc($rsImagenes)):?>
						<li>
							<a class="thumb" name="leaf" href="<?="{$cRutaVerImgGaleria}{$rax["imagen"]}";?>" title="<?=$rax["descripcion"];?>">
								<img src="<?=$cRutaVerImgGaleria.$rax["imagen"];?>" width="80" border="0"/>
							</a>
							<div class="caption">
								<!--<div class="download">
									<a href="http://farm4.static.flickr.com/3261/2538183196_8baf9a8015_b.jpg">Download Original</a>
								</div>
								<div class="image-title">Title #0</div>-->
								<div class="image-desc"><?=$rax["descripcion"];?></div>
							</div>
						</li>
                        <?php endwhile;?>
					</ul>
					<div style="clear: both;"></div>
				</div>
				<div style="clear: both;"></div>
                    <a class="link" href="<?php echo $home; ?>/galeria" class="deMasInfo2">Regresar</a>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				// We only want these styles applied when javascript is enabled
				jQuery('div.navigation').css({'width' : '300px', 'float' : 'left'});
				jQuery('div.cont').css('display', 'block');

				// Initially set opacity on thumbs and add
				// additional styling for hover effect on thumbs
				var onMouseOutOpacity = 0.3;
				jQuery('#thumbs ul.thumbs li').opacityrollover({
					mouseOutOpacity:   onMouseOutOpacity,
					mouseOverOpacity:  1.0,
					fadeSpeed:         'fast',
					exemptionSelector: '.selected'
				});
				
				// Initialize Advanced Galleriffic Gallery
				var gallery = jQuery('#thumbs').galleriffic({
					delay:                     2500,
					numThumbs:                 15,
					preloadAhead:              10,
					enableTopPager:            true,
					enableBottomPager:         true,
					maxPagesToShow:            7,
					imageContainerSel:         '#slideshow',
					controlsContainerSel:      '#controls',
					captionContainerSel:       '#caption',
					loadingContainerSel:       '#loading',
					renderSSControls:          true,
					renderNavControls:         true,
					playLinkText:              'Reproducir',
					pauseLinkText:             'Pausar',
					prevLinkText:              '&lsaquo; Anterior',
					nextLinkText:              'Siguiente &rsaquo;',
					nextPageLinkText:          'Siguiente &rsaquo;',
					prevPageLinkText:          '&lsaquo; Anterior',
					enableHistory:             false,
					autoStart:                 false,
					syncTransitions:           true,
					defaultTransitionDuration: 900,
					onSlideChange:             function(prevIndex, nextIndex) {
						// 'this' refers to the gallery, which is an extension of $('#thumbs')
						this.find('ul.thumbs').children()
							.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
							.eq(nextIndex).fadeTo('fast', 1.0);
					},
					onPageTransitionOut:       function(callback) {
						this.fadeTo('fast', 0.0, callback);
					},
					onPageTransitionIn:        function() {
						this.fadeTo('fast', 1.0);
					}
				});
			});
		</script>
                <?php endif;?>
    </div>
</section>
<!--- Sección de Noticias/tendencias --->    
<!--- Sección de Creado por --->
<?php require_once("footer.php");?>
<!--- Sección de Creado por --->
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
</body>
</html>

<!-- <div class="contactos" data-bottom-top="opacity:0; left:-150px;" data-top="opacity:1; left:0;"> -->