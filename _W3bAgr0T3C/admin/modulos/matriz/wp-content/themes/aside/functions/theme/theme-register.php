<?php
//register script
function ux_theme_register_script(){
	$ux_theme_register_script = array(
		array(
			'handle'    => 'ux-admin-bootstrap',
			'src'       => UX_THEME. '/js/bootstrap.min.js',
			'deps'      => array('jquery'),
			'ver'       => '3.0.2',
			'in_footer' => true,
		),
		array(
			'handle'    => 'ux-admin-bootstrap-switch',
			'src'       => UX_THEME. '/js/bootstrap-switch.min.js',
			'deps'      => array('jquery'),
			'ver'       => '1.8',
			'in_footer' => true,
		),
		array(
			'handle'    => 'ux-admin-minicolors',
			'src'       => UX_THEME. '/js/jquery.minicolors.min.js',
			'deps'      => array('jquery'),
			'ver'       => '2.1',
			'in_footer' => true,
		),
		array(
			'handle'    => 'ux-admin-icheck',
			'src'       => UX_THEME. '/js/jquery.icheck.min.js',
			'deps'      => array('jquery'),
			'ver'       => '0.9.1',
			'in_footer' => true,
		),
		array(
			'handle'    => 'ux-admin-isotope',
			'src'       => UX_THEME. '/js/jquery.isotope.min.js',
			'deps'      => array('jquery'),
			'ver'       => '1.5.25',
			'in_footer' => true,
		),
		array(
			'handle'    => 'ux-admin-bootstrap-datetimepicker',
			'src'       => UX_THEME. '/js/bootstrap-datetimepicker.js',
			'deps'      => array('jquery'),
			'ver'       => '0.0.1',
			'in_footer' => true,
		),
		array(
			'handle'    => 'ux-admin-bootstrap-paginator',
			'src'       => UX_THEME. '/js/bootstrap-paginator.js',
			'deps'      => array('jquery'),
			'ver'       => '1.0',
			'in_footer' => true,
		),
		array(
			'handle'    => 'ux-admin-theme-script',
			'src'       => UX_THEME. '/js/theme.js',
			'deps'      => array('jquery'),
			'ver'       => '0.0.1',
			'in_footer' => false,
		),
		array(
			'handle'    => 'ux-admin-customize-controls',
			'src'       => UX_THEME. '/js/customize-controls.js',
			'deps'      => array('jquery'),
			'ver'       => '0.0.1',
			'in_footer' => true,
		)
	);
	$ux_theme_register_script = apply_filters('ux_theme_register_script', $ux_theme_register_script);
	
	foreach($ux_theme_register_script as $script){
		wp_register_script($script['handle'], $script['src'], $script['deps'], $script['ver'], $script['in_footer'] ); 
	}
}
add_action('init', 'ux_theme_register_script');

//register style
function ux_theme_register_style(){
	$ux_theme_register_style = array(
		array(
			'handle' => 'ux-admin-bootstrap',
			'src'    => UX_THEME. '/css/bootstrap.css',
			'deps'   => array(),
			'ver'    => '3.0.2',
			'media'  => 'screen',
		),
		array(
			'handle' => 'ux-admin-bootstrap-theme',
			'src'    => UX_THEME. '/css/bootstrap-theme.css',
			'deps'   => array('ux-admin-bootstrap'),
			'ver'    => '3.0.2',
			'media'  => 'screen',
		),
		array(
			'handle' => 'font-awesome',
			'src'    => UX_THEME. '/css/font-awesome.min.css',
			'deps'   => array(),
			'ver'    => '4.0.3',
			'media'  => 'screen',
		),
		array(
			'handle' => 'ux-admin-bootstrap-switch',
			'src'    => UX_THEME. '/css/bootstrap-switch.css',
			'deps'   => array(),
			'ver'    => '1.8',
			'media'  => 'screen',
		),
		array(
			'handle' => 'ux-pb-bootstrap-datetimepicker',
			'src'    => UX_THEME. '/css/bootstrap-datetimepicker.min.css',
			'deps'   => array(),
			'ver'    => '0.0.1',
			'media'  => 'screen',
		),
		array(
			'handle' => 'ux-admin-minicolors',
			'src'    => UX_THEME. '/css/jquery.minicolors.css',
			'deps'   => array(),
			'ver'    => '2.1',
			'media'  => 'screen',
		),
		array(
			'handle' => 'ux-admin-theme-icons',
			'src'    => UX_THEME. '/css/icons.css',
			'deps'   => array(),
			'ver'    => '0.0.1',
			'media'  => 'screen',
		),
		array(
			'handle' => 'ux-admin-icheck',
			'src'    => UX_THEME. '/css/icheck/all.css',
			'deps'   => array(),
			'ver'    => '0.9.1',
			'media'  => 'screen',
		),
		array(
			'handle' => 'ux-admin-theme-style',
			'src'    => UX_THEME. '/css/theme.css',
			'deps'   => array(),
			'ver'    => '0.0.1',
			'media'  => 'screen',
		)
	);
	$ux_theme_register_style = apply_filters('ux_theme_register_style', $ux_theme_register_style);
	
	foreach($ux_theme_register_style as $style){
		wp_register_style($style['handle'], $style['src'], $style['deps'], $style['ver'], $style['media'] );
	}
}
add_action('init', 'ux_theme_register_style');

