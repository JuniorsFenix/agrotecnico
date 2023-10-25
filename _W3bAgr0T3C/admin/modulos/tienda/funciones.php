<?php
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo
  # Desarrollo               :  Estilo y Diseño - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
  require_once("../../funciones_generales.php");
  require_once 'funciones_productos.php';
	include("../../vargenerales.php");
	require_once("../../herramientas/upload/SimpleImage.php");

  ini_set("memory_limit","50M");
  ini_set("upload_max_filesize", "30M");
  ini_set("max_execution_time","180");//3 MINUTOS
  ini_set("post_max_size","30M");

  ###############################################################################
  # Descripción   : Muestra el formulario para ingreso
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CategoriasFormNuevo()
  {
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="categorias.php?Accion=Guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="IdCategoria" name="IdCategoria" value="0">
    <table width="100%">
      <tr>
        <td colspan="5" align="center" class="tituloFormulario"><b>NUEVA CATEGORÍA</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Categoria Superior:</td>
        <td class="contenidoNombres" colspan="5">
        <select name="IdCategoriaSuperior">
        <?php
        $ra =mysqli_query($nConexion,"select * from tblti_categorias order by vpath");
        while( $rax=mysqli_fetch_object($ra) ){
          ?><option value="<?=$rax->idcategoria;?>"><?=$rax->vpath;?></option><?
        }
        ?>
        </select>
        </td>
      </tr>

      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtNombre" type="text" name="txtNombre" maxLength="200" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripción:</td>
        <td class="contenidoNombres" colspan="5">
            <textarea name="txtDescripcion"></textarea>
            <script>
                CKEDITOR.replace( 'txtDescripcion' );
            </script>
        </td>
      </tr>
            <tr>
        <td colspan="5" align="center" class="tituloFormulario"><b>POSICIONAMIENTO</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Título:</td>
        <td class="contenidoNombres" colspan="5"><input type="text" name="titulo" class="seocounter_title" maxLength="200" style="width: 825px; height: 22px"></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripción:</td>
        <td class="contenidoNombres" colspan="5">
            <textarea name="metaDescripcion" class="seocounter_meta" cols="100" rows="10"></textarea>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Tags: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select url,nombre from tbltags_palabras where tag=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="txtTags[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["url"];?>"><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
        <td class="tituloNombres">Palabras Clave: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select idpalabra,nombre from tbltags_palabras where keyword=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="txtPalabras[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["nombre"];?>"><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
      </tr>
      <tr>
        <td colspan="5" align="center" class="tituloFormulario"></td>
      </tr>

        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres" colspan="5"><input type="file" id="txtImagen" name="txtImagen"></td>
        </tr>
        <tr>
            <td class="tituloNombres">Ver en Home:</td>
            <td class="contenidoNombres">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><label><input type="radio" id="home" name="home" value="1">Si</label></td>
                        <td width="10"></td>
                        <td><label><input type="radio" id="home" name="home" value="0" checked>No</label></td>
                    </tr>
                </table>
          </td>
        </tr>
      <tr>
        <td colspan="5" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="listar_categorias.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
  <?
  }
