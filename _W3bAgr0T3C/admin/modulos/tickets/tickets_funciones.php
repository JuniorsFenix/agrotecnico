<?php
require_once("../../funciones_generales.php");
require_once("../../herramientas/paginar/dbquery.inc.php");
require_once("../../herramientas/XPM4-v.0.4/MAIL.php");
require_once("../../vargenerales.php");

/*
 * a.     Abierto = #090
 * b.     Retenido = #F00
 * c.     En Proceso = #00C
 * d.     Contestado = #F60
 * e.     Cerrado = #666
 * f.      Respuesta-Cliente = #90C
 * 
 */
$estados = array(
    "cerrado" => "Cerrado",
    "contestado" => "Contestado",
    "enproceso" => "En Proceso",
    "retenido" => "Retenido"
);
?>
<?php

function TicketsResponder($nId, $mensaje, $estado, $adjuntos) {
	
		error_reporting(E_ALL ^E_WARNING);
    global $cRutaTicketsAdjunto;
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);

    $ca->prepareSelect("tbltk_tickets a join tblusuarios_externos b on (a.idusuario=b.idusuario)", "a.*,concat(b.nombre,' ',b.apellido) as nombre_remitente,b.correo_electronico", "a.idticket=:idticket");
    $ca->bindValue(":idticket", $nId, false);
    $ca->exec();

    if ($ca->size() == 0) {
        mysqli_close($nConexion);
        Mensaje("Error, ticket no encontrado.", "tickets_listar.php");
        return;
    }

    $rTicket = $ca->fetch();
	
	
    $ca->prepareInsert("tbltk_tickets_mensajes", "idticket,asunto,mensaje,idusuario,fechahora");
    $ca->bindValue(":idticket", $nId, false);
    $ca->bindValue(":asunto", $rTicket["asunto"], true);
    $ca->bindValue(":mensaje", $mensaje, true);
    //$ca->bindValue(":adjuntos", json_encode($rAdjuntos, JSON_FORCE_OBJECT), true);
    $ca->bindValue(":idusuario", "-1", false);
    $ca->bindValue(":visto", "1,2", false);
    $ca->bindValue(":fechahora", "current_timestamp", false);

    if (!$ca->exec()) {
        Mensaje("Error registrando mensaje {$nId}", "tickets_listar.php");
        exit;
    }

    $idMensaje = mysqli_insert_id($nConexion);


$rAdjuntos = array();
    if (isset($adjuntos)) {
        $upload_dir = $cRutaTicketsAdjunto;
        $i = 0;
        $f = $adjuntos;
        for ($i = 0; $i < count($f["name"]); $i++) {
            if ($f["name"][$i] != "") {
                $name = "m_{$idMensaje}_{$f["name"][$i]}";
                $rAdjuntos[] = $name;
                if ($f["error"][$i] == UPLOAD_ERR_OK) {
                    if (!move_uploaded_file($f["tmp_name"][$i], $upload_dir . $name)) {
                        die("Fallo cargando archivo al servidor");
                    }
                }
            }
        }
    }
    

    $ca->prepareUpdate("tbltk_tickets_mensajes", "adjuntos", "idmensaje=:idmensaje");
    $ca->bindValue(":adjuntos", json_encode($rAdjuntos, JSON_FORCE_OBJECT), true);
    $ca->bindValue(":idmensaje", $idMensaje, false);
    $ca->exec();

    $ca->prepareUpdate("tbltk_tickets", "estado", "idticket=:idticket");
    $ca->bindValue(":idticket", $nId, false);
    $ca->bindValue(":estado", $estado, true);
    if (!$ca->exec()) {
        Mensaje("Error registrando estado del ticket {$nId}", "tickets_empresas.php");
        exit;
    }
	
	$usuarios=array();
  $ras = mysqli_query($nConexion,"select * from tblusuarios where idusuario<>0");
  while( $usuario = mysqli_fetch_assoc($ras) ){
    $usuarios[ $usuario["idusuario"] ] = $usuario;
  }
  
	
  	$rax = mysqli_query($nConexion,"select * from tbltk_tickets where idticket={$nId}");
	$p = mysqli_fetch_assoc($rax);
	$idsede = $p["idsede"];
	$idprofesional = explode(',',$p["para"]);
	
  $ras = mysqli_query($nConexion,"select * from tbltk_sedes where idsede={$idsede}");
  $sedes = mysqli_fetch_assoc($ras);

    $m = new MAIL();
    $host = str_replace("www.", "", $_SERVER["HTTP_HOST"]);

    $to = $rTicket["correo_electronico"];
    $toName = $rTicket["nombre_remitente"];

    $subject = "Respuesta ticket:{$rTicket["idticket"]} , {$rTicket["asunto"]}";
    $message = "Soporte dice:<br/><br/>{$mensaje}";

    if (count($rAdjuntos) > 0) {
        $message .= "<br/><br/>NOTA: Este mensaje contiene adjuntos, para verlos ingrese en su Zona Privada a Ticket";
    }

    $url = "http://{$_SERVER["HTTP_HOST"]}/formZonaPrivada";
    $message .= "<br/><br/><a href='{$url}'>Ver Ticket<a/><br/><br/>";

    $from = !empty($from) ? $from : "solicitudes@{$host}";
    $fromName = !empty($fromName) ? $fromName : "Soporte";

    $m->addHeader("charset", "utf-8");
    $m->from($from, $fromName);
	$m->addto($sedes["correo_contacto"],$sedes["contacto"]);
	$m->AddBcc($to,$toName);  
	if( is_array($idprofesional) ){
	  foreach($idprofesional as $r){
	  $m->AddBcc($usuarios[$r]["correo_electronico"],$usuarios[$r]["nombres"]);                   
	  }
	}
    $m->subject($subject);

    $m->html($message);

    $cHost = $host;
    $cPort = 25;
    $cUser = "solicitudes@{$host}";
    $cPass = "/060371*";

    $c = $m->Connect($cHost, $cPort, $cUser, $cPass);
    $status = $m->send($c);

    if (!$status) {
        die("Error enviando mensaje");
    }

    mysqli_close($nConexion);
    Mensaje("El registro ha sido actualizado correctamente.", "tickets_empresas.php");
    return;
}
?>
<?php

