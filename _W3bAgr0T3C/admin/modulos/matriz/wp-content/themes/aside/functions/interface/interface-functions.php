<?php
/****************************************************************/
/*
/* Functions
/*
/****************************************************************/

//Function Web Title
function ux_interface_webtitle($title, $sep){
	global $paged, $page;

	if(is_feed() || is_search()){
		return $title;
	}

	$title .= get_bloginfo('name');

	$site_description = get_bloginfo('description', 'display');
	if($site_description &&(is_home() || is_front_page())){
		$title = "$title $sep $site_description";
	}

	if($paged >= 2 || $page >= 2){
		$title = "$title $sep " . sprintf(__('Page %s', 'ux'), max($paged, $page));
	}

	return $title;
}
add_filter('wp_title','ux_interface_webtitle',10, 2);

//Function Web Head Viewport
function ux_interface_webhead_viewport(){
	$enable_responsive = ux_get_option('theme_option_mobile_enable_responsive');
	
	if($enable_responsive){ ?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php
	}
}

//Function Web Head Favicon
function ux_interface_webhead_favicon(){
	$favicon_icon = ux_get_option('theme_option_custom_favicon');
	$mobile_icon  = ux_get_option('theme_option_mobile_icon');
	
	$favicon_icon = $favicon_icon ? $favicon_icon : UX_LOCAL_URL . '/img/favicon.ico';
	$mobile_icon  = $mobile_icon ? $mobile_icon : UX_LOCAL_URL . '/img/favicon.ico'; ?>
    
    <link rel="shortcut icon" href="<?php echo $favicon_icon; ?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $mobile_icon; ?>">
<?php
}

//Function Logo
function ux_interface_logo($key){
	$enable_text_logo   = ux_get_option('theme_option_enable_text_logo');
	$text_logo          = ux_get_option('theme_option_text_logo');
	$custom_logo        = ux_get_option('theme_option_custom_logo');
	$custom_logo        = $custom_logo ? $custom_logo : UX_LOCAL_URL . '/img/logo.png';
	$mobile_custom_logo = ux_get_option('theme_option_mobile_custom_logo');
	$mobile_custom_logo = $mobile_custom_logo ? $mobile_custom_logo : $custom_logo;
	
	$logo               = $key == 'mobile' ? $mobile_custom_logo : $custom_logo;
	$output             = '';
	
	switch($key){
		case 'mobile': 
			$output .= '<h1 id="logo-mobile"><a href="' . home_url() . '" title="' . get_bloginfo('name') . '">'; 
			$output .= $enable_text_logo ? $text_logo : '<img src="' . $logo . '" alt="' . get_bloginfo('name') . '" />';
			$output .= '</a></h1>';
		break;

		case 'page':   
			$output .= '<h1 id="logo-page"><a href="' . home_url() . '" title="' . get_bloginfo('name') . '">'; 
			$output .= $enable_text_logo ? $text_logo : '<img src="' . $logo . '" alt="' . get_bloginfo('name') . '" />';
			$output .= '</a></h1>';
		break;

		case 'loading':
			$output .= '<div class="site-loading-logo centered-ux">';
			$output .= $enable_text_logo ? $text_logo : '<img src="' . $logo . '" alt="' . get_bloginfo('name') . '" />';
			$output .= '</div>';
		break;

		default:       
			$output .= '<h1 id="logo"><a href="' . home_url() . '" title="' . get_bloginfo('name') . '">';
			$output .= $enable_text_logo ? $text_logo : '<img src="' . $logo . '" alt="' . get_bloginfo('name') . '" />';
			$output .= '</a></h1>';
		break;
	}

	
	echo $output;
}

