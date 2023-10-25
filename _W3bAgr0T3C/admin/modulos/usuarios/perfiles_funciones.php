<?php
###############################################################################
# usuarios_funciones.php :  Archivo de funciones modulo usuarios
# Desarrollo             :  Estilo y Dise�o & Informaticactiva
# Web                    :  http://www.esidi.com
#                           http://www.informaticactiva.com
###############################################################################
include("../../funciones_generales.php");
###############################################################################
# Nombre        : UsuariosFormNuevo
# Descripci�n   : Muestra el formulario para ingreso de usuarios nuevos
# Parametros    : Ninguno.
# Desarrollado  : Estilo y Dise�o & Informaticactiva
# Retorno       : Ninguno
###############################################################################

function PerfilesFormNuevo() {
    $nConexion = Conectar();
	$modulos  = mysqli_query($nConexion,"SELECT * FROM modulos");
	if($_SESSION["UsrPerfil"]!=1){
	$modulos  = mysqli_query($nConexion,"SELECT * FROM modulos WHERE tipo !='Matriz'");
	}
    ?>
    <!-- Formulario Ingreso de Usuarios -->
    <form method="post" action="perfiles.php?Accion=Guardar" enctype="multipart/form-data">
        <input TYPE="hidden" id="txtId" name="txtId" value="0">
        <table>
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO PERFIL</b></td>
            </tr>
            <tr>
                <td class="tituloNombres">Perfil:</td>
                <td class="contenidoNombres"><INPUT id="perfil" type="text" name="perfil" required maxLength="255" style="WIDTH: 300px; HEIGHT: 22px"></td>
            </tr>
			<?php while($row = mysqli_fetch_assoc($modulos) ):?>
            <tr>
                <td class="tituloNombres"><?php echo $row["modulo"]; ?></td>
                <td class="contenidoNombres" colspan="5">
					<label class="checkbox mitad">Ver<input name="ver[<?php echo $row["id"]; ?>]" value="1" type="checkbox" ></label>
					<label class="checkbox mitad">Crear<input name="crear[<?php echo $row["id"]; ?>]" value="1" type="checkbox" ></label>
					<label class="checkbox mitad">Editar<input name="editar[<?php echo $row["id"]; ?>]" value="1" type="checkbox" ></label>
					<label class="checkbox mitad">Eliminar<input name="eliminar[<?php echo $row["id"]; ?>]" value="1" type="checkbox" ></label>
                </td>
            </tr>
	 		<?php endwhile;?>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
                    <a href="perfiles_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
                </td>
            </tr>
        </table>
    </form>
    <?
}

###############################################################################
###############################################################################
# Nombre        : UsuariosGuardar
# Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
# Parametros    : cNombresUser, cUsuario, cClave1, cClave2, idperfil(Si el Cero Nuevo Usuario, de lo contrario Actualizar Usuario)
# Desarrollado  : Estilo y Dise�o & Informaticactiva
# Retorno       : Ninguno
###############################################################################

function PerfilesGuardar($d) {
	$nConexion = Conectar();
	$modulos  = mysqli_query($nConexion,"SELECT * FROM modulos");
	if($_SESSION["UsrPerfil"]!=1){
	$modulos  = mysqli_query($nConexion,"SELECT * FROM modulos WHERE tipo !='Matriz'");
	}
	if ($d["txtId"] <= 0) { // Nuevo Perfil
		mysqli_query($nConexion,"INSERT INTO perfiles ( perfil ) VALUES ( '{$d["perfil"]}' )");
		
        $idperfil = mysqli_insert_id($nConexion);
	  
	   while($row = mysqli_fetch_assoc($modulos) ):
	   	if(isset($d["ver"][$row["id"]]) || isset($d["crear"][$row["id"]]) || isset($d["editar"][$row["id"]]) || isset($d["eliminar"][$row["id"]])){
			$ver = isset($d["ver"][$row["id"]])?1:0;
			$crear = isset($d["crear"][$row["id"]])?1:0;
			$editar = isset($d["editar"][$row["id"]])?1:0;
			$eliminar = isset($d["eliminar"][$row["id"]])?1:0;
			$sql="INSERT INTO perfil_modulo ( idmodulo, idperfil, ver, crear, editar, eliminar ) VALUES ( {$row["id"]}, {$idperfil}, {$ver}, {$crear}, {$editar}, {$eliminar} )";
			$result = mysqli_query($nConexion,$sql);
		}
	  endwhile;
	  
		Log_System("PERFILES", "NUEVO", "PERFIL: " . $d["perfil"]);
		mysqli_close($nConexion);
		Mensaje("El registro ha sido almacenado correctamente.", "perfiles_listar.php");
		exit;
	} else { // Actualizar Usuario
		mysqli_query($nConexion,"UPDATE perfiles SET perfil = '{$d["perfil"]}' WHERE id = {$d["txtId"]}");
    	mysqli_query($nConexion,"DELETE FROM perfil_modulo WHERE idperfil = {$d["txtId"]}");
	  
	   while($row = mysqli_fetch_assoc($modulos) ):
	   	if(isset($d["ver"][$row["id"]]) || isset($d["crear"][$row["id"]]) || isset($d["editar"][$row["id"]]) || isset($d["eliminar"][$row["id"]])){
			$ver = isset($d["ver"][$row["id"]])?1:0;
			$crear = isset($d["crear"][$row["id"]])?1:0;
			$editar = isset($d["editar"][$row["id"]])?1:0;
			$eliminar = isset($d["eliminar"][$row["id"]])?1:0;
			$sql="INSERT INTO perfil_modulo ( idmodulo, idperfil, ver, crear, editar, eliminar ) VALUES ( {$row["id"]}, {$d["txtId"]}, {$ver}, {$crear}, {$editar}, {$eliminar} )";
			$result = mysqli_query($nConexion,$sql);
		}
	  endwhile;
	  
		Log_System("PERFILES", "EDITA", "PERFIL: " . $d["perfil"]);
		mysqli_close($nConexion);
		Mensaje("El registro ha sido actualizado correctamente.", "perfiles_listar.php");
		exit;
	}
}

