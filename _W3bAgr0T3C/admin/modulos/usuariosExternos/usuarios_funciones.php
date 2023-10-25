<? include("../../funciones_generales.php"); 
  ###############################################################################
  # Nombre        : NoticiasFormNuevo
  # Descripción   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function UsuariosFormNuevo()
	{
	?>
	<!-- Formulario Ingreso de Contenidos -->
	<form method="post" action="usuarios.php?Accion=Guardar" enctype="multipart/form-data">
		<input TYPE="hidden" id="txtId" name="txtId" value="0">
		<table width="100%">
			<tr>
				<td colspan="2" align="center" class="tituloFormulario"><b>NUEVO USUARIO</b></td>
			</tr>
			<tr>
				<td class="tituloNombres">Nombre:</td>
				<td class="contenidoNombres"><INPUT id="nombre" type="text" name="nombre" maxLength="150" required></td>
			</tr>
			<tr>
				<td class="tituloNombres">C&eacute;dula:</td>
				<td class="contenidoNombres"><INPUT id="cedula" type="text" name="cedula" maxLength="150"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Correo:</td>
				<td class="contenidoNombres"><INPUT id="correo" type="text" name="correo" maxLength="150" required></td>
			</tr>
			<tr>
				<td class="tituloNombres">Ciudad:</td>
				<td class="contenidoNombres"><INPUT id="ciudad" type="text" name="ciudad" maxLength="150"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Dirección:</td>
				<td class="contenidoNombres"><input id="direccion" type="text" name="direccion"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Tel&eacute;fono:</td>
				<td class="contenidoNombres"><INPUT id="telefono" type="text" name="telefono" maxLength="150"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Contraseña:</td>
				<td class="contenidoNombres"><INPUT id="clave" type="password" name="clave" required></td>
			</tr>
			<tr>
				<td class="tituloNombres">Confirmar contraseña:</td>
				<td class="contenidoNombres"><INPUT id="clave2" type="password" name="clave2" required> <span id='mensaje'></span></td>
			</tr>
              <tr>
                <td class="tituloNombres">Activar cotizador:</td>
                <td class="contenidoNombres" colspan="5">
                <select name="cotizacion">
                    <option value="1" >SI</option>
                    <option value="0" >NO</option>
                </select>
                </td>
              </tr>
			<tr>
				<td colspan="2" class="tituloFormulario">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="nuevo">
					<input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
					<a href="usuarios_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
				</td>
			</tr>
		</table>
	</form>
	<?
	}
###############################################################################


function UsuariosGuardar($d) {
  $nConexion = Conectar();
	
	function generate_password( $length = 6 ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$password = substr( str_shuffle( $chars ), 0, $length );
	return $password;
	}
    
	if ( $d["txtId"] == "0" ) // Nuevo Registro
	{
    $clave = hash("sha256",$d["clave"]);
		$sql = "INSERT INTO tblusuarios_externos (nombre,clave,cedula,correo_electronico,ciudad,direccion,telefono,cotizacion) VALUES
		('{$d["nombre"]}','{$clave}','{$d["cedula"]}','{$d["correo"]}','{$d["ciudad"]}','{$d["direccion"]}','{$d["telefono"]}','{$d["cotizacion"]}')";
	mysqli_query($nConexion,$sql);
		$d["txtId"] = mysqli_insert_id($nConexion);
		Log_System( "USUARIOSEXTERNOS" , "NUEVO" , "USUARIO: " . $d["txtId"] );
		mysqli_close( $nConexion );

		Mensaje( "El registro ha sido creado correctamente.", "usuarios_listar.php" );
		return;
	}
	else // Actualizar Registro Existente
	{
		$sql = "UPDATE tblusuarios_externos SET nombre='{$d["nombre"]}',cedula='{$d["cedula"]}',correo_electronico='{$d["correo"]}',ciudad='{$d["ciudad"]}',direccion='{$d["direccion"]}',telefono='{$d["telefono"]}',cotizacion='{$d["cotizacion"]}' WHERE idusuario ='{$d["txtId"]}'";
		if(!empty($d["clave"])){
			$clave = hash("sha256",$d["clave"]);
			$sql = "UPDATE tblusuarios_externos SET nombre='{$d["nombre"]}',clave='{$clave}',cedula='{$d["cedula"]}',correo_electronico='{$d["correo"]}',ciudad='{$d["ciudad"]}',direccion='{$d["direccion"]}',telefono='{$d["telefono"]}',cotizacion='{$d["cotizacion"]}' WHERE idusuario ='{$d["txtId"]}'";
		}

		mysqli_query($nConexion,$sql);
		Log_System( "USUARIOSEXTERNOS" , "EDITA" , "USUARIO: " . $nId );
		mysqli_close( $nConexion );

		Mensaje( "El registro ha sido actualizado correctamente.", "usuarios_listar.php" );
		return;	
	}
    
} // FIN: function UsuariosGuardar


