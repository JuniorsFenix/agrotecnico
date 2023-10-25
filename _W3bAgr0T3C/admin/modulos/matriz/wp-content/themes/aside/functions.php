<?php
/*
============================================================================
	*
	* require functions pagebuilder 
	*
============================================================================	
*/
require_once locate_template('/functions/pagebuilder/pagebuilder-admin.php');

/*
============================================================================
	*
	* require functions theme 
	*
============================================================================	
*/
require_once locate_template('/functions/theme/theme-admin.php');

/*
============================================================================
	*
	* require class 
	*
============================================================================	
*/
require_once locate_template('/functions/class/class-admin.php');

/*
============================================================================
	*
	* require interface 
	*
============================================================================	
*/
require_once locate_template('/functions/interface/interface-admin.php');

/*
============================================================================
	*
	* require woocommerce 
	*
============================================================================	
*/

if(class_exists('Woocommerce')){
	add_theme_support( 'woocommerce' );
	require_once locate_template('/woocommerce/ux-woocommerce.php');
}

add_action('init', 'myStartSession', 1);
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

add_filter( 'auth_cookie_expiration', 'keep_me_logged_in_for_1_year' );

function keep_me_logged_in_for_1_year( $expirein ) {
    return 31556926; // 1 year in seconds
}

?>