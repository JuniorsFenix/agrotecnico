<?php
// inventario = 14
// https://agrotecnico.com.co/php/productosver.php?ciudad=1&url=fumigadora-aliada-royal-condor-&test=true

// inventario = 6
// https://agrotecnico.com.co/php/productosver.php?ciudad=1&url=fumigadora-sr-430&test=true

// inventario = 5 (peso=0)
// https://agrotecnico.com.co/php/productosver.php?ciudad=1&url=motosierra-stihl-ms-170&test=true


// https://agrotecnico.com.co/php/carroCoor.php


if (!session_id()) session_start();

include("diasiniva.php");

include("../include/funciones_public.php");
require_once("inc/functions.php");
$sitioCfg = sitioAssoc();
$home = $sitioCfg["url"];
include("../admin/vargenerales.php");

$generales = datosGenerales();
$nConexion = Conectar();

$url = $_GET["categoria"];
$rxProducto = tiendaProductoAssoc($url);
if ($rxProducto == 0) {
  echo "<script language=\"javascript\">location.href='/productos'</script>";
}
$rxCategoria = tiendaCategoriaAssocId($rxProducto["idcategoria"]);

$imagenes = array();
$ras = mysqli_query($nConexion, "select * from tblti_imagenes where idimagen<>0 order by idimagen desc");
while ($imagen = mysqli_fetch_assoc($ras)) {
  $imagenes[$imagen["idproducto"]] = $imagen;
}

$fotos    = mysqli_query($nConexion, "SELECT * FROM tblti_imagenes WHERE idproducto={$rxProducto["idproducto"]}");
$num_rows = mysqli_num_rows($fotos);

$fotos2    = mysqli_query($nConexion, "SELECT * FROM tblti_imagenes WHERE idproducto={$rxProducto["idproducto"]}");
$fotoUsos = mysqli_fetch_assoc($fotos2);

$sql = "select * from tblti_marcas where idmarca = {$rxProducto["idmarca"]}";
$ra = mysqli_query($nConexion, $sql);
$marca = mysqli_fetch_assoc($ra);

$tecnologias = mysqli_query($nConexion, "SELECT t.* FROM tblti_tecnologias_asociadas ta, tblti_tecnologias t WHERE ta.idproducto = {$rxProducto["idproducto"]} AND t.id = ta.idproductoa");

$color = explode(",", $rxProducto["color"]);
$where = "1=0";
foreach ($color as $idcolor) {
  $where .= " OR id=$idcolor";
}
$colores = mysqli_query($nConexion, "SELECT * FROM tblti_colores WHERE $where");

$material = explode(",", $rxProducto["material"]);
$where = "1=0";
foreach ($material as $idmaterial) {
  $where .= " OR id=$idmaterial";
}
$materiales = mysqli_query($nConexion, "SELECT * FROM tblti_deportes WHERE $where");


$agro_categoria = explode(",", $rxProducto["usoscat"]);


$espec = mysqli_query($nConexion, "SELECT * FROM tblti_espec WHERE idproducto={$rxProducto["idproducto"]} order by id");
$espec2 = mysqli_query($nConexion, "SELECT * FROM tblti_espec WHERE idproducto={$rxProducto["idproducto"]} order by id");

$sql = "SELECT ROUND(AVG(rating),1) as averageRating FROM tblti_rating WHERE idproducto={$rxProducto["idproducto"]}";
$ra = mysqli_query($nConexion, $sql);
$fetchAverage = mysqli_fetch_assoc($ra);
$averageRating = $fetchAverage['averageRating'];
if ($averageRating <= 0) {
  $averageRating = 0;
}

if (!empty($rxProducto["titulo"])) {
  $titulo = $rxProducto["titulo"];
} else {
  $titulo = $sitioCfg["titulo"];
}

if (!empty($rxProducto["metaDescripcion"])) {
  $descripcion = $rxProducto["metaDescripcion"];
} else {
  $descripcion = $generales['descripcion_productos'];
}

