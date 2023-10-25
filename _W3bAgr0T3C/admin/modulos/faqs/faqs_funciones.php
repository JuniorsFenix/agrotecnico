<?
  ###############################################################################
  # noticias_funciones.php   :  Archivo de funciones modulo faqs
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : FaqsFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function FaqsFormNuevo()
  {
?>
    <!-- Formulario Ingreso de Noticias -->
    <form method="post" action="faqs.php?Accion=Guardar">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table>
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA FAQS</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Pregunta:</td>
          <td class="contenidoNombres"><textarea rows="12" id="txtPregunta" name="txtPregunta" cols="62"></textarea></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta:</td>
          <td class="contenidoNombres"><textarea rows="12" id="txtRespuesta" name="txtRespuesta" cols="62"></textarea></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
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
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="faqs_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : FaqsGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function FaqsGuardar( $nId,$cPregunta,$cRespuesta,$cPublicar )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblfaq ( pregunta,respuesta,publicar,idciudad ) VALUES ( '$cPregunta','$cRespuesta','$cPublicar', $IdCiudad )");
			Log_System( "FAQS" , "NUEVO" , "FAQS: " . substr($cPregunta,0,190)  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "faqs_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
    	mysqli_query($nConexion, "UPDATE tblfaq SET pregunta = '$cPregunta',respuesta = '$cRespuesta',publicar='$cPublicar' WHERE idfaq = '$nId'" );
			Log_System( "FAQS" , "EDITA" , "FAQS: " . substr($cPregunta,0,190)  );
		}
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "faqs_listar.php" ) ;
      exit;
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : FaqsEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function FaqsEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT pregunta FROM tblfaq WHERE idfaq ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblfaq WHERE idfaq ='$nId'" );
		Log_System( "FAQS" , "ELIMINA" , "FAQS: " . $reg->pregunta  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","faqs_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : FaqsFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function FaqsFormEditar( $nId )
  {
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblfaq WHERE idfaq = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Faqs -->
    <form method="post" action="faqs.php?Accion=Guardar">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table>
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR FAQS</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Pregunta:</td>
					<td class="contenidoNombres"><textarea rows="12" id="txtPregunta" name="txtPregunta" cols="62"><? echo $Registro["pregunta"]; ?></textarea></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta:</td>
					<td class="contenidoNombres"><textarea rows="12" id="txtRespuesta" name="txtRespuesta" cols="62"><? echo $Registro["respuesta"]; ?></textarea></td>
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
						?><a href="faqs.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="faqs_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
