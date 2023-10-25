<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

	include("../../funciones_generales.php");

	include("../../vargenerales.php");

	

  $page=new sistema_paginacion('tblcategoriasarchivos');

	$IdCiudad			= $_SESSION["IdCiudad"];

	$cWhereSQL = "WHERE idciudad = " . $IdCiudad;

  $page->set_condicion($cWhereSQL);

  $page->ordenar_por('idcategoria');

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

<script>

<!--

function land(ref, target)

{

lowtarget=target.toLowerCase();

if (lowtarget=="_self") {window.location=loc;}

else {if (lowtarget=="_top") {top.location=loc;}

else {if (lowtarget=="_blank") {window.open(loc);}

else {if (lowtarget=="_parent") {parent.location=loc;}

else {parent.frames[target].location=loc;};

}}}

}

function jump(menu)

{

ref=menu.cboCiudades.options[menu.cboCiudades.selectedIndex].value;

splitc=ref.lastIndexOf("*");

target="";

if (splitc!=-1)

{loc=ref.substring(0,splitc);

target=ref.substring(splitc+1,1000);}

else {loc=ref; target="_self";};

if (ref != "") {land(loc,target);}

}

//-->

</script>

  </head>

  <body>

  <? include("../../system_menu.php"); ?><br>

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="3" align="center" class="tituloFormulario">

					<center><b>LISTA DE CATEGOR�AS/SUB-CATEGOR�AS<br>MODULO ARCHIVOS</b><br><? $page->mostrar_numero_pagina() ?><br>

					<!--Filtro:<br>-->

					<?

					/*

					$nConexion 	= Conectar();

					$rsCiudades	= mysqli_query($nConexion,"SELECT * FROM tblciudades WHERE publicar = 'S' ORDER BY ciudad");

					if ( !isset( $_GET["ciudad"] ) ){

						$Parametro = "0";

					}

					else{

						$Parametro = $_GET["ciudad"];

					}

					echo "<form action=\"dummy\" method=\"get\">";

					echo "<select name=\"cboCiudades\" id=\"cboCiudades\" onChange=\"jump(this.form)\">\n";

					if ( $Parametro == "0" ){

						echo "<option value=\"archivos_categorias_listar.php?ciudad=0\" selected>Seleccione Ciudad</option>\n";	

					}

					else{

						echo "<option value=\"archivos_categorias_listar.php?ciudad=0\">Seleccione Ciudad</option>\n";	

					}

					while ( $regCiudades = mysqli_fetch_object($rsCiudades) ){

						if ( $Parametro == $regCiudades->idciudad ){

							echo "<option selected value=archivos_categorias_listar.php?ciudad=".$regCiudades->idciudad.">$regCiudades->ciudad</option>\n";

						}

						else{

							echo "<option value=archivos_categorias_listar.php?ciudad=".$regCiudades->idciudad.">$regCiudades->ciudad</option>\n";

						}

					}

					echo "</select>\n";

					echo "</form>";

					*/

					?>

					</center>

				</td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

        <td bgcolor="#FEF1E2"><b>Categor�as</b></td>

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idcategoria"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->categoria"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>" align="center">

						<a href="archivos_categorias.php?Accion=Editar&Id=<? echo "$row->idcategoria"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->categoria"; ?>"></a>&nbsp;

						<a href="archivos_categorias.php?Accion=Adicionar&IdPadre=<? echo "$row->idcategoria"; ?>&NomPadre=<? echo "$row->categoria"; ?>&IdCiudad=<?=$IdCiudad?>"><img src="../../image/nuevasubcat.gif" border="0" alt="Adicionar Sub-Categor�a"></a>&nbsp;

					</td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="3"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="3">&nbsp;</td>

      </tr>

			

      <tr>

        <td colspan="3" class="nuevo">

          <a href="archivos_categorias.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

        </td>

      </tr>

			</table>

			<br><br><br><br><br>

			<table border="0" width="100%" cellspacing="0" cellpadding="0">

			<tr>

				<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones inform�ticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

			</tr>

			</table>

  	</body>

</html>









