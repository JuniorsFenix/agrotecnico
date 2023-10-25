<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

	include("../../vargenerales.php");

	$IdCiudad = $_SESSION["IdCiudad"];

  $page=new sistema_paginacion('tbl_fotostur2');

	$page->set_condicion( "");

  // Si se envio parametro para filtro categorias muestro realizo la condicion

  if (isset ($_GET["IdLogin"])) // Si no se envio la accion muestro la lista completa

  {

    $page->set_condicion("WHERE idlogin = " . $_GET["IdLogin"]);

  }

  $page->ordenar_por('idfotos');

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

		

		<title>Lista de Archivos</title>

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

    ref=menu.cboIdlogin.options[menu.cboIdlogin.selectedIndex].value;

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

  <? include("../../system_menu.php");?><br>

  <form action="archivos_usuareg_listar.php" method="post">

    <table border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td>Filtrar por Usuario:</td>

        <td>

          <select name="cboIdlogin">

            <option selected="true" value="archivos_usuareg_listar.php">Sin Filtro</option>

            <?

            $nConexion = Conectar();

            $Resultado = mysqli_query($nConexion, "SELECT * FROM tbl_registroslogintur WHERE idciudad = $IdCiudad AND permitido = 'Si' ORDER BY idlogin" );

            mysqli_close($nConexion);

            while($Registros=mysqli_fetch_object($Resultado))

            {

              ?>

              <option value="<? echo "archivos_usuareg_listar.php?IdLogin=$Registros->idlogin"; ?>"><? echo $Registros->idlogin . "&nbsp;" . $Registros->nombres . "&nbsp;" . $Registros->apellidos; ?></option>

              <?

            }

            mysqli_free_result($Resultado);

            ?>

          </select>

          <input TYPE="button" VALUE="Ver" onClick="jump(this.form)">

        </td>

      </tr>

    </table>

  </form>





    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="5" align="center" class="tituloFormulario">

				<center>

          <b>LISTA DE ARCHIVOS USUARIOS REGISTRADOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

<br>

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

					echo "<select name=\"cboCiudades\" id=\"cboCiudades\" onChange=\"jump2(this.form)\">\n";

					if ( $Parametro == "0" ){

						echo "<option value=\"archivos_listar.php?ciudad=0\" selected>Seleccione Ciudad</option>\n";	

					}

					else{

						echo "<option value=\"archivos_listar.php?ciudad=0\">Seleccione Ciudad</option>\n";	

					}

					while ( $regCiudades = mysqli_fetch_object($rsCiudades) ){

						if ( $Parametro == $regCiudades->idciudad ){

							echo "<option selected value=archivos_listar.php?ciudad=".$regCiudades->idciudad.">$regCiudades->ciudad</option>\n";

						}

						else{

							echo "<option value=archivos_listar.php?ciudad=".$regCiudades->idciudad.">$regCiudades->ciudad</option>\n";

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

        <td bgcolor="#FEF1E2"><b>Foto</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>				

		<td bgcolor="#FEF1E2"><b>Creado por</b></td>

        <td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idfotos"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->foto1"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fecha"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->creadopor"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>" align="center"><a href="archivos_usuareg.php?Accion=Editar&Id=<? echo "$row->idfotos"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->idfotos"; ?>"></a></td>

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

          <a href="archivos_usuareg.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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

<?

/*function NomCategoria( $nCategoria )

{

	$nConexion = Conectar();

	$RegNomCategoria = mysqli_fetch_object( mysqli_query($nConexion, "SELECT categoria FROM tblcategoriasarchivos WHERE idcategoria = $nCategoria" ) );

	mysqli_close($nConexion)	;

	return $RegNomCategoria->categoria;

}*/

?>