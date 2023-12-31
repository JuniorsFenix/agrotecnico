<?php
//theme tgm register
function ux_theme_tgm_register(){
	$plugins = array(

		array(
			'name' 		=> 'Rotating Tweets (Twitter widget and shortcode)',
			'slug' 		=> 'rotatingtweets',
			'version'	=> '',
			'required' 	=> false,
		),
		array(
			'name' 		=> 'Contact Form 7',
			'slug' 		=> 'contact-form-7',
			'version'	=> '',
			'required' 	=> false,
		),	
		array(
			'name' 		=> 'Revolution Slider',
			'slug' 		=> 'revslider',
			'source'    => get_stylesheet_directory() . '/functions/plugins/revslider.zip', 
			'required' 	=> false,
		)

	);

	$theme_text_domain = 'ux';

	$config = array(
		'domain'       		=> 'ux',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'ux' ),
			'menu_title'                       			=> __( 'Install Plugins', 'ux' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'ux' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'ux' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'ux' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'ux' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'ux' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'ux' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'ux' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'ux' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'ux' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'ux' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'ux' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'ux' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'ux' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'ux' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'ux' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'ux_theme_tgm_register' );

//require tgm class
require_once locate_template('/functions/class/class-tgm-plugin-activation.php');

//require breadcrumb class
require_once locate_template('/functions/class/class-full-breadcrumb.php');
?>