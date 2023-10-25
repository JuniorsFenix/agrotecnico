<?php
###############################################################################
# usuarios_funciones.php :  Archivo de funciones modulo usuarios
# Desarrollo             :  Estilo y Dise�o & Informaticactiva
# Web                    :  http://www.esidi.com
#                           http://www.informaticactiva.com
###############################################################################
 require_once("funciones_generales.php");
 
 
	$sitioCfg = sitioAssoc2();
	$home = $sitioCfg["url"];

require_once dirname(__FILE__)."/herramientas/XPM4-v.0.4/MAIL.php";


###############################################################################
# Nombre        : ValidarLogin
# Descripci�n   : Valida que el usuario y claves existan en la base de datos
# Parametros    : Usuario, Clave
# Desarrollado  : Estilo y Dise�o & Informaticactiva
# Retorno       : Ninguno
###############################################################################

function ValidarLogin($correo, $cClave, $idCiudad) {
	global $home;
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion,"SELECT * FROM tblusuarios WHERE correo_electronico='$correo'");
    mysqli_close($nConexion);
    $Registro = mysqli_fetch_array($Resultado);
    $hclave = hash("sha256", $cClave);
    if ($Registro["correo_electronico"] == $correo && $Registro["clave"] == $hclave) {
        //echo "usuario correcto";
        session_start();
        $_SESSION["UsrValido"] = "SI";
        $_SESSION["UsrNombre"] = $Registro["nombres"];
        $_SESSION["UsrPerfil"] = $Registro["perfil"];
        $_SESSION["UsrCorreo"] = $Registro["correo_electronico"];
        $_SESSION["IdUser"] = $Registro["idusuario"];
        $_SESSION["IdCiudad"] = $idCiudad;
        header("Location: $home/sadminc/clickeeb");
        exit;
    } else {
        Error("Correo y/o contrase�a incorrectos.");
        exit;
    }

}

// FIN: function UsuariosActualizarClave
###############################################################################

function reasignarClave($correo, $idCiudad) {
	global $home;
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion,"SELECT * FROM tblusuarios WHERE correo_electronico='{$correo}'");


    if (mysqli_num_rows($Resultado) > 0) {
        $Registro = mysqli_fetch_array($Resultado);
        
        $clave = substr(base64_encode(crypt('', '')), 0, 16);
	 $clave = mysqli_real_escape_string($nConexion,$clave);
        
        $sql = "update tblusuarios set reset_code='$clave' where correo_electronico='$correo'";
        $ra = mysqli_query($nConexion,$sql);
        if (!$ra) {
            die("Error, fallo asignando nueva clave.");
        }

        mysqli_close($nConexion);
        $m = new MAIL();
        $host = str_replace("www.","", $_SERVER["HTTP_HOST"]);

        $m->addHeader("charset", "utf-8");
        $m->from("soporte@{$host}", "Departamento de Soporte");
        $m->addto("{$Registro["correo_electronico"]}", "{$Registro["nombre"]}");
        $m->subject("Clave Zona Usuarios Admin {$host}");
        
        $html = "<html><head><title>Clave Zona Usuarios Clickee</title></head>
	<body>Hola, {$Registro["nombre"]}:<br><br>
	Recientemente pediste cambiar tu contrase&ntilde;a de $host. Para completar el proceso, sigue este enlace:<br><br>
	<a href='http://www.$host{$home}/sadminc/password.php?n=$clave&id={$Registro["idusuario"]}'>http://www.$host{$home}/sadminc/password.php?n=$clave&id={$Registro["idusuario"]}</a><br><br>
	Si no has pedido una contrase&ntilde;a nueva, sigue este enlace y comun&iacute;canoslo:<br><br>
	<a href='http://www.$host{$home}/sadminc/cancelReset.php?n=$clave&id={$Registro["idusuario"]}'>http://www.$host{$home}/sadminc/cancelReset.php?n=$clave&id={$Registro["idusuario"]}</a><br><br>
	Gracias,<br>
	$host</body></html>";
        
        $m->html($html);

        $cHost = $host;
        $cPort = 25;
        $cUser = "soporte@clickee.com";
        $cPass = "mhyy964";

        $c = $m->Connect($cHost, $cPort, $cUser, $cPass);
        $status = $m->send($c);

        if (!$status) {
            die("Error enviando mensaje");
        }

        
        header("Location: $home/sadminc");
        exit;
    } else {
        Error("Usuario no encontrado.");
        exit;
    }

}

function cambiarClave($cClaveNueva, $cClaveConfirma, $clave, $idUsuario) {
	global $home;
    // Verificar que las claves sean correctas:

    if ($cClaveNueva == $cClaveConfirma) {
        $nConexion = Conectar();
        $Resultado = mysqli_query($nConexion,"SELECT * FROM tblusuarios WHERE idusuario ='$idUsuario'");
        $Registro = mysqli_fetch_array($Resultado);
        

        if ( $clave == $Registro["reset_code"]) {
            $nConexion = Conectar();
            $cClaveNueva = hash("sha256", $cClaveNueva);
            mysqli_query($nConexion,"UPDATE tblusuarios SET clave ='{$cClaveNueva}', reset_code ='' WHERE idusuario ='$idUsuario'");
            mysqli_close($nConexion);
            Mensaje("La contrase&ntilde;a se cambio con �xito.", "$home/sadminc");
            exit();
        } else {
            Error("Este link ya no es v&aacute;lido");
        }

    } else {
        Error("Los campos Contrase&ntilde;a y Confirmar deben ser iguales.");
    }

    mysqli_free_result($Resultado);
    exit();
}

function cancelar($clave, $idUsuario) {
	global $home;
	$nConexion = Conectar();
	mysqli_query($nConexion,"UPDATE tblusuarios SET reset_code ='' WHERE idusuario ='$idUsuario'");
	mysqli_close($nConexion);
	Mensaje("El cambio de contrase&ntilde;a ha sido invalidado.", "$home/sadminc");
	exit();
}
// FIN: function UsuariosActualizarClave
###############################################################################
?>