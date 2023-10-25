<?php
$team_position      = ux_get_post_meta(get_the_ID(), 'theme_meta_team_position');
$team_email         = ux_get_post_meta(get_the_ID(), 'theme_meta_team_email');
$team_phone_number  = ux_get_post_meta(get_the_ID(), 'theme_meta_team_phone_number');
$team_social_medias = ux_get_post_meta(get_the_ID(), 'theme_meta_team_social_medias'); ?>

<div class="entry">
    <div class="team" style="position:relative;">
        <?php if(has_post_thumbnail()){
            echo get_the_post_thumbnail(get_the_ID(), array(360,9999), array('class'=>'team-photo'));
        } ?>
        <div class="team-info">
            <?php if($team_position){ ?>
                <p class="team-position"><?php echo __('POSITION:', 'ux'). ' ' .$team_position; ?></p>
            <?php }
            
            if($team_email){ ?>
                <p class="team-email"><?php echo __('EMAIL:', 'ux'). ' ' .$team_email; ?></p>
            <?php }
            
            if($team_phone_number){ ?>
                <p class="team-phone"><?php echo __('PHONE NUMBEr:', 'ux'). ' ' .$team_phone_number; ?></p>
            <?php } ?>
            
            <p class="team-content"><?php the_content(); ?></p>
            
        </div><!--end .team-info-->
    </div>
</div>