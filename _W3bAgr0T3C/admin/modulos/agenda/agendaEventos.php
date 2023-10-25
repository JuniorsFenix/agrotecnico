<?php
include("../../herramientas/seguridad/seguridad.php");
include("../../herramientas/paginar/class.paginaZ.php");
include("../../funciones_generales.php");
include("../../vargenerales.php");

$nConexion    = Conectar();

$ano = isset($_GET["ano"]) ? $_GET["ano"]:date("Y");
$mes = isset($_GET["mes"]) ? $_GET["mes"]:date("m");
while( strlen($mes) < 2 ) $mes = "0".$mes;

$meses = array(
    1=>"Enero",
    2=>"Febrero",
    3=>"Marzo",
    4=>"Abril",
    5=>"Mayo",
    6=>"Junio",
    7=>"Julio",
    8=>"Agosto",
    9=>"Septiembre",
    10=>"Octubre",
    11=>"Noviembre",
    12=>"Diciembre"
);
$dias = array(
    0=>"Domingo",
    1=>"Lunes",
    2=>"Martes",
    3=>"Miercoles",
    4=>"Jueves",
    5=>"Viernes",
    6=>"Sabado"
);

$enc=array(
    "carro"=>-1
);

$resData=array();


$salones = array(
    array("idproducto"=>1,"nombre"=>"Salon 1"),
    array("idproducto"=>2,"nombre"=>"Salon 2"),
);
$reservaciones = array();
foreach($salones as $r){
    $reservaciones[ $r["idproducto"] ] = agendaReservacionesFecha($ano,$mes,$r["idproducto"]);
}



/*foreach($arrayDetalle as $r){
    if( $r["item"]=="111" || $r["item"]=="112" ){
       $salones[] = tiendaProductoAssoc($r["item"]);
       $reservaciones[ $r["item"] ] = agendaReservacionesFecha($ano,$mes,$r["item"]);

    }
}*/

function agendaConsultarHorarios() {
        $nConexion = Conectar();
        $sql = "SELECT * FROM tblreservacioneshorarios ORDER BY idhorario";
        $ra = mysqli_query($nConexion,$sql);
        if ( !$ra ) {
                die("Error consultando horarios");
        }

        $r = array();
        while($rax=mysqli_fetch_assoc($ra)){
                $r[] = $rax;
        }
        return $r;
}


function agendaConsultarReservacion($idsalon,$fecha,$idhorario) {
    global $resData;

    foreach($resData as $r){
        if( $r["idsalon"] == $idsalon && $r["fecha"]==$fecha && $r["idhorario"] == $idhorario){
            return $r;
        }
    }

    return false;
}


function agendaVerificarReservacion($idsalon,$fecha,$idhorario) {
    global $reservaciones;
    if( isset( $reservaciones[$idsalon][$fecha])
            && in_array($idhorario, $reservaciones[ $idsalon ][$fecha]) ) {
        return true;
    }


    if( $idhorario == 2 ) {
        if( isset( $reservaciones[$idsalon][$fecha])
                && in_array(3, $reservaciones[ $idsalon ][$fecha]) ) {
            return true;
        }
    }

    if( $idhorario == 3 ) {
        if( isset( $reservaciones[$idsalon][$fecha])
                && in_array(2, $reservaciones[ $idsalon ][$fecha]) ) {
            return true;
        }

    }

    return false;
}

function agendaReservacionesFecha($ano,$mes,$idsalon) {
    global $resData;
    
    $nConexion = Conectar();
    $sql = "SELECT a.* FROM tblreservaciones a,
    tblreservacioneshorarios b
    WHERE a.idhorario=b.idhorario
    AND substr(a.fecha,1,7)='{$ano}-{$mes}' AND a.idsalon={$idsalon}
    ORDER BY a.idhorario";
    
    $ra = mysqli_query($nConexion,$sql);
    if ( !$ra ) {
        
        die("Error consultando reservaciones ".mysqli_error($nConexion)."\n{$sql}");
    }
    $r = array();
    while($rax=mysqli_fetch_assoc($ra)) {
        $resData[] = $rax;
        
        if( !isset($r[ $rax["fecha"] ]) ) {
            $r[ $rax["fecha"] ]=array();
        }
        $r[ $rax["fecha"] ][] = $rax["idhorario"];
    }
    return $r;
}

