<?
###############################################################################
# usuarios_funciones.php :  Archivo de funciones modulo usuarios
# Desarrollo             :  Estilo y Diseño & Informaticactiva
# Web                    :  http://www.esidi.com
#                           http://www.informaticactiva.com
###############################################################################
include("../../funciones_generales.php");
###############################################################################
# Nombre        : UsuariosFormNuevo
# Descripción   : Muestra el formulario para ingreso de usuarios nuevos
# Parametros    : Ninguno.
# Desarrollado  : Estilo y Diseño & Informaticactiva
# Retorno       : Ninguno
###############################################################################

function UsuariosFormNuevo() {
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
	$perfiles  = mysqli_query($nConexion,"SELECT * FROM perfiles");
    ?>
    <!-- Formulario Ingreso de Usuarios -->
    <form method="post" action="usuarios.php?Accion=Guardar" enctype="multipart/form-data">
        <input TYPE="hidden" id="txtId" name="txtId" value="0">
        <table>
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO USUARIO</b></td>
            </tr>
            <tr>
                <td class="tituloNombres">Nombres y Apellidos:</td>
                <td class="contenidoNombres"><INPUT id="txtNombres" type="text" name="txtNombres" maxLength="255" style="WIDTH: 300px; HEIGHT: 22px"></td>
            </tr>
            <tr>
                <td class="tituloNombres">Perfil:</td>
                <td class="contenidoNombres">
                    <select name="cboPerfil" id="cboPerfil">
					<?php while($row = mysqli_fetch_assoc($perfiles) ):?>
                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["perfil"]; ?></option>
	 				<?php endwhile;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Correo:</td>
                <td class="contenidoNombres"><INPUT id="txtUsuario" type="text" name="txtCorreoElectronico" maxLength="50"></td>
            </tr>
            <tr>
                <td class="tituloNombres">Cédula:</td>
                <td class="contenidoNombres"><INPUT id="cedula" type="text" name="cedula" maxLength="50"></td>
            </tr>
            <tr>
                <td class="tituloNombres">Cargo:</td>
                <td class="contenidoNombres"><INPUT id="cargo" type="text" name="cargo" maxLength="50"></td>
            </tr>
			<tr>
				<td class="tituloNombres">Imagen:</td>
				<td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen"></td>
			</tr>
            <tr>
                <td class="tituloNombres">Contraseña:</td>
                <td class="contenidoNombres"><INPUT id="txtClave" type="password" name="txtClave" maxLength="50"></td>
            </tr>
            <tr>
                <td class="tituloNombres">Confirmar:</td>
                <td class="contenidoNombres"><INPUT id="txtConfirmar" type="password" name="txtConfirmar" maxLength="50"></td>
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
###############################################################################
# Nombre        : UsuariosGuardar
# Descripción   : Adiciona un nuevo registro o actualiza uno existente
# Parametros    : cNombresUser, cUsuario, cClave1, cClave2, nIdUsuario(Si el Cero Nuevo Usuario, de lo contrario Actualizar Usuario)
# Desarrollado  : Estilo y Diseño & Informaticactiva
# Retorno       : Ninguno
###############################################################################

function UsuariosGuardar($cNombresUser, $cClave1, $cClave2, $nIdUsuario, $cPerfil, $cCorreoElectronico, $cCedula, $cCargo, $cFirma) {
    if ($cClave1 == $cClave2) { // Si las claves son iguales
        if ($nIdUsuario <= 0) { // Nuevo Usuario
            $nConexion = Conectar();
			mysqli_set_charset($nConexion,'utf8');

            // Verifico que el usuario no este almacenado
            $Resultado = mysqli_query($nConexion,"SELECT * FROM tblusuarios WHERE correo_electronico = '$cCorreoElectronico'");
            if (mysqli_num_rows($Resultado)) {
            //if ( !$Existe = mysqli_num_rows )
                Error("Este correo ya esta almacenado, intente con un correo diferente.");
            } else {
                $cClave1 = hash("sha256",$cClave1);
                $r = mysqli_query($nConexion,"INSERT INTO tblusuarios ( nombres,clave,perfil,correo_electronico,cedula,cargo,firma ) VALUES ( '{$cNombresUser}','{$cClave1}','{$cPerfil}','{$cCorreoElectronico}','{$cCedula}','{$cCargo}','{$cFirma}' )");
				
			  if(!$r){
				Mensaje( "Fallo creando nuevo usuario.".mysqli_error($nConexion), "usuarios_listar.php" ) ;
				exit;
			  }
                Log_System("USUARIOS", "NUEVO", "USUARIO: " . $cNombresUser);
                mysqli_close($nConexion);
                Mensaje("El registro ha sido almacenado correctamente.", "usuarios_listar.php");
                exit;
            }
        } else { // Actualizar Usuario
            $nConexion = Conectar();
			mysqli_set_charset($nConexion,'utf8');
            mysqli_query($nConexion,"UPDATE tblusuarios SET nombres = '{$cNombresUser}', perfil = '{$cPerfil}', correo_electronico='{$cCorreoElectronico}', cedula='{$cCedula}', cargo='{$cCargo}', firma='{$cFirma}' WHERE idusuario = '$nIdUsuario'");
            Log_System("USUARIOS", "EDITA", "USUARIO: " . $cNombresUser);
            mysqli_close($nConexion);
            Mensaje("El registro ha sido actualizado correctamente.", "usuarios_listar.php");
            exit;
        }
    } else {
        Error("Los campos Contraseña y Confirmar deben ser iguales.");
    }
}

// FIN: function UsuariosGuardar
###############################################################################
###############################################################################
# Nombre        : UsuariosEliminar
# Descripción   : Eliminar un registro de la tabla tblusuarios
# Parametros    : $nIdUsuario
# Desarrollado  : Estilo y Diseño & Informaticactiva
# Retorno       : Ninguno
###############################################################################

function UsuariosEliminar($nIdUsuario) {
    $nConexion = Conectar();
			mysqli_set_charset($nConexion,'utf8');
    $reg = mysqli_fetch_object(mysqli_query($nConexion,"SELECT nombres FROM tblusuarios WHERE idusuario ='$nIdUsuario'"));
    mysqli_query($nConexion,"DELETE FROM tblusuarios WHERE idusuario ='$nIdUsuario'");
    Log_System("USUARIOS", "ELIMINA", "USUARIO: " . $reg->nombres);
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "usuarios_listar.php");
    exit();
}

