<?php include("../../funciones_generales.php");
//include("../../../php/funciones_public.php");
?>
<?php
$nConexion = Conectar();
$sql = "SELECT * FROM tbltipohabitacion ORDER BY descripcion";
$ra = mysqli_query($nConexion,$sql);
if ( !$ra ) {
  Mensaje("Error consultando tipo habitaci�n","reservas_listar.php");
}
$tipo_habitacion = $ra;

$sql = "SELECT * FROM tbltiporeserva ORDER BY descripcion";
$ra = mysqli_query($nConexion,$sql);
if ( !$ra ) {
  Mensaje("Error consultando tipo resreva","reservas_listar.php");
}
$tipo_reserva = $ra;

$sql = "SELECT * FROM tblempresacubre ORDER BY descripcion";
$ra = mysqli_query($nConexion,$sql);
if ( !$ra ) {
  Mensaje("Error consultando especificaciones empresa cubre","reservas_listar.php");
}
$empresa_cubre = $ra;

  function ReservasFormNuevo()
  {
    global $tipo_reserva;
    global $tipo_habitacion;
    global $empresa_cubre;
?>
    <!-- Formulario Ingreso de Eventos -->
    <form method="post" action="reservas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA RESERVA</b></td>
        </tr>

	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Nombres:</td>
	    <td class="formulario3"><input name="nombres_reservasG" size="32" gtbfieldid="9" /> </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Apellidos:</td>
	    <td class="formulario3"><input name="apellidos_reservasG" size="32" gtbfieldid="10" /> </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Fecha de entrada:</td>
	    <td class="formulario3">
	      <input type="text" id="f_fechaIn_reservasG_b" name="fechaIn_reservasG" readonly="yes" gtbfieldid="11" />
	      <input type="reset" id="f_trigger_fechaIn_reservasG_b" value="..."/>
	    </td>
	</tr>
	<script type="text/javascript">
	  Calendar.setup({
	    inputField     :    "f_fechaIn_reservasG_b",      // id of the input field
	    ifFormat       :    "%Y-%m-%d",       // format of the input field
	    showsTime      :    true,            // will display a time selector
	    button         :    "f_trigger_fechaIn_reservasG_b",   // trigger for the calendar (button ID)
	    singleClick    :    false,           // double-click mode
	    step           :    1                // show all years in drop-down boxes (instead of every other year as default)
	  });
	</script>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Fecha de salida:</td>
	    <td class="formulario3">
	      <input type="text" id="f_fechaOut_reservasG_b" name="fechaOut_reservasG" readonly="yes" gtbfieldid="12" />
	      <input type="reset" id="f_trigger_fechaOut_reservasG_b" value="..."/>
	    </td>
	</tr>
	<script type="text/javascript">
	  Calendar.setup({
	    inputField     :    "f_fechaOut_reservasG_b",      // id of the input field
	    ifFormat       :    "%Y-%m-%d",       // format of the input field
	    showsTime      :    true,            // will display a time selector
	    button         :    "f_trigger_fechaOut_reservasG_b",   // trigger for the calendar (button ID)
	    singleClick    :    false,           // double-click mode
	    step           :    1                // show all years in drop-down boxes (instead of every other year as default)
	  });
	</script>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Tipo Reserva:</td>

	    <td class="formulario3"><select name="tipoReserva_reservasG" id="tipoReserva_reservasG" gtbfieldid="13">
	    <?php while ($row = mysqli_fetch_assoc($tipo_reserva)):?>
	    <option value="<?=$row["idtiporeserva"];?>"><?=$row["descripcion"];?></option>
	    <?php endwhile;?>
	    </select> </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">Procedencia:</td>
	    <td class="formulario3"><input name="procedencia_reservasG" size="32" gtbfieldid="14" /> </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Habitaci&oacute;n, si desea varias<br />
	    habitaciones por favor<br />
	    coloque las especificaciones<br />
	    en OBSERVACIONES<br />
	    las que falten fuera de &eacute;sta:</td>
	    <td class="formulario3"><select name="habitacion_reservasG" id="habitacion_reservasG" gtbfieldid="15">
	    <?php while ($row = mysqli_fetch_assoc($tipo_habitacion)):?>
	    <option value="<?=$row["idtipohabitacion"];?>"><?=$row["descripcion"];?></option>
	    <?php endwhile;?>
	    </select> <br />
	    </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Numero de Habitaciones:</td>
	    <td class="formulario3"><input name="numeroHabitaciones_reservasG" size="3" gtbfieldid="16" /> </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">Facturar A:</td>
	    <td class="formulario3"><input name="facturar_reservasG" size="32" gtbfieldid="17" /> </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">Ninos:</td>
	    <td class="formulario3"><input name="ninos_reservasG" size="32" gtbfieldid="18" /></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Adultos:</td>
	    <td class="formulario3"><input name="adultos_reservasG" size="32" gtbfieldid="19" /></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Solicitante:</td>
	    <td class="formulario3"><input name="solicitante_reservasG" size="32" gtbfieldid="20" /></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Tel&eacute;fono:</td>
	    <td class="formulario3"><input name="telefono_reservasG" size="32" gtbfieldid="21" /></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Ciudad:</td>
	    <td class="formulario3"><input name="ciudad_reservasG" size="32" gtbfieldid="22" /></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Direcci&oacute;n:</td>
	    <td class="formulario3"><input name="direccion_reservasG" size="32" gtbfieldid="23" /></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">La empresa cubre:</td>
	    <td class="formulario3"><select name="cubre_reservasG" id="cubre_reservasG" gtbfieldid="15">
                <?php 
                while ($row = mysqli_fetch_assoc($empresa_cubre)):?>
                <option value="<?=$row["idempresacubre"];?>"><?=$row["descripcion"];?></option>
                <?php endwhile;?>
                </select> </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">Email:</td>
	    <td class="formulario3"><input name="email_reservasG" size="32" gtbfieldid="24" /></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">Observaci&oacute;n:</td>
	    <td class="formulario3"><textarea name="observacion_reservasG" cols="32" rows="10"></textarea></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" colspan="2"><strong>* Datos Requeridos</strong></td>
	</tr>

        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="reservas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  }
  ###############################################################################
?>
<?

function ReservasGuardar( $d )
  {
    $nId = $d["txtId"];
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      $sql = "INSERT INTO tblreservas(nombres,apellidos,fecha_entrada,fecha_salida,idtiporeserva,procedencia,idtipohabitacion,
	      numero_habitaciones,facturar_a,ninos,adultos,solicitante,telefono,ciudad,direccion,idempresacubre,
	      correo_electronico,observacion)
	      VALUES('{$d['nombres_reservasG']}','{$d['apellidos_reservasG']}','{$d['fechaIn_reservasG']}','{$d['fechaOut_reservasG']}',
	      '{$d['tipoReserva_reservasG']}','{$d['procedencia_reservasG']}','{$d['habitacion_reservasG']}',{$d['numeroHabitaciones_reservasG']},
	      '{$d['facturar_reservasG']}','{$d['ninos_reservasG']}','{$d['adultos_reservasG']}','{$d['solicitante_reservasG']}',
	      '{$d['telefono_reservasG']}','{$d['ciudad_reservasG']}','{$d['direccion_reservasG']}','{$d['cubre_reservasG']}',
	      '{$d['email_reservasG']}','{$d['observacion_reservasG']}')";
      mysqli_query($nConexion,$sql);
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "reservas_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
      $sql = "UPDATE tblreservas SET nombres='{$d['nombres_reservasG']}',apellidos='{$d['apellidos_reservasG']}',fecha_entrada='{$d['fechaIn_reservasG']}',
	      fecha_salida='{$d['fechaOut_reservasG']}',idtiporeserva='{$d['tipoReserva_reservasG']}',procedencia='{$d['procedencia_reservasG']}',idtipohabitacion='{$d['habitacion_reservasG']}',
	      numero_habitaciones={$d['numeroHabitaciones_reservasG']},facturar_a='{$d['facturar_reservasG']}',ninos='{$d['ninos_reservasG']}',
	      adultos='{$d['adultos_reservasG']}',solicitante='{$d['solicitante_reservasG']}',telefono='{$d['telefono_reservasG']}',ciudad='{$d['ciudad_reservasG']}',
	      direccion='{$d['direccion_reservasG']}',idempresacubre='{$d['cubre_reservasG']}',correo_electronico='{$d['email_reservasG']}',observacion='{$d['observacion_reservasG']}'
	      WHERE idreserva = {$nId}";
      mysqli_query($nConexion, $sql );
      Log_System( "RESERVAS" , "EDITA" , "RESERVA: " . $nId );
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "reservas_listar.php" ) ;
      exit();
    }
  } // FIN: function 
  ###############################################################################