function agendaRegistrarReservaciones($d) {
    global $enc;
    
    $nConexion = Conectar();
    foreach($d["horario"] as $k=>$h) {
        list($idsalon,$fecha,$idhorario) = explode(":",$h);
        $nombre = $d["nombre"][$k];

        $sql="INSERT INTO tblreservaciones(carro,idsalon,idhorario,fecha,nombre) VALUES
        ({$enc["carro"]},{$idsalon},{$idhorario},'{$fecha}','{$nombre}')";
        echo "{$sql}\n";
        $ra = mysqli_query($nConexion,$sql);
        if(!$ra) {
            return "Fallo insertando horario";
        }
    }

    //return false;
    return true;
}

if ( isset($_POST["bEnviar"]) ) {
    $d = $_POST;
    $result = agendaRegistrarReservaciones($d);
    if ( $result !== true ) {
        die($result);
    }

    header("Location: agendaEventos.php");
    exit;
}


if( isset($_GET["accion"]) && $_GET["accion"]=="eliminar"){
    $sql="delete from tblreservaciones where idhorario in ( {$_GET["idhorario"]} ) and idsalon = {$_GET["idproducto"]} and fecha='{$_GET["fecha"]}'";
    mysqli_query($nConexion,$sql);
    header("Location: agendaEventos.php");
    exit;
   
}


$arrayAgendaHorario = agendaConsultarHorarios();	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Agenda Eventos</title>
    <meta name="google-site-verification" content="qpdjrX1rp1jZ9W5BJqWc2Qr96xrGL-k2XOwpYBxziXk" />
	<meta name="GENERATOR" content="Agencia de Publicidad Estilo y Diseño (claudio@estilod.com)">
	<META name='revisit-after' content='3 day'>
	<META name='robots' content='ALL'>
	<META name='distribution' content='Global'>
	<META name='charset' content='ISO-8859-1'>
	<META name='expires' content='never'>
	<META name='rating' content='general'>
</head>

<body>
    <?php include("../../system_menu.php"); ?><br>
    <form name="vform" method="post" action="<?=$_SERVER["PHP_SELF"];?>?ciudad=<?=$IdCiudad;?>" >
           <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="tablaTitulo3"><!-- Imprimir TituloProductos-->
                      <!-- Fin Imprimir TituloProductos--></td>
                  </tr>
                  <tr>
                    <td class="tablaContenido3"><p><span class="tituloProductoVer">agenda de eventos<br />
                      seleccione mes y a&Ntilde;o: 
                      <select name="mes" id="select2" onchange="location='<?=$_SERVER["PHP_SELF"];?>?ciudad=<?=$IdCiudad;?>&ano=<?=$ano?>&mes='+this.value;">
                      <?php foreach( $meses as $k=>$v ):?>
                      <?php if( $k < date("m") && $ano==date("Y") ) continue;?>
                        <option value="<?=$k;?>" <?=$mes==$k?"SELECTED":"";?>><?=$v;?></option>
                      <? endforeach;?>
                      </select>
					  &nbsp;                    </span><span class="tituloProductoVer">
					    <select name="ano" id="select3" onchange="location='<?=$_SERVER["PHP_SELF"];?>?ciudad=<?=$IdCiudad;?>&ano='+this.value+'&mes=<?=$mes?>';">
					    <?php for ( $i = date("Y"); $i <= date("Y")+1; $i++ ):?>
							<option value="<?=$i;?>" <?=$ano==$i?"SELECTED":"";?>><?=$i;?></option>
						<?php endfor;?>
					    </select>
					    <br />
					    <br />
					  </span> Libre <img src="../imagenes/agendaFiguraLibre.gif" alt="Libre" width="16" height="14" hspace="2" align="absmiddle" /> &nbsp;Reservado <img src="../imagenes/agendaFiguraReservado.gif" alt="Reservado" width="16" height="14" hspace="2" align="absmiddle" /> &nbsp;Mantenimiento <img src="../imagenes/agendaFiguraMantenimiento.gif" alt="Mantenimiento" width="16" height="14" hspace="2" align="absmiddle" /></p>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="tablaCarroGeneralAbajo">
						<input type="submit" name="bEnviar" id="button2" value="Guardar" />

                                                <a href="registros_excel.php">Generar Archivo Excel</a>
                                                <hr/>
                          </td>
                        </tr>
                      </table>
