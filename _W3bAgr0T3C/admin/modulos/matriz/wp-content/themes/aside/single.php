<?php get_header(); ?>

	<?php while(have_posts()){ the_post(); ?>
		
		<div id="main-wrap">
		
			<div id="main">
		
				<div id="content" class="<?php ux_interface_pb_class(); ?>">
		
					<?php //** Do Hook Single summary
					do_action('ux_interface_single_summary'); ?>
                    
                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						
						<?php //** Do Hook Single before
						do_action('ux_interface_single_before'); ?>
						
						<div id="content_wrap" class="<?php ux_interface_sidebar_class(); ?>">
							
						<?php //** Do Hook Single content
							do_action('ux_interface_single_content'); 
						?>

						</div><!--end content_wrap-->
						
						<?php //** Do Hook Sidebar Widget
						do_action('ux_interface_sidebar_widget');
						
						//** Do Hook Single after
						do_action('ux_interface_single_after'); ?>
		
					</div><!--end post id-->
		
				</div><!--end content-->
		
			</div><!--End #main-->
		
		</div><!--End #main-wrap-->
	
	<?php } ?>
	
<?php get_footer(); ?>