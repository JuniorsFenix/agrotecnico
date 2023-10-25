<?php
include("../../funciones_generales.php");
include("../../herramientas/seguridad/seguridad.php");
include("../../vargenerales.php");
$nConexion    = Conectar();

$idciudad = $_GET["idciudad"];
$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblsitio where idciudad = " . $idciudad ) ;
if ( !mysqli_num_rows($Resultado) ){
	$EsNuevo = "S";
}else{
	$EsNuevo = "N";
}
	$rsPlantillas	= mysqli_query($nConexion,"SELECT * FROM plantillas");

if ( isset( $_GET["PostBack"] ) ){
		$_POST["txtNombre"] = str_replace("\n", "", $_POST["txtNombre"]);
		$_POST["txtNombre"] = str_replace("\r", "", $_POST["txtNombre"]);
		$url = $_POST["url"];
	
	if ($EsNuevo == "N"){
		mysqli_query($nConexion, "UPDATE tblsitio SET titulo = '$_POST[txtTitulo]', descripcion = '$_POST[txtDescripcion]', palabras_clave = '$_POST[txtPalabrasClave]', logo = '$_POST[logo]', nombre = '$_POST[txtNombre]', creditos = '$_POST[txtCreditos]', google = '$_POST[txtGoogle]', idfacebook = '$_POST[txtFacebook]', analytics = '$_POST[txtAnalytics]', idplantilla = '$_POST[plantilla]', url = '$url' WHERE idciudad = " . $idciudad );
		mysqli_query($nConexion, "UPDATE wp_options SET option_value = '{$url}/sadminc/modulos/matriz' WHERE option_name = 'siteurl' or option_name = 'home'" );
		$content = "# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase {$url}/sadminc/modulos/matriz/
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . {$url}/sadminc/modulos/matriz/index.php [L]
</IfModule>

# END WordPress";
		$fp = fopen("../matriz/.htaccess","wb");
		fwrite($fp,$content);
		fclose($fp);
	}else{
		mysqli_query($nConexion,"INSERT INTO tblsitio (titulo,descripcion,palabras_clave,idciudad,logo,nombre,creditos,google,idfacebook,analytics,idplantilla) VALUES ('$_POST[txtTitulo]','$_POST[txtDescripcion]','$_POST[txtPalabrasClave]',$idciudad,'$_POST[logo]','$_POST[txtNombre]','$_POST[txtCreditos]','$_POST[txtGoogle]','$_POST[txtFacebook]','$_POST[txtAnalytics]','$_POST[plantilla]')");			
	}
	mysqli_close( $nConexion ) ;
	?><script>document.location.href='../idiomas/idiomas_listar.php'</script><?
}
$Registro     = mysqli_fetch_array( $Resultado );
?>
<html>
	<head>
		<title>Información Empresa - Carrito de Compras</title>
		<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<link href="../../herramientas/seocounter.css" rel="stylesheet" type="text/css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="../../herramientas/ckeditor/ckeditor.js"></script>
		<script src="../../herramientas/seocounter.js"></script>
		<script type="text/javascript"> 
		$(document).ready(function(){
			seocounter();
		}); 
		</script>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
<body>
<?php include("../../system_menu.php"); ?><br>
    <!-- Formulario Edición / Eliminación de Productos -->
    <form method="post" action="sitio.php?PostBack=S&idciudad=<?=$idciudad;?>" enctype="multipart/form-data">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>INFORMACION GENERAL DEL SITIO WEB</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><input name="txtTitulo" class="seocounter_title" maxLength="200" style="width: 823px; height: 22px" value="<?php echo $Registro["titulo"]; ?>"></input></tr>
        <tr>
          <td class="tituloNombres">Descripción:</td>
          <td class="contenidoNombres"><textarea name="txtDescripcion" class="seocounter_meta" cols="100" rows="10"><? echo $Registro["descripcion"]; ?></textarea></td>
        </tr>
        <tr>
          <td class="tituloNombres">Logo:</td>
          <td class="contenidoNombres">
            <textarea name="logo"><?php echo $Registro["logo"]; ?></textarea>
            <script>
            CKEDITOR.replace( 'logo' );
            </script>
          </td>
        </tr>
        <tr>
            <td class="tituloNombres">Mapa (iframe):</td>
            <td class="contenidoNombres">
                <textarea name="txtNombre"><?php echo $Registro["nombre"];?></textarea>
                <script>
                    CKEDITOR.replace( 'txtNombre' );
                </script>
            </td>
        </tr>
        <tr>
            <td class="tituloNombres">Créditos:</td>
            <td class="contenidoNombres">
                            <textarea name="txtCreditos"><?php echo $Registro["creditos"];?></textarea>
                            <script>
                                CKEDITOR.replace( 'txtCreditos' );
            					CKEDITOR.config.contentsCss = '../matriz/wp-content/themes/aside/styles/bootstrap.css' ;
                            </script>
            </td>
        </tr>
			<tr>
				<td class="tituloNombres">Código verificación Google:</td>
				<td class="contenidoNombres">
                	<textarea name="txtGoogle" cols="90"><?php echo $Registro["google"];?></textarea>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">ID Facebook:</td>
				<td class="contenidoNombres">
                	<textarea name="txtFacebook" cols="90"><?php echo $Registro["idfacebook"];?></textarea>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Google Analytics:</td>
				<td class="contenidoNombres">
                	<input type="text" size="34" name="txtAnalytics" id="txtAnalytics" value="<?php echo $Registro["analytics"];?>" />
                </td>
			</tr>
        <tr>
            <td class="tituloNombres">Plantilla:</td>
            <td class="contenidoNombres">
				<select name="plantilla">
				<?php while ( $plantilla = mysqli_fetch_assoc( $rsPlantillas ) ){ ?>
					<option value="<?php echo $plantilla["idplantilla"];?>" <?=$plantilla["idplantilla"]==$Registro["idplantilla"]?"selected":"";?> ><?php echo $plantilla["nombre"];?></option>
				<? } ?>
				</select>
            </td>
        </tr>
        <tr>
          <td class="tituloNombres">Url del sitio:</td>
          <td class="contenidoNombres"><input name="url" value="<? echo $Registro["url"]; ?>"></td>
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
<?php
  mysqli_free_result( $Resultado );
?>


</body>
</html>