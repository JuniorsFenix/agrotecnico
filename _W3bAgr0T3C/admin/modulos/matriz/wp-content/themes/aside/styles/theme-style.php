<?php
header("Content-type: text/css; charset: UTF-8");
require_once('../../../../wp-load.php');


//Global Colors

//Heightlight Color
$ux_color_theme_main = ux_get_option('theme_option_color_theme_main');
if($ux_color_theme_main){ ?>
	
	a:hover,.entry p a,.archive-tit a:hover,.text_block a,.post_meta > li a:hover, #sidebar a:hover, #comments .comment-author a:hover,#comments .reply a:hover,.fourofour-wrap a,.archive-meta-unit a:hover,.post-meta-unit a:hover,
	.blog_meta a:hover,.breadcrumbs a:hover,.link-wrap a:hover,.item_title a:hover,.item_des a:hover,.archive-wrap h3 a:hover,.post-color-default,.latest-posts-tags a:hover,
	.carousel-wrap a:hover,.iocnbox:hover i,.blog-item-main h2 a:hover,div.bbp-template-notice,h1.main_title .bbp-breadcrumb a:hover,.related-post-wrap h3:hover a,.latest-posts-tit-a:hover,
	.woocommerce .price,.text_block .add_to_cart_button:hover,.woocommerce ul.product_list_widget li a:hover,.woocommerce ul.product_list_widget a>.amount,.woocommerce ul.product_list_widget ins .amount, 
	.woocommerce .sidebar_widget .widget_shopping_cart a.button:hover,.woocommerce-page .sidebar_widget .widget_shopping_cart a.button:hover

	{ 
		color:<?php echo $ux_color_theme_main; ?>; 
	}
	.pagenums a:hover,.pagenums .current,.page-numbers.current,.sidebar_widget .tagcloud a:hover,.related-post-wrap h3:before,.header-slider-item-more:hover,
	.process-bar,.nav-tabs > li > a:hover,.testimenials:hover,.testimenials:hover .arrow-bg,
	.sidebar_widget .widget_uxconatactform input#idi_send:hover,input.idi_send:hover,.page-numbers:hover,#bbp-user-navigation li a:hover,
	.woocommerce #content input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce-page #content input.button.alt, .woocommerce-page #respond input#submit.alt, 
	.woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt,
	.woocommerce #content input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce-page #content input.button.alt:hover, 
	.woocommerce-page #respond input#submit.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover,.woocommerce #commentform input[type="submit"]#submit,
	.chosen-container .chosen-results li.highlighted,.woocommerce .widget_layered_nav_filters ul li a, .woocommerce-page .widget_layered_nav_filters ul li a,.woocommerce-page #content input.button,.woocommerce-page #content input.button:hover
	{ 
		background-color:<?php echo $ux_color_theme_main; ?>;
	}
	textarea:focus,input[type="text"]:focus,input[type="password"]:focus,input[type="datetime"]:focus,input[type="datetime-local"]:focus,input[type="date"]:focus,input[type="month"]:focus,input[type="time"]:focus,input[type="week"]:focus,input[type="number"]:focus,input[type="email"]:focus,input[type="url"]:focus,input[type="search"]:focus,input[type="tel"]:focus,input[type="color"]:focus,.uneditable-input:focus,
	.sidebar_widget .widget_uxconatactform textarea:focus,.sidebar_widget .widget_uxconatactform input[type="text"]:focus,#respondwrap textarea:focus,#respondwrap input:focus
	{ 
		border-color:<?php echo $ux_color_theme_main; ?>; 
	}

	
<?php }


