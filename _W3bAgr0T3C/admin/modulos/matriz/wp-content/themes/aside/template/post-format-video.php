<?php 
$video_embeded_code = ux_get_post_meta(get_the_ID(), 'theme_meta_video_embeded_code');
$video_ratio        = ux_get_post_meta(get_the_ID(), 'theme_meta_video_ratio', true);
$video_custom_ratio = ux_get_post_meta(get_the_ID(), 'theme_meta_video_custom_ratio', true);

$key_1      = false;
$key_2      = false;
$video_size = false;

switch($video_ratio){
	case '16:9': $video_size = 'video-16-9'; break;
	case '4:3': $video_size = 'video-4-3'; break;
	case 'custom':
		$key_1 = $video_custom_ratio && isset($video_custom_ratio[1]) ? $video_custom_ratio[1] : 4;
		$key_2 = $video_custom_ratio && isset($video_custom_ratio[2]) ? $video_custom_ratio[2] : 3;
		$video_size = false;
	break;
}

$key_1 = $key_1 ? $key_1 : 4;
$key_2 = $key_2 ? $key_2 : 3;
$video_size = $video_size ? $video_size : false;

$video_custom = $video_custom_ratio ? 'padding-bottom:'.($key_2 / $key_1) * 100 .'%' : false;

if($video_embeded_code){ ?>
        
			<?php if(strstr($video_embeded_code, "youtu") && !(strstr($video_embeded_code, "iframe"))){ ?>
                <div class="videoWrapper video-wrap video-post-wrap youtube <?php echo $video_size; ?>" style=" <?php echo $video_custom; ?>">
                	<iframe src="http://www.youtube.com/embed/<?php echo ux_theme_get_youtube($video_embeded_code);?>?rel=0&controls=1&showinfo=0&theme=light&autoplay=0&wmode=transparent"></iframe>
            	</div>
            <?php }elseif(strstr($video_embeded_code, "vimeo") && !(strstr($video_embeded_code, "iframe"))){ ?>
				<div class="videoWrapper video-wrap video-post-wrap viemo <?php echo $video_size; ?>" style=" <?php echo $video_custom; ?>">
					<iframe src="http://player.vimeo.com/video/<?php echo ux_theme_get_vimeo($video_embeded_code); ?>?title=0&amp;byline=0&amp;portrait=0" width="100%" height="auto" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				</div>
			<?php }else{ ?>
				<div class="videoWrapper video-wrap video-post-wrap <?php echo $video_size; ?>" style=" <?php echo $video_custom; ?>"><?php echo $video_embeded_code; ?></div>
			<?php } ?>
          
<?php } ?>