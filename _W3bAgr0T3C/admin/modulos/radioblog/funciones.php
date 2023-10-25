<?
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
?>

<?
  ###############################################################################
  # Descripci�n   : Muestra el formulario para ingreso
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function MusicaFormNuevo()
  {
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="musica.php?Accion=Guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="txtIdMusica" name="txtIdMusica" value="0">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO MP3</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" maxLength="200" style="width:200px; "></td>
      </tr>
        <tr>
          <td class="tituloNombres">Pa�s:</td>
          <td class="contenidoNombres">
            <INPUT id="txtPais" type="text" name="txtPais" maxLength="200" style="width:200px; "></td>
        </tr>
        <tr>
          <td class="tituloNombres">Ciudad:</td>
          <td class="contenidoNombres">
            <INPUT id="txtCiudad" type="text" name="txtCiudad" maxLength="200" style="width:200px; "></td>
        </tr>
        <tr>
          <td class="tituloNombres">Artista:</td>
          <td class="contenidoNombres">
            <INPUT id="txtArtista" type="text" name="txtArtista" maxLength="200" style="width:200px; "></td>
        </tr>
        <tr>
          <td class="tituloNombres">Genero:</td>
          <td class="contenidoNombres">
            <INPUT id="txtGenero" type="text" name="txtGenero" maxLength="200" style="width:200px; "></td>
        </tr>

      <tr>
        <td class="tituloNombres">Duraci�n:</td>
        <td class="contenidoNombres"><INPUT id="txtDuracion" type="text" name="txtDuracion" maxLength="200" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Archivo mp3:</td>
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
          <a href="listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  function MusicaGuardar( $idMusica,$nombre,$pais,$ciudad,$artista,$genero,$duracion,$archivo='')
  {
    //creo el directorio si no existe
    if( !is_dir("../../../fotos/radioblog") ){
      mkdir("../../../fotos/radioblog");
    }

    $nConexion = Conectar();
    if ( $idMusica == "0" ) // Nuevo Registro
    {
      @ $r = mysqli_query($nConexion,"INSERT INTO tblradioblog (nombre,pais,ciudad,artista,genero,duracion,idciudad ) VALUES
      ( '$nombre','{$pais}','{$ciudad}','{$artista}','{$genero}','{$duracion}','{$_SESSION["IdCiudad"]}')");
      if(!$r){
        Mensaje( "Fallo almacenando mp3.".mysqli_error($nConexion), "listar.php" ) ;
        exit;
      }

      $idMusica = mysqli_insert_id($nConexion);
      $s = move_uploaded_file( $archivo["tmp_name"],"../../../fotos/radioblog/{$idMusica}.mp3");
      if(!$s){
        Mensaje( "Fallo cargando archivo.", "listar.php" ) ;
        exit;
      }

      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
      $r = mysqli_query($nConexion, "UPDATE tblradioblog SET nombre = '$nombre',pais='{$pais}',ciudad='{$ciudad}',artista='{$artista}',genero='{$genero}',duracion='{$duracion}',
      idciudad='{$_SESSION["IdCiudad"]}'
      WHERE idmusica = $idMusica" );

      if(!$r){
        Mensaje( "Fallo actualizando musica.".mysqli_error($nConexion), "listar.php" ) ;
        exit;
      }

      if( is_uploaded_file($archivo["tmp_name"]) ){
        $s = move_uploaded_file( $archivo["tmp_name"],"../../../fotos/radioblog/{$idMusica}.mp3");
        if(!$s){
          Mensaje( "Fallo cargando archivo.", "listar.php" ) ;
          exit;
        }
      }


      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "listar.php" ) ;
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
  function MusicaEliminar( $idMusica )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT idmusica FROM tblradioblog WHERE idmusica = $idMusica") );
    mysqli_query($nConexion, "DELETE FROM tblradioblog WHERE idmusica = $idMusica " );
    unlink("../../../fotos/radioblog/{$idMusica}.mp3");

    Log_System( "MUSICA" , "ELIMINA" , "MUSICA: " . $reg->idmusica  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","listar.php" );
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
  function MusicaFormEditar( $idMusica )
  {
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblradioblog WHERE idmusica = $idMusica" ) ;
    mysqli_close( $nConexion ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Contenidos -->
    <form method="post" action="musica.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtIdMusica" name="txtIdMusica" value="<? echo $idMusica ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR MP3</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" value="<? echo $Registro["nombre"]; ?>" maxLength="200" style="width:200px; "></td>
        </tr>
        <tr>
          <td class="tituloNombres">Pa�s:</td>
          <td class="contenidoNombres">
            <INPUT id="txtPais" type="text" name="txtPais" maxLength="200" style="width:200px; " value="<?=$Registro["pais"];?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Ciudad:</td>
          <td class="contenidoNombres">
            <INPUT id="txtCiudad" type="text" name="txtCiudad" maxLength="200" style="width:200px; " value="<?=$Registro["ciudad"];?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Artista:</td>
          <td class="contenidoNombres">
            <INPUT id="txtArtista" type="text" name="txtArtista" maxLength="200" style="width:200px; " value="<?=$Registro["artista"];?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Genero:</td>
          <td class="contenidoNombres">
            <INPUT id="txtGenero" type="text" name="txtGenero" maxLength="200" style="width:200px; " value="<?=$Registro["genero"];?>"></td>
        </tr>

      <tr>
        <td class="tituloNombres">Duraci�n:</td>
        <td class="contenidoNombres">
          <INPUT id="txtDuracion" type="text" name="txtDuracion" maxLength="200" style="width:200px; " value="<?=$Registro["duracion"];?>">
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Archivo mp3:</td>
        <td class="contenidoNombres">
          <input type="file" name="archivo"><br/>
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
            ?><a href="musica.php?Accion=Eliminar&Id=<? echo $idMusica; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
            }
            ?>
            <a href="listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
    <?
    mysqli_free_result( $Resultado );
  }
  ###############################################################################
  ?>