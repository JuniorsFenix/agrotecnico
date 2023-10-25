<?
  ###############################################################################
  # noticias_funciones.php   :  Archivo de funciones modulo Eventos
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
  function EventosFormNuevo()
  {
	  
    $nConexion = Conectar();
?>
    <!-- Formulario Ingreso de Eventos -->
    <form method="post" action="eventos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO GLOSARIO</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo Glosario:</td>
          <td class="contenidoNombres"><INPUT id="txtEvento" type="text" name="txtEvento" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloNombres">Descripci�n Glosario:</td>
          <!--<td class="contenidoNombres" colspan="5"><textarea rows="20" id="txtDetalle" name="txtDetalle" cols="80"></textarea></td>-->
        </tr>
        </table>
            <textarea name="txtDetalle"></textarea>
            <script>
                CKEDITOR.replace( 'txtDetalle' );
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
          <td class="tituloNombres">Fecha/Hora Inicio:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtFechaHoraIni" type="text" name="txtFechaHoraIni" maxLength="100">&nbsp;Ejemplo: 01 Enero 2005 - 10:30 AM</td>
        </tr>
        <tr>
          <td class="tituloNombres">Pais:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtPais" type="text" name="txtPais" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Ciudad:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtCiudad" type="text" name="txtCiudad" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
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
            <a href="eventos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : EventosGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function EventosGuardar( $nId,$cEvento,$cDetalle,$cFechaHoraIni,$cPais,$cCiudad,$cFuente,$cTags,$cPalabras,$cImagen,$cPublicar )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
	setlocale(LC_ALL, 'en_US.UTF8');
    $url = slug($cEvento);
	if (!empty($cTags)){
	$tags = implode(',', $cTags);
	}
	if (!empty($cPalabras)){
	$palabras = implode(', ', $cPalabras);
	}
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tbleventos ( evento,url,detalle,fechahoraini,pais,ciudad,fuente,tags,palabras,imagen,publicar,idciudad ) VALUES ( '$cEvento','$url','$cDetalle','$cFechaHoraIni','$cPais','$cCiudad','$cFuente','$tags','$palabras','$cImagen','$cPublicar',$IdCiudad )");
			Log_System( "EVENTOS" , "NUEVO" , "EVENTO: " . $cEvento  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "eventos_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
      if ( !empty($cImagen) )
      {
        mysqli_query($nConexion, "UPDATE tbleventos SET evento = '$cEvento',url = '$url',detalle = '$cDetalle',fechahoraini = '$cFechaHoraIni',pais = '$cPais',ciudad='$cCiudad',fuente='$cFuente',tags = '$tags',palabras = '$palabras',imagen='$cImagen',publicar='$cPublicar' WHERE idevento = '$nId'" );
				Log_System( "EVENTOS" , "EDITA" , "EVENTO: " . $cEvento  );
      }
      else
      {
        mysqli_query($nConexion, "UPDATE tbleventos SET evento = '$cEvento',url = '$url',detalle = '$cDetalle',fechahoraini = '$cFechaHoraIni',pais = '$cPais',ciudad='$cCiudad',fuente='$cFuente',tags = '$tags',palabras = '$palabras',publicar='$cPublicar' WHERE idevento = '$nId'" );
				Log_System( "EVENTOS" , "EDITA" , "EVENTO: " . $cEvento  );
      }
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "eventos_listar.php" ) ;
      exit;
    }
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : EventosEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function EventosEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT evento FROM tbleventos WHERE idevento ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tbleventos WHERE idevento ='$nId'" );
		Log_System( "EVENTOS" , "ELIMINA" , "EVENTO: " . $reg->evento  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","eventos_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : EventosFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function EventosFormEditar( $nId )
  {
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tbleventos WHERE idevento = '$nId'" ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
    $tags=explode(",",$Registro["tags"]);
    $palabras=explode(", ",$Registro["palabras"]);
?>
    <!-- Formulario Edici�n / Eliminaci�n de Eventos -->
    <form method="post" action="eventos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR GLOSARIO</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo Glosario:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtEvento" type="text" name="txtEvento" value="<? echo $Registro["evento"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloNombres">Descripci�n Glosario:</td>
          <!--<td class="contenidoNombres" colspan="5"><textarea rows="20" id="txtDetalle" name="txtDetalle" cols="80"><? //echo $Registro["detalle"]; ?></textarea></td>-->
        </tr>
        </table>
            <textarea name="txtDetalle"><? echo $Registro["detalle"]?></textarea>
            <script>
                CKEDITOR.replace( 'txtDetalle' );
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
          <td class="tituloNombres">Fecha/Hora Inicio:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtFechaHoraIni" type="text" name="txtFechaHoraIni" value="<? echo $Registro["fechahoraini"]; ?>" maxLength="100">&nbsp;Ejemplo: 01 Enero 2005 - 10:30 AM</td>
        </tr>
        <tr>
          <td class="tituloNombres">Pais:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtPais" type="text" name="txtPais" value="<? echo $Registro["pais"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Ciudad:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtCiudad" type="text" name="txtCiudad" value="<? echo $Registro["ciudad"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
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
              ?><img src="<? echo $cRutaVerImgEventos . $Registro["imagen"]; ?>"><?
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
						?><a href="eventos.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="eventos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
