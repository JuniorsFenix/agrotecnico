<?php session_start();
 
require_once("../../herramientas/XPM4-v.0.4/MAIL.php");
require_once('../../herramientas/html2pdf/html2pdf.class.php');
require_once("../../vargenerales.php");
$html2pdf = new HTML2PDF('P', 'Letter', 'es', true, 'UTF-8', array(0, 0, 0, 0));
$html2pdf->pdf->SetProtection(array('print'), '', 'estilo');
$html2pdf->writeHTML($_SESSION['template']);

 $adjunto = $html2pdf->Output($cRutaDocumentos . $_SESSION["nombre"].'.pdf', 'F');
  
    $host = str_replace("www.", "", $_SERVER["HTTP_HOST"]);

    $to = $_SESSION["UsrCorreo"];
    $toName = $_SESSION["UsrNombre"];
	
    $to2 = $_SESSION["nombre"];
    $toName2 = $_SESSION["correo"];
	
    $mensaje = $_SESSION["mensaje"];
    $asunto = $_SESSION["asunto"];

    $from = $_SESSION["UsrCorreo"];
    $fromName = $_SESSION["UsrNombre"];
/*
     $m = new MAIL();
    $m->addHeader("charset", "utf-8");
    $m->from($from, $fromName);
    $m->addto($to, $toName);
    $m->addto($to2, $toName2);
    $m->subject($subject);
    $m->attach($adjunto);

    $m->html($message);

    $cHost = $host;
    $cPort = 25;
    $cUser = "solicitudes@{$host}";
    $cPass = "soditi13*";

    $c = $m->Connect($cHost, $cPort, $cUser, $cPass);
    $status = $m->send($c);
   
	$html2pdf->Output($cRutaDocumentos . $_SESSION["nombre"].'.pdf');
	*/
	
	 /*$content_PDF = $html2pdf->Output('', true);  
   require_once('pjmail/pjmail.class.php'); 
   $mail = new PJmail(); 
   $mail->setAllFrom($from, $fromName); 
   $mail->addrecipient($to);
   $mail->addrecipient($to2); 
   $mail->addsubject($asunto); 
   $mail->text = $mensaje; 
   $mail->addbinattachement("prueba.pdf", $adjunto); 
   $res = $mail->sendmail(); */
  

/*define('_MPDF_PATH','MPDF56/');
include("MPDF56/mpdf.php");

$mpdf=new mPDF('c', 'Letter', 0, '', 0, 0, 0, 0, 0, 0, 'L'); 

$mpdf->default_lineheight_correction = 1.2;

// LOAD a stylesheet

$mpdf->showImageErrors = true; 

$mpdf->WriteHTML($_SESSION['template']);

$mpdf->Output();
exit;*/

?>