// FIN: function UsuariosGuardar
###############################################################################
###############################################################################
# Nombre        : UsuariosActualizarClave
# Descripción   : Actualiza la clave de acceso para un usuario especifico
# Parametros    : Contraseña Actual, Clave Nueva, Confirmación Clave Nueva, Id Usuario.
# Desarrollado  : Estilo y Diseño & Informaticactiva
# Retorno       : Ninguno
###############################################################################

function UsuariosActualizarClave($cClaveAnterior, $cClaveNueva, $cClaveConfirma, $nIdUsuario) {
    // Verificar que las claves sean correctas:
    if ($cClaveNueva == $cClaveConfirma) {
        // Verificar que la contraseña actual sea la correcta (la contraseña almacenada)
        $nConexion = Conectar();
		mysqli_set_charset($nConexion,'utf8');
        $Resultado = mysqli_query($nConexion,"SELECT * FROM tblusuarios WHERE idusuario ='$nIdUsuario'");
        mysqli_close($nConexion);
        $Registro = mysqli_fetch_array($Resultado);
        
        $cClaveAnterior = hash("sha256", $cClaveAnterior);
        $clave = $Registro["clave"];
        
        if ( $clave == $cClaveAnterior) {
            $nConexion = Conectar();
			mysqli_set_charset($nConexion,'utf8');
            $cClaveNueva = hash("sha256", $cClaveNueva);
            mysqli_query($nConexion,"UPDATE tblusuarios SET clave = '$cClaveNueva' WHERE idusuario ='$nIdUsuario'");
            mysqli_close($nConexion);
            Mensaje("La contraseña se cambio con éxito.", "usuarios_listar.php");
            exit();
        } else {
            Error("La contraseña actual no es correcta.");
        }
    } else {
        Error("Los campos Contraseña y Confirmar deben ser iguales.");
    }
    mysqli_free_result($Resultado);
    exit();
}

