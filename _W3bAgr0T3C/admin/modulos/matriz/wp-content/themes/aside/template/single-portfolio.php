<?php //** get portfolio panel align
$portfolio_panel_align = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_portfolio_panel_align');


//** Gallery Style and sidebar class
$gallery_class = $portfolio_panel_align == 'fullwidth' ? 'gallery-wrap-fullwidth' : 'gallery-wrap-sidebar';
$sidebar_class = false;
$galleryimage_class = false;
switch($portfolio_panel_align){
	case 'right':     $sidebar_class = 'span4 pull-right'; $galleryimage_class ='span8'; break;
	case 'left':      $sidebar_class = 'span4'; $galleryimage_class ='span8'; break;
	case 'fullwidth': $sidebar_class = false; $galleryimage_class =false; break;
}

//** get portfolio list style
$portfolio_list_style = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_portfolio_list_style');
$crop = $portfolio_list_style == 'fit' ? 'false' : 'true' ;

//** get portfolio image
$portfolio = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio');

//** get portfolio dark style
//$portfolio_dark_style = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_portfolio_dark_style');
//$portfolio_dark_style = $portfolio_dark_style ? 'gallery-dark' : false; ?>

<div class="row-fluid gallery-wrap <?php echo $gallery_class; ?> <?php //echo $portfolio_dark_style; ?>">

<?php if($portfolio_panel_align != 'fullwidth'){ ?>

    <div class="gallery-info-wrap container <?php echo $sidebar_class; ?>">

        <?php ux_interface_title_bar(); ?>

        <?php //** portfolio property
        ux_interface_portfolio_property(); ?>

        <div class="entry"><?php the_content(); ?></div><!--end entry-->
        
    </div><!--end gallery-info-wrap -->

<?php } ?>

    <div class="gallery-images-wrap <?php echo $galleryimage_class; ?>">

        <div class="row-fluid ">
        
			<?php if($portfolio_panel_align == 'fullwidth'){ ?>
                
                <div class="clear gallery-post-wrap">

                <?php if( $portfolio_list_style!='vertical' && $portfolio_list_style!='masonry') { ?>
                    <div class="gallery-wrap-slider ">
                        <?php if($portfolio){ ?>
                            <div class="galleria" data-crop="<?php echo $crop; ?>" data-transition="fade" data-interval="5000">
                                <?php foreach($portfolio as $image){
                                    $image_full = wp_get_attachment_image_src($image, 'full'); ?>
                                    
                                    <img src="<?php echo $image_full[0]; ?>" title="<?php echo get_the_title($image); ?>" />
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>    
                <?php } ?>

                <div class="gallery-info-wrap container">
    
                    <?php ux_interface_title_bar(); ?>
    
                    <div class="row-fluid">
    
                        <div class="entry span9">
                            <?php the_content(); ?>
                        </div><!--end entry-->
    
                        <?php //** portfolio property
						ux_interface_portfolio_property(); ?>
                        
                    </div>
    
                </div><!--end gallery-info-wrap -->
            
            <?php
            }
            
            switch($portfolio_list_style){
                case 'vertical': ?>
                    <div class="gallery-wrap-slider clear gallery-post-wrap">
						<?php if($portfolio){ ?>
                            <div class="vertical-list">
                                <?php foreach($portfolio as $image){
                                    $image_full = wp_get_attachment_image_src($image, 'full'); ?>
                                    
                                    <img src="<?php echo $image_full[0]; ?>" title="<?php echo get_the_title($image); ?>" />
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
				<?php
				break;
				
				case 'masonry': ?>
                    <div class="container-isotope clear gallery-post-wrap">
                        <?php if($portfolio){ ?>
                            <div id="isotope-load" class="isotope-load" style="display: none;"></div>
                            <div class="isotope masonry isotope_fade" style="" data-size="large">
								<?php foreach($portfolio as $num => $image){
                                    $image_full = wp_get_attachment_image_src($image, 'full');
									$col_width = $num == 0 ? 'width4' : 'width2'; ?>
                                    
                                    <div class="<?php echo $col_width; ?> isotope-item" style="">
                                        <div style="margin:0;" class="inside">
                                            <div class="entry-thumb">
                                                <div class="single-image mouse-over">
                                                    <a rel="post-<?php the_ID(); ?>" title="<?php echo get_the_title($image); ?>" class="lightbox" href="<?php echo $image_full[0]; ?>">
                                                        <div class="single-image-mask"><i class="m-eye"></i></div>
                                                        <img src="<?php echo $image_full[0]; ?>" alt="<?php echo get_the_title($image); ?>" />
                                                    </a>
                                                </div><!--End single-image mouse-over-->
                                            </div><!--End entry-thumb-->
                                        </div><!--End inside-->
                                    </div><!--end isotope-item-->
                                <?php } ?>
                            </div>
                        <?php } ?>

                    </div>
				<?php
				break;
				
				default:
					$crop = $portfolio_list_style == 'fit' ? 'false' : 'true' ; ?>
                    
                    <?php if($portfolio_panel_align != 'fullwidth'){ ?>
                    <div class="gallery-wrap-slider clear gallery-post-wrap">
						<?php if($portfolio){ ?>
                            <div class="galleria" data-crop="<?php echo $crop; ?>" data-transition="fade" data-interval="5000">
                                <?php foreach($portfolio as $image){
                                    $image_full = wp_get_attachment_image_src($image, 'full'); ?>
                                    
                                    <img src="<?php echo $image_full[0]; ?>" title="<?php echo get_the_title($image); ?>" />
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php } ?>

				<?php
				break;
				
            } ?>
            
            <?php if($portfolio_panel_align == 'fullwidth'){ ?>
            
				</div>
                
            <?php } ?>
            
            <?php //** portfolio related
			ux_interface_portfolio_related(); 

            if(comments_open(get_the_ID())){ 
                echo '<div class="container comment-wrap">';
                comments_template();
                echo '</div>';
            } ?>
        
        </div><!--end row-fluid-->
    
    </div><!--end gallery-images-wrap -->

</div><!--end row-fluid gallery-wrap-->
