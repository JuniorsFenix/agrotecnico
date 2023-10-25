<?php
//define
define('UX_PAGEBUILDER', get_template_directory_uri(). '/functions/pagebuilder' );

//pagebuilder scripts
function ux_pb_admin_enqueue_scripts(){
	global $post;
	if($post){
		wp_enqueue_script('ux-pb-pagebuilder-googlemap');
	}
	wp_enqueue_script('ux-pb-pagebuilder-script');
}
add_action('admin_enqueue_scripts', 'ux_pb_admin_enqueue_scripts', 50);

//pagebuilder style
function ux_pb_admin_enqueue_styles(){
	wp_enqueue_style('ux-pb-bootstrap-datetimepicker');
	wp_enqueue_style('ux-pb-pagebuilder-style');
}
add_action('admin_enqueue_scripts', 'ux_pb_admin_enqueue_styles', 100);

//pagebuilder theme scripts
function ux_pb_theme_enqueue_scripts(){
	global $post;
	if($post){
		$ux_pb_switch = get_post_meta($post->ID, 'ux-pb-switch', true);
		if($ux_pb_switch == 'pagebuilder'){
			wp_enqueue_style('ux-admin-theme-icons');
			wp_enqueue_script('ux-pb-theme-pagebuilder-script');
		}
	}
}
add_action('wp_enqueue_scripts', 'ux_pb_theme_enqueue_scripts', 150);


//pagebuilder ajax
function ux_pb_theme_head_ajax(){ ?>
	<script type="text/javascript">
		var AJAX_M = "<?php echo UX_PAGEBUILDER . '/pagebuilder-theme-ajax.php'; ?>";
	</script>
<?php	
}
add_action('wp_head', 'ux_pb_theme_head_ajax');

//pagebuilder itemid to postid
function ux_pb_item_postid($itemid){
	$get_posts = get_posts(array(
		'posts_per_page' => -1,
		'name' => $itemid,
		'post_type' => 'modules'
	));
	
	$post_id = $get_posts ? $get_posts[0]->ID : false;
	return $post_id;
}

//pagebuilder has_module
function ux_has_module($module){
   $return = false;
   if(is_singular('post') || is_page()){
	   global $post;
	   $ux_pb_meta = get_post_meta($post->ID, 'ux_pb_meta', true);
	   
	   if($ux_pb_meta){
		   $moduleid_date = array();
		   foreach($ux_pb_meta as $i => $wrap){
				$moduleid = isset($wrap['moduleid']) ? $wrap['moduleid'] : false;
				if($moduleid){
					$moduleid_date['w_' . $i] = $moduleid;
				}
				
				$items = isset($wrap['items']) ? $wrap['items'] : false;
				if($items){
					foreach($items as $item_num => $item){
						$moduleid = isset($item['moduleid']) ? $item['moduleid'] : false;
						
						if($moduleid){
							$moduleid_date['i_' . $item_num] = $moduleid;
						}
					}
				}
		   }
		   if(in_array($module, $moduleid_date)){
			   $return = true;
		   }
	   }
   }
   
   return $return;
}

//pagebuilder meta save
function ux_pb_meta_save($post_id) {  
    $ux_pb_meta = array('ux_pb_meta', 'ux-pb-switch');
	
	if(!isset($_POST['custom_meta_box_nonce'])){
		$post_nonce = '';
	}else{
		$post_nonce = $_POST['custom_meta_box_nonce'];
	}
	
	if (!wp_verify_nonce($post_nonce, ABSPATH))  
		return $post_id; 
	
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
        return $post_id;  
    
    if('page' == $_POST['post_type']){  
        if (!current_user_can('edit_page', $post_id))  
            return $post_id;  
        } elseif (!current_user_can('edit_post', $post_id)) {  
            return $post_id;  
    }
	
	foreach($ux_pb_meta as $meta){
		$old = get_post_meta($post_id, $meta, true);  
		$new = @$_POST[$meta];  
	
		if ($new && $new != $old) {  
			update_post_meta($post_id, $meta, $new);  
		} elseif ('' == $new && $old) {  
			delete_post_meta($post_id, $meta, $old);  
		}
	}
	
	return $post_id;
}  
add_action('save_post', 'ux_pb_meta_save'); 

//pagebuilder box bgcolor
function ux_pb_box_bgcolor(){
	$theme_color = ux_theme_color();
	foreach($theme_color as $color){ ?>
        <span data-id="<?php echo $color['id']; ?>" data-rgb="<?php echo $color['rgb']; ?>"></span>
    <?php	
	}
}

//require pagebuilder register
require_once locate_template('/functions/pagebuilder/pagebuilder-register.php');

//require pagebuilder interface
require_once locate_template('/functions/pagebuilder/pagebuilder-interface.php');

//require pagebuilder config
require_once locate_template('/functions/pagebuilder/pagebuilder-config.php');

//require pagebuilder fields
require_once locate_template('/functions/pagebuilder/pagebuilder-fields.php');

//require pagebuilder ajax
require_once locate_template('/functions/pagebuilder/pagebuilder-ajax.php');

//require pagebuilder modules
require_once locate_template('/functions/pagebuilder/pagebuilder-modules.php');

//require pagebuilder import
require_once locate_template('/functions/pagebuilder/pagebuilder-import.php');

//include plugin
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
?>