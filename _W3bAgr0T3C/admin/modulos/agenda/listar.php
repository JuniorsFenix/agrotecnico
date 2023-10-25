<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  include("../../vargenerales.php");



  $nConexion    = Conectar();

  

  if( isset($_GET["accion"]) && $_GET["accion"]=="eliminar" ) {

    $nConexion = Conectar();

    $sql="DELETE FROM tblreservaciones WHERE idreservaciones='{$_GET["idreservaciones"]}'";

    $r = mysqli_query($nConexion,$sql);

    if(!$r){

	Mensaje("fallo eliminando reservaci�n ","listar.php" );

    }

    header("Location: listar.php");

  }

  

  

  $page=new sistema_paginacion('tblreservaciones a

    join tblreservacioneshorarios b on (a.idhorario=b.idhorario)

    left join tblti_carro c on (a.carro=c.carro)

	left join tblti_productos d on (a.idsalon = d.idproducto )');

	//$page->set_condicion( "WHERE a.idciudad = " . $IdCiudad );

	// Si se envio parametro para filtro categorias muestro realizo la condicion

	

	$page->ordenar_por('a.fecha desc');

	$page->set_campos("a.idreservaciones,

    a.idsalon,

	d.referencia as salon,

	a.persona_reserva,

    a.fecha,

    a.idhorario,

    a.carro,

    b.descripcion,

    b.hora_inicio,

    b.hora_fin,

    b.grupo,

    case when b.grupo<>3 then c.nombre else 'MANTENIMIENTO' end as nombre");

	$page->set_limite_pagina(20);

	$rsEventos=$page->obtener_consulta();

	$page->set_color_tabla("#FEF1E2");

	$page->set_color_texto("black");

	$page->set_color_enlaces("black","#FF9900");

  

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

<? include("../../system_menu.php"); ?><br>

    <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td colspan="10" align="center" class="tituloFormulario">

                    <center>

          <b>EVENTOS PROGRAMADOS EN LA AGENDA</b>

          <br>

          <? $page->mostrar_numero_pagina(); ?><br>

                    </center>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>

        <td bgcolor="#FEF1E2"><b>Id</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>

		<td bgcolor="#FEF1E2"><b>Persona reserva</b></td>

		<td bgcolor="#FEF1E2"><b>Salon</b></td>

        <td bgcolor="#FEF1E2"><b>Horario</b></td>

        <td bgcolor="#FEF1E2"><b>Compra</b></td>

        <td bgcolor="#FEF1E2"><b>Nombre</b></td>

        <td bgcolor="#FEF1E2"><b>Acci�n</b></td>

        <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>

        <!--td bgcolor="#FEF1E2" align="center"><b>Acci�n</b></td-->

      </tr>

      <?

        $ContFilas = 0;

        $ColorFilaPar = "#FFFFFF";

        $ColorFilaImpar	= "#F0F0F0";

        while($row=mysqli_fetch_assoc($rsEventos))

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

            <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["idreservaciones"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["fecha"];?></td>

			<td bgcolor="<? echo $ColorFila; ?>"><?=$row["persona_reserva"];?></td>

			<td bgcolor="<? echo $ColorFila; ?>"><?=$row["salon"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["descripcion"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["carro"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>"><?=$row["nombre"];?></td>

            <td bgcolor="<? echo $ColorFila; ?>">

              <a href="listar.php?accion=eliminar&idreservaciones=<?=$row['idreservaciones'];?>" onclick="return confirm('�Seguro que desea eliminar este registro?');">

              <img src="../../image/borrar.gif" border="0" ></a>

            </td>

            <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</td>

          

            <!--td bgcolor="<? echo $ColorFila; ?>" align="center">

            <a href="boletines.php?Accion=Editar&Id=<? echo "$row->idboletin"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->titulo"; ?>"></a>

            &nbsp;

            <a href="bloques_listar.php?idboletin=<? echo "$row->idboletin"; ?>&boletin=<?=$row->titulo;?>"><img src="../../image/bol_bloques.gif" border="0" alt="Ver Bloques"></a>

            &nbsp;

            <a target="_blank" href="<? echo $cRutaVerPlantillas_GenBoletines . $row->template ;?>/index.php?bol=<?=$row->idboletin ;?>">Ver</a>

            &nbsp;

            <a target="_blank" href="<? echo $cRutaVerPlantillas_GenBoletines . $row->template ;?>/codigohtm.php?bol=<?=$row->idboletin ;?>">Codigo</a>

            &nbsp;

            <a target="_self" href="enviar.php?bol=<?=$row->idboletin ;?>&template=<?=$row->template;?>">Enviar</a>

            </td-->

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="10"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="10">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="10" class="nuevo">

		  <a href="evento.php?accion=adicionar">Programar evento</a>

          <a href="mantenimiento.php?accion=adicionar">Programar mantenimiento</a>

		  <a href="registros_excel.php">Generar Archivo Excel</a>

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