// Auxiliary Color
$ux_color_second_auxiliary = ux_get_option('theme_option_color_second_auxiliary');
if($ux_color_second_auxiliary){ ?>
	
	.slider-panel,.quote-wrap,#main_title_wrap,.nav-tabs > li,.item_des,.audio_player_list,.promote-wrap,.process-bar-wrap,.post_meta,.pagenumber a,.countdown_section,.progress-wrap .progress-bar,.interlock-item,
	.pagenumber span,.testimenials,.testimenials .arrow-bg,.carousel-wrap a,.pagenums a,.pagenums span,.accordion-heading,.page-numbers,.testimonial-thum-bg,.latest-posts-tit,.single-feild,.gallery-wrap-sidebar .related-post-wrap,.gallery-wrap-sidebar .comment-wrap,
	.woocommerce .woocommerce-message, .woocommerce-page .woocommerce-message,.woocommerce .woocommerce-error, .woocommerce-page .woocommerce-error,.woocommerce .woocommerce-info, .woocommerce-page .woocommerce-info,.cart-summary,.woocommerce-info,.returning-customer,table.shop_table th,
	.woocommerce-checkout form.checkout input[type="text"],.chosen-container-active.chosen-with-drop .chosen-single,.woocommerce-page form .form-row textarea,.woocommerce-checkout .form-row .chosen-container-single .chosen-single,
	.woocommerce form.login, .woocommerce form.checkout_coupon, .woocommerce form.register, .woocommerce-page form.login, .woocommerce-page form.checkout_coupon, .woocommerce-page form.register,.order_details,.order-address-box
	{ 
		background-color: <?php echo $ux_color_second_auxiliary; ?>; 
	}
	.progress_bars_with_image_content .bar .bar_noactive.grey 
	{
	  color: <?php echo $ux_color_second_auxiliary; ?>; 
	}
	.border-style2,.border-style3,.nav-tabs > li > a,.tab-content,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.tabs-v,.single-feild
	{ 
		border-color: <?php echo $ux_color_second_auxiliary; ?>; 
	}
	.nav.nav-tabs, .tabs-v .nav-tabs > li:last-child.active>a,#content .rotatingtweets, #content .norotatingtweets {
		border-bottom-color: <?php echo $ux_color_second_auxiliary; ?>; 
	}
	.tab-content.tab-content-v {
		border-left-color: <?php echo $ux_color_second_auxiliary; ?>; 
	}
	.tabs-v .nav-tabs > .active > a ,#content .rotatingtweets, #content .norotatingtweets {
		border-top-color: <?php echo $ux_color_second_auxiliary; ?>; 
	}
	
<?php }



//Logo Text Color
$ux_color_logo = ux_get_option('theme_option_color_logo');
if($ux_color_logo){ ?>
	
	#logo a, #logo-page a, #logo-mobile a,
	#logo a:hover, #logo-page a:hover, #logo-mobile a:hover,.site-loading-logo  { 
		color:<?php echo $ux_color_logo; ?> 
	}
	
<?php }



//Left Menu Bar
//Left Menu Bar Default Bg Color
$ux_bg_left_menu_bar = ux_get_option('theme_option_bg_left_menu_bar');
if($ux_bg_left_menu_bar){ ?>

	#sidebar,.site-loading,.page-loading,
	#navi ul li ul.sub-menu li, 
	#navi ul li:hover,
	.brick-grey,#header.mobile_active,
	.show_mobile_menu #mobile-advanced, .show_mobile_meta #mobile-header-meta

	{
		background-color: <?php echo $ux_bg_left_menu_bar; ?>;
	}

<?php }

//Menu Item Text Color
$ux_color_menu_item_text = ux_get_option('theme_option_color_menu_item_text');
if($ux_color_menu_item_text){ ?>

	#navi a,#mobile-advanced a,.menu-icon i,#navi ul li ul.sub-menu:before,
	input[type="text"].textboxsearch,.submit-wrap i,.icons-sidebar-unit,#woocomerce-cart-side a
	{ 
		color: <?php echo $ux_color_menu_item_text; ?>; 
	}
	.site-loading .loading-dot1, .site-loading .loading-dot2,
	.page-loading .loading-dot1, .page-loading .loading-dot2
	{ 
	  background-color: <?php echo $ux_color_menu_item_text; ?>; 
	}

<?php }

//Activated Item Text Color
$ux_color_menu_activated_item_text = ux_get_option('theme_option_color_menu_activated_item_text');
if($ux_color_menu_activated_item_text){ ?>

	#navi ul li:hover>a,
	#navi ul li.current-menu-item>a,
	#navi ul li.current-menu-ancestor>a,
	#mobile-advanced li>a:hover,
	#mobile-advanced li.current-menu-item>a,
	#mobile-advanced li.current-menu-ancestor>a,
	.icons-sidebar-unit:hover i
	{ 
		color:<?php echo $ux_color_menu_activated_item_text; ?>; 
	}
	#navi ul li a:before
	{ 
		background-color: <?php echo $ux_color_menu_activated_item_text; ?>; 
	}

<?php }