// FIN: function UsuariosGuardar
###############################################################################
###############################################################################
# Nombre        : UsuariosEliminar
# Descripci�n   : Eliminar un registro de la tabla perfiles
# Parametros    : $idperfil
# Desarrollado  : Estilo y Dise�o & Informaticactiva
# Retorno       : Ninguno
###############################################################################

function PerfilesEliminar($idperfil) {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object(mysqli_query($nConexion,"SELECT perfil FROM perfiles WHERE id ='$idperfil'"));
    mysqli_query($nConexion,"DELETE FROM perfiles WHERE id =$idperfil");
    mysqli_query($nConexion,"DELETE FROM perfil_modulo WHERE idperfil =$idperfil");
    Log_System("PERFILES", "ELIMINA", "PERFIL: " . $reg->perfil);
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "perfiles_listar.php");
    exit();
}

// FIN: function UsuariosActualizarClave
###############################################################################
###############################################################################
# Nombre        : UsuariosFormEditar
# Descripci�n   : Muestra el formulario de usuarios para la edicion o eliminacion
# Parametros    : $idperfil = ID de Usuario que se debe mostrar el en formulario
# Desarrollado  : Estilo y Dise�o & Informaticactiva
# Retorno       : Ninguno
###############################################################################

function PerfilesFormEditar($idperfil) {
	include("../../vargenerales.php");
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion,"SELECT * FROM perfiles WHERE id = '$idperfil'");
	$modulos  = mysqli_query($nConexion,"SELECT * FROM modulos m LEFT OUTER JOIN perfil_modulo pm on (m.id=pm.idmodulo) and idperfil = $idperfil");
	if($_SESSION["UsrPerfil"]!=1){
	$modulos  = mysqli_query($nConexion,"SELECT * FROM modulos m LEFT OUTER JOIN perfil_modulo pm on (m.id=pm.idmodulo) and idperfil = $idperfil WHERE tipo !='Matriz'");
	}
    mysqli_close($nConexion);

    $Registro = mysqli_fetch_array($Resultado);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Usuarios -->
    <form method="post" action="perfiles.php?Accion=Guardar" enctype="multipart/form-data">
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $idperfil; ?>">
        <table>
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR PERFIL</b></td>
            </tr>
            <tr>
                <td class="tituloNombres">Perfil:</td>
                <td class="contenidoNombres"><INPUT id="perfil" type="text" name="perfil" value="<?php echo $Registro["perfil"]; ?>" required maxLength="255" style="WIDTH: 300px; HEIGHT: 22px"></td>
            </tr>
			<?php while($row = mysqli_fetch_assoc($modulos) ):?>
            <tr>
                <td class="tituloNombres"><?php echo $row["modulo"]; ?></td>
                <td class="contenidoNombres" colspan="5">
					<label class="checkbox mitad">Ver<input name="ver[<?php echo $row["id"]; ?>]" value="1" type="checkbox" <?=$row["ver"]==1?"checked":"";?>></label>
					<label class="checkbox mitad">Crear<input name="crear[<?php echo $row["id"]; ?>]" value="1" type="checkbox" <?=$row["crear"]==1?"checked":"";?> ></label>
					<label class="checkbox mitad">Editar<input name="editar[<?php echo $row["id"]; ?>]" value="1" type="checkbox" <?=$row["editar"]==1?"checked":"";?> ></label>
					<label class="checkbox mitad">Eliminar<input name="eliminar[<?php echo $row["id"]; ?>]" value="1" type="checkbox" <?=$row["eliminar"]==1?"checked":"";?> ></label>
                </td>
            </tr>
	 		<?php endwhile;?>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
                    <a href="perfiles_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
                </td>
            </tr>
        </table>
    </form>
                    <?
                    mysqli_free_result($Resultado);
                }
?>