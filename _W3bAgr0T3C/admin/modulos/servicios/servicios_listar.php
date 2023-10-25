<?
  include("../../herramientas/seguridad/seguridad.php");
  include("../../herramientas/paginar/class.paginaZ.php");
  include("../../funciones_generales.php");
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
	include("../../vargenerales.php");
  $page=new sistema_paginacion('tblservicios');
	$IdCiudad = $_SESSION["IdCiudad"];
  // Si se envio parametro para filtro categorias muestro realizo la condicion
  if (isset ($_GET["IdCat"])) // Si no se envio la accion muestro la lista completa
  {
    $page->set_condicion("WHERE (idciudad = $IdCiudad) AND  idcategoria = " . $_GET["IdCat"]);
  }
	else
	{
		$page->set_condicion("WHERE (idciudad = $IdCiudad)");
	}
  $page->ordenar_por('servicio');
  $page->set_limite_pagina(20);
  $result_page=$page->obtener_consulta();
  $page->set_color_tabla("#FEF1E2");
  $page->set_color_texto("black");
  $page->set_color_enlaces("black","#FF9900");
$permisos  = permisos("Tips");
?>
<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<title>Lista de Servicios</title>
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
    <script>
    <!--
    function land(ref, target)
    {
    lowtarget=target.toLowerCase();
    if (lowtarget=="_self") {window.location=loc;}
    else {if (lowtarget=="_top") {top.location=loc;}
    else {if (lowtarget=="_blank") {window.open(loc);}
    else {if (lowtarget=="_parent") {parent.location=loc;}
    else {parent.frames[target].location=loc;};
    }}}
    }
    function jump(menu)
    {
    ref=menu.cboCategorias.options[menu.cboCategorias.selectedIndex].value;
    splitc=ref.lastIndexOf("*");
    target="";
    if (splitc!=-1)
    {loc=ref.substring(0,splitc);
    target=ref.substring(splitc+1,1000);}
    else {loc=ref; target="_self";};
    if (ref != "") {land(loc,target);}
    }
    //-->
    </script>
  </head>
  <body>
<? include("../../system_menu.php"); ?><br>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="5" align="center" class="tituloFormulario">
          <b>LISTA DE TIPS</b>
          <br>
          <? $page->mostrar_numero_pagina() ?><br>
        </td>
      </tr>
      <tr>
        <td bgcolor="#FEF1E2"><b>Id.</b></td>
				<td bgcolor="#FEF1E2"><b>Publicado</b></td>
        <td bgcolor="#FEF1E2"><b>Tip</b></td>
        <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>
        <td align="center" bgcolor="#FEF1E2"><b>Imagen</b></td>
      </tr>
      <?
				$ContFilas			= 0;
				$ColorFilaPar		= "#FFFFFF";
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
          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idservicio"; ?></td>
					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->publicar"; ?></td>
          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->servicio"; ?></td>
          <td bgcolor="<? echo $ColorFila; ?>" align="center"><?php if($permisos["editar"]==1):?><a href="servicios.php?Accion=Editar&Id=<? echo "$row->idservicio"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->servicio"; ?>"></a><?php endif;?></td>
          <td bgcolor="<? echo $ColorFila; ?>" align="center">
            <?
              if ( !empty($row->imagen) )
              {
                ?><a target="_blank" href="<? echo $cRutaVerImgServicios . $row->imagen ; ?>">Ver</a><?
              }
              else
              {
                echo "No Asignada" ;
              }
              
            ?>
          
          </td>
        </tr>
        <?
        }
      ?>
      <tr>
        <td colspan="5"><? $page->mostrar_enlaces(); ?></td>
      </tr>
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
        	<?php if($permisos["crear"]==1):?>
      <tr>
        <td colspan="5" class="nuevo">
          <a href="servicios.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
        </td>
      </tr>
        	<?php endif;?>
      </table>
			<br><br><br><br><br>
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones inform�ticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
			</tr>
			</table>
  	</body>
</html>
