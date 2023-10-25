<?php

include("../../herramientas/seguridad/seguridad.php");

include("../../herramientas/paginar/class.paginaZ.php");

include("../../funciones_generales.php");

include("../../vargenerales.php");

//	$IdCiudad = $_SESSION["IdCiudad"];



$pendiente_revision = isset($_GET["pendiente_revision"])?$_GET["pendiente_revision"]:0;

$categoria = isset($_GET["categoria"])?$_GET["categoria"]:"TODAS";

$zona = isset($_GET["zona"])?$_GET["zona"]:"TODAS";



//echo "Categoria {$categoria} pendiente {$pendiente_revision}";



$page = new sistema_paginacion("tbldiremp_empresas a join tbldiremp_categorias b on (a.codigo_categoria=b.codigo_categoria)

                                join tbldiremp_zonas c on (a.codigo_zona=c.codigo_zona)");

$page->set_campos("a.*,case when a.activo=1 then 'Si' else 'No' end as empresa_activa,b.nombre as nombre_categoria,c.nombre as nombre_zona");



$where = "where 1=1 ";

if ( $pendiente_revision == 0 ) {

    $where .= "and pendiente_revision=0 ";

}else{

    $where .= "and pendiente_revision=1 ";

}

if ( $categoria != "TODAS" ) {

    $where .= "and a.codigo_categoria={$categoria} ";

}

if ( $zona != "TODAS" ) {

    $where .= "and a.codigo_zona={$zona}";

}



$page->set_condicion($where);



$page->ordenar_por('a.nombre asc');

$page->set_limite_pagina(20);

$result_page = $page->obtener_consulta();

$page->set_color_tabla("#FEF1E2");

$page->set_color_texto("black");

$page->set_color_enlaces("black", "#FF9900");







$sql = "select codigo_categoria,nombre from tbldiremp_categorias order by nombre";

$nConexion = Conectar();

$rCategorias = mysqli_query($nConexion,$sql);



$sql = "select codigo_zona,nombre from tbldiremp_zonas order by nombre";

$nConexion = Conectar();

$rZonas = mysqli_query($nConexion,$sql);



?>



<html>

    <head>

        <link href="../../css/administrador.css" rel="stylesheet" type="text/css">

        <style type="text/css">

            <!--

            body {

                margin-top: 0px;

                margin-bottom:0px;

                margin-left:0px;

                margin-right:0px;

            }

            -->

        </style>



    </head>

    <body>

        <? include("../../system_menu.php"); ?>

        <br/>

        <form action="Cualquiera" method="post" name="formT">

            Pendiente revisi�n:<select name="pendiente_revision" id="pendiente_revision">

                <option value="1" <?php echo ($pendiente_revision == 1 ? "selected" : ""); ?>>Si</option>

                <option value="0" <?php echo ($pendiente_revision == 0 ? "selected" : ""); ?>>No</option>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Categor�a:<select name="categoria" id="categoria">

                <option value="TODAS" <?php echo ($categoria == "TODAS" ? "selected" : ""); ?>>Todas</option>

                <?php while ($r = mysqli_fetch_array($rCategorias)): ?>

                    <option value="<?php echo $r["codigo_categoria"]; ?>" <?php echo ($categoria == $r["codigo_categoria"] ? "selected" : ""); ?>><?php echo $r["nombre"]; ?></option>

                <?php endwhile; ?>

                </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Zonas:<select name="zonas" id="zona">

                <option value="TODAS" <?php echo ($zona == "TODAS" ? "selected" : ""); ?>>Todas</option>

                <?php while ($r = mysqli_fetch_array($rZonas)): ?>

                    <option value="<?php echo $r["codigo_zona"]; ?>" <?php echo ($zona == $r["codigo_zona"] ? "selected" : ""); ?>><?php echo $r["nombre"]; ?></option>

                <?php endwhile; ?>

                </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;



                <input TYPE="button" VALUE="Ver" onClick="var c = document.getElementById('categoria');

                    var p = document.getElementById('pendiente_revision');

                    var z = document.getElementById('zona');

                    window.location = 'diremp_empresas_listar.php?categoria='+c.value+'&zona='+z.value+'&pendiente_revision='+p.value;">

            </form>





        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td colspan="12" align="center" class="tituloFormulario">

                    <b>LISTA DE EMPRESAS DIRECTORIO EMPRESARIAL</b>

                    <br>

                    <? $page->mostrar_numero_pagina() ?><br>

                </td>

            </tr>

            <tr>

                <td bgcolor="#FEF1E2"><b>Id</b></td>

                <td bgcolor="#FEF1E2"><b>Empresa</b></td>

                <td bgcolor="#FEF1E2"><b>Sector comercial</b></td>

                <td bgcolor="#FEF1E2"><b>Direcci�n</b></td>

                <td bgcolor="#FEF1E2"><b>Tel�fono</b></td>

                <td bgcolor="#FEF1E2"><b>Zona</b></td>

                <td bgcolor="#FEF1E2"><b>Correo electronico</b></td>

                <td bgcolor="#FEF1E2"><b>URL Web</b></td>

                <td bgcolor="#FEF1E2"><b>Categoria</b></td>

                <td bgcolor="#FEF1E2"><b>Activa</b></td>

                <td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>

                <td bgcolor="#FEF1E2" align="center"><b>Eliminar</b></td>

            </tr>

            <?php

                    $ContFilas = 0;

                    $ColorFilaPar = "#FFFFFF";

                    $ColorFilaImpar = "#F0F0F0";

                    while ($row = mysqli_fetch_object($result_page)) {

                        $ContFilas = $ContFilas + 1;

                        if (fmod($ContFilas, 2) == 0) { // Si devuelve cero el numero es par

                            $ColorFila = $ColorFilaPar;

                        } else {

                            $ColorFila = $ColorFilaImpar;

                        }

            ?>

                        <tr>

                            <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->codigo_empresa; ?></td>

                            <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->nombre; ?></td>

                            <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->sector_comercial; ?></td>

                            <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->direccion; ?></td>

                            <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->telefono; ?></td>

                            <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->nombre_zona; ?></td>

                            <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->correo_electronico; ?></td>

                            <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->url_web; ?></td>

                            <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->nombre_categoria; ?></td>

                            <td bgcolor="<? echo $ColorFila; ?>"><? echo $row->empresa_activa; ?></td>

                            <td bgcolor="<? echo $ColorFila; ?>" align="center">

                                <a href="diremp_empresas.php?Accion=Editar&Id=<? echo "$row->codigo_empresa"; ?>">

                                    <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->nombre"; ?>">

                                </a>

                            </td>

                            <td bgcolor="<? echo $ColorFila; ?>"align="center">

                                <a href="diremp_empresas.php?Accion=Eliminar&Id=<?= $row->codigo_empresa; ?>" onclick="return confirm('�Seguro que desea eliminar este registro?');">

                                    <img src="../../image/borrar.gif" border="0" >

                                </a>

                            </td>

                        </tr>

            <?php

                    }

            ?>

                    <tr>

                        <td colspan="12"><? $page->mostrar_enlaces(); ?></td>

            </tr>

            <tr>

                <td colspan="12">&nbsp;</td>

            </tr>

            <tr>

                <td colspan="2" ></td>

                <td colspan="8" class="nuevo">

                    <a href="diremp_empresas.php?Accion=Adicionar">

                        <img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro.">

                    </a>

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <a href="diremp_empresas_exportar.php">Exportar excel</a>

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <a href="diremp_empresas.php?Accion=Importar">Importar archivo CSV</a>

                </td>

                <td colspan="2" ></td>

            </tr>

        </table>

        <br><br><br><br><br>

        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones inform�ticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

            </tr>

        </table>

    </body>

</html>