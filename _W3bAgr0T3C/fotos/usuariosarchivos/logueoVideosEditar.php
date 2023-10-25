<?php
  ini_set("memory_limit","50M");
  ini_set("upload_max_filesize", "50M");
  ini_set("max_execution_time",60*15);
  ini_set("post_max_size","50M");

  
if(!session_id()) session_start();
    include("funciones_public.php");
    ValCiudad();
    $IdCiudad = $_GET["ciudad"];
    include("../admin/vargenerales.php");
    include("../admin/herramientas/paginar/class.paginaZ.php");
    require_once dirname(__FILE__).'/../admin/modulos/videos/wjwflvplayer.inc.php';
    
usuariosVerificar();


if( isset($_GET["eliminar"]) && isset($_GET["idarchivo"]) ){
    usuariosArchivosEliminar($_SESSION["usuario"]["usuario"],'VIDEOS',$_GET["idarchivo"]);
    $path = "../fotos/usuariosarchivos/{$_GET["idarchivo"]}";
    unlink("{$path}.flv");
    unlink("{$path}.jpg");
    header("Location: logueoVideos.php?ciudad={$IdCiudad}");
    exit;            
}

function videoGenaratePreview( $input, $output ) {
   $ffmpeg = "/usr/bin/ffmpeg";
   $command = "{$ffmpeg} -v 0 -y -i $input -vframes 1 -ss 5 -vcodec mjpeg -f rawvideo -s 286x160 -aspect 16:9 {$output} ";
   shell_exec( $command );
   return true;
}

function videoConvertToFlv($input,$output){
    $ffmpeg = "/usr/bin/ffmpeg";
    $cmd="{$ffmpeg} -i \"{$input}\" -ar 22050 -ab 32000 -f flv -s 320x240 \"{$output}\"";
    $output=array();
    exec($cmd,$output);
    return true;    
}

if( isset($_POST["bGuardar"]) ){
    $id = usuariosArchivosGuardar(isset($_POST["idarchivo"])?$_POST["idarchivo"]:null,
        'VIDEOS',$_SESSION["usuario"]["usuario"],$_POST["nombre"],$_POST["descripcion"],
         $_FILES["archivo"]["name"]!=""?$_FILES["archivo"]:null);

    $path = "../fotos/usuariosarchivos/{$id}";
    videoConvertToFlv($path,"{$path}.flv");
    unlink($path);
    videoGenaratePreview("{$path}.flv","{$path}.jpg");
   
    header("Location: logueoVideos.php?ciudad={$IdCiudad}");
    exit;    
}


if( isset($_GET["idarchivo"]) ){
    $rxArchivo = usuariosArchivosAssoc($_GET["idarchivo"]);    
}
    
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><? echo Titulo_Sitio(); ?></title>
    <meta name="verify-v1" content="avSdf7eZXEhoMqgCqCmuyVDAUU4yw3RBiFowVsvEvG4=" />
	<? Meta_Tag(); ?>
	<meta name="GENERATOR" content="Agencia de Publicidad Estilo y Diseño (claudio@estilod.com)">
	<META name='revisit-after' content='3 day'>
	<META name='robots' content='ALL'>
	<META name='distribution' content='Global'>
	<META name='charset' content='ISO-8859-1'>
	<META name='expires' content='never'>
	<META name='rating' content='general'>
