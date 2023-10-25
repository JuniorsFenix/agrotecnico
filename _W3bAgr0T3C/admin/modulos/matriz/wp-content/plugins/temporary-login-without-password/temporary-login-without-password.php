<?php

/**
 * Plugin Name:       Temporary Login Without Password
 * Plugin URI:        http://storeapps.org
 * Description:       Create a temporary login link with any role using which one can access to your sytem without username and password for limited period of time.
 * Version:           1.4
 * Author:            StoreApps
 * Author URI:        http://storeapps.org
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-temporary-login-without-password
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

function wp_deactivate_temporary_login_without_password () {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-temporary-login-without-password-deactivator.php';
	Wp_Temporary_Login_Without_Password_Deactivator::deactivate();
}

function wp_activate_temporary_login_without_password () {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-temporary-login-without-password-activator.php';
	Wp_Temporary_Login_Without_Password_Activator::activate();
}

register_deactivation_hook( __FILE__, 'wp_deactivate_temporary_login_without_password' );
register_activation_hook( __FILE__, 'wp_activate_temporary_login_without_password' );


// Include main class file
require plugin_dir_path(__FILE__) . 'includes/class-wp-temporary-login-without-password.php';

function run_wp_temporary_login_without_password() {
    $plugin = new Wp_Temporary_Login_Without_Password();
    $plugin->define_constant('WTLWP_PLUGIN_DIR', dirname(__FILE__));
    $plugin->run();
}

run_wp_temporary_login_without_password();
