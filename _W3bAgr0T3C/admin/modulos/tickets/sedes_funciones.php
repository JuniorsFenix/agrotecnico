<?php
require_once("../../funciones_generales.php");
require_once("../../herramientas/paginar/dbquery.inc.php");

$nConexion = Conectar();
$ca = new DbQuery($nConexion);
$ca->prepareSelect("tbltk_zonas", "*");
$ca->exec();
$rZonas = $ca->assocAll();
$ca->prepareSelect("tbltk_pevaluaciones", "*");
$ca->exec();
$rEvaluaciones = $ca->assocAll();
mysqli_close($nConexion);

function SedesFormNuevo() {
    global $rZonas;
    global $rEvaluaciones;
    $IdCiudad = $_SESSION["IdCiudad"];
    ?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="sedes.php?Accion=Guardar">
        <input TYPE="hidden" id="txtId" name="txtId" value="0"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA SEDE</b></td>
            </tr>
        </table>
        <br/>
        <br/>
        <br/>
        <br/>
        <table width="100%">
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres"><input type="text" id="nombre" name="nombre" value=""/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Zona:</td>
                <td class="contenidoNombres">
                    <select name="idzona">
                        <?php foreach ($rZonas as $r):?>
                        <option value="<?php echo $r["idzona"];?>"><?php echo $r["nombre"];?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Ciudad:</td>
                <td class="contenidoNombres"><input type="text" id="ciudad" name="ciudad" value=""/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Pais:</td>
                <td class="contenidoNombres"><input type="text" id="pais" name="pais" value=""/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Contacto:</td>
                <td class="contenidoNombres"><input type="text" id="contacto" name="contacto" value=""/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Correo Contacto:</td>
                <td class="contenidoNombres"><input type="text" id="correo_contacto" name="correo_contacto" value=""/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Correo Sede:</td>
                <td class="contenidoNombres"><input type="text" id="correo_sede" name="correo_sede" value=""/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Direcci�n:</td>
                <td class="contenidoNombres"><input type="text" id="direccion" name="direccion" value=""/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Tel�fono:</td>
                <td class="contenidoNombres"><input type="text" id="telefono" name="telefono" value=""/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Gremio:</td>
                <td class="contenidoNombres"><input type="text" id="gremio" name="gremio" value=""/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Evaluaci�n:</td>
                <td class="contenidoNombres">
                    <select name="idevaluacion">
                        <?php foreach ($rEvaluaciones as $r):?>
                        <option value="<?php echo $r["idevaluacion"];?>"><?php echo $r["nombre"];?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
                    <a href="sedes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}

###############################################################################
?>
<?php
/*- Ciudad
- Pais
- Contacto directo
- Email Contacto
- Email Sede
- Direcci�n
- Tel�fono sede
- Gremio*/
function SedesGuardar($nId, $nombre, $idzona, $ciudad, $pais, $contacto, $correo_contacto, $correo_sede, $direccion, $telefono, $gremio, $idevaluacion ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $campos = "nombre,idzona,ciudad,pais,contacto,correo_contacto,correo_sede,direccion,telefono,gremio,idevaluacion";
    $ca = new DbQuery($nConexion);
    if ($nId <= 0) {
        $ca->prepareInsert("tbltk_sedes", $campos);
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":idzona", $idzona, false);
        $ca->bindValue(":ciudad", $ciudad, true);
        $ca->bindValue(":pais", $pais, true);
        $ca->bindValue(":contacto", $contacto, true);
        $ca->bindValue(":correo_contacto", $correo_contacto, true);
        $ca->bindValue(":correo_sede", $correo_sede, true);
        $ca->bindValue(":direccion", $direccion, true);
        $ca->bindValue(":telefono", $telefono, true);
        $ca->bindValue(":gremio", $gremio, true);
        $ca->bindValue(":idevaluacion", $idevaluacion, false);

        if (!$ca->exec()) {
            Mensaje("Error registrando nueva sede.", "sedes_listar.php");
            exit;
        }
        mysqli_close($nConexion);
        Mensaje("El registro ha sido almacenado correctamente.", "sedes_listar.php");
        return;
    } else {
        $ca->prepareUpdate("tbltk_sedes", $campos, "idsede=:idsede");
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":idsede", $nId, false);
        $ca->bindValue(":idzona", $idzona, false);
        $ca->bindValue(":ciudad", $ciudad, true);
        $ca->bindValue(":pais", $pais, true);
        $ca->bindValue(":contacto", $contacto, true);
        $ca->bindValue(":correo_contacto", $correo_contacto, true);
        $ca->bindValue(":correo_sede", $correo_sede, true);
        $ca->bindValue(":direccion", $direccion, true);
        $ca->bindValue(":telefono", $telefono, true);
        $ca->bindValue(":gremio", $gremio, true);
        $ca->bindValue(":idevaluacion", $idevaluacion, false);

        if (!$ca->exec()) {
            Mensaje("Error actualizando sede {$nId}", "sedes_listar.php");
            exit;
        }
        mysqli_close($nConexion);
        Mensaje("El registro ha sido actualizado correctamente.", "sedes_listar.php");
        return;
    }
}
?>
<?php

