<?
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo
  # Desarrollo               :  Estilo y Dise�o - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
  include("../../funciones_generales.php");
  include("../../herramientas/FCKeditor/fckeditor.php") ;
?>

<?
  ###############################################################################
  # Descripci�n   : Muestra el formulario para ingreso
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function MensajesFormNuevo()
  {
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="mensajes.php?Accion=Guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="txtIdMensaje" name="txtIdMensaje" value="0">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO CLASIFICADO</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Titulo:</td>
        <td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" maxLength="200" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Clasificado:</td>
        <td class="contenidoNombres">
			<?php
            /*$oFCKeditor = new FCKeditor('txtMensaje') ;
            $oFCKeditor->ToolbarSet="MyToolbar";
            $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
            $oFCKeditor->Width  = '100%' ;
            $oFCKeditor->Height = '200' ;
            $oFCKeditor->Create() ;*/
            ?>
            <textarea name="txtMensaje"></textarea>
            <script>
                CKEDITOR.replace( 'txtMensaje' );
            </script>
        </td>
      </tr>

      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" maxLength="200" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Correo:</td>
        <td class="contenidoNombres"><INPUT id="txtEmail" type="text" name="txtEmail" maxLength="200" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Imagen:</td>
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
  function MensajesGuardar( $idMensaje,$titulo,$mensaje,$nombre,$email,$archivo='')
  {
    $nConexion = Conectar();
    if ( $idMensaje == "0" ) // Nuevo Registro
    {
      @ $r = mysqli_query($nConexion,"INSERT INTO tblmensajes ( titulo,mensaje,nombre,email,fecha,hora,idciudad ) VALUES ( '$titulo','{$mensaje}','{$nombre}','{$email}',CURRENT_DATE,CURRENT_TIME,'{$_SESSION["IdCiudad"]}')");
      if(!$r){
        Mensaje( "Fallo almacenando mensaje.".mysqli_error($nConexion), "listar.php" ) ;
        exit;
      }

      $idMensaje = mysqli_insert_id($nConexion);
      $r = mysqli_query($nConexion,"update tblmensajes set imagen='{$idMensaje}_{$archivo["name"]}' where idmensaje = $idMensaje");

      $s = move_uploaded_file( $archivo["tmp_name"],"../../../fotos/mensajes/{$idMensaje}_{$archivo["name"]}");
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
      $r = mysqli_query($nConexion, "UPDATE tblmensajes SET titulo = '$titulo',mensaje='{$mensaje}',email='{$email}',imagen='{$idMensaje}_{$archivo["name"]}',
      idciudad='{$_SESSION["IdCiudad"]}',nombre='{$nombre}'
      WHERE idmensaje = $idMensaje" );

      if(!$r){
        Mensaje( "Fallo actualizando mensaje.".mysqli_error($nConexion), "listar.php" ) ;
        exit;
      }

      if( is_uploaded_file($archivo["tmp_name"]) ){
        $s = move_uploaded_file( $archivo["tmp_name"],"../../../fotos/mensajes/{$idMensaje}_{$archivo["name"]}");
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
  function MensajesEliminar( $idMensaje )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT idmensaje FROM tblmensajes WHERE idmensaje = $idMensaje") );
    mysqli_query($nConexion, "DELETE FROM tblmensajes WHERE idmensaje = $idMensaje " );
    unlink("../../../fotos/mensajes/{$idMensaje}_{$archivo["name"]}");

    Log_System( "MENSAJES" , "ELIMINA" , "MENSAJE: " . $reg->idmensaje  );
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
  function MensajesFormEditar( $idMensaje )
  {
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmensajes WHERE idmensaje = $idMensaje" ) ;
    mysqli_close( $nConexion ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
    ?>

    <!-- Formulario Edici�n / Eliminaci�n de Contenidos -->
    <form method="post" action="mensajes.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtIdMensaje" name="txtIdMensaje" value="<? echo $idMensaje ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CLASIFICADO</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" value="<? echo $Registro["titulo"]; ?>" maxLength="200" style="width:200px; "></td>
        </tr>
        <tr>
          <td class="tituloNombres">Clasificado:</td>
          <td class="contenidoNombres">
					<?php
                    /*$oFCKeditor = new FCKeditor('txtMensaje') ;
                    $oFCKeditor->ToolbarSet="MyToolbar";
                    $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
                    $oFCKeditor->Width  = '100%' ;
                    $oFCKeditor->Height = '200' ;
                    $oFCKeditor->Value = $Registro["mensaje"];
                    $oFCKeditor->Create() ;*/
                    ?>
                    <textarea name="txtMensaje"><? echo $Registro["mensaje"]?></textarea>
                    <script>
                        CKEDITOR.replace( 'txtMensaje' );
                    </script>

          </td>
        </tr>
      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" maxLength="200" style="width:200px; " value="<?=$Registro["nombre"];?>"></td>
      </tr>

      <tr>
        <td class="tituloNombres">Correo:</td>
        <td class="contenidoNombres"><INPUT id="txtEmail" type="text" name="txtEmail" maxLength="200" value="<?=$Registro["email"];?>" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Imagen:</td>
        <td class="contenidoNombres">
          <input type="file" name="archivo"><br/>
          <?php if( file_exists("../../../fotos/mensajes/{$Registro["imagen"]}") ):?>
            <img src="../../../fotos/mensajes/<?=$Registro["imagen"];?>">
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
            ?><a href="mensajes.php?Accion=Eliminar&Id=<? echo $idMensaje; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
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