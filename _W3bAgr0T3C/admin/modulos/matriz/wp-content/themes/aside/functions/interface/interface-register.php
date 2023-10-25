<?php
//register script
function ux_theme_interface_register_script($script){
	$script['ux-interface-bootstrap'] = array(
		'handle'    => 'ux-interface-bootstrap',
		'src'       => UX_LOCAL_URL. '/js/bootstrap.js',
		'deps'      => array('jquery'),
		'ver'       => '2.0',
		'in_footer' => true
	);
	
	$script['ux-lightbox'] = array(
		'handle'    => 'ux-lightbox',
		'src'       => UX_LOCAL_URL. '/js/lightbox/jquery.lightbox.min.js',
		'deps'      => array('jquery'),
		'ver'       => '1.7.1',
		'in_footer' => true
	);
	
	$script['ux-interface-script-ie'] = array(
		'handle'    => 'ux-interface-script-ie',
		'src'       => UX_LOCAL_URL. '/js/ie.js',
		'deps'      => array('jquery'),
		'ver'       => '0.0.1',
		'in_footer' => false
	);

	$script['ux-interface-gray'] = array(
		'handle'    => 'ux-interface-gray',
		'src'       => UX_LOCAL_URL. '/js/jquery.gray.min.js',
		'deps'      => array('jquery'),
		'ver'       => '1.2',
		'in_footer' => true
	);
	
	$script['ux-interface-jplayer'] = array(
		'handle'    => 'ux-interface-jplayer',
		'src'       => UX_LOCAL_URL. '/js/jquery.jplayer.min.js',
		'deps'      => array('jquery'),
		'ver'       => '2.2.0',
		'in_footer' => true
	);
	
	$script['ux-interface-infographic'] = array(
		'handle'    => 'ux-interface-infographic',
		'src'       => UX_LOCAL_URL. '/js/infographic.js',
		'deps'      => array('jquery'),
		'ver'       => '1.2.0',
		'in_footer' => true
	);
	
	$script['ux-interface-waypoints'] = array(
		'handle'    => 'ux-interface-waypoints',
		'src'       => UX_LOCAL_URL. '/js/waypoints.min.js',
		'deps'      => array('jquery'),
		'ver'       => '1.1.7',
		'in_footer' => true
	);
	
	$script['ux-interface-flexslider'] = array(
		'handle'    => 'ux-interface-flexslider',
		'src'       => UX_LOCAL_URL. '/js/jquery.flexslider-min.js',
		'deps'      => array('jquery'),
		'ver'       => '2.2.0',
		'in_footer' => true
	);
	
	$script['ux-comment-ajax'] = array(
		'handle'    => 'ux-comment-ajax',
		'src'       => UX_LOCAL_URL. '/js/comments-ajax.js',
		'deps'      => array('jquery'),
		'ver'       => '1.0',
		'in_footer' => true
	);

	$script['ux-interface-countdown'] = array(
		'handle'    => 'ux-interface-countdown',
		'src'       => UX_LOCAL_URL. '/js/jquery.countdown.min.js',
		'deps'      => array('jquery'),
		'ver'       => '1.6.3',
		'in_footer' => true
	);
	
	$script['ux-interface-googlemap'] = array(
		'handle'    => 'ux-interface-googlemap',
		'src'       => 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAsPAj7Fljj9d-zrSu32COJ5FzUzGM8kM8',
		'deps'      => array('jquery'),
		'ver'       => '3.0',
		'in_footer' => false
	);
	
	$script['ux-interface-main'] = array(
		'handle'    => 'ux-interface-main',
		'src'       => UX_LOCAL_URL. '/js/main.js',
		'deps'      => array('jquery'),
		'ver'       => '0.0.1',
		'in_footer' => true
	);
	
	
	$script['ux-interface-theme'] = array(
		'handle'    => 'ux-interface-theme',
		'src'       => UX_LOCAL_URL. '/js/custom.theme.js',
		'deps'      => array('jquery'),
		'ver'       => '0.0.1',
		'in_footer' => true
	);
	
	$script['ux-interface-theme-isotope'] = array(
		'handle'    => 'ux-interface-theme-isotope',
		'src'       => UX_LOCAL_URL. '/js/custom.theme.isotope.js',
		'deps'      => array('jquery'),
		'ver'       => '0.0.1',
		'in_footer' => true
	);
	
	$script['ux-interface-galleria'] = array(
		'handle'    => 'ux-interface-galleria',
		'src'       => UX_LOCAL_URL. '/js/galleria/galleria-1.3.5.js',
		'deps'      => array('jquery'),
		'ver'       => '1.3.5',
		'in_footer' => true
	);
	
	$script['ux-interface-galleria-classic'] = array(
		'handle'    => 'ux-interface-galleria-classic',
		'src'       => UX_LOCAL_URL. '/js/galleria/themes/classic/galleria.classic.min.js',
		'deps'      => array('jquery'),
		'ver'       => '1.3.5',
		'in_footer' => true
	);
	
	return $script;
}
add_filter('ux_theme_register_script', 'ux_theme_interface_register_script');

