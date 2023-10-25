<?php
//theme icons


function ux_theme_icons_fields(){

// Fontawesome icons list
$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
$fontawesome_path =  get_template_directory().'/functions/theme/css/font-awesome.min.css';
if( file_exists( $fontawesome_path ) ) {
	if(!class_exists('WP_Filesystem_Direct')){
		require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php');
		require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php');
	}
	$wp_filesystem = new WP_Filesystem_Direct('');
	@$subject = $wp_filesystem->get_contents($fontawesome_path);
}

preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

$icons = array();

foreach($matches as $match){
	array_push($icons, 'fa ' . $match[1]);
}

return $icons;
}

//theme color
function ux_theme_color(){
	$theme_color = array(
		array('id' => 'color1', 'value' => 'theme-color-1', 'rgb' => '#ee7164'),
		array('id' => 'color2', 'value' => 'theme-color-2', 'rgb' => '#be9ecd'),
		array('id' => 'color3', 'value' => 'theme-color-3', 'rgb' => '#f67bb5'),
		array('id' => 'color4', 'value' => 'theme-color-4', 'rgb' => '#77c9e1'),
		array('id' => 'color5', 'value' => 'theme-color-5', 'rgb' => '#5a6b7f'),
		array('id' => 'color6', 'value' => 'theme-color-6', 'rgb' => '#b8b69d'),
		array('id' => 'color7', 'value' => 'theme-color-7', 'rgb' => '#34bc99'),
		array('id' => 'color8', 'value' => 'theme-color-8', 'rgb' => '#e8b900'),
		array('id' => 'color9', 'value' => 'theme-color-9', 'rgb' => '#ce671e'),
		array('id' => 'color10', 'value' => 'theme-color-10', 'rgb' => '#454545')
	);	
	return $theme_color;
}

//theme config social networks
function ux_theme_social_networks(){
	$theme_config_social_networks = array(
		array(
			'name' => __('Facebook','ux'),
			'icon' => 'fa fa-facebook-square',
			'icon2' => 'fa fa-facebook-square',
			'slug' => 'facebook',
			'dec'  => __('Visit Facebook page','ux')
		),
		array(
			'name' => __('Twitter','ux'),
			'icon' => 'fa fa-twitter-square',
			'icon2' => 'fa fa-twitter-square',
			'slug' => 'twitter',
			'dec'  => __('Visit Twitter page','ux')
		),
		array(
			'name' => __('Google+','ux'),
			'icon' => 'fa fa-google-plus-square',
			'icon2' => 'fa fa-google-plus-square',
			'slug' => 'googleplus',
			'dec'  => __('Visit Google Plus page','ux')
		),
		array(
			'name' => __('Youtube','ux'),
			'icon' => 'fa fa-youtube-square',
			'icon2' => 'fa fa-youtube-square',
			'slug' => 'youtube',
			'dec'  => __('Visit Youtube page','ux')
		),
		array(
			'name' => __('Vimeo','ux'),
			'icon' => 'fa fa-vimeo-square',
			'icon2' => 'fa fa-vimeo-square',
			'slug' => 'vimeo',
			'dec'  => __('Visit Vimeo page','ux')
		),
		array(
			'name' => __('Tumblr','ux'),
			'icon' => 'fa fa-tumblr-square',
			'icon2' => 'fa fa-tumblr-square',
			'slug' => 'tumblr',
			'dec'  => __('Visit Tumblr page','ux')
		),
		array(
			'name' => __('RSS','ux'),
			'icon' => 'fa fa-rss-square',
			'icon2' => 'fa fa-rss-square',
			'slug' => 'rss',
			'dec'  => __('Visit Rss','ux')
		),
		array(
			'name' => __('Pinterest','ux'),
			'icon' => 'fa fa-pinterest-square',
			'icon2' => 'fa fa-pinterest-square',
			'slug' => 'pinterest',
			'dec'  => __('Visit Pinterest page','ux')
		),
		array(
			'name' => __('Linkedin','ux'),
			'icon' => 'fa fa-linkedin-square',
			'icon2' => 'fa fa-linkedinn-square',
			'slug' => 'linkedin',
			'dec'  => __('Visit Linkedin page','ux')
		),
		array(
			'name' => __('Instagram','ux'),
			'icon' => 'fa fa-instagram',
			'icon2' => 'fa fa-instagram',
			'slug' => 'instagram',
			'dec'  => __('Visit Instagram page','ux')
		),
		array(
			'name' => __('Github','ux'),
			'icon' => 'fa fa-github-square',
			'icon2' => 'fa fa-github-square',
			'slug' => 'github',
			'dec'  => __('Visit Github page','ux')
		),
		array(
			'name' => __('Xing','ux'),
			'icon' => 'fa fa-xing-square',
			'icon2' => 'fa fa-xing-square',
			'slug' => 'xing',
			'dec'  => __('Visit Xing page','ux')
		),
		array(
			'name' => __('Flickr','ux'),
			'icon' => 'fa fa-flickr',
			'icon2' => 'fa fa-flickr',
			'slug' => 'flickr',
			'dec'  => __('Visit Flickr page','ux')
		),
		array(
			'name' => __('VK','ux'),
			'icon' => 'fa fa-vk square-radiu',
			'icon2' => 'fa fa-vk square-radiu',
			'slug' => 'vk',
			'dec'  => __('Visit VK page','ux')
		),
		array(
			'name' => __('Weibo','ux'),
			'icon' => 'fa fa-weibo square-radiu',
			'icon2' => 'fa fa-weibo square-radiu',
			'slug' => 'weibo',
			'dec'  => __('Visit Weibo page','ux')
		),
		array(
			'name' => __('Renren','ux'),
			'icon' => 'fa fa-renren square-radiu',
			'icon2' => 'fa fa-renren square-radiu',
			'slug' => 'renren',
			'dec'  => __('Visit Renren page','ux')
		),
		array(
			'name' => __('Bitbucket','ux'),
			'icon' => 'fa fa-bitbucket-square',
			'icon2' => 'fa fa-bitbucket-square',
			'slug' => 'bitbucket',
			'dec'  => __('Visit Bitbucket page','ux')
		),
		array(
			'name' => __('Foursquare','ux'),
			'icon' => 'fa fa-foursquare square-radiu',
			'icon2' => 'fa fa-foursquare square-radiu',
			'slug' => 'foursquare',
			'dec'  => __('Visit Foursquare page','ux')
		),
		array(
			'name' => __('Skype','ux'),
			'icon' => 'fa fa-skype square-radiu',
			'icon2' => 'fa fa-skype square-radiu',
			'slug' => 'skype',
			'dec'  => __('Skype','ux')
		),
		array(
			'name' => __('Dribbble','ux'),
			'icon' => 'fa fa-dribbble square-radiu',
			'icon2' => 'fa fa-dribbble square-radiu',
			'slug' => 'dribbble',
			'dec'  => __('Visit Dribbble page','ux')
		)
	);	
	
	return $theme_config_social_networks;
	
}

