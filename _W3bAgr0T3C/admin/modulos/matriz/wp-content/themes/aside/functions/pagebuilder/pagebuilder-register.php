<?php
//register script
function ux_pb_register_script(){
	$ux_pb_register_script = array(
		array(
			'handle'    => 'ux-pb-pagebuilder-script',
			'src'       => UX_PAGEBUILDER. '/js/pagebuilder.js',
			'deps'      => array('jquery'),
			'ver'       => '0.0.1',
			'in_footer' => true,
		),
		array(
			'handle'    => 'ux-pb-pagebuilder-googlemap',
			'src'       => 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAsPAj7Fljj9d-zrSu32COJ5FzUzGM8kM8',
			'deps'      => array('jquery'),
			'ver'       => '3.0',
			'in_footer' => false,
		),
		array(
			'handle'    => 'ux-pb-theme-pagebuilder-script',
			'src'       => UX_PAGEBUILDER. '/js/theme.pagebuilder.js',
			'deps'      => array('jquery'),
			'ver'       => '0.0.1',
			'in_footer' => true,
		)
	);
	foreach($ux_pb_register_script as $script){
		wp_register_script($script['handle'], $script['src'], $script['deps'], $script['ver'], $script['in_footer'] ); 
	}
}
add_action('init', 'ux_pb_register_script');

//register style
function ux_pb_register_style(){
	$ux_pb_register_style = array(
		array(
			'handle' => 'ux-pb-pagebuilder-style',
			'src'    => UX_PAGEBUILDER. '/css/pagebuilder.css',
			'deps'   => array(),
			'ver'    => '0.0.1',
			'media'  => 'screen',
		)
	);
	foreach($ux_pb_register_style as $style){
		wp_register_style($style['handle'], $style['src'], $style['deps'], $style['ver'], $style['media'] );
	}
}
add_action('init', 'ux_pb_register_style');

//register todules template
register_post_type('modules', array('label' => __('Modules (PageBuilder)','ux'), 'show_ui' => false));
register_post_type('module_template', array('label' => __('Module Template (PageBuilder)','ux'), 'show_ui' => false));
?>