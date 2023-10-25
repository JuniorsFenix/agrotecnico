<?
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: menu_listar.php");
  }
  include("../../herramientas/seguridad/seguridad.php");
  include("../../vargenerales.php");
  include("menu_funciones.php");


?>
<html>
	<head>
		<title>Administración de Menu</title>
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
<? include("../../system_menu.php"); ?><br>
<?
  /* Determinar si biene el parametro que establece una accion:
     Adicionar  = Nuevo Registro
     Editar     = Editar Registro
     Eliminar   = Eliminar Registro
     Si no esta determinada la variable accion entonces se muestra la grilla con los registros
  */
    switch($_GET["Accion"])
    {
      case  "Adicionar":
        MenuFormNuevo();
        break;
      case "Editar":
        MenuFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        MenuEliminar($_GET["Id"]);
        break;
      case "Guardar":
        $ArchivoImg = $_FILES['txtImagen']['name'];
	
		$NomImagen = "";
		
        if ( !empty($ArchivoImg) )
        {
		  $NomImagen = $_FILES['txtImagen']['name'];
		  
        if( is_uploaded_file($_FILES["txtImagen"]["tmp_name"]) ){
          $s = move_uploaded_file( $_FILES["txtImagen"]["tmp_name"],"$cRutaImgMenu{$NomImagen}");
          if(!$s){
            Mensaje( "Fallo cargando archivo.", "listar_productos.php" ) ;
            exit;
          }
        }
        }
		
      	MenuGuardar($_POST["txtId"],$_POST["txtOrden"],$_POST["txtTitulo"],$_POST["opModulo"],$_POST["lstContenidos"],$_POST["lstProductos"],$_POST["lstServicios"],$_POST["txtUrl"],$NomImagen,$_POST["chkVentana"],$_POST["optPublicar"],$_POST["cboPadre"]);
        break;
	  case "Mover":
		MenuMover($_POST["idMenu"] , $_POST["txtOrden"] );
		?><script language="javascript">document.location.href='menu_listar.php'</script><?
		break;
      default:
				?><script language="javascript">document.location.href='menu_listar.php'</script><?
				break;
    }
?>
</body>
</html>