<?



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



<? include("../../system_menu.php"); ?><br>



    <table border="0" width="100%" cellspacing="0" cellpadding="0">



      <tr>



        <td colspan="4" align="center" class="tituloFormulario">



					<center>



          <b>LISTA DE CIUDADES</b>



          <br>



          <? $page->mostrar_numero_pagina() ?><br>



					</center>



        </td>



      </tr>



      <tr>



        <td bgcolor="#FEF1E2"><b>Id</b></td>



        <td bgcolor="#FEF1E2"><b>Ciudad</b></td>



        <td bgcolor="#FEF1E2"><b>Publicado</b></td>



        <td bgcolor="#FEF1E2" align="center"><b>Seleccionar</b></td>



      </tr>



      <?



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



          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idciudad"; ?></td>



          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->ciudad"; ?></td>



					<td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->publicar"; ?></td>



          <td bgcolor="<? echo $ColorFila; ?>"align="center"><a href="ciudades.php?Accion=Editar&Id=<? echo "$row->idciudad"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->ciudad"; ?>"></a>&nbsp;<a href="../opgenerales/op_generales.php?idciudad=<?=$row->idciudad;?>">Opciones</a></td>



        </tr>



        <?



        }



      ?>



      <tr>



        <td colspan="4"><? $page->mostrar_enlaces(); ?></td>



      </tr>



      <tr>



        <td colspan="4">&nbsp;</td>



      </tr>



      <tr>



        <td colspan="4" class="nuevo">



          <a href="ciudades.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>



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



















