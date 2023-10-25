<?php get_header(); ?>

	<?php while(have_posts()){ the_post();
		
		//** Show Logo on Content Area
		$content_logo = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio_logo_on_content_area'); ?>
			
			<div id="main">
		
				<div id="content">
		
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						
						<?php //** Do Hook Page before
						do_action('ux_interface_page_before'); ?>
						
						<div id="content_wrap" class="<?php ux_interface_sidebar_class(); ?>">
							
							<div class="content-wrap-inn <?php ux_interface_space_class(); ?>">
							<?php //** Do Hook Page content
							do_action('ux_interface_page_content'); ?>
							</div><!--End content-wrap-inn-->
		
						</div><!--end content_wrap-->
						
						<?php //** Do Hook Sidebar Widget
						do_action('ux_interface_sidebar_widget');
						
						//** Do Hook Page after
						do_action('ux_interface_page_after'); ?>
		
					</div><!--end row-fluid-->
		
				</div><!--end content-->
		
			</div><!--End #main-->
	
	<?php } ?>
	<script type="text/javascript" src="../iframeResizer.contentWindow.min.js"></script>
<?php get_footer(); ?>