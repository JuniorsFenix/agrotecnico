<?
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo
  # Desarrollo               :  Estilo y Dise�o - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
  include("../../funciones_generales.php");
  require_once 'wjwflvplayer.inc.php';
  require_once 'ffmpeg_snap.php';

  ini_set("memory_limit","512M");
  ini_set("upload_max_filesize", "100M");
  ini_set("max_execution_time",60*15);//3 MINUTOS
  ini_set("post_max_size","100M");
?>

<?
  ###############################################################################
  # Descripci�n   : Muestra el formulario para ingreso
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function VideosFormNuevo()
  {
    $nConexion = Conectar();
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="videos.php?Accion=Guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="txtIdVideo" name="txtIdVideo" value="0">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO VIDEO</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Categoria:</td>
        <td class="contenidoNombres">
        <select name="IdCategoria">
        <?php
        $ra =mysqli_query($nConexion,"select * from tblvideos_categorias where idcategoria<>0 order by vpath");
        while( $rax=mysqli_fetch_object($ra) ){
          ?><option value="<?=$rax->idcategoria;?>"><?=$rax->vpath;?></option><?
        }
        ?>
        </select>
        </td>
      </tr>
      
      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" maxLength="200" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripcion:</td>
        <td class="contenidoNombres">
        <textarea name="txtDescripcion" rows="10" cols="50" wrap="off"></textarea>
        </td>
      </tr>

        <tr>
          <td class="tituloNombres">Pa�s:</td>
          <td class="contenidoNombres">
            <INPUT id="txtPais" type="text" name="txtPais" maxLength="200" style="width:200px; "></td>
        </tr>

      <tr>
        <td class="tituloNombres">Duraci�n:</td>
        <td class="contenidoNombres"><INPUT id="txtDuracion" type="text" name="txtDuracion" maxLength="200" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Archivo FLV:</td>
        <td class="contenidoNombres">
          <input type="file" name="archivo">
        </td>
      </tr>
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="listar_categorias.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
  <?
  }
###############################################################################
?>



