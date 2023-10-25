<?php
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo
  # Desarrollo               :  Estilo y Dise�o - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
  include("../../funciones_generales.php");
  
  ini_set("memory_limit","50M");
  ini_set("upload_max_filesize", "30M");
  ini_set("max_execution_time","180");//3 MINUTOS
  ini_set("post_max_size","30M");
  
  ###############################################################################
  # Descripci�n   : Muestra el formulario para ingreso
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function VideosFormNuevo()
  {
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="videos.php?Accion=Guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="txtIdVideo" name="txtIdVideo" value="0">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO VIDEO YOUTUBE</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Categoria:</td>
        <td class="contenidoNombres">
        <select name="IdCategoria">
        <?php
        $ra =mysqli_query($nConexion,"select * from tblvideosyoutube_categorias where idcategoria<>0 order by vpath");
        while( $rax=mysqli_fetch_object($ra) ){
          ?><option value="<?=$rax->idcategoria;?>"  <?php echo (isset($_GET["idcategoria"]) && $_GET["idcategoria"]==$rax->idcategoria) ? "selected":"";?> ><?=$rax->vpath;?></option><?
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
        <td class="tituloNombres">Url:</td>
        <td class="contenidoNombres">
        <input type="text" name="url" style="width:100%;"></textarea>
        </td>
      </tr>
      
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="listar.php?idcategoria=1"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
  <?php
  }
###############################################################################
  ###############################################################################
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente a la DB
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function VideosGuardar( $idcategoria, $idVideo,$nombre,$descripcion,$url)
  {
    
    if( trim($nombre)=="" ){
        Mensaje( "Nombre de categoria invalido" ) ;
    }    
    
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
	mysqli_set_charset($nConexion,'utf8');
    if ( $idVideo == "0" ) // Nuevo Registro
    {
      $sql="INSERT INTO tblvideosyoutube ( nombre,descripcion,idciudad,idcategoria,url,fechapub ) VALUES
      ( '$nombre','{$descripcion}','{$_SESSION["IdCiudad"]}',{$idcategoria},'{$url}',current_date)";
	  
      @ $r = mysqli_query($nConexion,$sql);
      if(!$r){
        Mensaje( "Fallo almacenando video.".mysqli_error($nConexion), "listar.php?idcategoria=1" ) ;
        exit;
      }

      $idVideo = mysqli_insert_id($nConexion);
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "listar.php?idcategoria=1" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
        $sql="UPDATE tblvideosyoutube SET nombre = '$nombre',descripcion='{$descripcion}',
      idciudad='{$_SESSION["IdCiudad"]}',idcategoria={$idcategoria},url='{$url}' 
      WHERE idvideo = $idVideo";
      
      $r = mysqli_query($nConexion, $sql );

      if(!$r){
        Mensaje( "Fallo actualizando video.".mysqli_error($nConexion), "listar.php?idcategoria=$idcategoria" ) ;
        exit;
      }
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "listar.php?idcategoria=$idcategoria" ) ;
      exit;
    }



  } // FIN: function
  ###############################################################################
  ###############################################################################
  # Descripci�n   : Eliminar un registro
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function VideosEliminar( $idVideo )
  {
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT idvideo FROM tblvideosyoutube WHERE idvideo = $idVideo") );
    mysqli_query($nConexion, "DELETE FROM tblvideosyoutube WHERE idvideo = $idVideo " );

    Log_System( "VIDEOSYOUTUBE" , "ELIMINA" , "VIDEO: " . $reg->idVideo  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","listar.php?idcategoria=1" );
    exit();
  } // FIN: function
  ###############################################################################
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
	mysqli_set_charset($nConexion,'utf8');
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblvideosyoutube WHERE idvideo = $idVideo" ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Contenidos -->
    <form method="post" action="videos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtIdVideo" name="txtIdVideo" value="<? echo $idVideo ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR VIDEO YOUTUBE</b></td>
        </tr>
        
      <tr>
        <td class="tituloNombres">Categoria:</td>
        <td class="contenidoNombres">
        <select name="IdCategoria">
        <?php
        $ra =mysqli_query($nConexion,"select * from tblvideosyoutube_categorias where idcategoria<>0 order by vpath");
        while( $rax=mysqli_fetch_object($ra) ){
          ?><option value="<?=$rax->idcategoria;?>" <?=$rax->idcategoria==$Registro["idcategoria"]?"selected":"";?> ><?=$rax->vpath;?></option><?
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
        <td class="tituloNombres">Url:</td>
        <td class="contenidoNombres">
        <input type="text" name="url" value="<?=$Registro["url"];?>" style="width:100%;"></textarea>
        </td>
      </tr>
      
      <tr>
        <td class="tituloNombres">Preview:</td>
        <td class="contenidoNombres">
        <?php 
			$url = explode("watch?v=",$Registro["url"]);
			$url = explode("&",$url[1]);
			$url = $url[0];
		?>
		<div class="flex">
			<div class="col-md-6">
				<div class="videoWrapper">
					<iframe src="https://www.youtube.com/embed/<?php echo $url; ?>" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
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
          <a href="listar.php?idcategoria=1"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
    <?
    mysqli_free_result( $Resultado );
  }
  ###############################################################################
  ?>