<link href="../css/diccionario.css" rel="stylesheet" type="text/css" />
<?=wjwflvPlayer::import();?>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="tablaPrincipal"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="tablaGeneral"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="tablaFecha"><?php echo "Hoy es: ".date("d \d\e M \d\e Y") ?></td>
            <td class="tablaBuscar">
            <!-- Imprimir Contenido=FormBuscar-->
            <?
            $RegContenido = mysql_fetch_object(VerContenido( "FormBuscar" ));
            echo $RegContenido->contenido;
            ?>
            <!-- Fin Imprimir Contenido=FormBuscar-->
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="tablaCabezote">
        <!-- Imprimir Contenido=FlashArriba-->
        <?
        $RegContenido = mysql_fetch_object(VerContenido( "FlashArriba" ));
        echo $RegContenido->contenido;
        ?>
        <!-- Fin Imprimir Contenido=FlashArriba-->
        </td>
      </tr>
      <tr>
        <td class="tablaGeneralContenido"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="tablaIzq"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="tablaRompe1"><img src="../imagenes/esqSupIzq1.gif" width="17" height="28" /></td>
                <td class="tablaRompe2">
                <!-- Imprimir Contenido=TituloMenuPrincipal-->
                <?
                $RegContenido = mysql_fetch_object(VerContenido( "TituloMenuPrincipal" ));
                echo $RegContenido->contenido;
                ?>
                <!-- Fin Imprimir Contenido=TituloMenuPrincipal-->
                </td>
                <td class="tablaRompe3"><img src="../imagenes/esqSupDer1.gif" width="18" height="28" /></td>
              </tr>
              <tr>
                <td class="tablaRompe4">&nbsp;</td>
                <td class="tablaRompe5">
                <?php ImprimirMenuPpal(); ?>
                </td>
                <td class="tablaRompe6">&nbsp;</td>
              </tr>
              <tr>
                <td class="tablaRompe7"><img src="../imagenes/esqInfIzq1.gif" width="17" height="16" /></td>
                <td class="tablaRompe8">&nbsp;</td>
                <td class="tablaRompe9"><img src="../imagenes/esqInfDer1.gif" width="18" height="16" /></td>
              </tr>
            </table>
              <br />
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="tablaRompe1"><img src="../imagenes/esqSupIzq1.gif" width="17" height="28" /></td>
                  <td class="tablaRompe2">
                    <!-- Imprimir Contenido=TituloEncuestas-->
                    <?
                    $RegContenido = mysql_fetch_object(VerContenido( "TituloEncuestas" ));
                    echo $RegContenido->contenido;
                    ?>
                    <!-- Fin Imprimir Contenido=TituloEncuestas-->
                  </td>
                  <td class="tablaRompe3"><img src="../imagenes/esqSupDer1.gif" width="18" height="28" /></td>
                </tr>
                <tr>
                  <td class="tablaRompe4">&nbsp;</td>
                  <td class="tablaRompe5">
                  <? ImprimirEncuesta(); ?>
                  </td>
                  <td class="tablaRompe6">&nbsp;</td>
                </tr>
                <tr>
                  <td class="tablaRompe7"><img src="../imagenes/esqInfIzq1.gif" width="17" height="16" /></td>
                  <td class="tablaRompe8">&nbsp;</td>
                  <td class="tablaRompe9"><img src="../imagenes/esqInfDer1.gif" width="18" height="16" /></td>
                </tr>
              </table>
              <br />
		<?php
        $rs_Mensaje = CargarMensajes("rand()",1);
        if( mysql_num_rows( $rs_Mensaje) > 0 ){
        $Reg_Mensaje = mysql_fetch_object($rs_Mensaje);
        ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="tablaRompe1"><img src="../imagenes/esqSupIzq1.gif" width="17" height="28" /></td>
                  <td class="tablaRompe2">
                    <!-- Imprimir Contenido=TituloPizarraVirtual-->
                    <?
                    $RegContenido = mysql_fetch_object(VerContenido( "TituloPizarraVirtual" ));
                    echo $RegContenido->contenido;
                    ?>
                    <!-- Fin Imprimir Contenido=TituloPizarraVirtual-->
                  </td>
                  <td class="tablaRompe3"><img src="../imagenes/esqSupDer1.gif" width="18" height="28" /></td>
                </tr>
                <tr>
                  <td class="tablaRompe4">&nbsp;</td>
                  <td class="tablaRompe5">
                    <span class="titulo1">
                    <?=$Reg_Mensaje->nombre;?>
                    </span><br />
                    <?=$Reg_Mensaje->titulo;?>
                    <br />
                    <?=$Reg_Mensaje->mensaje;?>
                    <p align="center">
                    <a href="mailto:<?=$Reg_Mensaje->email;?>" title="Escribir mail" class="deMasInfo">
                    <!--Imprimir Contenido=BotonMensajeEscribirMail -->
                    <?
                    $RegContenido = mysql_fetch_object(VerContenido( "BotonMensajeEscribirMail" ));
                    echo $RegContenido->contenido;
                    ?>
                    <!--Fin Contenido=BotonMensajeEscribirMail -->
                    </a>
                    <a href="mensajes_enviar.php?ciudad=<?=$IdCiudad?>" title="Agregar Mensaje" class="deMasInfo">
                    <!--Imprimir Contenido=BotonMensajeAgregar -->
                    <?
                    $RegContenido = mysql_fetch_object(VerContenido( "BotonMensajeAgregar" ));
                    echo $RegContenido->contenido;
                    ?>
                    <!--Fin Contenido=BotonMensajeAgregar -->
                    </a>
                    <a href="mensajes.php?ciudad=<?=$IdCiudad?>" title="Ver Mensaje" class="deMasInfo">
                    <!--Imprimir Contenido=BotonMensajeVer -->
                    <?
                    $RegContenido = mysql_fetch_object(VerContenido( "BotonMensajeVer" ));
                    echo $RegContenido->contenido;
                    ?>
                    </a>
                    </p>
                  </td>
                  <td class="tablaRompe6">&nbsp;</td>
                </tr>
                <tr>
                  <td class="tablaRompe7"><img src="../imagenes/esqInfIzq1.gif" width="17" height="16" /></td>
                  <td class="tablaRompe8">&nbsp;</td>
                  <td class="tablaRompe9"><img src="../imagenes/esqInfDer1.gif" width="18" height="16" /></td>
                </tr>
              </table>  
		<?php
        }
        ?>
              <br />
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="tablaRompe1"><img src="../imagenes/esqSupIzq1.gif" width="17" height="28" /></td>
                  <td class="tablaRompe2">
                    <!-- Imprimir Contenido=TituloRegistroBoletin-->
                    <?
                    $RegContenido = mysql_fetch_object(VerContenido( "TituloRegistroBoletin" ));
                    echo $RegContenido->contenido;
                    ?>
                    <!-- Fin Imprimir Contenido=TituloRegistroBoletin-->
                  </td>
                  <td class="tablaRompe3"><img src="../imagenes/esqSupDer1.gif" width="18" height="28" /></td>
                </tr>
                <tr>
                  <td class="tablaRompe4">&nbsp;</td>
                  <td class="tablaRompe5">
                    <!-- Imprimir Contenido=FormBoletin-->
                    <?
                    $RegContenido = mysql_fetch_object(VerContenido( "FormBoletin" ));
                    echo $RegContenido->contenido;
                    ?>
                    <!-- Fin Imprimir Contenido=FormBoletin-->
                  </td>
                  <td class="tablaRompe6">&nbsp;</td>
                </tr>
                <tr>
                  <td class="tablaRompe7"><img src="../imagenes/esqInfIzq1.gif" width="17" height="16" /></td>
                  <td class="tablaRompe8">&nbsp;</td>
                  <td class="tablaRompe9"><img src="../imagenes/esqInfDer1.gif" width="18" height="16" /></td>
                </tr>
              </table>              
              <br />
        <!-- Imprimir Contenido=Contactos-->
        <?
           $RegContenido = mysql_fetch_object(VerContenido( "Contactos" ));
        ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="tablaRompe1"><img src="../imagenes/esqSupIzq1.gif" width="17" height="28" /></td>
                  <td class="tablaRompe2"><? echo $RegContenido->titulo; ?></td>
                  <td class="tablaRompe3"><img src="../imagenes/esqSupDer1.gif" width="18" height="28" /></td>
                </tr>
                <tr>
                  <td class="tablaRompe4">&nbsp;</td>
                  <td class="tablaRompe5">
                    <? echo $RegContenido->contenido; ?><br />
                    <a href="contenido.php.php?clave=Mapa&ciudad=<?=$IdCiudad?>" class="deMasInfo">
                    <!--Imprimir Contenido=BotonVerMapa -->
                    <?
                    $RegContenido = mysql_fetch_object(VerContenido( "BotonVerMapa" ));
                    echo $RegContenido->contenido;
                    ?>
                    <!--Fin Contenido=BotonVerMapa -->
                    </a>
                  </td>
                  <td class="tablaRompe6">&nbsp;</td>
                </tr>
                <tr>
                  <td class="tablaRompe7"><img src="../imagenes/esqInfIzq1.gif" width="17" height="16" /></td>
                  <td class="tablaRompe8">&nbsp;</td>
                  <td class="tablaRompe9"><img src="../imagenes/esqInfDer1.gif" width="18" height="16" /></td>
                </tr>
              </table>
        <!-- Fin Contenido=Contactos-->
              </td>
            <td class="tablaCentroProductos">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="tablaRompe1a"><img src="../imagenes/esqSupIzq2.gif" width="15" height="15" /></td>
                <td class="tablaRompe2a">ss</td>
                <td class="tablaRompe3a"><img src="../imagenes/esqSupDer2.gif" width="12" height="15" /></td>
                </tr>
              <tr>
                <td class="tablaRompe4a">&nbsp;</td>
                <td class="tablaRompe5a">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="tablaLogueoUsuario"><span class="titulo1">Bienvenido:</span>  <?=$_SESSION["usuario"]["nombre"];?></td>
                        <td class="tablaLogueoBotonesGenerales"> |<a href="logueo.php?ciudad=1" class="deMasInfo2">Inicio</a>| 
                          |<a href="logueoVideos.php?ciudad=1" class="deMasInfo2">Atr&aacute;s</a>| 
                          |<a href="logueo.php?logout=1" class="deMasInfo2">Logout</a>| </td>
                      </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                    <td class="tablaTitulo4">
                    <!-- Imprimir Contenido=TituloZonaPrivada-->
                    <?
                    $RegContenido = mysql_fetch_object(VerContenido( "TituloZonaPrivada" ));
                    echo $RegContenido->contenido;
                    ?>
                    <!-- Fin Imprimir Contenido=TituloZonaPrivada-->
                    </td>
                  </tr>
                  <tr>
                    <td class="tablaContenido4">
                      <form action="<?=$_SERVER["PHP_SELF"];?>?ciudad=<?=$IdCiudad;?>" method="post" enctype="multipart/form-data" >
                      <?php if(isset($rxArchivo) ):?>
                      <input type="hidden" name="idarchivo" value="<?=$rxArchivo["idarchivo"];?>"/>
                      <?php endif;?>
                      
                      <span class="tituloProductoVer">Editar Video</span><br />
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="tablaLogueoFormularioGeneral">T&iacute;tulo<br />
                          <input name="nombre" type="text" id="textfield" value="<?=isset($rxArchivo)?$rxArchivo["nombre"]:"";?>" size="25" maxlength="45" />
                          <br />
                          <br />
                          Contenido<br />
                          <textarea name="descripcion" id="textarea" cols="60" rows="7"><?=isset($rxArchivo)?$rxArchivo["descripcion"]:"";?></textarea>
                          <br />
                          <br />
                          Video<br />
                          <?php if($rxArchivo):?>
                          <?=$rxArchivo["archivo"];?><br/>
                          <?=wjwflvPlayer::build("player1","http://www.chiquititaplaza.com/fotos/usuariosarchivos/{$rxArchivo["idarchivo"]}.flv");?>
                          <br/>
                          <?php endif;?>                                                    
                          <input name="archivo" type="file" id="textfield2" />
                        </td>
                      </tr>
                    </table>
                      <br />
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="tablaLogueoGeneral">
                            <input type="submit" name="bGuardar" id="button" value="Guardar" /> &nbsp;
                            <?php if(isset($rxArchivo) ):?>
                            <input type="button" name="button2" id="button2" value="Eliminar" onclick="location='<?=$_SERVER["PHP_SELF"];?>?ciudad=<?=$IdCiudad;?>&eliminar=1&idarchivo=<?=$rxArchivo["idarchivo"];?>';"/>
                            <?php endif;?>
                            &nbsp;
                            <input type="button" name="button3" id="button3" value="Regresar" onclick="location='logueoVideos.php?ciudad=<?=$IdCiudad;?>';"/>

                          </td>
                        </tr>
                      </table>
                      </form>
                      </td>
                  </tr>
                  <tr>
                    <td class="tablaAbajo4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="tablaAbajo4a"><img src="../imagenes/figuraAbajoDetalles4.gif" width="144" height="44" /></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                  <br /><br />
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="tablaBotonesAbajo">
                        <?php ImprimirMenuPie()?>
                        </td>
                      </tr>
                    </table>
                  </td>
                <td class="tablaRompe6a">&nbsp;</td>
                </tr>
              <tr>
                <td height="14" class="tablaRompe7a"><img src="../imagenes/esqInfIzq2.gif" width="15" height="13" /></td>
                <td class="tablaRompe8a">1</td>
                <td class="tablaRompe9a"><img src="../imagenes/esqInfDer2.gif" width="12" height="13" /></td>
                </tr>
            </table></td>
            <td class="tablaBotonesAdicionalesIZQ">
              <!-- Imprimir Contenido=BotonesArriba-->
              <?
            $RegContenido = mysql_fetch_object(VerContenido( "BotonesArriba" ));
            echo $RegContenido->contenido;
            ?>
              <!-- Fin Imprimir Contenido=BotonesArriba-->
            </td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td class="tablaCreditos">
        <?php CargarCreditos()?>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript">
_uacct = "UA-1321799-1";
	urchinTracker();
</script>
</body>
</html>
