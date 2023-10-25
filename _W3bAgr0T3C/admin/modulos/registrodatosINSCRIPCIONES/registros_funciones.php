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
                <td class="tituloNombres" >EPM:</td>
                <td class="contenidoNombres" >
				  <input checked="checked" type="radio" name="epm" value="M" />Si
				  <input type="radio" name="epm" value="F" />No
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" >Hermanos:</td>
                <td class="contenidoNombres" >
				  <input checked="checked" type="radio" name="hermanos" value="M" />Si
				  <input type="radio" name="hermanos" value="F" />No
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" >Nuevo:</td>
                <td class="contenidoNombres" >
				  <input checked="checked" type="radio" name="nuevo" value="M" />Si
				  <input type="radio" name="nuevo" value="F" />No
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Nombre Ni�o:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="nombreN" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Apellido:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="ApellidoN" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Fecha Nacimiento - (AAAA-MM-DD):</td>
                <td class="contenidoNombres" >
				  <input maxlength="30" size="30" name="nacimiento" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Edad:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="edad" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Talla:</td>
                <td class="contenidoNombres">
				  <input name="talla" size="4" maxlength="4" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > EPS:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="eps" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > E-mail Ni�o:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="mailN" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Direcci�n casa Ni�o:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="DireccionCasaN" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Barrio Ni�o:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="barrioN" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel�fono Ni�o:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="telefonoN" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Direcci�n Ni�o Opcional:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="direccionNO" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Barrio Ni�o Opcional:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="barrioNO" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel�fono Ni�o Opcional:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="telefonoNO" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Nombre Padre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="nombrePadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Apellido Padre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="apellidoPadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > C�dula Padre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="cedulaPadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > E-mail Padre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="emailPadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Empresa Padre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="empresaPadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Cargo Padre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="cargoPadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel�fono Padre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="telefonoPadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel�fono Casa Padre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="telefonoCasaPadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Celular Padre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="celularPadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Nombre Madre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="nombreMadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Apellido Madre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="apellidoMadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > C�dula Madre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="cedulaMadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > E-mail Madre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="emailMadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Empresa Madre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="empresaMadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Cargo Madre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="cargoMadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel�fono Madre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="telefonoMadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel�fono Casa Madre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="telefonoCasaMadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Celular Madre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="celularMadre" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > C�mo se enter�:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="comoEntero" />
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Observaciones:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="observaciones" />
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
	  
      mysqli_query($nConexion,"INSERT INTO tbl_datos_incripciones ( epm,hermanos,nuevo,nombreN,ApellidoN,nacimiento,edad,talla,eps,mailN,DireccionCasaN,barrioN,telefonoN,direccionNO,barrioNO,telefonoNO,nombrePadre,apellidoPadre,cedulaPadre,emailPadre,empresaPadre,cargoPadre,telefonoPadre,telefonoCasaPadre,celularPadre,nombreMadre,apellidoMadre,cedulaMadre,emailMadre,empresaMadre,cargoMadre,telefonoMadre,telefonoCasaMadre,celularMadre,comoEntero,observaciones )
				  VALUES ( '{$d["epm"]}','{$d["hermanos"]}','{$d["nuevo"]}','{$d["nombreN"]}','{$d["ApellidoN"]}','{$d["nacimiento"]}',
				  '{$d["edad"]}','{$d["talla"]}','{$d["eps"]}','{$d["mailN"]}','{$d["DireccionCasaN"]}','{$d["barrioN"]}'																							  
				  '{$d["telefonoN"]}','{$d["direccionNO"]}','{$d["barrioNO"]}','{$d["telefonoNO"]}','{$d["nombrePadre"]}'																							  
				  '{$d["apellidoPadre"]}','{$d["cedulaPadre"]}','{$d["emailPadre"]}','{$d["empresaPadre"]}','{$d["cargoPadre"]}','{$d["telefonoPadre"]}'																							  
				  '{$d["telefonoCasaPadre"]}','{$d["celularPadre"]}','{$d["nombreMadre"]}','{$d["apellidoMadre"]}','{$d["cedulaMadre"]}','{$d["emailMadre"]}'																							  
				  '{$d["empresaMadre"]}','{$d["cargoMadre"]}','{$d["telefonoMadre"]}','{$d["telefonoCasaMadre"]}','{$d["celularMadre"]}','{$d["comoEntero"]}'																							  
				  '{$d["observaciones"]}' )");
      Log_System( "REGISTRODATOS" , "NUEVO" , "REGISTRODATOS: " . $nId  );
      mysqli_close($nConexion);
      
      Mensaje( "El registro ha sido almacenado correctamente.", "registros_listar.php" );
      return;
    }
    else // Actualizar Registro Existente
    {
      $cTxtSQLUpdate = "UPDATE tbl_datos_incripciones SET epm='{$d["epm"]}',hermanos='{$d["hermanos"]}',nuevo='{$d["nuevo"]}',
						nombreN='{$d["nombreN"]}',apellidoN='{$d["ApellidoN"]}',nacimiento='{$d["nacimiento"]}',edad='{$d["edad"]}',
						talla='{$d["talla"]}',eps='{$d["eps"]}',mailN='{$d["mailN"]}',direccionCasaN='{$d["DireccionCasaN"]}',
						barrioN='{$d["barrioN"]}',telefonoN='{$d["telefonoN"]}',direccionNO='{$d["direccionNO"]}',barrioNO='{$d["barrioNO"]}',
						telefonoNO='{$d["telefonoNO"]}',nombrePadre='{$d["nombrePadre"]}',apellidoPadre='{$d["apellidoPadre"]}',cedulaPadre='{$d["cedulaPadre"]}',
						nombreMadre='{$d["nombreMadre"]}',apellidoMadre='{$d["apellidoMadre"]}',cedulaMadre='{$d["cedulaMadre"]}',emailMadre='{$d["emailMadre"]}',
						empresaMadre='{$d["empresaMadre"]}',cargoMadre='{$d["cargoMadre"]}',telefonoMadre='{$d["telefonoMadre"]}',telefonoCasaMadre='{$d["telefonoCasaMadre"]}',
						celularMadre='{$d["celularMadre"]}',comoEntero='{$d["comoEntero"]}',observaciones='{$d["observaciones"]}'
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
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT iddatos_inscripciones FROM tbl_datos_incripciones WHERE iddatos_inscripciones ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tbl_datos_incripciones WHERE iddatos_inscripciones ='$nId'" );
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
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tbl_datos_incripciones WHERE iddatos_inscripciones = '$nId'" );
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
                <td class="tituloNombres" >EPM:</td>
                <td class="contenidoNombres" >
				  <input <?=$Registro["epm"]=="M"?"checked='checked'":"";?> type="radio" name="epm" value="si" />Si
				  <input <?=$Registro["epm"]=="F"?"checked='checked'":"";?> type="radio" name="epm" value="no" />No
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" >Hermanos:</td>
                <td class="contenidoNombres" >
				  <input <?=$Registro["hermanos"]=="M"?"checked='checked'":"";?> type="radio" name="hermanos" value="si" />Si
				  <input <?=$Registro["hermanos"]=="F"?"checked='checked'":"";?> type="radio" name="hermanos" value="no" />No
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" >Nuevo:</td>
                <td class="contenidoNombres" >
				  <input <?=$Registro["nuevo"]=="M"?"checked='checked'":"";?> type="radio" name="nuevo" value="si" />Si
				  <input <?=$Registro["nuevo"]=="F"?"checked='checked'":"";?> type="radio" name="nuevo" value="no" />No
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Nombre Ni�o:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="nombreN" value="<?=$Registro["nombreN"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Apellido:</td>
                <td class="contenidoNombres" >
				  <input maxlength="100" size="50" name="ApellidoN" value="<?=$Registro["ApellidoN"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Fecha Nacimiento - (AAAA-MM-DD):</td>
                <td class="contenidoNombres" >
				  <input maxlength="30" size="30" name="nacimiento" value="<?=$Registro["nacimiento"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Edad:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="edad" value="<?=$Registro["edad"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Talla:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="talla" value="<?=$Registro["talla"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > EPS:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="eps" value="<?=$Registro["eps"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > E-mail:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="mailN" value="<?=$Registro["mailN"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Direcci�n:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="DireccionCasaN" value="<?=$Registro["DireccionCasaN"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Barrio:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="barrioN" value="<?=$Registro["barrioN"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel�fono:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="telefonoN" value="<?=$Registro["telefonoN"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Direcci�n Opcional:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="direccionNO" value="<?=$Registro["direccionNO"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Barrio Opcional:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="barrioNO" value="<?=$Registro["barrioNO"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel�fono Opcional:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="telefonoNO" value="<?=$Registro["telefonoNO"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Direcci�n Opcional:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="direccionNO" value="<?=$Registro["direccionNO"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Barrio Opcional:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="barrioNO" value="<?=$Registro["barrioNO"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel�fono Opcional:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="telefonoNO" value="<?=$Registro["telefonoNO"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Nombre Padre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="nombrePadre" value="<?=$Registro["nombrePadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Apellido:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="apellidoPadre" value="<?=$Registro["apellidoPadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > C�dula:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="cedulaPadre" value="<?=$Registro["cedulaPadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > E-mail:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="emailPadre" value="<?=$Registro["emailPadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Empresa:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="empresaPadre" value="<?=$Registro["empresaPadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Cargo:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="cargoPadre" value="<?=$Registro["cargoPadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel�fono:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="telefonoPadre" value="<?=$Registro["telefonoPadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel�fono Casa:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="telefonoCasaPadre" value="<?=$Registro["telefonoCasaPadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Celular:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="celularPadre" value="<?=$Registro["celularPadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Nombre Madre:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="nombreMadre" value="<?=$Registro["nombreMadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Apellidos:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="apellidoMadre" value="<?=$Registro["apellidoMadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > C�dula:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="cedulaMadre" value="<?=$Registro["cedulaMadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > E-mail:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="emailMadre" value="<?=$Registro["emailMadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Empresa:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="empresaMadre" value="<?=$Registro["empresaMadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Cargo:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="cargoMadre" value="<?=$Registro["cargoMadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel�fono:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="telefonoMadre" value="<?=$Registro["telefonoMadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Tel�fono Casa:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="telefonoCasaMadre" value="<?=$Registro["telefonoCasaMadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Celular:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="celularMadre" value="<?=$Registro["celularMadre"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > �Por qu� medio se entero?:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="comoEntero" value="<?=$Registro["comoEntero"]?>"/>
				</td>
            </tr>
            <tr>
                <td class="tituloNombres" > Observaciones:</td>
                <td class="contenidoNombres">
				  <input maxlength="50" name="observaciones" value="<?=$Registro["observaciones"]?>"/>
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