function TicketsVer($nId) {
    global $estados;
    global $cRutaVerTicketsAdjunto;
    $IdCiudad = $_SESSION["IdCiudad"];

    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);

    $sql = "select 
 � � � � � �a.*,
 � � � � � �concat(b.nombre,' ',b.apellido) as nombre_remitente,
            b.correo_electronico
 � � � � � �from tbltk_tickets a 
 � � � � � �join tblusuarios_externos b on (a.idusuario=b.idusuario)
 � � � � � �where a.idticket = :idticket ";

    $ca->prepare($sql);
    $ca->bindValue(":idticket", $nId);
    $ca->exec();
    $r["ticket"] = $ca->fetch();

    $sql = "select 
 � � � � � �a.*,
 � � � � � �case when a.idusuario=-1 then 'Asesor'
 � � � � � �else concat(b.nombre,' ',b.apellido) end as nombre_remitente
 � � � � � �from tbltk_tickets_mensajes a 
 � � � � � �left join tblusuarios_externos b on (a.idusuario=b.idusuario)
 � � � � � �where a.idticket = :idticket order by idmensaje asc";

    $ca->prepare($sql);
    $ca->bindValue(":idticket", $nId);
    $ca->exec();
    $r["mensajes"] = $ca->fetchAll();
	
	
	if(empty($r["ticket"]["visto"])){
		$visto=$_SESSION["IdUser"];
	}
	else{
		$Vistos = explode(',',$r["ticket"]["visto"]);
		if (!in_array($_SESSION["IdUser"], $Vistos)) {
		$visto=$r["ticket"]["visto"].",".$_SESSION["IdUser"];
		}
		else{
			$visto=$r["ticket"]["visto"];
		}
	}
	
    $ca->prepareUpdate("tbltk_tickets", "visto", "idticket=:idticket");
    $ca->bindValue(":idticket", $nId, false);
    $ca->bindValue(":visto", $visto, true);
    $ca->exec();
    mysqli_close($nConexion);
    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="tickets.php?Accion=Responder" enctype="multipart/form-data" >
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>"/>
        <table width="100%">
            <tr>
                <td colspan="2" align="center" class="tituloFormulario"><b>Ticket # <?php echo $nId; ?></b></td>
            </tr>
        </table>
        <style>
            .encTicket
            {
                background-color: #E6E6E6;
                color: #333333;
                font-family: Verdana,Arial,Helvetica,sans-serif;
                font-size: 12px;
                font-weight: bold;
                padding: 4px;
                text-align: left;
                vertical-align: top;
            }
            .contenidoEncTicket 
            {
                background-color: #D7D7D7;
                padding: 4px;
                text-align: left;
                vertical-align: top;
            }
        </style>
        <table width="100%" style="">
            <tr>
                <td style="width: 5%;">&nbsp;</td>
                <td class="encTicket">Fecha</td>
                <td class="encTicket">Asunto</td>
                <td class="encTicket">Estado</td>
                <td class="encTicket">Urgencia</td>
                <td style="width: 5%;">&nbsp;</td>
            </tr>
            <tr>
                <td >&nbsp;</td>
                <td class="contenidoEncTicket"><?php echo $r["ticket"]["fechahora"]; ?></td>
                <td class="contenidoEncTicket"><?php echo $r["ticket"]["asunto"]; ?></td>
                <td class="contenidoEncTicket"><?php echo $r["ticket"]["estado"]; ?></td>
                <td class="contenidoEncTicket"><?php echo $r["ticket"]["prioridad"]; ?></td>
                <td >&nbsp;</td>
            </tr>
        </table>
        <br/>

        <table width="100%;">
            <tr>
                <td >&nbsp;</td>
                <td style="width: 90%;" <?php echo $r["ticket"]["idusuario"] == -1 ? "bgcolor='#BABFFB'" : "bgcolor='#E0F0F0'"; ?>>
                    <?php echo $r["ticket"]["nombre_remitente"]; ?><br/>
                    <?php echo $r["ticket"]["idusuario"] == -1 ? "Soporte" : "Cliente"; ?><br/>
                    <?php echo $r["ticket"]["fechahora"]; ?>
                </td>
                <td >&nbsp;</td>
            </tr>
            <tr>
                <td >&nbsp;</td>
                <td <?php echo $r["ticket"]["idusuario"] == -1 ? "bgcolor='#FFFFFF'" : "bgcolor='#FFFFFF'"; ?>>
                    <?php echo nl2br($r["ticket"]["mensaje"]); ?>
                </td>
                <td >&nbsp;</td>
            </tr>
            <tr>
                <td >&nbsp;</td>
                <td <?php echo $r["ticket"]["idusuario"] == -1 ? "bgcolor='#FFFFFF'" : "bgcolor='#FFFFFF'"; ?>>
                    Adjuntos: <br/>
                    <?php
                    if (json_decode($r["ticket"]["adjuntos"]) != null) {
                        foreach (json_decode($r["ticket"]["adjuntos"]) as $a):
                            ?>
                            <a href="<?php echo "{$cRutaVerTicketsAdjunto}{$a}"; ?>" target="_blank">Descargar <?php echo $a; ?></a><br/>
                            <?php
                        endforeach;
                    }
                    ?>
                </td>
                <td >&nbsp;</td>
            </tr>
        </table>
        <br/>

        <?php
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);
	 foreach ($r["mensajes"] as $m):
	
	if(empty($m["visto"])){
		$visto=$_SESSION["IdUser"];
	}
	else{
		$Vistos = explode(',',$m["visto"]);
		if (!in_array($_SESSION["IdUser"], $Vistos)) {
		$visto=$m["visto"].",".$_SESSION["IdUser"];
		}
		else{
			$visto=$m["visto"];
		}
	}
	
    $ca->prepareUpdate("tbltk_tickets_mensajes", "visto", "idmensaje=:idmensaje");
    $ca->bindValue(":idmensaje", $m["idmensaje"], false);
    $ca->bindValue(":visto", $visto, true);
    $ca->exec();
	 ?>
            <table width="100%;">
                <tr>
                    <td >&nbsp;</td>
                    <td style="width: 90%; color: #333;" <?php echo $m["idusuario"] == -1 ? "bgcolor='#D8D8D8'" : "bgcolor='#C8C8C8'"; ?>>
                        <?php echo $m["nombre_remitente"]; ?><br/>
                        <?php echo $m["idusuario"] == -1 ? "Soporte" : "Cliente"; ?><br/>
                        <?php echo $m["fechahora"]; ?>
                    </td>
                    <td >&nbsp;</td>
                </tr>
                <tr>
                    <td >&nbsp;</td>
                    <td <?php echo $m["idusuario"] == -1 ? "bgcolor='#FFFFFF'" : "bgcolor='#FFFFFF'"; ?>>
                        <?php echo nl2br($m["mensaje"]); ?>
                    </td>
                    <td >&nbsp;</td>
                </tr>
                <tr>
                    <td >&nbsp;</td>
                    <td <?php echo $m["idusuario"] == -1 ? "bgcolor='#FFFFFF'" : "bgcolor='#FFFFFF'"; ?>>
                        Adjuntos: <br/>
                        <?php
                        if (json_decode($m["adjuntos"]) != null) {
                            foreach (json_decode($m["adjuntos"]) as $a):
                                ?>
                                <a href="<?php echo "{$cRutaVerTicketsAdjunto}{$a}"; ?>" target="_blank">Descargar <?php echo $a; ?></a><br/>
                                <?php
                            endforeach;
                        }
                        ?>
                    </td>
                    <td >&nbsp;</td>
                </tr>
            </table>
            <br/>
        <?php endforeach;
		mysqli_close($nConexion);
		 ?>

        <br/>

        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablaTicketForm">
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td colspan="2" style="text-align: center;">
                    <input type="button" name="bCerrar" value="Cerrar Ticket" onClick="var idticket = document.getElementById('txtId');
                        window.location = 'tickets.php?Accion=CerrarTicket&idticket='+idticket.value;
                           " />
                    <br/><hr/><br/>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td colspan="2" style="text-align: center;">
                    <br/>
                    <h3>Estado: <select name="estado">
                            <?php foreach ($estados as $k => $v): ?>
                                <option value="<?php echo $k; ?>" <?php echo $k == "contestado" ? "selected" : ""; ?>><?php echo $v; ?></option>
                            <?php endforeach; ?>
                        </select></h3>
                    <br/>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td colspan="2">
                    <h3>Responder</h3>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td class="encTicket">Nombre:</td>
                <td class="contenidoEncTicket">
                    <input name="nombre" type="text" disabled="disabled" id="bombre" value="<?php echo $r["ticket"]["nombre_remitente"]; ?>" style="width:280px;"/>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td class="encTicket">Direcci&oacute;n de Email:</td>
                <td class="contenidoEncTicket">
                    <input name="correo" type="text" disabled="disabled" id="correo" value="<?php echo $r["ticket"]["correo_electronico"]; ?>" style="width:280px;"/>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td class="encTicket">Detalles del Ticket:</td>
                <td class="contenidoEncTicket">
                    <textarea name="mensaje" cols="45" rows="5" placeholder="Ac&aacute; ir�n los datos que son necesarios o especificos para cada sede..." id="detalle"></textarea>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td class="encTicket">Adjunto:
                    <a href="#nolink" onClick="nuevoAdjunto();">
                        <img src="../../../fotos/Image/contenidos/add.gif" width="16" height="16" />
                    </a>
                    <script type="text/javascript">
                        function nuevoAdjunto(){
                            $('.files-adjuntos').append('<input type="file" name="adjunto[]" /><br/>');
                        }
                    </script></td>
                <td class="contenidoEncTicket">
                    <div class="files-adjuntos">
                        <input type="file" name="adjunto[]" /><br/>
                    </div>
                    <br/><br/>
                    <p>(Extensiones de archivo permitidas: .jpg,.gif,.jpeg,.png,.pdf,.bmp,.doc,.docx,.ppt,.pptx,.txt,.rtf,.xls,.xlsx)</p>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td class="contenidoEncTicket">&nbsp;</td>
                <td class="contenidoEncTicket">
                    <input type="submit" name="bEnviar" id="button2" value="Enviar" />
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <a href="tickets_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
                    <br/><br/><br/>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>

