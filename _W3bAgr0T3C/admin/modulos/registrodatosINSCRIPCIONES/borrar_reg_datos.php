<html>
	<head>
		<title>Administraci�n de Contenidos Generales</title>
        <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
	</head>
<body>
<?
  include("../../funciones_generales.php");
  //include("../../herramientas/seguridad/seguridad.php");
$nId = $_GET["id"];
$nConexion = Conectar();
mysqli_query($nConexion, "DELETE FROM tbl_datos_incripciones WHERE iddatos_inscripciones ='$nId'" );
mysqli_close( $nConexion );
Mensaje( "El registro ha sido eliminado correctamente.","registros_listar.php" );
?>
</body>
</html>
