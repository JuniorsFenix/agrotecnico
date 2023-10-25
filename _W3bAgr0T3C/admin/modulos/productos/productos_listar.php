<?

	include("../../herramientas/seguridad/seguridad.php");

	include("../../herramientas/paginar/class.paginaZ.php");

	include("../../funciones_generales.php");

	include("../../vargenerales.php");

	$IdCiudad = $_SESSION["IdCiudad"];

	$page=new sistema_paginacion('tblproductos');

	

	// Si se envio parametro para filtro categorias muestro realizo la condicion

	if (isset ($_GET["IdCat"])) // Si no se envio la accion muestro la lista completa

	{

	$page->set_condicion("WHERE (idciudad = $IdCiudad) AND idcategoria = " . $_GET["IdCat"]);

	}

	else

	{

	$page->set_condicion("WHERE (idciudad = $IdCiudad)");

	}

	$page->ordenar_por('producto');

	$page->set_limite_pagina(20);

	$result_page=$page->obtener_consulta();

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

</style>		<title>Lista de Glosario</title>

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

  <body>

  <? include("../../system_menu.php"); ?><br>

  <form action="Cualquiera" method="post">

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td>Filtrar por Alfabeto:</td>

        <td>

          <select name="cboCategorias">

            <option selected="true" value="productos_listar.php">Sin Filtro</option>

            <?

            $nConexion = Conectar();

            $Resultado = mysqli_query($nConexion, "SELECT * FROM tblcategoriasproductos WHERE idciudad = $IdCiudad ORDER BY idcategoria" );

            mysqli_close($nConexion);

            while($Registros=mysqli_fetch_object($Resultado))

            {

							if ( $Registros->idcategoria == $_GET["IdCat"]  ){

								?><option selected value="<? echo "productos_listar.php?IdCat=$Registros->idcategoria"; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria; ?></option><?

							}else{

								?><option value="<? echo "productos_listar.php?IdCat=$Registros->idcategoria"; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria; ?></option><?

							}

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

        <td colspan="7" align="center" class="tituloFormulario">

          <b>LISTA DE GLOSARIO</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id.</b></td>

        <td bgcolor="#FEF1E2"><b>Glosario</b></td>

        <td bgcolor="#FEF1E2"><b>Precio</b></td>				

				<td bgcolor="#FEF1E2"><b>Publicado</b></td>

				<td bgcolor="#FEF1E2"><b>Carrito</b></td>

        <td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>

        <td align="center" bgcolor="#FEF1E2"><b>Imagen</b></td>

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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idproducto"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->producto"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->precio"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->publicar"; ?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->activar_carrito"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>" align="center"><a href="productos.php?Accion=Editar&Id=<? echo "$row->idproducto"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->producto"; ?>"></a></td>

          <td bgcolor="<? echo $ColorFila; ?>" align="center">

            <?

              if ( !empty($row->imagen) )

              {

                ?><a target="_blank" href="<? echo $cRutaVerImgProductos . $row->imagen ; ?>">Ver</a><?

              }

              else

              {

                echo "No Asignada" ;

              }

              

            ?>

          

          </td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="7"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="7">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="7" class="nuevo">

          <a href="productos.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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