<?php

function TicketsNuevo() {
    global $estados;
    global $cRutaVerTicketsAdjunto;
    $IdCiudad = $_SESSION["IdCiudad"];

    $nConexion = Conectar();
	
    $nConexion = Conectar();
	$ca = new DbQuery($nConexion);
	$ca->prepareSelect("tbltk_sedes_usuarios a join tblusuarios_externos b on (a.idusuario=b.idusuario)", "b.*,concat(b.nombre,' ',b.apellido) as nombre_usuario");
	$ca->exec();
	$rUsuarios = $ca->fetchAll();

    ?>
    <!-- Formulario Edici�n / Eliminaci�n de Empresas -->
    <form method="post" action="tickets.php?Accion=Responder" enctype="multipart/form-data" >
        <script type="text/javascript" src="../../../php/jquery-fancyTransition/js/jquery-1.6.1.min.js"></script>
        <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId; ?>"/>
        <br/>

        <br/>
		<script type="text/javascript">
        $(document).ready(function()
        {
        $("#bombre").change(function()
        {
        var id=$(this).val();
        var dataString = 'id='+ id;
        
        $.ajax
        ({
        type: "POST",
        url: "ajax_ticket.php?ciudad=1",
        data: dataString,
        cache: false,
        success: function(html)
        {
        $("#correo").html(html);
        } 
        });
        
        });
        });
        </script>

        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablaTicketForm">
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td colspan="2" style="text-align: center;">
                    <br/>
                    <h3>Estado: <select name="estado">
                            <?php foreach ($estados as $k => $v): ?>
                                <option value="<?php echo $k; ?>" <?php echo $k == "contestado" ? "selected" : ""; ?>><?php echo $v; ?></option>
                            <?php endforeach; ?>
                        </select></h3>
                    <br/>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td colspan="2">
                    <h3>Responder</h3>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td class="encTicket">Nombre:</td>
                <td class="contenidoEncTicket">
                    <select name="nombre" type="text" id="bombre" style="width:280px;"/>
						<?php foreach ($rUsuarios as $r): ?>
                            <option value="<?php echo $r["idusuario"]; ?>"><?php echo $r["nombre_usuario"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td class="encTicket">Direcci&oacute;n de Email:</td>
                <td class="contenidoEncTicket">
                    <select name="correo" type="text" id="correo" style="width:280px;"/>
                    	<option>correo</option>
                    </select>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td class="encTicket">Detalles del Ticket:</td>
                <td class="contenidoEncTicket">
                    <textarea name="mensaje" cols="45" rows="5" placeholder="Ac&aacute; ir�n los datos que son necesarios o especificos para cada sede..." id="detalle"></textarea>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td class="encTicket">Adjunto:
                    <a href="#nolink" onClick="nuevoAdjunto();">
                        <img src="../../../fotos/Image/contenidos/add.gif" width="16" height="16" />
                    </a>
                    <script type="text/javascript">
                        function nuevoAdjunto(){
                            $('.files-adjuntos').append('<input type="file" name="adjunto[]" /><br/>');
                        }
                    </script></td>
                <td class="contenidoEncTicket">
                    <div class="files-adjuntos">
                        <input type="file" name="adjunto[]" /><br/>
                    </div>
                    <br/><br/>
                    <p>(Extensiones de archivo permitidas: .jpg,.gif,.jpeg,.png,.pdf,.bmp,.doc,.docx,.ppt,.pptx,.txt,.rtf,.xls,.xlsx)</p>
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 10%;">&nbsp;</td>
                <td class="contenidoEncTicket">&nbsp;</td>
                <td class="contenidoEncTicket">
                    <input type="submit" name="bEnviar" id="button2" value="Enviar" />
                </td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td colspan="2" class="tituloFormulario">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="nuevo">
                    <a href="tickets_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/></a>
                    <br/><br/><br/>
                </td>
            </tr>
        </table>
    </form>
    <?php
}
?>

<?php

function TicketsExportar($idempresa, $idregion, $idzona, $idsede, $tipo, $filtro) {
    ob_clean();
    ob_start();
    $where = "1=1 ";
    if ($filtro != "") {
        $where .= "and (upper(CONCAT(e.nombre,' ',e.apellido)) like upper('%:filtro%') or upper(a.asunto) like upper('%:filtro%') 
        or upper(a.mensaje) like upper('%:filtro%')) ";
    }
    
    if ($idempresa != "todas") {
        $where .= "and d.idempresa=:idempresa ";
    }
    if ($idsede != "todas") {
        $where .= "and b.idsede=:idsede ";
    }
    if ($idzona != "todas") {
        $where .= "and f.idzona=:idzona ";
    }
    if ($idregion != "todas") {
        $where .= "and g.idregion=:idregion ";
    }
    if ($tipo != "todos") {
        $where .= "and c.tipo=:tipo ";
    }


    $campos = "a.idticket,a.fechahora,concat(e.nombre,' ',e.apellido) as nombre,c.tipo as perfil,
    b.nombre as sede,f.nombre as zona,g.nombre as region,d.nombre as empresa,a.asunto,
    SUBSTR(a.mensaje,1,25) as mensaje,a.prioridad,a.estado";

    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);

    $ca->prepareSelect("tbltk_tickets a 
    join tbltk_sedes b on (a.idsede=b.idsede)
    join tbltk_sedes_usuarios c on (a.idusuario=c.idusuario)
    join tbltk_zonas f on (b.idzona=f.idzona)
    join tbltk_regiones g on (f.idregion=g.idregion)
    join tbltk_empresas d on (g.idempresa=d.idempresa)
    join tblusuarios_externos e on (a.idusuario=e.idusuario)", $campos, $where);
    $ca->bindValue(":idempresa", $idempresa, false);
    $ca->bindValue(":idsede", $idsede, false);
    $ca->bindValue(":idzona", $idzona, false);
    $ca->bindValue(":idregion", $idregion, false);
    $ca->bindValue(":filtro", $filtro, false);
    $ca->bindValue(":tipo", $tipo, true);
    
    $ca->exec();
    
    
    $rTickets = $ca->fetchAll();

    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=tickets.xls");
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
        <head>
            <title>Documento sin t&iacute;tulo</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        </head>
        <body>
            <table cellpadding="0" cellspacing="0" border="1">
                <tr>
                    <td bgcolor="#FEF1E2">Id. Ticket</td>
                    <td bgcolor="#FEF1E2">Fecha Hora</td>
                    <td bgcolor="#FEF1E2">Nombre</td>
                    <td bgcolor="#FEF1E2">Perfil</td>
                    <td bgcolor="#FEF1E2">Sede</td>
                    <td bgcolor="#FEF1E2">Zona</td>
                    <td bgcolor="#FEF1E2">Region</td>
                    <td bgcolor="#FEF1E2">Empresa</td>
                    <td bgcolor="#FEF1E2">Prioridad</td>
                    <td bgcolor="#FEF1E2">Estado</td>
                </tr>
                <?php foreach ($rTickets as $r): ?>
                    <tr>
                        <td bgcolor="#F0F0F0"><?php echo $r["idticket"]; ?></td>
                        <td bgcolor="#F0F0F0"><?php echo $r["fechahora"]; ?></td>
                        <td bgcolor="#F0F0F0"><?php echo $r["nombre"]; ?></td>
                        <td bgcolor="#F0F0F0"><?php echo $r["perfil"]; ?></td>
                        <td bgcolor="#F0F0F0"><?php echo $r["sede"]; ?></td>
                        <td bgcolor="#F0F0F0"><?php echo $r["zona"]; ?></td>
                        <td bgcolor="#F0F0F0"><?php echo $r["region"]; ?></td>
                        <td bgcolor="#F0F0F0"><?php echo $r["empresa"]; ?></td>
                        <td bgcolor="#F0F0F0"><?php echo $r["prioridad"]; ?></td>
                        <td bgcolor="#F0F0F0"><?php echo $r["estado"]; ?></td>
                    </tr>
                    <tr>
                        <td bgcolor="#F0F0F0" rowspan="3">&nbsp;</td>
                        <td bgcolor="#F0F0F0" rowspan="3">Remite</td>
                        <td colspan="6" <?php echo $r["idusuario"] == -1 ? "bgcolor='#BABFFB'" : "bgcolor='#E0F0F0'"; ?>><?php echo $r["nombre"]; ?></td>
                    </tr>
                    <tr>
                        <td colspan="6" <?php echo $r["idusuario"] == -1 ? "bgcolor='#BABFFB'" : "bgcolor='#E0F0F0'"; ?>><?php echo $r["idusuario"] == -1 ? "Soporte" : "Cliente"; ?></td>
                    </tr>
                    <tr>
                        <td <?php echo $r["idusuario"] == -1 ? "bgcolor='#BABFFB'" : "bgcolor='#E0F0F0'"; ?>><?php echo $r["fechahora"]; ?></td>
                        <td colspan="5" <?php echo $r["idusuario"] == -1 ? "bgcolor='#BABFFB'" : "bgcolor='#E0F0F0'"; ?>>&nbsp;</td>
                    </tr>
                    <tr>
                        <td bgcolor="#F0F0F0">&nbsp;</td>
                        <td bgcolor="#F0F0F0">Mensaje</td>
                        <td colspan="6" <?php echo $r["idusuario"] == -1 ? "bgcolor='#FFFFFF'" : "bgcolor='#FFFFFF'"; ?>><?php echo $r["mensaje_completo"]; ?></td>
                    </tr>
                    <?php
                    $sql = "select 
             � � � � � �a.*,
             � � � � � �case when a.idusuario=-1 then 'Asesor'
             � � � � � �else concat(b.nombre,' ',b.apellido) end as nombre
             � � � � � �from tbltk_tickets_mensajes a 
             � � � � � �left join tblusuarios_externos b on (a.idusuario=b.idusuario)
             � � � � � �where a.idticket = :idticket order by a.idmensaje asc";

                    $ca->prepare($sql);
                    $ca->bindValue(":idticket", $r["idticket"], false);
                    $ca->exec();
                    $rMensajes = $ca->fetchAll();
                    ?>
                    <?php foreach ($rMensajes as $m): ?>
                        <tr>
                            <td bgcolor="#F0F0F0" rowspan="3">&nbsp;</td>
                            <td bgcolor="#F0F0F0" rowspan="3">Remite</td>
                            <td colspan="6" <?php echo $m["idusuario"] == -1 ? "bgcolor='#D8D8D8'" : "bgcolor='#C8C8C8'"; ?>><?php echo $m["nombre"]; ?></td>
                        </tr>
                        <tr>
                            <td colspan="6" <?php echo $m["idusuario"] == -1 ? "bgcolor='#D8D8D8'" : "bgcolor='#C8C8C8'"; ?>><?php echo $m["idusuario"] == -1 ? "Soporte" : "Cliente"; ?></td>
                        </tr>
                        <tr>
                            <td <?php echo $m["idusuario"] == -1 ? "bgcolor='#D8D8D8'" : "bgcolor='#C8C8C8'"; ?>><?php echo $m["fechahora"]; ?></td>
                            <td colspan="5" <?php echo $m["idusuario"] == -1 ? "bgcolor='#D8D8D8'" : "bgcolor='#C8C8C8'"; ?>>&nbsp;</td>
                        </tr>
                        <tr>
                            <td bgcolor="#F0F0F0">&nbsp;</td>
                            <td bgcolor="#F0F0F0">Mensaje</td>
                            <td colspan="6"><?php echo $m["mensaje"]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="8">&nbsp;</td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </body>
    </html>
    <?php
    ob_flush();
    mysqli_close($nConexion);
}
?>
<?php

