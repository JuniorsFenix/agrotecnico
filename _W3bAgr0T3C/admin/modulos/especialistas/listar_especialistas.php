<?

    include("../../herramientas/seguridad/seguridad.php");

    include("../../herramientas/paginar/class.paginaZ.php");

    include ("../../vargenerales.php");

    require_once("../../funciones_generales.php");



    $accion = isset($_GET["accion"])?$_GET["accion"]:"";



    



    function especialistasEliminarProfesional($d) {

	$nConexion = Conectar();

	$sql = "DELETE FROM tblconsultoria_profesionales WHERE idprofesional = {$d}";

	

        $r = mysqli_query($nConexion,$sql);

        if ( !$r ) {

            return "fallo eliminando especialista ".mysqli_error($nConexion);

        }

	return true;

    }

    

    if( $_GET["accion"] == "eliminar" ) {

	$result = especialistasEliminarProfesional($_GET["idprofesional"]);

	if( $result != true ) {

            Mensaje($result,"listar_especialistas.php");

        }

    }

    

    $page = new sistema_paginacion('tblconsultoria_profesionales a,tblconsultoria_profesiones b');

    $page->set_condicion("where 1=1 AND a.idprofesion=b.idprofesion");

    $page->ordenar_por('a.nombre');

    $page->set_limite_pagina(20);

    $rsProfesionales = $page->obtener_consulta();

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

        <td colspan="6" align="center" class="tituloFormulario">

          <center>

          <b>ESPECIALISTAS</b>

          <br>

          <? /*$page->mostrar_numero_pagina()*/ ?><br>

          </center>

        </td>

      </tr>

      <tr>

	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>

	<td bgcolor="#FEF1E2"><b>Nombre</b></td>

	<td bgcolor="#FEF1E2"><b>Correo</b></td>

        <td bgcolor="#FEF1E2"><b>Profesión</b></td>

	<td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>

	<td bgcolor="#FEF1E2" align="center"><b>Eliminar</b></td>

      </tr>

      <?

        $ContFilas		= 0;

        $ColorFilaPar	= "#FFFFFF";

        $ColorFilaImpar	= "#F0F0F0";

        while($row = mysqli_fetch_assoc($rsProfesionales)) {

	    $ContFilas = $ContFilas + 1;

	    if ( fmod( $ContFilas,2 ) == 0 ) {

	      $ColorFila = $ColorFilaPar;

	    }

	    else {

	      $ColorFila = $ColorFilaImpar;

	    }

	    ?>

	    <tr>

		<td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</td>

		<td bgcolor="<? echo $ColorFila; ?>"><?=$row["nombre"];?></td>

		<td bgcolor="<? echo $ColorFila; ?>"><?=$row["correo_electronico"];?></td>

		<td bgcolor="<? echo $ColorFila; ?>"><?=$row["profesion"];?></td>

		<td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="especialistas.php?accion=editar&idprofesional=<?=$row["idprofesional"];?>">&nbsp;<img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo $row["idprofesional"]; ?>"></a></td>

		<td bgcolor="<? echo $ColorFila; ?>"align="center">

		<a href="listar_especialistas.php?accion=eliminar&idprofesional=<?=$row["idprofesional"];?>" onclick="return confirm('¿Seguro que desea eliminar este registro?');">

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

	    <a href="especialistas.php?accion=adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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