//Submenu Text Color
$ux_color_submenu_text = ux_get_option('theme_option_color_submenu_text');
if($ux_color_submenu_text){ ?>

	#navi ul.sub-menu a { color:<?php echo $ux_color_submenu_text; ?>; }

<?php }

//copyright Color
$ux_color_copyright_text = ux_get_option('theme_option_color_copyright');
if($ux_color_copyright_text){ ?>

	.copyright,.copyright a { color:<?php echo $ux_color_copyright_text; ?>; }

<?php }



//Posts & Pages
//Title Color  
$ux_color_title_light = ux_get_option('theme_option_color_title_light');
if($ux_color_title_light){ ?>
	
	#comments .comment-author a,h1,h2,h3,h4,h5,h6,.archive-tit a,.blog-item-main h2 a,.item_title a,#sidebar .social_active i:hover,.countdown_amount,.latest-posts-tit a,
	.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.accordion-heading .accordion-toggle,.item_des .item_title a,
	.infrographic.bar .bar-percent,.jqbar.vertical span,.item_title a,.team-item-con-back a,.team-item-con-back i,.team-item-con-h p,.slider-panel-item h2.slider-title a,
	#respondwrap textarea, #respondwrap input, .contactform input[type="text"], .contactform textarea,#respondwrap input#submit:hover,.contactform input[type="submit"]:hover,input.wpcf7-form-control.wpcf7-submit:hover,
	.woocommerce .woocommerce-message, .woocommerce .woocommerce-error, .woocommerce .woocommerce-info, .woocommerce-page .woocommerce-message, .woocommerce-page .woocommerce-error, .woocommerce-page .woocommerce-info
	{ 
		color:<?php echo $ux_color_title_light; ?>; 
	}
	
	li.commlist-unit,
	.gallery-wrap-fullwidth .gallery-info-property,
	.accordion-heading,
	#respondwrap textarea, #respondwrap input, .contactform input[type="text"], .contactform textarea,
	#respondwrap input#submit,.contactform input[type="submit"]
	{ 
		border-color: <?php echo $ux_color_title_light; ?>; 
	}
	h1.main-title:before,.team-item-con,.archive-wrap li:before,.ux-btn:hover,.related-post-wrap h2:before,#respondwrap input#submit,.contactform input[type="submit"],
	.galleria-info,#float-bar-triggler,.float-bar-inn,.galleria-image-nav-left:after, .galleria-image-nav-right:after,.comm-reply-title:after,.tw_style a,
	.promote-button:hover,.filter-floating li, .filter-floating-triggle,.item_title:before,.accordion-style-b .accordion-heading a:before,.accordion-style-b .accordion-heading a:after,
	.separator_inn.bg-,.carousel-indicators li,.woocommerce select.orderby,.woocommerce-page select.orderby,.woocommerce .widget_price_filter .price_slider_amount .button, 
	.woocommerce-page .widget_price_filter .price_slider_amount .button,.woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle
	 {
	  background-color: <?php echo $ux_color_title_light; ?>;
	}
	
<?php }

// Content text Color 
$ux_color_content_light = ux_get_option('theme_option_color_content_text_light');
if($ux_color_content_light){ ?>
	
	body,a,.entry p a:hover,.text_block a:hover,#content_wrap,#comments .reply a,#comments,.blog-item-excerpt,.item_des,.item_des a,
	h3#reply-title small, #comments .nav-tabs li.active h3#reply-title .logged,#comments .nav-tabs li a:hover h3 .logged,
	.header-info-mobile,.carousel-wrap a.disabled:hover,.filters li a:hover,
	.woocommerce #content .quantity .minus, .woocommerce #content .quantity .plus, .woocommerce .quantity .minus, .woocommerce .quantity .plus, .woocommerce-page #content .quantity .minus, .woocommerce-page #content .quantity .plus, .woocommerce-page .quantity .minus, .woocommerce-page .quantity .plus,
	.woocommerce a.button, .woocommerce button.button, .woocommerce #respond input#submit, .woocommerce #content input.button, .woocommerce-page a.button,.woocommerce-page #content input.button.update-cart-button,
	.woocommerce-page button.button, .woocommerce-page #respond input#submit, .woocommerce-message .ux-btn,.woocommerce p.stars span a:hover,.woocommerce input#coupon_code, .woocommerce input[type="text"].qty, 
	.woocommerce .woocommerce-message:before, .woocommerce-page .woocommerce-message:before,.woocommerce .woocommerce-error:before, .woocommerce-page .woocommerce-error:before,.woocommerce-message .ux-btn:hover,.woocommerce .woocommerce-info:before, .woocommerce-page .woocommerce-info:before,
	.chosen-container-single .chosen-single,.text_block .add_to_cart_button,.woocommerce .price .star-rating span, .woocommerce-page .price .star-rating span
	{ 
	  color: <?php echo $ux_color_content_light; ?>; 
	}
	.filters li a:before,.woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-range
	{
		background-color: <?php echo $ux_color_content_light; ?>; 
	}
	.woocommerce .order_details li, .woocommerce-page .order_details li
	{
		border-color: <?php echo $ux_color_content_light; ?>; 
	}
<?php }