function SedesEliminar($nId) {
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareDelete("tbltk_sedes", "idsede=:idsede");
    $ca->bindValue(":idsede", $nId, false);

    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando sede {$nId}", "sedes_listar.php");
        exit;
    }
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "sedes_listar.php");
    exit();
}
?>
<?php

function SedesFormEditar($nId) {
    global $rZonas;
    global $rEvaluaciones;
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tbltk_sedes", "*", "idsede=:idsede");
    $ca->bindValue(":idsede", $nId, false);
    $ca->exec();

    $Registro = $ca->assoc();
    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="sedes.php?Accion=Guardar" >
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>" />
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR SEDE</b></td>
            </tr>

        </table>

        <table width="100%">
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres"><input type="text" id="nombre" name="nombre" value="<?php echo $Registro["nombre"] ?>"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Zona:</td>
                <td class="contenidoNombres">
                    <select name="idzona">
                        <?php foreach ($rZonas as $r):?>
                        <option value="<?php echo $r["idzona"];?>" <?php echo $r["idzona"]==$Registro["idzona"]?"selected":"";?>><?php echo $r["nombre"];?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Ciudad:</td>
                <td class="contenidoNombres"><input type="text" id="ciudad" name="ciudad" value="<?php echo $Registro["ciudad"] ?>"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Pais:</td>
                <td class="contenidoNombres"><input type="text" id="pais" name="pais" value="<?php echo $Registro["pais"] ?>"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Contacto:</td>
                <td class="contenidoNombres"><input type="text" id="contacto" name="contacto" value="<?php echo $Registro["contacto"] ?>"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Correo Contacto:</td>
                <td class="contenidoNombres"><input type="text" id="correo_contacto" name="correo_contacto" value="<?php echo $Registro["correo_contacto"] ?>"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Correo Sede:</td>
                <td class="contenidoNombres"><input type="text" id="correo_sede" name="correo_sede" value="<?php echo $Registro["correo_sede"] ?>"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Direcci�n:</td>
                <td class="contenidoNombres"><input type="text" id="direccion" name="direccion" value="<?php echo $Registro["direccion"] ?>"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Tel�fono:</td>
                <td class="contenidoNombres"><input type="text" id="telefono" name="telefono" value="<?php echo $Registro["telefono"] ?>"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Gremio:</td>
                <td class="contenidoNombres"><input type="text" id="gremio" name="gremio" value="<?php echo $Registro["gremio"] ?>"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Evaluaci�n:</td>
                <td class="contenidoNombres">
                    <select name="idevaluacion">
                        <?php foreach ($rEvaluaciones as $r):?>
                        <option value="<?php echo $r["idevaluacion"];?>" <?php echo $r["idevaluacion"]==$Registro["idevaluacion"]?"selected":"";?>><?php echo $r["nombre"];?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="sedes.php?Accion=Eliminar&Id=<?php echo $nId; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
                    <a href="sedes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
                </td>
            </tr>
        </table>
    </form>
<?php
}
?>
