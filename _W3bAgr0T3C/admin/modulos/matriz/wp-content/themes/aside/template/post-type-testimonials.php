<?php
$testimonial_cite       = ux_get_post_meta(get_the_ID(), 'theme_meta_testimonial_cite');
$testimonial_position   = ux_get_post_meta(get_the_ID(), 'theme_meta_testimonial_position');
$testimonial_link_title = ux_get_post_meta(get_the_ID(), 'theme_meta_testimonial_link_title');
$testimonial_link       = ux_get_post_meta(get_the_ID(), 'theme_meta_testimonial_link'); ?>

<div class="entry">
    <div class="testimenials">
        <i class="m-quote-left"></i>
        <?php the_content();
        
        if($testimonial_cite){ ?>
            <div class="cite">
                <?php echo $testimonial_cite; ?>
                <span class="testimonial-position"><?php echo $testimonial_position; ?></span>
                <span class="testimonial-company"><a class="testimonial-link" href="<?php echo esc_url($testimonial_link); ?>"><?php echo $testimonial_link_title; ?></a></span>
            </div>
        <?php } ?>
        <div class="arrow-bg"><p class="arrow-wrap"><span class="arrow"></span></p></div>
    </div>
</div>