//theme config fonts size
function ux_theme_options_fonts_size(){
	$theme_config_fonts_size = array('10px', '11px', '12px', '13px', '14px', '15px', '16px', '17px', '18px', '19px', '20px', '22px', '24px', '26px', '28px', '30px', '32px', '36px', '38px', '40px', '46px', '50px', '56px', '60px', '66px');
	
	return $theme_config_fonts_size;
}

//theme config fonts style
function ux_theme_options_fonts_style(){
	$theme_config_fonts_style = array(
		array('title' => 'Light', 'value' => 'light'),
		array('title' => 'Normal', 'value' => 'regular'),
		array('title' => 'Bold', 'value' => 'bold'),
		array('title' => 'Italic', 'value' => 'italic')
	);
	
	return $theme_config_fonts_style;
}

//theme config color scheme
function ux_theme_options_color_scheme(){
	
	$color_scheme = array(
		'scheme-1' => array(
			  array('name' => 'theme_main_color',                     'value' => '#FF5533'),
                          array('name' => 'second_auxiliary_color',               'value' => '#FAFAFA'), 
                          array('name' => 'logo_text_color',                      'value' => '#eeeeee'), 
                          array('name' => 'left_menu_bar_bg_color',               'value' => '#333333'), 
                          array('name' => 'menu_item_text_color',                 'value' => '#a3a3a3'), 
                          array('name' => 'menu_activated_item_text_color',       'value' => '#ffffff'), 
                          array('name' => 'submenu_text_color',                   'value' => '#a3a3a3'), 
                          array('name' => 'copyright_text_color',                 'value' => '#666666'),
                          array('name' => 'title_color_light',                    'value' => '#333333'), 
                          array('name' => 'content_text_color_light',             'value' => '#444444'), 
                          array('name' => 'auxiliary_content_color_light',        'value' => '#999999'),   
                          array('name' => 'selected_text_bg_color',               'value' => '#FF5533'), 
                          array('name' => 'page_post_bg_color',                   'value' => '#ffffff'), 
                          array('name' => 'sidebar_widget_bg_color',              'value' => '#fafafa'),
                          array('name' => 'sidebar_widget_title_color',           'value' => '#666666'), 
                          array('name' => 'sidebar_content_color',                'value' => '#999999'), 
                          array('name' => 'fullscreen_post_slider_text_bg_color', 'value' => '#424242')
			  
		),
		'scheme-2' => array(
			  array('name' => 'theme_main_color',                     'value' => '#3B5998'),
                          array('name' => 'second_auxiliary_color',               'value' => '#FAFAFA'), 
                          array('name' => 'logo_text_color',                      'value' => '#eeeeee'), 
                          array('name' => 'left_menu_bar_bg_color',               'value' => '#333333'), 
                          array('name' => 'menu_item_text_color',                 'value' => '#a3a3a3'), 
                          array('name' => 'menu_activated_item_text_color',       'value' => '#ffffff'), 
                          array('name' => 'submenu_text_color',                   'value' => '#a3a3a3'), 
                          array('name' => 'copyright_text_color',                 'value' => '#666666'),
                          array('name' => 'title_color_light',                    'value' => '#333333'), 
                          array('name' => 'content_text_color_light',             'value' => '#444444'), 
                          array('name' => 'auxiliary_content_color_light',        'value' => '#999999'),   
                          array('name' => 'selected_text_bg_color',               'value' => '#3B5998'), 
                          array('name' => 'page_post_bg_color',                   'value' => '#ffffff'), 
                          array('name' => 'sidebar_widget_bg_color',              'value' => '#fafafa'),
                          array('name' => 'sidebar_widget_title_color',           'value' => '#666666'), 
                          array('name' => 'sidebar_content_color',                'value' => '#999999'), 
                          array('name' => 'fullscreen_post_slider_text_bg_color', 'value' => '#424242')
		),
		'scheme-3' => array(
			  array('name' => 'theme_main_color',                     'value' => '#00CF75'),
                          array('name' => 'second_auxiliary_color',               'value' => '#FAFAFA'), 
                          array('name' => 'logo_text_color',                      'value' => '#eeeeee'), 
                          array('name' => 'left_menu_bar_bg_color',               'value' => '#333333'), 
                          array('name' => 'menu_item_text_color',                 'value' => '#a3a3a3'), 
                          array('name' => 'menu_activated_item_text_color',       'value' => '#ffffff'), 
                          array('name' => 'submenu_text_color',                   'value' => '#a3a3a3'), 
                          array('name' => 'copyright_text_color',                 'value' => '#666666'),
                          array('name' => 'title_color_light',                    'value' => '#333333'), 
                          array('name' => 'content_text_color_light',             'value' => '#444444'), 
                          array('name' => 'auxiliary_content_color_light',        'value' => '#999999'),   
                          array('name' => 'selected_text_bg_color',               'value' => '#00CF75'), 
                          array('name' => 'page_post_bg_color',                   'value' => '#ffffff'), 
                          array('name' => 'sidebar_widget_bg_color',              'value' => '#fafafa'),
                          array('name' => 'sidebar_widget_title_color',           'value' => '#666666'), 
                          array('name' => 'sidebar_content_color',                'value' => '#999999'), 
                          array('name' => 'fullscreen_post_slider_text_bg_color', 'value' => '#424242')
		),
		'scheme-4' => array(
			  array('name' => 'theme_main_color',                     'value' => '#FFC400'),
                          array('name' => 'second_auxiliary_color',               'value' => '#FAFAFA'), 
                          array('name' => 'logo_text_color',                      'value' => '#eeeeee'), 
                          array('name' => 'left_menu_bar_bg_color',               'value' => '#333333'), 
                          array('name' => 'menu_item_text_color',                 'value' => '#a3a3a3'), 
                          array('name' => 'menu_activated_item_text_color',       'value' => '#ffffff'), 
                          array('name' => 'submenu_text_color',                   'value' => '#a3a3a3'), 
                          array('name' => 'copyright_text_color',                 'value' => '#666666'),
                          array('name' => 'title_color_light',                    'value' => '#333333'), 
                          array('name' => 'content_text_color_light',             'value' => '#444444'), 
                          array('name' => 'auxiliary_content_color_light',        'value' => '#999999'),   
                          array('name' => 'selected_text_bg_color',               'value' => '#FFC400'), 
                          array('name' => 'page_post_bg_color',                   'value' => '#ffffff'), 
                          array('name' => 'sidebar_widget_bg_color',              'value' => '#fafafa'),
                          array('name' => 'sidebar_widget_title_color',           'value' => '#666666'), 
                          array('name' => 'sidebar_content_color',                'value' => '#999999'), 
                          array('name' => 'fullscreen_post_slider_text_bg_color', 'value' => '#424242')
		),
		'scheme-5' => array(
			  array('name' => 'theme_main_color',                     'value' => '#DA7BEB'),
                          array('name' => 'second_auxiliary_color',               'value' => '#FAFAFA'), 
                          array('name' => 'logo_text_color',                      'value' => '#eeeeee'), 
                          array('name' => 'left_menu_bar_bg_color',               'value' => '#333333'), 
                          array('name' => 'menu_item_text_color',                 'value' => '#a3a3a3'), 
                          array('name' => 'menu_activated_item_text_color',       'value' => '#ffffff'), 
                          array('name' => 'submenu_text_color',                   'value' => '#a3a3a3'), 
                          array('name' => 'copyright_text_color',                 'value' => '#666666'),
                          array('name' => 'title_color_light',                    'value' => '#333333'), 
                          array('name' => 'content_text_color_light',             'value' => '#444444'), 
                          array('name' => 'auxiliary_content_color_light',        'value' => '#999999'),   
                          array('name' => 'selected_text_bg_color',               'value' => '#DA7BEB'), 
                          array('name' => 'page_post_bg_color',                   'value' => '#ffffff'), 
                          array('name' => 'sidebar_widget_bg_color',              'value' => '#fafafa'),
                          array('name' => 'sidebar_widget_title_color',           'value' => '#666666'), 
                          array('name' => 'sidebar_content_color',                'value' => '#999999'), 
                          array('name' => 'fullscreen_post_slider_text_bg_color', 'value' => '#424242')
		),
		'scheme-6' => array(
			  array('name' => 'theme_main_color',                     'value' => '#FF7C6E'),
                          array('name' => 'second_auxiliary_color',               'value' => '#333333'), 
                          array('name' => 'logo_text_color',                      'value' => '#eeeeee'), 
                          array('name' => 'left_menu_bar_bg_color',               'value' => '#242424'), 
                          array('name' => 'menu_item_text_color',                 'value' => '#a3a3a3'), 
                          array('name' => 'menu_activated_item_text_color',       'value' => '#ffffff'), 
                          array('name' => 'submenu_text_color',                   'value' => '#a3a3a3'), 
                          array('name' => 'copyright_text_color',                 'value' => '#666666'),
                          array('name' => 'title_color_light',                    'value' => '#fafafa'), 
                          array('name' => 'content_text_color_light',             'value' => '#cccccc'), 
                          array('name' => 'auxiliary_content_color_light',        'value' => '#999999'),   
                          array('name' => 'selected_text_bg_color',               'value' => '#FF7C6E'), 
                          array('name' => 'page_post_bg_color',                   'value' => '#2b2b2b'), 
                          array('name' => 'sidebar_widget_bg_color',              'value' => '#2b2b2b'),
                          array('name' => 'sidebar_widget_title_color',           'value' => '#cccccc'), 
                          array('name' => 'sidebar_content_color',                'value' => '#aaaaaa'), 
                          array('name' => 'fullscreen_post_slider_text_bg_color', 'value' => '#666666')
		),
		'scheme-7' => array(
			  array('name' => 'theme_main_color',                     'value' => '#99CEFF'),
                          array('name' => 'second_auxiliary_color',               'value' => '#333333'), 
                          array('name' => 'logo_text_color',                      'value' => '#eeeeee'), 
                          array('name' => 'left_menu_bar_bg_color',               'value' => '#242424'), 
                          array('name' => 'menu_item_text_color',                 'value' => '#a3a3a3'), 
                          array('name' => 'menu_activated_item_text_color',       'value' => '#ffffff'), 
                          array('name' => 'submenu_text_color',                   'value' => '#a3a3a3'), 
                          array('name' => 'copyright_text_color',                 'value' => '#666666'),
                          array('name' => 'title_color_light',                    'value' => '#fafafa'), 
                          array('name' => 'content_text_color_light',             'value' => '#cccccc'), 
                          array('name' => 'auxiliary_content_color_light',        'value' => '#999999'),   
                          array('name' => 'selected_text_bg_color',               'value' => '#99CEFF'), 
                          array('name' => 'page_post_bg_color',                   'value' => '#2b2b2b'), 
                          array('name' => 'sidebar_widget_bg_color',              'value' => '#2b2b2b'),
                          array('name' => 'sidebar_widget_title_color',           'value' => '#cccccc'), 
                          array('name' => 'sidebar_content_color',                'value' => '#aaaaaa'), 
                          array('name' => 'fullscreen_post_slider_text_bg_color', 'value' => '#666666')
		),
		'scheme-8' => array(
			  array('name' => 'theme_main_color',                     'value' => '#00CF75'),
                          array('name' => 'second_auxiliary_color',               'value' => '#333333'), 
                          array('name' => 'logo_text_color',                      'value' => '#eeeeee'), 
                          array('name' => 'left_menu_bar_bg_color',               'value' => '#242424'), 
                          array('name' => 'menu_item_text_color',                 'value' => '#a3a3a3'), 
                          array('name' => 'menu_activated_item_text_color',       'value' => '#ffffff'), 
                          array('name' => 'submenu_text_color',                   'value' => '#a3a3a3'), 
                          array('name' => 'copyright_text_color',                 'value' => '#666666'),
                          array('name' => 'title_color_light',                    'value' => '#fafafa'), 
                          array('name' => 'content_text_color_light',             'value' => '#cccccc'), 
                          array('name' => 'auxiliary_content_color_light',        'value' => '#999999'),   
                          array('name' => 'selected_text_bg_color',               'value' => '#00CF75'), 
                          array('name' => 'page_post_bg_color',                   'value' => '#2b2b2b'), 
                          array('name' => 'sidebar_widget_bg_color',              'value' => '#2b2b2b'),
                          array('name' => 'sidebar_widget_title_color',           'value' => '#cccccc'), 
                          array('name' => 'sidebar_content_color',                'value' => '#aaaaaa'), 
                          array('name' => 'fullscreen_post_slider_text_bg_color', 'value' => '#666666')
		),
		'scheme-9' => array(
			  array('name' => 'theme_main_color',                     'value' => '#FFEE00'),
                          array('name' => 'second_auxiliary_color',               'value' => '#333333'), 
                          array('name' => 'logo_text_color',                      'value' => '#eeeeee'), 
                          array('name' => 'left_menu_bar_bg_color',               'value' => '#242424'), 
                          array('name' => 'menu_item_text_color',                 'value' => '#a3a3a3'), 
                          array('name' => 'menu_activated_item_text_color',       'value' => '#ffffff'), 
                          array('name' => 'submenu_text_color',                   'value' => '#a3a3a3'), 
                          array('name' => 'copyright_text_color',                 'value' => '#666666'),
                          array('name' => 'title_color_light',                    'value' => '#fafafa'), 
                          array('name' => 'content_text_color_light',             'value' => '#cccccc'), 
                          array('name' => 'auxiliary_content_color_light',        'value' => '#999999'),   
                          array('name' => 'selected_text_bg_color',               'value' => '#FFEE00'), 
                          array('name' => 'page_post_bg_color',                   'value' => '#2b2b2b'), 
                          array('name' => 'sidebar_widget_bg_color',              'value' => '#2b2b2b'),
                          array('name' => 'sidebar_widget_title_color',           'value' => '#cccccc'), 
                          array('name' => 'sidebar_content_color',                'value' => '#aaaaaa'), 
                          array('name' => 'fullscreen_post_slider_text_bg_color', 'value' => '#666666')
		),
		'scheme-10' => array(
			  array('name' => 'theme_main_color',                     'value' => '#DA7BEB'),
                          array('name' => 'second_auxiliary_color',               'value' => '#333333'), 
                          array('name' => 'logo_text_color',                      'value' => '#eeeeee'), 
                          array('name' => 'left_menu_bar_bg_color',               'value' => '#242424'), 
                          array('name' => 'menu_item_text_color',                 'value' => '#a3a3a3'), 
                          array('name' => 'menu_activated_item_text_color',       'value' => '#ffffff'), 
                          array('name' => 'submenu_text_color',                   'value' => '#a3a3a3'), 
                          array('name' => 'copyright_text_color',                 'value' => '#666666'),
                          array('name' => 'title_color_light',                    'value' => '#fafafa'), 
                          array('name' => 'content_text_color_light',             'value' => '#cccccc'), 
                          array('name' => 'auxiliary_content_color_light',        'value' => '#999999'),   
                          array('name' => 'selected_text_bg_color',               'value' => '#DA7BEB'), 
                          array('name' => 'page_post_bg_color',                   'value' => '#2b2b2b'), 
                          array('name' => 'sidebar_widget_bg_color',              'value' => '#2b2b2b'),
                          array('name' => 'sidebar_widget_title_color',           'value' => '#cccccc'), 
                          array('name' => 'sidebar_content_color',                'value' => '#aaaaaa'), 
                          array('name' => 'fullscreen_post_slider_text_bg_color', 'value' => '#666666')
		)

		
	);
	return $color_scheme;
	
}

