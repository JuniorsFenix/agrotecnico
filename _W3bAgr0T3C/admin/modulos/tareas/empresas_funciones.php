<?php
require_once("../../funciones_generales.php");
require_once("../../herramientas/paginar/dbquery.inc.php");

function EmpresasFormNuevo() {
    $IdCiudad = $_SESSION["IdCiudad"];
    ?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="empresas.php?Accion=Guardar">
        <input TYPE="hidden" id="txtId" name="txtId" value="0">
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA EMPRESA</b></td>
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
                    <a href="empresas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}

###############################################################################
?>
<?php

function EmpresasGuardar($nId, $nombre) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $ca = new DbQuery($nConexion);
    if ($nId <= 0) {
        
        //Creando lista de boletines
        $ca->prepareInsert("tblboletineslistas", "nombre");
        $ca->bindValue(":nombre", $nombre, true);
        if (!$ca->exec()) {
            Mensaje("Error creando lista de correos para boletines.", "empresas_listar.php");
            exit;
        }
        
        $idLista = mysqli_insert_id($nConexion);
        
        //Registrando empresa
        $ca->prepareInsert("tbltk_empresas", "nombre,idlista");
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":idlista", $idLista, false);

        if (!$ca->exec()) {
            Mensaje("Error registrando nueva empresa.", "empresas_listar.php");
            exit;
        }
        
        mysqli_close($nConexion);
        Mensaje("El registro ha sido almacenado correctamente.", "empresas_listar.php");
        return;
    } else {
        $ca->prepareSelect("tbltk_empresas", "idlista", "idempresa=:idempresa");
        $ca->bindValue(":idempresa", $nId, false);
        $ca->exec();
        
        $rEmpresa = $ca->fetch();
        
        $ca->prepareUpdate("tbltk_empresas", "nombre", "idempresa=:idempresa");
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":idempresa", $nId, false);

        if (!$ca->exec()) {
            Mensaje("Error actualizando empresa {$nId}", "empresas_listar.php");
            exit;
        }
        
        //actualizando lista de boletines
        $ca->prepareUpdate("tblboletineslistas", "nombre", "idlista=:idlista");
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":idlista", $rEmpresa["idlista"], false);
        $ca->exec();
        
        mysqli_close($nConexion);
        Mensaje("El registro ha sido actualizado correctamente.", "empresas_listar.php");
        return;
    }
}
?>
<?php

function EmpresasEliminar($nId) {
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $ca = new DbQuery($nConexion);
    $ca->prepareDelete("tbltk_empresas", "idempresa=:idempresa");
    $ca->bindValue(":idempresa", $nId, false);

    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando empresa {$nId}", "empresas_listar.php");
        exit;
    }
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "empresas_listar.php");
    exit();
}
?>
<?php

function EmpresasFormEditar($nId) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tbltk_empresas", "*", "idempresa=:idempresa");
    $ca->bindValue(":idempresa", $nId, false);
    $ca->exec();

    $Registro = $ca->assoc();
    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edición / Eliminación de Empresas -->
    <form method="post" action="empresas.php?Accion=Guardar" >
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>">
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR EMPRESA</b></td>
            </tr>

        </table>

        <table width="100%">
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres"><input type="text" id="nombre" name="nombre" value="<?php echo $Registro["nombre"] ?>"></td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="empresas.php?Accion=Eliminar&Id=<?php echo $nId; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('¿Esta seguro que desea eliminar este registro?')"></a>
                    <a href="empresas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
                </td>
            </tr>
        </table>
    </form>
<?php
}
?>
