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

        $sql="delete from tblconsultoria_preguntas where idpregunta={$_GET["idpregunta"]}";

        $r = mysqli_query($nConexion,$sql);

        if(!$r){

            Mensaje("fallo eliminando pregunta ".mysqli_error($nConexion),"listar.php" );

        }

    }

    

    $page = new sistema_paginacion("tblconsultoria_preguntas a,tblconsultoria_profesionales b,tblconsultoria_profesiones c,tblusuarios_externos d ");

    $page->set_condicion("where a.idprofesion=c.idprofesion and a.idprofesional=b.idprofesional and a.idusuario=d.idusuario");

    $page->ordenar_por("c.profesion");

    $page->set_campos("a.idpregunta,a.fechahora,a.titulo_pregunta,b.nombre AS Especialista,c.profesion,a.pregunta,d.usuario,a.pregunta");

    $page->set_limite_pagina(20);

    $rsPreguntas = $page->obtener_consulta();

    $page->set_color_tabla("#FEF1E2");

    $page->set_color_texto("black");

    $page->set_color_enlaces("black","#FF9900");

    

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

        <td colspan="17" align="center" class="tituloFormulario">

          <center>

          <b>LISTA DE PREGUNTAS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

          </center>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Id</b></td>

        <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>

        <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Titulo pregunta</b></td>

        <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Especialista</b></td>

        <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Profesión</b></td>

        <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Usuario</b></td>

        <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Pregunta</b></td>

        <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Eliminar</b></td>

        <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>

      </tr>

      <?

        $ContFilas		= 0;

        $ColorFilaPar	= "#FFFFFF";

        $ColorFilaImpar	= "#F0F0F0";

        while( $row = mysqli_fetch_object( $rsPreguntas ) )

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

            <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idpregunta"; ?></td>

            <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fechahora"; ?></td>

            <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->titulo_pregunta"; ?></td>

            <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->Especialista"; ?></td>

            <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->profesion"; ?></td>

            <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->usuario"; ?></td>

            <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->pregunta"; ?></td>

            <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

<? /*            <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="listar.php?modulo=<?=$modulo;?>&accion=ampliar&idpregunta=<?=$row->idpregunta;?>">

            <img src="../../image/seleccionar.gif" border="0" ></a></td> */

?>

            <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="listar.php?modulo=<?=$modulo;?>&accion=eliminar&idpregunta=<?=$row->idpregunta;?>" onclick="return confirm('¿Seguro que desea eliminar este registro?');">

            <img src="../../image/borrar.gif" border="0" ></a></td>

            <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="17"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="17">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="17" class="nuevo">

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

