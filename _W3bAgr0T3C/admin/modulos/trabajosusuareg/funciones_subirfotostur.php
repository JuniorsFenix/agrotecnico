<?
  ###############################################################################
  # funciones_decrip_clienteseyd.php:  Archivo de funciones modulo 
  # Desarrollo               		:  Estilo y Dise�o
  # Web                      		:  http://www.esidi.com
  ###############################################################################
  require_once("../../funciones_generales.php");
  //require_once("../../herramientas/FCKeditor/fckeditor.php") ;
  include("../../herramientas/upload/uploaderFunction.php");
  //ini_set("memory_limit","5M");
  //ini_set("upload_max_filesize", "1M");
  //ini_set("max_execution_time","180");//3 MINUTOS
  //ini_set("post_max_size","1M");
?>
<? //include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : SubirFotosturGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId , $nombreagencia
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function SubirFotosturGuardar( $d,$files )
  { 
    $IdUsuario =  $_SESSION["UsrId"];
	//$IdCiudad = $_SESSION["IdCiudad"];
	  //creo el directorio si no existe
    if( !is_dir("../../../fotos/fotostur") ){
      @ mkdir("../../../fotos/fotostur");
    }
	$fecha1=date("Y-m-d");
	
    for($i=1;$i<=5;$i++){
      ${"archivo{$i}"} ="";

      if( is_uploaded_file($files["archivo{$i}"]["tmp_name"]) ){
	  
	   if( ($files["archivo{$i}"]["type"]=="image/pjpeg") || ($files["archivo{$i}"]["type"]=="image/jpeg") || ($files["archivo{$i}"]["type"]=="image/gif") || ($files["archivo{$i}"]["type"]=="application/x-shockwave-flash") ){
	   if( ($files["archivo{$i}"]["size"]<=300000)  ){
        /*$s = move_uploaded_file( $files["imagen_{$i}"]["tmp_name"],"../../../fotos/tienda/productos/{$d["IdProducto"]}_{$files["imagen_{$i}"]["name"]}");
        if(!$s){
          Mensaje( "Fallo cargando archivo {$i}.", "productos_listar.php" ) ;
          exit;
        }*/

        ${"archivo{$i}"}=$files["archivo{$i}"]["name"];
		}
	   }
      }
      elseif( $d["archivoh{$i}"]){
        ${"archivo{$i}"}=$d["archivoh{$i}"];
      }
    }

    $nConexion = Conectar();
	
    if ( $d["txtId"] <= "0" ) // Nuevo Registro
    {
	   $sql="INSERT INTO tbl_fotostur (idfotos,idlogin,fecha,foto1,foto2,foto3,foto4,foto5,creadopor) VALUES ('{$d["txtId"]}', '$IdUsuario' , '$fecha1' , '$archivo1' , '$archivo2' , '$archivo3' , '$archivo4' , '$archivo5' , '{$d["txtcreadopor"]}')";
	   
      @ $r = mysqli_query($nConexion,$sql);

      if(!$r){
        Mensaje( "Fallo almacenando ".mysqli_error($nConexion), "cabeceratur.php" ) ;
        exit;
      }
	  
      $d["txtId"] = mysqli_insert_id($nConexion);
		 
	for($i=1;$i<=5;$i++){
        if( is_uploaded_file($files["archivo{$i}"]["tmp_name"]) ){
		  if( ($files["archivo{$i}"]["type"]=="image/pjpeg") || ($files["archivo{$i}"]["type"]=="image/jpeg") || ($files["archivo{$i}"]["type"]=="image/gif") || ($files["archivo{$i}"]["type"]=="application/x-shockwave-flash")){
		  if( ($files["archivo{$i}"]["size"]<=300000)  ){
		  $s = move_uploaded_file( $files["archivo{$i}"]["tmp_name"],"../../../fotos/fotostur/{$files["archivo{$i}"]["name"]}");
          if(!$s){
            Mensaje( "Fallo cargando archivo {$i}.", "cabeceratur.php" ) ;
            exit;
			}
		   }
          }
        }
	  }		 
		 
		 	for($i=1;$i<=5;$i++){

		  $tipo = ( $files["archivo{$i}"]["type"]);
       echo "Tipo: $i ".$tipo." ";
			}
			
			 	for($i=1;$i<=5;$i++){

		  $tipo = ( $files["archivo{$i}"]["size"]);
       echo "Tipo: $i ".$tipo." ";
			}


		 
      mysqli_close($nConexion);
      Mensaje( "Los Archivos han sido almacenado correctamente.", "logout.php" ) ;
      exit;
    }
  } // FIN: function 
  ###############################################################################
?>