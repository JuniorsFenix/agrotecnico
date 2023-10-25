<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  include("../../vargenerales.php");

  $IdCiudad = $_SESSION["IdCiudad"];

  $campos = "a.*, b.descripcion AS descripciontiporeserva, c.descripcion AS descripciontipohabitacion, d.descripcion AS descripcionempresacubre";

  $page=new sistema_paginacion(' tblreservas a JOIN tbltiporeserva b ON (a.idtiporeserva=b.idtiporeserva) JOIN tbltipohabitacion c ON (a.idtipohabitacion=c.idtipohabitacion) JOIN tblempresacubre d ON (a.idempresacubre=d.idempresacubre) ');

  //$page->set_condicion( " WHERE a.idtiporeserva=b.idtiporeserva AND a.idtipohabitacion=c.idtipohabitacion AND a.idempresacubre=d.idempresacubre " );

  $page->set_campos($campos);

  $page->ordenar_por('a.idreserva desc');

  $page->set_limite_pagina(20);

  $result_page=$page->obtener_consulta();

  $page->set_color_tabla("#FEF1E2");

  $page->set_color_texto("black");

  $page->set_color_enlaces("black","#FF9900")

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

        <td colspan="13" align="center" class="tituloFormulario">

          <b>LISTADO RESERVAS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Nombre y Apellido</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha entrada</b></td>

	<td bgcolor="#FEF1E2"><b>Fecha Salida</b></td>

	<td bgcolor="#FEF1E2"><b>Tipo reserva</b></td>

	<td bgcolor="#FEF1E2"><b>Tipo habitaci�n</b></td>

	<td bgcolor="#FEF1E2"><b>N�mero hab.</b></td>

	<td bgcolor="#FEF1E2"><b>Solicitante</b></td>

	<td bgcolor="#FEF1E2"><b>Tel�fono</b></td>

	<td bgcolor="#FEF1E2"><b>Ciudad</b></td>

	<td bgcolor="#FEF1E2"><b>Empresa</b></td>             

	<td bgcolor="#FEF1E2"><b>Email</b></td>

        <td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>

	<td bgcolor="#FEF1E2" align="center"><b>Eliminar</b></td>

      </tr>

      <?

	$ContFilas = 0;

	$ColorFilaPar = "#FFFFFF";

	$ColorFilaImpar	= "#F0F0F0";

        while($row=mysqli_fetch_object($result_page))

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

          <td bgcolor="<? echo $ColorFila; ?>"><?=$row->nombres.' '.$row->apellidos;?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><?=$row->fecha_entrada;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->fecha_salida;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->descripciontiporeserva;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->descripciontipohabitacion;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->numero_habitaciones;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->solicitante;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->telefono;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->ciudad;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->descripcionempresacubre;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>"><?=$row->correo_electronico;?></td>

	  <td bgcolor="<? echo $ColorFila; ?>" align="center">

	  <a href="reservas.php?Accion=Editar&Id=<?=$row->idreserva;?>">

	  <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<?=$row->idreserva;?>">

	  </a></td>

	  <td bgcolor="<? echo $ColorFila; ?>" align="center">

	  <a href="reservas.php?Accion=Eliminar&Id=<?=$row->idreserva;?>">

	  <img src="../../image/borrar.gif" border="0" alt="Eliminar:<?=$row->idreserva;?>" onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')">

	  </a></td>

        </tr>

        <?

        }

      ?>

      <tr>

        <td colspan="13"><? $page->mostrar_enlaces(); ?></td>

      </tr>

      <tr>

        <td colspan="13">&nbsp;</td>

      </tr>

      <tr>

        <td colspan="13" class="nuevo">

          <a href="reservas.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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