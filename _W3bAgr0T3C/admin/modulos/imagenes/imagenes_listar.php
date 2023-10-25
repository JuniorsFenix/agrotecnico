<?php
  include("../../herramientas/seguridad/seguridad.php");
  include("../../herramientas/paginar/class.paginaZ.php");
  include("../../funciones_generales.php");
	$sitioCfg = sitioAssoc2();
	$home = $sitioCfg["url"];
  include("../../vargenerales.php");
  $IdCiudad = $_SESSION["IdCiudad"];
  $page=new sistema_paginacion('tblimagenes a JOIN tblcategoriasimagenes b ON (a.idcategoria=b.idcategoria) ');
  $page->set_condicion( "WHERE a.idciudad = " . $IdCiudad );
  // Si se envio parametro para filtro categorias muestro realizo la condicion
  if ( isset ($_GET["IdCat"]) ) {
    $page->set_condicion("WHERE a.idcategoria = " . $_GET["IdCat"]);
  }
  $page->set_campos("a.*,b.categoria");
  $page->ordenar_por('a.idimagen desc');
  $page->set_limite_pagina(20);
  $result_page=$page->obtener_consulta();
  $page->set_color_tabla("#FEF1E2");
  $page->set_color_texto("black");
  $page->set_color_enlaces("black","#FF9900");
$permisos  = permisos("Galeria");
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
		<title>Lista de Imagenes</title>
    <script>
    <!--
    function land(ref, target) {
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
  <form action="imagenes_listar.php" method="post">
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td>Filtrar por Categor�as:</td>
        <td>
          <select name="cboCategorias">
            <option selected="true" value="imagenes_listar.php">Sin Filtro</option>
            <?
            $nConexion = Conectar();
            $Resultado = mysqli_query($nConexion, "SELECT * FROM tblcategoriasimagenes ORDER BY idcategoria" );
            mysqli_close($nConexion);
            while($Registros=mysqli_fetch_object($Resultado))
            {
              ?>
              <option value="<? echo "imagenes_listar.php?IdCat=$Registros->idcategoria"; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria; ?></option>
              <?
            }
            mysqli_free_result($Resultado);
            ?>
          </select>
          <input TYPE="button" VALUE="Ver" onClick="jump(this.form)">
        </td>
      </tr>
    </table>
  </form>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="9" align="center" class="tituloFormulario">
          <b>LISTA DE IMAGENES</b>
          <br>
          <? $page->mostrar_numero_pagina() ?><br>
        </td>
      </tr>
      <tr>
	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>
        <td bgcolor="#FEF1E2"><b>Id.</b></td>
        <td bgcolor="#FEF1E2"><b>Nombre Imagen</b></td>
	<td bgcolor="#FEF1E2"><b>Categoria</b></td>
	<td bgcolor="#FEF1E2"><b>Publicada</b></td>
        <td bgcolor="#FEF1E2"><b>Seleccionar</b></td>
        <td align="center" bgcolor="#FEF1E2"><b>Imagen
	<td bgcolor="#FEF1E2"><b>Eliminar</b></td>
	<td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>
	</b></td>
      </tr>
      <?
	$ContFilas			= 0;
	$ColorFilaPar		= "#FFFFFF";
	$ColorFilaImpar	= "#F0F0F0";
        while($row=mysqli_fetch_object($result_page)) {
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
	  <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>
          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idimagen"; ?></td>
          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->imagen"; ?></td>
	  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->categoria"; ?></td>
	  <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->publicar"; ?></td>
          <td bgcolor="<? echo $ColorFila; ?>" align="center"><?php if($permisos["editar"]==1):?><a href="imagenes.php?Accion=Editar&Id=<? echo "$row->idimagen"; ?>">
	  <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->imagen"; ?>"></a><?php endif;?></td>
          <td bgcolor="<? echo $ColorFila; ?>" align="center">
            <?
              if ( !empty($row->imagen) ) {
                ?><a target="_blank" href="<? echo $cRutaVerImgGaleria . $row->imagen ; ?>">Ver</a>
		<img src="<? echo $cRutaVerImgGaleria . $row->imagen; ?>" alt="" width="100" height="100" hspace="0" align="center" border="0" />
              <?
	      }
              else {
                echo "No Asignada" ;
              }
            ?>
          
          </td>
	  <td bgcolor="<? echo $ColorFila; ?>"align="center"><?php if($permisos["eliminar"]==1):?><a href="imagenes.php?Accion=Eliminar&Id=<?=$row->idimagen;?>" onclick="return confirm('�Seguro que desea eliminar este registro?');">
	  <img src="../../image/borrar.gif" border="0" ></a><?php endif;?></td>
	  <td bgcolor="<? echo $ColorFila; ?>">&nbsp;&nbsp;</td>
        </tr>
        <?
        }
      ?>
      <tr>
        <td colspan="6"><? $page->mostrar_enlaces(); ?></td>
      </tr>
      <tr>
        <td colspan="6">&nbsp;</td>
      </tr>
      <?php if($permisos["crear"]==1):?>
      <tr>
        <td colspan="6" class="nuevo">
          <a href="imagenes.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
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
