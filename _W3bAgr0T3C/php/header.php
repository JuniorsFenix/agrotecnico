<script type="text/javascript">
  /* Abrir ventana modal */
  function abrirModalPage() {
    element = document.getElementById("modalPage");
    if (element.style.display = "none") {
      element.style.display = "none"
    } else {
      element.style.display = "block"
    }
  }
</script>


<?php
include("diasiniva.php");

require_once("inc/functions.php");
$page = $_GET["pagename"];

$contenidoLanding = mysqli_fetch_object(VerContenido("modal-home"));
$img = "/fotos/Image/contenidos/" . $contenidoLanding->imagen;
$verhome = $contenidoLanding->verhome;

if ($_SESSION['loggedin'] == true && $_SESSION["usuario"]["cotizacion"] == 1) {
  define("COTIZAR", true);
} else {
  define("COTIZAR", false);
}

?>

<?php if (COTIZAR == false) { ?>
  <!-- Start of  Zendesk Widget script -->
  <!--<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=8f5c1662-2dbd-4e4d-8f5c-af1f86b3d3e9"> </script>-->
  <!-- End of  Zendesk Widget script -->

  <!--<script src="//code.jivosite.com/widget/5ZGhUpgJap" async></script>-->
<?php } ?>

<!--Inicio Header-->
<header>

  <?php

  $html = " <div class='modal_page' id='modalPage' onclick='abrirModalPage()' >
                  <div id='divModalPage'>
                    <img src='{$img}'>
                  </div>
                </div>
              ";

  // Comportamiento de la ventana modal
  if ($contenidoLanding == true) {
    // publicar = true
    if ($verhome == "S") {
      // ver solo en home
      if ($page == "home") {
        echo $html;
      }
    } else {
      // ver en todas las paginas
      echo $html;
    }
  }
  ?>

  <div class="container">
    <div class="row">
      <div class="col-3 text-center">
        <div class="logoMenu">
          <?php
          $RegContenido = mysqli_fetch_object(VerContenido("logo-menu"));
          echo $RegContenido->contenido;
          ?>
        </div>
      </div>
      <div class="col-9">
        <div class="row">
          <div class="col-12">
            <div class="header--first-row">
              <nav class="menu">
                <?php ImprimirMenuPpal3(); ?>
              </nav>
              <div class="header-buttons--first-row">
                <a class="carrito" href="<?= COTIZAR ? $home . '/carrito-cotizar' : $home . '/carrito'; ?>">
                  <span class="total">
                    <?php
                    echo total();
                    ?>
                  </span>
                  <?php $RegContenido = mysqli_fetch_object(VerContenido("Carrito"));
                  echo $RegContenido->contenido;
                  ?>
                </a>
                <ul class='infoUsuario'>
                  <?php
                  if ($_SESSION['loggedin'] == true) {
                    echo "
                            <li class='mi-cuenta'>
                                <label for='nav-check'>{$_SESSION["usuario"]["nombre"]} 
                                    <img alt='Ampliar' src='$home/fotos/Image/flecha.png' width='15px'>
                                </label>
                                <input type='checkbox' id='nav-check'>
                                <ul>
                                    <li><a href='$home/mi-cuenta'>Mi cuenta</a></li>";

                    if ($_SESSION["usuario"]["perfil"] == 1) {
                      echo "<li><a href='$home/registrarse'>Registro</a></li>";
                    }
                    if (COTIZAR) {
                      echo "<li><a href='$home/clientes'>Clientes</a></li>";
                    }
                    echo "<li><a href='$home/cerrar-sesion'>Cerrar sesión</a></li>
                                </ul>
                            </li>";
                  } else {
                    echo "<li class='mi-cuenta'><a href='$home/iniciar-sesion' style='color: #a3d900;'><img alt='Ampliar' src='$home/fotos/Image/perfil.png' width='30px'></a></li>";
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-12 mt-3">
            <form action="<?php echo $home; ?>/buscar" class="buscar" method="get">
              <input list="Productos" id="buscar" name="buscar" placeholder="Buscar Producto" type="text" class="form-control">
              <?php $productos = CargarNombreProductos(); ?>
              <?php
              if ($productos) {
                echo '<datalist id="Productos">';
                while ($row = mysqli_fetch_assoc($productos)) {
                  $idproducto = $row['idproducto'];
                  $nombre = $row['nombre'];
                  echo "<option value=\"$nombre\">$nombre</option>";
                }
                echo '</datalist>';
              }
              ?>
              <input list="Marcas" id="marca" name="marca" placeholder="Marca" class="form-control">
              <?php $marcas = CargarMarcas(); ?>
              <?php
              if ($marcas) {
                echo '<datalist id="Marcas">';
                while ($row = mysqli_fetch_assoc($marcas)) {
                  $idmarca = $row['idmarca'];
                  $nombre = $row['nombre'];
                  echo "<option value=\"$nombre\">$nombre</option>";
                }
                echo '</datalist>';
              }
              ?>
              <input list="Segmentos" id="segmento" name="segmento" placeholder="Segmento" class="form-control">
              <?php $categorias = CargarCategoriasProductos(); ?>
              <?php
              if ($categorias) {
                echo '<datalist id="Segmentos">';
                while ($row = mysqli_fetch_assoc($categorias)) {
                  $idcategoria = $row['idcategoria'];
                  $nombre = $row['nombre'];
                  echo "<option value=\"$nombre\">$nombre</option>";
                }
                echo '</datalist>';
              }
              ?>
              <input list="Hogares" id="hogar" name="hogar" placeholder="Hogar" class="form-control">
              <?php $categoriasAgro = CargarCategoriasAgro(); ?>
              <?php
              if ($categoriasAgro) {
                echo '<datalist id="Hogares">';
                while ($row = mysqli_fetch_assoc($categoriasAgro)) {
                  $idcategoria = $row['id'];
                  $nombre = $row['nombre'];
                  echo "<option value=\"$nombre\">$nombre</option>";
                }
                echo '</datalist>';
              }
              ?>
              <input list="Referencias" id="referencia" name="referencia" placeholder="Referencia" class="form-control">
              <?php $referencias = CargarReferenciasProductos(); ?>
              <?php
              if ($referencias) {
                echo '<datalist id="Referencias">';
                while ($row = mysqli_fetch_assoc($referencias)) {
                  $idproducto = $row['idproducto'];
                  $referencia = $row['referencia'];
                  echo "<option value=\"$referencia\">$referencia</option>";
                }
                echo '</datalist>';
              }
              ?>
              <button class="header--submit-filter" type="submit"><img src="<?php echo $home; ?>/fotos/Image/search-icon.png" alt=""></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="row">
    <div class="col-12">
      <nav class="menu">
        <div class="logoMenu">
          <?php
          $RegContenido = mysqli_fetch_object(VerContenido("logo-menu"));
          echo $RegContenido->contenido; ?>
        </div>
        <?php ImprimirMenuPpal3(); ?>
      </nav>
      <div class="logoBarra" data-50="opacity:0;margin-right:-50px" data-150="opacity:1;margin-right:0">
        <?php echo $sitioCfg["logo"]; ?>
      </div>
      <button class="menuP">
        <span>MEN脷</span>
      </button>
    </div>
  </div> -->
</header>
<!--Final Header-->