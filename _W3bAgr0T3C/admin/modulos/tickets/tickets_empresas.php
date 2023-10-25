<?php

require_once("../../herramientas/seguridad/seguridad.php");

require_once("../../herramientas/paginar/class.paginaZ.php");

require_once("../../herramientas/paginar/dbquery.inc.php");

require_once("../../herramientas/seguridad/validate.php");

require_once("../../funciones_generales.php");

require_once("../../vargenerales.php");

$IdCiudad = $_SESSION["IdCiudad"];





$nConexion = Conectar();

$ca = new DbQuery($nConexion);

$ca->prepareSelect("tbltk_empresas", "*","","nombre");

$ca->exec();

$rEmpresas = $ca->assocAll();

$ca = new DbQuery($nConexion);

$ca->prepareSelect("tbltk_sedes", "*");

$ca->exec();

$rSedes = $ca->assocAll();

$ca = new DbQuery($nConexion);

$ca->prepareSelect("tbltk_zonas", "*");

$ca->exec();

$rZonas = $ca->assocAll();

$ca = new DbQuery($nConexion);

$ca->prepareSelect("tbltk_regiones", "*");

$ca->exec();

$rRegiones = $ca->assocAll();

mysqli_close($nConexion);

$rTiposUsuario = array("admin"=>"Administrador","operador"=>"Operario");

$rEstados = array("abierto, enproceso"=>"Abiertos","enproceso"=>"En Proceso","respuestacliente"=>"Respuesta Cliente","contestado"=>"Contestado","retenido"=>"Retenido","cerrado"=>"Cerrado");

?>



<html>

    <head>

        <link href="../../css/administrador.css" rel="stylesheet" type="text/css">

		<link href="/css/paginador.css" rel="stylesheet" type="text/css">

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



        <title>Lista de Tickets</title>



    </head>

    <body>

        <?php require_once("../../system_menu.php"); ?><br>

        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td colspan="1" align="center" class="tituloFormulario">

                    <b>LISTA DE EMPRESAS</b>

                    <input style="margin-left:111px;" type="button" value="Actualizar" onClick="window.location.reload()">                    <br/>

                </td>

            </tr>

            <tr>

                <td colspan="1">

                	<div id="margen">

						<?php

                        $ContFilas = 0;

                        $ColorFilaPar = "#FFFFFF";

                        $ColorFilaImpar = "#F0F0F0";

                        ?>

                        <?php $i=0;foreach ( $rEmpresas as $r):

						$ContFilas = $ContFilas + 1;

						if (fmod($ContFilas, 2) == 0) {

							$ColorFila = $ColorFilaPar;

						} else {

							$ColorFila = $ColorFilaImpar;

						}

						$nConexion = Conectar();

						  $ras = mysqli_query($nConexion,"select * from tbltk_tickets a

join tbltk_sedes b on (a.idsede=b.idsede)

join tbltk_zonas f on (b.idzona=f.idzona)

join tbltk_regiones g on (f.idregion=g.idregion)

join tbltk_empresas d on (g.idempresa=d.idempresa) where (FIND_IN_SET({$_SESSION["IdUser"]},a.para) and a.estado!='cerrado' and NOT FIND_IN_SET({$_SESSION["IdUser"]},a.visto) and d.idempresa={$r["idempresa"]})");

						  $mensajes1 = mysqli_num_rows($ras);



						$ras2 = mysqli_query($nConexion,"select m.idmensaje from tbltk_tickets_mensajes m

join tbltk_tickets a on (m.idticket=a.idticket) 

join tbltk_sedes b on (a.idsede=b.idsede)

join tbltk_zonas f on (b.idzona=f.idzona)

join tbltk_regiones g on (f.idregion=g.idregion)

join tbltk_empresas d on (g.idempresa=d.idempresa) where (FIND_IN_SET({$_SESSION["IdUser"]},a.para) and NOT FIND_IN_SET({$_SESSION["IdUser"]},m.visto) and d.idempresa={$r["idempresa"]})");

						  $mensajes2 = mysqli_num_rows($ras2);

						  $mensajes = $mensajes1+$mensajes2;

						mysqli_close($nConexion);?>

                        <?php if($i==0):?>

                        <ul class="empresas">

                        <?php endif;?>

                    	<li><a href="tickets_listar.php?idempresa=<?php echo $r["idempresa"];?>" style="background:<?php echo $ColorFila; ?>;"><?php echo $r["nombre"];?>

                        <?=$mensajes!=0?"<span id='mensajes'>{$mensajes}</span>":"";?>

                        </a></li>

                        <?php if(++$i==10):$i=0;?>

                        </ul>

                        <?php endif;?>

                        <?php endforeach;?>

                   </div>

                </td>

            </tr>

            <tr>

                <td colspan="1">&nbsp;</td>

            </tr>

        </table>

        <br/><br/><br/><br/><br/>

        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>

            </tr>

        </table>

    </body>

</html>