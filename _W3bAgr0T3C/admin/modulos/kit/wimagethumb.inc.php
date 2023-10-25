<?php
function wimageThumbSize($width,$height,$newwidth,$newheight) {
    $factorh = ( $newheight * 100 ) / $height;
    $factorw = ( $newwidth * 100 ) / $width;

    //escalado automatico

    if ( ($newwidth == 0 && $newheight > 0) ||  ($factorw > $factorh && $factorh > 0) ){
      $newwidth = ($width * $factorh ) / 100;
    }
    else if ( ($newheight == 0 && $newwidth > 0)  ||  ($factorh > $factorw && $factorw > 0) ){
      $newheight = ($height * $factorw ) / 100;
    }

    return array($newwidth,$newheight);
}
function wimageThumbFromString($i_string, $newWidth,$newHeight) {
    $o_im = imagecreatefromstring($i_string);
    $o_wd = imagesx($o_im) ;
    $o_ht = imagesy($o_im) ;

    list( $t_wd,$t_ht ) = wimageThumbSize($o_wd,$o_ht,$newWidth,$newHeight);
    //echo "newWidth = $t_wd newHeight = $t_ht";

    $t_im = imageCreateTrueColor($t_wd,$t_ht);

    imageCopyResampled($t_im, $o_im, 0, 0, 0, 0, $t_wd, $t_ht, $o_wd, $o_ht);
    imageDestroy($o_im);

    ob_start();
    imageJPEG($t_im,'',95);
    //imageJPEG($t_im);
    $data = ob_get_contents();

    //ojo esto es solo para ravinglacapital
    //$data = $i_string;
    //$t_wd=$o_wd;
    //$t_ht=$o_ht;

    ob_end_clean();

    imageDestroy($t_im);
    return array($data,$t_wd,$t_ht);
}





function wimageThumbFromFile($o_file, $t_ht = 100) {
    $image_info = getImageSize($o_file) ; // see EXIF for faster way

    switch ($image_info['mime']) {
        case 'image/gif':
            if (imagetypes() & IMG_GIF)  { // not the same as IMAGETYPE
                $o_im = imageCreateFromGIF($o_file) ;
            } else {
                $ermsg = 'GIF images are not supported<br />';
            }
            break;
        case 'image/jpeg':
            if (imagetypes() & IMG_JPG)  {
                $o_im = imageCreateFromJPEG($o_file) ;
            } else {
                $ermsg = 'JPEG images are not supported<br />';
            }
            break;
        case 'image/png':
            if (imagetypes() & IMG_PNG)  {
                $o_im = imageCreateFromPNG($o_file) ;
            } else {
                $ermsg = 'PNG images are not supported<br />';
            }
            break;
        case 'image/wbmp':
            if (imagetypes() & IMG_WBMP)  {
                $o_im = imageCreateFromWBMP($o_file) ;
            } else {
                $ermsg = 'WBMP images are not supported<br />';
            }
            break;
        default:
            $ermsg = $image_info['mime'].' images are not supported<br />';
            break;
    }

    if (!isset($ermsg)) {
        $o_wd = imagesx($o_im) ;
        $o_ht = imagesy($o_im) ;
        // thumbnail width = target * original width / original height
        $t_wd = round($o_wd * $t_ht / $o_ht) ;

        $t_im = imageCreateTrueColor($t_wd,$t_ht);

        imageCopyResampled($t_im, $o_im, 0, 0, 0, 0, $t_wd, $t_ht, $o_wd, $o_ht);

        ob_start();
        imageJPEG($t_im);
        $data = ob_get_contents();
        ob_end_clean();

        imageDestroy($o_im);
        imageDestroy($t_im);
        return $data;
    }
    return isset($ermsg)?$ermsg:NULL;
}



function imagecreatefromfile($path, $user_functions = false)
{
    $info = @getimagesize($path);

    if(!$info)
    {
        return false;
    }

    $functions = array(
        IMAGETYPE_GIF => 'imagecreatefromgif',
        IMAGETYPE_JPEG => 'imagecreatefromjpeg',
        IMAGETYPE_PNG => 'imagecreatefrompng',
        IMAGETYPE_WBMP => 'imagecreatefromwbmp',
        IMAGETYPE_XBM => 'imagecreatefromwxbm',
        );

    if($user_functions)
    {
        $functions[IMAGETYPE_BMP] = 'imagecreatefrombmp';
    }

    if(!$functions[$info[2]])
    {
        return false;
    }

    if(!function_exists($functions[$info[2]]))
    {
        return false;
    }

    return $functions[$info[2]]($path);
}

?>