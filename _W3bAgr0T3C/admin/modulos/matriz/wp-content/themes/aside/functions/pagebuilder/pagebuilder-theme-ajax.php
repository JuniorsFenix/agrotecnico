<?php
header("charset: UTF-8");
require_once('../../../../../wp-load.php');
$data = $_POST['data'];
$mode = $_POST['mode'];

switch($mode){
	case 'module':
		$module_id = $data["module_id"];
		$paged = $data["paged"];
		$post_id = $data["post_id"];
		$module_post = $data["module_post"];
		
		switch($module_id){
			case 'blog':
				ux_pb_module_load_blog($module_post, $paged);
			break;
			
			case 'team':
				ux_pb_module_load_team($module_post, $paged);
			break;
			
			case 'portfolio':
				ux_pb_module_load_portfolio($module_post, $paged);
			break;
			
			case 'liquid-list':
				ux_pb_module_load_liquidlist($module_post, $paged);
			break;
			
			case 'gallery':
				ux_pb_module_load_gallery($module_post, $paged);
			break;
		}
	break;
	
	case 'liquid':
	$post_id = $data["post_id"];
	$block_words = $data["block_words"];
	$show_social = $data["show_social"];
	$image_ratio = $data["image_ratio"];
	
	ux_pb_view_liquid_load($post_id, $block_words, $show_social, $image_ratio);
	break;
	
	/*case 'captcha':
		$captcha = new UXCaptcha();
		$prefix = mt_rand();
		$captcha_word = $captcha->generate_random_word();
		$captcha_img = $captcha->generate_image($prefix, $captcha_word); ?>
        
        <input type="hidden" value="<?php echo $captcha_word; ?>" name="ux_captcha_word" />
        <input type="text" id="enterVerify" name="enterVerify" class="requiredField captcha" placeholder="<?php _e('Captcha', 'ux'); ?>" />
        <span class="verifyNum" id="verifyNum"><img src="<?php echo $captcha->ux_captcha_tmp_url() . '/' . $captcha_img; ?>" /></span>
	<?php
    break;*/
	
}

?>