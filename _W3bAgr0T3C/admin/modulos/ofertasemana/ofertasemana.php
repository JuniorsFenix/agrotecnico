<?
	include("../../herramientas/FCKeditor/fckeditor.php") ;
  include("../../herramientas/seguridad/seguridad.php");
  include("ofertasemana_funciones.php");
  include("../../herramientas/upload/uploaderFunction.php");
	include("../../vargenerales.php");
  if (!isset ($_GET["Accion"])) // Si no se envio la accion muestro la lista
  {
    header("Location: ofertasemana_listar.php");
  }
?>
<html>
	<head>
		<title>Administraci�n de Oferta de la semana</title>
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
<script src="../../herramientas/ckeditor/ckeditor.js"></script>

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
        OfertasemanaFormNuevo();
        break;
      case "Editar":
        OfertasemanaFormEditar($_GET["Id"]);
        break;
      case "Eliminar":
        OfertasemanaEliminar($_GET["Id"]);
        break;
      case "Guardar":
        // Subo el archivo al servidor, si es correcto almaceno el registro
        # Comprobamos que el campo file no venga vacio.
        $Archivo = $_FILES['txtImagen']['name'][0];
        if ( empty($Archivo) )
        {
          OfertasemanaGuardar($_POST["txtId"],$_POST["txtEmpresa"],$_POST["txtDescripcion"],$_POST["txtDuracion"],$_POST["txtFuente"],"",$_POST["optPublicar"]);
          exit;
        }

        # Creamos el array de los tipos que permitiremos su ingreso.
        $tipos = array("image/jpeg","image/gif","image/pjpeg","image/png");
        # Le damo valor a la variable $size para permitir un tama�o especifico.
        # el tama�o debe estar en bytes ejemplo 700k = 700000 bytes
        # tomar en cuenta que 1MB es igual a 1 millon de bytes (1MB = 1000000 bytes)
        $size = 400000;
        # Creamos la variable del Nombre del campo, aqui se debe tomar en cuenta que
        # el nombre sera puesto como array ejemplo <input type="file" name="file[]">
        $Campofile = "txtImagen";
        # Cremos la variable del folder donde se ingresaran las imagenes
        # el nombre debe terminar con el signo / ejemplo: $folder = "image/";
        $folder = $cRutaImgOfertasemana;
        # Llamamos a la funcion Uploader que para esta version 1.6 como en la 1.5 devolvera un boolean
        # que dira si se proceso los archivos a subir o si ubieron errores de
        # configuracion.
        # es importante tener en cuenta que si suben 5 imagenes de ellas 3 fallan
        # la funcion devolvera true ya que ella proceso correctamente detalles como
        # validacion de tama�o y de tipo.
        if(uploader($Campofile,$folder,$size,$tipos))
        {
          //echo "La funcion Uploader finalizo con el proceso.<br>";
          # se incorporo la funcion uploader_msg() que es un depurador
          # para saber que resultados en detalle paso con cada imagen que
          # se envio a la funcion uploader.
          # esta funcion devuelve los detalles que uno imprimia en la versio 1.0
          # al devolver la funcion un array como retorno.
          //uploader_msg();
          # La variable global $uploader_archivos_copiados es un array multidimensional que se incorporo
          # en esta versi�n 1.6 para recibir los nombres de las imagenes que fueron copiadas al server
          # con �xito permitiendo a los programadores poder ingresar en la base de datos
          # los nombres de los archivos, tipo y tama�o en bytes.
          foreach ($uploader_archivos_copiados as $imagen => $detalles)
          {
            # Con foreach obtuvimos las variables
            # $imagen que almacena los nombres de las imagenes
      	    # $detalles[0] dice el tipo de la imagen
        	  # $detalles[1] dice el peso en bytes de la variable.
      	    //echo $imagen." de tipo ".$detalles[0]." y peso de ".$detalles[1]." bytes\n";
      	    $NomImagen = $imagen ;
      	    # Con estos valores podremos hacer uso de ellas para insertarlas en una
     	      # base de datos:
      	    # mysqli_query($nConexion,"Insert into tabla (imagen,tipo,size) values (".$imagen.",".$detalles[0].",".$detalles[1].")",$coneccion);
          }
            OfertasemanaGuardar($_POST["txtId"],$_POST["txtEmpresa"],$_POST["txtDescripcion"],$_POST["txtDuracion"],$_POST["txtFuente"],$NomImagen,$_POST["optPublicar"]);
        }
        break;
      default:
        header("Location: ofertasemana_listar.php");
        break;
    }
?>
</body>
</html>