//Function body class
function ux_interface_body_class(){
	$responsive       = ux_get_option('theme_option_mobile_enable_responsive') ? ' responsive-ux' : false;
	$nicescroll       = ux_get_option('theme_option_enable_nice_scroll') ? ' nicescroll-ux' : false;
	$full_line        = ux_get_option('theme_option_full_line') ? ' full-line' : ' boxed-line';
	$portfolio_layout = false;
	
	if(is_page()){
		$portfolio_layout = ux_enable_portfolio_template() ? 'page-portfolio-template-layout-ux' : false;
	}
	
	body_class($responsive . $nicescroll . $full_line . ' aside-layout-ux ' . $portfolio_layout);
}

//Function sidebar class
function ux_interface_sidebar_class(){
	$sidebar   = ux_get_post_meta(get_the_ID(), 'theme_meta_sidebar');
	$pb_switch = get_post_meta(get_the_ID(), 'ux-pb-switch', true);
	$output    = 'span8';
	
	if(is_singular('post') || is_page()){
		if(ux_enable_portfolio_template() || ux_enable_featured_image() || ux_enable_slider()){
			$output = false;
		}else{
			switch($sidebar){
				case 'right-sidebar':   $output = 'span8'; break;
				case 'left-sidebar':    $output = 'span8 pull-right'; break;
				case 'without-sidebar': $output = $pb_switch == 'pagebuilder' ? false : $output = 'container'; break;
			}
		}
	}
	
	echo $output;
}

//Function Space class
function ux_interface_space_class(){
	$output = false;
	
	//** Show Top Spacer
	$top_spacer    = ux_get_post_meta(get_the_ID(), 'theme_meta_show_top_spacer');
	$top_spacer    = $top_spacer ? 'top-space ' : false; 
	
	//** Show Bottom Spacer
	$bottom_spacer = ux_get_post_meta(get_the_ID(), 'theme_meta_show_bottom_spacer');
	$bottom_spacer = $bottom_spacer ? 'bottom-space ' : false;
	
	if(!ux_enable_portfolio_template() && !ux_enable_featured_image() && !ux_enable_slider()){
		$output .= $top_spacer . $bottom_spacer;
	}
	
	echo $output;
	
}

function ux_interface_pb_class(){
	$output = false;
	if(ux_enable_pb() && is_single()){
		$output = 'single-with-pagebuild ';
	}
	echo $output;
}

//Function Social
function ux_interface_social(){
	$social_medias = ux_get_option('theme_option_show_social_medias');
	if($social_medias && isset($social_medias['icontype'])){
		$icon_type = $social_medias['icontype']; ?>
		
		<!--Social icons-->
		<div class="social-icons-sidebar">
			<?php foreach($icon_type as $num => $type){
				$icon = $social_medias['icon'][$num];
				$url = $social_medias['url'][$num];
				$tip = $social_medias['tip'][$num];  ?>
				
				<a title="<?php echo $tip; ?>" href="<?php echo esc_url($url); ?>" class="icons-sidebar-unit">
					<?php if($type == 'fontawesome'){ ?>
						<i class="<?php echo $icon; ?>"></i>
					<?php }elseif($type == 'user'){ ?>
						<img src="<?php echo $icon; ?>" />
					<?php } ?>
				</a>
			<?php } ?>
		</div>
	<?php

	} //End if $social_medias
}

//Function Copyright
function ux_interface_copyright(){
	$footer_copyright = ux_get_option('theme_option_copyright');
	echo $footer_copyright = $footer_copyright ? $footer_copyright : 'Copyright uiueux.com';
}

//Function pagination
function ux_interface_pagination($pages = '', $range = 3){
	global $wp_query, $wp_rewrite;
	
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1; 
	
	echo '<div class="clearfix pagenums">';
	echo wp_kses_post(paginate_links( array(
		'base' => @add_query_arg('paged','%#%'),
		'format' => '',
		'current' => $current,
		'total' => $wp_query->max_num_pages,
		'mid_size' => $range
	))); 
	echo '</div>';
}

//Function Pagebuilder
function ux_interface_pagebuilder(){
	
	if(ux_enable_pb() && !ux_enable_portfolio_template() && !ux_enable_featured_image() && !ux_enable_slider()){
		if(post_password_required()){
		 	echo get_the_password_form();
		 	return;
		}else{
			echo '<div class="pagebuilder-wrap">';
			do_action('ux-theme-single-pagebuilder');
			echo '</div>';
		}	
	}
	
}

