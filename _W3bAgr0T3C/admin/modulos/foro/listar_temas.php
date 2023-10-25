<?

    include("../../herramientas/seguridad/seguridad.php");

    include("../../herramientas/paginar/class.paginaZ.php");

    include ("../../vargenerales.php");

    require_once("../../funciones_generales.php");



    $accion = isset($_GET["accion"])?$_GET["accion"]:"";

    

    

    

    function foroEliminarTema($d) {

	$nConexion = Conectar();

	$sql = "DELETE FROM tblforo_comentarios WHERE idtema = {$d}";

	$r = mysqli_query($nConexion,$sql);

        if( !$r ) {

            return "Fallo eliminando comentarios del tema ".mysqli_error($nConexion);

        }

        $sql = "DELETE FROM tblforo_temas WHERE idtema = {$d}";

        $r = mysqli_query($nConexion,$sql);

        if( !$r ) {

            return "Fallo eliminando tema ".mysqli_error($nConexion);

        }

	return true;

    }

    

    if( $_GET["accion"] == "eliminar" ) {

	$result = foroEliminarTema($_GET["idtema"]);

        if( $result != true ) {

            die($result);

        }

    }

    

   

    $page=new sistema_paginacion('tblforo_temas b

	    LEFT JOIN tblforo_categorias c ON (b.idcategoria=c.idcategoria)');

	//$page->set_condicion( "WHERE a.idciudad = " . $IdCiudad );

	// Si se envio parametro para filtro categorias muestro realizo la condicion

	

	$page->ordenar_por('b.idcategoria DESC');

	$page->set_campos("b.idtema,

	    b.titulo as titulo_tema,

	    b.mensaje as mensaje_tema,

	    b.fechahora as fechahora_tema,

	    b.idusuario as id_usuario_tema,

	    b.usuario as usuario_tema,

	    b.correo_electronico as correo_electronico_tema,

	    b.lecturas as lecturas_tema,

	    c.nombre as nombre_categoria");

	$page->set_limite_pagina(20);

	$rsTemas=$page->obtener_consulta();

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

          <b>TEMAS DEL FORO</b>

          <br>

          <? $page->mostrar_numero_pagina();?><br>

          </center>

        </td>

      </tr>

      <tr>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Categoria</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>

        <td bgcolor="#FEF1E2"><b>Titulo del tema</b></td>

	<td bgcolor="#FEF1E2"><b>Mensaje del tema</b></td>

        <td bgcolor="#FEF1E2"><b>Usuario</b></td>

        <td bgcolor="#FEF1E2"><b>Correo electronico</b></td>

        <td bgcolor="#FEF1E2"><b>Lecturas</b></td>

        <td bgcolor="#FEF1E2"><b>Eliminar</b></td>

      </tr>

      <?

        $ContFilas		= 0;

        $ColorFilaPar	= "#FFFFFF";

        $ColorFilaImpar	= "#F0F0F0";

        while($row = mysqli_fetch_assoc($rsTemas)){

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

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["nombre_categoria"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["fechahora_tema"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["titulo_tema"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["mensaje_tema"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["usuario_tema"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["correo_electronico"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["lecturas_tema"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="listar_temas.php?accion=eliminar&idtema=<?=$row["idtema"];?>" onclick="return confirm('¿Seguro que desea eliminar este registro?');">

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