<?
  ###############################################################################
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente a la DB
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function VideosGuardar( $idcategoria, $idVideo,$nombre,$descripcion,$pais,$duracion,$archivo='')
  {
  ini_set("memory_limit","512M");

  ini_set("max_execution_time","300");//3 MINUTOS
  ini_set("max_input_time","300");
  $ffmpeg = "/usr/bin/ffmpeg";
  $videoDest=realpath("../../../fotos/videos");

  //ini_set("upload_max_filesize", "128M");
  //ini_set("post_max_size","128M");
  
    //creo el directorio si no existe
    if( !is_dir("../../../fotos/videos") ){
      mkdir("../../../fotos/videos");
    }

    $nConexion = Conectar();
    if ( $idVideo == "0" ) // Nuevo Registro
    {
      @ $r = mysqli_query($nConexion,"INSERT INTO tblvideos ( nombre,pais,duracion,descripcion,idciudad,idcategoria ) VALUES
      ( '$nombre','{$pais}','{$duracion}','{$descripcion}','{$_SESSION["IdCiudad"]}',{$idcategoria})");
      if(!$r){
        Mensaje( "Fallo almacenando video.".mysqli_error($nConexion), "listar_categorias.php" ) ;
        exit;
      }

      $idVideo = mysqli_insert_id($nConexion);
      
      

      $cmd="{$ffmpeg} -i \"{$archivo["tmp_name"]}\" -ar 22050 -ab 32000 -f flv -s 320x240 \"{$videoDest}/{$idVideo}.flv\"";
      $output=array();
      exec($cmd,$output);
      
      convertToFlvSnap($archivo["tmp_name"],"{$videoDest}/{$idVideo}.jpg");
      
      //$s = move_uploaded_file( $archivo["tmp_name"],"../../../fotos/videos/{$idVideo}.flv");
      
      
      if(!file_exists("{$videoDest}/{$idVideo}.flv")){
        Mensaje( "Fallo cargando archivo.", "listar_categorias.php" ) ;
        exit;
      }

      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "listar_categorias.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
      $r = mysqli_query($nConexion, "UPDATE tblvideos SET nombre = '$nombre',pais='{$pais}',duracion='{$duracion}',descripcion='{$descripcion}',
      idciudad='{$_SESSION["IdCiudad"]}',idcategoria={$idcategoria}
      WHERE idvideo = $idVideo" );

      if(!$r){
        Mensaje( "Fallo actualizando video.".mysqli_error($nConexion), "listar_categorias.php" ) ;
        exit;
      }

      if( is_uploaded_file($archivo["tmp_name"]) ){
        //$s = move_uploaded_file( $archivo["tmp_name"],"../../../fotos/videos/{$idVideo}.flv");
        $cmd="{$ffmpeg} -i \"{$archivo["tmp_name"]}\" -ar 22050 -ab 32000 -f flv -s 320x240 \"{$videoDest}/{$idVideo}.flv\"";
        $output=array();
        exec($cmd,$output);
        
        convertToFlvSnap($archivo["tmp_name"],"{$videoDest}/{$idVideo}.jpg");
        
        
        if(!file_exists("{$videoDest}/{$idVideo}.flv")){
          Mensaje( "Fallo cargando archivo.", "listar_categorias.php" ) ;
          exit;
        }
      }


      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "listar_categorias.php" ) ;
      exit;
    }



  } // FIN: function
  ###############################################################################
?>

<?
  ###############################################################################
  # Descripci�n   : Eliminar un registro
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function VideosEliminar( $idVideo )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT idvideo FROM tblvideos WHERE idvideo = $idVideo") );
    mysqli_query($nConexion, "DELETE FROM tblvideos WHERE idvideo = $idVideo " );
    unlink("../../../fotos/videos/{$idVideo}.flv");

    Log_System( "VIDEOS" , "ELIMINA" , "VIDEO: " . $reg->idVideo  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","listar_categorias.php" );
    exit();
  } // FIN: function
  ###############################################################################
?>

<?
  ###############################################################################
  # Nombre        : ContenidosFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function VideosFormEditar( $idVideo )
  {
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblvideos WHERE idvideo = $idVideo" ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
    ?>

    <?=wjwflvPlayer::import();?>

    <!-- Formulario Edici�n / Eliminaci�n de Contenidos -->
    <form method="post" action="videos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtIdVideo" name="txtIdVideo" value="<? echo $idVideo ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR VIDEO</b></td>
        </tr>
        
      <tr>
        <td class="tituloNombres">Categoria:</td>
        <td class="contenidoNombres">
        <select name="IdCategoria">
        <?php
        $ra =mysqli_query($nConexion,"select * from tblvideos_categorias where idcategoria<>0 order by vpath");
        while( $rax=mysqli_fetch_object($ra) ){
          ?><option value="<?=$rax->idcategoria;?>"><?=$rax->vpath;?></option><?
        }
        ?>
        </select>
        </td>
      </tr>
        
        <tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" value="<? echo $Registro["nombre"]; ?>" maxLength="200" style="width:200px; "></td>
        </tr>
      <tr>
        <td class="tituloNombres">Descripcion:</td>
        <td class="contenidoNombres">
        <textarea name="txtDescripcion" rows="10" cols="50" wrap="off"><?=$Registro["descripcion"];?></textarea>
        </td>
      </tr>

        <tr>
          <td class="tituloNombres">Pa�s:</td>
          <td class="contenidoNombres">
            <INPUT id="txtPais" type="text" name="txtPais" value="<? echo $Registro["pais"]; ?>" maxLength="200" style="width:200px; "></td>
        </tr>
      <tr>
        <td class="tituloNombres">Duraci�n:</td>
        <td class="contenidoNombres"><INPUT id="txtDuracion" type="text" name="txtDuracion" maxLength="200" value="<?=$Registro["duracion"];?>" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Archivo FLV:</td>
        <td class="contenidoNombres">
          <input type="file" name="archivo"><br/>
          <?php if( file_exists("../../../fotos/videos/{$idVideo}.flv") ):?>
          <?=wjwflvPlayer::build("1","{$wwwRoot}fotos/videos/{$idVideo}.flv");?>
          <?php endif;?>
        </td>
      </tr>

        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <?
            if ( Perfil() != "3" )
            {
            ?><a href="videos.php?Accion=Eliminar&Id=<? echo $idVideo; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
            }
            ?>
            <a href="listar_categorias.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
    <?
    mysqli_free_result( $Resultado );
  }
  ###############################################################################
  ?>