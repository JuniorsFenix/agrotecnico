<?php

include("funcioneslogin.php");
	$sitioCfg = sitioAssoc();
	$home = $sitioCfg["url"];
include("vargenerales.php");

?>
<html>
    <head>
        <title>.:: Sitio de Administración Portal ClicKee ::.</title>
        <link href="<?php echo $home; ?>/sadminc/css/administrador.css" rel="stylesheet" type="text/css">
        <script language="javascript">
            function my_focus()
            {
                document.frm.txtClave1.focus();
            }
        </script>
    </head>
    <body onLoad="my_focus()">
        <table width="740"  border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td class="tablaPrincipal">
                    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="tablaCabezote">
                                <table border="0" cellpadding="0" cellspacing="0" width="740">
                                    <tr>
                                        <td><img src="<?php echo $home; ?>/sadminc/image/cabezotelogin1.jpg" width="250" height="241"><img src="<?php echo $home; ?>/sadminc/image/cabezotelogin2.jpg" width="242" height="241"><img src="<?php echo $home; ?>/sadminc/image/cabezotelogin3.jpg" width="248" height="241"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <?php
        				cancelar($_GET["n"], $_GET["id"]);
					?>
                </td>
            </tr>
        </table>
    </body>
</html>