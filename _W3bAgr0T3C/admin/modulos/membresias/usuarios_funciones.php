<?php
require_once("../../funciones_generales.php");
require_once("../../herramientas/paginar/dbquery.inc.php");

$nConexion = Conectar();
$ca = new DbQuery($nConexion);
$ca->prepareSelect("tblmb_membresias", "idmembresia,nombre", "1=1", "nombre");
$ca->exec();
$rMembresias = $ca->assocAll();
?>
<?php

function UsuariosGuardar($nId, $idmembresia, $ip_habilitada) {
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);

    $ca->prepareUpdate("tblusuarios_externos", "idmembresia,ip_habilitada", "idusuario=:idusuario");
    $ca->bindValue(":idusuario", $nId, false);
    $ca->bindValue(":idmembresia", $idmembresia, false);
    $ca->bindValue(":ip_habilitada", $ip_habilitada, true);

    if (!$ca->exec()) {
        Mensaje("Error actualizando usuario membresia {$nId}", "usuarios_listar.php");
        exit;
    }
    mysqli_close($nConexion);
    Mensaje("El registro ha sido actualizado correctamente.", "usuarios_listar.php");
    return;
}
?>

<?php

function UsuariosFormEditar($nId) {
    global $rMembresias;
    $nConexion = Conectar();
    $campos = "a.idusuario,CONCAT(a.nombre,' ',a.apellido) as nombre,a.correo_electronico,a.idmembresia,a.ip_habilitada";
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tblusuarios_externos a", $campos, "a.idusuario=:idusuario");
    $ca->bindValue(":idusuario", $nId, false);
    $ca->exec();

    $Registro = $ca->assoc();
    mysqli_close($nConexion);
    ?>
    <form method="post" action="usuarios.php?Accion=Guardar">
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>">
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR USUARIO - MEMBRESIA</b></td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres">
                    <input type="text" id="nombre" name="nombre" value="<?php echo $Registro["nombre"] ?>" readonly/>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Correo:</td>
                <td class="contenidoNombres">
                    <input type="text" id="correo" name="correo" value="<?php echo $Registro["correo_electronico"] ?>" readonly/>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Membresia:</td>
                <td class="contenidoNombres">
                    <select name="idmembresia" id="idmembresia">
                        <?php foreach ($rMembresias as $r): ?>
                            <option value="<?php echo $r["idmembresia"]; ?>" <?php echo $r["idmembresia"] == $Registro["idmembresia"] ? "selected" : ""; ?>><?php echo $r["nombre"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td class="tituloNombres">IP(s) habilitada:</td>
                <td class="contenidoNombres">
                    <input type="text" id="ip_habilitada" name="ip_habilitada" value="<?php echo $Registro["ip_habilitada"] ?>" /><br/>
                    Puede ingresar una IP (Ej: 200.75.50.92), varias IP separadas por coma (,) (Ej: 200.75.50.92,200.75.50.97)<br/>
                    o un asterisco (*) para indicar que es cualquier IP.
                </td>
            </tr>

            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="usuarios.php?Accion=Eliminar&Id=<?php echo $nId; ?>">
                        <img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"/>
                    </a>
                    <a href="usuarios_listar.php">
                        <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/>
                    </a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>
