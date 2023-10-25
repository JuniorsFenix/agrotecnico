<?php

require_once("../../herramientas/seguridad/seguridad.php");

require_once("../../herramientas/paginar/class.paginaZ.php");

require_once("../../herramientas/paginar/dbquery.inc.php");

require_once("../../funciones_generales.php");

require_once("../../vargenerales.php");

$IdCiudad = $_SESSION["IdCiudad"];



$filtro = isset($_GET["filtro"])?$_GET["filtro"]:"";

$idcategoria = isset($_GET["idcategoria"])?$_GET["idcategoria"]:"todas";

$fecha = isset($_GET["fecha"])?$_GET["fecha"]:"todas";

$pais = isset($_GET["pais"])?$_GET["pais"]:"todos";

$ciudad = isset($_GET["ciudad"])?$_GET["ciudad"]:"todas";



$where = "where 1=1 ";

if ( $filtro != "" ) {

    $where .= "and (upper(b.categoria) like upper('%{$filtro}%') or upper(a.pais) like upper('%{$filtro}%') or upper(a.ciudad) like upper('%{$filtro}%') or upper(a.fechahoraini) like upper('%{$filtro}%') or upper(a.detalle) like upper('%{$filtro}%')) ";

}

if ( $idcategoria != "todas" ) {

    $where .= "and b.idcategoria='{$idcategoria}' ";

}

if ( $fecha != "todas" ) {

    $where .= "and a.fechahoraini='{$fecha}' ";

}

if ( $pais != "todos" ) {

    $where .= "and a.pais='{$pais}' ";

}

if ( $ciudad != "todas" ) {

    $where .= "and a.ciudad='{$ciudad}' ";

}





$campos = "b.categoria as categoria,a.pais as pais,a.ciudad as ciudad,a.fechahoraini as fechahoraini,a.evento as evento,a.idevento as idevento,a.publicar as publicar,a.imagen as imagen,

    SUBSTR(a.detalle,1,25) as detalle";



$page = new sistema_paginacion('tbleventos a 

    left join tblcategoriaseventos b on (a.idcategoria=b.idcategoria)');

$page->set_campos($campos);

$page->ordenar_por("a.idevento desc");

$page->set_condicion($where);

$page->set_limite_pagina(20);

$rsEventos = $page->obtener_consulta();

if (!$rsEventos) {

    die("Fallo consultando eventos");

}

$page->set_color_tabla("#FEF1E2");

$page->set_color_texto("black");

$page->set_color_enlaces("black", "#FF9900");







$nConexion = Conectar();

$ca = new DbQuery($nConexion);

$ca->prepareSelect("tblcategoriaseventos", "*");

$ca->exec();

$rCategorias = $ca->assocAll();

$ca = new DbQuery($nConexion);

$ca->prepareSelect("tbleventos", "*");

$ca->exec();

$rEventos = $ca->assocAll();

mysqli_close($nConexion);

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



        <title>Lista de Eventos</title>



    </head>

    <body>

        <?php require_once("../../system_menu.php"); ?><br>



        <form action="eventos_listar.php" method="post" name="formT">

            Categor�a: <select id="categoria" name="categoria">

                <option value="todas" <?php echo $idcategoria=="todas"?"selected":"";?>>Todas</option>

                <?php foreach ( $rCategorias as $r):?>

                <option value="<?php echo $r["idcategoria"];?>" <?php echo $idcategoria==$r["idcategoria"]?"selected":"";?>><?php echo $r["categoria"];?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Fecha Evento: <select id="fecha" name="fecha">

                <option value="todas" <?php echo $fecha=="todas"?"selected":"";?>>Todas</option>

                <?php foreach ( $rEventos as $r):?>

                <option value="<?php echo $r["fechahoraini"];?>" <?php echo $fecha==$r["fechahoraini"]?"selected":"";?>><?php echo $r["fechahoraini"];?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Pa�s: <select id="pais" name="pais">

                <option value="todos" <?php echo $pais=="todos"?"selected":"";?>>Todos</option>

                <?php foreach ( $rEventos as $r):?>

                <option value="<?php echo $r["pais"];?>" <?php echo $pais==$r["pais"]?"selected":"";?>><?php echo $r["pais"];?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Ciudad: <select id="ciudad" name="ciudad">

                <option value="todas" <?php echo $ciudad=="todas"?"selected":"";?>>Todas</option>

                <?php foreach ( $rEventos as $r):?>

                <option value="<?php echo $r["ciudad"];?>" <?php echo $ciudad==$r["ciudad"]?"selected":"";?>><?php echo $r["ciudad"];?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Filtro: <input id="filtro" name="filtro" type="text"/>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                

            <input TYPE="button" VALUE="Filtrar" onClick="var filtro = document.getElementById('filtro');

                var e = document.getElementById('categoria');

                var s = document.getElementById('fecha');

                var t = document.getElementById('pais');

                var c = document.getElementById('ciudad');

                window.location = 'eventos_listar.php?idcategoria='+e.value+'&fecha='+s.value+'&pais='+t.value+'&ciudad='+c.value+'&filtro='+filtro.value;"/>

        </form>

        

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="8" align="center" class="tituloFormulario">

          <b>EVENTOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Fecha Inicio</b></td>

        <td bgcolor="#FEF1E2"><b>Nombre</b></td>

        <td bgcolor="#FEF1E2"><b>Pais</b></td>

        <td bgcolor="#FEF1E2"><b>Ciudad</b></td>

        <td bgcolor="#FEF1E2"><b>Publicado</b></td>

        <td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>

	<td align="center" bgcolor="#FEF1E2"><b>Imagen</b></td>

      </tr>

      <?

		$ContFilas			= 0;

		$ColorFilaPar		= "#FFFFFF";

		$ColorFilaImpar	= "#F0F0F0";

        while($row=mysqli_fetch_object($rsEventos))

        {

		$ContFilas = $ContFilas+ 1 ;

		if ( fmod( $ContFilas,2 ) == 0 ) // Si devuelve cero el numero es par

		{

			$ColorFila = $ColorFilaPar;

		}

		else

		{

			$ColorFila = $ColorFilaImpar;

		}

        ?>

        <tr>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fechahoraini"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->evento"; ?></td>

	<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->pais"; ?></td>

	<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->ciudad"; ?></td>

	<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->publicar"; ?></td>

	<td bgcolor="<? echo $ColorFila; ?>" align="center">

	<a href="eventos.php?Accion=Editar&Id=<? echo "$row->idevento"; ?>">

	<img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->evento"; ?>">

	</a></td>

	<td bgcolor="<? echo $ColorFila; ?>" align="center">

	<a href="" target="_blank" ></a>

	<?php

	if ( !empty( $row->imagen ) ) {

		?><a href="<? echo $cRutaVerImgEventos . $row->imagen; ?>" target="_blank">Ver</a><?

	}

	else {

		echo "No Asignada";

	}

	?>

	</td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="8"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="8">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="8" class="nuevo">

          <a href="eventos.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

        </td>

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