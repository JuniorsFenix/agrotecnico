<?php
	include("../../funciones_generales.php");
	$sitioCfg = sitioAssoc2();
	$home = $sitioCfg["url"];
	include("../../herramientas/seguridad/seguridad.php");
	include("../../vargenerales.php");

	$nConexion    = Conectar();

	if(!empty($_POST))
	{
		include("../../herramientas/upload/SimpleImage.php");
		
    	$sql = "UPDATE tblmatriz SET titulo='{$_POST["titulo"]}' WHERE id={$_POST["id"]}";
    	mysqli_query($nConexion,$sql);
	
		$sql = mysqli_query($nConexion,"SELECT tabla, idcategoria FROM tblmatriz WHERE id={$_POST["id"]}" );
		$Registro = mysqli_fetch_array($sql);
		
		if(!empty($_FILES["imagen"]["tmp_name"]))
		{
			$NomImagenG = $_FILES["imagen"]["name"];
			$NomImagenM = "m_".$NomImagenG;
			$NomImagenP = "p_".$NomImagenG;
			$image = new SimpleImage();
			$image->load($_FILES["imagen"]["tmp_name"]);
			$image->resizeToWidth(1920);
			$image->save($cRutaImgGeneral.$Registro["tabla"]."/".$NomImagenG);
			$image->resizeToWidth(600);
			$image->save($cRutaImgGeneral.$Registro["tabla"]."/".$NomImagenM);
			$image->resizeToWidth(200);
			$image->save($cRutaImgGeneral.$Registro["tabla"]."/".$NomImagenP);
			$sql="UPDATE tblmatriz SET imagen='$NomImagenG' WHERE id={$_POST["id"]}";
			mysqli_query($nConexion,$sql);
		}
      	Mensaje("El registro ha sido actualizado correctamente.", "modulos_categorias_listar.php?modulo={$Registro["idcategoria"]}");
		exit;
	}
?>
<html>
	<head>
		<title>Administración de Imágenes</title>
		<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
<body>
<?php include("../../system_menu.php"); ?><br>
	
<?php
    
	mysqli_set_charset($nConexion,'utf8');
  	$nId = $_GET["id"];
	
	$sql = mysqli_query($nConexion,"SELECT * FROM tblmatriz WHERE id=$nId" );
	$Registro = mysqli_fetch_array($sql);
    
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" enctype="multipart/form-data">
      <input TYPE="hidden" name="id" value="<?php echo $Registro["id"];?>">
      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>Editar categoría: <?php echo $Registro["titulo"];?></b></td>
        </tr>
		<tr>
		  <td class="tituloNombres">Nombre:</td>
		  <td class="contenidoNombres"><input type="text" value="<?php echo $Registro["titulo"];?>" name="titulo" maxLength="200" style="width: 823px; height: 22px"></td>
		</tr>
        <tr>
			<td class="tituloNombres">Imagen:</td>
			<td class="contenidoNombres"><input name="imagen" type="file" maxlength="255" style="WIDTH: 300px; HEIGHT: 22px"></td>
		</tr>
        <tr>
			<td class="tituloNombres">Imagen Actual: </td>
			<td class="contenidoNombres">
			<?php
				if ( empty($Registro["imagen"]) )
				{
					echo "No se asigno una imagen.";
				}
				else
				{
					?><img src="<?php echo $cRutaVerImgGeneral.$Registro["tabla"]."/p_".$Registro["imagen"]; ?>"><?
				}
			?>
			</td>
       	</tr>
        <tr>
          <td colspan="4" class="nuevo">
      <input type="submit" alt="Guardar Registro." value="Guardar" id="save"/>
	    <a href="modulos_categorias_listar.php?modulo=<?php echo $Registro["idcategoria"]?>"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
	</body>
</html>

