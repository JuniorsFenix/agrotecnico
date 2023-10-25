<?

    include("../../herramientas/seguridad/seguridad.php");

    include("../../herramientas/paginar/class.paginaZ.php");

    include ("../../vargenerales.php");

    require_once("../../funciones_generales.php");



    $accion = isset($_GET["accion"])?$_GET["accion"]:"";



    

    function foroListarCategorias() {

	$nConexion = Conectar();

	$sql = "SELECT

	    idcategoria

	    nombre as nombre_categoria

	    FROM tblforo_categorias

	    ORDER BY idcategoria DESC";

	

	$ra = mysqli_query($nConexion,$sql);

	if ( !$ra ) {

	    die("Fallo consultando categorias de foro");

	}

    }

    

    function foroEliminarCategoria($d) {

	$nConexion = Conectar();

	$sql = "DELETE FROM tblforo_comentarios WHERE idtema IN (SELECT idtema FROM tblforo_temas WHERE idcategoria= {$d})";

	//die($sql);

	$r = mysqli_query($nConexion,$sql);

	if( !$r ) {

            return "Fallo eliminando comentarios de la categoria ".mysqli_error($nConexion);

        }

	$sql = "DELETE FROM tblforo_temas WHERE idcategoria = {$d}";

	$r = mysqli_query($nConexion,$sql);

	if( !$r ) {

            return "Fallo eliminando temas de la categoria ".mysqli_error($nConexion);

        }

	$sql = "DELETE FROM tblforo_categorias WHERE idcategoria = {$d}";

	

        $r = mysqli_query($nConexion,$sql);

        if(!$r){

            return "fallo eliminando categoria ".mysqli_error($nConexion);

        }

	return true;

    }

    

    if( $_GET["accion"]=="eliminar" ) {

	$result = foroEliminarCategoria($_GET["idcategoria"]);

	

	if( $result != true ) {

            die($result);

        }

	

    }

        

    

	

//    $rsCategorias = foroListarCategorias();

	

   

    $page = new sistema_paginacion('tblforo_categorias');

    $page->set_condicion("where 1=1");

    $page->ordenar_por('nombre');

    $page->set_limite_pagina(20);

    $rsCategorias = $page->obtener_consulta();

    $page->set_color_tabla("#FEF1E2");

    $page->set_color_texto("black");

    $page->set_color_enlaces("black","#FF9900");

?>



<html>

  <head>

    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">



  </head>

  <body>

    

  <? include("../../system_menu.php"); ?><br>

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="9" align="center" class="tituloFormulario">

          <center>

          <b>CATEGORIAS	DEL FORO</b>

          <br>

          <? /*$page->mostrar_numero_pagina()*/ ?><br>

          </center>

        </td>

      </tr>

      <tr>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Categoria</b></td>

	<td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>

	<td bgcolor="#FEF1E2" align="center"><b>Eliminar</b></td>

        

      </tr>

      <?

        $ContFilas		= 0;

        $ColorFilaPar	= "#FFFFFF";

        $ColorFilaImpar	= "#F0F0F0";

        while($row = mysqli_fetch_assoc($rsCategorias)){

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

	    <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["nombre"];?></td>

	    <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="categorias.php?accion=editar&idcategoria=<?=$row["idcategoria"];?>">&nbsp;<img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo $row["idcategoria"]; ?>"></a></td>

            <td bgcolor="<? echo $ColorFila; ?>"align="center">

	    <a href="listar_categorias.php?accion=eliminar&idcategoria=<?=$row["idcategoria"];?>" onclick="return confirm('¿Seguro que desea eliminar este registro?');">

            <img src="../../image/borrar.gif" border="0" ></a></td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="9"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="9">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="9" class="nuevo">

	    <a href="categorias.php?accion=adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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

