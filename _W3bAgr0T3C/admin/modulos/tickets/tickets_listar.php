<?php

require_once("../../herramientas/seguridad/seguridad.php");

require_once("../../herramientas/paginarAdmin/class.paginaZ.php");

require_once("../../herramientas/paginarAdmin/dbquery.inc.php");

require_once("../../herramientas/seguridad/validate.php");

require_once("../../funciones_generales.php");

require_once("../../vargenerales.php");

$IdCiudad = $_SESSION["IdCiudad"];



$filtro = isset($_GET["filtro"])?$_GET["filtro"]:"";

$idempresa = isset($_GET["idempresa"])?$_GET["idempresa"]:"todas";

$idsede = isset($_GET["idsede"])?$_GET["idsede"]:"todas";

$idzona = isset($_GET["idzona"])?$_GET["idzona"]:"todas";

$idregion = isset($_GET["idregion"])?$_GET["idregion"]:"todas";

$tipo = isset($_GET["tipo"])?$_GET["tipo"]:"todos";

//$estado = isset($_GET["estado"])?$_GET["estado"]:"todos";





	$estado = varValidator::validateReqString("get", "estado", false,"abiertos");



$where = "1=1 ";

$where .= $estado == "abiertos" ? "and a.estado<>'cerrado'" : ($estado == "cerrados" ? "and a.estado='cerrado'" : "");

if ( $filtro != "" ) {

    $where .= "and (upper(CONCAT(e.nombre,' ',e.apellido)) like upper('%{$filtro}%') or upper(a.asunto) like upper('%{$filtro}%') 

        or upper(a.mensaje) like upper('%{$filtro}%')) ";

}

if ( $idempresa != "todas" ) {

    $where .= "and d.idempresa='{$idempresa}' ";

}

if ( $idsede != "todas" ) {

    $where .= "and b.idsede='{$idsede}' ";

}

if ( $idzona != "todas" ) {

    $where .= "and f.idzona='{$idzona}' ";

}

if ( $idregion != "todas" ) {

    $where .= "and g.idregion='{$idregion}' ";

}

if ( $tipo != "todos" ) {

    $where .= "and c.tipo='{$tipo}' ";

}

/*if ( $estado != "todos" ) {

    $where .= "and a.estado='{$estado}' ";

}*/





