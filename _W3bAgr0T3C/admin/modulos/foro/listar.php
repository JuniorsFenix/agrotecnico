<?

    include("../../herramientas/seguridad/seguridad.php");

    include("../../herramientas/paginar/class.paginaZ.php");

    include ("../../vargenerales.php");

    require_once("../../funciones_generales.php");



    $accion = isset($_GET["accion"])?$_GET["accion"]:"";

    $nConexion = Conectar();

    

    

    if( $_GET["accion"]=="eliminar" ){

        $sql="delete from tblforo_comentarios where idcomentario = {$_GET["idcomentario"]}";

        $r = mysqli_query($nConexion,$sql);

        if(!$r){

            die("fallo eliminando comentario ".mysqli_error($nConexion) );

        }

    }

        

    

	$sql="

	select 

	a.idcomentario,

	a.idtema,

	a.idcomentario,

	a.mensaje,

	a.fechahora,

	a.idusuario,

	a.usuario,

	a.correo_electronico,

	b.idtema,

	b.titulo as titulo_tema,

	b.mensaje as mensaje_tema,

	b.fechahora as fechahora_tema,

	b.idusuario as id_usuario_tema,

	b.usuario as usuario_tema,

	b.correo_electronico as correo_electronico_tema,

	b.lecturas as lecturas_tema,

	c.nombre as nombre_categoria

	

	

	from tblforo_comentarios a

	left join tblforo_temas b on (a.idtema=b.idtema)

	left join tblforo_categorias c on (b.idcategoria=c.idcategoria)

	order by b.idcategoria desc,a.idtema desc,a.idcomentario asc

	";

	

	$rsComentarios = mysqli_query($nConexion,$sql);

	

   

    /*$page = new sistema_paginacion('tblforo_categorias');

    $page->set_condicion("where 1=1");

    $page->ordenar_por('nombre');

    $page->set_limite_pagina(20);

    $rs_contenidos = $page->obtener_consulta();

    $page->set_color_tabla("#FEF1E2");

    $page->set_color_texto("black");

    $page->set_color_enlaces("black","#FF9900")*/

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

          <b>CONVERSACIONES DEL FORO</b>

          <br>

          <? /*$page->mostrar_numero_pagina()*/ ?><br>

          </center>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Categoria</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>

        <td bgcolor="#FEF1E2"><b>Tema</b></td>

        <td bgcolor="#FEF1E2"><b>usuario</b></td>

        <td bgcolor="#FEF1E2"><b>Nombre</b></td>

        <td bgcolor="#FEF1E2"><b>Correo electronico</b></td>

        <td bgcolor="#FEF1E2"><b>Comentario</b></td>

        <td bgcolor="#FEF1E2"><b>Eliminar</b></td>

        

      </tr>

      <?

        $ContFilas		= 0;

        $ColorFilaPar	= "#FFFFFF";

        $ColorFilaImpar	= "#F0F0F0";

        while($row = mysqli_fetch_assoc($rsComentarios)){

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

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["nombre_categoria"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["fecha"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["titulo_tema"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["usuario"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["nombre"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["correo_electronico"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["mensaje"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="listar.php?accion=eliminar&idcomentario=<?=$row["idcomentario"];?>">

            <img src="../../image/borrar.gif" border="0" ></a></td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="9"><? /*$page->mostrar_enlaces();*/ ?></td>

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

