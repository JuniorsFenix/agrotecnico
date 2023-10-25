<?php
//** portfolio template -> template
$template     = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_template');

//** portfolio template -> Category
$category     = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_category');

//** portfolio template -> Order By
$orderby      = ux_get_post_meta(get_the_ID(), 'theme_meta_orderby');
$order        = ux_get_post_meta(get_the_ID(), 'theme_meta_order');

//** portfolio template -> Number To Show
$number       = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio_number');
$number       = $number ? $number : 6;

//** portfolio template -> Navigation Button Align
$button_align = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_navigation_button_align');
$button_align = $button_align == 'lower_right' ? 'page-portfolio-navi-bottom' : 'page-portfolio-navi-top';

//** portfolio template -> Transition
$transition   = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_transition');

//** portfolio template -> Interval time(ms)
$time         = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_time');
$time         = $time ? $time : '5000';

//** portfolio template -> Fill
$fill         = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_fill');
$fill         = $fill ? 'true' : 'false';

//** portfolio template -> Border
$border       = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_border');
$border       = $border ? 'true' : 'false';

//** portfolio template ->  link
$withlink     = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_withlink');

//** portfolio template ->  title
$withtitle     = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_withtitle');

//get posts
$get_post = get_posts(array(
	'posts_per_page' => $number,
	'cat'            => $category,
	'orderby'        => $orderby,
	'order'          => $order

));

if($get_post){
	global $post; ?>

    <div class="page-portfolio-template <?php echo $button_align; ?>">
    
        <div class="galleria <?php if($border =='true') { echo 'bordered'; } ?>" data-crop="<?php echo $fill; ?>" data-transition="<?php echo $transition; ?>" data-interval="<?php echo $time; ?>">
            <?php foreach($get_post as $post){ setup_postdata($post);
				$post_format = !get_post_format() ? 'standard' : get_post_format();
				$post_url = $withlink ? $post_url = get_permalink() : false;
				$post_title = $withtitle ? $post_title = get_the_title() : false;
				$post_thumbnail = get_the_post_thumbnail(get_the_ID(), 'full', array('data-link'=> $post_url, 'data-title' => $post_title, 'alt' => ''));
				switch($post_format){
					case 'video':
						$video_embeded = ux_get_post_meta(get_the_ID(), 'theme_meta_video_embeded_code');
						if(strstr($video_embeded, "youtu") && !(strstr($video_embeded, "iframe"))){
							echo '<a href="' . $video_embeded . '">' . $post_thumbnail . '</a>';
						}elseif(strstr($video_embeded, "vimeo") && !(strstr($video_embeded, "iframe"))){
							echo '<a href="' . $video_embeded . '">' . $post_thumbnail . '</a>';
						}
						
					break;
					
					default:
						echo $post_thumbnail;
					break;
				}
			}
			wp_reset_postdata(); ?>
            
        </div>
    
    </div><!--end page-portfolio-template-->

<?php } ?>	