function UsuariosEliminar( $nId ) {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT * FROM tblusuarios_externos WHERE idusuario ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblusuarios_externos WHERE idusuario ='$nId'" );
    Log_System( "USUARIOS_EXTERNOS" , "ELIMINA" , "USUARIOS: " . $reg->idusuario );
    mysqli_close( $nConexion );
	
    Mensaje( "El registro ha sido eliminado correctamente.","usuarios_listar.php" );
    exit();
  } 
  // FIN: function UsuariosGuardar
  ###############################################################################

function UsuariosFormEditar( $nId )
  {
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblusuarios_externos WHERE idusuario = '$nId'" );
    mysqli_close( $nConexion );

    $Registro = mysqli_fetch_array( $Resultado );
	?>
	<!-- Formulario Ingreso de Contenidos -->
	<form method="post" action="usuarios.php?Accion=Guardar" enctype="multipart/form-data">
		<input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>">
		<table width="100%">
			<tr>
				<td colspan="2" align="center" class="tituloFormulario"><b>EDITAR USUARIO</b></td>
			</tr>
			<tr>
				<td class="tituloNombres">Nombre:</td>
				<td class="contenidoNombres"><INPUT id="nombre" type="text" name="nombre" maxLength="150" value="<?php echo $Registro["nombre"]; ?>" required></td>
			</tr>
			<tr>
				<td class="tituloNombres">C&eacute;dula:</td>
				<td class="contenidoNombres"><INPUT id="cedula" type="text" name="cedula" maxLength="150" value="<?php echo $Registro["cedula"]; ?>"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Correo:</td>
				<td class="contenidoNombres"><INPUT id="correo" type="text" name="correo" maxLength="150" value="<?php echo $Registro["correo_electronico"]; ?>" required></td>
			</tr>
			<tr>
				<td class="tituloNombres">Ciudad:</td>
				<td class="contenidoNombres"><INPUT id="ciudad" type="text" name="ciudad" maxLength="150" value="<?php echo $Registro["ciudad"]; ?>"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Dirección:</td>
				<td class="contenidoNombres"><input id="direccion" type="text" name="direccion" value="<?php echo $Registro["direccion"]; ?>"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Tel&eacute;fono:</td>
				<td class="contenidoNombres"><INPUT id="telefono" type="text" name="telefono" maxLength="150" value="<?php echo $Registro["telefono"]; ?>"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Contraseña:</td>
				<td class="contenidoNombres"><INPUT id="clave" type="password" name="clave"></td>
			</tr>
			<tr>
				<td class="tituloNombres">Confirmar contraseña:</td>
				<td class="contenidoNombres"><INPUT id="clave2" type="password" name="clave2"> <span id='mensaje'></span></td>
			</tr>
              <tr>
                <td class="tituloNombres">Cotizador activo:</td>
                <td class="contenidoNombres" colspan="5">
                <select name="cotizacion">
                    <option value="1"  <?=$Registro["cotizacion"]==1?"selected":"";?>>SI</option>
                    <option value="0"  <?=$Registro["cotizacion"]==0?"selected":"";?>>NO</option>
                </select>
                </td>
              </tr> 
			<tr>
				<td colspan="2" class="tituloFormulario">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="nuevo">
					<input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
					<a href="usuarios_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
				</td>
			</tr>
		</table>
	</form>
	<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>