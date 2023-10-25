<?php

include("../../funciones_generales.php");
require_once "../../herramientas/excel-2.0/Writer.php";

$sql = "select
        a.codigo_empresa,
        a.nombre,
        a.sector_comercial,
        a.valor_minimo,
        a.valor_maximo,
        a.descripcion,
        a.telefono,
        a.codigo_zona,
        z.nombre as nombre_zona,
        a.correo_electronico,
        a.url_web,
        a.imagen,
        a.codigo_categoria,
        c.nombre as nombre_categoria

        from tbldiremp_empresas a
        join tbldiremp_categorias c on (a.codigo_categoria = c.codigo_categoria)
        join tbldiremp_zonas z on (a.codigo_zona = z.codigo_zona ) where 1=1 ";

$nConexion = Conectar();
$rEmpresas = mysqli_query($nConexion,$sql);
mysqli_close($nConexion);


$file = "empresas.xls";
$wb = new Spreadsheet_Excel_Writer();

$ws = & $wb->addWorksheet('Hoja1');

$i = 0;


$ws->writeString($i, 0, 'C�digo empresa');
$ws->writeString($i, 1, 'Nombre');
$ws->writeString($i, 2, 'Sector comercial');
$ws->writeString($i, 3, 'Valor minimo');
$ws->writeString($i, 4, 'Valor m�ximo');
$ws->writeString($i, 5, 'Descripci�n');
$ws->writeString($i, 6, 'Tel�fono');
$ws->writeString($i, 7, 'C�digo zona');
$ws->writeString($i, 8, 'Zona');
$ws->writeString($i, 9, 'Correo electronico');
$ws->writeString($i, 10, 'URL Web');
$ws->writeString($i, 11, 'C�digo categoria');
$ws->writeString($i, 12, 'Categoria');

while ($empresa = mysqli_fetch_array( $rEmpresas )) {
    $i++;
    $ws->writeString($i, 0, $empresa["codigo_empresa"]);
    $ws->writeString($i, 1, $empresa["nombre"]);
    $ws->writeString($i, 2, $empresa["sector_comercial"]);
    $ws->writeString($i, 3, $empresa["valor_minimo"]);
    $ws->writeString($i, 4, $empresa["valor_maximo"]);
    $ws->writeString($i, 5, $empresa["descripcion"]);
    $ws->writeString($i, 6, $empresa["telefono"]);
    $ws->writeString($i, 7, $empresa["codigo_zona"]);
    $ws->writeString($i, 8, $empresa["nombre_zona"]);
    $ws->writeString($i, 9, $empresa["correo_electronico"]);
    $ws->writeString($i, 10, $empresa["url_web"]);
    $ws->writeString($i, 11, $empresa["codigo_categoria"]);
    $ws->writeString($i, 12, $empresa["nombre_categoria"]);
}

$wb->send($file);

$wb->close();
echo "hola";
?>