//meta text Color 
$ux_color_auxiliary_content_light = ux_get_option('theme_option_color_auxiliary_content_light');
if($ux_color_auxiliary_content_light){ ?>
	
	.post_meta>li,.post_meta>li a,.blog_meta,.blog_meta a,.post-meta, .post-meta a,.archive-meta-unit,.archive-meta-unit a,.latest-posts-tags a,
	#mobile-header-meta p,.bbp-meta,.bbp-meta a,.bbp-author-role,.bbp-pagination-count,span.bbp-author-ip,.bbp-forum-content,.infrographic-subtit,
	.woocommerce .price del,.woocommerce .star-rating:before, .woocommerce-page .star-rating:before
	{ 
	  color:<?php echo $ux_color_auxiliary_content_light; ?>; 
	}
	.woocommerce .quantity input.qty, .woocommerce #content .quantity input.qty, .woocommerce-page .quantity input.qty, .woocommerce-page #content .quantity input.qty,
	.woocommerce .quantity .plus, .woocommerce .quantity .minus, .woocommerce #content .quantity .plus, .woocommerce #content .quantity .minus, .woocommerce-page .quantity .plus, 
	.woocommerce-page .quantity .minus, .woocommerce-page #content .quantity .plus, .woocommerce-page #content .quantity .minus 
	{
		border-color: <?php echo $ux_color_auxiliary_content_light; ?>; 
	}
	
<?php }


//Selected Text Bg Color
$ux_color_selected_text_bg = ux_get_option('theme_option_color_selected_text_bg');
if($ux_color_selected_text_bg){ ?>

    ::selection { background: <?php echo $ux_color_selected_text_bg; ?>; }
	::-moz-selection { background: <?php echo $ux_color_selected_text_bg; ?>; }
	::-webkit-selection { background: <?php echo $ux_color_selected_text_bg; ?>; }

<?php
}

// Content BG Color
$ux_bg_page_post = ux_get_option('theme_option_bg_page_post');
if($ux_bg_page_post){ ?>
	
	#main,.separator h4,.float-bar-triggler-inn:before, .float-bar-triggler-inn:after, .float-bar-triggler-inn,
	.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.tab-content,.filters.filter-floating li a:before,
	.chosen-container .chosen-drop,.modal-dialog .modal-content
	{ 
	  background-color: <?php echo $ux_bg_page_post; ?>;
	}
	.testimenials span.arrow,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus { 
		border-bottom-color: <?php echo $ux_bg_page_post; ?>; 
	}
	.tabs-v .nav-tabs > .active > a
	{ 
	  border-right-color: <?php echo $ux_bg_page_post; ?>; 
	}
	#post-navi ,#post-navi a,.float-bar-social-share button,#respondwrap input#submit,.contactform input[type="submit"],.tw_style a,
	.filter-floating a,.filter-floating a:hover,.filter-floating i,.galleria-info-title, .galleria-image-nav, .galleria-counter,
	.woocommerce select.orderby,.woocommerce-page select.orderby,.woocommerce .widget_price_filter .price_slider_amount .button, 
	.woocommerce-page .widget_price_filter .price_slider_amount .button
	{
	  color: <?php echo $ux_bg_page_post; ?>; 
	}
	
<?php }


