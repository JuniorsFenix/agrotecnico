<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include ("../../vargenerales.php");

  require_once("../../funciones_generales.php");



    $nConexion = Conectar();

    

    $sql="

    CREATE TABLE `tblvideosyoutube_categorias` (

      `idciudad` int(11) NOT NULL,

      `idcategoria` int(11) NOT NULL auto_increment,

      `idcategoria_superior` int(11) NOT NULL,

      `nombre` varchar(200) character set latin1 collate latin1_spanish_ci NOT NULL,

      `vpath` text NOT NULL,

      `descripcion` varchar(255) NOT NULL,

      PRIMARY KEY  (`idcategoria`)

    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    ";

    

    @ mysqli_query($nConexion,$sql);



  

  $sql="select * from tblvideosyoutube_categorias where idcategoria = 0";

  $ra = mysqli_query($nConexion,$sql);

  if( mysqli_num_rows($ra) == 0 ){

    $sql="insert into tblvideosyoutube_categorias (idciudad,idcategoria,nombre,vpath,descripcion) values (1,-1,'--CATEGORIA PRINCIPAL--','/','')";

	  echo $sql;

    

    $r = mysqli_query($nConexion, $sql);

    $sql="update tblvideosyoutube_categorias set idcategoria=0 where idcategoria=-1";

    echo $sql;

    $r = mysqli_query($nConexion, $sql);

  }

    $sql="alter table tblvideosyoutube_categorias add idcategoria integer";

    $r = mysqli_query($nConexion, $sql);



  $page=new sistema_paginacion('tblvideosyoutube_categorias');

  $page->set_condicion("where idcategoria<>0");

  $page->ordenar_por('vpath,nombre');

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

        <td colspan="6" align="center" class="tituloFormulario">

          <center>

          <b>LISTA DE CATEGORIAS DE VIDEOS YOUTUBE</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

          </center>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id</b></td>

        <td bgcolor="#FEF1E2"><b>Nombre</b></td>

        <td bgcolor="#FEF1E2"><b>Descripción</b></td>

        <td bgcolor="#FEF1E2"><b>Path</b></td>

        <td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>

        <td bgcolor="#FEF1E2" align="center"><b>Productos</b></td>

      </tr>

      <?

        $ContFilas		= 0;

        $ColorFilaPar	= "#FFFFFF";

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idcategoria"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nombre"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->descripcion"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->vpath"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="categorias.php?Accion=Editar&Id=<? echo "$row->idcategoria"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->idcategoria"; ?>"></a></td>

          <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="listar.php?idcategoria=<? echo "$row->idcategoria"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="">Ver videos</a></td>

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

          <a href="categorias.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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









