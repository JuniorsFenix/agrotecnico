<?php
require_once("../../funciones_generales.php");
require_once("../../herramientas/paginar/dbquery.inc.php");

$nConexion = Conectar();
$ca = new DbQuery($nConexion);
$ca->prepareSelect("tblpantalla_led", 
        "*");
$ca->exec();
$rEmpresas = $ca->assocAll();
mysqli_close($nConexion);

function RegionesFormNuevo() {
    $IdCiudad = $_SESSION["IdCiudad"];
    global $rEmpresas;
    ?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="frases.php?Accion=Guardar">
        <input TYPE="hidden" id="txtId" name="txtId" value="0"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO TEXTO</b></td>
            </tr>
        </table>
        <br/>
        <br/>
        <br/>
        <br/>
        <table width="100%">
            <tr>
                <td class="tituloNombres">Texto:</td>
                <td class="contenidoNombres"><textarea name="texto" id="texto"></textarea></td>
            </tr>
            <tr>
                <td class="tituloNombres">Categor�a:</td>
                <td class="contenidoNombres">
                    <select name="idcategoria">
                        <?php foreach ( $rEmpresas as $r ):?>
                        <option value="<?php echo $r["idcategoria"]?>"><?php echo $r["nombre"]?></option>
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
                    <a href="frases_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
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
        $ca->prepareInsert("tbltexto_pantalla", "texto,idcategoria");
        $ca->bindValue(":texto", $nombre, true);
        $ca->bindValue(":idcategoria", $idempresa, false);

        if (!$ca->exec()) {
            Mensaje("Error registrando nueva frase.", "frases_listar.php");
            exit;
        }
        
        mysqli_close($nConexion);
        Mensaje("El registro ha sido almacenado correctamente.", "frases_listar.php");
        return;
    } else {
        $ca->prepareUpdate("tbltexto_pantalla", "texto,idcategoria", "idtexto=:idtexto");
        $ca->bindValue(":texto", $nombre, true);
        $ca->bindValue(":idtexto", $nId, false);
        $ca->bindValue(":idcategoria", $idempresa, false);
        
        if (!$ca->exec()) {
            Mensaje("Error actualizando region {$nId}", "frases_listar.php");
            exit;
        }
        
        mysqli_close($nConexion);
        Mensaje("El registro ha sido actualizado correctamente.", "frases_listar.php");
        return;
    }
}
?>
<?php

function RegionesEliminar($nId) {
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareDelete("tbltexto_pantalla", "idtexto=:idtexto");
    $ca->bindValue(":idtexto", $nId, false);

    if (!$ca->exec()) {
        mysqli_close($nConexion);
        Mensaje("Fallo eliminando region {$nId}", "frases_listar.php");
        exit;
    }
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "frases_listar.php");
    exit();
}
?>
<?php

function RegionesFormEditar($nId) {
    $IdCiudad = $_SESSION["IdCiudad"];
    global $rEmpresas;
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
    $ca->prepareSelect("tbltexto_pantalla", "*", "idtexto=:idtexto");
    $ca->bindValue(":idtexto", $nId, false);
    $ca->exec();

    $Registro = $ca->assoc();
    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="frases.php?Accion=Guardar" >
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR TEXTO</b></td>
            </tr>

        </table>

        <table width="100%">
            <tr>
                <td class="tituloNombres">Frase:</td>
                <td class="contenidoNombres"><textarea id="texto" name="texto"><?php echo $Registro["texto"] ?></textarea></td>
            </tr>
            <tr>
                <td class="tituloNombres">Categor�a:</td>
                <td class="contenidoNombres">
                    <select name="idcategoria">
                        <?php foreach ( $rEmpresas as $r ):?>
                        <option value="<?php echo $r["idcategoria"]?>" <?php echo $r["idcategoria"]==$Registro["idcategoria"]?"selected":"";?>><?php echo $r["nombre"]?></option>
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
                    <a href="frases.php?Accion=Eliminar&Id=<?php echo $nId; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
                    <a href="frases_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
                </td>
            </tr>
        </table>
    </form>
<?php
}
?>
