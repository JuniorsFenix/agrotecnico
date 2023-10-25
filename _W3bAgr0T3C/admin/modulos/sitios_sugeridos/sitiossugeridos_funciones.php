<?
  ###############################################################################
  # noticias_funciones.php   :  Archivo de funciones modulo Sitios
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : SitiosFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function SitiosFormNuevo()
  {
?>
    <!-- Formulario Ingreso de Sitios -->
    <form method="post" action="sitiossugeridos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO SITIO</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombre Sitio:</td>
          <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloNombres">Descripci�n:</td>
          <!--<td class="contenidoNombres"><textarea rows="20" id="txtDescripcion" name="txtDescripcion" cols="80"></textarea></td>-->
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
          <td class="tituloNombres">Direcci�n Web:</td>
          <td class="contenidoNombres">http://<INPUT id="txtWeb" type="text" name="txtWeb" maxLength="255" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
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
            <a href="sitiossugeridos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : SitiosGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function SitiosGuardar( $nId,$cNombre,$cDescripcion,$cWeb,$cImagen,$cPublicar )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblsitiossugeridos ( nombre,descripcion,web,imagen,publicar,idciudad ) VALUES ( '$cNombre','$cDescripcion','$cWeb','$cImagen','$cPublicar',$IdCiudad )");
			Log_System( "SITIOS" , "NUEVO" , "SITIO: " . $cNombre );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "sitiossugeridos_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
      if ( !empty($cImagen) )
      {
        mysqli_query($nConexion, "UPDATE tblsitiossugeridos SET nombre = '$cNombre',descripcion = '$cDescripcion',web = '$cWeb',imagen='$cImagen',publicar='$cPublicar' WHERE idsitio = '$nId'" );
      }
      else
      {
        mysqli_query($nConexion, "UPDATE tblsitiossugeridos SET nombre = '$cNombre',descripcion = '$cDescripcion',web = '$cWeb',publicar='$cPublicar' WHERE idsitio = '$nId'" );
      }
      mysqli_close( $nConexion );
			Log_System( "SITIOS" , "EDITA" , "SITIO: " . $cNombre );
      Mensaje( "El registro ha sido actualizado correctamente.", "sitiossugeridos_listar.php" ) ;
      exit;
    }
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : sitiosEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function SitiosEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT nombre FROM tblsitiossugeridos WHERE idsitio ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblsitiossugeridos WHERE idsitio ='$nId'" );
    Log_System( "SITIOS" , "ELIMINA" , "SITIO: " . $reg->nombre );
		mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","sitiossugeridos_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : SitiosFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function SitiosFormEditar( $nId )
  {
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblsitiossugeridos WHERE idsitio = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Sitios -->
    <form method="post" action="sitiossugeridos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR SITIO</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombre Sitio:</td>
          <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" value="<? echo $Registro["nombre"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloNombres">Descripci�n:</td>
          <!--<td class="contenidoNombres"><textarea rows="20" id="txtDescripcion" name="txtDescripcion" cols="80"><? //echo $Registro["descripcion"]; ?></textarea></td>-->
        </tr>
			</table>
					<?
						/*$oFCKeditor = new FCKeditor('txtDescripcion') ;
						$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
						$oFCKeditor->Value = $Registro["descripcion"];
						$oFCKeditor->Create() ;
						$oFCKeditor->Width  = '100%' ;
						$oFCKeditor->Height = '400px' ;*/
					?>
                    <textarea name="txtDescripcion"><? echo $Registro["descripcion"]?></textarea>
                    <script>
                        CKEDITOR.replace( 'txtDescripcion' );
                    </script>
			<table width="100%">
        <tr>
          <td class="tituloNombres">Direcci�n Web:</td>
          <td class="contenidoNombres">http://<INPUT id="txtWeb" type="text" name="txtWeb" value="<? echo $Registro["web"]; ?>" maxLength="255"></td>
        </tr>
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
              ?><img src="<? echo $cRutaVerImgSitios . $Registro["imagen"]; ?>"><?
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
						?><a href="sitiossugeridos.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="sitiossugeridos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
