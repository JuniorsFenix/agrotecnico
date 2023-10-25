<?
  include("../../herramientas/seguridad/seguridad.php");
  include("funciones_lista.php");
  include("../../funciones_generales.php");
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
      $lines = file_get_contents($_FILES["listacorreos"]["tmp_name"]);
      $lines = explode("\n", $lines);
      if ( $_POST["borrarlista"] ) {
        $result = borrarCorreos($_POST["idlista"]);
        if ( $result != true ) {
          Mensaje( $result, "registrar_lista.php" );
        }
      }
      $i = 1;
      $inserts = array();
      foreach ($lines as $line_num => $line) {
        $datos = explode(",", $line);
        if ( count($datos) == 1 ) {
          $soloCorreo = true;
        } else {
          $soloCorreo = false;
        }
        $ok = false;
        if ( $soloCorreo && $datos[0] != "" ) {
          $ok = true;
        }
        if ( !$soloCorreo && $datos[1] != "" ) {
          $ok = true;
        }
        
        if ( $ok ) {
          if ( $soloCorreo ) {
            $result = registrarCorreo("",$datos[0],$_POST["idlista"]);
          }
          if ( !$soloCorreo ) {
            $result = registrarCorreo($datos[0],$datos[1],$_POST["idlista"]);
          }
          if ( $result != 1 && $result != 2 ) {
            rollbackRegistrarCorreo($i,$inserts);
            Mensaje( $result." ".$i, "registrar_lista.php" );
          }
          if ( $result == 1 ) {
            $inserts[$line_num] = $line;
          }
          $i++;
        }
      }
      Mensaje( "Lista importada... ", "registrar_lista.php" );
      break;
    default:
      header("Location: registrar_lista.php");
      break;
  }
?>
</body>
</html>