//Function Slider Contetnt
function ux_slider_content($slider=''){
	$ux_slider_value = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_slider');
	
	if($ux_slider_value){
		switch($slider){
			case 'revolution':
				echo do_shortcode('[rev_slider ' . $ux_slider_value . ']');
			break;
		}
	}
}

/****************************************************************/
/*
/* Condition
/*
/****************************************************************/

//Condition enable sidebar
function ux_enable_sidebar(){
	$sidebar = true;
	if(is_singular('post') || is_page()){
		$sidebar = ux_get_post_meta(get_the_ID(), 'theme_meta_sidebar');
		
		//** not portfolio template get sidebar template
		if(ux_enable_portfolio_template() || $sidebar == 'without-sidebar' || ux_enable_featured_image() || ux_enable_slider()){
			$sidebar = false;
		}
	}
	return $sidebar;
}

//Condition enable pagebuilder
function ux_enable_pb(){
	$switch = false;
	
	if(is_singular('post') || is_page()){
		$pb_switch = get_post_meta(get_the_ID(), 'ux-pb-switch', true);
		
		if($pb_switch == 'pagebuilder'){
			$switch = true;
		}
	}
	
	return $switch;
	
}

//Condition enable portfolio template
function ux_enable_portfolio_template(){
	$switch = false;
	
	if(is_singular('post')){
		//** get portfolio template meta
		$portfolio_template_enble = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_portfolio_template');
		
		if($portfolio_template_enble ){
			$switch = true;
		}
	}

	if(is_page()){
		//** get portfolio template meta
		$portfolio_template_enble = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_portfolio_template');
		$portfolio_template       = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_template');
		
		if( $portfolio_template_enble && $portfolio_template == 'fullscreen_post_slider' ){
			$switch = true;
		}
	}
	return $switch;
	
}

//Condition enable feaured image layout
function ux_enable_featured_image(){
	$switch = false;
	
	if(is_page()){
		//** get   meta
		$featured_image = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_template');
		$papge_template_enble = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_portfolio_template');
		if($featured_image == 'show_featured_image' && $papge_template_enble ){
			$switch = true;
		}
	}
	
	return $switch;
	
}

//Condition enable enble slider
function ux_enable_slider(){
	$switch = false;
	
	if(is_page()){
		//** get   meta
		$slider = ux_get_post_meta(get_the_ID(), 'theme_meta_page_portfolio_template');
		$papge_template_enble = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_portfolio_template');
		
		if( $slider == 'show_slider' && $papge_template_enble ){
			$switch = true;
		}
	}
	
	return $switch;
	
}

/****************************************************************/
/*
/* Template
/*
/****************************************************************/

//Template Mobile Meta
function ux_interface_mobilemeta(){
	ux_get_template_part('mobile', 'meta');
}

//Template Sidebar
function ux_interface_sidebar(){
	get_sidebar();
}

//Template Sidebar Weiget
function ux_interface_sidebar_widget(){
	ux_get_template_part('sidebar', 'widget');
}

//Template Header
function ux_interface_header(){
	//if(is_singular('post') || is_page()){
		//$topbar_for_pages = ux_get_option('theme_option_enable_floating_topbar_for_pages');
		//$topbar_for_posts = ux_get_option('theme_option_enable_floating_topbar_for_posts');
	
		//if($topbar_for_pages || $topbar_for_posts){
			ux_get_template_part('header', 'wrap');
		//}
	//}
}

//Template Archive loop
function ux_interface_archive_loop(){
	ux_get_template_part('archive', 'loop');
}

//Template Title bar
function ux_interface_title_bar(){
	ux_get_template_part('title', 'bar');
}

