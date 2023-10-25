<?
  include("../../herramientas/seguridad/seguridad.php");
  include("funciones_lista.php");
  require_once("../../funciones_generales.php");
  if (!isset ($_GET["accion"])) {
    header("Location: registrar_lista.php");
  }
  
  function registrarCorreo($nombre,$correo,$idlista) {
    $nConexion = Conectar();
    $sql = "INSERT INTO tblboletinescorreos(correo,nombre,idlista) VALUES('{$correo}','{$nombre}',{$idlista})";
    $ra = mysqli_query($nConexion,$sql);
    if ( !$ra ) {
      $sql = "UPDATE tblboletinescorreos SET nombre='{$nombre}',idlista={$idlista} WHERE correo='{$correo}'";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
        return "Error importando lista, fallo insertando correo ";
      }
      return 2;
    }
    return 1;
  }

  function borrarCorreos($idlista) {
    $nConexion = Conectar();
    $sql = "DELETE FROM tblboletinescorreos WHERE idlista={$idlista}";
    $ra = mysqli_query($nConexion,$sql);
    if ( !$ra ) {
      return "Error importando lista, fallo eliminando correos de la lista";
    }
    return true;
  }
  
  function rollbackRegistrarCorreo($ii,$lines) {
    $nConexion = Conectar();
    $i = 1;
    foreach ( $lines as $line_num => $line ) {
      $datos = explode(",", $line);
      $sql = "DELETE FROM tblboletinescorreos WHERE correo='{$datos[0]}'";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
        Mensaje( "Error haciendo rollback.", "registrar_lista.php" ) ;
        //die("Error haciendo rollback ".$sql. " ".print_r($lines,1));
      }
      $i++;
      if ( $i == $ii ) {
        break;
      }
    }
  }
  
?>
<html>
  <head>
    <title>Administración de Contenidos Generales</title>
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
<?

  switch ( $_GET["accion"] ) {
    case  "adicionar":
      ListaFormNuevo();
      break;
    case "editar":
      ListaFormEditar($_GET["idlista"]);
      break;
    case "guardar":
      $result = ListaGuardar($_POST);
      if ( $result != true ) {
        Mensaje( $result, "registrar_lista.php" );
      }
      break;
    case "listaimportar":
      $result = ListaFormImportar($_POST);
      if ( $result != true ) {
        Mensaje( $result, "registrar_lista.php" );
      }
      break;
    case "importar":
	if ($_FILES["csv"]["size"] > 0) {
		
    $nConexion = Conectar();
    //get the csv file
    $file = $_FILES["csv"]["tmp_name"];
    $handle = fopen($file,"r");
    
    //loop through the csv file and insert into database
		do {
			if ($data[0]) {
				mysqli_query($nConexion,"INSERT INTO tblinvitados(nombre,apellido,cargo,empresa,correo,telefono,ciudad,pais) VALUES
					(
						'".addslashes($data[0])."',
						'".addslashes($data[1])."',
						'".addslashes($data[2])."',
						'".addslashes($data[3])."',
						'".addslashes($data[4])."',
						'".addslashes($data[5])."',
						'".addslashes($data[6])."',
						'".addslashes($data[7])."'
					)
				");
			}
		} while ($data = fgetcsv($handle,1000,";","'"));
		//
	
	} 
      Mensaje( "Lista importada... ", "registrar_correo.php" );
      break;
    default:
      header("Location: registrar_correo.php");
      break;
  }
?>
</body>
</html>