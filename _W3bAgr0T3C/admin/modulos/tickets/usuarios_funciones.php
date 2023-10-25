<?php
require_once("../../funciones_generales.php");
require_once("../../herramientas/paginar/dbquery.inc.php");

$nConexion = Conectar();
$ca = new DbQuery($nConexion);
$ca->prepareSelect("tbltk_sedes a join tbltk_zonas b on (a.idzona=b.idzona) 
        join tbltk_regiones c on (b.idregion=c.idregion) 
        join tbltk_empresas d on (c.idempresa=d.idempresa)", 
        "a.idsede,concat(a.nombre,' - ',b.nombre,' - ',c.nombre,' - ',d.nombre) as nombre");
$ca->exec();
$rSedes = $ca->assocAll();

$ca->prepareSelect("tbltk_zonas a join tbltk_regiones b on (a.idregion=b.idregion) join tbltk_empresas c on (b.idempresa=c.idempresa)", 
        "a.idzona,concat(a.nombre,' - ',b.nombre,' - ',c.nombre) as nombre");
$ca->exec();
$rZonas = $ca->assocAll();

$ca->prepareSelect("tbltk_regiones a join tbltk_empresas b on (a.idempresa=b.idempresa)", 
        "a.idregion,concat(a.nombre,' - ',b.nombre) as nombre");
$ca->exec();
$rRegiones = $ca->assocAll();
mysqli_close($nConexion);

$rTiposUsuario = array ("admin"=>"Administrador","operador"=>"Operario","region"=>"Region","zona"=>"Zona");
?>
<?php

function UsuariosGuardar($nId, $idsede, $tipo, $attr_tipo) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    
    $ca->prepareSelect("tbltk_sedes_usuarios", "*","idusuario=:idusuario");
    $ca->bindValue(":idusuario", $nId, false);
    $ca->exec();
    
    if ($ca->size() == 0) {
        $ca->prepareInsert("tbltk_sedes_usuarios", "idsede,idusuario,tipo,attr_tipo");
        $ca->bindValue(":idusuario", $nId, false);
        $ca->bindValue(":idsede", $idsede, false);
        $ca->bindValue(":tipo", $tipo, true);
        $ca->bindValue(":attr_tipo", $attr_tipo, false);
        
        if (!$ca->exec()) {
            Mensaje("Error registrando usuario sede.", "usuarios_listar.php");
            exit;
        }
        
        $ca->prepareSelect("tbltk_sedes a 
                join tbltk_zonas b on (a.idzona=b.idzona)
                join tbltk_regiones c on (b.idregion=c.idregion)
                join tbltk_empresas d on (c.idempresa=d.idempresa)
                join tblboletineslistas e on (e.nombre=d.nombre)", 
                "e.idlista", 
                "a.idsede=:idsede");
        $ca->bindValue(":idsede", $idsede, false);
        $ca->exec();
        $rLista = $ca->fetch();
        
        $ca->prepareSelect("tblusuarios_externos", "*", "idusuario=:idusuario");
        $ca->bindValue(":idusuario", $nId, false);
        $ca->exec();
        $rUsuario = $ca->fetch();
        
        $ca->prepareInsert("tblboletinescorreos", "correo,nombre,idlista");
        $ca->bindValue(":correo", $rUsuario["correo_electronico"], true);
        $ca->bindValue(":nombre", "{$rUsuario["nombre"]} {$rUsuario["apellido"]}", true);
        $ca->bindValue(":idlista", $rLista["idlista"], false);
        
        if (!$ca->exec()) {
            Mensaje("Error registrando usuario en lista.", "usuarios_listar.php");
            exit;
        }
        
        
        mysqli_close($nConexion);
        Mensaje("El registro ha sido almacenado correctamente.", "usuarios_listar.php");
        return;
    } else {
        $ca->prepareUpdate("tbltk_sedes_usuarios", "idsede,tipo,attr_tipo", "idusuario=:idusuario");
        $ca->bindValue(":idusuario", $nId, false);
        $ca->bindValue(":idsede", $idsede, false);
        $ca->bindValue(":tipo", $tipo, true);
        $ca->bindValue(":attr_tipo", $attr_tipo, false);

        if (!$ca->exec()) {
            Mensaje("Error actualizando usuario sede {$nId}", "usuarios_listar.php");
            exit;
        }
        mysqli_close($nConexion);
        Mensaje("El registro ha sido actualizado correctamente.", "usuarios_listar.php");
        return;
    }
}
?>
<?php

