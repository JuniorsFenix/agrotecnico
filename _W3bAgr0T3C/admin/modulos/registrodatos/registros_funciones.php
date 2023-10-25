<? include("../../funciones_generales.php"); ?>
<?
function RegistrosFormNuevo() {
  $IdCiudad = $_SESSION["IdCiudad"];
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="registros.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      
	<table width="100%">
        <tbody>
            <tr>
			  <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO REGISTRO</b></td>
			</tr>
            <tr>
                <td class="tituloNombres" >Nombres:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="nombres" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" >Apellidos:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="apellidos" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" >Direcci&oacute;n:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="direccion" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel&eacute;fono:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="telefono" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Mail:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="mail" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Fecha Nacimiento - (AAAA-MM-DD):</td>
                <td class="contenidoNombres" >
				  <input maxlength="30" size="30" name="nacimiento" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Profesi&oacute;n:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="profesion" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Sexo:</td>
                <td class="contenidoNombres">
				  <input checked="checked" type="radio" name="sexo" value="M" />Masculino
				  <input type="radio" name="sexo" value="F" />Femenino
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Ciudad:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="ciudad" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Barrio:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="barrio" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Comentarios:</td>
                <td class="contenidoNombres">
				  <textarea name="comentarios" cols="60" rows="8"></textarea>
				</td>
            </tr>
        </tbody>
    </table>
	
	
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="registros.php?action=Guardar"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################
?>
<?php
function RegistrosGuardar( $nId,$d ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
	  //iddatos,nombres,apellidos,direccion,telefono,mail,nacimiento,profesion,sexo,ciudad,barrio
	  
      mysqli_query($nConexion,"INSERT INTO tbl_datos ( nombres,apellidos,direccion,telefono,mail,nacimiento,profesion,sexo,ciudad,barrio,comentarios )
				  VALUES ( '{$d["nombres"]}','{$d["apellidos"]}','{$d["direccion"]}','{$d["telefono"]}','{$d["mail"]}','{$d["nacimiento"]}',
				  '{$d["profesion"]}','{$d["sexo"]}','{$d["ciudad"]}','{$d["barrio"]}','{$d["comentarios"]}' )");
      Log_System( "REGISTRODATOS" , "NUEVO" , "REGISTRODATOS: " . $nId  );
      mysqli_close($nConexion);
      
      Mensaje( "El registro ha sido almacenado correctamente.", "registros_listar.php" );
      return;
    }
    else // Actualizar Registro Existente
    {
      $cTxtSQLUpdate = "UPDATE tbl_datos SET nombres='{$d["nombres"]}',apellidos='{$d["apellidos"]}',direccion='{$d["direccion"]}',
						telefono='{$d["telefono"]}',mail='{$d["mail"]}',nacimiento='{$d["nacimiento"]}',profesion='{$d["profesion"]}',
						sexo='{$d["sexo"]}',ciudad='{$d["ciudad"]}',barrio='{$d["barrio"]}',comentarios='{$d["comentarios"]}' 
						WHERE iddatos = '$nId'";
						
      mysqli_query($nConexion,$cTxtSQLUpdate  );
      Log_System( "REGISTRADATOS" , "EDITA" , "REGISTRADATOS: " . $nId );
      mysqli_close( $nConexion );

      Mensaje( "El registro ha sido actualizado correctamente.", "registros_listar.php" );
      return;
    }
} // FIN: function UsuariosGuardar

?>
<?php
function RegistrosEliminar( $nId ) {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT iddatos FROM tbl_datos WHERE iddatos ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tbl_datos WHERE iddatos ='$nId'" );
    Log_System( "REGISTRADATOS" , "ELIMINA" , "REGISTRADATOS: " . $reg->iddatos  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","registros_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?php
function RegistrosFormEditar( $nId )
  {
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tbl_datos WHERE iddatos = '$nId'" );
    mysqli_close( $nConexion );

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="registros.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      
	  <table width="100%">
        <tbody>
            <tr>
			  <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO REGISTRO</b></td>
			</tr>
            <tr>
                <td class="tituloNombres" >Nombres:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="nombres" value="<?=$Registro["nombres"]?>" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" >Apellidos:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="apellidos" value="<?=$Registro["apellidos"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" >Direcci&oacute;n:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="direccion" value="<?=$Registro["direccion"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel&eacute;fono:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="telefono" value="<?=$Registro["telefono"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Mail:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="mail" value="<?=$Registro["mail"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Fecha Nacimiento - (AAAA-MM-DD):</td>
                <td class="contenidoNombres" >
				  <input maxlength="30" size="30" name="nacimiento" value="<?=$Registro["nacimiento"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Profesi&oacute;n:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="profesion" value="<?=$Registro["profesion"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Sexo:</td>
                <td class="contenidoNombres">
				  <input <?=$Registro["sexo"]=="M"?"checked='checked'":"";?> type="radio" name="sexo" value="M" />Masculino
				  <input <?=$Registro["sexo"]=="F"?"checked='checked'":"";?> type="radio" name="sexo" value="F" />Femenino
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Ciudad:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="ciudad" value="<?=$Registro["ciudad"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Barrio:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="barrio" value="<?=$Registro["barrio"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Comentarios:</td>
                <td class="contenidoNombres">
				  <textarea name="comentarios" cols="60" rows="8" value="<?=$Registro["comentarios"]?>"><?=$Registro["comentarios"]?></textarea>
				</td>
            </tr>
			<tr>
			  <td colspan="2" class="tituloFormulario">&nbsp;</td>
			</tr>
			<tr>
			  <td colspan="2" class="nuevo">
				<input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
				<a href="registros.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
				<a href="registros_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
			  </td>
			</tr>
        </tbody>
    </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
