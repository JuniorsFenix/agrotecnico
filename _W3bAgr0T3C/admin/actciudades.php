<?
session_start();
require_once("funciones_generales.php");
$sitioCfg = sitioAssoc2();
$home = $sitioCfg["url"];
$IdCiudad = $_POST["cboCiudad"];
echo $_POST["cboCiudad"];
$_SESSION["IdCiudad"] = $IdCiudad;
?>
<script language="javascript">parent.location.href='<?php echo $home; ?>/sadminc/home.php'</script>";