$RegContenido = mysqli_fetch_object(VerContenido("metaTags"));

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="google-site-verification" content="<?php CargarMetaVerificacionGoogle() ?>" />
  <title><?php echo $titulo; ?></title>
  <meta name="description" content="<?php echo $descripcion; ?>">
  <meta name="keywords" content="<?php echo $palabras; ?>">
  <?php echo $RegContenido->contenido; ?>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <link href="<?php echo $home; ?>/css/<?php echo $sitioCfg["estilo"]; ?>" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link href='<?php echo $home; ?>/php/bar-rating/themes/fontawesome-stars-o.css' rel='stylesheet' type='text/css'>
  <link href="<?php echo $home; ?>/php/lightbox/css/lightbox.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $home; ?>/php/slick/slick.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $home; ?>/php/slick/slick-theme.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(function() {
      $("#colores li").tooltip();
    });
  </script>
  <script src="<?php echo $home; ?>/php/bar-rating/jquery.barrating.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

  <script type="text/javascript" src="<?php echo $home; ?>/php/inc/js/custom.js"></script>

  <script type="text/javascript">
    $(function() {
      $("#cantidad").change(function() {
        var id = $(this).val();
        var dataString = 'id=' + id;

        $(".cesta a").removeClass();
        $(".cesta a").addClass(id);

      });
    });
  </script>

  <script type="text/javascript">
    /* Abrir ventana modal */
    function abrirModal(ver) {
      element = document.getElementById("modal");
      if (ver == 1) {
        element.style.display = "flex"
      } else {
        element.style.display = "none"
      }
    }
  </script>
  <style>
    .modal-descripcion {
      max-height: 0px;
      position: relative;
      overflow: hidden;
      transition: max-height 0.3s ease-in-out;
    }

    .ampliar {
      color: #FFF;
      padding: 5px 8px;
      overflow: hidden;
      margin-top: 11px;
      border-radius: 2rem;
      background: linear-gradient(to right, #AAC148, #509F4E);
      display: inline-block;
    }

    .modal-descripcion.abierto {
      max-height: 2000px;
    }
  </style>

  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', '<?php echo $sitioCfg["analytics"]; ?>');
  </script>
  <!-- End Google Tag Manager -->
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $sitioCfg["analytics"]; ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <div class="modal" id="modal" onclick="abrirModal(0)">
    <div class="modal-div">
      <?php $RegContenido = mysqli_fetch_object(VerContenido("como-comprar"));
      echo $RegContenido->contenido;
      ?>
    </div>
  </div>

  <!--- Sección de menú --->
  <?php require_once("header.php"); ?>
  <!--- Sección de menú --->
  <div class="principal">
    <div id="skrollr-body">

      <!--- Sección de Noticias/tendencias --->
      <section class="contenidoInterno">
        <div class="background">
          <div class="container-producto">
            <div class="row pb-5 pt-2">
              <!-- imagen producto -->
              <div class="col-md-4 productimgcontainer">
                <div class="agro-categorys--container">
                  <div class="agro-category--container <?php echo (in_array(1,$agro_categoria))?'agro-category-active':''  ?> ">
                    <?php if(in_array("1", $agro_categoria)){ ?>
                      <img src="<?php echo $home ?>/fotos/image/hogar-category-active.png" alt="">
                    <?php }else{?>
                      <img src="<?php echo $home ?>/fotos/image/hogar-category.png" alt="">
                    <?php } ?>
                  </div>
                  <span>Hogar</span>
                  <div class="agro-category--container" <?php echo (in_array(3,$agro_categoria))?'agro-category-active':''  ?>>
                  <?php if(in_array("3", $agro_categoria)){ ?>
                    <img src="<?php echo $home ?>/fotos/image/forestal-category-active.png" alt="">
                    <?php }else{?>
                      <img src="<?php echo $home ?>/fotos/image/forestal-category.png" alt="">
                    <?php } ?>
                  </div>
                  <span>Forestal</span>
                  <div class="agro-category--container <?php echo (in_array(4,$agro_categoria))?'agro-category-active':''  ?>">
                  <?php if(in_array("4", $agro_categoria)){ ?>
                    <img src="<?php echo $home ?>/fotos/image/agricola-category-active.png" alt="">
                    <?php }else{?>
                      <img src="<?php echo $home ?>/fotos/image/agricola-category.png" alt="">
                    <?php } ?>
                  </div>
                  <span>Agrícola</span>
                  <div class="agro-category--container <?php echo (in_array(2,$agro_categoria))?'agro-category-active':''  ?>">
                  <?php if(in_array("2", $agro_categoria)){ ?>
                    <img src="<?php echo $home ?>/fotos/image/profesional-category-active.png" alt="">
                    <?php }else{?>
                      <img src="<?php echo $home ?>/fotos/image/profesional-category.png" alt="">
                    <?php } ?>
                  </div>
                  <span>Profesional</span>
                </div>
                <div class="sliderProductos" id="productImageWrapID_<?= $rxProducto["idproducto"]; ?>">
                  <?php while ($Registro = mysqli_fetch_object($fotos)) : ?>
                    <div>
                      <a id="<?php echo $Registro->imagen; ?>" class="nozoom" href="<?php echo $cRutaVerImagenTienda . $Registro->imagen; ?>" data-lightbox="productos">
                        <img src="<?php echo $cRutaVerImagenTienda . $Registro->imagen; ?>" alt="<?= $rxProducto["nombre"]; ?>" />
                      </a>
                    </div>
                  <?php endwhile; ?>
                  <?php if ($num_rows > 1) { ?>
                    <div class="slider-nav">
                      <?php mysqli_data_seek($fotos, 0); ?>
                      <?php while ($Registro = mysqli_fetch_object($fotos)) : ?>
                        <div>
                          <img src="<?php echo $cRutaVerImagenTienda . "m_" . $Registro->imagen; ?>" alt="<?php echo $rxProducto["nombre"]; ?>" />
                        </div>
                      <?php endwhile; ?>
                    </div>
                  <?php } ?>
                </div>
                <?php if ($rxProducto["colores_activo"] == 1) { ?>
                  <ul id="colores">
                    <?php
                    if (mysqli_num_rows($colores) > 0) {
                      while ($rax = mysqli_fetch_assoc($colores)) : ?>
                        <li title="<?php echo $rax["nombre"]; ?>">
                          <div class="color" style="background:#<?= $rax["color"]; ?>;"></div>
                        </li>
                    <?php endwhile;
                    } ?>
                  </ul>
                <?php } ?>
              </div>
              <!-- fin imagen producto -->
              <!-- descripcion producto -->
              <div class="col-md-8 descripcion-producto--container">
                <div class="info-producto">
                  <div class="volver-producto--container">
                    <span><img src="<?php echo $home ?>/fotos/image/icono-flecha-izquierda.png" alt=""></span>
                    <a href="javascript:window.history.back();" id="volver-producto">Volver</a>
                  </div>
                  <h2><?php echo $rxProducto["nombre"]; ?></h2>
                  <?php if ($rxProducto["referencia_activo"] == 1) { ?>
                    <p class="ref"> Referencia: <b><?= $rxProducto["referencia"]; ?></b></p>
                  <?php } ?>
                  <div class="description-row">
                    <ul class="especificaciones col-md-5">

                      <?php if ($rxProducto["inventario"] == 0) { ?>
                        <h3 class="clear">Agotado</h3>
                      <?php } else { ?>
                        <h3 class="clear">Stock disponible</h3>
                      <?php } ?>
                      <div class="post-action mb-2" style="color: #243A44;">
                        <!-- Rating -->
                        <select id='rating' data-id-product='<?php echo $rxProducto["idproducto"]; ?>' data-current-rating='<?php echo $averageRating; ?>'>
                          <option value=""></option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                        <!-- Set rating -->
                        <script type='text/javascript'>
                          $(function() {
                            var currentRating = $('#rating').data('current-rating');
                            var idproduct = $('#rating').data('id-product');
                            $('#rating').barrating({
                              theme: 'fontawesome-stars-o',
                              showSelectedRating: false,
                              initialRating: currentRating,
                              onSelect: function(value, text) {
                                $.post(
                                  '/php/calificar.php', {
                                    rating: value,
                                    idproduct: idproduct
                                  },
                                  function() {
                                    window.location.reload(true);
                                  });
                              }
                            });
                          });
                        </script>
                      </div>
                      <?php while ($campos = mysqli_fetch_object($espec)) : ?>
                        <li><?php echo "<strong>$campos->nombre:</strong> $campos->descripcion" ?></li>
                      <?php endwhile; ?>
                    </ul>
                    <div class="descripcion-product col-md-7 pl-2">
                      <b>Descripción</b>
                      <br>
                      <br>
                      <?php echo $rxProducto["descripcion"]; ?>
                    </div>
                  </div>
                </div>
                <!-- <div class="modal-descripcion">
                 
                </div> -->
                <div style="text-align:left; display: flex; align-items: center; ">
                  <div class="product-buttons-container-carrito">
                    <?php if (COTIZAR || ($rxProducto["activo"] == 1 && $rxProducto["inventario"] > 0 && DIASINIVA) || ($rxProducto["activo"] == 1 && $rxProducto["inventario"] > 0 && $rxProducto["idmarca"] != 1)) { ?>
                      <div class="productPriceWrapRight cesta" style="height: 30px;">
                        <span>
                          <input type="number" id="cantidad" name="cantidad" min="1" max="<?= $rxProducto["inventario"] ?>" value="1">
                        </span>
                        <a style="line-height: 1; padding: 5px 28px; color: #243A44; height: 30px;" href="<?php echo $home; ?>/php/inc/functions.php?action=addToBasket&productID=<?= $rxProducto["idproducto"]; ?>" id="featuredProduct_<?= $rxProducto["idproducto"]; ?>" class="1" onClick="return false;">
                          <?php $RegContenido = mysqli_fetch_object(VerContenido("Carrito"));
                          echo $RegContenido->contenido . " Comprar";
                          ?>
                        </a>
                      </div>
                    <?php } elseif (!DIASINIVA) { ?>
                      <div class="productPriceWrapRight cesta" id="botonCotizar">
                        <a href="<?php echo $home; ?>/php/inc/functions.php?action=addToBasket&productID=<?= $rxProducto["idproducto"]; ?>" id="featuredProduct_<?= $rxProducto["idproducto"]; ?>" class="1" onClick="return false;">
                          <?php $RegContenido = mysqli_fetch_object(VerContenido("boton-cotizar"));
                          echo $RegContenido->contenido;
                          ?>
                        </a>
                      </div>
                    <?php } ?>
                    <a class="botonmodal" onclick='abrirModal(1)'>
                      ¿Cómo comprar?
                    </a>
                    <div class="add-wishlist">
                      <a href="#" class="openmodal" data-url="<?php echo $url; ?>">Lista de deseos</a>
                    </div>
                  </div>
                </div>
                <div class="precio">
                  <?php if ($rxProducto["precioa_activo"] == 1) { ?>
                    <span id="antes">Antes
                      COP <?php echo number_format(($rxProducto["precioant"]), 0, ',', '.') ?>
                    </span>
                    <br>
                  <?php }
                  if ($rxProducto["precio_activo"] == 1) { ?>
                    <span>
                      <?php
                      if (DIASINIVA and $rxProducto["diasiniva"]) {
                        $divisor = 1 + ($rxProducto['iva'] / 100);
                        $precio = number_format(($rxProducto["precio"] / $divisor), 0, ',', '.');
                      } else {
                        $precio = number_format(($rxProducto["precio"]), 0, ',', '.');
                      }
                      ?>
                      <h4 class="pt-3" style="font-weight: 800; color:#243A44 ;">COP <?php echo $precio ?></h4>
                    </span>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="usos">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 672.1 175.01">
                <defs>
                  <clipPath id="clip-path">
                    <rect x="168.04" y="113.58" width="167.99" height="20.67" style="fill: none" />
                  </clipPath>
                  <linearGradient id="linear-gradient" x1="0%" y1="0%" x2="100%" y2="0%" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#aac148" />
                    <stop offset="1" stop-color="#2a9a42" />
                  </linearGradient>
                  <clipPath id="clip-path-2">
                    <rect x="336.07" y="113.58" width="167.99" height="20.67" style="fill: none" />
                  </clipPath>
                  <clipPath id="clip-path-3">
                    <path d="M504.11,113.58v20.67H661.77a10.34,10.34,0,0,0,0-20.67Z" style="fill: none" />
                  </clipPath>
                  <linearGradient id="linear-gradient-2" x1="766.74" y1="440.44" x2="767.74" y2="440.44" gradientTransform="matrix(167.99, 0, 0, -167.99, -128300.63, 74114.05)" xlink:href="#linear-gradient" />
                  <clipPath id="clip-path-4">
                    <path d="M582,97.77v15.14c0,.76,0,.67,1,.66s1,.08,1-.66V97.77c0-.37-.45-.67-1-.67s-1,.3-1,.67" style="fill: none" />
                  </clipPath>
                  <linearGradient id="linear-gradient-3" x1="353.41" y1="512.84" x2="354.41" y2="512.84" gradientTransform="matrix(1.98, 0, 0, -1.98, -119.32, 1123.07)" xlink:href="#linear-gradient" />
                  <clipPath id="clip-path-5">
                    <path d="M251,97.77v15.15c0,.76,0,.66,1,.66s1,.07,1-.66V97.77c0-.36-.44-.66-1-.66s-1,.3-1,.66" style="fill: none" />
                  </clipPath>
                  <linearGradient id="linear-gradient-4" x1="353.41" y1="512.84" x2="354.41" y2="512.84" gradientTransform="matrix(1.98, 0, 0, -1.98, -450.27, 1123.08)" xlink:href="#linear-gradient" />
                  <clipPath id="clip-path-6">
                    <path d="M212.47,19.72a1,1,0,0,0,1.58,1.2,47.56,47.56,0,1,1-9.58,28.63,1,1,0,1,0-2,0,49.54,49.54,0,1,0,10-29.83" style="fill: none" />
                  </clipPath>
                  <linearGradient id="linear-gradient-5" x1="763.3" y1="441.04" x2="764.3" y2="441.04" gradientTransform="matrix(99.09, 0, 0, -99.09, -75434.26, 43753.24)" xlink:href="#linear-gradient" />
                  <clipPath id="clip-path-7">
                    <path d="M219.7,19.05a44.51,44.51,0,0,0,57.18,67.58l-.48-.7a43.81,43.81,0,0,1-54.83-4.58,43.64,43.64,0,1,1,68.28-10.09l.75.42a44.51,44.51,0,0,0-70.9-52.63" style="fill: none" />
                  </clipPath>
                  <linearGradient id="linear-gradient-6" x1="762.35" y1="441.21" x2="763.35" y2="441.21" gradientTransform="matrix(89.01, 0, 0, -89.01, -67649.55, 39321.84)" xlink:href="#linear-gradient" />
                  <clipPath id="clip-path-8">
                    <rect x="370.52" width="99.09" height="99.09" style="fill: none" />
                  </clipPath>
                  <clipPath id="clip-path-10">
                    <rect x="375.56" y="5.39" width="89.01" height="88.93" style="fill: none" />
                  </clipPath>
                  <clipPath id="clip-path-11">
                    <path d="M543.43,19.72a1,1,0,0,0,1.58,1.2,47.56,47.56,0,1,1-9.58,28.63,1,1,0,1,0-2,0,49.56,49.56,0,1,0,10-29.83" style="fill: none" />
                  </clipPath>
                  <linearGradient id="linear-gradient-7" x1="763.3" y1="441.04" x2="764.3" y2="441.04" gradientTransform="matrix(99.09, 0, 0, -99.09, -75103.29, 43753.23)" xlink:href="#linear-gradient" />
                  <clipPath id="clip-path-12">
                    <path d="M550.88,19.05a44.51,44.51,0,0,0,57.19,67.58l-.49-.7a43.81,43.81,0,0,1-54.83-4.58A43.64,43.64,0,1,1,621,71.26l.74.42a44.51,44.51,0,0,0-70.9-52.63" style="fill: none" />
                  </clipPath>
                  <linearGradient id="linear-gradient-8" x1="762.35" y1="441.21" x2="763.35" y2="441.21" gradientTransform="matrix(89.01, 0, 0, -89.01, -67318.42, 39321.87)" xlink:href="#linear-gradient" />
                  <clipPath id="clip-path-13">
                    <rect x="394.24" y="25.07" width="50.96" height="50.96" style="fill: none" />
                  </clipPath>
                  <clipPath id="clip-path-14">
                    <rect x="231.31" y="27.25" width="45.06" height="45.06" style="fill: none" />
                  </clipPath>
                  <clipPath id="clip-path-15">
                    <rect x="61.68" y="26" width="49.1" height="49.1" style="fill: none" />
                  </clipPath>
                </defs>
                <g style="isolation: isolate">
                  <g id="Layer_1" data-name="Layer 1">
                    <g>
                      <path d="M10.33,113.58a10.34,10.34,0,0,0,0,20.67H168V113.58Z" style="<?= in_array("1", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                      <g style="clip-path: url(#clip-path)">
                        <rect x="168.04" y="113.58" width="167.99" height="20.67" style="<?= in_array("3", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                      </g>
                      <g style="mix-blend-mode: multiply">
                        <g style="clip-path: url(#clip-path-2)">
                          <rect x="336.07" y="113.58" width="167.99" height="20.67" style="<?= in_array("4", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                        </g>
                      </g>
                      <g style="clip-path: url(#clip-path-3)">
                        <rect x="504.11" y="113.58" width="167.99" height="20.67" style="<?= in_array("2", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                      </g>
                      <path d="M88.57,123.91a2.08,2.08,0,1,1-2.07-2.07,2.08,2.08,0,0,1,2.07,2.07" style="fill: #fff" />
                      <path d="M254.11,123.91a2.08,2.08,0,1,1-2.08-2.07,2.08,2.08,0,0,1,2.08,2.07" style="fill: #fff" />
                      <path d="M422.15,123.91a2.08,2.08,0,1,1-2.08-2.07,2.08,2.08,0,0,1,2.08,2.07" style="fill: #fff" />
                      <path d="M585.06,123.91a2.08,2.08,0,1,1-2.07-2.07,2.08,2.08,0,0,1,2.07,2.07" style="fill: #fff" />
                      <polyline points="12 139.69 84.26 139.69 86.5 144.6 88.73 139.69 249.79 139.69 252.03 144.6 254.27 139.69 417.83 139.69 420.07 144.6 422.31 139.69 580.75 139.69 582.99 144.6 585.23 139.69 660.63 139.69" style="fill: none;stroke: #000;stroke-linecap: round;stroke-linejoin: round;stroke-width: 0.28299999237060547px" />
                      <text transform="translate(48.96 165.81)" style="font-size: 19.12470054626465px;font-family: Helvetica, Helvetica<?= in_array("1", $agro_categoria) ? ";fill: #2a9a42" : "" ?>">HOGAR</text>
                      <path d="M86.5,99.09A49.6,49.6,0,0,1,37,49.55a1,1,0,1,1,2,0,47.55,47.55,0,1,0,9.58-28.63,1,1,0,0,1-1.58-1.2A49.54,49.54,0,1,1,86.5,99.09" style="<?= in_array("1", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                      <path d="M86.5,121.69a1,1,0,0,1-1-1V98.1a1,1,0,0,1,2,0v22.6a1,1,0,0,1-1,1" style="<?= in_array("1", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                      <path d="M419.83,121.09a.82.82,0,0,1-.76-.88v-20c0-1.74,0-1.15.86-1.15.66,0,.66-.47.66.83v20.3a.82.82,0,0,1-.76.88" style="<?= in_array("4", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                      <path d="M86.43,94.33a44.46,44.46,0,1,1,38.73-22.65l-.74-.42A43.64,43.64,0,1,0,111,85.93l.48.7a44.28,44.28,0,0,1-25,7.7" style="<?= in_array("1", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                      <text transform="translate(207.3 165.81)" style="font-size: 19.12470054626465px;font-family: Helvetica, Helvetica<?= in_array("3", $agro_categoria) ? ";fill: #2a9a42" : "" ?>">FORESTAL</text>
                      <g style="clip-path: url(#clip-path-4)">
                        <rect x="581.99" y="97.1" width="1.99" height="16.57" style="<?= in_array("2", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                      </g>
                      <g style="clip-path: url(#clip-path-5)">
                        <rect x="251.04" y="97.11" width="1.98" height="16.57" style="<?= in_array("3", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                      </g>
                      <g style="clip-path: url(#clip-path-6)">
                        <rect x="202.49" width="99.09" height="99.09" style="<?= in_array("3", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                      </g>
                      <g style="clip-path: url(#clip-path-7)">
                        <rect x="207.07" y="1.72" width="93.48" height="95.8" style="<?= in_array("3", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                      </g>
                      <text transform="translate(369.32 165.81)" style="font-size: 19.12470054626465px;font-family: Helvetica, Helvetica<?= in_array("4", $agro_categoria) ? ";fill: #2a9a42" : "" ?>">AGRÍCOLA</text>
                      <g style="mix-blend-mode: multiply">
                        <g style="clip-path: url(#clip-path-8)">
                          <g style="mix-blend-mode: multiply">
                            <g style="clip-path: url(#clip-path-8)">
                              <path d="M420.07,99.09a49.6,49.6,0,0,1-49.55-49.54,1,1,0,1,1,2,0,47.55,47.55,0,1,0,9.58-28.63,1,1,0,0,1-1.58-1.2,49.54,49.54,0,1,1,39.56,79.37" style="<?= in_array("4", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                            </g>
                          </g>
                        </g>
                      </g>
                      <g style="mix-blend-mode: multiply">
                        <g style="clip-path: url(#clip-path-10)">
                          <path d="M420.13,94.33a44.46,44.46,0,1,1,38.73-22.65l-.74-.42a43.66,43.66,0,1,0-13.46,14.67l.49.7a44.33,44.33,0,0,1-25,7.7" style="<?= in_array("4", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                        </g>
                      </g>
                      <text transform="translate(520.84 165.81)" style="font-size: 19.12470054626465px;font-family: Helvetica, Helvetica<?= in_array("2", $agro_categoria) ? ";fill: #2a9a42" : "" ?>">PROFESIONAL</text>
                      <g style="clip-path: url(#clip-path-11)">
                        <rect x="533.44" width="99.09" height="99.09" style="<?= in_array("2", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                      </g>
                      <g style="clip-path: url(#clip-path-12)">
                        <rect x="538.25" y="1.72" width="93.48" height="95.8" style="<?= in_array("2", $agro_categoria) ? "fill: url(#linear-gradient)" : "fill: #d8d8d8" ?>" />
                      </g>
                      <g style="clip-path: url(#clip-path-13)">
                        <image width="512" height="512" transform="translate(394.24 25.07) scale(0.1)" xlink:href="data:image/png;base64,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" />
                      </g>
                      <g style="clip-path: url(#clip-path-14)">
                        <image width="512" height="512" transform="translate(231.31 27.25) scale(0.09)" xlink:href="data:image/png;base64,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" />
                      </g>
                      <g style="clip-path: url(#clip-path-15)">
                        <image width="512" height="512" transform="translate(61.68 26) scale(0.1)" xlink:href="data:image/png;base64,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" />
                      </g>
                      <path d="M586.28,24a1.83,1.83,0,0,1,1.1,1c0,.12.24.21.38.26a12.26,12.26,0,0,1,8.49,10.14.76.76,0,0,0,.34.46,3.23,3.23,0,0,1,1.8,2.89,3.18,3.18,0,0,1-1.63,2.93.53.53,0,0,0-.34.53c.23,3.84-1.39,6.93-3.94,9.64l-.17.21a18.3,18.3,0,0,1,8.18,5.24,14.14,14.14,0,0,0,3-2.28c.84-.82,1.2-.81,2,0a13.22,13.22,0,0,0,6.39,3.65,5,5,0,0,0,.54.08c.86.13,1.12.44,1.15,1.3a17.59,17.59,0,0,1-4.1,11.77,18.54,18.54,0,0,1-2.6,2.71c-1.69,1.41-3,1.37-4.79,0a8.14,8.14,0,0,1-1.16-1,1.29,1.29,0,0,0-1.09-.44H582.71a3.35,3.35,0,0,1-.71-.05,1,1,0,0,1,.07-1.93c.2,0,.41,0,.61,0h16.21l-.42-.64a17.16,17.16,0,0,1-3.11-10.33c0-1,.28-1.26,1.26-1.4a13,13,0,0,0,1.38-.3,5,5,0,0,0,.57-.21A13.25,13.25,0,0,0,594,55c-.1.76-.13,1.53-.3,2.28a10.47,10.47,0,0,1-2.63,4.63c-.43.49-1,.44-1.54-.08-1.71-1.64-3.4-3.3-5.1-4.94l-.42-.4L580.39,60c-.65.63-1.29,1.28-1.95,1.9a1,1,0,0,1-1.48,0,10.34,10.34,0,0,1-2.74-5.17c-.09-.58-.11-1.17-.17-1.82-.41.22-.79.41-1.16.62a17,17,0,0,0-7.44,9.21,33.47,33.47,0,0,0-1.18,4.31c-.32,1.5,0,2,1.57,2,2.27.08,4.54,0,6.8.06a4.85,4.85,0,0,1,.66,0,1,1,0,0,1,.86,1,1,1,0,0,1-.79,1,2.21,2.21,0,0,1-.35,0l-7.31-.05-.3,0c-2.32-.22-3.53-1.68-3.16-4,.88-5.54,3.16-10.33,7.62-13.92a17.57,17.57,0,0,1,5.48-2.93l.4-.15-.38-.42a13.38,13.38,0,0,1-3.53-6.45,18,18,0,0,1-.19-2.85.68.68,0,0,0-.39-.67,3.28,3.28,0,0,1,.18-5.77.72.72,0,0,0,.4-.67,12.23,12.23,0,0,1,4.51-7.84,12.4,12.4,0,0,1,4.16-2.19,1.2,1.2,0,0,0,.41-.24c.35-.32.68-.65,1-1ZM573.55,42.19a16,16,0,0,0,.32,2.92,12.69,12.69,0,0,0,7.9,8.53,5.54,5.54,0,0,0,3.7.23,12.71,12.71,0,0,0,8.67-8.53,8.31,8.31,0,0,0,.26-3.15Zm38,18.52a15.46,15.46,0,0,1-7.09-3.83c-2.93,2.37-3.26,2.55-7.13,3.87,0,.67.06,1.36.16,2a17,17,0,0,0,5.4,9.93c1.25,1.2,1.86,1.18,3.13,0a18.68,18.68,0,0,0,4.49-6.5,14.35,14.35,0,0,0,1-5.5M584,40.17h10.63a4.86,4.86,0,0,0,.66,0,1.25,1.25,0,0,0,1.08-1,1.32,1.32,0,0,0-1.46-1.55h-5.19l-10,0-6.34,0a3.2,3.2,0,0,0-.7.06,1.23,1.23,0,0,0-1,1.21c0,.83.55,1.34,1.53,1.35H584M573.9,35.51a.35.35,0,0,0,.13.05c1.75,0,3.49,0,5.24,0a.58.58,0,0,0,.39-.33,22.39,22.39,0,0,0,1.16-7.92,10,10,0,0,0-6.92,8.21m13.58-8.13a21.87,21.87,0,0,0,1.13,7.87c.11.29.28.32.54.32h4.68c.13,0,.25,0,.37,0a10.1,10.1,0,0,0-6.72-8.14M582.84,26a29.19,29.19,0,0,1-1.15,9.49h4.91A27.79,27.79,0,0,1,585.46,26Zm-5.06,33.7c1.38-1.33,2.71-2.62,4.07-4a2.93,2.93,0,0,1-.37-.14,28.5,28.5,0,0,1-3.1-1.49,1.77,1.77,0,0,0-1.8-.22.52.52,0,0,0-.41.47,6.8,6.8,0,0,0,1.61,5.33m12.45,0a6.56,6.56,0,0,0,1.67-5c0-.23-.14-.61-.29-.65-.47-.14-.9-.49-1.47-.16-1.08.61-2.19,1.14-3.3,1.7-.19.09-.4.14-.64.23l4,3.93" />
                      <path d="M576.69,72.13a1,1,0,0,1,1-1,1,1,0,1,1-1,1" />
                      <path d="M603.93,65.89,606.52,63a1,1,0,0,1,1.08-.34.84.84,0,0,1,.68.78,1.47,1.47,0,0,1-.27.87q-1.57,1.8-3.2,3.55a1,1,0,0,1-1.4.11c-.56-.4-1.1-.82-1.64-1.25a1,1,0,0,1-.21-1.43,1,1,0,0,1,1.43-.15c.31.22.61.46.94.71" />
                      <rect x="561.99" y="24.01" width="51.7" height="51.7" style="fill: none" />
                      <rect x="561.99" y="24.01" width="51.7" height="51.7" style="fill: none" />
                    </g>
                  </g>
                </g>
              </svg>

              <div class="row">
                <?php
                $nConexion = Conectar();
                mysqli_set_charset($nConexion, 'utf8');
                $sql = "SELECT * FROM agro_usos";
                $stmt = mysqli_query($nConexion, $sql);
                while ($usos = mysqli_fetch_object($stmt)) {
                  $activo = "";
                  if ($usos->id == $rxProducto["usos"]) $activo = "activo";
                  echo "
                  <div class='col-md-4 $activo'>
                    Uso $usos->nombre
                  </div>";
                } ?>
              </div>
            </div>
            <?php
            $sql = "SELECT idproducto, url, nombre FROM tblti_productos WHERE idproducto!={$rxProducto["idproducto"]} AND activo=1 AND idproducto IN (SELECT idproductoa FROM tblti_productos_asociados WHERE idproducto={$rxProducto["idproducto"]})";
            $stmt = mysqli_query($nConexion, $sql);
            if (mysqli_num_rows($stmt) > 0) { ?>
              <div class="row">
                <div class="col-12" class="productos-relacionados">
                  <h3>PRODUCTOS RELACIONADOS</h2>
                    <div class="productos-categorias">
                      <?php
                      $RegContenido = mysqli_fetch_object(VerContenido("Carrito"));
                      while ($product = mysqli_fetch_assoc($stmt)) {
                        echo "<div class='listado px-2'>
                        <div class='content-product'>
                          <a class='imagenBlog' href='$home/productos/{$product["url"]}'><img src='$home/fotos/tienda/productos/m_{$imagenes[$product["idproducto"]]["imagen"]}' alt='{$product["nombre"]}' /></a>
                          <h3 class='title'>{$product["nombre"]}</h3>
                          <a href='$home/productos/{$product["url"]}' class='link'>Ver más</a>
                          <div class='productPriceWrapRight cesta'>
                            <a href='$home/php/inc/functions.php?action=addToBasket&productID={$product["idproducto"]}' id='featuredProduct_{$product["idproducto"]}' class='1' onClick='return false;'>
                              $RegContenido->contenido
                            </a>
                          </div>
                        </div>
                      </div>";
                      } ?>
                    </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="background-relacionados">
          <div class="container-producto">
            <div class="row">
              <div class="col-12">
                <h3 class="productos-relacionados">Productos relacionados</h2>
                  <div class="productos-categorias">
                    <?php
                    $nConexion = Conectar();
                    mysqli_set_charset($nConexion, 'utf8');
                    $sql = "SELECT idproducto, url, nombre FROM tblti_productos WHERE idmarca={$rxProducto["idmarca"]} AND idproducto!={$rxProducto["idproducto"]} AND activo=1";
                    $stmt = mysqli_query($nConexion, $sql);
                    while ($product = mysqli_fetch_assoc($stmt)) {
                      echo "
                      <div class='listado px-2'>
                        <div class='content-product' style='background:white; flex-direction:column; display:flex; justify-content:center; border-radius:25px; min-height:360px; max-height:360px;
                        '>
                        <h3 class='title' style='padding:1.5rem;' >{$product["nombre"]}</h3>
                          <a class='imagenBlog' style='padding-bottom:10px' href='$home/productos/{$product["url"]}'>
                            <img src='$home/fotos/tienda/productos/m_{$imagenes[$product["idproducto"]]["imagen"]}' alt='{$product["nombre"]}' />
                          </a>
                          <a style='padding:0.5rem 1.2rem; margin-bottom:15px;   font-size:0.8rem' href='$home/productos/{$product["url"]}' class='link'>Ver más</a>
                        </div>
                      </div>";
                    }
                    ?>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--- Sección de Creado por --->
      <?php require_once("footer.php"); ?>
      <!--- Sección de Creado por --->
      <style>
        .logo {
          display: none !important;
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

        @media only screen and (max-width: 820px) {
          .logoBarra {
            opacity: 1;
            display: block;
            right: 70px;
          }

          .logoBarra img {
            height: 38px !important;
            width: auto !important;
          }
        }
      </style>
      <div class="arrow bounce">
        <span class="fa fa-arrow-down fa-2x"></span>
      </div>
    </div>
  </div>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
      </div>
    </div>
  </div>
  <script src="https://ui.mlstatic.com/chico/tiny/0.2.4/tiny.min.js"></script>
  <script src="https://ui.mlstatic.com/chico/2.0.11/ui/chico.min.js"></script>
  <script>
    window.onload = function() {

      var zoom = new ch.Zoom(ch('.zoom')[0], {
        'width': (ch.viewport.width / 4) + 'px',
        'height': (ch.viewport.width / 4) + 'px'
      });
      zoom.loadImage();

    };
  </script>

  <script type="text/javascript" src="<?php echo $home; ?>/php/lightbox/js/lightbox-2.6.min.js"></script>
  <script src="<?php echo $home; ?>/php/slick/slick.min.js" type="text/javascript"></script>

  <script type="text/javascript">
    $(document).on('ready', function() {
      $('.ampliar').on('click', function(e) {
        e.preventDefault();
        $('.modal-descripcion').toggleClass("abierto");
        $(this).toggleClass("activo");
        var text = $(this).text();
        if (text === "Ver información importante") {
          $(this).html('Ocultar información importante');
        } else {
          $(this).text('Ver información importante');
        }
      });

      $('.sliderProductos').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        autoplay: true,
        autoplaySpeed: 6000,
        asNavFor: '.slider-nav'
      });
      $('.slider-nav').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.sliderProductos',
        focusOnSelect: true,
        responsive: [{
          breakpoint: 1300,
          settings: {
            slidesToShow: 3
          }
        }, {
          breakpoint: 768,
          settings: {
            slidesToShow: 2
          }
        }, {
          breakpoint: 560,
          settings: {
            slidesToShow: 1
          }
        }]
      });
      $('.productos-categorias').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        focusOnSelect: true,
        responsive: [{
          breakpoint: 1300,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1
          }
        }, {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        }, {
          breakpoint: 560,
          settings: {
            slidesToShow: 1,
            adaptiveHeight: true,
            slidesToScroll: 1
          }
        }]
      });

      $("body").on("click", ".openmodal", function() {
        var url = $(this).data('url');

        $.post(
          '/add-to-wishlist/' + url, {
            url: url
          },
          function(data) {
            $('#myModal .modal-content').html(data);
          });
        $("#myModal").modal('show');
      });

      $("#myModal").on("submit", "#modal-form", function(e) {
        e.preventDefault();
        var postData = $(this).serialize();
        var formURL = $(this).attr("action");
        var url = $(this).find("#url").val();
        var num = $(".total-lista");
        $.ajax({
          url: formURL,
          type: "POST",
          data: postData,
          success: function(data) {
            $('#myModal').modal('hide');
            if (url) {
              $('.lista-deseos').addClass('shake');
              setTimeout(function() {
                $('.lista-deseos').removeClass('shake');
              }, 500);
              num.text(Number(num.text()) + 1);
              $('[data-url="' + url + '"]').find("i").removeClass('fa-heart-o');
              $('[data-url="' + url + '"]').find("i").addClass('fa-heart text-danger');
            }
          }
        });
      });
    });
  </script>
</body>

</html>

<script src="/php/js/jquery.arctext.js"></script>