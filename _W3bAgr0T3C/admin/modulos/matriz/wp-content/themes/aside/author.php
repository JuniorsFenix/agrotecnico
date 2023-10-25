<?php get_header(); ?>
        
	<?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    ?>
   
    <div id="main-wrap">
    
        <div id="main">
    
            <div class="container archive-wrap-outer author-outer" id="content">
        
        
                <header class="author-header">
                    <div class="author-thumbs"><?php echo get_avatar( $curauth->user_email, 120 ); ?></div>
                    <h2><?php _e('Posts from','ux'); ?> <?php echo $curauth->nickname; ?>:</h2>
                </header>
        
                <div class="archive-wrap">
        
                    <?php get_template_part('archive', 'list'); ?>
        
                </div><!--End archive-wrap-->
        
            </div>
    
        </div><!--End #main-->
    
    </div><!--End #main-wrap-->
  
<?php get_footer(); ?>