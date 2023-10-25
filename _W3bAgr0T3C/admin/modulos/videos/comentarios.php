<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include ("../../vargenerales.php");

  require_once("../../funciones_generales.php");



  $nConexion = Conectar();



  if( isset($_GET["eliminar"]) ){

    mysqli_query($nConexion,"delete from tblvideos_comentarios where idcomentario={$_GET["eliminar"]}");

  }



  $page=new sistema_paginacion('tblvideos_comentarios');

  $page->set_condicion("where idvideo={$_GET["Id"]}");

  $page->ordenar_por('idcomentario');

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

        <td colspan="7" align="center" class="tituloFormulario">

          <center>

          <b>LISTA DE COMENTARIOS A VIDEOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

          </center>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>

        <td bgcolor="#FEF1E2"><b>Comentario</b></td>

        <td bgcolor="#FEF1E2" align="center"><b>Eliminar</b></td>

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idcomentario"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fecha"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->comentario"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>" align="center"><a href="comentarios.php?Id=<?=$_GET["Id"];?>&eliminar=<?=$row->idcomentario;?>"><img src="../../image/eliminar.gif" border="0" ></a></td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="7"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="7">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="7" class="nuevo">

          <a href="listar_categorias.php">Regresar</a>

        </td>

      </tr>

      </table>

      <br><br><br><br><br>

      <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

      </tr>

      </table>

    </body>

</html>









