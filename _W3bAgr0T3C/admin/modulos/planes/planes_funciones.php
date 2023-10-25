<?
  ###############################################################################
  # noticias_funciones.php   :  Archivo de funciones modulo noticias
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : NoticiasFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function PlanesFormNuevo()
  {
?>
    <!-- Formulario Ingreso de Noticias -->
    <form method="post" action="planes.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO PLAN</b></td>
        </tr>
				<tr>
          <td class="tituloNombres">Sede:</td>
          <td class="contenidoNombres">
						<select name="cboSede" id="cboSede" style="width:300px;">
							<option value="1">Gran Hotel</option>
							<option value="2">Casa Dorada</option>
							<option value="3">Campestre</option>
						</select>
					</td>
				</tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloNombres">Descripci�n:</td>
          <!--<td class="contenidoNombres"><textarea rows="20" id="txtNoticia" name="txtNoticia" cols="80"></textarea></td>-->
        </tr>
			</table>
					<?
						/*$oFCKeditor = new FCKeditor('txtDescripcion') ;
						$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
						$oFCKeditor->Create() ;
						$oFCKeditor->Width  = '100%' ;
						$oFCKeditor->Height = '400' ;*/
					?>
                    <textarea name="txtDescripcion"></textarea>
                    <script>
                        CKEDITOR.replace( 'txtDescripcion' );
                    </script>
			<table width="100%">
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Vigencia:</td>
          <td class="contenidoNombres"><input type="text" name="date" id="f_date_b" readonly="yes" /><input type="reset" id="f_trigger_b" value="..."/></td>
        </tr>
			<script type="text/javascript">
					Calendar.setup({
							inputField     :    "f_date_b",      // id of the input field
							ifFormat       :    "%Y-%m-%d",       // format of the input field
							showsTime      :    true,            // will display a time selector
							button         :    "f_trigger_b",   // trigger for the calendar (button ID)
							singleClick    :    false,           // double-click mode
							step           :    1                // show all years in drop-down boxes (instead of every other year as default)
					});
			</script>

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
				<td class="contenidoNombres">
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
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="planes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  function PlanesGuardar( $nId,$cTitulo,$cImagen,$cDescripcion,$cVigencia,$cPublicar,$cSede )
  {
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblplanes ( titulo,imagen,descripcion,vigencia,publicar,sede ) VALUES ( '$cTitulo','$cImagen','$cDescripcion','$cVigencia','$cPublicar','$cSede' )");
			Log_System( "PLANES" , "NUEVO" , "TITULO: " . $cTitulo );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "planes_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
      if ( !empty($cImagen) )
      {
        mysqli_query($nConexion, "UPDATE tblplanes SET titulo = '$cTitulo',descripcion = '$cDescripcion',imagen = '$cImagen',vigencia = '$cVigencia',publicar='$cPublicar', sede='$cSede' WHERE idplan = '$nId'" );
      }
      else
      {
        mysqli_query($nConexion, "UPDATE tblplanes SET titulo = '$cTitulo',descripcion = '$cDescripcion',vigencia = '$cVigencia',publicar='$cPublicar', sede = '$cSede' WHERE idplan = '$nId'" );
      }
			Log_System( "PLANES" , "EDITA" , "TITULO: " . $cTitulo );
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "planes_listar.php" ) ;
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
  function PlanesEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT titulo FROM tblplanes WHERE idplan ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblplanes WHERE idplan ='$nId'" );
		Log_System( "PLANES" , "ELIMINA" , "TITULO: " . $reg->titular  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","planes_listar.php" );
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
  function PlanesFormEditar( $nId )
  {
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblplanes WHERE idplan = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Noticias -->
    <form method="post" action="planes.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR PLAN</b></td>
        </tr>
				<tr>
          <td class="tituloNombres">Sede:</td>
          <td class="contenidoNombres">
						<select name="cboSede" id="cboSede" style="width:300px;">
							<option value="1" <? if ( $Registro["sede"] == 1 ) { echo "selected"; } ?> >Gran Hotel</option>
							<option value="2" <? if ( $Registro["sede"] == 2 ) { echo "selected"; }  ?> >Casa Dorada</option>
							<option value="3" <? if ( $Registro["sede"] == 3 ) { echo "selected"; }  ?> >Campestre</option>
						</select>
					</td>
				</tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" value="<? echo $Registro["titulo"]; ?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloNombres">Descripcion:</td>
          <!--<td class="contenidoNombres"><textarea rows="20" id="txtNoticia" name="txtNoticia" cols="80"><? //echo $Registro["noticia"]; ?></textarea></td>-->
        </tr>
			</table>
			<?
                /*$oFCKeditor = new FCKeditor('txtDescripcion') ;
                $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
                $oFCKeditor->Value = $Registro["descripcion"];
                $oFCKeditor->Create() ;
                $oFCKeditor->Width  = '100%' ;
                $oFCKeditor->Height = '400' ;*/
            ?>
            <textarea name="txtDescripcion"><? echo $Registro["descripcion"]?></textarea>
            <script>
                CKEDITOR.replace( 'txtDescripcion' );
            </script>
			<table width="100%">
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen Actual:</td>
          <td class="contenidoNombres">
          <?
            if ( empty($Registro["imagen"]) )
            {
              echo "No se asigno una imagen.";
            }
            else
            {
              ?><img src="<? echo $cRutaVerImgPlanes . $Registro["imagen"]; ?>"><?
            }
          ?>
          </td>
        <tr>
          <td class="tituloNombres">Vigencia:</td>
          <td class="contenidoNombres"><input type="text" name="date" id="f_date_b" readonly="yes" value="<? echo $Registro["vigencia"]; ?>" /><input type="reset" id="f_trigger_b" value="..."/></td>
        </tr>
			<script type="text/javascript">
					Calendar.setup({
							inputField     :    "f_date_b",      // id of the input field
							ifFormat       :    "%Y-%m-%d",       // format of the input field
							showsTime      :    true,            // will display a time selector
							button         :    "f_trigger_b",   // trigger for the calendar (button ID)
							singleClick    :    false,           // double-click mode
							step           :    1                // show all years in drop-down boxes (instead of every other year as default)
					});
			</script>

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
				<td class="contenidoNombres">
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
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
						<?
						if ( Perfil() != "3" )
						{
						?><a href="planes.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="planes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