?>
<?

  function ReservasEliminar( $nId )
  {
    $nConexion = Conectar();
    $sql = "DELETE FROM tblreservas WHERE idreserva={$nId}";
    $ra = mysqli_query($nConexion,$sql);
    if ( !$ra ) {
      Mensaje("Error eliminando reserva","reservas_listar.php");
      exit();
    }
    Log_System( "RESERVAS" , "ELIMINA" , "RESERVA: " . $nId  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","reservas_listar.php" );
    exit();
  } 

?>
<?
  function ReservasFormEditar( $nId )
  {
    include("../../vargenerales.php");
    $nConexion = Conectar();
    $sql = "SELECT * FROM tblreservas WHERE idreserva = $nId";
    $Resultado = mysqli_query($nConexion, $sql ) ;
    mysqli_close( $nConexion ) ;

    $Registro = mysqli_fetch_array( $Resultado );
    global $tipo_reserva;
    global $tipo_habitacion;
    global $empresa_cubre;
?>
    <!-- Formulario Edici�n / Eliminaci�n de Eventos -->
    <form method="post" action="reservas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<?=$nId;?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR RESERVA</b></td>
        </tr>

	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Nombres:</td>
	    <td class="formulario3"><input name="nombres_reservasG" size="32" gtbfieldid="9" value="<?=$Registro['nombres']?>"/> </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Apellidos:</td>
	    <td class="formulario3"><input name="apellidos_reservasG" size="32" gtbfieldid="10" value="<?=$Registro['apellidos']?>"/> </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Fecha de entrada:</td>
	    <td class="formulario3">
	      <input type="text" id="f_fechaIn_reservasG_b" name="fechaInreservasG" readonly="yes" gtbfieldid="11" value="<?=$Registro['fecha_entrada']?>" />
	      <input type="reset" id="f_trigger_fechaIn_reservasG_b" value="..."/>
	    </td>
	</tr>
	<script type="text/javascript">
	  Calendar.setup({
	    inputField     :    "f_fechaIn_reservasG_b",      // id of the input field
	    ifFormat       :    "%Y-%m-%d",       // format of the input field
	    showsTime      :    true,            // will display a time selector
	    button         :    "f_trigger_fechaIn_reservasG_b",   // trigger for the calendar (button ID)
	    singleClick    :    false,           // double-click mode
	    step           :    1                // show all years in drop-down boxes (instead of every other year as default)
	  });
	</script>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Fecha de salida:</td>
	    <td class="formulario3">
	      <input type="text" id="f_fechaOut_reservasG_b" name="fechaOut_reservasG" readonly="yes" gtbfieldid="12" value="<?=$Registro['fecha_salida']?>" />
	      <input type="reset" id="f_trigger_fechaOut_reservasG_b" value="..."/>
	    </td>
	</tr>
	<script type="text/javascript">
	  Calendar.setup({
	    inputField     :    "f_fechaOut_reservasG_b",      // id of the input field
	    ifFormat       :    "%Y-%m-%d",       // format of the input field
	    showsTime      :    true,            // will display a time selector
	    button         :    "f_trigger_fechaOut_reservasG_b",   // trigger for the calendar (button ID)
	    singleClick    :    false,           // double-click mode
	    step           :    1                // show all years in drop-down boxes (instead of every other year as default)
	  });
	</script>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Tipo Reserva:</td>

	    <td class="formulario3"><select name="tipoReserva_reservasG" id="tipoReserva_reservasG" gtbfieldid="13">
	    <?php while ($row = mysqli_fetch_assoc($tipo_reserva)):?>
	    <option value="<?=$row["idtiporeserva"];?>" <?=$Registro['idtiporeserva']==$row['idtiporeserva']?"selected":""?>><?=$row["descripcion"];?></option>
	    <?php endwhile;?>
	    </select> </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">Procedencia:</td>
	    <td class="formulario3"><input name="procedencia_reservasG" size="32" gtbfieldid="14" value="<?=$Registro['procedencia']?>"/> </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Habitaci&oacute;n, si desea varias<br />
	    habitaciones por favor<br />
	    coloque las especificaciones<br />
	    en OBSERVACIONES<br />
	    las que falten fuera de &eacute;sta:</td>
	    <td class="formulario3"><select name="habitacion_reservasG" id="habitacion_reservasG" gtbfieldid="15">
	    <?php while ($row = mysqli_fetch_assoc($tipo_habitacion)):?>
	    <option value="<?=$row["idtipohabitacion"];?>" <?=$Registro['idtipohabitacion']==$row['idtipohabitacion']?"selected":"";?>><?=$row["descripcion"];?></option>
	    <?php endwhile;?>
	    </select> <br />
	    </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Numero de Habitaciones:</td>
	    <td class="formulario3"><input name="numeroHabitaciones_reservasG" size="3" gtbfieldid="16" value="<?=$Registro['numero_habitaciones']?>"/> </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">Facturar A:</td>
	    <td class="formulario3"><input name="facturar_reservasG" size="32" gtbfieldid="17" value="<?=$Registro['facturar_a']?>"/> </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">Ninos:</td>
	    <td class="formulario3"><input name="ninos_reservasG" size="32" gtbfieldid="18" value="<?=$Registro['ninos']?>"/></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Adultos:</td>
	    <td class="formulario3"><input name="adultos_reservasG" size="32" gtbfieldid="19" value="<?=$Registro['adultos']?>"/></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Solicitante:</td>
	    <td class="formulario3"><input name="solicitante_reservasG" size="32" gtbfieldid="20" value="<?=$Registro['solicitante']?>"/></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Tel&eacute;fono:</td>
	    <td class="formulario3"><input name="telefono_reservasG" size="32" gtbfieldid="21" value="<?=$Registro['telefono']?>"/></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Ciudad:</td>
	    <td class="formulario3"><input name="ciudad_reservasG" size="32" gtbfieldid="22" value="<?=$Registro['ciudad']?>"/></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">* Direcci&oacute;n:</td>
	    <td class="formulario3"><input name="direccion_reservasG" size="32" gtbfieldid="23" value="<?=$Registro['direccion']?>"/></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">La empresa cubre:</td>
	    <td class="formulario3"><select name="cubre_reservasG" id="cubre_reservasG" gtbfieldid="15">
                <?php while ($row = mysqli_fetch_assoc($empresa_cubre)):?>
                <option value="<?=$row["idempresacubre"];?>" <?=$Registro['idempresacubre']==$row["idempresacubre"]?"selected":"";?>><?=$row["descripcion"];?></option>
                <?php endwhile;?>
                </select> 
	      </td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">Email:</td>
	    <td class="formulario3"><input name="email_reservasG" size="32" gtbfieldid="24" value="<?=$Registro['correo_electronico']?>"/></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" class="formulario2">Observaci&oacute;n:</td>
	    <td class="formulario3"><textarea name="observacion_reservasG" cols="32" rows="10" ><?=$Registro['observacion']?></textarea></td>
	</tr>
	<tr valign="baseline">
	    <td nowrap="nowrap" align="right" colspan="2"><strong>* Datos Requeridos</strong></td>
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
	    ?><a href="reservas.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
	    }
	    ?>
            <a href="reservas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
