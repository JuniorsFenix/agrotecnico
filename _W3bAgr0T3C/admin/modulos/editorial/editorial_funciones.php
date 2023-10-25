<?
  ###############################################################################
  # noticias_funciones.php   :  Archivo de funciones modulo Editorial
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
	include("../../funciones_generales.php");
	include("../../vargenerales.php");
	include("../../herramientas/upload/SimpleImage.php");
  ###############################################################################
  # Nombre        : EditorialFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function EditorialFormNuevo()
  {
    $nConexion = Conectar();
?>
    <!-- Formulario Ingreso de Editorial -->
    <form method="post" action="editorial.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>NUEVO INFORMACI�N</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres" colspan="2"><INPUT id="txtTitulo" type="text" name="txtTitulo" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
		</table>
            <textarea name="txtEditorial"></textarea>
            <script>
                CKEDITOR.replace( 'txtEditorial' );
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
          <td class="tituloNombres">Creditos:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtCreditos" type="text" name="txtCreditos" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Fuente:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtFuente" type="text" name="txtFuente" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres" colspan="5"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
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
            <a href="editorial_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : EditorialGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function EditorialGuardar( $nId,$cTitulo,$cContenido,$cCreditos,$cFuente,$cTags,$cPalabras,$cImagen,$cPublicar )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
	setlocale(LC_ALL, 'en_US.UTF8');
    $url = slug($cTitulo);
	if (!empty($cTags)){
	$tags = implode(',', $cTags);
	}
	if (!empty($cPalabras)){
	$palabras = implode(', ', $cPalabras);
	}
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tbleditorial ( titulo,url,contenido,creditos,fuente,tags,palabras,imagen,fechapub,publicar,idciudad ) VALUES ( '$cTitulo','$url','$cContenido','$cCreditos','$cFuente','$tags','$palabras','$cImagen',Now(),'$cPublicar',$IdCiudad )");
			Log_System( "EDITORIAL" , "NUEVO" , "TITULO: " . $cTitulo  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "editorial_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
      if ( !empty($cImagen) )
      {
        mysqli_query($nConexion, "UPDATE tbleditorial SET titulo = '$cTitulo',url = '$url',contenido = '$cContenido',creditos = '$cCreditos',fuente = '$cFuente',tags = '$tags',palabras = '$palabras',imagen = '$cImagen', publicar='$cPublicar' WHERE ideditorial = '$nId'" );
				Log_System( "EDITORIAL" , "EDITA" , "TITULO: " . $cTitulo  );
      }
      else
      {
        mysqli_query($nConexion, "UPDATE tbleditorial SET titulo = '$cTitulo',url = '$url',contenido = '$cContenido',creditos = '$cCreditos',fuente = '$cFuente',tags = '$cTags',palabras = '$cPalabras',publicar='$cPublicar' WHERE ideditorial = '$nId'" );
				Log_System( "EDITORIAL" , "EDITA" , "TITULO: " . $cTitulo  );
      }
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "editorial_listar.php" ) ;
      exit;
    }
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : EditorialEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function EditorialEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT titulo FROM tbleditorial WHERE ideditorial ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tbleditorial WHERE ideditorial ='$nId'" );
		Log_System( "EDITORIAL" , "ELIMINA" , "TITULO: " . $reg->titulo  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","editorial_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : EditorialFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function EditorialFormEditar( $nId )
  {
	include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tbleditorial WHERE ideditorial = '$nId'" ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
    $tags=explode(",",$Registro["tags"]);
    $palabras=explode(", ",$Registro["palabras"]);
?>
    <!-- Formulario Edici�n / Eliminaci�n de Editorial -->
    <form method="post" action="editorial.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>EDITAR INFORMACI�N</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres" colspan="2"><INPUT id="txtTitulo" type="text" name="txtTitulo" value="<? echo $Registro["titulo"]; ?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        </table>
            <textarea name="txtEditorial"><? echo $Registro["contenido"]?></textarea>
            <script>
                CKEDITOR.replace( 'txtEditorial' );
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
          <td class="tituloNombres">Creditos:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtCreditos" type="text" name="txtCreditos" value="<? echo $Registro["creditos"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Fuente:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtFuente" type="text" name="txtFuente" value="<? echo $Registro["fuente"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres" colspan="5"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
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
              ?><img src="<? echo $cRutaVerImgEditorial . $Registro["imagen"]; ?>"><?
            }
          ?>
          </td>
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
						?><a href="editorial.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="editorial_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
