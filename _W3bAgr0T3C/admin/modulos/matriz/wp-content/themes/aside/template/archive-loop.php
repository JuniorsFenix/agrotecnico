<?php //** Do Hook Title Bar
do_action('ux_interface_title_bar'); ?>

<?php if(have_posts()){ ?>
    <div class="archive-wrap">
    
        <?php while(have_posts()){ the_post(); ?>
            <section class="archive-unit">
                <h1 class="archive-tit"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
                
                <div class="archive-excerpt">
                    <p><?php the_excerpt(); ?></p>
                </div><!--end archive-excerpt-->
                
                <div class="archive-meta">
                    <span class="archive-meta-unit date"><?php echo get_post_time('j,M,Y', true); ?></span>
                    <span class="archive-meta-unit category"><?php the_category(', '); ?></span>
                    <span class="archive-meta-unit tag"><?php the_tags('', ', '); ?></span>
                    <span class="archive-meta-unit author"><?php the_author(); ?></span>
                </div><!--end archive-meta-->
        
                <a href="<?php the_permalink(); ?>" class="archive-more"><i class="fa fa-long-arrow-right"></i> <?php _e('Read more', 'ux'); ?></a>
        
            </section>
		
		<?php }
		
		ux_interface_pagination(); ?>
    
    </div><!--end archive-wrap-->
<?php }else{ ?>

    <div class="archive-nopost"><?php _e('Sorry, no articles','ux');?> </div> 
    
<?php } ?>