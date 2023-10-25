<?php
require_once dirname(__FILE__).'/../../vargenerales.php';

class wjwflvPlayer {
  function import(){
    global $wwwRoot;
    ob_start();
    ?>
    <script src="<?=$wwwRoot;?>admin/modulos/videos/jwflvplayer/swfobject.js" type="text/javascript"></script>
    <?
    $tmp = ob_get_contents();
    ob_end_clean();
    return $tmp;
  }

  function build($playerId,$fileName,$op=array()){
    global $wwwRoot;
    $w = isset( $op["w"] ) ? $op["w"] : 300;
    $h = isset( $op["h"] ) ? $op["h"] : 170;
    $display = isset($op["display"]) ? "'{$op["display"]}'":"''";
    $autostart = isset($op["autostart"]) ? $op["autostart"]:"0";
    
    ob_start();
    ?>
    <p id="<?=$playerId;?>" style="display:<?=$display;?>;" >
      <a href="http://www.macromedia.com/go/getflashplayer" target="_blank">Get the Flash Player</a> to see this player.
    </p>
    <script type="text/javascript">
      var s1 = new SWFObject("<?=$wwwRoot;?>admin/modulos/videos/jwflvplayer/flvplayer.swf","single","<?=$w;?>","<?=$h;?>","7");
      s1.addParam("allowfullscreen","true");
      s1.addVariable("file","<?=$fileName;?>");
      //s1.addVariable("image","<?=$wwwRoot;?>admin/modulos/videos/jwflvplayer/preview.jpg");
      s1.addVariable("backcolor","0x000000");
      s1.addVariable("frontcolor","0xCCCCCC");
      s1.addVariable("lightcolor","0x557722");
      s1.addVariable("width","<?=$w;?>");
      s1.addVariable("height","<?=$h;?>");
      s1.addVariable("autostart",<?=$autostart;?>);
      s1.write("<?=$playerId;?>");
    </script>
    <?

    $tmp = ob_get_contents();
    ob_end_clean();
    return $tmp;
  }
}
?>