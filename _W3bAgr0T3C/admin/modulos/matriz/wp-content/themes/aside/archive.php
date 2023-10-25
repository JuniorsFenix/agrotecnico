<?php get_header(); ?>
   
    <div id="main-wrap">
    
        <div id="main">
    
            <div id="content" class="archive-wrap-outer">
    
                <div class="row-fluid two-cols-layout">
    
                    <div id="content_wrap" class="span8">
                    
                        <?php //** Do Hook Archive loop
						do_action('ux_interface_archive_loop'); ?>
    
                    </div><!--end content_wrap-->
                    
                    <?php //** Do Hook Sidebar Widget
					do_action('ux_interface_sidebar_widget'); ?>
    
                </div><!--end row-fluid-->
    
            </div><!--end content-->
    
        </div><!--End #main-->
    
    </div><!--End #main-wrap-->
  
<?php get_footer(); ?>