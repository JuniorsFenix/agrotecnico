<?php
require_once dirname(__FILE__).'/../../vargenerales.php';

class wswfmp3Player {
  public static function import(){
    global $wwwRoot;
    ob_start();
    ?>
    <script src="<?=$wwwRoot;?>admin/modulos/musica/wswfmp3player/swfobject.js" type="text/javascript"></script>
    <?
    $tmp = ob_get_contents();
    ob_end_clean();
    return $tmp;
  }

  public static function build($playerId,$fileName,$op=array()){
    global $wwwRoot;

    $op["name"] = isset($op["name"]) ? $op["name"]:"Sin nombre";
    $w = isset( $op["w"] ) ? $op["w"] : 300;
    $h = isset( $op["h"] ) ? $op["h"] : 70;
    $display = isset($op["display"]) ? "'{$op["display"]}'":"''";

    ob_start();
    ?>
    <p id="<?=$playerId;?>" style="display:<?=$display;?>;" >
      <a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.
    </p>
    <script type="text/javascript">
      //var flashObj = new FlashObject ("<?=$wwwRoot;?>admin/modulos/musica/wswfmp3player/swfmp3player.swf?mp3=<?=$fileName;?>&action=stop&title=Rock song&color=b1eb95&loop=no&lma=yes&textcolor=000000", "FMP3", "260", "60", 7, "#FFFFFF", true);
      var s1 = new SWFObject("<?=$wwwRoot;?>admin/modulos/musica/wswfmp3player/swfmp3player.swf?mp3=<?=$fileName;?>&action=stop&title=<?=$op["name"];?>&color=b1eb95&loop=no&lma=yes&textcolor=000000","FMP3","<?=$w;?>","<?=$h;?>",7,"#FFFFFF", true);
      s1.addVariable("width","<?=$w;?>");
      s1.addVariable("height","<?=$h;?>");
      s1.write("<?=$playerId;?>");
    </script>
    <?

    $tmp = ob_get_contents();
    ob_end_clean();
    return $tmp;
  }
}
?>