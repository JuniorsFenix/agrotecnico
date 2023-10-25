<?php
require_once ("../../funciones_generales.php");
require_once ("../../vargenerales.php");
require_once ("../../herramientas/paginar/dbquery.inc.php");

$nConexion = Conectar();
$ca = new DbQuery($nConexion);
$ca->prepareSelect("tblmb_categorias", "idcategoria,nombre", "1=1", "nombre");
$ca->exec();
$rCategoriasA = $ca->assocAll();
?>

<?php

function ArchivosFormNuevo() {
    global $rCategoriasA;
    ?>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
    <!-- Formulario Ingreso de Contenidos -->
    <form method="post" action="archivos.php?Accion=Guardar" enctype="multipart/form-data">
        <input TYPE="hidden" id="txtId" name="txtId" value="0"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO ARCHIVO MEMBRESIA</b></td>
            </tr>
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres"><INPUT id="nombre" type="text" name="nombre" style="width: 450px;" /></td>
            </tr>
            <tr>
                <td class="tituloNombres">Categorias:</td>
                <td class="contenidoNombres">
                    <select name="idscategorias[]" multiple style="width: 450px;">
                        <?php foreach ($rCategoriasA as $r): ?>
                            <option value="<?php echo $r["idcategoria"]; ?>"><?php echo $r["nombre"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Contenido:</td>
                <td class="contenidoNombres">
                    <?php
                    /*$oFCKeditor = new FCKeditor('contenido');
                    $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
                    $oFCKeditor->Create();
                    $oFCKeditor->Width = '100%';
                    $oFCKeditor->Height = '400';*/
                    ?>
                    <textarea name="contenido"></textarea>
                    <script>
                        CKEDITOR.replace( 'contenido' );
                    </script>/*
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Archivo:</td>
                <td class="contenidoNombres"><input type="file" id="foto" name="archivo"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Url:</td>
                <td class="contenidoNombres"><input type="text" id="url_informacion" name="url_informacion" style="width: 450px;"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Estado:</td>
                <td class="contenidoNombres">
                    <select name="estado">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
                    <a href="archivos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>

<?php

function ArchivosGuardar($nId, $nombre, $idsCategoria, $contenido, $archivo, $url, $estado) {
    global $cRutaImgMbContenidos;
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);

    if ( !isset($idsCategoria) || $idsCategoria == "" ){
        $idsCategoria = array();
    }
    
    $campos = "nombre,contenido,fecha_publicacion,url_informacion,estado,tipo";
    if ($nId <= 0) {
        $ca->prepareInsert("tblmb_contenidos", $campos);
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":contenido", $contenido, true);
        $ca->bindValue(":fecha_publicacion", "current_date", false);
        $ca->bindValue(":url_informacion", $url, true);
        $ca->bindValue(":estado", $estado, true);
        $ca->bindValue(":tipo", "archivo", true);
        if (!$ca->exec()) {
            Mensaje("Error registrando archivo.", "archivos_listar.php");
            exit;
        }
        $idcontenido = mysqli_insert_id($nConexion);
    } else {
        $idcontenido = $nId;
        $ca->prepareUpdate("tblmb_contenidos", $campos, "idcontenido=:idcontenido");
        $ca->bindValue(":nombre", $nombre, true);
        $ca->bindValue(":contenido", $contenido, true);
        $ca->bindValue(":fecha_publicacion", "current_date", false);
        $ca->bindValue(":url_informacion", $url, true);
        $ca->bindValue(":estado", $estado, true);
        $ca->bindValue(":tipo", "archivo", true);
        $ca->bindValue(":idcontenido", $idcontenido, false);
        if (!$ca->exec()) {
            Mensaje("Error actualizando archivo.", "archivos_listar.php");
            exit;
        }
    }

    $sql = "update tblmb_contenidos set contenido='{$contenido}' where idcontenido={$idcontenido}";
    $ca->exec($sql);
    
    $ca->prepareDelete("tblmb_contenidos_categorias", "idcontenido=:idcontenido");
    $ca->bindValue(":idcontenido", $idcontenido, false);
    $ca->exec();

    foreach ($idsCategoria as $k => $v) {
        $ca->prepareInsert("tblmb_contenidos_categorias", "idcontenido,idcategoria");
        $ca->bindValue(":idcontenido", $idcontenido, false);
        $ca->bindValue(":idcategoria", $v, false);
        if (!$ca->exec()) {
            Mensaje("Error registrando archivo categorias.", "archivos_listar.php");
            exit;
        }
    }



    if (isset($archivo)) {
        $upload_dir = $cRutaImgMbContenidos;

        if (!file_exists($cRutaImgMbContenidos)) {
            mkdir($cRutaImgMbContenidos);
            chmod($cRutaImgMbContenidos, 0755);
        }

        $f = $archivo;
        $name = "";
        if ($f["name"] != "") {
            $name = "mb_arch_{$idcontenido}_{$f["name"]}";
            if ($f["error"] == UPLOAD_ERR_OK) {
                if (!move_uploaded_file($f["tmp_name"], $upload_dir . $name)) {
                    die("Fallo cargando archivo al servidor");
                }
            }
            $ca->prepareUpdate("tblmb_contenidos", "archivo", "idcontenido=:idcontenido");
            $ca->bindValue(":archivo", $name, true);
            $ca->bindValue(":idcontenido", $idcontenido, false);
            if (!$ca->exec()) {
                Mensaje("Error registrando archivo.", "archivos_listar.php");
                exit;
            }
        }
    }

    mysqli_close($nConexion);
    Mensaje("El registro ha sido actualizado correctamente.", "archivos_listar.php");
    return;
}
?>

<?php

function ArchivosEliminar($nId) {
    global $cRutaImgMbContenidos;
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    
    $ca->prepareSelect("tblmb_contenidos","*","idcontenido=:idcontenido");
    $ca->bindValue(":idcontenido",$nId, false);
    $ca->exec();
    
    if ( $ca->size() > 0 ) {
        $rContenido = $ca->fetch();
        unlink("{$cRutaImgMbContenidos}{$rContenido["archivo"]}");
        
        $ca->prepareDelete("tblmb_contenidos", "idcontenido=:idcontenido");
        $ca->bindValue(":idcontenido",$nId, false);
        $ca->exec();
        Log_System("CONTENIDOS", "ELIMINA", "Archivo: " . $rContenido["nombre"]);
    }
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "archivos_listar.php");
    exit();
}
?>

<?php

function ArchivosFormEditar($nId) {
    global $cRutaVerImgMbContenidos;
    global $rCategoriasA;
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tblmb_contenidos", "*", "idcontenido=:idcontenido");
    $ca->bindValue(":idcontenido", $nId, false);
    $ca->exec();
    $Registro = $ca->fetch();


    $ca->prepareSelect("tblmb_contenidos_categorias", "idcategoria", "idcontenido=:idcontenido");
    $ca->bindValue(":idcontenido", $nId, false);
    $ca->exec();

    $rCC = $ca->fetchAll();
    $rCategoriasE = array();
    foreach ($rCC as $r) {
        $rCategoriasE[] = $r["idcategoria"];
    }
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Contenidos -->
    <form method="post" action="archivos.php?Accion=Guardar" enctype="multipart/form-data">
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>">
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR ARCHIVO MEMBRESIA</b></td>
            </tr>
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres"><input id="nombre" type="text" name="nombre" value="<?php echo $Registro["nombre"]; ?>" style="width: 450px;" /></td>
            </tr>
            <tr>
                <td class="tituloNombres">Categorias:</td>
                <td class="contenidoNombres">
                    <select name="idscategorias[]" multiple style="width: 450px;">
                        <?php foreach ($rCategoriasA as $r): ?>
                            <option value="<?php echo $r["idcategoria"]; ?>" <?php echo in_array($r["idcategoria"], $rCategoriasE) ? "selected" : ""; ?>><?php echo $r["nombre"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Contenido:</td>
                <td class="contenidoNombres">
                    <?php
                    /*$oFCKeditor = new FCKeditor('contenido');
                    $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
                    $oFCKeditor->Value = $Registro["contenido"];
                    $oFCKeditor->Create();
                    $oFCKeditor->Width = '100%';
                    $oFCKeditor->Height = '400';*/
                    ?>
                    <textarea name="contenido"><? echo $Registro["contenido"]?></textarea>
                    <script>
                        CKEDITOR.replace( 'contenido' );
                    </script>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Archivo:</td>
                <td class="contenidoNombres"><input type="file" id="archivo" name="archivo"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Archivo Actual:</td>
                <td class="contenidoNombres">
                    <?php
                    if (empty($Registro["archivo"])) {
                        echo "No se asigno archivo.";
                    } else {
                        ?><a href="<?php echo "{$cRutaVerImgMbContenidos}{$Registro['archivo']}"; ?>" target="_blank">Descargar Archivo</a>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Url:</td>
                <td class="contenidoNombres">
                    <input type="text" id="url_informacion" name="url_informacion" value="<?php echo $Registro["url_informacion"]; ?>" style="width: 450px;"/>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Estado:</td>
                <td class="contenidoNombres">
                    <select name="estado">
                        <option value="activo" <?php echo $Registro["estado"] == "activo" ? "selected" : ""; ?>>Activo</option>
                        <option value="inactivo" <?php echo $Registro["estado"] == "inactivo" ? "selected" : ""; ?>>Inactivo</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro."/>
                    <?php
                    if (Perfil() != "3") {
                        ?><a href="archivos.php?Accion=Eliminar&Id=<?php echo $nId; ?>">
                            <img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"/>
                        </a>
                        <?php
                    }
                    ?>
                    <a href="archivos_listar.php">
                        <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/>
                    </a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>