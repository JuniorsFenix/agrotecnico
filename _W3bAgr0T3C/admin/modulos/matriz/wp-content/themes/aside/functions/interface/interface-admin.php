<?php
define('UX_LOCAL_URL', get_template_directory_uri());

//UX Theme Text Domain 
if(!function_exists('ux_theme_lang_setup')){
	add_action('after_setup_theme', 'ux_theme_lang_setup');
	function ux_theme_lang_setup(){
		$lang = get_template_directory()  . '/languages';
		load_theme_textdomain('ux', $lang);
	}
}

//UX Theme Get Template
function ux_get_template_part($key, $name){
	get_template_part('template/' . $key, $name);
}



//theme interface post meta
function ux_post_meta($key){
	$post_id = false;
	$post_type = false;
	
	if(is_page() || is_singular('post')){
		$post_id = get_the_ID();
		$post_type = get_post_type($post_id);
	}
	
	switch($key){
		case 'title-bar-height':
			$ux_title_bar_height = ux_get_post_meta($post_id, 'theme_meta_title_bar_height');
			if(!$post_id){
				$ux_title_bar_height = 'header-bg-height-1';
			}
			echo $ux_title_bar_height;
		break;
		
		case 'title-bar-color':
			$ux_bg_color = ux_get_post_meta($post_id, 'theme_meta_bg_color');
			$ux_bg_page_title_bar = ux_get_option('theme_option_bg_page_title_bar');
			$ux_bg_color = $ux_bg_color ? ux_theme_switch_color($ux_bg_color, 'rgb') . ';' : $ux_bg_page_title_bar;
			echo 'background-color:' . $ux_bg_color . ';';
		break;
		
		case 'title-bar-page-title':
			$ux_title_bar_page_title = ux_get_post_meta($post_id, 'theme_meta_title_bar_page_title');
			if(!$post_id){
				$ux_title_bar_page_title = true;
			}
			return $ux_title_bar_page_title;
		break;
		
		case 'title-bar-expert':
			$ux_title_bar_expert = ux_get_post_meta($post_id, 'theme_meta_title_bar_expert');
			if(!$post_id){
				$ux_title_bar_expert = true;
				if(is_singular('product')){
					$ux_title_bar_expert = false;
				}
			}
			return $ux_title_bar_expert;
		break;
		
		case 'title-bar-breadcrumbs':
			$ux_show_breadcrumb = ux_get_post_meta($post_id, 'theme_meta_title_bar_breadcrumb');
			if(!$post_id){
				$ux_show_breadcrumb = true;
			}
			return $ux_show_breadcrumb;
		break;
		
		case 'title-bar-featured-image':
			$ux_show_featured_image = ux_get_post_meta($post_id, 'theme_meta_use_featured_image_as_bg_image');
			$ux_show_slider = ux_get_post_meta($post_id, 'theme_meta_title_bar_slider');
			if(!$post_id){
				$ux_show_featured_image = false;
			}else{
				if(!$ux_show_slider && $ux_show_featured_image){
					$post_thumbnail_id = get_post_thumbnail_id($post_id);
					$post_thumbnail = wp_get_attachment_image_src($post_thumbnail_id, 'full'); 
					echo (has_post_thumbnail($post_id)) ? 'background-image:url(' . $post_thumbnail[0] . '); background-repeat:no-repeat; background-size:cover;' : false;
				}
			}
		break;
		
		case 'title-bar-slider':
			$ux_show_slider = ux_get_post_meta($post_id, 'theme_meta_title_bar_slider');
			if($post_id){
				return ($ux_show_slider) ? 'header-bg-slider' : false;
			}
		break;
		
		case 'header-bg-switch':
			$ux_show_title_bar = ux_get_post_meta($post_id, 'theme_meta_show_title_bar');
			if(!$post_id){
				$ux_show_title_bar = true;
			}
			return $ux_show_title_bar;
		break;
		
		case 'show-postmeta':
			$ux_show_postmeta = ux_get_post_meta($post_id, 'theme_meta_showmeta');
			if(is_array($ux_show_postmeta)){
				$ux_show_postmeta = (in_array('meta', $ux_show_postmeta)) ? true : false;
			}
			if($post_id){
				return $ux_show_postmeta;
			}
		break;
		
		case 'show-top-spacer':
			$ux_show_top_spacer = ux_get_post_meta($post_id, 'theme_meta_show_top_spacer');
			if($post_id){
				if($ux_show_top_spacer){
					echo ' top-space';
				}
			}
		break;
		
		case 'show-bottom-spacer':
			$ux_show_bottom_spacer = ux_get_post_meta($post_id, 'theme_meta_show_bottom_spacer');
			if($post_id){
				if(!$ux_show_bottom_spacer){
					echo 'style="margin-top: 0px;"';
				}
			}
		break;
		
		case 'slider-content':
			$ux_slider_name = ux_get_post_meta($post_id, 'theme_meta_title_bar_slider_name');
			$ux_slider_value = ux_get_post_meta($post_id, 'theme_meta_title_bar_slider_value');
			switch($ux_slider_name){
				case 'zoomslider':
					if(function_exists('ux_theme_zoomslider')){
						ux_theme_zoomslider($ux_slider_value);
					}
				break;
				
				case 'layerslider':
					echo do_shortcode('[layerslider id="' . $ux_slider_value . '"]');
				break;
				
				case 'revolutionslider':
					echo do_shortcode('[rev_slider ' . $ux_slider_value . ']');
				break;
			}
			
		break;
	}
}

