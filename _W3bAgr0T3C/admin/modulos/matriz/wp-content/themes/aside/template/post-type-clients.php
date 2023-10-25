<?php 
$client_link = ux_get_post_meta(get_the_ID(), 'theme_meta_client_link'); ?>

<div class="entry">
    <div class="client">
        <a title="<?php the_title(); ?>" href="<?php echo esc_url($client_link); ?>"><?php echo get_the_post_thumbnail(get_the_ID(), 'full');?></a>
        <?php the_title(); ?>
    </div>
</div>