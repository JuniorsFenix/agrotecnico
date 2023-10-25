<?php
require_once("../../funciones_generales.php");
require_once("../../herramientas/paginar/dbquery.inc.php");

function EvaluacionesFormNuevo() {
    $IdCiudad = $_SESSION["IdCiudad"];
    ?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="evaluaciones.php?Accion=Guardar" >
        <input TYPE="hidden" id="txtId" name="txtId" value="0"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA EVALUACI�N</b></td>
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
                <td class="tituloNombres">Fecha publicaci�n:</td>
                <td class="contenidoNombres"><input type="text" id="nombre" name="fecha_publicacion" value=""/></td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
                    <a href="evaluaciones_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}

###############################################################################
?>
<?php

function EvaluacionesGuardar($nId, $nombre, $fecha_publicacion) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    if ($nId <= 0) {
        $ca->prepareInsert("tbl_pevaluaciones_publicas", "nombre,fecha_publicacion,url_id");
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":fecha_publicacion", $fecha_publicacion, true);
        $ca->bindValue(":url_id", substr(hash("sha256",microtime()), 2, 5), true);
        
        if (!$ca->exec()) {
            Mensaje("Error registrando nueva evaluaci�n.", "evaluaciones_listar.php");
            exit;
        }

        $mensaje = "El registro ha sido almacenado correctamente.";
    } else {
        $ca->prepareUpdate("tbl_pevaluaciones_publicas", "nombre,fecha_publicacion", "idevaluacion=:idevaluacion");
        $ca->bindValue(":idevaluacion", $nId, false);
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":fecha_publicacion", $fecha_publicacion, true);

        if (!$ca->exec()) {
            Mensaje("Error actualizando evaluaci�n {$nId}", "evaluaciones_listar.php");
            exit;
        }

        $mensaje = "El registro ha sido actualizado correctamente.";
    }

    mysqli_close($nConexion);
    Mensaje($mensaje, "evaluaciones_listar.php");
    exit;
}
?>
<?php

function EvaluacionesEliminar($nId) {
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    
    $ca->prepareDelete("tbl_pevaluaciones_publicas", "idevaluacion=:idevaluacion");
    $ca->bindValue(":idevaluacion", $nId, false);
    
    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando evaluacion {$nId}", "evaluaciones_listar.php");
        exit;
    }
    
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "evaluaciones_listar.php");
    exit();
}
?>
<?php

function EvaluacionesFormEditar($nId) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tbl_pevaluaciones_publicas", "*", "idevaluacion=:idevaluacion");
    $ca->bindValue(":idevaluacion", $nId, false);
    $ca->exec();
    
    $Registro = $ca->assoc();
    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="evaluaciones.php?Accion=Guardar">
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR EVALUACI�N PUBLICA</b></td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres"><input type="text" id="nombre" name="nombre" value="<?php echo $Registro["nombre"];?>"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Fecha publicaci�n:</td>
                <td class="contenidoNombres"><input type="text" id="nombre" name="fecha_publicacion" value="<?php echo $Registro["fecha_publicacion"];?>"/></td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="evaluaciones.php?Accion=Eliminar&Id=<?php echo $nId; ?>">
                        <img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"/>
                    </a>
                    <a href="evaluaciones_listar.php">
                        <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/>
                    </a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>
