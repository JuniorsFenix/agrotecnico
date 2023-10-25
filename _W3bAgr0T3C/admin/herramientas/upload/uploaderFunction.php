<?php
#//////////////////////////////////////////////////////////////////////////////////////////
# Function uploader() v1.6
# CREADA: Mayo 13 de 2005
# ESCRITO POR: Marco A. Castillo
# EMAIL: dellasera@gmail.com
# EXPLICACION: funcion para subir archivos al servidor.
# NOTAS:
#		1- La función uploader es una función que le permitirá subir archivos al servidor
#       2- Esta función devuelve un resultado bollean que puede ser true o false.
#       3- Permite verificar los resultados de cada imagen invocando la función
#          uploader_msg()
#       4- Devuelve una variable array multidimensional creada de forma global para obtener
#          los valores de los archivos que fueron copiados correctamente. Estos valores pueden
#          ser procesados por medio de un foreach($uploader_archivos_copiados as $imagen => $detalles) 
#//////////////////////////////////////////////////////////////////////////////////////////

function uploader($CampoNombre,$folder,$size=2000000,$tipoArray=array("default")){
global $uploader_descripcion;
global $uploader_archivos_copiados;
$msgFolder = "<font size3><b>El folder seleccionado no existe.</b></font><br>Este parámetro no debe estar vacío y debe terminar con el signo /";
$msgFolder = $msgFolder."<br><b>ejemplo:</b><br>\$folder = \"image/\";";
$msgFile = "<font size=3><b>El nombre del campo no existe.</b></font><br>Se pudo comprobar que el campo <b>$CampoNombre</b> no es ";
$msgFile = $msgFile."un array de tipo \$_FILE o no existe, porfavor verifique que el nombre sea el correcto.";
    #Si no vienen tipos definidos se agregan los tipos por default
	if($tipoArray[0]=="default"){
		unset($tipoArray);
		$tipoArray = ListaTipos();
	}
	#Comprobamos si el campo file en verdad existe
	if(!isset($_FILES[$CampoNombre]['name'][0])){
 	 echo $msgFile;
 	 return false;
	}
 	for($i=0;$i<count($_FILES[$CampoNombre]['name']);$i++){
	 $nombre_File = $_FILES[$CampoNombre]['name'][$i];
 	 $size_File = $_FILES[$CampoNombre]['size'][$i];
 	 $tipo_File = $_FILES[$CampoNombre]['type'][$i];
 	 $temp_File = $_FILES[$CampoNombre]['tmp_name'][$i];
 	 if( opendir($folder) /*&& strpos($folder,"/")*/){
 	 if(VerificarTipo($tipo_File,$tipoArray)){
 	 	if(size($size_File,$size)){
         if(!move_uploaded_file($temp_File,$folder.$nombre_File)){
         	#si no subio se manda el mensaje
         	$uploader_descripcion = $uploader_descripcion.$nombre_File."=4=".$tipo_File."^";
         	$uploader_temp_archivos = $uploader_temp_archivos.$nombre_File."=0^";
         }
         else{
         	#si subio se manda el mensaje
         	$uploader_descripcion = $uploader_descripcion.$nombre_File."=1=".$tipo_File."^";
         	$uploader_temp_archivos = $uploader_temp_archivos.$nombre_File."=1=".$tipo_File."=".$size_File."^";
         }
 	 	}
 	 	else{
 	 		if($nombre_File!=""){
 	 			#si el tamaño sobrepaso se manda el mensaje
 	 		$uploader_descripcion = $uploader_descripcion.$nombre_File."=3=".$tipo_File."^";
 	 		$uploader_temp_archivos = $uploader_temp_archivos.$nombre_File."=0^";
 	 		}
 	 	}
 	 }
 	 else{
 	 	if($nombre_File!=""){
 	 	#si el tipo no coincide se manda el mensaje
 	    $uploader_descripcion = $uploader_descripcion.$nombre_File."=2=".$tipo_File."^";
 	    $uploader_temp_archivos = $uploader_temp_archivos.$nombre_File."=0^";
 	 	}
 	 }
 	}
 	else{
     #Si el folder no existe detenemos el script y enviamos el error
 	 echo $msgFolder;
 	 return false;
 	 break;
 	}
 	}
 $uploader_archivos_copiados = archivo_ingresada($uploader_temp_archivos);
 return true;
}

function archivo_ingresada($uploader_temp_archivos){
$uploader_imagen_detalles = explode("^",$uploader_temp_archivos);
$i = 0;
 foreach($uploader_imagen_detalles as $uploader_lista){
   $uploader_imagen = explode("=",$uploader_lista);
    if($uploader_imagen[1]==1){
     #$lista_imagenes = $lista_imagenes.$uploader_imagen[0]."^";
     if(isset($list_array)){
      $temp_array = array("$uploader_imagen[0]"=>array("$uploader_imagen[2]","$uploader_imagen[3]"));
      $list_array = array_merge($list_array,$temp_array);
      unset($temp_array);
     }
     else{
     	$list_array = array("$uploader_imagen[0]"=>array("$uploader_imagen[2]","$uploader_imagen[3]"));
     }
     $i++;
    }
  }

return $list_array;
}

function uploader_msg(){
	
global $uploader_descripcion;
$detalles = explode("^",$uploader_descripcion);
foreach($detalles as $lineas) {
	$codigos = explode("=",$lineas);
	switch ($codigos[1]){
	case 1:
	$msgSubio = "<b>".$codigos[0]."</b> se copio al servidor correctamente.<br>";
	echo "<font face=verdana size=2>".$msgSubio."</font>";
	break;
	case 2:
	$msgTipo = "<b>".$codigos[0]."</b> (TIPO=\"".$codigos[2]."\") no o es un tipo permitido. Si desea utilizarlo agregue el tipo a su lista.<br>";
	echo "<font face=verdana size=2>".$msgTipo."</font>";
	break;
	case 3:
	$msgSize = "<b>".$codigos[0]."</b> El archivo sobrepaso el tamaño permitido.<br>";
	echo "<font face=verdana size=2>".$msgSize."</font>";
	break;
	case 4:
	$msgError = "<b>".$codigos[0]."</b> Error al copiar este archivo al servidor.<br>";
	echo "<font face=verdana size=2>".$msgError."</font>";
	break;
	}
}
	
}

function size($size_File,$size){
	if($size_File<$size){
		return true;
	}
	else{
	    return false;	
	}
}

function msg($msg){
	$contenido = explode("|",$msg);
	return $contenido;
}

function VerificarTipo($tipo_File,$tipoArray){
	$count = count($tipoArray);
	for($i=0;$i<$count;$i++){
		if($tipo_File==$tipoArray[$i]){
			return true;
			break;
		}
	}
	return false;
}

function ListaTipos(){
 $tipos = array(
 0 => "image/jpeg",
 1 => "image/gif",
 2 => "application/zip",
 3 => "application/pdf",
 4 => "application/msword",
 5 => "application/vnd.ms-excel",
 6 => "image/png",
 7 => "text/plain",
 8 => "text/php",
 9 => "text/asp",
 10 => "text/css",
 11 => "image/pjpeg"
 );
 return $tipos;
}
?>