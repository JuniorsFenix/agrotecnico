<?php 
##########################################
## Script formulario de correo mail.php ##
##########################################
$code = $_POST["txtId"];
$nombres = $_POST["nombres"];
$user = $_POST["nick"];
$emaile = $_POST["maile"];

echo "codigo:  ". $code. "<br>";
echo "nombres: ". $nombres. "<br>";
echo "usuario: ". $user. "<br>";
echo "correo:  ". $emaile. "<br>";

## VARIABLES
## Direcci&oacute;n de tu correo
$micorreo="ovidio@clickee.com"; //para colocar info@execulimo
## Asunto axiliar si no lo introduce un asunto que identifique la procedencia del correo.
$xasunto="Registro en línea desde nuestra Web";
## Pagina final de gracias. Si el formulario no incluye este campo oculto del formulario. 
//$gracias_defecto="http://www.ovidiocardona.com"; 
## Página final si se produce un error al enviar el correo
//$error_correo="http://www.buscarportal.com/anuncios/error_correo.html"; 
## variable auxiliar, que produce un salto de l&iacute;nea
$retorno="\r\n";
								
## CABECERAS DE CORREO
## Diversas cabeceras para el correo. Luego, lo usaremos para enviar el correo.
## $nombre $correo son variables que contienen los valores de: nombre y correo del formulario.
$headers = "MIME-Version: 1.0\r\n" ;
## campos y variables nombre, $nombre y correo $correo. No pueden ser modificados
## Han de mantenerse en el formulario para utilizar el mismo script con distintos formularios 
$headers .= "From: $nombres<$emaile>\r\n";
## Responder al correo
//$headers .= "Reply-To: ovidio@clickee.com<ovidio@clickee.com>\r\n";
## Otras cabeceras que pueden ponerse si ocurren problemas u omitirse si todo va bien.
## Obligatoriamente, cada elemento de la cabecera termina en \r\n Nueva l&iacute;nea.
## $headers .= "X-Mailer: PHP/" . phpversion();
## $headers .= "X-Sender: $correo<$correo>\r\n";
## $headers .= "Return-Path: <$correo>\r\n";
//$headers .= "Cc: $nombres<$emaile>\r\n"; 
								
## CUERPO DEL MENSAJE INICIO
## Obtención de la IP del visitante
## Empezamos a contruir el mensaje final, sumando los elementos del mensaje
$mfinal.="IP visitante: ";
## Guardamos la IP del visitante
$mfinal.=$HTTP_SERVER_VARS['REMOTE_ADDR'];
$mfinal.=": ";
## Y el puerto del usuario
$mfinal.=$HTTP_SERVER_VARS['REMOTE_PORT'];
## añadimos dos retornos de línea
$mfinal.=$retorno;
$mfinal.=$retorno; 
								
## CUERPO DEL MENSAJE AÑADIDO DE CAMPOS AL MENSAJE
## $vareliminar Número de botones del formulario y campos ocultos (últimos elementos) + 1 --> en este caso (1+1)
## Si queremos eliminar del mensaje el campo oculto de la página final $vareliminar=3;
//$vareliminar=0;
## Almacenar en un array los nombres de variables del formulario enviado
//$claves_array=array_keys ($HTTP_GET_VARS);
## de i=0 hasta el n&uacute;mero de campos del formulario, - variables a eliminar
//for ($i=0;$i<=(count($HTTP_GET_VARS)-$vareliminar);$i++){
## Obtenemos el nombre de cada campo en concreto
//$nombrevar=$claves_array[$i];
## Sumamos el nombre de campo de formulario al mensaje final
//$mfinal .= $nombrevar;
//$mfinal .= ": ";
## Y a&ntilde;adimos el contenido que haya introducido nuestro visitante
//$mfinal .= $HTTP_GET_VARS[$nombrevar]; 
## Separamos cada campo por dos retornos, podemos eliminar uno
$mfinal .= $retorno;
$mfinal .= $retorno;
//}
$mfinal .= "Mi nombre es: " .$nombres;
$mfinal .= $retorno;
$mfinal .= "Mi usuario es: " .$user;
$mfinal .= $retorno;

$mfinal .= "Mi codigo es: " .$code;
$mfinal .= $retorno;
$mfinal .= "Click en el siguiente link para responder y activar este registro: "; 
$mfinal .= $retorno;
$mfinal .= "http://www.XXXXXXXX/activartur.php";
$mfinal .= $retorno;
## Si no hay asunto, o no contiene nada, le damos al email un asunto defecto
if (is_null($asunto)){ $asunto2="Registro en línea desde nuestra Web";}
## Si hay asunto, añadimos un prefijo propio para identificar que es correo desde la web.
else { $asunto2 ="Asunto-> $asunto"; }
								
## ENVÏO DEL CORREO
## Para finalizar, envíamos el correo, y comprobamos el resultado
$resultado=mail($micorreo, $asunto2, $mfinal, $headers);
## Si quisiéremos enviar un mensaje de acuso de recibo, añadimos esta línea, sabiendo que:
## tenemos que asignar estas variables $asuntoreply (Asunto), $mreply (mensaje), $headers2(mensaje)
## de modo similar a como hemos construido las variables anteriores
## $resultado2=mail($correo, $asuntoreply, $mreply, $headers2);
								
## COMPROBACIÓN
## Si no se ha podido enviar el correo.
	if ($resultado ==true) 
	{
## Si no hay p&aacute;gina de gracias carga las p&aacute;gina de defecto
	echo "Información enviada satisfactoriamente" ;
	
	}
## Si se ha producido un error, advierte al usuario
	else echo "Error al enviar el correo" ;
?>
<a href="javascript:history.go(-1)">----Regresar----</a>