$nConexion = Conectar();

	$sql = "SELECT  from  WHERE {} order by ";

	$ca = new DbQuery($nConexion);

	$ca->prepareSelect("tbltk_tickets a 

join tbltk_sedes b on (a.idsede=b.idsede)

join tbltk_sedes_usuarios c on (a.idusuario=c.idusuario)

join tbltk_zonas f on (b.idzona=f.idzona)

join tbltk_regiones g on (f.idregion=g.idregion)

join tbltk_empresas d on (g.idempresa=d.idempresa)

join tblusuarios_externos e on (a.idusuario=e.idusuario)","a.idticket,a.fechahora,concat(e.nombre,' ',e.apellido) as nombre,c.tipo as perfil,b.nombre as sede,f.nombre as zona,g.nombre as region,d.nombre as empresa,a.asunto,

    SUBSTR(a.mensaje,1,25) as mensaje,a.prioridad,a.estado,visto",$where,"a.idticket desc");	

        //echo "XXXX ".$ca->preparedQuery();

		

		

if ( isset($_GET["idempresa"]) ) {

    $pagerVars = "idempresa={$idempresa}&idsede={$idsede}&idzona={$idzona}&idregion={$idregion}&tipo={$tipo}&estado={$estado}&filtro={$filtro}";

}

	

	$pag = isset($_GET["pag"]) ? $_GET["pag"]:1;

	$page = $ca->execPage(array("pager"=>true,"page"=>$pag,"count"=>20,"pagerVars"=>"{$pagerVars}"));

	







$ca = new DbQuery($nConexion);

$ca->prepareSelect("tbltk_empresas", "*");

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

			.jlib-pager a, .jlib-pager a:visited {

    color: #000;}

	.jlib-pager-current a{color: #FFF;}

        </style>



        <title>Lista de Tickets</title>



    </head>

    <body>

        <?php require_once("../../system_menu.php"); ?><br>



        <form action="tickets_listar.php" method="post" name="formT">

            Empresa: <select id="idempresa" name="idempresa">

                <option value="todas" <?php echo $idempresa=="todas"?"selected":"";?>>Todas</option>

                <?php foreach ( $rEmpresas as $r):?>

                <option value="<?php echo $r["idempresa"];?>" <?php echo $idempresa==$r["idempresa"]?"selected":"";?>><?php echo $r["nombre"];?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Sedes: <select id="idsede" name="idsede">

                <option value="todas" <?php echo $idsede=="todas"?"selected":"";?>>Todas</option>

                <?php foreach ( $rSedes as $r):?>

                <option value="<?php echo $r["idsede"];?>" <?php echo $idsede==$r["idsede"]?"selected":"";?>><?php echo $r["nombre"];?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Zonas: <select id="idzona" name="idzona">

                <option value="todas" <?php echo $idzona=="todas"?"selected":"";?>>Todas</option>

                <?php foreach ( $rZonas as $r):?>

                <option value="<?php echo $r["idzona"];?>" <?php echo $idzona==$r["idzona"]?"selected":"";?>><?php echo $r["nombre"];?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Regiones: <select id="idregion" name="idregion">

                <option value="todas" <?php echo $idregion=="todas"?"selected":"";?>>Todas</option>

                <?php foreach ( $rRegiones as $r):?>

                <option value="<?php echo $r["idregion"];?>" <?php echo $idregion==$r["idregion"]?"selected":"";?>><?php echo $r["nombre"];?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Perfil: <select id="tipo" name="tipo">

                <option value="todos" <?php echo $tipo=="todos"?"selected":"";?>>Todos</option>

                <?php foreach ( $rTiposUsuario as $k => $v ):?>

                <option value="<?php echo $k;?>" <?php echo $tipo==$k?"selected":"";?>><?php echo $v;?></option>

                <?php endforeach;?>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Estado: <select id="estado" name="estado">

                                                <option value="abiertos" <?php echo $estado=="abiertos"?"selected":"";?>>Abiertos</option>

                                                <option value="cerrados" <?php echo $estado=="cerrados"?"selected":"";?>>Cerrados</option>

                                                <option value="todos" <?php echo $estado=="todos"?"selected":"";?>>Todos</option>

            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            Filtro: <input id="filtro" name="filtro" type="text"/>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                

            <input TYPE="button" VALUE="Filtrar" onClick="var filtro = document.getElementById('filtro');

                var e = document.getElementById('idempresa');

                var s = document.getElementById('idsede');

                var z = document.getElementById('idzona');

                var r = document.getElementById('idregion');

                var t = document.getElementById('tipo');

                var d = document.getElementById('estado');

                window.location = 'tickets_listar.php?idempresa='+e.value+'&idsede='+s.value+'&idzona='+z.value+'&idregion='+r.value+'&tipo='+t.value+'&estado='+d.value+'&filtro='+filtro.value;"/>

        </form>



        <table border="0" width="100%" cellspacing="0" cellpadding="0">

            <tr>

                <td colspan="15" align="center" class="tituloFormulario">

                    <b>LISTA DE TICKETS</b>

                    <br/>

                    <br/>

                </td>

            </tr>

            <tr>

                <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

                <td bgcolor="#FEF1E2"><b>Id.</b></td>

                <td bgcolor="#FEF1E2"><b>Fecha Hora</b></td>

                <td bgcolor="#FEF1E2"><b>Nombre</b></td>

                <td bgcolor="#FEF1E2"><b>Perfil</b></td>

                <td bgcolor="#FEF1E2"><b>Sede</b></td>

                <td bgcolor="#FEF1E2"><b>Zona</b></td>

                <td bgcolor="#FEF1E2"><b>Region</b></td>

                <td bgcolor="#FEF1E2"><b>Empresa</b></td>

                <td bgcolor="#FEF1E2"><b>Asunto</b></td>

                <td bgcolor="#FEF1E2"><b>Mensaje</b></td>

                <td bgcolor="#FEF1E2"><b>Prioridad</b></td>

                <td bgcolor="#FEF1E2"><b>Estado</b></td>

                <td bgcolor="#FEF1E2"><b>Ver</b></td>

                <td bgcolor="#FEF1E2"><b>&nbsp;&nbsp;</b></td>

            </tr>

            <?php

            $ContFilas = 0;

            $ColorFilaPar = "#FFFFFF";

            $ColorFilaImpar = "#F0F0F0";

				if ( $page["error"] == false )

				{

				foreach($page["records"] as $row){

                $ContFilas = $ContFilas + 1;

                if (fmod($ContFilas, 2) == 0) {

                    $ColorFila = $ColorFilaPar;

                } else {

                    $ColorFila = $ColorFilaImpar;

                }

				$nConexion = Conectar();

				$result = mysqli_query($nConexion,"SELECT visto FROM tbltk_tickets_mensajes where idticket={$row["idticket"]} order by idmensaje desc");

				$rVisto = mysqli_fetch_array($result);

				$num_results = mysqli_num_rows($result); 

				mysqli_close($nConexion);

				$VistosT = explode(',',$row["visto"]);

				if($rVisto["visto"]==""){

					if ($num_results > 0){

					  $ColorFila = "#FFE6CC";

						}

					elseif (!in_array($_SESSION["IdUser"], $VistosT)) {

					  $ColorFila = "#FFE6CC";

					}

				}

				else{

					$VistosM = explode(',',$rVisto["visto"]);

					if ((!in_array($_SESSION["IdUser"], $VistosM)) || (!in_array($_SESSION["IdUser"], $VistosT))) {

					  $ColorFila = "#FFE6CC";

					}

				}

                ?>

                <tr>

                    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;</td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row["idticket"]; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row["fechahora"]; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row["nombre"]; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row["perfil"]; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row["sede"]; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row["zona"]; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row["region"]; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row["empresa"]; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row["asunto"]; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row["mensaje"]; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row["prioridad"]; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>"><?php echo $row["estado"]; ?></td>

                    <td bgcolor="<?php echo $ColorFila; ?>" align="center">

                        <a href="tickets.php?Accion=Ver&Id=<?php echo $row["idticket"];?>">

                            ...

                        </a>

                    </td>

                    <td bgcolor="<?php echo $ColorFila; ?>">&nbsp;&nbsp;</td>

                </tr>

                <?

            }

            ?>

            <tr>

                <td colspan="15">

                    <?php     

						echo $page["pager"];

                        }

                        else

                        {

                          echo "No se encontraron Tickets.";

                        }

                    ?>

                </td>

            </tr>

            <tr>

                <td colspan="15" style="text-align: center;">

                    <br/>

                    <input TYPE="button" VALUE="Exportar a excel" onClick="var filtro = document.getElementById('filtro');

                    var e = document.getElementById('idempresa');

                    var s = document.getElementById('idsede');

                    var z = document.getElementById('idzona');

                    var r = document.getElementById('idregion');

                    var t = document.getElementById('tipo');

                    window.location = 'tickets.php?Accion=Exportar&idempresa='+e.value+'&idsede='+s.value+'&idzona='+z.value+'&idregion='+r.value+'&tipo='+t.value+'&filtro='+filtro.value;"/>

            		<!--<a href="tickets.php?Accion=Nuevo"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a>-->

                </td>

            </tr>

            <tr>

                <td colspan="15">&nbsp;</td>

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

