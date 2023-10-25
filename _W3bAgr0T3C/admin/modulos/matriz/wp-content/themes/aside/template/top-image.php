<?php
$post_format = !get_post_format() ? 'standard' : get_post_format();

if($post_format == 'image' || $post_format == 'audio'){
	if(has_post_thumbnail()){ ?>

        <div class="top-image"><?php the_post_thumbnail('full'); ?></div>
    
    <?php
	}
}?>