function UsuariosEliminar($nId) {
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    
    $ca->prepareSelect("tbltk_sedes_usuarios", "idsede", "idusuario=:idusuario");
    $ca->bindValue(":idusuario", $nId, false);
    $ca->exec();
    if ( $ca->size() == 0 ) {
        mysqli_close($nConexion);
        Mensaje("El usuario no esta asociado a alguna sede.", "usuarios_listar.php");
        exit;
    }
    $rSede = $ca->fetch();
    
    $ca->prepareDelete("tbltk_sedes_usuarios", "idusuario=:idusuario");
    $ca->bindValue(":idusuario", $nId, false);

    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando usuario {$nId} de la sede.", "usuarios_listar.php");
        exit;
    }
    
    $ca->prepareSelect("tbltk_sedes a 
            join tbltk_zonas b on (a.idzona=b.idzona)
            join tbltk_regiones c on (b.idregion=c.idregion)
            join tbltk_empresas d on (c.idempresa=d.idempresa)
            join tblboletineslistas e on (e.nombre=d.nombre)", 
            "e.idlista", 
            "a.idsede=:idsede");
    $ca->bindValue(":idsede", $rSede["idsede"], false);
    $ca->exec();
    $rLista = $ca->fetch();

    $ca->prepareSelect("tblusuarios_externos", "*", "idusuario=:idusuario");
    $ca->bindValue(":idusuario", $nId, false);
    $ca->exec();
    $rUsuario = $ca->fetch();

    $ca->prepareDelete("tblboletinescorreos", "correo=:correo and idlista=:idlista");
    $ca->bindValue(":correo", $rUsuario["correo_electronico"], true);
    $ca->bindValue(":idlista", $rLista["idlista"], false);
    
    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando usuario {$nId} de la lista de correo.", "usuarios_listar.php");
        exit;
    }
    
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "usuarios_listar.php");
    exit();
}
?>
<?php

function UsuariosFormEditar($nId) {
    global $rSedes;
    global $rZonas;
    global $rRegiones;
    global $rTiposUsuario;
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $campos = "a.idusuario,b.idsede,b.tipo,attr_tipo,CONCAT(a.nombre,' ',a.apellido) as nombre,a.correo_electronico";
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tblusuarios_externos a 
    left join tbltk_sedes_usuarios b on (a.idusuario=b.idusuario)
    left join tbltk_sedes c on (b.idsede=c.idsede)
    left join tbltk_zonas d on (c.idzona=d.idzona)
    left join tbltk_regiones e on (d.idregion=e.idregion)
    left join tbltk_empresas f on (e.idempresa=f.idempresa)", $campos, "a.idusuario=:idusuario");
    $ca->bindValue(":idusuario", $nId, false);
    $ca->exec();

    $Registro = $ca->assoc();
    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="usuarios.php?Accion=Guardar" >
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>">
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR USUARIO</b></td>
            </tr>

        </table>

        <table width="100%">
            <tr>
                <td class="tituloNombres">Nombre:</td>
                <td class="contenidoNombres">
                    <input type="text" id="nombre" name="nombre" value="<?php echo $Registro["nombre"] ?>" readonly/>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Correo:</td>
                <td class="contenidoNombres">
                    <input type="text" id="correo" name="correo" value="<?php echo $Registro["correo_electronico"] ?>" readonly/>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Sede:</td>
                <td class="contenidoNombres">
                    <select name="idsede" id="idsede">
                        <?php foreach ($rSedes as $r): ?>
                            <option value="<?php echo $r["idsede"]; ?>" <?php echo $r["idsede"] == $Registro["idsede"] ? "selected" : ""; ?>><?php echo $r["nombre"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tituloNombres">Perfil:</td>
                <td class="contenidoNombres">
                    <select name="tipo" id="tipo" onchange="var tipo = document.getElementById('tipo');
                        var attr_tipo_zona = document.getElementById('attr_tipo_zona');
                        var attr_tipo_region = document.getElementById('attr_tipo_region');
                        if ( tipo.value != 'region' && tipo.value != 'zona' ) {
                            attr_tipo_zona.style.display = 'none';
                            attr_tipo_region.style.display = 'none';
                            return;
                        }
                        if ( tipo.value == 'region' ) {
                            attr_tipo_zona.style.display = 'none';
                            attr_tipo_region.style.display = '';
                        }
                        if ( tipo.value == 'zona' ) {
                            attr_tipo_zona.style.display = '';
                            attr_tipo_region.style.display = 'none';
                        }
                        ">
                        <?php foreach ($rTiposUsuario as $k => $v): ?>
                            <option value="<?php echo $k; ?>" <?php echo $k == $Registro["tipo"] ? "selected" : ""; ?>><?php echo $v; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            
            <tr>

                <td class="tituloNombres">Region o Zona:</td>
                <td class="contenidoNombres">
                    <div id="attr_tipo_zona" style="display:<?php echo $Registro["tipo"] == "zona"?"":"none";?>;">
                        <select name="attr_tipo_zona">
                            <option value="0">&nbsp;</option>
                            <?php foreach ($rZonas as $r): ?>
                                <option value="<?php echo $r["idzona"]; ?>" <?php echo $r["idzona"] == $Registro["attr_tipo"] ? "selected" : ""; ?>><?php echo $r["nombre"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="attr_tipo_region" style="display:<?php echo $Registro["tipo"] == "region"?"":"none";?>;">
                        <select name="attr_tipo_region">
                            <option value="0">&nbsp;</option>
                            <?php foreach ($rRegiones as $r): ?>
                                <option value="<?php echo $r["idregion"]; ?>" <?php echo $r["idregion"] == $Registro["attr_tipo"] ? "selected" : ""; ?>><?php echo $r["nombre"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </td>
            </tr>
            
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro."/>
                    <a href="usuarios.php?Accion=Eliminar&Id=<?php echo $nId; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
                    <a href="usuarios_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>
