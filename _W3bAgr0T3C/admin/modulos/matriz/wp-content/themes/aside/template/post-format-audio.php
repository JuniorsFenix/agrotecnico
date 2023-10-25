<?php 
$audio_type       = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_type');
$audio_artist     = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_artist');
$audio_mp3        = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_mp3');
$audio_soundcloud = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_soundcloud');

switch($audio_type){
	case 'self-hosted-audio': 

        if($audio_artist) { 

            echo '<div class="audio-artist">';
            _e('Artist: ','ux');
            echo  $audio_artist .'</div>';
            
        }    

        ?>
        <ul class="audio_player_list audio_content audio-format-post">
			<?php foreach($audio_mp3['name'] as $i => $name){
                $url = $audio_mp3['url'][$i]; ?>
                <li class="audio-unit"><span id="audio-<?php echo get_the_ID() . '-' . $i; ?>" class="audiobutton pause" rel="<?php echo esc_url($url); ?>"></span><span class="songtitle" title="<?php echo $name;?>"><?php echo $name;?></span></li>
            <?php } ?>
        </ul>
        
    <?php
	break;
	
	case 'soundcloud': ?>
        <div class="audiopost-soundcloud-wrap">
            <iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?php echo $audio_soundcloud;?>&amp;color=ff3900&amp;auto_play=false&amp;show_artwork=true"></iframe>
        </div>
    <?php
	break;
}
?>