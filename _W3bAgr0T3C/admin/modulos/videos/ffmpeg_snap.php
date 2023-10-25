<?php
//convertToFlv( "some-video-input.avi", "output.jpg" );

function convertToFlvSnap( $input, $output ) {
   $ffmpeg = "/usr/bin/ffmpeg";
   //echo "Converting $input to $output<br />";
   $command = "{$ffmpeg} -v 0 -y -i $input -vframes 1 -ss 5 -vcodec mjpeg -f rawvideo -s 286x160 -aspect 16:9 $output ";
   //echo "$command<br />";
   shell_exec( $command );
   //echo "Converted<br />";
}
?>