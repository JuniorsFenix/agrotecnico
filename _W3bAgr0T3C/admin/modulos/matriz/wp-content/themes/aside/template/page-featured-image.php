<?php
//** portfolio template -> template
//$template     = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_template');

//$post_thumbnail = get_the_post_thumbnail(get_the_ID(), 'full', array('data-title' => get_the_title(), 'alt' => ''));

//$image_right     = ux_get_post_meta(get_the_ID(), 'theme_meta_page_featured_right');
$image           = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 

?>

<article id="page-feaured-image-layout">	

	<div id="page-feaured-image-entry" class="pull-right">

		<div class="entry">

			<div id="title-bar" class="title-bar-wrap ">
    
			    <div id="title-wrap">
			        
			        <div class="title-wrap-inn">

			            <div id="main-title">
			                <h1 class="main-title">
								<?php the_title(); ?>              
			                </h1>
			            </div>
			                                                    
			        </div>

			    </div><!--End #title-wrap-->

			</div><!--End #title-bar-->
            
			<?php if(ux_enable_pb()){
				
				echo '<div class="pagebuilder-wrap">';
				do_action('ux-theme-single-pagebuilder');
				echo '</div>';
				
			}else{
				the_content();
			} ?>

    	</div><!--End entry-->

    </div><!--End page-feaured-image-entry-->

    <div id="featured-img-wrap" style="background-image:url(<?php echo $image[0]; ?>)"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" class="half-page-img" /></div>

</article>	