//theme interface get post meta
function ux_get_post_meta($post_id, $key){
	$get_post_meta = get_post_meta($post_id, 'ux_theme_meta', true);
	$return = false;
	
	if($get_post_meta){
		if(isset($get_post_meta[$key])){
			if($get_post_meta[$key] != ''){
				switch($get_post_meta[$key]){
					case 'true': $return = true; break;
					case 'false': $return = false; break;
					default: $return = $get_post_meta[$key]; break;
				}
			}
		}
	}else{
		$return = ux_theme_post_meta_default($key);
	}
	
	return $return;
}

//theme interface option
function ux_option($key){
	$post_id = false;
	if(is_page() || is_singular('post')){
		$post_id = get_the_ID();
	}
	
	switch($key){
		
		case 'header-layout':
			$ux_header_layout = ux_get_option('theme_option_header_layout');
			if($ux_header_layout){
				switch($ux_header_layout){
					case 'logo_center': echo 'header-centered'; break; 
				}
			}
  
		break;
		
		case 'dock-effect':
			$ux_header_dock = ux_get_option('theme_option_enable_header_dock')  ? ux_get_option('theme_option_enable_header_dock')  : true;
			if($ux_header_dock){
				echo 'data-dock="true" class="scrolled-yes clearfix"';
			}else{
				echo 'data-dock="false" class="clearfix"';
			}
		break;
			
		case 'post-next-prev':
			$ux_show_next_prev = ux_get_option('theme_option_show_next_prev');
			if($post_id){
				return $ux_show_next_prev;
			}
		break;
		
		case 'post-share':
			$ux_show_share = ux_get_option('theme_option_show_share_button');
			if($post_id){
				return $ux_show_share;
			}
		break;
		
		case 'track-code':
			$ux_track_code = ux_get_option('theme_option_track_code');
			echo stripslashes($ux_track_code);
		break;
		
		case 'footer-logo':
			$ux_custom_foot_logo = ux_get_option('theme_option_custom_foot_logo'); 
			$foot_logo = $ux_custom_foot_logo ? $ux_custom_foot_logo : UX_LOCAL_URL.'/img/logo-foot.png';
			?>
            <a href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo('name'); ?>">
				<?php if($foot_logo){ ?>
					<img src="<?php echo $foot_logo; ?>" alt="<?php echo get_bloginfo('name'); ?>" />
                <?php } ?>
            </a>
        <?php
		break;
		
		case 'footer-style':
			$ux_footer_layout = ux_get_option('theme_option_footer_layout') ? ux_get_option('theme_option_footer_layout') : 'logo_and_copyright';
			switch($ux_footer_layout){
				case 'centered_copyright': echo 'class="footer-style1"'; break;
				case 'logo_and_copyright': echo 'class="footer-style2"'; break;
				case 'logo_and_submenu': echo 'class="footer-style3"'; break;
				case 'copyright_and_submenu': echo 'class="footer-style4"'; break;
				case 'centered_submenu': echo 'class="footer-style5"'; break;
			}
		break;
		
	}
}

