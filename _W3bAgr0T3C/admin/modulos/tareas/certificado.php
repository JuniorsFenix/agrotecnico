<?php 
	include_once("templates/includes.php");
	include_once("include/convertidor.php");
	$perfil = datosPerfil($_SESSION["perfil"]);

	date_default_timezone_set("America/Bogota" ) ;
function fecha($fecha=""){
	
	if($fecha!=""){
		$fecha = explode("-",$fecha);
		$tiempo['year'] = $fecha[0];
		$tiempo['mon'] = $fecha[1];
		$tiempo['mday'] = $fecha[2];
	}
	else{
		$tiempo = getdate(time());
	}
	$dia_mes=$tiempo['mday'];
	$mes = $tiempo['mon'];
	$year = $tiempo['year'];

	switch($mes){
	case "1": $mes_nombre="Enero"; break;
	case "2": $mes_nombre="Febrero"; break;
	case "3": $mes_nombre="Marzo"; break;
	case "4": $mes_nombre="Abril"; break;
	case "5": $mes_nombre="Mayo"; break;
	case "6": $mes_nombre="Junio"; break;
	case "7": $mes_nombre="Julio"; break;
	case "8": $mes_nombre="Agosto"; break;
	case "9": $mes_nombre="Septiembre"; break;
	case "10": $mes_nombre="Octubre"; break;
	case "11": $mes_nombre="Noviembre"; break;
	case "12": $mes_nombre="Diciembre"; break;
	}
	
	if($fecha!=""){
		$fecha = "$dia_mes de $mes_nombre de $year";
	}
	else{
		$fecha = "$dia_mes d&iacute;as del mes de $mes_nombre de $year";
	}
	return $fecha;
}

	$usuario2 = datosUsuario(1);
	if(isset($_POST["asunto"])){
		require_once("include/html2pdf/html2pdf.class.php");
		$html2pdf = new HTML2PDF('P', 'Letter', 'es', true, 'UTF-8', array(30, 60, 30, 20));
		//$html2pdf->pdf->SetProtection(array('print'), '', 'estilo');
		/*$html2pdf->addFont('ArenaCondensed','','arenacondensed.php');*/
    	$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($_SESSION['certificado']);

		$usuario = datosUsuario($_POST["idusuario"]);

		$to = $_SESSION["correo"];
		$toName = "{$usuario2['nombre']} {$usuario2['apellido']}";

		$to2 = $_POST["correo"];
		$toName2 = "";

		$mensaje = $_POST["mensaje"];
		$asunto = $_POST["asunto"];

		$from = $usuario2['correo'];
		$fromName = "{$usuario2['nombre']} {$usuario2['apellido']}";
	
	
		global $db;
		
		$stmt = $db->prepare("INSERT INTO certificados(fechahora,idusuario,correo,asunto,mensaje) VALUES(:fechahora,:idusuario,:correo,:asunto,:mensaje)");
		$stmt->bindValue(':fechahora', date('Y-m-d H:i:s'), PDO::PARAM_STR);
		$stmt->bindValue(':idusuario', $_POST["idusuario"], PDO::PARAM_INT);
		$stmt->bindValue(':correo', $to2, PDO::PARAM_STR);
		$stmt->bindValue(':asunto', $asunto, PDO::PARAM_STR);
		$stmt->bindValue(':mensaje', $mensaje, PDO::PARAM_INT);
		$stmt->execute();

		$insertId = $db->lastInsertId();
		
		$fecha = date('Y-m-d');

		$certificado = "{$insertId}_{$usuario["cedula"]}_{$fecha}.pdf";

		$html2pdf->Output("./fotos/certificados/$certificado", 'F');
		
		$stmt = $db->prepare("UPDATE certificados SET certificado=:certificado WHERE idcertificado=:id");
		$stmt->bindValue(':certificado', $certificado, PDO::PARAM_STR);
		$stmt->bindValue(':id', $insertId, PDO::PARAM_INT);
		$stmt->execute();


		$adjunto = file_get_contents("./fotos/certificados/$certificado");
		require_once('include/pjmail/pjmail.class.php'); 
		$mail = new PJmail(); 
		$mail->setAllFrom($from, $fromName); 
		$mail->addrecipient($to);
		$mail->addrecipient($to2); 
		$mail->addsubject($asunto); 
		$mail->text = $mensaje; 
		$mail->addbinattachement($certificado, $adjunto); 
		$res = $mail->sendmail();
		
		header("Location: /{$sitioCfg["carpeta"]}/editar-usuario/{$_POST["idusuario"]}");
		exit();
	}

	$user = $_SESSION["id"];

	if(isset($_GET["usuario"])){
	$user = $_GET["usuario"];
	}
	$usuario = datosUsuario($user);

	if($usuario["sexo"]=="Hombre"){
		$pronombre = "el se&ntilde;or";
		$pronombre2 = "identificado";
	} elseif($usuario["sexo"]=="Mujer"){
		$pronombre = "la se&ntilde;ora";
		$pronombre2 = "identificada";
	} 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title>Generar certificado laboral - <?php echo $sitioCfg["titulo"]; ?></title>
    <link href="/<?php echo $sitioCfg["carpeta"]; ?>/estilos/estilo.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<style type="text/css">
		.certificado
		{ 
			background:url(http://www.miendomarketing.com/<?php echo $sitioCfg["carpeta"]; ?>/fotos/certificado.jpg) no-repeat;
			width: 816px;
			height: 1056px;
			font: normal 12pt Arial, "sans-serif";
			float: right;
			padding: 220px 120px 100px 120px;
		}
	</style>
</head>

<body>
    <?php get_header() ?>
    <?php menu() ?>
    <div id="container-inside">
        <h1>Certificado laboral</h1>

    	<?php ob_start(); ?>
		<style type="text/css">
			.certificado
			{ 
				text-align: justify;
			}
		</style>
		<page backimg="http://www.miendomarketing.com/<?php echo $sitioCfg["carpeta"]; ?>/fotos/certificado.jpg" style="font-size: 12pt">
			<div class="certificado">
				<div style="text-align: center;">
					<strong><?php echo $sitioCfg["nombre"]; ?></strong><br />
					<strong> </strong><br />
					&nbsp;<br />
					&nbsp;<br />
					<strong>CERTIFICA</strong>
				</div>
				&nbsp;<br />
				&nbsp;<br />
				&nbsp;<br />
				Que <?php echo $pronombre; ?> <strong><?php echo "{$usuario['nombre']} {$usuario['apellido']}"; ?> </strong><?php echo $pronombre2; ?> con <strong>C.C No. <?php echo $usuario['cedula']; ?> </strong>de <strong><?php echo $usuario['lugar_expedicion']; ?> </strong>, se encuentra laborando en nuestra compa&ntilde;&iacute;a como <strong><?php echo $usuario['cargo']; ?> </strong>desde el <strong><?php echo fecha($usuario['desde']); ?></strong> con <?php echo $usuario['contrato']; ?>, y un salario de <?php echo numtoletras($usuario['salario']); ?> pesos mcte ($<?php echo $usuario['salario']; ?>).<br />
				&nbsp;<br />
				La presente certificaci&oacute;n se expide a solicitud del interesado a los <?php echo fecha(); ?>.<br />
				&nbsp;<br />
				Cordialmente,<br />
				&nbsp;<br />
				&nbsp;<br />
				<img src="<?php echo "http://www.miendomarketing.com/{$sitioCfg["carpeta"]}/fotos/perfiles/{$usuario2['firma']}"; ?>" width="174" height="77">
				<br>
				__________________________<br><br>
				<strong><?php echo $usuario2['nombre']." ".$usuario2['apellido']; ?><br>
				<?php echo $usuario2['cargo']; ?><br>
				<?php echo $sitioCfg['nombre']; ?><br>
				 <br>
				 
				</strong>
			</div>
		</page>
		<?php $_SESSION['certificado'] = ob_get_contents(); ?>

        <form method="post" enctype="multipart/form-data" id="form">
            <input type="hidden" name="idusuario" value="<?php echo $user ?>">  
            <label>Asunto:</label>
            <input type="text" name="asunto" maxlength="255" required value="" />          
            <label>Mensaje</label>
            <textarea name="mensaje" rows="4" cols="20"></textarea>
            <label>Correo:</label>
            <input type="email" name="correo" maxlength="255" required value="<?php echo $usuario['correo']; ?>" /><br><br>
            <a href="/usuarios" class="cancelar" />Cancelar</a>
            <input type="submit" class="action-button" value="Enviar" title="Enviar" />
        </form>
    </div>
    <?php get_footer() ?>
</body>
</html>