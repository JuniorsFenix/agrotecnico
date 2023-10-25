<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../herramientas/paginar/class.paginaZ.php");

  include("../../funciones_generales.php");

  include("../../vargenerales.php");



  $nConexion    = Conectar();

  $sql="create table tblboletines_retirados (email varchar(255) not null primary key);";

  mysqli_query($nConexion,$sql);



  $page=new sistema_paginacion('tblboletines');

  $page->ordenar_por('fecha desc');

  $page->set_limite_pagina(10);

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

        <td colspan="5" align="center" class="tituloFormulario">

                    <center>

          <b>BOLETINES</b>

          <br>

          <? $page->mostrar_numero_pagina() ?>

                    </center>

        </td>

      </tr>

      <tr>

                <td bgcolor="#FEF1E2"><b>Id</b></td>

        <td bgcolor="#FEF1E2"><b>Fecha</b></td>

        <td bgcolor="#FEF1E2"><b>Titulo</b></td>

                <td bgcolor="#FEF1E2"><b>Plantilla</b></td>

        <td bgcolor="#FEF1E2" align="center"><b>Acci�n</b></td>

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

                    <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->idboletin"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->fecha"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->titulo"; ?></td>

                    <td bgcolor="<? echo $ColorFila; ?>"><? echo "$row->template"; ?></td>

          <td bgcolor="<? echo $ColorFila; ?>" align="center">

                        <a href="boletines.php?Accion=Editar&Id=<? echo "$row->idboletin"; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<? echo "$row->titulo"; ?>"></a>

                        &nbsp;

                        <a href="bloques_listar.php?idboletin=<? echo "$row->idboletin"; ?>&boletin=<?=$row->titulo;?>"><img src="../../image/bol_bloques.gif" border="0" alt="Ver Bloques"></a>

                        &nbsp;

                        <a target="_blank" href="<? echo $cRutaVerPlantillas_GenBoletines . $row->template ;?>/index.php?bol=<?=$row->idboletin ;?>">Ver</a>

                        &nbsp;

                        <a target="_blank" href="<? echo $cRutaVerPlantillas_GenBoletines . $row->template ;?>/codigohtm.php?bol=<?=$row->idboletin ;?>">Codigo</a>

                        &nbsp;

                        <a target="_self" href="enviar.php?bol=<?=$row->idboletin ;?>&template=<?=$row->template;?>">Enviar</a>

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

      <tr>

        <td colspan="5" class="nuevo">

          <a href="boletines.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>

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