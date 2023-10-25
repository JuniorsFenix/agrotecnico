<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include ("../../vargenerales.php");

  require_once("../../funciones_generales.php");



  $nConexion = Conectar();

  //@ $exists = mysqli_query($nConexion,"drop table tblmensajes");

  @ $exists = mysqli_query($nConexion,"SELECT 1 FROM tblmensajes LIMIT 0");

  if(!$exists){

    $sql="

      CREATE TABLE `tblmensajes` (

      `idciudad` int not null,

      `idmensaje` int(11) NOT NULL auto_increment,

      `nombre` varchar(200) collate latin1_spanish_ci default NULL,

      `email` varchar(200) collate latin1_spanish_ci default NULL,

      `titulo` varchar(200) collate latin1_spanish_ci NOT NULL,

      `mensaje` TEXT collate latin1_spanish_ci default NULL,

      `fecha` date not null,

      `hora` time not null,

      `imagen` varchar(200),

      PRIMARY KEY  (`idmensaje`)

      ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

    ";



    @ $r = mysqli_query($nConexion, $sql);

    if(!$r){

      die("Fallo creando tabla para almacenar mensajes<br/>".mysqli_error($nConexion));

    }

  }



  $page=new sistema_paginacion('tblmensajes');

  $page->ordenar_por('fecha desc,hora desc');

  $page->set_limite_pagina(20);

  $rs_contenidos=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900")

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

        <td colspan="5" align="center" class="tituloFormulario">

          <center>

          <b>LISTA DE CLASIFICADOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

          </center>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id</b></td>

        <td bgcolor="#FEF1E2"><b>Titulo</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>

        <td bgcolor="#FEF1E2"><b>Hora</b></td>



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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idmensaje"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->titulo"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fecha"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->hora"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="mensajes.php?Accion=Editar&Id=<? echo "$row->idmensaje"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->idmensaje"; ?>"></a></td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="5"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="5">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="5" class="nuevo">

          <a href="mensajes.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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