//Sidebar
//Sidebar bg Color
$ux_color_sidebar_widget_bg = ux_get_option('theme_option_color_sidebar_widget_bg');
if($ux_color_sidebar_widget_bg){ ?>
	
	#sidebar-widget { 
	  background-color: <?php echo $ux_color_sidebar_widget_bg; ?>;
	}
	
<?php }

//Sidebar Widget Title Color
$ux_color_sidebar_widget_title = ux_get_option('theme_option_color_sidebar_widget_title');
if($ux_color_sidebar_widget_title){ ?>
	
	.sidebar_widget h3.widget-title,
	.sidebar_widget h3.widget-title a { 
	  color: <?php echo $ux_color_sidebar_widget_title; ?>;
	}
	
<?php }

//Sidebar Widget content Color
$ux_color_sidebar_con_color = ux_get_option('theme_option_color_sidebar_content_color');
if($ux_color_sidebar_con_color){ ?>
	
	.sidebar_widget,
	.sidebar_widget a,
	.woocommerce .sidebar_widget a.button,
	.woocommerce .sidebar_widget a.button:hover { 
	  color: <?php echo $ux_color_sidebar_con_color; ?>; 
	}

	.woocommerce .sidebar_widget a.button,
	.woocommerce .sidebar_widget a.button:hover {
	  border-color: <?php echo $ux_color_sidebar_con_color; ?>; 
	}

	.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content, 
	.woocommerce-page .widget_price_filter .price_slider_wrapper .ui-widget-content {
	  background-color: <?php echo $ux_color_sidebar_con_color; ?>; 
	}

<?php }



//FullScreen Post Slider

//FullScreen Post Slider BG color
$ux_color_fullscreen_post_slider_bg = ux_get_option('theme_option_bg_fullscreen_post_slider');
if($ux_color_fullscreen_post_slider_bg){ ?>
	
	.galleria-container {
	  background-color: <?php echo $ux_color_fullscreen_post_slider_bg; ?>;
	}
	
<?php }


//## Font ########################################################################################

//main font
$ux_main_font = ux_get_option('theme_option_font_family_main');
$ux_main_font = $ux_main_font != -1 ? $ux_main_font : false;
if($ux_main_font){
	$ux_main_font = str_replace('+', ' ', $ux_main_font); ?>
	body,input[type="text"],textarea,div.bbp-template-notice p,legend { font-family: <?php echo $ux_main_font; ?>;}
<?php }
//mainfont style
$ux_main_font_style = ux_get_option('theme_option_font_style_main');
if($ux_main_font_style){ ?>
    body,input[type="text"],textarea,div.bbp-template-notice p,legend { <?php echo ux_theme_google_font_style($ux_main_font_style); ?>}
<?php }

//heading font
$ux_heading_font = ux_get_option('theme_option_font_family_heading');
$ux_heading_font = $ux_heading_font != -1 ? $ux_heading_font : false;
if($ux_heading_font){
	$ux_heading_font = str_replace('+', ' ', $ux_heading_font); ?>
	h1,h2,h3,h4,h5,h6 { font-family: <?php echo $ux_heading_font; ?>; }
<?php }
//heading style
$ux_heading_font_style = ux_get_option('theme_option_font_style_heading');
if($ux_heading_font_style){ ?>
    h1,h2,h3,h4,h5,h6 { <?php echo ux_theme_google_font_style($ux_heading_font_style); ?>}
<?php }


//logo font
$ux_logo_font = ux_get_option('theme_option_font_family_logo');
$ux_logo_font = $ux_logo_font != -1 ? $ux_logo_font : false;
if($ux_logo_font){
	$ux_logo_font = str_replace('+', ' ', $ux_logo_font); ?>
	#logo a, #logo-page a, #logo-mobile a,.site-loading-logo { font-family: <?php echo $ux_logo_font; ?>;}
<?php }
//logo size
$ux_logo_font_size = ux_get_option('theme_option_font_size_logo');
if($ux_logo_font_size){ ?>
    #logo a, #logo-page a, #logo-mobile a,.site-loading-logo{ font-size: <?php echo $ux_logo_font_size; ?>;}
<?php }
//logo style
$ux_logo_font_style = ux_get_option('theme_option_font_style_logo');
if($ux_logo_font_style){ ?>
    #logo a, #logo-page a, #logo-mobile a,.site-loading-logo{ <?php echo ux_theme_google_font_style($ux_logo_font_style); ?>}
<?php }


