<?php
require_once("../../funciones_generales.php");
require_once("../../herramientas/paginar/dbquery.inc.php");

$nConexion = Conectar();
$ca = new DbQuery($nConexion);
$ca->prepareSelect("tblmb_categorias", "idcategoria,nombre", "1=1", "nombre");
$ca->exec();
$rCategorias = $ca->assocAll();

function MembresiasFormNuevo() {
    global $rCategorias;
    $IdCiudad = $_SESSION["IdCiudad"];
    ?>
    <form method="post" action="membresias.php?Accion=Guardar">
        <input TYPE="hidden" id="txtId" name="txtId" value="0"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA MEMBRESIA</b></td>
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
                <td class="tituloNombres">Categorias:</td>
                <td class="contenidoNombres">
                    <select name="idscategorias[]" multiple style="width: 450px;">
                        <?php foreach ($rCategorias as $r): ?>
                            <option value="<?php echo $r["idcategoria"]; ?>"><?php echo $r["nombre"]; ?></option>
                        <?php endforeach; ?>
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
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="membresias_listar.php">
                        <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/>
                    </a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}

###############################################################################
?>
<?php

function MembresiasGuardar($nId, $nombre, $idsCategoria) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    if ($nId <= 0) {
        $ca->prepareInsert("tblmb_membresias", "idmembresia,nombre");
        $ca->bindValue(":idmembresia", $nId, false);
        $ca->bindValue(":nombre", $nombre, true);

        if (!$ca->exec()) {
            Mensaje("Error registrando nueva membresia.", "membresias_listar.php");
            exit;
        }
        
        $nId = mysqli_insert_id($nConexion);

        foreach ($idsCategoria as $k => $v) {
            $ca->prepareInsert("tblmb_membresias_categorias", "idmembresia,idcategoria");
            $ca->bindValue(":idmembresia", $nId, false);
            $ca->bindValue(":idcategoria", $v, false);
            if (!$ca->exec()) {
                Mensaje("Error registrando membresias categorias.", "membresias_listar.php");
                exit;
            }
        }

        mysqli_close($nConexion);
        Mensaje("El registro ha sido almacenado correctamente.", "membresias_listar.php");
        return;
    } else {
        $ca->prepareUpdate("tblmb_membresias", "nombre", "idmembresia=:idmembresia");
        $ca->bindValue(":idmembresia", $nId, false);
        $ca->bindValue(":nombre", $nombre, true);

        if (!$ca->exec()) {
            Mensaje("Error actualizando membresia {$nId}", "membresias_listar.php");
            exit;
        }

        $ca->prepareDelete("tblmb_membresias_categorias", "idmembresia=:idmembresia");
        $ca->bindValue(":idmembresia", $nId, false);
        if (!$ca->exec()) {
            mysqli_close($nConexion);
            Mensaje("Fallo eliminando membresias categorias {$nId}", "membresias_listar.php");
            exit;
        }

        foreach ($idsCategoria as $k => $v) {
            $ca->prepareInsert("tblmb_membresias_categorias", "idmembresia,idcategoria");
            $ca->bindValue(":idmembresia", $nId, false);
            $ca->bindValue(":idcategoria", $v, false);
            if (!$ca->exec()) {
                Mensaje("Error actulizando membresias categorias.", "membresias_listar.php");
                exit;
            }
        }


        mysqli_close($nConexion);
        Mensaje("El registro ha sido actualizado correctamente.", "membresias_listar.php");
        return;
    }
}
?>
<?php

function MembresiasEliminar($nId) {
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareDelete("tblmb_membresias", "idmembresia=:idmembresia");
    $ca->bindValue(":idmembresia", $nId, false);

    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando membresia {$nId}", "membresias_listar.php");
        exit;
    }

    $ca->prepareDelete("tblmb_membresias_categorias", "idmembresia=:idmembresia");
    $ca->bindValue(":idmembresia", $nId, false);
    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando membresias categorias {$nId}", "membresias_listar.php");
        exit;
    }

    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "membresias_listar.php");
    exit();
}
?>
<?php

function MembresiasFormEditar($nId) {
    global $rCategorias;
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tblmb_membresias", "*", "idmembresia=:idmembresia");
    $ca->bindValue(":idmembresia", $nId, false);
    $ca->exec();

    $Registro = $ca->fetch();

    $ca->prepareSelect("tblmb_membresias_categorias", "idcategoria", "idmembresia=:idmembresia");
    $ca->bindValue(":idmembresia", $Registro["idmembresia"], false);
    $ca->exec();

    $rMC = $ca->fetchAll();

    foreach ($rMC as $r) {
        $rCategoriasE[] = $r["idcategoria"];
    }

    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="membresias.php?Accion=Guardar">
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR MEMBRESIA</b></td>
            </tr>

        </table>

        <table width="100%">
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres">
                    <input type="text" id="nombre" name="nombre" value="<?php echo $Registro["nombre"] ?>"/>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Categorias:</td>
                <td class="contenidoNombres">
                    <select name="idscategorias[]" multiple style="width: 450px;">
                        <?php foreach ($rCategorias as $r): ?>
                            <option value="<?php echo $r["idcategoria"]; ?>" <?php echo in_array($r["idcategoria"], $rCategoriasE) ? "selected" : ""; ?>><?php echo $r["nombre"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="membresias.php?Accion=Eliminar&Id=<?php echo $nId; ?>">
                        <img src="../../image/eliminar.gif"
                             border="0" alt="Eliminar Registro."
                             onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"/>
                    </a>
                    <a href="membresias_listar.php">
                        <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/>
                    </a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>