<script type="text/javascript">
function validarHorario(obj){
    var tmp = obj.id.split("_");
    if( tmp[1] == "2" || tmp[1]=="3" ){
        if( tmp[1]=="2"){
            document.getElementById(tmp[0]+"_3").disabled=obj.checked;
        }
        else {
                document.getElementById(tmp[0]+"_2").disabled=obj.checked;
        }
    }

    return true;
}
</script>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td class="tablaAgendaDia1">d&Iacute;a</td>
                        <?php foreach($salones as $s):?>
                        <td class="tablaAgendaSalon1"><?=$s["nombre"];?></td>
                        <?php endforeach;?>
                        <!--td class="tablaAgendaObservacion1">observaciones</td-->
                      </tr>
                        <?php for( $dia = 1; $dia <= 31; $dia++ ):?>
                        <?php while( strlen($dia) < 2 ) $dia = "0".$dia;?>
                        <?php if( !checkdate($mes,$dia,$ano) ) continue;?>
                        <?php $dow = date("w",mktime(0, 0, 0, $mes, $dia, $ano));?>
                        <tr>
                        <td valign="top"><?=$dias[$dow]." {$dia}";?></td>
                        <?php foreach($salones as $s):?>
                        <?php $fecha = "{$ano}-{$mes}-{$dia}";?>
                        <td valign="top" style="text-align:left;"><FONT COLOR="black">
                        <?php foreach($arrayAgendaHorario as $rax ):?>

                        <?php if( $rax["grupo"]!="2" && in_array($dow,array(6,0)) ) continue;?>
                        <?php if( $rax["grupo"]!="1" && in_array($dow,array(1,2,3,4,5)) ) continue;?>

                        <?php $res = agendaConsultarReservacion($s["idproducto"],$fecha,$rax["idhorario"]);?>
                        <?php if( agendaVerificarReservacion($s["idproducto"],$fecha,$rax["idhorario"]) ):?>
                        <?=$rax["descripcion"];?> (Reservado) <a href="?accion=eliminar&idproducto=<?=$s["idproducto"];?>&fecha=<?=$fecha;?>&idhorario=<?=$rax["idhorario"];?>">Eliminar</a><br/>
                        <?=$res["nombre"];?><br/>
                        <?php else:?>
                        <input type="checkbox" id="horario<?=$fecha;?>_<?=$rax["idhorario"]?>" onclick="return validarHorario(this);" name="horario[]" value="<?="{$s["idproducto"]}:{$fecha}:{$rax["idhorario"]}";?>" />
                        <?=$rax["descripcion"];?><br/>
                        <input type="text" name="nombre[]" size="40"/><br/>
                        <?php endif;?>
                        <br>
                        <?php endforeach;?>
                        </font>
                        </td>
                        <?php endforeach;?>

                        <!--td class="tablaAgendaObservacion2">
                        <textarea name="observaciones_<?=$fecha?>" cols="30" rows="4" id="textarea"></textarea>
                        </td-->
                        </tr>
                      <?php endfor;?>
                    </table>
                    <br />
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="tablaCarroGeneralAbajo">
                                <input type="submit" name="bEnviar" id="button2" value="Guardar" />
                            </td>
                        </tr>
                    </table>
                    <!-- Fin Galer&iacute;a--></td>
                  </tr>
                  <tr>
                    <td class="tablaAbajo3">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="tablaAbajo3a"><img src="../imagenes/figuraAbajoDetalles3.gif" width="144" height="44" /></td>
                            </tr>
                        </table>
                    </td>
                  </tr>
                </table>
</body>
</html>