//theme interface get option
function ux_get_option($key){
	$get_option = get_option('ux_theme_option');
	$return = false;
	
	if($get_option){
		if(isset($get_option[$key])){
			if($get_option[$key] != ''){
				switch($get_option[$key]){
					case 'true': $return = true; break;
					case 'false': $return = false; break;
					default: $return = $get_option[$key]; break;
				}
			}
		}else{
			switch($key){
				case 'theme_option_enable_fadein_effect': $return = true; break;
				case 'theme_option_enable_search_field': $return = true; break;
				case 'theme_option_enable_meta_post_page': $return = true; break;
				case 'theme_option_posts_showmeta': $return = array('date', 'tag', 'author', 'category'); break;
				case 'theme_option_mobile_enable_responsive': $return = true; break;
			}
		}
	}else{
		$return = ux_theme_option_default($key);
		
		switch($key){
			case 'theme_option_enable_fadein_effect': $return = true; break;
			case 'theme_option_enable_search_field': $return = true; break;
			case 'theme_option_enable_meta_post_page': $return = true; break;
			case 'theme_option_posts_showmeta': $return = array('date', 'tag', 'author', 'category'); break;
			case 'theme_option_mobile_enable_responsive': $return = true; break;
		}
	}
	
	return $return;
}

//theme front scripts
function ux_front_enqueue_scripts(){
	global $wp_styles;
	
	//** if is portfolio template for post/page 
	if(is_single() || is_page()){
		if(ux_enable_portfolio_template()){
			
			//script
			wp_enqueue_script('ux-interface-galleria');
			wp_enqueue_script('ux-interface-galleria-classic');
			
			//style
			wp_enqueue_style('ux-interface-galleria-classic');
		}
	}
	
	wp_enqueue_style('ux-interface-bootstrap');
	wp_enqueue_style('font-awesome');
	wp_enqueue_style('ux-lightbox-default');
	wp_enqueue_style('ux-interface-pagebuild');
	wp_enqueue_style('ux-interface-style');
	wp_enqueue_style('ux-googlefont-rotobo');
	wp_enqueue_style('ux-googlefont-playfair');
	wp_enqueue_style('ux-interface-theme-style');
	wp_enqueue_style('custom-css');
	wp_enqueue_script('ux-interface-bootstrap');
	wp_enqueue_script('ux-lightbox');
	wp_enqueue_script('ux-interface-waypoints');
	wp_enqueue_script('ux-interface-flexslider');
	wp_enqueue_script('ux-interface-jplayer');
	if(ux_has_module('progress-bar')){
		wp_enqueue_script('ux-interface-infographic');
	}
	if(ux_has_module('count-down')){
		wp_enqueue_script('ux-interface-countdown');
	}
	
	if(is_single()){
		wp_enqueue_script('comment-reply');
	}
	wp_enqueue_script('ux-interface-main');
	if(ux_has_module('portfolio')){
		wp_enqueue_script('ux-interface-gray');
	}	
	wp_enqueue_script('ux-interface-theme-isotope');
	wp_enqueue_script('ux-interface-theme');
	
	if(ux_has_module('google-map')){
		wp_enqueue_script('ux-interface-googlemap');
	}
	
}
add_action('wp_enqueue_scripts', 'ux_front_enqueue_scripts',101);

