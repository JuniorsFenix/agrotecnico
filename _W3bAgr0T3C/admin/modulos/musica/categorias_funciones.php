<?php
require_once("../../funciones_generales.php");
require_once("../../herramientas/paginar/dbquery.inc.php");

function CategoriasFormNuevo() {
    $IdCiudad = $_SESSION["IdCiudad"];
    ?>
    <form method="post" action="categorias.php?Accion=Guardar">
        <input TYPE="hidden" id="txtId" name="txtId" value="0"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA CATEGORIA MP3</b></td>
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
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="categorias_listar.php">
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

function CategoriasGuardar($nId, $nombre) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    if ($nId <= 0) {
        $ca->prepareInsert("tblcategoriasmusica", "idcategoria,nombre");
        $ca->bindValue(":idcategoria", $nId, false);
        $ca->bindValue(":nombre", $nombre, true);

        if (!$ca->exec()) {
            Mensaje("Error registrando nueva categoria.", "categorias_listar.php");
            exit;
        }
        
        mysqli_close($nConexion);
        Mensaje("El registro ha sido almacenado correctamente.", "categorias_listar.php");
        return;
    } else {
        $ca->prepareUpdate("tblcategoriasmusica", "nombre", "idcategoria=:idcategoria");
        $ca->bindValue(":idcategoria", $nId, false);
        $ca->bindValue(":nombre", $nombre, true);

        if (!$ca->exec()) {
            Mensaje("Error actualizando categoria {$nId}", "categorias_listar.php");
            exit;
        }

        mysqli_close($nConexion);
        Mensaje("El registro ha sido actualizado correctamente.", "categorias_listar.php");
        return;
    }
}
?>
<?php

function CategoriasEliminar($nId) {
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareDelete("tblcategoriasmusica", "idcategoria=:idcategoria");
    $ca->bindValue(":idcategoria", $nId, false);

    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando categoria {$nId}", "categorias_listar.php");
        exit;
    }

    $ca->prepareDelete("tblmb_membresias_categorias", "idcategoria=:idcategoria");
    $ca->bindValue(":idcategoria", $nId, false);
    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando membresias categorias {$nId}", "categorias_listar.php");
        exit;
    }

    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "categorias_listar.php");
    exit();
}
?>
<?php

function CategoriasFormEditar($nId) {
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tblcategoriasmusica", "*", "idcategoria=:idcategoria");
    $ca->bindValue(":idcategoria", $nId, false);
    $ca->exec();

    $Registro = $ca->fetch();

    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="categorias.php?Accion=Guardar">
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CATEGORIA MP3</b></td>
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
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="categorias.php?Accion=Eliminar&Id=<?php echo $nId; ?>">
                        <img src="../../image/eliminar.gif"
                             border="0" alt="Eliminar Registro."
                             onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"/>
                    </a>
                    <a href="categorias_listar.php">
                        <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/>
                    </a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>