//theme config select fields
function ux_theme_options_config_select_fields(){
	$theme_config_select_fields = array(
		'theme_option_submenu_distribution' => array(
			array('title' => __('Vertical', 'ux'), 'value' => 'vertical'),
			array('title' => __('Horizon', 'ux'), 'value' => 'horizon')
		),
		'theme_option_posts_showmeta' => array(
			array('title' => __('Date', 'ux'), 'value' => 'date'),
			array('title' => __('Tag', 'ux'), 'value' => 'tag'),
			array('title' => __('Author', 'ux'), 'value' => 'author'),
			array('title' => __('Category', 'ux'), 'value' => 'category')
		),
                'theme_option_website_layout' => array(
                        array('title' => __('Sidebar Hide', 'ux'), 'value' => 'sidebar_hide'),
                        array('title' => __('Sidebar Hide B', 'ux'), 'value' => 'sidebar_hide sidebar_hide_b'),
                        array('title' => __('Sidebar Show', 'ux'), 'value' => 'sidebar_show')
                ) 
		
	);
	
	$theme_config_select_fields = apply_filters('theme_config_select_fields', $theme_config_select_fields);
	return $theme_config_select_fields;
}

//theme config fields
function ux_theme_options_config_fields(){
	$theme_config_fields = array(
		array(
			'id' => 'options-theme',
			'name' => __('Theme Options','ux'),
			'section' => array(
				array(
					'id' => 'import-export',
					'title' => __('Import Demo Data','ux'),
					'item' => array(
						array('description' => __('if you are new to WordPress or have problems creating posts or pages that look like the theme demo, you could import dummy posts and pages here that will definitely help to understand how those tasks are done','ux'),
							  'button' => array(
									  'title' => __('Import Demo Data','ux'),
									  'loading' => __('Loading data, don&acute;t close the page please.','ux'),
									  'type' => 'import-demo-data',
									  'class' => 'btn-info',
									  'url' => admin_url('admin.php?import=wordpress&step=2', 'http')
							  ),
							  'notice' => __('The demo content will be import including post/pages and sliders, the images in sliders could only be use as placeholder and could not be use in your finally website due to copyright reasons.','ux'),
							  'type' => 'button',
							  'name' => 'theme_option_import_demo'),
								  
						array('description' => __('export your current data to a file and save it on your computer','ux'),
							  'button' => array(
									  'title' => __('Export Current Data','ux'),
									  'type' => 'export-current-data',
									  'class' => 'btn-default',
									  'url' => admin_url('export.php?download=true')
							  ),
							  'type' => 'button',
							  'name' => 'theme_option_export_current_data'),
								  
						array('description' => __('import a data file you have saved','ux'),
							  'button' => array(
									  'title' => __('Import My Saved Data','ux'),
									  'type' => 'import-mysaved-data',
									  'class' => 'btn-default',
									  'url' => admin_url('admin.php?import=wordpress')
							  ),
							  'type' => 'button',
							  'name' => 'theme_option_import_mysaved_data'))
				),
				array(
					'id' => 'frontpage',
					'item' => array(
						array('title' => __('FrontPage','ux'),
							  'description' => __('select which page to display on your FrontPage, if left blank the Blog will be displayed','ux'),
							  'type' => 'select-front',
							  'name' => 'theme_option_frontpage')
					)
				)
			)
		),
		array(
			'id' => 'options-general',
			'name' => __('General Settings','ux'),
			'section' => array(    

				array(
					'id' => 'logo',
					'title' => __('Logo','ux'),
					'item' => array(        
						array('title' => __('Enable Plain Text Logo','ux'),
							  'description' =>'',
							  'type' => 'switch',
							  'name' => 'theme_option_enable_text_logo',
							  'default' => 'false'),

						array('title' => __('Logo Text','ux'),
							  'description' => '',
							  'type' => 'text',
							  'name' => 'theme_option_text_logo',
							  'description' => __('enter logo text','ux'),
							  'default' => __('Aside','ux'),
							  'control' => array(
									  'name' => 'theme_option_enable_text_logo',
									  'value' => 'true'
							  )
						),

						array('title' => __('Custom Logo','ux'),
							  'description' => __('the container for custom logo is 120px(width) * 100px(hight), you could upload a double size logo image to meet the needs of retina screens','ux'),
							  'type' => 'upload',
							  'name' => 'theme_option_custom_logo',
							  'default' => UX_LOCAL_URL . '/img/logo.png'
                                                )
							  
					)
				),
				array(
					'id' => 'copyright',
					'title' => __('Copyright','ux'),
					'item' => array(
						array('title' => __('Copyright Information','ux'),
							  'description' => __('enter the copyright information, it would be placed on the bottom of the pages','ux'),
							  'type' => 'text',
							  'name' => 'theme_option_copyright',
							  'default' => 'Copyright uiueux.com')
					)
				),
				array(
					'id' => 'track-code',
					'title' => __('Please enter the track Code','ux'),
					'item' => array(
						array('title' => __('Track Code','ux'),
							  'type' => 'textarea',
							  'name' => 'theme_option_track_code')
					)
				),
				array(
					'id' => 'icon',
					'title' => __('Icon','ux'),
					'item' => array(
						array('title' => __('Custom Favicon','ux'),
							  'description' => __('upload the favicon for your website, it would be shown on the tab of the browser','ux'),
							  'type' => 'upload',
							  'name' => 'theme_option_custom_favicon',
							  'default' => UX_LOCAL_URL . '/img/favicon.ico'),
							  
						array('title' => __('Custom Mobile Icon','ux'),
							  'description' => __('upload the icon for the shortcuts on mobile devices','ux'),
							  'type' => 'upload',
							  'name' => 'theme_option_mobile_icon',
							  'default' => UX_LOCAL_URL . '/img/apple-touch-icon-114x114.png')
					)
				),
				array(
					'title' => __('Page Loading', 'ux'),
					'id' => 'options-page-setting',
					'item' => array(
							      
						array('title' => __('Enable Fade-in Loading Efect','ux'),
							  'type' => 'switch',
							  'name' => 'theme_option_enable_fadein_effect',
							  'default' => 'true')
					)
				),
                                array('title' => __('Custom CSS','ux'),
                                        'id' => 'custom-css',
                                        'title' => __('Custom CSS','ux'),
                                        'item' => array(
                                                array('title' => __('Please enter your Custom CSS','ux'),
                                                          'type' => 'textarea',
                                                          'name' => 'theme_option_custom_css')
                                        )
                                )
			)
		),
		array(
			'id' => 'options-social-networks',
			'name' => __('Social Networks','ux'),
			'section' => array(
				array(
					'id' => 'social-media-links',
					'title' => __('Your Social Media Links','ux'),
					'item' => array(

						array('title' => __('Enable Social Media Links','ux'),
							  'type' => 'switch',
							  'name' => 'theme_option_show_social',
							  'default' => 'false',
							  'bind' => array(
								  array('title' => __('Social Medias','ux'),
										'type' => 'new-social-medias',
										'name' => 'theme_option_show_social_medias',
										'position' => 'after',
										'control' => array(
											'name' => 'theme_option_show_social',
											'value' => 'true'
										)
								  )
							  ))
					)
				),
			)
		),
		array(
			'id' => 'options-schemes',
			'name' => __('Schemes','ux'),
			'section' => array(
				array(
					'id' => 'color-scheme',
					'title' => __('Color Setting','ux'),
					'item' => array(
						array('title' => __('Select a predefined color scheme ','ux'),
							  'type' => 'color-scheme',
							  'name' => 'theme_option_color_scheme')
					)
				),
				array(
					'id' => 'color-main',
					'title' => __('Global','ux'),
					'item' => array(
						array('title' => __('Highlight Color','ux'),
							  'description' => __('click the','ux'). '<a title="http://www.uiueux.com/a/aside/help/assets/color_intro_aside.png" class="themeoption-help-a" target="_blank" href="http://www.uiueux.com/a/aside/help/assets/color_intro_aside.png"><span class="themeoption-help">?</span></a> ' .__('icon to learn which elements would be affected by the Highlight Color','ux'),
							  'type' => 'switch-color',
							  'name' => 'theme_option_color_theme_main',
							  'scheme-name' => 'theme_main_color',
							  'default' => '#FF5533'),
							  
						array('title' => __('Auxiliary Color','ux'),
							  'description' => '',
							  'type' => 'switch-color',
							  'name' => 'theme_option_color_second_auxiliary',
							  'help_url' => 'http://www.uiueux.com/a/aside/help/assets/color_intro_aside.png',
							  'scheme-name' => 'second_auxiliary_color',
							  'default' => '#FAFAFA')
					)
				),
                                array(
                                        'id' => 'color-logo',
                                        'title' => __('Logo','ux'),
                                        'item' => array(
                                                array('title' => __('Logo Text Color','ux'),
                                                          'description' => __('rcolor for plain text logo','ux'),
                                                          'type' => 'switch-color',
                                                          'name' => 'theme_option_color_logo',
                                                          'scheme-name' => 'logo_text_color',
							  'default' => '#eeeeee')
                                        )
                                ),
                                array(
                                        'id' => 'color-menu',
                                        'title' => __('Menu Bar','ux'),
                                        'item' => array(
                                                array('title' => __('Left Menu Bar Bg Color','ux'),
                                                          'type' => 'switch-color',
                                                          'name' => 'theme_option_bg_left_menu_bar',
                                                          'scheme-name' => 'left_menu_bar_bg_color',
							  'default' => '#333333'),
                                                          
                                                array('title' => __('Menu Item Text Color','ux'),
                                                          'description' => __('color for menu item text','ux'),
                                                          'type' => 'switch-color',
                                                          'name' => 'theme_option_color_menu_item_text',
                                                          'scheme-name' => 'menu_item_text_color',
							  'default' => '#a3a3a3'),
                                                          
                                                array('title' => __('Activated Item Text Color','ux'),
                                                          'description' => __('color for text of menu item linked the curren','ux'),
                                                          'type' => 'switch-color',
                                                          'name' => 'theme_option_color_menu_activated_item_text',
                                                          'scheme-name' => 'menu_activated_item_text_color',
							  'default' => '#ffffff'),
                                                          
                                                array('title' => __('Submenu Text Color','ux'),
                                                          'description' => __('color for submenu item text','ux'),
                                                          'type' => 'switch-color',
                                                          'name' => 'theme_option_color_submenu_text',
                                                          'scheme-name' => 'submenu_text_color',
							  'default' => '#a3a3a3'),

                                                array('title' => __('Copyright Color','ux'),
                                                          'description' => '',
                                                          'type' => 'switch-color',
                                                          'name' => 'theme_option_color_copyright',
                                                          'scheme-name' => 'copyright_text_color',
							  'default' => '#666666')
                                        )
                                ),
				array(
					'id' => 'color-post-page',
					'title' => __('Posts & Pages','ux'),
					'item' => array(

						array('title' => __('Title Color','ux'),
							  'description' => __('the color for title text ','ux'),
							  'type' => 'switch-color',
							  'name' => 'theme_option_color_title_light',
							  'scheme-name' => 'title_color_light',
							  'default' => '#333333'),
							  
						array('title' => __('Content Text Color','ux'),
							  'description' => __('the color for content text ','ux'),
							  'type' => 'switch-color',
							  'name' => 'theme_option_color_content_text_light',
							  'scheme-name' => 'content_text_color_light',
							  'default' => '#444444'),
							  
						array('title' => __('Auxiliary Content Color','ux'),
							  'description' => __('the color for auxiliary content text, such as meta of a post','ux'),
							  'type' => 'switch-color',
							  'name' => 'theme_option_color_auxiliary_content_light',
							  'scheme-name' => 'auxiliary_content_color_light',
							  'default' => '#999999'),
							  
						array('title' => __('Selected Text Bg Color','ux'),
							  'description' => __('the color for selected text background','ux'),
							  'type' => 'switch-color',
							  'name' => 'theme_option_color_selected_text_bg',
							  'scheme-name' => 'selected_text_bg_color',
							  'default' => '#FF5533'),
							  
						array('title' => __('Page/Post Bg Color','ux'),
							  'description' => __('background color for the page area','ux'),
							  'type' => 'switch-color',
							  'name' => 'theme_option_bg_page_post',
							  'scheme-name' => 'page_post_bg_color',
							  'default' => '#ffffff')

					)
				),

				
				array(
					'id' => 'color-sidebar',
					'title' => __('Sidebar','ux'),
					'item' => array(
                                                array('title' => __('Sidebar background Color','ux'),
                                                          'description' => __('color for sidebar background','ux'),
                                                          'type' => 'switch-color',
                                                          'name' => 'theme_option_color_sidebar_widget_bg',
                                                          'scheme-name' => 'sidebar_widget_bg_color',
							  'default' => '#fafafa'),

						array('title' => __('Sidebar Widget Title Color','ux'),
							  'description' => __('color for sidebar widget title text','ux'),
							  'type' => 'switch-color',
							  'name' => 'theme_option_color_sidebar_widget_title',
							  'scheme-name' => 'sidebar_widget_title_color',
							  'default' => '#666666'),
							  
						array('title' => __('Sidebar Widget Content Color','ux'),
							  'type' => 'switch-color',
							  'name' => 'theme_option_color_sidebar_content_color',
							  'scheme-name' => 'sidebar_content_color',
							  'default' => '#999999')
					)
				),
				array(
					'id' => 'color-sliders',
					'title' => __('Sliders','ux'),
					'item' => array(  
						array('title' => __('FullScreen Post Slider background Color','ux'),
                                                          'description' => __('background Color for fullscreen post Slider template and slider style in porfolio format post','ux'),
							  'type' => 'switch-color',
							  'name' => 'theme_option_bg_fullscreen_post_slider',
							  'scheme-name' => 'fullscreen_post_slider_text_bg_color',
							  'default' => '#424242')
							  
					)
				)
			)
		),
		array(
			'id' => 'options-font',
			'name' => __('Font Settings','ux'),
			'section' => array(
				array(
					'id' => 'font-synchronous',
					'title' => __('Synchronous','ux'),
					'item' => array(
						array('button' => array(
								  'title' => __('Update to new Google Font Data','ux'),
								  'loading' => __('Updating ...','ux'),
								  'type' => 'font-synchronous',
								  'class' => 'btn-primary'
							  ),
							  'type' => 'button',
							  'name' => 'theme_option_font_synchronous')
					)
				),
				array(
					'id' => 'font-main',
					'item' => array(
						array('title' => __('Main Font','ux'),
							  'description' => __('font for all text except titles','ux'),
							  'type' => 'fonts-family',
							  'name' => 'theme_option_font_family_main',
                                                          'bind' => array(
                                                                       array('type' => 'fonts-style',
                                                                                'name' => 'theme_option_font_style_main',
                                                                                'default' => 'normal',
                                                                                'position' => 'after')
                                                                        )

                                                ),
							  
						array('title' => __('Heading Font','ux'),
							  'description' => __('font for titles','ux'),
							  'type' => 'fonts-family',
							  'name' => 'theme_option_font_family_heading',
                                                          'bind' => array(
                                                                       array('type' => 'fonts-style',
                                                                                'name' => 'theme_option_font_style_heading',
                                                                                'default' => 'normal',
                                                                                'position' => 'after')
                                                                        )
                                                )          
					)
				),

				array(
					'id' => 'font-logo',
					'item' => array(
						array('title' => __('Logo Font','ux'),
							  'description' => __('font for plaint text logo','ux'),
							  'type' => 'fonts-family',
							  'name' => 'theme_option_font_family_logo',
							  'bind' => array(
								  array('type' => 'fonts-size',
										'name' => 'theme_option_font_size_logo',
										'default' => '38px',
										'position' => 'after'),
										
								  array('type' => 'fonts-style',
										'name' => 'theme_option_font_style_logo',
										'default' => 'normal',
										'position' => 'after')
							  ))
					)
				),
				array(
					'id' => 'font-menu',
					'item' => array(
						array('title' => __('Menu Font','ux'),
							  'description' => __('font for text on menu','ux'),
							  'type' => 'fonts-family',
							  'name' => 'theme_option_font_family_menu',
							  'bind' => array(
								  array('type' => 'fonts-size',
										'name' => 'theme_option_font_size_menu',
										'default' => '12px',
										'position' => 'after'),
										
								  array('type' => 'fonts-style',
										'name' => 'theme_option_font_style_menu',
										'default' => 'normal',
										'position' => 'after')
							  ))
					)
				),
                                array(
                                        'id' => 'copyright',
                                        'item' => array(
                                                array('title' => __('Copyright','ux'),
                                                          'description' => '',
                                                          'type' => 'fonts-size',
                                                          'name' => 'theme_option_font_size_copyright',
                                                          'default' => '12px')
                                        )
                                ),
				array(
					'id' => 'font-post-page',
					'item' => array(
						array('title' => __('Post/Page Title Font','ux'),
							  'description' => __('font for post/page title text','ux'),
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_size_post_page_title',
							  'default' => '40px'),
							  
						array('title' => __('Post/Page Content Font','ux'),
							  'description' => __('font for post/page content text','ux'),
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_size_post_page_content',
							  'default' => '12px')
					)
				),
				array(
					'id' => 'font-sidebar',
					'item' => array(
						array('title' => __('Sidebar Widget Title Font','ux'),
							  'description' => __('font for sidebar widget title text','ux'),
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_size_sidebar_widget_title',
							  'default' => '16px'),
							  
						array('title' => __('Sidebar Widget Content Font','ux'),
							  'description' => __('font for sidebar widget content text','ux'),
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_size_sidebar_widget_content',
							  'default' => '12px')
					)
				),
				array(
					'id' => 'font-footer',
					'item' => array(
						array('title' => __('Footer Text','ux'),
							  'description' => __('font for copyright text on footer','ux'),
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_size_copyright_text',
							  'default' => '12px')
					)
				),
				array(
					'id' => 'font-fullscreen',
					'item' => array(
						array('title' => __('FullScreen Post Slider Text','ux'),
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_size_fullscreen_post_slider',
							  'default' => '12px')
					)
				)
			)
		),
		array(
			'id' => 'options-icons',
			'name' => __('Icons','ux'),
			'section' => array(
				array(
					'id' => 'icons-upload',
					'title' => __('Upload Icons','ux'),
					'item' => array(
						array('description' => __('select images for your icons from Media Library, it is recommended to upload 48*48 images','ux'),
							  'type' => 'select-images',
							  'name' => 'theme_option_icons_custom')
					)
				)
			)
		),		
		array(
			'id' => 'options-layout',
			'name' => __('Layout','ux'),
			'section' => array(
                                
				array(
					'title' => __('Left Navigation Panel','ux'),
					'item' => array(

                                                array('type' => 'image-select',
                                                        'title' => 'Layout',
                                                          'name' => 'theme_option_website_layout',
                                                          'size' => '80:90',
                                                          'default' => 'sidebar_hide'),
                                                
						array('title' => __('Enable Search Field','ux'),
							  'type' => 'switch',
							  'name' => 'theme_option_enable_search_field',
							  'default' => 'true'),

						array('title' => __('WPML','ux'),
							  'description' => __('the WPML switcher (flags) would be shown on menu bar when this option is on','ux'),
							  'type' => 'switch',
							  'name' => 'theme_option_enable_WPML',
							  'default' => 'false'),
							  
						array('title' => __('Submenu Distribution','ux'),
							  'type' => 'select',
							  'name' => 'theme_option_submenu_distribution',
							  'default' => 'horizon')
					)
				),
				array(
					'titlt' => __('Floating Top Bar','ux'),
					'item' => array(
					
						array('title' => __('Disable Social Share Bar','ux'),
							  'type' => 'switch',
							  'name' => 'theme_option_enable_floating_bar_disable',
							  'default' => 'false')
					)
				),
				array(
					'titlt' => __('Post','ux'),
					'item' => array(
					
						array('title' => __('Show Meta On Post Page','ux'),
							  'type' => 'switch',
							  'name' => 'theme_option_enable_meta_post_page',
							  'default' => 'true',
							  'bind' => array(
								  array('type' => 'checkbox-group',
										'name' => 'theme_option_posts_showmeta',
										'position' => 'after',
										'default' => array('date', 'tag', 'author', 'category'),
										'control' => array(
											'name' => 'theme_option_enable_meta_post_page',
											'value' => 'true'
										)
								  )
							  ))
					)
				)
			)
		),
		array(
			'id' => 'options-mobile',
			'name' => __('Mobile','ux'),
			'section' => array(
				array(
					'id' => 'mobile-logo',
					'title' => __('Logo','ux'),
					'item' => array(
						array('title' => __('Custom Logo (for mobile device)','ux'),
							  'description' => __('the container for mobile logo is 120px(width) * 65px(hight), you could upload a double size logo image to meet the needs of retina screens','ux'),
							  'type' => 'upload',
							  'name' => 'theme_option_mobile_custom_logo')
					)
				),
				array(
					'id' => 'mobile-responsive',
					'title' => __('Responsive','ux'),
					'item' => array(
						array('title' => __('Enable Mobile Layout','ux'),
							  'description' => __('disable this option if you want to display the same with PC end','ux'),
							  'type' => 'switch',
							  'name' => 'theme_option_mobile_enable_responsive',
							  'default' => 'true')
  
					)
				)
			)
		)
	);
	
	return $theme_config_fields;
}


?>