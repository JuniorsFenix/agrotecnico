<?php 
$jobs_location = ux_get_post_meta(get_the_ID(), 'theme_meta_jobs_location');
$jobs_number   = ux_get_post_meta(get_the_ID(), 'theme_meta_jobs_number'); ?>

<div class="entry"><?php the_content(); ?></div>
<div class="job-info">
	<?php if($jobs_location){ ?>
        <span class="job-location"><?php echo __('Location:', 'ux'). ' ' .$jobs_location; ?></span>
    <?php }
    
    if($jobs_number){ ?>
        <span class="job-number"><?php echo __('Number:', 'ux'). ' ' .$jobs_number; ?></span>
    <?php } ?>
</div>