<?php
  include("../../herramientas/seguridad/seguridad.php");
  include("../../herramientas/paginar/class.paginaZ.php");
	include ("../../vargenerales.php");
  $page=new sistema_paginacion('tblciudades');
  $page->ordenar_por('ciudad');
  $page->set_limite_pagina(20);
  $rs_contenidos=$page->obtener_consulta();
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
<?php include("../../system_menu.php"); ?><br>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="5" align="center" class="tituloFormulario">
					<center>
          <b>LISTA DE IDIOMAS</b>
          <br>
          <?php $page->mostrar_numero_pagina() ?><br>
					</center>
        </td>
      </tr>
      <tr>
        <td bgcolor="#FEF1E2"><b>Id</b></td>
        <td bgcolor="#FEF1E2"><b>Idioma</b></td>
        <td bgcolor="#FEF1E2"><b>Código</b></td>
        <td bgcolor="#FEF1E2"><b>Publicado</b></td>
        <td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>
      </tr>
      <?php
				$ContFilas			= 0;
				$ColorFilaPar		= "#FFFFFF";
				$ColorFilaImpar	= "#F0F0F0";
        while( $row = mysqli_fetch_object( $rs_contenidos ) )
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
          <td bgcolor="<?php echo $ColorFila; ?>"><?php echo "$row->idciudad"; ?></td>
          <td bgcolor="<?php echo $ColorFila; ?>"><?php echo "$row->ciudad"; ?></td>
          <td bgcolor="<?php echo $ColorFila; ?>"><?php echo "$row->codigo"; ?></td>
					<td bgcolor="<?php echo $ColorFila; ?>"><?php echo "$row->publicar"; ?></td>
          <td bgcolor="<?php echo $ColorFila; ?>"align="center"><a href="idiomas.php?Accion=Editar&Id=<?php echo "$row->idciudad"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<?php echo "$row->ciudad"; ?>"></a>&nbsp;<a href="../sitio/sitio.php?idciudad=<?=$row->idciudad;?>">Editar Informacion</a></td>
        </tr>
        <?
        }
      ?>
      <tr>
        <td colspan="5"><?php $page->mostrar_enlaces(); ?></td>
      </tr>
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" class="nuevo">
          <a href="idiomas.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>
        </td>
      </tr>
      </table>
			<br><br><br><br><br>
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
			</tr>
			</table>
  	</body>
</html>
