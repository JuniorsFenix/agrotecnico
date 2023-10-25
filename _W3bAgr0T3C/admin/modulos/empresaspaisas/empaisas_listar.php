<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

	include("../../vargenerales.php");

  $page=new sistema_paginacion('tblempresaspaisas');

	$IdCiudad = $_SESSION["IdCiudad"];

  // Si se envio parametro para filtro categorias muestro realizo la condicion

  if (isset ($_GET['categoria'])) // Si no se envio la accion muestro la lista completa

  {

    $page->set_condicion("WHERE (idciudad = $IdCiudad) AND categoria = '" . $_GET['categoria'] . "'");

	}

	else

	{

		$page->set_condicion("WHERE (idciudad = $IdCiudad)");

	}

	

  //$page->set_condicion($cConsulta);

  $page->ordenar_por('idempresapaisa desc');

  $page->set_limite_pagina(20);

  $result_page=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900")

?>



<html>

  <head>

    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">

		<title>Lista de Empresas</title>

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

    ref=menu.Categoria.options[menu.Categoria.selectedIndex].value;

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



  <form action="Cualquiera" method="post">

    <table border="0" width="70%" cellspacing="0" cellpadding="0">

      <tr>

        <td>Buscar Empresa por Categoria:</td>

        <td>

          <select name="Categoria">

            <option selected="true" value="empaisas_listar.php">Sin Filtro</option>

            <?

            $nConexion = Conectar();

            $Resultado = mysqli_query($nConexion, "SELECT * FROM tblcategempaisa ORDER BY nombrecategoria asc" );

            mysqli_close($nConexion);

            while($Registros=mysqli_fetch_object($Resultado))

            {

              ?>

              <option value="<? echo "empaisas_listar.php?categoria=$Registros->nombrecategoria&idciudad=$IdCiudad"; ?>"><? echo $Registros->nombrecategoria ?></option>

              <?

            }

            mysqli_free_result($Resultado);

            ?>

          </select>

          <input TYPE="button" VALUE="Filtrar" onClick="jump(this.form)">

        </td>

      </tr>

    </table>

  </form>

     <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="10" align="center" class="tituloFormulario">

          <b>EMPRESAS PAISAS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

        <td width="4%" bgcolor="#FEF1E2"><b>Id.</b></td>

		<td width="18%" bgcolor="#FEF1E2"><b>Nombre</b></td>

		<td width="12%" bgcolor="#FEF1E2"><b>Sucursal</b></td>

        <td width="12%" bgcolor="#FEF1E2"><b>Categoria</b></td>

		<td width="8%" align="center" bgcolor="#FEF1E2"><b>Minimo</b></td>

		<td width="8%" align="center" bgcolor="#FEF1E2"><b>Maximo</b></td>

		<td width="8%" align="center" bgcolor="#FEF1E2"><b>Telefono</b></td>

        <td width="10%" align="center" bgcolor="#FEF1E2"><b>Mail</b></td>

        <td width="10%" align="center" bgcolor="#FEF1E2"><b>Editar</b></td>				

		<td width="10%" align="center" bgcolor="#FEF1E2"><b>Imagen</b></td>

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idempresapaisa"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->nomempresa"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->sucursal"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->categoria"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>" align="center"><? echo "$row->preciomin"; ?></td>		  

          <td bgcolor="<? echo $ColorFila; ?>" align="center"><? echo "$row->preciomax"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>" align="center"><? echo "$row->telefono"; ?></td>

		  <td bgcolor="<? echo $ColorFila; ?>" align="center"><? echo "$row->email"; ?></td>		  

		  <td bgcolor="<? echo $ColorFila; ?>" align="center"><a href="empaisas.php?Accion=Editar&Id=<? echo "$row->idempresapaisa"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->nomempresa"; ?>"></a></td>

          

					<td bgcolor="<? echo $ColorFila; ?>" align="center">

					<?

					if ( !empty( $row->imagen ) )

					{

					  ?><a target="_blank" href="<? echo $cRutaImgEmpaisas . $row->imagen; ?>">Ver</a><?

					}

					else

					{

						echo "No Asignada";

					}

					?>

					</td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="10"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="10">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="10" class="nuevo">

          <a href="empaisas.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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