//register style
function ux_theme_interface_register_style($style){
	require_once dirname(__FILE__).("/../../../../../../../../include/funciones_public.php");
	//require_once dirname(__FILE__).("/../../../../../../../funciones_generales.php");
	$sitioCfg = sitioAssoc();
	
	$style['ux-interface-bootstrap'] = array(
		'handle' => 'ux-interface-bootstrap',
		'src'    => UX_LOCAL_URL. '/styles/bootstrap.css',
		'deps'   => array(),
		'ver'    => '2.0',
		'media'  => 'screen'
	);
	
	$style['font-awesome'] = array(
		'handle' => 'font-awesome',
		'src'    => UX_LOCAL_URL. '/functions/pagebuilder/css/font-awesome.min.css',
		'deps'   => array(),
		'ver'    => '4.0.3',
		'media'  => 'screen'
	);
	
	$style['ux-lightbox-default'] = array(
		'handle' => 'ux-lightbox-default',
		'src'    => UX_LOCAL_URL. '/js/lightbox/themes/default/jquery.lightbox.css',
		'deps'   => array(),
		'ver'    => '0.0.1',
		'media'  => 'screen'
	);
	
	$style['ux-interface-pagebuild'] = array(
		'handle' => 'ux-interface-pagebuild',
		'src'    => UX_LOCAL_URL. '/styles/pagebuild.css',
		'deps'   => array(),
		'ver'    => '0.0.1',
		'media'  => 'screen'
	);

	$style['ux-interface-style'] = array(
		'handle' => 'ux-interface-style',
		'src'    => UX_LOCAL_URL. '/style.css',
		'deps'   => array(),
		'ver'    => '0.0.1',
		'media'  => 'screen'
	);
	
	$style['ux-googlefont-rotobo'] = array(
		'handle' => 'ux-googlefont-rotobo',
		'src'    => 'http://fonts.googleapis.com/css?family=Roboto:400,400italic,700,900',
		'deps'   => array(),
		'ver'    => '0.0.1',
		'media'  => 'screen'
	);	

	$style['ux-googlefont-playfair'] = array(
		'handle' => 'ux-googlefont-playfair',
		'src'    => 'http://fonts.googleapis.com/css?family=Playfair+Display:700',
		'deps'   => array(),
		'ver'    => '0.0.1',
		'media'  => 'screen'
	);

	$style['ux-interface-style-ie'] = array(
		'handle' => 'ux-interface-style-ie',
		'src'    => UX_LOCAL_URL. '/styles/ie.css',
		'deps'   => array(),
		'ver'    => '0.0.1',
		'media'  => 'screen'
	);
	
	$style['ux-interface-style-ie8'] = array(
		'handle' => 'ux-interface-style-ie8',
		'src'    => UX_LOCAL_URL. '/styles/ie8.css',
		'deps'   => array(),
		'ver'    => '0.0.1',
		'media'  => 'screen'
	);
	
	$style['ux-interface-theme-style'] = array(
		'handle' => 'ux-interface-theme-style',
		'src'    => UX_LOCAL_URL. '/styles/theme-style.php',
		'deps'   => array('ux-interface-style'),
		'ver'    => '0.0.1',
		'media'  => 'screen',
	);
	
	$style['ux-interface-galleria-classic'] = array(
		'handle' => 'ux-interface-galleria-classic',
		'src'    => UX_LOCAL_URL. '/js/galleria/themes/classic/galleria.classic.css',
		'deps'   => array(),
		'ver'    => '1.3.5',
		'media'  => 'screen',
	);
	
	$style['custom-css'] = array(
		'handle' => 'custom-css',
		'src'    => '/css/'.$sitioCfg["estilo"],
		'deps'   => array(),
		'ver'    => '0.0.1',
		'media'  => 'screen',
	);
	
	return $style;
}
add_filter('ux_theme_register_style', 'ux_theme_interface_register_style');
?>