// FIN: function UsuariosActualizarClave
###############################################################################
###############################################################################
# Nombre        : UsuariosFormEditar
# Descripción   : Muestra el formulario de usuarios para la edicion o eliminacion
# Parametros    : $nIdUsuario = ID de Usuario que se debe mostrar el en formulario
# Desarrollado  : Estilo y Diseño & Informaticactiva
# Retorno       : Ninguno
###############################################################################

function UsuariosFormEditar($nIdUsuario) {
		include("../../vargenerales.php");
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $Resultado = mysqli_query($nConexion,"SELECT * FROM tblusuarios WHERE idusuario = '$nIdUsuario'");
	$perfiles  = mysqli_query($nConexion,"SELECT * FROM perfiles");
    mysqli_close($nConexion);

    $Registro = mysqli_fetch_array($Resultado);
    ?>
    <!-- Formulario Edición / Eliminación de Usuarios -->
    <form method="post" action="usuarios.php?Accion=Guardar" enctype="multipart/form-data">
        <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nIdUsuario; ?>">
        <table>
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR USUARIO</b></td>
            </tr>
            <tr>
                <td class="tituloNombres">Nombres y Apellidos:</td>
                <td class="contenidoNombres"><INPUT id="txtNombres" type="text" name="txtNombres" maxLength="255" value="<? echo $Registro["nombres"]; ?>" style="WIDTH: 300px; HEIGHT: 22px"></td>
            </tr>
            <tr>
                <td class="tituloNombres">Perfil:</td>
                <td class="contenidoNombres">
                    <select name="cboPerfil" id="cboPerfil">
					<?php while($row = mysqli_fetch_assoc($perfiles) ):?>
                        <option value="<?php echo $row["id"]; ?>" <?= $Registro["perfil"] == $row["id"] ? "selected" : ""; ?>><?php echo $row["perfil"]; ?></option>
	 				<?php endwhile;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Correo:</td>
                <td class="contenidoNombres"><INPUT id="txtUsuario" type="text" name="txtCorreoElectronico" maxLength="50" value="<? echo $Registro["correo_electronico"]; ?>"></td>
            </tr>
            <tr>
                <td class="tituloNombres">Cédula:</td>
                <td class="contenidoNombres"><INPUT id="cedula" type="text" name="cedula" maxLength="50" value="<? echo $Registro["cedula"]; ?>"></td>
            </tr>
            <tr>
                <td class="tituloNombres">Cargo:</td>
                <td class="contenidoNombres"><INPUT id="cargo" type="text" name="cargo" maxLength="50" value="<? echo $Registro["cargo"]; ?>"></td>
            </tr>
            <tr>
                <td class="tituloNombres">Firma:</td>
                <td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen"></td>
            </tr>
            <tr>
                <td class="tituloNombres">Imagen Actual:</td>
                <td class="contenidoNombres">
                <?
                    if ( empty( $Registro["firma"] ) )
                    {
                        echo "No se asigno una firma.";
                    }
                    else
                    {
                        ?><img src="<? echo $cRutaVerFirmas . $Registro['firma']; ?>"><?
                    }
                ?>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Contraseña:</td>
                <td class="contenidoNombres"><a href="usuarios.php?Accion=Clave&Id=<? echo $nIdUsuario; ?>"><img src="../../image/cambiarclave.gif" border="0" alt="Cambiar Contraseña."></a></td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">

    <?
    if (Perfil() != "3") {
        ?><a href="usuarios.php?Accion=Eliminar&Id=<? echo $nIdUsuario; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('¿Esta seguro que desea eliminar este registro?')"></a><?
    }
    ?>
                    <a href="usuarios_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
                </td>
            </tr>
        </table>
    </form>
                    <?
                    mysqli_free_result($Resultado);
                }

