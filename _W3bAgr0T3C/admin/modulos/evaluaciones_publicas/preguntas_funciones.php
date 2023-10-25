<?php
require_once("../../funciones_generales.php");
require_once("../../herramientas/paginar/dbquery.inc.php");

$nConexion = Conectar();
$ca = new DbQuery($nConexion);
$ca->prepareSelect("tbl_pevaluaciones_publicas", "*");
$ca->exec();
$rEvaluaciones = $ca->assocAll();
mysqli_close($nConexion);

function PreguntasFormNuevo() {
    global $rEvaluaciones;
    $IdCiudad = $_SESSION["IdCiudad"];
    ?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="preguntas.php?Accion=Guardar" enctype="multipart/form-data">
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
                    <?php
                    /*$oFCKeditor = new FCKeditor('pregunta');
                    $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
                    $oFCKeditor->Create();
                    $oFCKeditor->Width = '100%';
                    $oFCKeditor->Height = '50';*/
                    ?>
                    <textarea name="pregunta"></textarea>
                    <script>
                        CKEDITOR.replace( 'pregunta' );
                    </script>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Detalle:</td>
                <td class="contenidoNombres">
                    <?php
                   /*$oFCKeditor = new FCKeditor('detalle');
                    $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
                    $oFCKeditor->Create();
                    $oFCKeditor->Width = '100%';
                    $oFCKeditor->Height = '200';*/
                    ?>
                    <textarea name="detalle"></textarea>
                    <script>
                        CKEDITOR.replace( 'detalle' );
                    </script>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Imagen:</td>
                <td class="contenidoNombres"><input type="file" id="nombre" name="imagen" value=""/></td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
                    <a href="preguntas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}

###############################################################################
?>
<?php

function PreguntasGuardar($nId, $idEvaluacion, $pregunta, $detalle, $imagen) {
    global $cRutaEvaluacionesPublicas;
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    if ($nId <= 0) {
        $ca->prepareInsert("tbl_pevaluaciones_publicas_det", "idevaluacion,pregunta,detalle");
        $ca->bindValue(":idevaluacion", $idEvaluacion, false);
        $ca->bindValue(":pregunta", $pregunta, true);
        $ca->bindValue(":detalle", $detalle, true);

        if (!$ca->exec()) {
            Mensaje("Error registrando nueva pregunta.", "preguntas_listar.php");
            exit;
        }

        $nId = mysqli_insert_id($nConexion);

        $mensaje = "El registro ha sido almacenado correctamente.";
    } else {
        $ca->prepareUpdate("tbl_pevaluaciones_publicas_det", "idevaluacion,pregunta,detalle", "idpregunta=:idpreunta");
        $ca->bindValue(":idpregunta", $nId, false);
        $ca->bindValue(":idevaluacion", $idEvaluacion, false);
        $ca->bindValue(":pregunta", $pregunta, true);
        $ca->bindValue(":detalle", $detalle, true);

        if (!$ca->exec()) {
            Mensaje("Error actualizando evaluaci�n {$nId}", "preguntas_listar.php");
            exit;
        }

        $mensaje = "El registro ha sido actualizado correctamente.";
    }
    
    if (isset($imagen)) {
        $upload_dir = $cRutaEvaluacionesPublicas;
        
        if ( !file_exists($cRutaEvaluacionesPublicas) ) {
            mkdir($cRutaEvaluacionesPublicas);
            chmod($cRutaEvaluacionesPublicas, 0755);
        }
        
        $f = $imagen;
        $name = "";
        if ($f["name"] != "") {
            $name = "{$nId}_{$f["name"]}";
            if ($f["error"] == UPLOAD_ERR_OK) {
                if (!move_uploaded_file($f["tmp_name"], $upload_dir . $name)) {
                    die("Fallo cargando archivo al servidor");
                }
            }
        }

        $ca->prepareUpdate("tbl_pevaluaciones_publicas_det", "imagen", "idpregunta=:idpregunta");
        $ca->bindValue(":imagen", $name, true);
        $ca->bindValue(":idpregunta", $nId, false);
        $ca->exec();
    }

    mysqli_close($nConexion);
    Mensaje($mensaje, "preguntas_listar.php");
    exit;
}
?>
<?php

function PreguntasEliminar($nId) {
    global $cRutaEvaluacionesPublicas;
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tbl_pevaluaciones_publicas_det", "imagen", "idpregunta=:idpregunta");
    $ca->bindValue(":idpregunta", $nId, false);
    $ca->exec();
    $rPregunta = $ca->fetch();
    
    $ca->prepareDelete("tbl_pevaluaciones_publicas_det", "idpregunta=:idpregunta");
    $ca->bindValue(":idpregunta", $nId, false);
    
    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando evaluacion {$nId}", "preguntas_listar.php");
        exit;
    }
    
    unlink($cRutaEvaluacionesPublicas.$rPregunta["imagen"]);
    
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "preguntas_listar.php");
    exit();
}
?>
<?php

function PreguntasFormEditar($nId) {
    global $rEvaluaciones;
    global $cRutaVerEvaluacionesPublicas;
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tbl_pevaluaciones_publicas_det", "*", "idpregunta=:idpregunta");
    $ca->bindValue(":idpregunta", $nId, false);
    $ca->exec();

    $Registro = $ca->assoc();
    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="preguntas.php?Accion=Guardar"enctype="multipart/form-data">
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR PREGUNTAS EVALUACI�N PUBLICA</b></td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td class="tituloNombres">Evaluaci�n:</td>
                <td class="contenidoNombres">
                    <select name="idevaluacion">
                        <?php foreach ($rEvaluaciones as $r):?>
                        <option value="<?php echo $r["idevaluacion"];?>" <?php echo $Registro["idevaluacion"]==$r["idevaluacion"]?"selected":"";?>><?php echo $r["nombre"];?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Pregunta:</td>
                <td class="contenidoNombres">
                    <?php
                    /*$oFCKeditor = new FCKeditor('pregunta');
                    $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
                    $oFCKeditor->Value = $Registro["pregunta"];
                    $oFCKeditor->Create();
                    $oFCKeditor->Width = '100%';
                    $oFCKeditor->Height = '50';*/
                    ?>
                    <textarea name="pregunta"><? echo $Registro["pregunta"]?></textarea>
                    <script>
                        CKEDITOR.replace( 'pregunta' );
                    </script>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Detalle:</td>
                <td class="contenidoNombres">
                    <?php
                    /*$oFCKeditor = new FCKeditor('detalle');
                    $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
                    $oFCKeditor->Value = $Registro["detalle"];
                    $oFCKeditor->Create();
                    $oFCKeditor->Width = '100%';
                    $oFCKeditor->Height = '200';*/
                    ?>
                    <textarea name="detalle"><? echo $Registro["detalle"]?></textarea>
                    <script>
                        CKEDITOR.replace( 'detalle' );
                    </script>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Imagen:</td>
                <td class="contenidoNombres"><input type="file" id="nombre" name="imagen" value=""/>
                    <?php if ( $Registro["imagen"] != "" ) :?>
                    <br/>
                    Imagen actual:<br/>
                    <img src="<?php echo"{$cRutaVerEvaluacionesPublicas}{$Registro["imagen"]}";?>" />
                    <?php endif;?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="preguntas.php?Accion=Eliminar&Id=<?php echo $nId; ?>">
                        <img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"/>
                    </a>
                    <a href="preguntas_listar.php">
                        <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/>
                    </a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>
