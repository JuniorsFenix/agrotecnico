<?
  ###############################################################################
  # Desarrollo               :  Estilo y Dise�o
  # Web                      :  http://www.esidi.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Descripci�n   : Muestra el formulario para ingreso de registros nuevos
  # Parametros    : Ninguno.
  # Retorno       : Ninguno
  ###############################################################################
  function BoletinesFormNuevo()
  {
	include ("../../vargenerales.php");
?>
    <!-- Formulario Ingreso -->
    <form method="post" action="boletines.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO BOLETIN</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Fecha:</td>
          <td class="contenidoNombres"><input type="text" name="date" id="f_date_b" readonly="yes" /> <input type="image" src="../../image/calendario16x16.png" id="f_trigger_b"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Plantilla:</td>
          <td class="contenidoNombres">
					<select name="cboPlantilla" id="cboPlantilla">
					<?
					$d = dir($cRutaPlantillas_GenBoletines);
					while (false !== ($entrada = $d->read())) {
						if ( ( $entrada !== "." ) and ( $entrada !== ".." ) and ( $entrada !== "funciones.php" ) )
						{
							echo "<option value=\"$entrada\">$entrada</option>\n";
						}
					}
					$d->close();
					?>
					</select>
					</td>
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
        <tr>
          <td colspan="2" class="tituloNombres">Encabezado de Pagina</td>
        </tr>
			</table>
					<?
						/*$oFCKeditor = new FCKeditor('txtEncabezado') ;
						$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
						$oFCKeditor->Create() ;
						$oFCKeditor->Width  = '100%' ;
						$oFCKeditor->Height = '400' ;*/
					?>
                    <textarea name="txtEncabezado"></textarea>
                    <script>
                        CKEDITOR.replace( 'txtEncabezado' );
                    </script>
			<table width="100%">
        <tr>
          <td colspan="2" class="tituloNombres">Pie de Pagina</td>
        </tr>
			</table>
					<?
						/*$oFCKeditor = new FCKeditor('txtPie') ;
						$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
						$oFCKeditor->Create() ;
						$oFCKeditor->Width  = '100%' ;
						$oFCKeditor->Height = '400' ;*/
					?>
                    <textarea name="txtPie"></textarea>
                    <script>
                        CKEDITOR.replace( 'txtPie' );
                    </script>
			<table width="100%">
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="boletines_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : BoletinesGuardar
  ###############################################################################
  function BoletinesGuardar( $nId,$cTitulo,$Fecha,$cEnc,$cPie, $cboPlantilla )
  {
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblboletines ( titulo,fecha,encabezado,piepagina,template ) VALUES ( '$cTitulo','$Fecha','$cEnc','$cPie' , '$cboPlantilla' )");
			Log_System( "BOLETINES" , "NUEVO" , "TITULO: " . $cTitulo );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "boletines_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
			mysqli_query($nConexion, "UPDATE tblboletines SET titulo = '$cTitulo',fecha = '$Fecha',encabezado = '$cEnc',piepagina = '$cPie',template='$cboPlantilla' WHERE idboletin = '$nId'" );
			Log_System( "BOLETINES" , "EDITA" , "TITULO: " . $cTitulo );
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "boletines_listar.php" ) ;
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
  function BoletinesEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT titulo FROM tblboletines WHERE idboletin ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblboletines WHERE idboletin ='$nId'" );
		mysqli_query($nConexion, "DELETE FROM tblboletines_blo WHERE idboletin ='$nId'" );
		Log_System( "BOLETINES" , "ELIMINA" , "TITULO: " . $reg->titulo  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","boletines_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : BoletinesFormEditar
  ###############################################################################
  function BoletinesFormEditar( $nId )
  {
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblboletines WHERE idboletin = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Noticias -->
    <form method="post" action="boletines.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR BOLETIN</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" value="<? echo $Registro["titulo"]; ?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Fecha:</td>
          <td class="contenidoNombres"><input type="text" name="date" id="f_date_b" readonly="yes" value="<? echo $Registro["fecha"]; ?>" /> <input type="image" src="../../image/calendario16x16.png" id="f_trigger_b"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Plantilla:</td>
          <td class="contenidoNombres">
					<select name="cboPlantilla" id="cboPlantilla">
					<?
					$d = dir($cRutaPlantillas_GenBoletines);
					while (false !== ($entrada = $d->read())) {
						if ( ( $entrada !== "." ) and ( $entrada !== ".." ) and ( $entrada !== "funciones.php" ) )
						{
							if ( $Registro["template"] == $entrada ){
								echo "<option value=\"$entrada\" selected>$entrada</option>\n";
							}else{
							echo "<option value=\"$entrada\">$entrada</option>\n";
							}
						}
					}
					$d->close();
					?>
					</select>
					</td>
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
        <tr>
          <td colspan="2" class="tituloNombres">Encabezado de Pagina</td>
        </tr>
			</table>
					<?
						/*$oFCKeditor = new FCKeditor('txtEncabezado') ;
						$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
						$oFCKeditor->Value = $Registro["encabezado"];
						$oFCKeditor->Create() ;
						$oFCKeditor->Width  = '100%' ;
						$oFCKeditor->Height = '400' ;*/
					?>
                    <textarea name="txtEncabezado"><? echo $Registro["encabezado"]?></textarea>
                    <script>
                        CKEDITOR.replace( 'txtEncabezado' );
                    </script>
			<table width="100%">
        <tr>
          <td colspan="2" class="tituloNombres">Pie de Pagina</td>
        </tr>
			</table>
					<?
						/*$oFCKeditor = new FCKeditor('txtPie') ;
						$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
						$oFCKeditor->Value = $Registro["piepagina"];
						$oFCKeditor->Create() ;
						$oFCKeditor->Width  = '100%' ;
						$oFCKeditor->Height = '400' ;*/
					?>
                    <textarea name="txtPie"><? echo $Registro["piepagina"]?></textarea>
                    <script>
                        CKEDITOR.replace( 'txtPie' );
                    </script>
			<table width="100%">
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
						<?
						if ( Perfil() != "3" )
						{
						?><a href="boletines.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="boletines_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
