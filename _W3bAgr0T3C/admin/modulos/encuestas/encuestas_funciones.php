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
  # Nombre        : EncuestasFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de encuestas nuevas
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function EncuestasFormNuevo()
  {
?>
    <!-- Formulario Ingreso de Noticias -->
    <form method="post" action="encuestas.php?Accion=Guardar">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table>
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA ENCUESTA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombre Encuesta:</td>
          <td class="contenidoNombres"><input name="txtnombre" type="text" id="txtnombre" size="50" maxlength="50"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Pregunta:</td>
          <td class="contenidoNombres"><input name="txtpregunta" type="text" id="txtpregunta" size="80" maxlength="150"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Activar Encuesta: </td>
          <td class="contenidoNombres">
						<table>
            	<tr>
              	<td><label><input type="radio" name="optActivar" value="S">Si</label></td>
								<td>&nbsp;</td>
								<td><label><input type="radio" name="optActivar" value="N">No</label></td>
            	</tr>
          	</table>
					</td>
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
          <td class="tituloNombres">Respuesta 1: </td>
          <td class="contenidoNombres"><input name="txtrespuesta01" type="text" id="txtrespuesta01" size="50" maxlength="100"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 2: </td>
          <td class="contenidoNombres"><input name="txtrespuesta02" type="text" id="txtrespuesta02" size="50" maxlength="100"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 3: </td>
          <td class="contenidoNombres"><input name="txtrespuesta03" type="text" id="txtrespuesta03" size="50" maxlength="100"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 4: </td>
          <td class="contenidoNombres"><input name="txtrespuesta04" type="text" id="txtrespuesta04" size="50" maxlength="100"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 5: </td>
          <td class="contenidoNombres"><input name="txtrespuesta05" type="text" id="txtrespuesta05" size="50" maxlength="100"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 6: </td>
          <td class="contenidoNombres"><input name="txtrespuesta06" type="text" id="txtrespuesta06" size="50" maxlength="100"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 7: </td>
          <td class="contenidoNombres"><input name="txtrespuesta07" type="text" id="txtrespuesta07" size="50" maxlength="100"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 8: </td>
          <td class="contenidoNombres"><input name="txtrespuesta08" type="text" id="txtrespuesta08" size="50" maxlength="100"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 9: </td>
          <td class="contenidoNombres"><input name="txtrespuesta09" type="text" id="txtrespuesta09" size="50" maxlength="100"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 10: </td>
          <td class="contenidoNombres"><input name="txtrespuesta10" type="text" id="txtrespuesta10" size="50" maxlength="100"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="encuestas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : EncuestasGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function EncuestasGuardar( $nId,$cNombre,$cPregunta,$cActivar,$cRespuesta1,$cRespuesta2,$cRespuesta3,$cRespuesta4,$cRespuesta5,$cRespuesta6,$cRespuesta7,$cRespuesta8,$cRespuesta9,$cRespuesta10,$cPublicar )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblencuestas ( nombre,activa,pregunta,respuesta1,respuesta2,respuesta3,respuesta4,respuesta5,respuesta6,respuesta7,respuesta8,respuesta9,respuesta10,publicar,idciudad ) VALUES ( '$cNombre','$cActivar','$cPregunta','$cRespuesta1','$cRespuesta2','$cRespuesta3','$cRespuesta4','$cRespuesta5','$cRespuesta6','$cRespuesta7','$cRespuesta8','$cRespuesta9','$cRespuesta10','$cPublicar',$IdCiudad )");
			Log_System( "ENCUESTAS" , "NUEVO" , "ENCUESTA: " . $cNombre );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "encuestas_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
    	mysqli_query($nConexion, "UPDATE tblencuestas SET nombre = '$cNombre',activa = '$cActivar',pregunta = '$cPregunta',respuesta1 = '$cRespuesta1',respuesta2 = '$cRespuesta2',respuesta3 = '$cRespuesta3',respuesta4 = '$cRespuesta4',respuesta5 = '$cRespuesta5',respuesta6 = '$cRespuesta6',respuesta7 = '$cRespuesta7',respuesta8 = '$cRespuesta8',respuesta9 = '$cRespuesta9',respuesta10  = '$cRespuesta10',publicar='$cPublicar' WHERE idencuesta = '$nId'" );
			Log_System( "ENCUESTAS" , "EDITA" , "ENCUESTA: " . $cNombre );
		}
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "encuestas_listar.php" ) ;
      exit;
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : EncuestasEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function EncuestasEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT nombre FROM tblencuestas WHERE idencuesta ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblencuestas WHERE idencuesta ='$nId'" );
		Log_System( "ENCUESTAS" , "ELIMINA" , "ENCUESTA: " . $reg->nombre  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","encuestas_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : EncuestasFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function EncuestasFormEditar( $nId )
  {
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblencuestas WHERE idencuesta = '$nId'" ) ;
    mysqli_close( $nConexion ) ;
    $Registro     = mysqli_fetch_object( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Faqs -->
    <form method="post" action="encuestas.php?Accion=Guardar">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table>
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR ENCUESTA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombre Encuesta:</td>
          <td class="contenidoNombres"><input name="txtnombre" type="text" id="txtnombre" size="50" maxlength="50" value="<? echo $Registro->nombre; ?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Pregunta:</td>
          <td class="contenidoNombres"><input name="txtpregunta" type="text" id="txtpregunta" size="80" maxlength="150" value="<? echo $Registro->pregunta; ?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Activar Encuesta: </td>
          <td class="contenidoNombres">
						<table>
            	<tr>
              	<td><label><input type="radio" name="optActivar" value="S" <? if ( $Registro->activa == "S" ) { echo "checked"; }  ?>>Si</label></td>
								<td>&nbsp;</td>
								<td><label><input type="radio" name="optActivar" value="N" <? if ( $Registro->activa == "N" ) { echo "checked"; }  ?>>No</label></td>
            	</tr>
          	</table>
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
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="S" <? if ( $Registro->publicar == "S" ) echo "checked" ?>>Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="N" <? if ( $Registro->publicar == "N" ) echo "checked" ?>>No</label></td>
						</tr>
					</table>
			  </td>
			</tr>
			<?
			}
			?>

        <tr>
          <td class="tituloNombres">Respuesta 1: </td>
          <td class="contenidoNombres"><input name="txtrespuesta01" type="text" id="txtrespuesta01" size="50" maxlength="100" value="<? echo $Registro->respuesta1; ?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 2: </td>
          <td class="contenidoNombres"><input name="txtrespuesta02" type="text" id="txtrespuesta02" size="50" maxlength="100" value="<? echo $Registro->respuesta2; ?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 3: </td>
          <td class="contenidoNombres"><input name="txtrespuesta03" type="text" id="txtrespuesta03" size="50" maxlength="100" value="<? echo $Registro->respuesta3; ?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 4: </td>
          <td class="contenidoNombres"><input name="txtrespuesta04" type="text" id="txtrespuesta04" size="50" maxlength="100" value="<? echo $Registro->respuesta4; ?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 5: </td>
          <td class="contenidoNombres"><input name="txtrespuesta05" type="text" id="txtrespuesta05" size="50" maxlength="100" value="<? echo $Registro->respuesta5; ?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 6: </td>
          <td class="contenidoNombres"><input name="txtrespuesta06" type="text" id="txtrespuesta06" size="50" maxlength="100" value="<? echo $Registro->respuesta6; ?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 7: </td>
          <td class="contenidoNombres"><input name="txtrespuesta07" type="text" id="txtrespuesta07" size="50" maxlength="100" value="<? echo $Registro->respuesta7; ?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 8: </td>
          <td class="contenidoNombres"><input name="txtrespuesta08" type="text" id="txtrespuesta08" size="50" maxlength="100" value="<? echo $Registro->respuesta8; ?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 9: </td>
          <td class="contenidoNombres"><input name="txtrespuesta09" type="text" id="txtrespuesta09" size="50" maxlength="100" value="<? echo $Registro->respuesta9; ?>"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Respuesta 10: </td>
          <td class="contenidoNombres"><input name="txtrespuesta10" type="text" id="txtrespuesta10" size="50" maxlength="100" value="<? echo $Registro->respuesta10; ?>"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
						<?
						if ( Perfil() != "3" )
						{
						?><a href="encuestas.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
						<a href="encuestas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
