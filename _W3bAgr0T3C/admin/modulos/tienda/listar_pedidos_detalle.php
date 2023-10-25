<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include ("../../vargenerales.php");

  require_once("../../funciones_generales.php");



  $nConexion = Conectar();
  
  $Resultado = mysqli_query($nConexion, "SELECT fecha FROM tblti_carro WHERE carro={$_GET["carro"]}");
  $carro = mysqli_fetch_object($Resultado);
  
  
  $date = new DateTime($carro->fecha);

  $page=new sistema_paginacion('tblti_carro_detalle a join tblti_productos b on (a.idproducto=b.idproducto)');

  $page->set_campos("a.detalle,a.item,b.referencia,a.descripcion,a.unidades,a.precio,b.mantenimiento");

  $page->set_condicion("where a.carro={$_GET["carro"]}");

  $page->ordenar_por('a.detalle desc');

  $page->set_limite_pagina(20);

  $rs_contenidos=$page->obtener_consulta();

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

        <td colspan="9" align="center" class="tituloFormulario">

          <center>

          <b>LISTA DE DETALLE DE PEDIDOS</b>

          <br>

          <? $page->mostrar_numero_pagina() ?><br>

          </center>

        </td>

      </tr>

      <tr>

        <td bgcolor="#FEF1E2"><b>Id</b></td>

        <td bgcolor="#FEF1E2"><b>Id Producto</b></td>

        <td bgcolor="#FEF1E2"><b>Referencia</b></td>

        <td bgcolor="#FEF1E2"><b>Descripcion</b></td>

        <td bgcolor="#FEF1E2"><b>Unidades</b></td>

        <td bgcolor="#FEF1E2"><b>Precio</b></td>

        <td bgcolor="#FEF1E2"><b>Mantenimiento</b></td>

      </tr>

      <?php
        $ContFilas			= 0;
        $ColorFilaPar		= "#FFFFFF";
        $ColorFilaImpar	= "#F0F0F0";
        while( $row = mysqli_fetch_object( $rs_contenidos ) ) {
            $fecha = '';
            if(!empty($row->mantenimiento)) {
                $dias = $row->mantenimiento;
                $interval = "P{$dias}D";
                $date->add(new DateInterval($interval));
                $fecha = $date->format('d-m-Y');
            }
            
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

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->detalle"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->item"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->referencia"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->descripcion"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->unidades"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->precio"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo $fecha; ?></td>

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

      </table>

      <br><br><br><br><br>

      <table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>

        <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

      </tr>

      </table>

    </body>

</html>









