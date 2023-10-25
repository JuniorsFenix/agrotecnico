<?php
require_once ("../../funciones_generales.php");
require_once ("../../vargenerales.php");
require_once ("../../herramientas/paginar/dbquery.inc.php");

$nConexion = Conectar();
$ca = new DbQuery($nConexion);
$ca->prepareSelect("tblmb_categorias", "idcategoria,nombre", "1=1", "nombre");
$ca->exec();
$rCategorias = $ca->assocAll();
?>

<?php

function ContenidosFormNuevo() {
    global $rCategorias;
    ?>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
    <!-- Formulario Ingreso de Contenidos -->
    <form method="post" action="contenidos.php?Accion=Guardar" enctype="multipart/form-data">
        <input TYPE="hidden" id="txtId" name="txtId" value="0"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO CONTENIDO MEMBRESIA</b></td>
            </tr>
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres"><INPUT id="nombre" type="text" name="nombre" style="width: 450px;" /></td>
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
                </script>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Foto:</td>
                <td class="contenidoNombres"><input type="file" id="foto" name="foto"/></td>
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
                    <a href="contenidos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>

<?php

function ContenidosGuardar($nId, $nombre, $idsCategoria, $contenido, $foto, $url, $estado) {
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
        $ca->bindValue(":tipo", "contenido", true);
        if (!$ca->exec()) {
            Mensaje("Error registrando contenido.", "contenidos_listar.php");
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
        $ca->bindValue(":tipo", "contenido", true);
        $ca->bindValue(":idcontenido", $idcontenido, false);
        
        //Mensaje("Dev ".print_r($ca->preparedQuery()." --<br/> ".$contenido), "contenidos_listar.php");
        //exit;
        if (!$ca->exec()) {
            Mensaje("Error actualizando contenido.", "contenidos_listar.php");
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
            Mensaje("Error registrando contenido categorias.", "contenidos_listar.php");
            exit;
        }
    }



    if (isset($foto)) {
        $upload_dir = $cRutaImgMbContenidos;

        if (!file_exists($cRutaImgMbContenidos)) {
            mkdir($cRutaImgMbContenidos);
            chmod($cRutaImgMbContenidos, 0755);
        }

        $f = $foto;
        $name = "";
        if ($f["name"] != "") {
            $name = "mb_cont_{$idcontenido}_{$f["name"]}";
            if ($f["error"] == UPLOAD_ERR_OK) {
                if (!move_uploaded_file($f["tmp_name"], $upload_dir . $name)) {
                    die("Fallo cargando archivo al servidor");
                }
            }
            $ca->prepareUpdate("tblmb_contenidos", "imagen", "idcontenido=:idcontenido");
            $ca->bindValue(":imagen", $name, true);
            $ca->bindValue(":idcontenido", $idcontenido, false);
            if (!$ca->exec()) {
                Mensaje("Error registrando contenido foto.", "contenidos_listar.php");
                exit;
            }
        }
    }


    mysqli_close($nConexion);
    Mensaje("El registro ha sido actualizado correctamente.", "contenidos_listar.php");
    return;
}
?>

<?php

function ContenidosEliminar($nId) {
    global $cRutaImgMbContenidos;
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    
    $ca->prepareSelect("tblmb_contenidos","*","idcontenido=:idcontenido");
    $ca->bindValue(":idcontenido",$nId, false);
    $ca->exec();
    
    if ( $ca->size() > 0 ) {
        $rContenido = $ca->fetch();
        unlink("{$cRutaImgMbContenidos}{$rContenido["imagen"]}");
        
        $ca->prepareDelete("tblmb_contenidos", "idcontenido=:idcontenido");
        $ca->bindValue(":idcontenido",$nId, false);
        $ca->exec();
        Log_System("CONTENIDOS", "ELIMINA", "Archivo: " . $rContenido["nombre"]);
    }
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "contenidos_listar.php");
    exit();
}
?>

<?php

function ContenidosFormEditar($nId) {
    global $cRutaVerImgMbContenidos;
    global $rCategorias;
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
    <form method="post" action="contenidos.php?Accion=Guardar" enctype="multipart/form-data">
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>">
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CONTENIDO MEMBRESIA</b></td>
            </tr>
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres"><input id="nombre" type="text" name="nombre" value="<?php echo $Registro["nombre"]; ?>" style="width: 450px;" /></td>
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
                <td class="tituloNombres">Foto:</td>
                <td class="contenidoNombres"><input type="file" id="foto" name="foto"/></td>
            </tr>
            <tr>
                <td class="tituloNombres">Imagen Actual:</td>
                <td class="contenidoNombres">
                    <?php
                    if (empty($Registro["imagen"])) {
                        echo "No se asigno una imagen.";
                    } else {
                        ?><img src="<?php echo "{$cRutaVerImgMbContenidos}{$Registro['imagen']}"; ?>"/>
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
                        ?><a href="contenidos.php?Accion=Eliminar&Id=<?php echo $nId; ?>">
                            <img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"/>
                        </a>
                        <?php
                    }
                    ?>
                    <a href="contenidos_listar.php">
                        <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/>
                    </a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>