function TicketsCerrarTicket($idticket) {
    $nConexion = Conectar();
    $ca = new DbQuery($nConexion);

    $ca->prepareUpdate("tbltk_tickets", "estado", "idticket=:idticket");
    $ca->bindValue(":idticket", $idticket, false);
    $ca->bindValue(":estado", "cerrado", true);
    if (!$ca->exec()) {
        Mensaje("Error registrando ticket {$nId} como cerrado", "tickets_listar.php");
        exit;
    }

    $ca->prepareSelect("tbltk_tickets a join tblusuarios_externos b on (a.idusuario=b.idusuario)", "a.*,concat(b.nombre,' ',b.apellido) as nombre_remitente,b.correo_electronico", "a.idticket=:idticket");
    $ca->bindValue(":idticket", $idticket, false);
    $ca->exec();

    if ($ca->size() == 0) {
        mysqli_close($nConexion);
        Mensaje("Error, ticket no encontrado.", "tickets_listar.php");
        return;
    }

    $rTicket = $ca->fetch();


    $m = new MAIL();
    $host = str_replace("www.", "", $_SERVER["HTTP_HOST"]);

    $to = $rTicket["correo_electronico"];
    $toName = utf8_decode($rTicket["nombre_remitente"]);

    $subject = utf8_decode("Ticket CERRADO ticket:{$rTicket["idticket"]} , {$rTicket["asunto"]}");
    $message = utf8_decode("Soporte a cerrado el ticket {$rTicket["idticket"]}");

    $from = !empty($from) ? $from : "solicitudes@{$host}";
    $fromName = !empty($fromName) ? $fromName : "Soporte";

    $m->addHeader("charset", "utf-8");
    $m->from($from, $fromName);
    $m->addto($to, $toName);
    $m->subject($subject);

    $m->html($message);

    $cHost = $host;
    $cPort = 25;
    $cUser = "solicitudes@{$host}";
    $cPass = "/060371*";

    $c = $m->Connect($cHost, $cPort, $cUser, $cPass);
    $status = $m->send($c);

    if (!$status) {
        die("Error enviando mensaje");
    }

    mysqli_close($nConexion);
}
?>