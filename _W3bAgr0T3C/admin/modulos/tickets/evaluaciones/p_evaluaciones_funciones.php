<?php
require_once("../../../funciones_generales.php");
require_once("../../../herramientas/paginar/dbquery.inc.php");

function EvaluacionesFormNuevo() {
    $IdCiudad = $_SESSION["IdCiudad"];
    ?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="p_evaluaciones.php?Accion=Guardar">
        <input TYPE="hidden" id="txtId" name="txtId" value="0">
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
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="p_evaluaciones_listar.php"><img src="../../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}

###############################################################################
?>
<?php

function EvaluacionesGuardar($nId, $nombre) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    if ($nId <= 0) {
        $ca->prepareInsert("tbltk_pevaluaciones", "nombre");
        $ca->bindValue(":nombre", $nombre, true);

        if (!$ca->exec()) {
            Mensaje("Error registrando nueva evaluaci�n.", "p_evaluaciones_listar.php");
            exit;
        }
        mysqli_close($nConexion);
        Mensaje("El registro ha sido almacenado correctamente.", "p_evaluaciones_listar.php");
        return;
    } else {
        $ca->prepareUpdate("tbltk_pevaluaciones", "nombre", "idevaluacion=:idevaluacion");
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":idevaluacion", $nId, false);

        if (!$ca->exec()) {
            Mensaje("Error actualizando evaluaci�n {$nId}", "p_evaluaciones_listar.php");
            exit;
        }
        mysqli_close($nConexion);
        Mensaje("El registro ha sido actualizado correctamente.", "p_evaluaciones_listar.php");
        return;
    }
}
?>
<?php

function EvaluacionesEliminar($nId) {
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareDelete("tbltk_pevaluaciones", "idevaluacion=:idevaluacion");
    $ca->bindValue(":idevaluacion", $nId, false);

    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando evaluacion {$nId}", "p_evaluaciones_listar.php");
        exit;
    }
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "p_evaluaciones_listar.php");
    exit();
}
?>
<?php

function EvaluacionesFormEditar($nId) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tbltk_pevaluaciones", "*", "idevaluacion=:idevaluacion");
    $ca->bindValue(":idevaluacion", $nId, false);
    $ca->exec();

    $Registro = $ca->assoc();
    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="p_evaluaciones.php?Accion=Guardar" >
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR EVALUACI�N</b></td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres"><input type="text" id="nombre" name="nombre" value="<?php echo $Registro["nombre"] ?>"/></td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="p_evaluaciones.php?Accion=Eliminar&Id=<?php echo $nId; ?>">
                        <img src="../../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"/>
                    </a>
                    <a href="p_evaluaciones_listar.php">
                        <img src="../../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/>
                    </a>
                </td>
            </tr>
        </table>
    </form>
<?php
}
?>
<?php

function EvaluacionesFormEvaluar($idsede) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tbltk_sedes a join tbltk_pevaluaciones b on (a.idevaluacion=b.idevaluacion)", 
            "a.nombre as sede,b.nombre as evaluacion", 
            "a.idsede=:idsede");
    $ca->bindValue(":idsede", $idsede, false);
    $ca->exec();

    $enc = $ca->fetch();
    
    $campos = "b.idconcepto,b.descripcion as pregunta";
    $ca->prepareSelect("tbltk_sedes a join tbltk_pevaluaciones_det b on (a.idevaluacion=b.idevaluacion)", 
            $campos, 
            "a.idsede=:idsede");
    $ca->bindValue(":idsede", $idsede, false);
    $ca->exec();

    $det = $ca->fetchAll();
    
    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="p_evaluaciones.php?Accion=GuardarEvaluar" >
        <input TYPE="hidden" id="txtId" name="idsede" value="<?php echo $idsede; ?>"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EVALUACI�N SEDE <?php echo $enc["sede"];?></b></td>
            </tr>
        </table>

        <table width="100%">
            <?php foreach ($det as $r):?>
            <tr>
                <td class="tituloNombres"><?php echo $r["pregunta"];?>:</td>
            </tr>
            <tr>
                <td class="contenidoNombres">
                    Calificaci�n: <select name="<?php echo $r["idconcepto"];?>">
                        <option value="0" selected></option>
                    <?php for( $i = 1; $i <= 5; $i++ ):?>
                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                    <?php endfor;?>
                    </select>
                </td>
            </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../../image/guardar.gif" alt="Guardar Evaluaci�n."/>
                    <a href="../sedes_listar.php">
                        <img src="../../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/>
                    </a>
                </td>
            </tr>
        </table>
    </form>
<?php
}
?>

<?php

function EvaluacionesGuardarEvaluar($p) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    
    $ca = new DbQuery($nConexion);
    //echo print_r($p,1);
    
    $campos = "b.idconcepto";
    $ca->prepareSelect("tbltk_sedes a join tbltk_pevaluaciones_det b on (a.idevaluacion=b.idevaluacion)", 
            $campos, 
            "a.idsede=:idsede");
    $ca->bindValue(":idsede", $p["idsede"], false);
    $ca->exec();

    $rConceptos = $ca->fetchAll();
    
    $ca->prepareInsert("tbltk_evaluaciones_vals", "idsede,fechahora");
    $ca->bindValue(":idsede", $p["idsede"], false);
    $ca->bindValue(":fechahora", "current_timestamp", false);
    if (!$ca->exec()) {
        Mensaje("Error registrando encabezado de evaluaci�n.", "../sedes_listar.php");
        exit;
    }
    
    $ca->prepareSelect("tbltk_evaluaciones_vals", "max(idevaluacion) as idevaluacion", "idsede=:idsede");
    $ca->bindValue(":idsede", $p["idsede"], false);
    $ca->exec();
    $rEvaluacion = $ca->fetch();
    
    foreach ( $rConceptos as $r ) {
        if( isset($p[$r["idconcepto"]])) {
            $ca->prepareInsert("tbltk_evaluaciones_vals_det", "idconcepto,idevaluacion,valor");
            $ca->bindValue(":idconcepto", $r["idconcepto"], false);
            $ca->bindValue(":idevaluacion", $rEvaluacion["idevaluacion"], false);
            $ca->bindValue(":valor", $p[$r["idconcepto"]], false);
            if (!$ca->exec()) {
                Mensaje("Error registrando detalle de evaluacion.", "../sedes_listar.php");
                exit;
            }
        }
    }
    
    mysqli_close($nConexion);
    Mensaje("La evaluaci�n ha sido almacenada correctamente.", "../sedes_listar.php");
    return;
}
?>