###############################################################################
###############################################################################
# Nombre        : UsuariosFormClave
# Descripción   : Muestra el formulario para cambiar la contraseña
# Parametros    : $nIdUsuario = ID de Usuario a cambiar contraseña
# Desarrollado  : Estilo y Diseño & Informaticactiva
# Retorno       : Ninguno
###############################################################################

function UsuariosFormClave($nIdUsuario) {
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $Resultado = mysqli_query($nConexion,"SELECT * FROM tblusuarios WHERE idusuario = '$nIdUsuario'");
    mysqli_close($nConexion);

    $Registro = mysqli_fetch_array($Resultado);
    ?>
    <!-- Formulario Cambiar Contraseña -->
    <form method="post" action="usuarios.php?Accion=ActualizarClave">
        <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nIdUsuario; ?>">
        <table>
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>CAMBIO DE CONTRASEÑA</b></td>
            </tr>
            <tr>
                <td class="tituloNombres">Nombres y Apellidos:</td>
                <td class="contenidoNombres"><b><? echo $Registro["nombres"]; ?></b></td>
            </tr>
            <tr>
                <td class="tituloNombres">Usuario:</td>
                <td class="contenidoNombres"><b><? echo $Registro["usuario"]; ?></b></td>
            </tr>
            <tr>
                <td class="tituloNombres">Contraseña Actual:</td>
                <td class="contenidoNombres"><INPUT id="txtClaveAnt" type="password" name="txtClaveAnt" maxLength="20"></td>
            </tr>
            <tr>
                <td class="tituloNombres">Nueva Contraseña:</td>
                <td class="contenidoNombres"><INPUT id="txtClave1" type="password" name="txtClave1" maxLength="20"></td>
            </tr>
            <tr>
                <td class="tituloNombres">Confirmar Contraseña:</td>
                <td class="contenidoNombres"><INPUT id="txtClave2" type="password" name="txtClave2" maxLength="20"></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Actualizar Contraseña.">
                    <a href="usuarios_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
                </td>
            </tr>
        </table>
    </form>
    <?
    mysqli_free_result($Resultado);
}

###############################################################################
?>
<?
###############################################################################
# Nombre        : ValidarLogin
# Descripción   : Valida que el usuario y claves existan en la base de datos
# Parametros    : Usuario, Clave
# Desarrollado  : Estilo y Diseño & Informaticactiva
# Retorno       : Ninguno
###############################################################################

function ValidarLogin($cUsuario, $cClave) {
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $cClave = hash("sha256", $cClave);
    $Resultado = mysqli_query($nConexion,"SELECT * FROM tblusuarios WHERE usuario='$cUsuario' AND clave='$cClave'");
    mysqli_close($nConexion);
    $Registro = mysqli_fetch_array($Resultado);
    
    if ($Registro["usuario"] == $cUsuario && $Registro["clave"] == $cClave) {
        //echo "usuario correcto";
        session_start();
        $_SESSION["UsrValido"] = "SI";
        $_SESSION["UsrNombre"] = $Registro["nombres"];
        $_SESSION["UsrPerfil"] = $Registro["perfil"];
        $_SESSION["UsrUser"] = $Registro["usuario"];

        header("Location: home.php");
        exit;
    } else {
        Error("Usuario y/o contraseña incorrectos.");
        exit;
    }
}

// FIN: function UsuariosActualizarClave
###############################################################################
?>
