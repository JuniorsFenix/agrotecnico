<?php
	require_once("include/funciones.php");
	require_once '../../herramientas/PHPMailer/PHPMailerAutoload.php';
	$user = "soporte@estilod.com";
	$pass = "EYD/tk/mhyy*964*";
	$nombre = "Soporte";
	$host = "smtp.gmail.com";
	$port = 587;
	
	global $db;
	date_default_timezone_set('America/Bogota');
	$now = date("Y-m-d H:i:s");

	$stmt = $db->prepare("SELECT * FROM config_tareas");
	$stmt->execute();
	$config = $stmt->fetch(PDO::FETCH_ASSOC);

	$query= "SELECT t.*, u.nombres, u.correo_electronico, e.nombre from tareas t join tblusuarios u on t.idusuario=u.idusuario join tbltk_empresas e on t.idempresa=e.idempresa WHERE estado='En Proceso'";
	$stmt = $db->query($query);
	foreach($stmt as $row) {
		$date = strtotime("{$row['entrega']} -{$row['recordatorio']} hour");
		$recordatorio = date('Y-m-d H:i:s', $date);
		if($now==$recordatorio){
			$mensaje = "{$config["asunto"]}<br><br>";
			$mensaje .= "Tarea: {$row['tarea']}<br>
			Prioridad: {$row['prioridad']}<br>
			Cliente: {$row['nombre']}<br>
			Responsable: {$row['nombres']}<br>
			Fecha de inicio: {$row['inicio']}<br>
			Fecha de entrega: {$row['entrega']}";

			$mail = new PHPMailer();

			$mail->isSMTP();       // Set mailer to use SMTP
			$mail->Host = $host;  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = $user;                 // SMTP username
			$mail->Password = $pass;                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = $port; 

			$mail->CharSet = "UTF-8";
			$mail->setFrom($user, $nombre);
			$mail->AddAddress($row["correo_electronico"]);
			$mail->AddBCC( "claudio@estilod.com" );
			$mail->Subject   = $config["asunto"];
			$mail->Body      = $mensaje;
			$mail->IsHTML(true);
			$mail->Send();
		}
	}
?>