<?

	include("../../herramientas/seguridad/seguridad.php");

	include("../../herramientas/paginar/class.paginaZ.php");

	include("../../funciones_generales.php");

	include("../../vargenerales.php");

	$page=new sistema_paginacion('tblboletines_blo');

	$page->set_condicion("WHERE idboletin = " . $_GET["idboletin"]);

	$page->ordenar_por('orden');

	$page->set_limite_pagina(10);

	$result_page=$page->obtener_consulta();

	$page->set_color_tabla("#FEF1E2");

	$page->set_color_texto("black");

	$page->set_color_enlaces("black","#FF9900");

	$Total_Bloques = TotalBloques( $_GET["idboletin"] );

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

          <b>BLOQUES - BOLETIN:<?=$_GET["boletin"];?></b>

          <br>

          <? $page->mostrar_numero_pagina() ?>

					</center>

        </td>

      </tr>

      <tr>

				<td bgcolor="#FEF1E2"><b>Id</b></td>

        <td bgcolor="#FEF1E2"><b>Boletin</b></td>

        <td bgcolor="#FEF1E2"><b>Titulo</b></td>

		<td bgcolor="#FEF1E2"><b>Orden</b></td>                        <td bgcolor="#FEF1E2"><b>Orientaci�n</b></td>

        <td bgcolor="#FEF1E2" align="center"><b>Acci�n</b></td>

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

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idbloque"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><?=$_GET["boletin"]; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->titulo"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>">

						<?

						$cImgMover = "";

						$IdBoletin = $_GET["idboletin"];

						$cBoletin  = $_GET["boletin"];

						if ( $Total_Bloques == 1 ){ // Solo Existe Un Registro No Imprimo Arriba y Abajo

							$cImgMover = "";

						}else{

							if ( $ContFilas == 1 ){ // Es el primer registro: Solo muestro mover abajo

								$cImgMover = "<a href='bloques.php?Accion=Mover&Donde=Abajo&nIdBloque=$row->idbloque&nOrdenActual=$row->orden&idboletin=$IdBoletin&boletin=$cBoletin' ><img border='0' src='../../image/mnu_abajo.png' alt='Mover abajo'></a>";

							}else{

								if ( $ContFilas == $Total_Bloques ){ // Si es el ultimo solo muestro arriba

									$cImgMover = "<a href='bloques.php?Accion=Mover&Donde=Arriba&nIdBloque=$row->idbloque&nOrdenActual=$row->orden&idboletin=$IdBoletin&boletin=$cBoletin'><img border='0' src='../../image/mnu_arriba.png' alt='Mover arriba'></a>";

								}else{

									$cImgMover = "<a href='bloques.php?Accion=Mover&Donde=Abajo&nIdBloque=$row->idbloque&nOrdenActual=$row->orden&idboletin=$IdBoletin&boletin=$cBoletin'><img border='0' src='../../image/mnu_abajo.png' alt='Mover abajo'></a>&nbsp;&nbsp;&nbsp;<a href='bloques.php?Accion=Mover&Donde=Arriba&nIdBloque=$row->idbloque&nOrdenActual=$row->orden&idboletin=$IdBoletin&boletin=$cBoletin'><img border='0' src='../../image/mnu_arriba.png' alt='Mover arriba'></a>";

								}

							}

						}

						?>

						<? echo "$row->orden"; ?>&nbsp;<?=$cImgMover;?>

					</td>                    <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->orientacion"; ?></td>

                    <td bgcolor="<? echo $ColorFila; ?>" align="center">

                        <a href="bloques.php?Accion=Editar&Id=<? echo "$row->idbloque"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->titulo"; ?>"></a>

                    </td>

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

				<a href="bloques.php?Accion=Adicionar&idboletin=<?=$_GET["idboletin"];?>&boletin=<?=$_GET["boletin"];?>"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>&nbsp;

				<a href="boletines_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>

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

<?

	function TotalBloques( $IdBoletin )

	{

    $nConexion    = Conectar();

    $Resultado    = mysqli_query($nConexion, "SELECT COUNT(idbloque) AS total FROM tblboletines_blo WHERE idboletin = $IdBoletin" ) ;

    mysqli_close( $nConexion ) ;

		$RegTotal = mysqli_fetch_object($Resultado);

		$Total = $RegTotal->total;

		mysqli_free_result($Resultado);

		return $Total;

	}



?>