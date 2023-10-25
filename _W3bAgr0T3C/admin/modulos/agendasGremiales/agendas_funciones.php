<?
  ###############################################################################
  # agendas_funciones.php   :  Archivo de funciones modulo agendas
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
	include("../../funciones_generales.php");
	include("../../vargenerales.php");
	include("../../herramientas/upload/SimpleImage.php");
  ###############################################################################
  # Nombre        : AgendasFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function AgendasFormNuevo()
  {
    $nConexion = Conectar();
?>
    <!-- Formulario Ingreso de Agendas -->
    <form method="post" action="agendas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA AGENDA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloNombres">Descripcion:</td>
          <!--<td class="contenidoNombres" colspan="5"><textarea rows="20" id="txtDescripcion" name="txtDescripcion" cols="80"></textarea></td>-->
        </tr>
        </table>
                <textarea name="txtDescripcion"></textarea>
                <script>
                    CKEDITOR.replace( 'txtDescripcion' );
                </script>
        <table width="100%">
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
        <?php endwhile;
    mysqli_close( $nConexion ) ?>
        </select>
        </td>
      </tr>
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres" colspan="5"><input type="file" id="txtImagen" name="txtImagen"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Fuente:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtFuente" type="text" name="txtFuente" maxLength="255" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
			<?
			if ( Perfil() == "3" )
			{
			?><input type="hidden" name="optPublicar" id="optPublicar" value="N"><?
			}
			else
			{
			?>
			<tr>
				<td class="tituloNombres">Publicar:</td>
				<td class="contenidoNombres" colspan="5">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="S">Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="N" checked>No</label></td>
						</tr>
					</table>
			  </td>
			</tr>
			<?
			}
			?>
        <tr>
          <td colspan="4" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="agendas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  }
  ###############################################################################

  ###############################################################################
  # Nombre        : AgendasGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function AgendasGuardar( $nId,$cNombre,$cDescripcion,$cFuente,$cTags,$cPalabras,$files,$cPublicar )
  {
	include("../../vargenerales.php");
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
	setlocale(LC_ALL, 'en_US.UTF8');
    $url = slug($cNombre);
	if (!empty($cTags)){
	$tags = implode(',', $cTags);
	}
	if (!empty($cPalabras)){
	$palabras = implode(', ', $cPalabras);
	}
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblagendas ( nombre,url,descripcion,fuente,tags,palabras,fechapub,publicar,idciudad ) VALUES ( '$cNombre','$url','$cDescripcion','$cFuente','$tags','$palabras',Now(),'$cPublicar',$IdCiudad )");
      $nId = mysqli_insert_id($nConexion);
			Log_System( "AGENDAS" , "NUEVO" , "TITULAR: " . $cNombre );
			    
			if( isset( $files["txtImagen"]["tmp_name"] ) && $files["txtImagen"]["tmp_name"]!="" ) {
			
				$NomImagenG = $nId . "_" . $files["txtImagen"]["name"];
				$NomImagenM = "m_" . $nId . "_" . $files["txtImagen"]["name"];
	
			  $image = new SimpleImage();
			  $image->load($files["txtImagen"]["tmp_name"]);
			  $image->resizeToWidth(900);
			  $image->save($cRutaImgAgendas . $NomImagenG);
			  $image->resizeToWidth(500);
			  $image->save($cRutaImgAgendas . $NomImagenM);
				
				$sql="UPDATE tblagendas SET imagen = '{$NomImagenG}' where idagenda ='$nId'";

      $r = mysqli_query($nConexion,$sql);

      
      if(!$r){
        Mensaje( "Fallo actualizando imagenes.".mysqli_error($nConexion), "agendas_listar.php" ) ;
        exit;
      }

				}
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "agendas_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
        mysqli_query($nConexion, "UPDATE tblagendas SET nombre = '$cNombre',url = '$url',descripcion = '$cDescripcion',fuente = '$cFuente',tags = '$tags',palabras = '$palabras',publicar='$cPublicar' WHERE idagenda = '$nId'" );
			Log_System( "AGENDAS" , "EDITA" , "TITULAR: " . $cNombre );
			
			if( isset( $files["txtImagen"]["tmp_name"] ) && $files["txtImagen"]["tmp_name"]!="" ) {
			
				$NomImagenG = $nId . "_" . $files["txtImagen"]["name"];
				$NomImagenM = "m_" . $nId . "_" . $files["txtImagen"]["name"];
	
			  $image = new SimpleImage();
			  $image->load($files["txtImagen"]["tmp_name"]);
			  $image->resizeToWidth(900);
			  $image->save($cRutaImgAgendas . $NomImagenG);
			  $image->resizeToWidth(500);
			  $image->save($cRutaImgAgendas . $NomImagenM);
				
				$sql="UPDATE tblagendas SET imagen = '{$NomImagenG}' where idagenda ='$nId'";

      $r = mysqli_query($nConexion,$sql);

      
      if(!$r){
        Mensaje( "Fallo actualizando imagenes.".mysqli_error($nConexion), "agendas_listar.php" ) ;
        exit;
      }

				}
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "agendas_listar.php" ) ;
      exit;
    }
  } // FIN: function 
  ###############################################################################

  ###############################################################################
  # Nombre        : AgendasEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function AgendasEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT nombre FROM tblagendas WHERE idagenda ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblagendas WHERE idagenda ='$nId'" );
		Log_System( "AGENDAS" , "ELIMINA" , "TITULAR: " . $reg->nombre  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","agendas_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################

  ###############################################################################
  # Nombre        : AgendasFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function AgendasFormEditar( $nId )
  {
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblagendas WHERE idagenda = '$nId'" ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
    $tags=explode(",",$Registro["tags"]);
    $palabras=explode(", ",$Registro["palabras"]);
?>
    <!-- Formulario Edici�n / Eliminaci�n de Agendas -->
    <form method="post" action="agendas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>EDITAR AGENDA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" value="<? echo $Registro["nombre"]; ?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloNombres">Descripcion:</td>
          <!--<td class="contenidoNombres" colspan="5"><textarea rows="20" id="txtDescripcion" name="txtDescripcion" cols="80"><? //echo $Registro["descripcion"]; ?></textarea></td>-->
        </tr>
        </table>
            <textarea name="txtDescripcion"><? echo $Registro["descripcion"]?></textarea>
            <script>
                CKEDITOR.replace( 'txtDescripcion' );
            </script>
        <table width="100%">
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
        <?php endwhile;
    mysqli_close( $nConexion ) ;?>
        </select>
        </td>
      </tr>
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres" colspan="5"><input type="file" id="txtImagen" name="txtImagen"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen Actual:</td>
          <td class="contenidoNombres" colspan="5">
          <?
            if ( empty($Registro["imagen"]) )
            {
              echo "No se asigno una imagen.";
            }
            else
            {
              ?><img src="<? echo $cRutaVerImgAgendas ."m_". $Registro["imagen"]; ?>" width="500"><?
            }
          ?>
          </td>
        <tr>
          <td class="tituloNombres">Fuente:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtFuente" type="text" name="txtFuente" value="<? echo $Registro["fuente"]; ?>" maxLength="255" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        </tr>
			<?
			if ( Perfil() == "3" )
			{
			?><input type="hidden" name="optPublicar" id="optPublicar" value="<? echo $Registro["publicar"] ?>"><?
			}
			else
			{
			?>
			<tr>
				<td class="tituloNombres">Publicar:</td>
				<td class="contenidoNombres" colspan="5">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="S" <? if ( $Registro["publicar"] == "S" ) echo "checked" ?>>Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="N" <? if ( $Registro["publicar"] == "N" ) echo "checked" ?>>No</label></td>
						</tr>
					</table>
			  </td>
			</tr>
			<?
			}
			?>
        <tr>
          <td colspan="4" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
						<?
						if ( Perfil() != "3" )
						{
						?><a href="agendas.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="agendas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
