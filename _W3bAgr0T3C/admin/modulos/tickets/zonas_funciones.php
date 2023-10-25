<?php
require_once("../../funciones_generales.php");
require_once("../../herramientas/paginar/dbquery.inc.php");

$nConexion = Conectar();
$ca = new DbQuery($nConexion);
$ca->prepareSelect("tbltk_regiones a join tbltk_empresas b on (a.idempresa=b.idempresa)", 
        "a.idregion,concat(a.nombre,' - ',b.nombre) as nombre");
$ca->exec();
$rRegiones = $ca->assocAll();
mysqli_close($nConexion);

function ZonasFormNuevo() {
    $IdCiudad = $_SESSION["IdCiudad"];
    global $rRegiones;
    ?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="zonas.php?Accion=Guardar">
        <input TYPE="hidden" id="txtId" name="txtId" value="0">
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA ZONA</b></td>
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
                <td class="tituloNombres">Region:</td>
                <td class="contenidoNombres">
                    <select name="idregion">
                        <?php foreach ( $rRegiones as $r ):?>
                        <option value="<?php echo $r["idregion"]?>"><?php echo $r["nombre"]?></option>
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
                    <a href="zonas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}

###############################################################################
?>
<?php

function ZonasGuardar($nId, $nombre, $idregion) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    if ($nId <= 0) {
        
        //Registrando empresa
        $ca->prepareInsert("tbltk_zonas", "nombre,idregion");
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":idregion", $idregion, false);

        if (!$ca->exec()) {
            Mensaje("Error registrando nueva zona.", "zonas_listar.php");
            exit;
        }
        
        mysqli_close($nConexion);
        Mensaje("El registro ha sido almacenado correctamente.", "zonas_listar.php");
        return;
    } else {
        $ca->prepareUpdate("tbltk_zonas", "nombre,idregion", "idzona=:idzona");
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":idzona", $nId, false);
        $ca->bindValue(":idregion", $idregion, false);
        
        if (!$ca->exec()) {
            Mensaje("Error actualizando zona {$nId}", "zonas_listar.php");
            exit;
        }
        
        mysqli_close($nConexion);
        Mensaje("El registro ha sido actualizado correctamente.", "zonas_listar.php");
        return;
    }
}
?>
<?php

function ZonasEliminar($nId) {
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareDelete("tbltk_zonas", "idzona=:idzona");
    $ca->bindValue(":idzona", $nId, false);

    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando zona {$nId}", "zonas_listar.php");
        exit;
    }
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "zonas_listar.php");
    exit();
}
?>
<?php

function ZonasFormEditar($nId) {
    $IdCiudad = $_SESSION["IdCiudad"];
    global $rRegiones;
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tbltk_zonas", "*", "idzona=:idzona");
    $ca->bindValue(":idzona", $nId, false);
    $ca->exec();

    $Registro = $ca->assoc();
    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="zonas.php?Accion=Guardar" >
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR ZONA</b></td>
            </tr>

        </table>

        <table width="100%">
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres"><input type="text" id="nombre" name="nombre" value="<?php echo $Registro["nombre"] ?>"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Region:</td>
                <td class="contenidoNombres">
                    <select name="idregion">
                        <?php foreach ( $rRegiones as $r ):?>
                        <option value="<?php echo $r["idregion"]?>" <?php echo $r["idregion"]==$Registro["idregion"]?"selected":"";?>><?php echo $r["nombre"]?></option>
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
                    <a href="zonas.php?Accion=Eliminar&Id=<?php echo $nId; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
                    <a href="zonas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
                </td>
            </tr>
        </table>
    </form>
<?php
}
?>
