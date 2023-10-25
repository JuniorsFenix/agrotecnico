<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include ("../../vargenerales.php");

  require_once("../../funciones_generales.php");



  $nConexion = Conectar();

  @ $exists = mysqli_query($nConexion,"SELECT 1 FROM tblvideos LIMIT 0");

  if(!$exists){

    $sql="

      CREATE TABLE `tblvideos` (

      `idciudad` int not null,

      `idvideo` int(11) NOT NULL auto_increment,

      `nombre` varchar(200) collate latin1_spanish_ci NOT NULL,

      `descripcion` varchar(255) not null,

      `pais` varchar(100) collate latin1_spanish_ci default NULL,

      `duracion` varchar(20) collate latin1_spanish_ci default NULL,

      PRIMARY KEY  (`idvideo`)

      ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

    ";



    @ $r = mysqli_query($nConexion, $sql);

    if(!$r){

      Mensaje("Fallo creando tabla para almacenar videos<br/>".mysqli_error($nConexion),"listar.php");

    }

  }



  $page=new sistema_paginacion('tblvideos');

  $page->set_condicion("where idcategoria = {$_GET["idcategoria"]}");

  $page->ordenar_por('nombre');

  $page->set_limite_pagina(20);

  $rs_contenidos=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900");

  

  $videoDest="../../../fotos/videos";

?>



<html>

  <head>

    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">

<style type="text/css">

<!--

body {

  margin-top: 0px;

  margin-bottom:0px;

  margin-left:0px;

  margin-right:0px;

}

-->

</style>



  </head>

  <body>

  <? include("../../system_menu.php"); ?><br>

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="6" align="center" class="tituloFormulario">

          <center>

          <b>LISTA DE VIDEOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

          </center>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id</b></td>

        <td bgcolor="#FEF1E2"><b>Nombre</b></td>

        <td bgcolor="#FEF1E2"><b>Pa�s</b></td>

        <td bgcolor="#FEF1E2"><b>Duraci�n</b></td>

        <td bgcolor="#FEF1E2"><b>Imagen</b></td>



        <td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>

      </tr>

      <?

        $ContFilas			= 0;

        $ColorFilaPar		= "#FFFFFF";

        $ColorFilaImpar	= "#F0F0F0";

        while( $row = mysqli_fetch_object( $rs_contenidos ) )

        {

        $ContFilas = $ContFilas+ 1 ;

        if ( fmod( $ContFilas,2 ) == 0 ) // Si devuelve cero el numero es par

        {

          $ColorFila = $ColorFilaPar;

        }

        else

        {

          $ColorFila = $ColorFilaImpar;

        }

        ?>

        <tr>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idvideo"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nombre"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->pais"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->duracion"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><img src="<?="{$videoDest}/{$row->idvideo}.jpg";?>"></td>

          <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="videos.php?Accion=Editar&Id=<? echo "$row->idvideo"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->idvideo"; ?>"></a></td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="6"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="6">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="6" class="nuevo">

          <a href="videos.php?Accion=Adicionar&idcategoria=<?=$_GET["idcategoria"];?>"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

        </td>

      </tr>

      </table>

      <br><br><br><br><br>

      <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones inform�ticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

      </tr>

      </table>

    </body>

</html>









