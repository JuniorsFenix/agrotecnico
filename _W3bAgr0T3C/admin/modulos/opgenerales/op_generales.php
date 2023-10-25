<?php
include("../../funciones_generales.php");
include("../../herramientas/seguridad/seguridad.php");
include("../../vargenerales.php");
$nConexion    = Conectar();

$idciudad = $_GET["idciudad"];
$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblgenerales where idciudad = " . $idciudad ) ;
if ( !mysqli_num_rows($Resultado) ){
	$EsNuevo = "S";
}else{
	$EsNuevo = "N";
}

if ( isset( $_GET["PostBack"] ) ){
	$Titulo				= $_POST["txtTitulo"];
	$Descripcion	= $_POST["txtDescripcion"];
	$Palabras_Cla	= $_POST["txtPalabrasClave"];
	$logo	= $_POST["logo"];
	if ($EsNuevo == "N"){
		mysqli_query($nConexion, "UPDATE tblgenerales SET titulo = '$Titulo', descripcion = '$Descripcion', palabras_clave = '$Palabras_Cla', logo = '$logo' WHERE idciudad = " . $idciudad );
	}else{
		mysqli_query($nConexion,"INSERT INTO tblgenerales (titulo,descripcion,palabras_clave,idciudad,logo) VALUES ('$Titulo','$Descripcion','$Palabras_Cla',$idciudad,$logo)");			
	}
	mysqli_close( $nConexion ) ;
	?><script>document.location.href='../ciudades/ciudades_listar.php'</script><?
}
$Registro     = mysqli_fetch_object ( $Resultado );
?>
<html>
	<head>
		<title>Informaci�n Empresa - Carrito de Compras</title>
		<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<script src="../../herramientas/ckeditor/ckeditor.js"></script>
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
    <form method="post" action="op_generales.php?PostBack=S&idciudad=<?=$idciudad;?>" enctype="multipart/form-data">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>DATOS EMPRESA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><textarea name="txtTitulo" cols="60" rows="5"><? echo $Registro->titulo; ?></textarea></tr>
        <tr>
          <td class="tituloNombres">Descripci�n:</td>
          <td class="contenidoNombres"><textarea name="txtDescripcion" cols="60" rows="5"><? echo $Registro->descripcion; ?></textarea></td>
        </tr>
        <tr>
          <td class="tituloNombres">Palabras Clave:</td>
          <td class="contenidoNombres"><textarea name="txtPalabrasClave" cols="60" rows="5"><? echo $Registro->palabras_clave; ?></textarea></td>
        </tr>
        <tr>
          <td class="tituloNombres">Logo:</td>
          <td class="contenidoNombres">
            <textarea name="logo"><?php echo $Registro->logo; ?></textarea>
            <script>
            CKEDITOR.replace( 'logo' );
            </script>
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