//menu font
$ux_menu_font = ux_get_option('theme_option_font_family_menu');
$ux_menu_font = $ux_menu_font != -1 ? $ux_menu_font : false;
if($ux_menu_font){
	$ux_menu_font = str_replace('+', ' ', $ux_menu_font); ?>
	#navi a { font-family: <?php echo $ux_menu_font; ?>;}
<?php }
//menu size
$ux_menu_font_size = ux_get_option('theme_option_font_size_menu');
if($ux_menu_font_size){ ?>
    #navi a { font-size: <?php echo $ux_menu_font_size; ?>;}
<?php }
//menu style
$ux_menu_font_style = ux_get_option('theme_option_font_style_menu');
if($ux_menu_font_style){ ?>
    #navi a { <?php echo ux_theme_google_font_style($ux_menu_font_style); ?>}
<?php }

//copyright
$ux_copyright_font_size = ux_get_option('theme_option_font_size_copyright');
if($ux_copyright_font_size){ ?>
    .copyright { font-size: <?php echo $ux_copyright_font_size; ?>;}
<?php }

//Post & page Title size
$ux_post_page_title_font_size = ux_get_option('theme_option_font_size_post_page_title');
if($ux_post_page_title_font_size){ ?>
    h1.main-title { font-size: <?php echo $ux_post_page_title_font_size; ?>;}
<?php }
//Post & page Title style
$ux_post_page_title_font_style = ux_get_option('theme_option_font_style_post_page_title');
if($ux_post_page_title_font_style){ ?>
    h1.main-title { <?php echo ux_theme_google_font_style($ux_post_page_title_font_style); ?>}
<?php }

//Post & page Content size
/*$ux_post_page_content_font_size = ux_get_option('theme_option_font_size_post_page_content');
if($ux_post_page_content_font_size){ ?>
    #content_wrap { font-size: <?php echo $ux_post_page_content_font_size; ?>;}
<?php }*/
//Post & page Content style
$ux_post_page_content_font_style = ux_get_option('theme_option_font_style_post_page_content');
if($ux_post_page_content_font_style){ ?>
    #content_wrap { <?php echo ux_theme_google_font_style($ux_post_page_content_font_style); ?>}
<?php }

//Sidebar Widget Title size
$ux_sidebar_widget_title_font_size = ux_get_option('theme_option_font_size_sidebar_widget_title');
if($ux_sidebar_widget_title_font_size){ ?>
    ul.sidebar_widget h3.widget-title { font-size: <?php echo $ux_sidebar_widget_title_font_size; ?>; }
<?php }
//Sidebar Widget Title style
$ux_sidebar_widget_title_font_style = ux_get_option('theme_option_font_style_sidebar_widget_title');
if($ux_sidebar_widget_title_font_style){ ?>
    ul.sidebar_widget h3.widget-title { <?php echo ux_theme_google_font_style($ux_sidebar_widget_title_font_style); ?> }
<?php }

//Sidebar Widget Content size
$ux_sidebar_widget_content_font_size = ux_get_option('theme_option_font_size_sidebar_widget_content');
if($ux_sidebar_widget_content_font_size){ ?>
    ul.sidebar_widget .widget-container { font-size: <?php echo $ux_sidebar_widget_content_font_size; ?>;}
<?php }
//Sidebar Widget Content style
$ux_sidebar_widget_content_font_style = ux_get_option('theme_option_font_style_sidebar_widget_content');
if($ux_sidebar_widget_content_font_style){ ?>
    ul.sidebar_widget { <?php echo ux_theme_google_font_style($ux_sidebar_widget_content_font_style); ?>}
<?php }

//FullScreen Post Slider Text
$ux_font_size_fullscreen_post_slider = ux_get_option('theme_option_font_size_fullscreen_post_slider');
if($ux_font_size_fullscreen_post_slider){ ?>
	.galleria-info-title { font-size: <?php echo $ux_font_size_fullscreen_post_slider; ?>;}
<?php }


//Custom css
$ux_custom_css = ux_get_option('theme_option_custom_css');
if($ux_custom_css){ 
	echo $ux_custom_css;
}
?>
