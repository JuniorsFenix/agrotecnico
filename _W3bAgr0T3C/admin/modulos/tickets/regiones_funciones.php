<?php
require_once("../../funciones_generales.php");
require_once("../../herramientas/paginar/dbquery.inc.php");

$nConexion = Conectar();
$ca = new DbQuery($nConexion);
$ca->prepareSelect("tbltk_empresas", 
        "*");
$ca->exec();
$rEmpresas = $ca->assocAll();
mysqli_close($nConexion);

function RegionesFormNuevo() {
    $IdCiudad = $_SESSION["IdCiudad"];
    global $rEmpresas;
    ?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="regiones.php?Accion=Guardar">
        <input TYPE="hidden" id="txtId" name="txtId" value="0"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA REGION</b></td>
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
                <td class="tituloNombres">Empresa:</td>
                <td class="contenidoNombres">
                    <select name="idempresa">
                        <?php foreach ( $rEmpresas as $r ):?>
                        <option value="<?php echo $r["idempresa"]?>"><?php echo $r["nombre"]?></option>
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
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="regiones_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}

###############################################################################
?>
<?php

function RegionesGuardar($nId, $nombre, $idempresa) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    if ($nId <= 0) {
        
        //Registrando empresa
        $ca->prepareInsert("tbltk_regiones", "nombre,idempresa");
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":idempresa", $idempresa, false);

        if (!$ca->exec()) {
            Mensaje("Error registrando nueva region.", "regiones_listar.php");
            exit;
        }
        
        mysqli_close($nConexion);
        Mensaje("El registro ha sido almacenado correctamente.", "regiones_listar.php");
        return;
    } else {
        $ca->prepareUpdate("tbltk_regiones", "nombre,idempresa", "idregion=:idregion");
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":idregion", $nId, false);
        $ca->bindValue(":idempresa", $idempresa, false);
        
        if (!$ca->exec()) {
            Mensaje("Error actualizando region {$nId}", "regiones_listar.php");
            exit;
        }
        
        mysqli_close($nConexion);
        Mensaje("El registro ha sido actualizado correctamente.", "regiones_listar.php");
        return;
    }
}
?>
<?php

function RegionesEliminar($nId) {
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareDelete("tbltk_regiones", "idregion=:idregion");
    $ca->bindValue(":idregion", $nId, false);

    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando region {$nId}", "regiones_listar.php");
        exit;
    }
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "regiones_listar.php");
    exit();
}
?>
<?php

function RegionesFormEditar($nId) {
    $IdCiudad = $_SESSION["IdCiudad"];
    global $rEmpresas;
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tbltk_regiones", "*", "idregion=:idregion");
    $ca->bindValue(":idregion", $nId, false);
    $ca->exec();

    $Registro = $ca->assoc();
    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="regiones.php?Accion=Guardar" >
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR REGION</b></td>
            </tr>

        </table>

        <table width="100%">
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres"><input type="text" id="nombre" name="nombre" value="<?php echo $Registro["nombre"] ?>"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Empresa:</td>
                <td class="contenidoNombres">
                    <select name="idempresa">
                        <?php foreach ( $rEmpresas as $r ):?>
                        <option value="<?php echo $r["idempresa"]?>" <?php echo $r["idempresa"]==$Registro["idempresa"]?"selected":"";?>><?php echo $r["nombre"]?></option>
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
                    <a href="regiones.php?Accion=Eliminar&Id=<?php echo $nId; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
                    <a href="regiones_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
                </td>
            </tr>
        </table>
    </form>
<?php
}
?>