//theme register google fonts
function ux_theme_register_google_fonts(){
	$json = get_option('ux_theme_googlefont');
	if($json){
		$fonts_object = json_decode($json);
		if($fonts_object && is_object($fonts_object)){
			if($fonts_object->items && is_array($fonts_object->items)){
				$fonts = $fonts_object->items;
				foreach($fonts as $item){
					$family_val = str_replace(' ', '+', $item->family);
					$separator = '%2C';
					$output = '';
					if(count($item->variants)){
						foreach($item->variants as $num => $variant){
							$output .= $variant . $separator;
						}
					}
					wp_register_style('google-fonts-' . $family_val, 'http://fonts.googleapis.com/css?family=' . $family_val . ':' . trim($output, $separator));
				}
			}
		}
	}
}
add_filter('init', 'ux_theme_register_google_fonts');

//register post type
function ux_theme_register_post_type(){
	$ux_theme_register_post_type = array(
		'team' => array(
			'name' => __('Team','ux'),
			'meta' => true,
			'add_new' => __('Add New','ux'),
			'add_new_item' => __('Add New Team Member','ux'),
			'edit_item' => __('Edit Team Member','ux'),
			'new_item' => __('New Team Member','ux'),
			'view_item' => __('View Team Member','ux'),
			'not_found' => __('No Team Member found.','ux'),
			'not_found_in_trash' => __('No Team Member found in Trash.','ux'),
			'search_items' => __('Search Team Member','ux'),
			'cat_slug' => __('team_cat','ux'),
			'cat_menu_name' => __('Team Categories','ux'),
			'columns' => array(
				'column_category' => __('Categories','ux')
			),
			'menu_icon' => UX_THEME. '/images/icon/team.png'
		
		),
		'clients' => array(
			'name' => __('Clients','ux'),
			'meta' => true,
			'add_new' => __('Add New','ux'),
			'add_new_item' => __('Add New Client','ux'),
			'edit_item' => __('Edit Client','ux'),
			'new_item' => __('New Client','ux'),
			'view_item' => __('View Client','ux'),
			'not_found' => __('No Client found.','ux'),
			'not_found_in_trash' => __('No Client found in Trash.','ux'),
			'search_items' => __('Search Client','ux'),
			'cat_slug' => __('client_cat','ux'),
			'cat_menu_name' => __('Client Categories','ux'),
			'columns' => array(
				'column_category' => __('Categories','ux')
			),
			'menu_icon' => UX_THEME. '/images/icon/client.png',
			'remove_support' => array('editor')
		
		),
		'testimonials' => array(
			'name' => __('Testimonials','ux'),
			'meta' => true,
			'add_new' => __('Add New','ux'),
			'add_new_item' => __('Add New Testimonial','ux'),
			'edit_item' => __('Edit Testimonial','ux'),
			'new_item' => __('New Testimonial','ux'),
			'view_item' => __('View Testimonial','ux'),
			'not_found' => __('No Testimonial found.','ux'),
			'not_found_in_trash' => __('No Testimonial found in Trash.','ux'),
			'search_items' => __('Search Testimonial','ux'),
			'cat_slug' => __('testimonial_cat','ux'),
			'cat_menu_name' => __('Categories','ux'),
			'columns' => array(
				'column_category' => __('Categories','ux')
			),
			'menu_icon' => UX_THEME. '/images/icon/testimonial.png'
		
		),
		'jobs' => array(
			'name' => __('Jobs','ux'),
			'meta' => true,
			'add_new' => __('Add New','ux'),
			'add_new_item' => __('Add New Job','ux'),
			'edit_item' => __('Edit Job','ux'),
			'new_item' => __('New Job','ux'),
			'view_item' => __('View Job','ux'),
			'not_found' => __('No Job found.','ux'),
			'not_found_in_trash' => __('No Job found in Trash.','ux'),
			'search_items' => __('Search Job','ux'),
			'cat_slug' => __('job_cat','ux'),
			'cat_menu_name' => __('Job Categories','ux'),
			'columns' => array(
				'column_category' => __('Categories','ux')
			),
			'menu_icon' => UX_THEME. '/images/icon/jobs.png'
		
		),
		'faqs' => array(
			'name' => __('FAQs','ux'),
			'meta' => false,
			'add_new' => __('Add New','ux'),
			'add_new_item' => __('Add New Question','ux'),
			'edit_item' => __('Edit Question','ux'),
			'new_item' => __('New Question','ux'),
			'view_item' => __('View Question','ux'),
			'not_found' => __('No Question found.','ux'),
			'not_found_in_trash' => __('No Question found in Trash.','ux'),
			'search_items' => __('Search Question','ux'),
			'cat_slug' => __('question_cat','ux'),
			'cat_menu_name' => __('Topics','ux'),
			'columns' => array(
				'column_category' => __('Categories','ux')
			),
			'menu_icon' => UX_THEME.'/images/icon/faqs.png'
		)
	);
	
	$ux_theme_register_post_type = apply_filters('ux_theme_register_post_type', $ux_theme_register_post_type);
	
	foreach($ux_theme_register_post_type as $slug => $post_type){
		$labels = array(
			'name'               => $post_type['name'],
			'singular_name'      => $post_type['name'],
			'add_new'            => $post_type['add_new'],
			'add_new_item'       => $post_type['add_new_item'],
			'edit_item'          => $post_type['edit_item'],
			'new_item'           => $post_type['new_item'],
			'all_items'          => $post_type['name'],
			'view_item'          => $post_type['view_item'],
			'search_items'       => $post_type['search_items'],
			'not_found'          => $post_type['not_found'],
			'not_found_in_trash' => $post_type['not_found_in_trash'], 
			'parent_item_colon'  => '',
			'menu_name'          => $post_type['name']
		);
		
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true, 
			'show_in_menu'       => true, 
			'query_var'          => true,
			'rewrite'            => array( 'slug' => $slug ),
			'capability_type'    => 'post',
			'has_archive'        => true, 
			'hierarchical'       => true,
			'menu_position'      => isset($post_type['menu_position']) ? $post_type['menu_position'] : false,
			'menu_icon'          => $post_type['menu_icon'],
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		); 
		
		register_post_type($slug, $args);
		
		if(isset($post_type['remove_support'])){
			foreach($post_type['remove_support'] as $remove_support){
				remove_post_type_support( $slug, $remove_support );
			}
			
		}
		
		if(isset($post_type['cat_slug'])){
			$labels = array(   
				'name' => $post_type['cat_menu_name'], 
				'singular_name' => $post_type['cat_slug'], 
				'menu_name' => $post_type['cat_menu_name'],   
			);  
			
			register_taxonomy(   
				$post_type['cat_slug'],   
				array($slug),   
				array(   
					'hierarchical' => true,   
					'labels' => $labels,   
					'show_ui' => true,   
					'query_var' => true,   
					'rewrite' => array( 'slug' => $post_type['cat_slug'] ),   
				)   
			); 
		}
	}
	
	return $ux_theme_register_post_type;
}
add_action('init', 'ux_theme_register_post_type');

