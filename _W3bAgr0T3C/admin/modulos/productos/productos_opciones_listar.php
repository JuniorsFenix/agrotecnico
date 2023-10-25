<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

	include("../../vargenerales.php");

	$IdCiudad = $_SESSION["IdCiudad"];

	$IdPlus		= $_GET["Id"];

	$NomPlus	= $_GET["nom"];

  $page=new sistema_paginacion('tblproductosopciones');

	$page->set_condicion("WHERE (idplus = $IdPlus)");

  $page->ordenar_por('orden');

  $page->set_limite_pagina(20);

  $result_page=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900");

	$Total_Opciones = TotalOpciones( $IdPlus );

?>

<html>

<head><link href="../../css/administrador.css" rel="stylesheet" type="text/css">

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

    ref=menu.cboCategorias.options[menu.cboCategorias.selectedIndex].value;

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

	<title>Opciones de Productos</title>

  <body>

  <? include("../../system_menu.php"); ?><br>

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="5" align="center" class="tituloFormulario">

				<center>

          <b>LISTA DE OPCIONES - <?=strtoupper($NomPlus);?></b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

					</center>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

        <td bgcolor="#FEF1E2"><b>Titulo</b></td>

        <td bgcolor="#FEF1E2"><b>Precio</b></td>

				<td bgcolor="#FEF1E2"><b>Orden</b></td>

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idopcion"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->titulo"; ?></td>

					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$" . number_format($row->precio,2,'.',','); ?></td>

					<td bgcolor="<? echo $ColorFila; ?>">

						<?

						$cImgMover		= "";

						$IdOpcionPlus	= $IdPlus;

						$cNomPlus			= $NomPlus;

						if ( $Total_Opciones == 1 ){ // Solo Existe Un Registro No Imprimo Arriba y Abajo

							$cImgMover = "";

						}else{

							if ( $ContFilas == 1 ){ // Es el primer registro: Solo muestro mover abajo

								$cImgMover = "<a href='productos_opciones.php?Accion=Mover&Donde=Abajo&nIdOpcion=$row->idopcion&nOrdenActual=$row->orden&idplus=$IdOpcionPlus&NomPlus=$cNomPlus' ><img border='0' src='../../image/mnu_abajo.png' alt='Mover abajo'></a>";

							}else{

								if ( $ContFilas == $Total_Opciones ){ // Si es el ultimo solo muestro arriba

									$cImgMover = "<a href='productos_opciones.php?Accion=Mover&Donde=Arriba&nIdOpcion=$row->idopcion&nOrdenActual=$row->orden&idplus=$IdOpcionPlus&NomPlus=$cNomPlus'><img border='0' src='../../image/mnu_arriba.png' alt='Mover arriba'></a>";

								}else{

									$cImgMover = "<a href='productos_opciones.php?Accion=Mover&Donde=Abajo&nIdOpcion=$row->idopcion&nOrdenActual=$row->orden&idplus=$IdOpcionPlus&NomPlus=$cNomPlus'><img border='0' src='../../image/mnu_abajo.png' alt='Mover abajo'></a>&nbsp;&nbsp;&nbsp;<a href='productos_opciones.php?Accion=Mover&Donde=Arriba&nIdOpcion=$row->idopcion&nOrdenActual=$row->orden&idplus=$IdOpcionPlus&NomPlus=$cNomPlus'><img border='0' src='../../image/mnu_arriba.png' alt='Mover arriba'></a>";

								}

							}

						}

						?>

						<? echo "$row->orden"; ?>&nbsp;<?=$cImgMover;?>

					</td>

          <td bgcolor="<? echo $ColorFila; ?>" align="center">

						<a href="productos_opciones.php?Accion=Editar&Id=<? echo "$row->idopcion"; ?>&IdPlus=<?=$_GET["Id"];?>&nomplus=<?=$_GET["nom"];?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->producto"; ?>"></a>

					</td>

        </tr>

        <?

        }

      ?>

      <tr><td colspan="5"><? $page->mostrar_enlaces(); ?></td></tr>

      <tr>

        <td colspan="5">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="5" class="nuevo">

					<a href="productos_opplus_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>&nbsp;

          <a href="productos_opciones.php?Accion=Adicionar&idplus=<?=$IdPlus;?>&nomplus=<?=$NomPlus;?>"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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

function TotalOpciones( $IdPlus ){

	$nConexion    = Conectar();

	$Resultado    = mysqli_query($nConexion, "SELECT COUNT(idopcion) AS total FROM tblproductosopciones WHERE idplus = $IdPlus" ) ;

	mysqli_close( $nConexion ) ;

	$RegTotal = mysqli_fetch_object($Resultado);

	$Total = $RegTotal->total;

	mysqli_free_result($Resultado);

	return $Total;

}

?>