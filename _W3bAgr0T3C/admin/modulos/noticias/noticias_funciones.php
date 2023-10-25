<?
  ###############################################################################
  # noticias_funciones.php   :  Archivo de funciones modulo noticias
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
	include("../../funciones_generales.php");
	include("../../vargenerales.php");
	include("../../herramientas/upload/SimpleImage.php");
  ###############################################################################
  # Nombre        : NoticiasFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function NoticiasFormNuevo()
  {
    $nConexion = Conectar();
?>
    <!-- Formulario Ingreso de Noticias -->
    <form method="post" action="noticias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA NOTICIA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titular:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtTitular" type="text" name="txtTitular" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloNombres">Noticia:</td>
          <!--<td class="contenidoNombres" colspan="5"><textarea rows="20" id="txtNoticia" name="txtNoticia" cols="80"></textarea></td>-->
        </tr>
        </table>
                <textarea name="txtNoticia"></textarea>
                <script>
                    CKEDITOR.replace( 'txtNoticia' );
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
          <td class="contenidoNombres" colspan="5"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
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
            <a href="noticias_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : NoticiasGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function NoticiasGuardar( $nId,$cTitular,$cNoticia,$cFuente,$cTags,$cPalabras,$cImagen,$cPublicar )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
	setlocale(LC_ALL, 'es_ES.iso88591');
    $url = slug($cTitular);
	if (!empty($cTags)){
	$tags = implode(',', $cTags);
	}
	if (!empty($cPalabras)){
	$palabras = implode(', ', $cPalabras);
	}
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblnoticias ( titular,url,noticia,imagen,fuente,tags,palabras,fechapub,publicar,idciudad ) VALUES ( '$cTitular','$url','$cNoticia','$cImagen','$cFuente','$tags','$palabras',Now(),'$cPublicar',$IdCiudad )");
			Log_System( "NOTICIAS" , "NUEVO" , "TITULAR: " . $cTitular );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "noticias_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
      if ( !empty($cImagen) )
      {
        mysqli_query($nConexion, "UPDATE tblnoticias SET titular = '$cTitular',url = '$url',noticia = '$cNoticia',imagen = '$cImagen',fuente = '$cFuente',tags = '$tags',palabras = '$palabras',publicar='$cPublicar' WHERE idnoticia = '$nId'" );
      }
      else
      {
        mysqli_query($nConexion, "UPDATE tblnoticias SET titular = '$cTitular',url = '$url',noticia = '$cNoticia',fuente = '$cFuente',tags = '$tags',palabras = '$palabras',publicar='$cPublicar' WHERE idnoticia = '$nId'" );
      }
			Log_System( "NOTICIAS" , "EDITA" , "TITULAR: " . $cTitular );
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "noticias_listar.php" ) ;
      exit;
    }
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : NoticiasEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function NoticiasEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT titular FROM tblnoticias WHERE idnoticia ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblnoticias WHERE idnoticia ='$nId'" );
		Log_System( "NOTICIAS" , "ELIMINA" , "TITULAR: " . $reg->titular  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","noticias_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : NoticiasFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function NoticiasFormEditar( $nId )
  {
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblnoticias WHERE idnoticia = '$nId'" ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
    $tags=explode(",",$Registro["tags"]);
    $palabras=explode(", ",$Registro["palabras"]);
?>
    <!-- Formulario Edici�n / Eliminaci�n de Noticias -->
    <form method="post" action="noticias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>EDITAR NOTICIAS</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titular:</td>
          <td class="contenidoNombres" colspan="2"><INPUT id="txtTitular" type="text" name="txtTitular" value="<? echo $Registro["titular"]; ?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloNombres">Noticia:</td>
          <!--<td class="contenidoNombres" colspan="5"><textarea rows="20" id="txtNoticia" name="txtNoticia" cols="80"><? //echo $Registro["noticia"]; ?></textarea></td>-->
        </tr>
        </table>
            <textarea name="txtNoticia"><? echo $Registro["noticia"]?></textarea>
            <script>
                CKEDITOR.replace( 'txtNoticia' );
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
              ?><img src="<? echo $cRutaVerImgNoticias . $Registro["imagen"]; ?>"><?
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
						?><a href="noticias.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="noticias_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
