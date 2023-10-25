<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta charset="<?php bloginfo('charset'); ?>">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <base target="_parent" />
    <?php //** Do Hook Web Head
	do_action('ux_interface_webhead'); ?>
    
    <?php wp_head(); ?>
  </head>
  
  <body <?php ux_interface_body_class(); ?>>
      
      <?php //** Do Hook Site Loading
	  do_action('ux_interface_site_loading'); ?>
      
      <div id="jquery_jplayer" class="jp-jplayer"></div>
  
	  <?php //** Do Hook Hook Mobile
	  do_action('ux_interface_mobile'); ?>
      
      <div id="wrap">
		
          <?php 
		  //** Do Hook Sidebar
		  do_action('ux_interface_sidebar');
		  
		  //** Do Hook Header
		  do_action('ux_interface_header'); ?>