//register sidebar
function ux_theme_register_sidebar(){
	$sidebars = array(
		array('value' => 'sidebar_default', 'title' => __('default','ux')),
		array('value' => 'sidebar_1', 'title' => __('sidebar_1','ux')),
		array('value' => 'sidebar_2', 'title' => __('sidebar_2','ux')),
		array('value' => 'sidebar_3', 'title' => __('sidebar_3','ux')),
		array('value' => 'sidebar_4', 'title' => __('sidebar_4','ux')),
		array('value' => 'sidebar_5', 'title' => __('sidebar_5','ux')),
		array('value' => 'sidebar_6', 'title' => __('sidebar_6','ux')),
		array('value' => 'sidebar_7', 'title' => __('sidebar_7','ux')),
		array('value' => 'sidebar_8', 'title' => __('sidebar_8','ux')),
		array('value' => 'sidebar_9', 'title' => __('sidebar_9','ux')),
		array('value' => 'sidebar_10', 'title' => __('sidebar_10','ux'))
	);
	
	foreach($sidebars as $num => $sidebar){
		register_sidebar(array(
			'name' => $sidebar['title'],
			'id' => $sidebar['value'],
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
			'after_widget' => '</li>',
			'class' => ''
		));
	}
	
	return $sidebars;
}
add_action('widgets_init', 'ux_theme_register_sidebar');

function ux_theme_register_nav_menu(){
	register_nav_menus(array(
		'primary' => 'Primary Menu'
	));
}
add_action('init', 'ux_theme_register_nav_menu');
?>