<?php
require_once("../../../funciones_generales.php");
require_once("../../../herramientas/paginar/dbquery.inc.php");

$nConexion = Conectar();
$ca = new DbQuery($nConexion);
$ca->prepareSelect("tbltk_pevaluaciones", "*");
$ca->exec();
$rEvaluaciones = $ca->assocAll();
mysqli_close($nConexion);

function PreguntasFormNuevo() {
    global $rEvaluaciones;
    $IdCiudad = $_SESSION["IdCiudad"];
    ?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="preguntas.php?Accion=Guardar">
        <input TYPE="hidden" id="txtId" name="txtId" value="0"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA PREGUNTA</b></td>
            </tr>
        </table>
        <br/>
        <br/>
        <br/>
        <br/>
        <table width="100%">
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
                <td class="tituloNombres">Pregunta:</td>
                <td class="contenidoNombres">
                    <textarea name="descripcion" cols="45" rows="5" id="descripcion"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="preguntas_listar.php">
                        <img src="../../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/>
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
/*- Ciudad
- Pais
- Contacto directo
- Email Contacto
- Email Sede
- Direcci�n
- Tel�fono sede
- Gremio*/
function PreguntasGuardar($nId, $descripcion, $idevaluacion ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $campos = "descripcion,idevaluacion";
    $ca = new DbQuery($nConexion);
    if ($nId <= 0) {
        $ca->prepareInsert("tbltk_pevaluaciones_det", $campos);
        $ca->bindValue(":descripcion", $descripcion, true);
        $ca->bindValue(":idevaluacion", $idevaluacion, false);

        if (!$ca->exec()) {
            Mensaje("Error registrando nueva Pregunta.", "preguntas_listar.php");
            exit;
        }
        mysqli_close($nConexion);
        Mensaje("El registro ha sido almacenado correctamente.", "preguntas_listar.php");
        return;
    } else {
        $ca->prepareUpdate("tbltk_pevaluaciones_det", $campos, "idconcepto=:idconcepto");
        $ca->bindValue(":descripcion", $descripcion, true);
        $ca->bindValue(":idconcepto", $nId, false);
        $ca->bindValue(":idevaluacion", $idevaluacion, false);

        if (!$ca->exec()) {
            Mensaje("Error actualizando Pregunta {$nId}", "preguntas_listar.php");
            exit;
        }
        mysqli_close($nConexion);
        Mensaje("El registro ha sido actualizado correctamente.", "preguntas_listar.php");
        return;
    }
}
?>
<?php

function PreguntasEliminar($nId) {
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareDelete("tbltk_pevaluaciones_det", "idconcepto=:idconcepto");
    $ca->bindValue(":idconcepto", $nId, false);

    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando pregunta {$nId}", "preguntas_listar.php");
        exit;
    }
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "preguntas_listar.php");
    exit();
}
?>
<?php

function PreguntasFormEditar($nId) {
    global $rEvaluaciones;
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tbltk_pevaluaciones_det", "*", "idconcepto=:idconcepto");
    $ca->bindValue(":idconcepto", $nId, false);
    $ca->exec();

    $Registro = $ca->assoc();
    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="preguntas.php?Accion=Guardar" >
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR PREGUNTA</b></td>
            </tr>
        </table>

        <table width="100%">
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
                <td class="tituloNombres">Pregunta:</td>
                <td class="contenidoNombres">
                    <input type="text" id="descripcion" name="descripcion" value="<?php echo $Registro["descripcion"] ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="preguntas.php?Accion=Eliminar&Id=<?php echo $nId; ?>"><img src="../../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
                    <a href="preguntas_listar.php"><img src="../../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
                </td>
            </tr>
        </table>
    </form>
<?php
}
?>