//Template Title bar for page
function ux_interface_page_title_bar(){
	if(!ux_enable_portfolio_template()){
		if(is_page()){
			//** Show Title Bar
			$show_title_bar     = ux_get_post_meta(get_the_ID(), 'theme_meta_show_title_bar');
			$portfolio_template_enble = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_portfolio_template');
			
			if($show_title_bar && !$portfolio_template_enble){
				ux_interface_title_bar();
			}
		}elseif(is_single()){
			
			if(!ux_enable_portfolio_template()){
				ux_interface_title_bar();
			}
		}
	}
}

//Template Page portfolio
function ux_interface_page_portfolio(){
	if(ux_enable_portfolio_template()){
		ux_get_template_part('page', 'portfolio');
	}
}

//Template Page featured image 
function ux_interface_page_featured_image(){
	if(ux_enable_featured_image()){
		ux_get_template_part('page', 'featured-image');
	}
}

//Template Page slider
function ux_interface_page_enable_slider(){
	if(ux_enable_slider()){
		ux_get_template_part('page', 'show-slider');; 
	}
}

//Template page content
function ux_interface_page_content(){
	if(!ux_enable_pb() && !ux_enable_portfolio_template() && !ux_enable_featured_image() && !ux_enable_slider() ){ ?>
        
        <div class="entry">
			<?php the_content(); ?>
        </div><!--End entry--> 
    <?php
	}
}

//Template Single portfolio
function ux_interface_single_portfolio(){
	if(ux_enable_portfolio_template()){
		ux_get_template_part('single', 'portfolio');
	}
}

//Template Single content
function ux_interface_single_comment(){
	if(!ux_enable_portfolio_template()){
		//** comment before if enable pb set class container
		if(ux_enable_pb() && !ux_enable_sidebar()){
			echo '<div class="container">';
		}
		
		if(comments_open(get_the_ID())){
			comments_template();
		}
		
		//** comment after if enable pb set class container end
		if(ux_enable_pb() && !ux_enable_sidebar()){
			echo '</div>';
		}
	}
}

//Template Single content
function ux_interface_single_content(){
	if(!ux_enable_pb() && !ux_enable_portfolio_template()){
		$post_format = !get_post_format() ? 'standard' : get_post_format();
		
		//** post format
		if(is_singular('post') && $post_format != 'video'){
			ux_get_template_part('post-format', $post_format);
		}

		if(is_singular('post') && $post_format = 'video'){
			echo '<div class="entry">';
			the_content(); wp_link_pages();
			echo '</div>';
		}	
		
		//** post type for clients, faqs, jobs, team, testimonials
		if(!is_singular('post')){
			if( get_post_type() =='faqs' || get_post_type() =='testimonials' || get_post_type() =='jobs' || get_post_type() =='clients' || get_post_type() =='team' ) {
				ux_get_template_part('post-type', get_post_type());
			} else { ?>
				<div class="entry"><?php the_content(); ?></div>
			<?php }
			
			 
		}
	}
}

//Template Single Format Video
function ux_interface_single_format_video(){
	if(!ux_enable_pb()){
		$post_format = !get_post_format() ? 'standard' : get_post_format();
		//** post format
		if(is_singular('post') && $post_format == 'video'){
			ux_get_template_part('post-format', $post_format);
		}
	}
}

//Template Single Portfolio Property
function ux_interface_portfolio_property(){
	ux_get_template_part('single', 'portfolio-property');
}

//Template Single Portfolio Related Post
function ux_interface_portfolio_related(){
	//** get portfolio related
	$related = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_portfolio_related');
	if($related){
		ux_get_template_part('single', 'portfolio-related');
	}
}

//Template Page Before
function ux_interface_page_before(){
	ux_get_template_part('page', 'before');
}

//Template Page After
function ux_interface_page_after(){
	ux_get_template_part('page', 'after');
}

//Template Top image
function ux_interface_top_image(){
	ux_get_template_part('top', 'image');
}

//Template Site Loading
function ux_interface_site_loading(){
	ux_get_template_part('site', 'loading');
}

//Template Page Loading
function ux_interface_page_loading(){
	ux_get_template_part('page', 'loading');
}

?>