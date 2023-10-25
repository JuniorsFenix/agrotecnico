<?php
require_once ("../../herramientas/qr-code/qrcode.php");

$text = base64_decode( $_GET["text"] );
QRCode::show($text);
?>