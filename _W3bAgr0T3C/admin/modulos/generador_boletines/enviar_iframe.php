<?php
	require_once dirname(__FILE__)."/XPM4-v.0.4/MAIL.php";
	include("../../herramientas/seguridad/seguridad.php");
	include("../../herramientas/paginar/class.paginaZ.php");
	include("../../funciones_generales.php");
	include("../../vargenerales.php");

    $nConexion    = Conectar();

    set_time_limit(0);

    $_SESSION["bol"] = $_POST["bol"];
    $_SESSION["bloques"] = $_POST["bloques"];
    $_SESSION["espera"] = $_POST["espera"];
    $_SESSION["template"] = $_POST["template"];

    $_SESSION["asunto"] = $_POST["asunto"];
    
    if( $_POST["lista"]==-1){
        $_SESSION["destinatarios"] = explode("\n",trim( file_get_contents( $_FILES["destinatarios"]["tmp_name"] ) ) );
        
    }
    else {
    	$sql="select * from tblboletinescorreos ";
        
        if( $_POST["lista"] > 0 ){
            $sql.=" where idlista = {$_POST["lista"]}";
        }
    	
    	$rsCorreos = mysqli_query($nConexion,$sql);
    	$_SESSION["destinatarios"]=array();
    	while($rax=mysqli_fetch_assoc($rsCorreos)){
            $_SESSION["destinatarios"][] = $rax;
    	}
    }
        
    //$_SESSION["destinatarios"] = trim($_SESSION["destinatarios"]);


    //echo file_get_contents( $_FILES["destinatarios"]["tmp_name"] );


    //$_SESSION["total"] = count($_SESSION["destinatarios"]);

    $total = count($_SESSION["destinatarios"]);


    $urlT = "http://{$_SERVER["HTTP_HOST"]}/fotos/Image/plantillasgb/{$_SESSION["template"]}/index.php?bol={$_SESSION["bol"]}";
    
    $html = file_get_contents($urlT);



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="en" />
    <meta name="GENERATOR" content="PHPEclipse 1.2.0" />
    <title>title</title>
</head>
<body>
<?php
$i=1;

foreach($_SESSION["destinatarios"] as $k=>$v){
    $v["correo"] = trim($v["correo"]);
    $v["nombre"] = trim($v["nombre"]);
    if( $v["correo"]=="" ) continue;

    $ra = mysqli_query($nConexion,"select * from tblboletines_retirados where email='{$v['correo']}'");
    if( mysqli_num_rows($ra) > 0 ){
        continue;
    }

    $m=new MAIL();
    $host = str_replace("www.","",$_SERVER["HTTP_HOST"]);

    $m->from("boletin@{$host}","Clickee, un aministrador que Diferencia!");
    
    if ( !preg_match("/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/",$v["correo"]) ) {
	// /^[^@ ]+@[^@ ]+.[^@ .]+$/
	echo "Fallo {$i} de {$total}  {$v['correo']}<br/>";
	continue;
    }
    $m->addto($v["correo"],$v["nombre"]);
    $m->subject($_SESSION["asunto"]);

    $tmp = str_replace("{destinatario}",$v["nombre"]!=""?$v["nombre"]:$v["correo"],$html);
    $tmp = str_replace("{email}",$v["correo"],$tmp);
    
    $m->html( $tmp );
    $m->send();

    unset($_SESSION["destinatarios"][$k]);

    echo "Enviando {$i} de {$total}<br/>";
    $i++;
    ob_flush();
    flush();

    if( ($i % $_SESSION["bloques"])==0 ){
        echo "En espera";
        for($j=0;$j<$_SESSION["espera"];$j++){
            sleep(60);
            echo ".";
            ob_flush();
            flush();
        }
        echo "<br/>";
    }



}
echo "----------Proceso finalizado----------<br/>";

?>
</body>
</html>