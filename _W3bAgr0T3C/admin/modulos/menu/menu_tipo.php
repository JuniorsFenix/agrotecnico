<?
  include("seguridad.php");
	include("menu_funciones.php");
	$rs_ListaContenidos = ListaContenidos();
	$rs_ListaProductos	= ListaProductos();
	$rs_ListaServicios	= ListaServicios();
?>
<html>
  <head>
    <link href="administrador.css" rel="stylesheet" type="text/css">
<script language="javascript">
function VerPanel(Panel)
{
	switch ( Panel )
	{
		case 1: //Contenidos
		document.getElementById('DivContenidos').style.visibility="visible";
		document.getElementById('DivProductos').style.visibility="hidden";		
		document.getElementById('DivServicios').style.visibility="hidden";		
		document.getElementById('DivUrl').style.visibility="hidden";		
		break;
		case 2: //Productos
		document.getElementById('DivProductos').style.visibility="visible";		
		document.getElementById('DivContenidos').style.visibility="hidden";
		document.getElementById('DivServicios').style.visibility="hidden";		
		document.getElementById('DivUrl').style.visibility="hidden";		
		break;
		case 3: //Servicios
		document.getElementById('DivServicios').style.visibility="visible";		
		document.getElementById('DivContenidos').style.visibility="hidden";
		document.getElementById('DivProductos').style.visibility="hidden";		
		document.getElementById('DivUrl').style.visibility="hidden";		
		break;
		case 4: // URL
		document.getElementById('DivUrl').style.visibility="visible";		
		document.getElementById('DivContenidos').style.visibility="hidden";
		document.getElementById('DivProductos').style.visibility="hidden";		
		document.getElementById('DivServicios').style.visibility="hidden";		
		break;
	}
}
</script>


  </head>
  <body>
<form name="form1" method="post" action="">
  <table width="50%" align="center">
		<tr>
			<td colspan="4" align="center">Modulo:</td>
		</tr>
    <tr>
      <td><label><input onClick="VerPanel(1)" type="radio" name="opModulo" value="Contenido">Contenido</label></td>
      <td><label><input onClick="VerPanel(2)" type="radio" name="opModulo" value="Productos">Productos</label></td>
      <td><label><input onClick="VerPanel(3)" type="radio" name="opModulo" value="Servicios">Servicios</label></td>
      <td><label><input onClick="VerPanel(4)" type="radio" name="opModulo" value="Url">Url</label></td>
    </tr>
  </table>
	<br/><br/>
	<div id="DivContenidos" style="visibility:hidden; position:absolute">
	<table border="0" cellpadding="0" cellspacing="0">
		<tr><td><strong>Seleccione Contenido:</strong></td></tr>
		<tr>
			<td>
				<select name="lstContenidos" size="10" style="width:200px;">
				<?
					$Contador = 0;
					while($row=mysqli_fetch_object($rs_ListaContenidos))
					{
						$Contador = $Contador + 1;
						if ( $Contador == 1 )
						{
							echo "<option selected title='$row->titulo' value='contenido.php?clave=$row->clave'>$row->titulo</option>\n";
						}
						else
						{
							echo "<option title='$row->titulo' value='contenido.php?clave=$row->clave'>$row->titulo</option>\n";
						}
						
					}
				?>
				</select>
			</td>
		</tr>
	</table>
	</div>

	<div id="DivProductos" style="visibility:hidden; position:absolute">
	<table border="0" cellpadding="0" cellspacing="0">
		<tr><td><strong>Seleccione Producto:</strong></td></tr>
		<tr>
			<td>
				<select name="lstProductos" size="10" style="width:200px;">
				<?
					$Contador = 0;
					while($row=mysqli_fetch_object($rs_ListaProductos))
					{
						$Contador = $Contador + 1;
						if ( $Contador == 1 )
						{
							echo "<option selected title='$row->producto' value='productosver.php?producto=$row->idproducto'>$row->producto</option>\n";
						}
						else
						{
							echo "<option title='$row->producto' value='productosver.php?producto=$row->idproducto'>$row->producto</option>\n";
						}
						
					}
				?>
				</select>
			</td>
		</tr>
	</table>
	</div>
	
	<div id="DivServicios" style="visibility:hidden; position:absolute">
	<table border="0" cellpadding="0" cellspacing="0">
		<tr><td><strong>Seleccione Servicio:</strong></td></tr>
		<tr>
			<td>
				<select name="lstServicios" size="10" style="width:200px;">
				<?
					$Contador = 0;
					while($row=mysqli_fetch_object($rs_ListaServicios))
					{
						$Contador = $Contador + 1;
						if ( $Contador == 1 )
						{
							echo "<option selected title='$row->servicio' value='serviciosver.php?servicio=$row->idservicio'>$row->servicio</option>\n";
						}
						else
						{
							echo "<option title='$row->servicio' value='serviciosver.php?servicio=$row->idservicio'>$row->servicio</option>\n";
						}
						
					}
				?>
				</select>
			</td>
		</tr>
	</table>
	</div>

	<div id="DivUrl" style="visibility:hidden; position:absolute">
	<table border="0" cellpadding="0" cellspacing="0">
		<tr><td><strong>Escriba la URL:</strong></td></tr>
		<tr>
			<td><input type="text" name="txtUrl" id="txtUrl" maxlength="200" style="width:300px;"></td>
		</tr>
	</table>
	</div>
</form>
</body>
</html>
