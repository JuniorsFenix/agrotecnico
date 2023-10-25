<?php
###############################################################################
# diremp_zonas_funciones.php   	:  Archivo de funciones modulo Eventos
# Desarrollo               		:  Estilo y Dise�o
# Web                      		:  http://www.esidi.com
###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?php
###############################################################################
# Nombre        : dirempZonasFormNuevo
# Descripci�n   : Muestra el formulario para ingreso de productos nuevos
# Parametros    : Ninguno.
# Desarrollado  : Estilo y Dise�o
# Retorno       : Ninguno
###############################################################################

function dirempZonasFormNuevo() {
?>
    <!-- Formulario Ingreso de Municipios para Arrendamientos -->
    <form method="post" action="diremp_zonas.php?Accion=Guardar" enctype="multipart/form-data">
        <input TYPE="hidden" id="txtId" name="txtId" value="0">
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA ZONA</b></td>
            </tr>
            <tr>
                <td class="tituloNombres">Zona:</td>
                <td class="contenidoNombres">
                    <INPUT id="nombre" type="text" name="nombre" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2"  class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
                    <a href="diremp_zonas_listar.php">
                        <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar.">
                    </a>
                </td>
            </tr>
        </table>
    </form>
<?
}

###############################################################################
?>
<?php
###############################################################################
# Nombre        : dirempZonasGuardar
# Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
# Parametros    : $nId , $nombredepto
# Desarrollado  : Estilo y Dise�o
# Retorno       : Ninguno
###############################################################################

function dirempZonasGuardar($nId, $nombre) {
//	$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ($nId <= 0) { // Nuevo Registro
        mysqli_query($nConexion,"INSERT INTO tbldiremp_zonas (nombre) VALUES ( '{$nombre}' )");
        mysqli_close($nConexion);
        Mensaje("El registro ha sido almacenado correctamente.", "diremp_zonas_listar.php");
        exit;
    } else {
        mysqli_query($nConexion,"UPDATE tbldiremp_zonas SET nombre = '{$nombre}' WHERE codigo_zona = {$nId}");

        mysqli_close($nConexion);
        Mensaje("El registro ha sido actualizado correctamente.", "diremp_zonas_listar.php");
        exit;
    }
}

// FIN: function
###############################################################################
?>
<?php
###############################################################################
# Nombre        : dirempZonasEliminar
# Descripci�n   : Eliminar un registro
# Parametros    : $nId
# Desarrollado  : Estilo y Dise�o
# Retorno       : Ninguno
###############################################################################

function dirempZonasEliminar($nId) {
    $nConexion = Conectar();
    mysqli_query($nConexion,"DELETE FROM tbldiremp_zonas WHERE codigo_zona ={$nId}");
    mysqli_close($nConexion);
    Mensaje("El registro ha sido eliminado correctamente.", "diremp_zonas_listar.php");
    exit();
}

// FIN: function dirempZonasEliminar
###############################################################################
?>
<?php
###############################################################################
# Nombre        : dirempZonasFormEditar
# Descripci�n   : Muestra el formulario para editar o eliminar registros
# Parametros    : $nId = ID de registro que se debe mostrar el en formulario
# Desarrollado  : Estilo y Dise�o
# Retorno       : Ninguno
###############################################################################

function dirempZonasFormEditar($nId) {
    include("../../vargenerales.php");
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion,"SELECT * FROM tbldiremp_zonas WHERE codigo_zona = {$nId}");
    $Registro = mysqli_fetch_array($Resultado);
?>
    <!-- Formulario Edici�n / Eliminaci�n de Municipios Arrendamientos -->
    <form method="post" action="diremp_zonas.php?Accion=Guardar" enctype="multipart/form-data">
        <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId; ?>">
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR ZONAS</b></td>
            </tr>
            <tr>
                <td class="tituloNombres">Zona:</td>
                <td class="contenidoNombres">
                    <INPUT id="nombre" type="text" name="nombre" value="<? echo $Registro["nombre"]; ?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px">
                </td>
            </tr>

            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
                    <a href="diremp_zonas.php?Accion=Eliminar&Id=<? echo $nId; ?>">
                        <img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')">
                    </a>
                    <a href="diremp_zonas_listar.php">
                        <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar.">
                    </a>
                </td>
            </tr>
        </table>
    </form>
<?php
    mysqli_free_result($Resultado);
}

###############################################################################
?>
