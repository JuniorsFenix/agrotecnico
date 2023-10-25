<?php
	include("include/funciones.php");
	$sitioCfg = sitioFetch();
	session_start();
	session_destroy();
?>
<script language="javascript">parent.location.href="/<?php echo $sitioCfg["carpeta"]; ?>";</script>
