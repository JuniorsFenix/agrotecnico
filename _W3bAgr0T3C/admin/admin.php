<?php
	require_once("funciones_generales.php");
require_once("funcioneslogin.php");
	$sitioCfg = sitioAssoc2();
	$home = $sitioCfg["url"];
require_once("vargenerales.php");


if (isset($_POST["txtUsuario"])) {
    if (isset($_POST["bIniciar"])) {
        if ($_POST["txtUsuario"] != "" || $_POST["txtClave"] != "") {
            ValidarLogin($_POST["txtUsuario"], $_POST["txtClave"], $_POST["cboCiudades"]);
        } else {
            header("Location: $home/sadminc?error=si");
        }
    }
    
    if ( isset($_POST["bRecuperar"]) ) {
        reasignarClave($_POST["txtUsuario"], $_POST["cboCiudades"]);
    }
}
?>
<html>
    <head>
        <title>.:: Sitio de Administraci&oacute;n Portal ClicKee ::.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="<?php echo $home; ?>/sadminc/css/administrador.css" rel="stylesheet" type="text/css">
        <script language="javascript">
            function my_focus()
            {
                document.frm.txtUsuario.focus();
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
                                <form method="post" action="<?php echo $home; ?>/sadminc" name="frm">
                                    <table width="550" align="center" class="formularioLineaFuera">
                                        <tr valign="baseline">
                                            <td colspan="2" align="center">
                                                <?php
                                                if (isset($_GET["error"])) {
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
                                                        <td nowrap class="nombresDelCampo">Correo:</td>
                                                        <td nowrap class="nombresDelCampo">
                                                            <input type="text" autocomplete="off" id="txtUsuario" name="txtUsuario" maxLength="50"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td nowrap class="nombresDelCampo">Clave:</td>
                                                        <td nowrap class="nombresDelCampo">
                                                            <input type="password" name="txtClave" id="txtClave" maxlength="20"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td nowrap class="nombresDelCampo">Idioma:</td>
                                                        <td nowrap class="nombresDelCampo" >
                                                            <?php
                                                            $nConexion = Conectar();
                                                            $rsCiudades = mysqli_query($nConexion,"SELECT * FROM tblciudades WHERE publicar = 'S' ORDER BY ciudad");
                                                            mysqli_close($nConexion);
                                                            echo "<select name=\"cboCiudades\" id=\"cboCiudades\" style=\"width:100%;text-align:left;\">\n";
                                                            //echo "<option value=\"0\" selected>Seleccione el idioma</option>\n";
                                                            while ($regCiudades = mysqli_fetch_object($rsCiudades)) {
                                                                $selected = isset($sw) ? "" : "selected";
                                                                echo "<option value=\"$regCiudades->idciudad\" {$selected} >$regCiudades->ciudad</option>\n";
                                                            }
                                                            mysqli_free_result($rsCiudades);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <input name="bIniciar" type="submit" id="bIniciar" value="Iniciar Sesi&oacute;n"/>
                                                            <input name="bRecuperar" type="submit" id="bRecuperar" value="Enviar Nueva Clave"/>
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
                            <td height="39" class="tablaCreditos">&copy; todos los derechos reservados por CLICKEE &nbsp;&nbsp;<a href="mailto:info@clickee.com" title="Esc&iacute;benos!!!" class="botonAbajo">info@clickee.com</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.clickee.com" title="Agencia que realiz&oacute; este Administrador de Contenidos..." target="_blank" class="botonAbajo">www.clickee.com</a></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
