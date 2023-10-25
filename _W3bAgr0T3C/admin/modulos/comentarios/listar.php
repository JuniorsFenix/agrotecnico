<?

    include("../../herramientas/seguridad/seguridad.php");

    include("../../herramientas/paginar/class.paginaZ.php");

    include ("../../vargenerales.php");

    require_once("../../funciones_generales.php");

    

    $modulo = isset($_GET["modulo"]) ? $_GET["modulo"]:"TODOS";

    

    $where="1=1";

    if( $modulo!="TODOS" ){

        $where = "modulo='{$modulo}'";

    }



    $nConexion = Conectar();

    

    

    if( isset($_GET["accion"]) && $_GET["accion"]=="eliminar" ){

        $sql="delete from tblcomentarios where idcomentario={$_GET["idcomentario"]}";

        $r = mysqli_query($nConexion,$sql);

        if(!$r){

            die("fallo eliminando comentario ".mysqli_error($nConexion) );

        }

    }

        

    $sql = "SELECT DISTINCT modulo FROM tblcomentarios";

    $rsComentarios = mysqli_query($nConexion,$sql);

    

    $page = new sistema_paginacion('tblcomentarios');

    $page->set_condicion("where {$where}");

    $page->ordenar_por('modulo,idcomentario');

    $page->set_limite_pagina(20);

    $rs_contenidos = $page->obtener_consulta();

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

        <td colspan="9" align="center" class="tituloFormulario">

          <center>

          <b>LISTA DE COMENTARIOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

          </center>

        </td>

      </tr>

      <tr>

        <td>

            <select nombre="filtro"  onchange="location='listar.php?modulo='+this.value;">

                <option value="TODOS">TODOS</option>

                <?php while($row = mysqli_fetch_assoc( $rsComentarios )):?>

                <option value="<?=$row["modulo"];?>"  <?=$row["modulo"]==$modulo?"selected":"";?> ><?=$row["modulo"];?></option>

                <?php endwhile;?>

            </select>

        </td>

        <td colspan="8"></td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>

        <td bgcolor="#FEF1E2"><b>Modulo</b></td>

        <td bgcolor="#FEF1E2"><b>Id Item</b></td>

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

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fechahora"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->modulo"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->iditem"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->usuario"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nombre"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->correo_electronico"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->comentario"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="listar.php?modulo=<?=$modulo;?>&accion=eliminar&idcomentario=<?=$row->idcomentario;?>" onclick="return confirm('¿Seguro que desea eliminar este registro?');">

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

