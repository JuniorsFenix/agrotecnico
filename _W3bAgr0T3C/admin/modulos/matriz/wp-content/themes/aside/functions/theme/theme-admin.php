<?php
//define
define('UX_THEME', get_template_directory_uri(). '/functions/theme' );
define('UX_THEME_OPTIONS', get_template_directory_uri(). '/functions/theme/options' );
define('UX_THEME_WIDGET', get_template_directory_uri(). '/functions/theme/widget' );
define('UX_THEME_SHORTCODES', get_template_directory_uri(). '/functions/theme/shortcodes' );
define('UX_THEME_IMPORTER', get_template_directory_uri(). '/functions/theme/wordpress-importer' );
define('UX_THEME_CUSTOMIZE', get_template_directory_uri(). '/functions/theme/customize' );

//theme scripts
function ux_theme_options_enqueue_scripts(){	
	// New Media Library
	if(function_exists('wp_enqueue_media')){ wp_enqueue_media(); }

	// Load default WP resources
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('wp-pointer');
	wp_enqueue_style('wp-pointer');
	wp_enqueue_script('json2');
	
	
	wp_enqueue_script('jquery-ui-droppable');
	wp_enqueue_script('jquery-ui-draggable');
	
	wp_enqueue_script('ux-admin-bootstrap');
	wp_enqueue_script('ux-admin-bootstrap-switch');
	wp_enqueue_script('ux-admin-bootstrap-paginator');
	wp_enqueue_script('ux-admin-bootstrap-datetimepicker');
	wp_enqueue_script('ux-admin-isotope');
	wp_enqueue_script('ux-admin-minicolors');
	wp_enqueue_script('ux-admin-icheck');
	wp_enqueue_script('ux-admin-theme-script');
	
	wp_enqueue_style('ux-admin-bootstrap');
	wp_enqueue_style('font-awesome');
	wp_enqueue_style('ux-admin-bootstrap-theme');
	wp_enqueue_style('ux-admin-bootstrap-switch');
	wp_enqueue_style('ux-admin-bootstrap-datetimepicker');
	wp_enqueue_style('ux-admin-minicolors');
	wp_enqueue_style('ux-admin-icheck');
	wp_enqueue_style('ux-admin-theme-icons');
	wp_enqueue_style('ux-admin-theme-style');
	wp_enqueue_style('custom-css');
}
add_action('admin_enqueue_scripts','ux_theme_options_enqueue_scripts', 10);

//theme admin head
function ux_theme_admin_head(){ ?>
	<script type="text/javascript">
		var UX_THEME_SHORTCODES = "<?php echo UX_THEME_SHORTCODES; ?>";
	</script>
<?php }
add_action('admin_head', 'ux_theme_admin_head');

//theme post type support
function ux_theme_support(){
	add_theme_support('title-tag');
	add_post_type_support('post', array('excerpt', 'comments'));
	add_post_type_support('page', 'excerpt');
	
	add_theme_support('post-formats', array('gallery', 'link', 'image', 'quote', 'video', 'audio'));
	add_theme_support('automatic-feed-links');
	add_theme_support('custom-header');
	add_theme_support('custom-background');
	add_theme_support('post-thumbnails');
	
	add_image_size('blog-thumb', 200, 200, true);
	add_image_size('imagebox-thumb', 400, 400, true);
	add_image_size('standard-blog-thumb', 800, 400, true);
	add_image_size('standard-thumb', 800, 9999);
	add_image_size('image-thumb', 800, 480, true);
	add_image_size('image-thumb-1', 800, 800, true);
	add_image_size('image-thumb-2', 400, 800, true);
	
	if(!isset($content_width)) $content_width = 1220;
}
add_action('init','ux_theme_support');

//ux theme breadcrumb
function ux_theme_breadcrumb(){
	if(function_exists('show_full_breadcrumb')){
		show_full_breadcrumb();
	}
}

function ux_cheakother(){
	add_editor_style();
	echo posts_nav_link();
}

//require theme register
require_once locate_template('/functions/theme/theme-register.php');

//require theme options
require_once locate_template('/functions/theme/theme-options.php');

//require theme post
require_once locate_template('/functions/theme/theme-post.php');

//require theme widget
require_once locate_template('/functions/theme/theme-widget.php');

//require theme shortcodes
require_once locate_template('/functions/theme/theme-shortcodes.php');

//require theme ajax
require_once locate_template('/functions/theme/theme-ajax.php');

//require theme import
require_once locate_template('/functions/theme/theme-import.php');

//require theme export
require_once locate_template('/functions/theme/theme-export.php');

//require theme customize
require_once locate_template('/functions/theme/customize/customize-options.php');

//Load wordpress importer
if(!function_exists('wordpress_importer_init')){
	require_once locate_template('/functions/theme/wordpress-importer/wordpress-importer.php');
}

//require theme nav menu
require_once locate_template('/functions/theme/theme-nav-menu.php');
?>