//theme google font family
function ux_theme_options_enqueue_googlefonts(){
	$get_option = get_option('ux_theme_option'); 
	$fonts_data = array();
	
	$main_font = false;
	if(isset($get_option['theme_option_font_family_main'])){
		$main_font = $get_option['theme_option_font_family_main'];
		array_push($fonts_data, $main_font);
	}
	
	$heading_font = false;
	if(isset($get_option['theme_option_font_family_heading'])){
		$heading_font = $get_option['theme_option_font_family_heading'];
		array_push($fonts_data, $heading_font);
	}
	
	$logo_font = false;
	if(isset($get_option['theme_option_font_family_logo'])){
		$logo_font = $get_option['theme_option_font_family_logo'];
		array_push($fonts_data, $logo_font);
	}
	
	$menu_font = false;
	if(isset($get_option['theme_option_font_family_menu'])){
		$menu_font = $get_option['theme_option_font_family_menu'];
		array_push($fonts_data, $menu_font);
	}
	
	$fonts_data = array_unique($fonts_data);
	if(count($fonts_data)){
		foreach($fonts_data as $font){
			if($font != -1){
				wp_enqueue_style('google-fonts-' . $font);
			}
		}
	}
}
add_action('wp_enqueue_scripts','ux_theme_options_enqueue_googlefonts');

//theme front scripts for ie
function ux_theme_head(){ ?>
	<script type="text/javascript">
	var JS_PATH = "<?php echo UX_LOCAL_URL.'/js';?>";
    </script>
    
    <!-- IE hack -->
    <!--[if lte IE 9]>
	<link rel='stylesheet' id='cssie'  href='<?php echo UX_LOCAL_URL; ?>/styles/ie.css' type='text/css' media='screen' />
	<![endif]-->

	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo UX_LOCAL_URL; ?>/js/ie.js"></script>
	<link rel='stylesheet' id='cssie8'  href='<?php echo UX_LOCAL_URL; ?>/styles/ie8.css' type='text/css' media='screen' />
	<![endif]-->
	
	<!--[if lte IE 7]>
	<div style="width: 100%;" class="messagebox_orange">Your browser is obsolete and does not support this webpage. Please use newer version of your browser or visit <a href="http://www.ie6countdown.com/" target="_new">Internet Explorer 6 countdown page</a>  for more information. </div>
	<![endif]-->
	
    
    <noscript>
		<style>
            .mask-hover-caption{ top: 0px;left: -100%; -webkit-transition: all 0.3s ease; -moz-transition: all 0.3s ease-in-out; -o-transition: all 0.3s ease-in-out; -ms-transition: all 0.3s ease-in-out; transition: all 0.3s ease-in-out; }
            .mask-hover-inn:hover .mask-hover-caption { left: 0px; }
        </style>
    </noscript>
	<!---->
<?php	
}
add_action('wp_head', 'ux_theme_head');

//theme footer
function ux_theme_footer(){
	ux_option('track-code');
}
add_action('wp_footer', 'ux_theme_footer', 20);

//ux theme post title
function ux_theme_post_title(){
	get_template_part('post', 'title');
}
add_action('ux_theme_page_title', 'ux_theme_post_title', 10);


//ux theme post content
function ux_theme_page_content(){ ?>
	<div class="entry">
		<?php the_content(); ?>
	</div><!--End entry--> 
<?php
}
add_action('ux_theme_page_content', 'ux_theme_page_content', 10);

//Theme Language Flags

function language_flags(){
	if (function_exists('icl_get_languages')) {
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		if(!empty($languages)){
			
				echo '<div class="wpml-translation">';
				echo '<ul class="wpml-language-flags clearfix">';
				foreach($languages as $l){
					echo '<li>';
					if($l['country_flag_url']){
						if(!$l['active']) {
							echo '<a href="'.$l['url'].'"><img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" /></a>';
						} else {
							echo '<div class="current-language"><img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" /></div>';
						}
					}
					echo '</li>';
				}
				echo '</ul>';
				echo '</div><!--End header-translation-->';
			
		}
	} else {
		echo "<p class='wpml-tip'>". __('WPML not installed and activated.','ux') ."</p>";
	}
}

//require theme interface register
require_once locate_template('/functions/interface/interface-register.php');

//require theme interface hook
require_once locate_template('/functions/interface/interface-functions.php');

//require theme interface hook
require_once locate_template('/functions/interface/interface-hook.php');

?>