###############################################################################

  ###############################################################################
  # Descripción   : Adiciona un nuevo registro o actualiza uno existente a la DB
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CategoriasGuardar( $d,$files )
  {
	include("../../vargenerales.php");

    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
	setlocale(LC_ALL, 'en_US.UTF8');
    $url = slug($d["txtNombre"]);
	if (!empty($d["txtTags"])){
	$tags = implode(',', $d["txtTags"]);
	}
	if (!empty($d["txtPalabras"])){
	$palabras = implode(', ', $d["txtPalabras"]);
	}
    if ( $d["IdCategoria"] == "0" ) // Nuevo Registro
    {
      $sql="select vpath from tblti_categorias where idcategoria = {$d["IdCategoriaSuperior"]} ";
      $ra = mysqli_query($nConexion,$sql);
      $dCat = mysqli_fetch_assoc( $ra );

      $vpath = $dCat["vpath"];
      if( $vpath=="/" ) $vpath="";
      $vpath="{$vpath}/{$d["txtNombre"]}";

      $sql="insert into tblti_categorias
      ( idciudad, nombre,descripcion,vpath,url,idcategoria_superior,titulo,metaDescripcion,tags,palabras) values
      ({$_SESSION["IdCiudad"]},'{$d["txtNombre"]}','{$d["txtDescripcion"]}','{$vpath}','{$url}',{$d["IdCategoriaSuperior"]},'{$d["titulo"]}','{$d["metaDescripcion"]}','$tags','$palabras')";

      @ $r = mysqli_query($nConexion,$sql);
	  
      $d["IdCategoria"] = mysqli_insert_id($nConexion);
	  
	  if( isset( $files["txtImagen"]["tmp_name"] ) && $files["txtImagen"]["tmp_name"]!="" ) {
			
				$NomImagen = $files["txtImagen"]["name"];
	
			  $image = new SimpleImage();
			  $image->load($files["txtImagen"]["tmp_name"]);
			  $image->resizeToWidth(600);
			  $image->save($cRutaImagenTienda . $NomImagen);
				
			  $sql="update tblti_categorias set imagen='{$NomImagen}' where idcategoria = {$d["IdCategoria"]}";
				
      $r = mysqli_query($nConexion,$sql);
	  
	  }

      if(!$r){
        Mensaje( "Fallo almacenando ".mysqli_error($nConexion), "listar_categorias.php" ) ;
        exit;
      }

      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "listar_categorias.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
      mysqli_query($nConexion,"begin");
      $sql="select vpath from tblti_categorias where idcategoria = {$d["IdCategoriaSuperior"]} ";
      $ra = mysqli_query($nConexion,$sql);
      $dCat = mysqli_fetch_assoc( $ra );

      $vpath = $dCat["vpath"];
      if( $vpath=="/" ) $vpath="";
      $vpath="{$vpath}/{$d["txtNombre"]}";

      $sql="select * from tblti_categorias where idcategoria = {$d["IdCategoria"]} ";
      $ra = mysqli_query($nConexion,$sql);
      $dCat = mysqli_fetch_assoc( $ra );

      $sql="update tblti_categorias set vpath=replace(vpath,'{$dCat["vpath"]}','{$vpath}')
      where idcategoria_superior = {$d["IdCategoria"]}";

      $ra = mysqli_query($nConexion,$sql);
      if( !$ra){
        mysqli_query($nConexion,"rollback");
        Mensaje("Fallo actualizando categorias hijas");
        exit;
      }


      $sql="update tblti_categorias set idciudad={$_SESSION["IdCiudad"]},
      nombre='{$d["txtNombre"]}',descripcion='{$d["txtDescripcion"]}',vpath='{$vpath}',url='{$url}',idcategoria_superior={$d["IdCategoriaSuperior"]}, titulo='{$d["titulo"]}', metaDescripcion='{$d["metaDescripcion"]}', tags='$tags', palabras='$palabras' where idcategoria = {$d["IdCategoria"]}";

      $r = mysqli_query($nConexion,$sql);
	  
	  if( isset( $files["txtImagen"]["tmp_name"] ) && $files["txtImagen"]["tmp_name"]!="" ) {
			
				$NomImagen = $files["txtImagen"]["name"];
	
			  $image = new SimpleImage();
			  $image->load($files["txtImagen"]["tmp_name"]);
			  $image->resizeToWidth(600);
			  $image->save($cRutaImagenTienda . $NomImagen);
				
			  $sql="update tblti_categorias set imagen='{$NomImagen}' where idcategoria = {$d["IdCategoria"]}";
				
      $r = mysqli_query($nConexion,$sql);
	  
	  }

      if(!$r){
        mysqli_query($nConexion,"rollback");
        Mensaje( "Fallo actualizando video.".mysqli_error($nConexion), "listar_categorias.php" ) ;
        exit;
      }

      mysqli_query($nConexion,"commit");

      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "listar_categorias.php" ) ;
      exit;
    }



  } // FIN: function
  ###############################################################################

  ###############################################################################
  # Descripción   : Eliminar un registro
  # Parametros    : $nId
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CategoriasEliminar( $idCategoria )
  {
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    mysqli_query($nConexion, "DELETE FROM tblti_categorias WHERE idcategoria = $idCategoria " );

    Log_System( "TIENDA" , "ELIMINA" , "CATEGORIA: " . $idCategoria  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","listar_categorias.php" );
    exit();
  } // FIN: function
  ###############################################################################

  ###############################################################################
  # Nombre        : ContenidosFormEditar
  # Descripción   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CategoriasFormEditar( $idCategoria )
  {
    include("../../vargenerales.php");
    $nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblti_categorias where idcategoria = $idCategoria" ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
    $tags=explode(",",$Registro["tags"]);
    $palabras=explode(", ",$Registro["palabras"]);
    ?>

    <!-- Formulario Edición / Eliminación de Contenidos -->
    <form method="post" action="categorias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="IdCategoria" name="IdCategoria" value="<? echo $idCategoria ; ?>">
      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>EDITAR CATEGORIA</b></td>
        </tr>
      <tr>
        <td class="tituloNombres">Categoria Superior:</td>
        <td class="contenidoNombres" colspan="3">
        <select name="IdCategoriaSuperior">
        <?php
        $ra =mysqli_query($nConexion,"select * from tblti_categorias  where idcategoria<>{$idCategoria} order by vpath");
        while( $rax=mysqli_fetch_object($ra) ){
          ?><option value="<?=$rax->idcategoria;?>" <?=$rax->idcategoria==$Registro["idcategoria_superior"]?"selected":"";?> ><?=$rax->vpath;?></option><?
        }
        ?>
        </select>
        </td>
      </tr>

        <tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres" colspan="3"><INPUT id="txtNombre" type="text" name="txtNombre" value="<? echo $Registro["nombre"]; ?>" maxLength="200" style="width:200px; "></td>
        </tr>
      <tr>
        <td class="tituloNombres">Descripcion:</td>
        <td class="contenidoNombres" colspan="3">
            <textarea name="txtDescripcion"><? echo $Registro["descripcion"];?></textarea>
            <script>
                CKEDITOR.replace( 'txtDescripcion' );
            </script>
        </td>
      </tr>
      <tr>
        <td colspan="5" align="center" class="tituloFormulario"><b>POSICIONAMIENTO</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Título:</td>
        <td class="contenidoNombres" colspan="3"><input type="text" name="titulo" value="<?php echo $Registro["titulo"]; ?>" class="seocounter_title" maxLength="200" style="width: 823px; height: 22px"></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripción:</td>
        <td class="contenidoNombres" colspan="3">
            <textarea name="metaDescripcion" class="seocounter_meta" cols="100" rows="10"><?php echo $Registro["metaDescripcion"]?></textarea>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Tags: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select url,nombre from tbltags_palabras where tag=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="txtTags[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["url"];?>" <?=in_array($rax["url"],$tags)?"selected":"";?> ><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
        <td class="tituloNombres">Palabras Clave: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select idpalabra,nombre from tbltags_palabras where keyword=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="txtPalabras[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["nombre"];?>" <?=in_array($rax["nombre"],$palabras)?"selected":"";?> ><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
      </tr>
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres" colspan="3"><input type="file" id="txtImagen" name="txtImagen"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen Actual:</td>
          <td colspan="3">
          <?
            if ( empty($Registro["imagen"]) )
            {
              echo "No se asigno una imagen.";
            }
            else
            {
              ?><img src="<?php echo $cRutaVerImagenTienda.$Registro["imagen"]; ?>"><?
            }
          ?>
          </td>
        </tr>
        <tr>
            <td class="tituloNombres">Ver en Home:</td>
            <td class="contenidoNombres" colspan="3">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><label><input type="radio" id="home" name="home" value="1" <?php if ( $Registro["home"] == "1" ) echo "checked" ?>>Si</label></td>
                        <td width="10"></td>
                        <td><label><input type="radio" id="home" name="home" value="0" <?php if ( $Registro["home"] == "0" ) echo "checked" ?> checked>No</label></td>
                    </tr>
                </table>
          </td>
        </tr>
        <tr>
          <td colspan="4" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <?
            if ( Perfil() != "3" )
            {
            ?><a href="categorias.php?Accion=Eliminar&Id=<? echo $idCategoria; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('¿Esta seguro que desea eliminar este registro?')"></a><?
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
