<?
	include("../../funciones_generales.php");
  include("../../herramientas/seguridad/seguridad.php");
  include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
	
  $nConexion    = Conectar();
	
	if ( isset( $_GET["PostBack"] ) )
	{
		$ArchivoImg = $_FILES['txtImagen']['name'][0];
		$NomImagen = "*"; // * Indica que no se asigno un archivo

        if ( !empty($ArchivoImg) )
        {
					$tipos = array("image/jpeg","image/gif","image/pjpeg","application/x-shockwave-flash");
					$size = 400000;
					$Campofile = "txtImagen";
					$folder = $cRutaLogoCarrito ;
					if(uploader($Campofile,$folder,$size,$tipos))
					{
						foreach ($uploader_archivos_copiados as $imagen => $detalles)
						{
							$NomImagen = $imagen ;
						}
					}
        }
	
				if ( $NomImagen == "*" )
				{
					$NomImagen = "";
				}
		
		$Empresa		= $_POST["txtEmpresa"];
		$Logo				= $NomImagen;
		$Direccion	= $_POST["txtDireccion"];
		$Telefonos	= $_POST["txtTelefonos"];
		$Fax				= $_POST["txtFax"];
		$Mail				= $_POST["txtMail"];
		if ( empty($Logo) )
		{
			mysqli_query($nConexion, "UPDATE tbl_cart_empresa SET empresa = '$Empresa', direccion = '$Direccion', telefonos = '$Telefonos', fax = '$Fax', mail = '$Mail'" );
		}
		else
		{
			mysqli_query($nConexion, "UPDATE tbl_cart_empresa SET empresa = '$Empresa', direccion = '$Direccion', telefonos = '$Telefonos', fax = '$Fax', mail = '$Mail', logo = '$Logo'" );
		}
		
	}
	
  $Resultado    = mysqli_query($nConexion, "SELECT * FROM tbl_cart_empresa LIMIT 1" ) ;
  mysqli_close( $nConexion ) ;
  $Registro     = mysqli_fetch_object ( $Resultado );

?>
<html>
	<head>
		<title>Informaci�n Empresa - Carrito de Compras</title>
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
    <!-- Formulario Edici�n / Eliminaci�n de Productos -->
    <form method="post" action="car_empresa.php?PostBack=S" enctype="multipart/form-data">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>DATOS EMPRESA </b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombre / Raz&oacute;n Social :</td>
          <td class="contenidoNombres"><INPUT id="txtEmpresa" type="text" name="txtEmpresa" value="<? echo $Registro->empresa; ?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Direcci&oacute;n:</td>
          <td class="contenidoNombres"><INPUT id="txtDireccion" type="text" value="<? echo $Registro->direccion; ?>" name="txtDireccion" maxLength="200" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Telefonos:</td>
          <td class="contenidoNombres"><input type="text" name="txtTelefonos" value="<? echo $Registro->telefonos; ?>" maxlength="200" style="WIDTH: 300px; HEIGHT: 22px"> </td>
        </tr>
        <tr>
          <td class="tituloNombres">Fax:</td>
          <td class="contenidoNombres"><input type="text" name="txtFax" maxlength="200" value="<? echo $Registro->fax; ?>" style="WIDTH: 300px; HEIGHT: 22px"> </td>
        </tr>
        <tr>
          <td class="tituloNombres">Email:</td>
          <td class="contenidoNombres"><input type="text" name="txtMail" maxlength="200" value="<? echo $Registro->mail; ?>" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Logo:</td>
          <td class="contenidoNombres">
          <?
            if ( empty($Registro->logo) )
            {
              echo "No se asigno una imagen." . "<br>";
            }
            else
            {
              ?><img src="<? echo $cRutaVerLogoCarrito . $Registro->logo; ?>"><br><?
            }
          ?>
						<input type="file" id="txtImagen[]" name="txtImagen[]">
					</td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
?>


</body>
</html>