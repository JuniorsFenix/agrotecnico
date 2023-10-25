<?

	include("../../funciones_generales.php");

  include("../../herramientas/seguridad/seguridad.php");

?>

<html>

  <head>

    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">

		<link rel="stylesheet" type="text/css" media="all" href="../../herramientas/jscalendar/skins/aqua/theme.css" title="Aqua" />

		<script type="text/javascript" src="../../herramientas/jscalendar/calendar.js"></script>

		<script type="text/javascript" src="../../herramientas/jscalendar/lang/calendar-es.js"></script>

		<script type="text/javascript" src="../../herramientas/jscalendar/calendar-setup.js"></script>

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

    ref=menu.cboFiltro.options[menu.cboFiltro.selectedIndex].value;

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

		<form action="log_listar.php" method="get">

		<table border="0" cellpadding="0" cellspacing="5" align="center">

			<tr>

				<td>Filtrar Lista:</td>

				<td>

					<select name="cboFiltro" id="cboFiltro" onChange="jump(this.form)">

						<option value="log_buscar.php" <? if ( $_GET["filtro"] == 0 ) echo "selected" ;?> >Seleccionar Filtro</option>

						<option value="log_buscar.php?filtro=1" <? if ( $_GET["filtro"] == 1 ) echo "selected" ;?>>Modulo</option>

						<option value="log_buscar.php?filtro=2" <? if ( $_GET["filtro"] == 2 ) echo "selected" ;?>>Fecha</option>

					</select>

				</td>

			</tr>

			<?

			if ( $_GET["filtro"] == 1 )

			{

			?>

			<tr>

				<td>Modulo:</td>

				<td>

				<?

					$nConexion = Conectar();

					$rsModulos = mysqli_query($nConexion,"SELECT DISTINCT modulo FROM tbllog ORDER BY modulo");

					mysqli_close($nConexion);

					?><select name="cboModulo" id="cboModulo"><?

					while($row=mysqli_fetch_object($rsModulos))

					{

						echo "<option value='$row->modulo'>$row->modulo</option>";

					}

					

				?>

					</select>

				</td>

			</tr>

			<tr>

				<td>Ordenar por:</td>

				<td>

					<select name="cboOrdenar" id="cboOrdenar">

						<option value="modulo">MODULO</option>

						<option value="accion">ACCION</option>

						<option value="usuario">USUARIO</option>

						<option value="fecha_hora">FECHA</option>

					</select>

					<select name="cboOrdenarTipo" id="cboOrdenarTipo">

						<option value="ASC">ASCENDENTE</option>

						<option value="DESC">DESCENDENTE</option>

					</select>

					

				</td>

			</tr>

			<tr><td colspan="2" align="center">&nbsp;</td></tr>

			<tr><td colspan="2" align="center"><input type="image" name="cmdEnviar" src="../../image/consultar.gif"><!--<input type="submit" name="cmdEnviar" value="Consultar">--></td></tr>



			<?

			}

			?>

			

			<?

			if ( $_GET["filtro"] == 2 )

			{

			?>

			<tr>

				<td>Fecha:</td>

				<td><input type="text" name="date" id="f_date_b" readonly="yes" /> <input type="image" src="../../image/calendario16x16.png" id="f_trigger_b"> <!-- <input type="reset" id="f_trigger_b" value="..."/>--></td>

			</tr>

			<tr>

				<td>Ordenar por:</td>

				<td>

					<select name="cboOrdenar" id="cboOrdenar">

						<option value="modulo">MODULO</option>

						<option value="accion">ACCION</option>

						<option value="usuario">USUARIO</option>

						<option value="fecha_hora">FECHA</option>

					</select>

					<select name="cboOrdenarTipo" id="cboOrdenarTipo">

						<option value="ASC">ASCENDENTE</option>

						<option value="DESC">DESCENDENTE</option>

					</select>

					

				</td>

			</tr>

			<tr><td colspan="2" align="center">&nbsp;</td></tr>

			<tr><td colspan="2" align="center"><input type="image" name="cmdEnviar" src="../../image/consultar.gif">  <!--<input type="submit" name="cmdEnviar" value="Consultar">--></td></tr>



			<script type="text/javascript">

					Calendar.setup({

							inputField     :    "f_date_b",      // id of the input field

							ifFormat       :    "%Y-%m-%d",       // format of the input field

							showsTime      :    true,            // will display a time selector

							button         :    "f_trigger_b",   // trigger for the calendar (button ID)

							singleClick    :    false,           // double-click mode

							step           :    1                // show all years in drop-down boxes (instead of every other year as default)

					});

			</script>

			<?

			}

			?>

			

			

		</table>

		</form>

			<br><br><br><br><br>

			<table border="0" width="100%" cellspacing="0" cellpadding="0">

			<tr>

				<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

			</tr>

			</table>

      

  	</body>

</html>