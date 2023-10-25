<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

	include("../../funciones_generales.php");

	include("../../vargenerales.php");

	

  $page=new sistema_paginacion('tbl_registroslogintur ');

	$IdCiudad = $_SESSION["IdCiudad"];

	$cWhereSQL = "WHERE idciudad = " . $IdCiudad;

  $page->set_condicion($cWhereSQL);

  $page->ordenar_por('idlogin');

  $page->set_limite_pagina(20);

  $result_page=$page->obtener_consulta();

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

  <? include("../../system_menu.php"); ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="9" align="center" class="tituloFormulario">

      <center>

        <b>LISTA DE USUARIOS REGISTRADOS</b><br>

        <? $page->mostrar_numero_pagina() ?>

        <br>

    </center></td>

  </tr>

  <tr>

    <td bgcolor="#FEF1E2"><b>Id.</b></td>

    <td bgcolor="#FEF1E2"><b>Nombres</b></td>

    <td bgcolor="#FEF1E2"><b>Apellidos</b></td>

    <td bgcolor="#FEF1E2"><b>Ciudad</b></td>

    <td bgcolor="#FEF1E2"><b>Telefono</b></td>

    <td bgcolor="#FEF1E2"><b>Mail</b></td>

    <td bgcolor="#FEF1E2"><b>Username</b></td>

    <td bgcolor="#FEF1E2"><b>Clave</b></td>

    <td align="center" bgcolor="#FEF1E2"><b>Acci�n</b></td>

  </tr>

  <?

				$ContFilas			= 0;

				$ColorFilaPar		= "#FFFFFF";

				$ColorFilaImpar	= "#F0F0F0";

        while($row=mysqli_fetch_object($result_page))

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

    <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idlogin"; ?></td>

    <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nombres"; ?></td>

    <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->apellidos"; ?></td>

    <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->ciudad"; ?></td>

    <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->telefono"; ?></td>

    <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->mail"; ?></td>

    <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->username"; ?></td>

    <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->clave"; ?></td>			

    <td bgcolor="<? echo $ColorFila; ?>" align="center"><a href="archivos_login_usuareg.php?Accion=Editar&Id=<? echo "$row->idlogin"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->idlogin"; ?>"></a> </td>

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

    <td colspan="9" class="nuevo"> <a href="archivos_login_usuareg.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a> </td>

  </tr>

</table>

<br>

    <br>

    <br><br><br><br>

			<table border="0" width="100%" cellspacing="0" cellpadding="0">

			<tr>

				<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones inform�ticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

			</tr>

			</table>

</body>

</html>