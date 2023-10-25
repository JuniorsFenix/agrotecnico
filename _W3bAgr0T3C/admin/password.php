<?php

include("funcioneslogin.php");
$sitioCfg = sitioAssoc2();
$home = $sitioCfg["url"];
include("vargenerales.php");


    

    if ( isset($_POST["bRecuperar"]) ) {
        cambiarClave($_POST["txtClave1"], $_POST["txtClave2"], $_POST["txtClave"], $_POST["txtUsuario"]);
    }


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
                                        <td><img src="<?php echo $home; ?>/sadminc/image/cabezote1.jpg"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="tablaContenidos"><p>&nbsp;</p><p>&nbsp;</p>
                                <form method="post" action="<?php echo $home; ?>/sadminc/password.php" name="frm">
                                    <input type="hidden" name="txtClave" id="txtClave" value="<?php echo $_GET["n"]; ?>"/>
                                    <input type="hidden" name="txtUsuario" id="txtClave" value="<?php echo $_GET["id"]; ?>"/>
                                    <table width="550" align="center" class="formularioLineaFuera">
                                        <tr valign="baseline">
                                            <td colspan="2" align="center">
                                                <?php

                                                if ($_GET["error"] == "si") {
                                                    echo "<b>Usuario, Contrase&ntilde;a y/o Ciudad Incorrectos</b>";
                                                } else {
                                                    echo "<b>Ingresa tus datos de inicio de sesi&oacute;n</b>";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table border="0" align="center">
                                                    <tr valign="baseline">
                                                        <td nowrap class="nombresDelCampo">Nueva Contrase&ntilde;a:</td>
                                                        <td nowrap class="nombresDelCampo">
                                                            <input type="password" name="txtClave1" id="txtClave1" maxlength="20"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td nowrap class="nombresDelCampo">Confirmar Contrase&ntilde;a:</td>
                                                        <td nowrap class="nombresDelCampo">
                                                            <input type="password" name="txtClave2" id="txtClave2" maxlength="20"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <input name="bRecuperar" type="submit" id="bRecuperar" value="Enviar"/>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </form><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
                            </td>
                        </tr>
                        <tr>
                            <td height="39" class="tablaCreditos">&copy; todos los derechos reservados por clickee &nbsp;&nbsp;<a href="mailto:info@clickee.com" title="Esc&iacute;benos!!!" class="botonAbajo">info@clickee.com</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.clickee.com" title="Agencia que realiz&oacute; este Administrador de Contenidos..." target="_blank" class="botonAbajo">www.clickee.com</a></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>