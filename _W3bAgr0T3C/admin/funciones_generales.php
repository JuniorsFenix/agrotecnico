<?php
  ###############################################################################
  # funciones_generales.php:  Archivo de funciones de uso general
  # Desarrollo             :  Estilo y Dise�o & Informaticactiva
  # Web                    :  http://www.esidi.com
  #                           http://www.informaticactiva.com
  ###############################################################################
require_once dirname(__FILE__).("/../include/connect.php");
 
  ###############################################################################

  ###############################################################################
  # Nombre        : Error
  # Descripci�n   : Imprime Errores Generales
  # Parametros    : $cCadenaError = Cadena con texto de error.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################

function sitioAssoc2(){
	$nConexion = Conectar();
    $sql="select s.*, p.estilo from tblsitio s LEFT JOIN plantillas p ON s.idplantilla=p.idplantilla LIMIT 1";
    $ra = mysqli_query($nConexion,$sql);
    
    return mysqli_fetch_assoc($ra);
		
}
  function Error( $cCadenaError )
  {
	$sitioCfg = sitioAssoc2();
	$home = $sitioCfg["url"];
?> 
<html>
	<head>
		<title>--Administraci�n de Usuarios--</title>
		<link href="<?php echo $home; ?>/sadminc/css/administrador.css" rel="stylesheet" type="text/css">
	</head>
<body>
<table width="100%">
<tr>
<td><h1 class="errorTitulo">ERROR:</h1></td>
</tr>
<tr>
<td><h2 class="errorEcho"><?php echo $cCadenaError;?></h2></td>
</tr>
<tr>
<td class="errorAtras">Intente nuevamente presionando clic <a href="javascript:history.back(1)" class="botonAbajo">aca</a> o comunique al <span class="botonAbajo"><a href="mailto:soporte@clickee.com" class="botonAbajo">webmaster</a> si considera que esto es una anomal�a.</span><br><br><br>Muchas Gracias</td>
</tr>
</table>
</body>
</html>
<?php
  }
  ###############################################################################

  ###############################################################################
  # Nombre        : getRealIP
  # Descripci�n   : Retorna la IP del Cliente
  # Parametros    : Ninguno
  # Retorno       : Numero IP
  ###############################################################################
function getRealIP()
{
   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );
								// los proxys van a�adiendo al final de esta cabecera
								// las direcciones ip que van "ocultando". Para localizar la ip real
								// del usuario se comienza a mirar por el principio hasta encontrar
								// una direcci�n ip que no sea del rango privado. En caso de no
								// encontrarse ninguna se toma como valor el REMOTE_ADDR
      $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);
      reset($entries);
      while (list(, $entry) = each($entries))
      {
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
         {
            // http://www.faqs.org/rfcs/rfc1918.html
            $private_ip = array(
                  '/^0\./',
                  '/^127\.0\.0\.1/',
                  '/^192\.168\..*/',
                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                  '/^10\..*/');
   
            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
   
            if ($client_ip != $found_ip)
            {
               $client_ip = $found_ip;
               break;
            }
         }
      }
   }
   else
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );
   }
   return $client_ip;
}

  ###############################################################################
  # Nombre        : Mensaje
  # Descripci�n   : Imprime un mensaje al usuario
  # Parametros    : $cCadenaMensaje = Mensaje que se imprimira
  # Parametros    : $cPagina        = Pagina la cual debe ser direccionada por medio de un link
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function Mensaje( $cCadenaMensaje, $cPagina )
  {
		error_reporting(E_ALL ^E_WARNING);
    ?>
      <table width="50%" align="center">
        <tr>
          <td align="center" class="mensajeEcho"><?php echo $cCadenaMensaje; ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center" class="mensajeAceptar"><a href="<?php echo $cPagina; ?>" class="botonAbajo2"><b>Aceptar</b></a></td>
        </tr>
      </table>
    <?php
  }
  ###############################################################################
function Perfil()
{
	session_start();
	return $_SESSION["UsrPerfil"];
}

function NomUsuario()
{
	session_start();
	return $_SESSION["UsrCorreo"];
}

function Log_System( $Modulo, $Accion, $Descripcion )
{
	$Ip 			= getRealIP();
	$Usuario	= NomUsuario();
	
	$nConexion	= Conectar();
	mysqli_query($nConexion,"INSERT INTO tbllog ( modulo,accion,descripcion,usuario,fecha_hora,ip ) VALUES ( '$Modulo', '$Accion', '$Descripcion', '$Usuario', Now(), '$Ip' )");
}

function CboCiudades($IdCiudad){
	$nConexion 	= Conectar();
	$rsCiudades	= mysqli_query($nConexion,"SELECT * FROM tblciudades WHERE publicar = 'S' ORDER BY ciudad");
	$Primero 		=	0;
	echo "<select name=\"cboCiudades\" id=\"cboCiudades\">\n";
	while ( $regCiudades = mysqli_fetch_object($rsCiudades) ){
		$Primero = $Primero + 1;
		if ( $IdCiudad == 0 ){
			if ( $Primero == 1 ){
				echo "<option value=".$regCiudades->idciudad." selected>$regCiudades->ciudad</option>\n";
			}
			else{
				echo "<option value=".$regCiudades->idciudad.">$regCiudades->ciudad</option>\n";
			}
		}
		else{
			if ( $IdCiudad == $regCiudades->idciudad ){
				echo "<option value=".$regCiudades->idciudad." selected>$regCiudades->ciudad</option>\n";
			}
			else
			{
				echo "<option value=".$regCiudades->idciudad.">$regCiudades->ciudad</option>\n";
			}
		}
	}
	echo "</select>\n";
}

function slug($str, $replace=array(), $delimiter='-') {
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}

	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	return $clean;
}

function permisos($modulo="todos") {
    $nConexion = Conectar();
	if( $modulo=="todos" ) {
		$sql  = mysqli_query($nConexion,"SELECT modulo FROM modulos m JOIN perfil_modulo pm on (m.id=pm.idmodulo) WHERE idperfil = {$_SESSION["UsrPerfil"]}");
		while($row=mysqli_fetch_assoc($sql)) {
			$modulos[] = $row["modulo"];
		}
		return $modulos;
	}
	else{
		$sql  = mysqli_query($nConexion,"SELECT ver,crear,editar,eliminar FROM modulos m JOIN perfil_modulo pm on (m.id=pm.idmodulo) WHERE idperfil = {$_SESSION["UsrPerfil"]} AND modulo='$modulo'");
		$row=mysqli_fetch_assoc($sql);
		return $row;
	}
}
function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
	require_once dirname(__FILE__)."/herramientas/random/lib/random.php";
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}
?>