<?
include("funciones_generales.php");
	$sitioCfg = sitioAssoc2();
	$home = $sitioCfg["url"];
session_start();
session_destroy();
//Mensaje ("Su sesi�n a sido cerrada correctamente.","admin.php");
?>
<script language="javascript">parent.location.href="<?php echo $home; ?>/sadminc/login";</script>
