<?php
//theme meta interface
function ux_theme_post_meta_interface(){
	$ux_theme_post_meta_fields = ux_theme_post_meta_fields();
		
	if(!empty($ux_theme_post_meta_fields[get_post_type()])){
		$ux_theme_post_meta_posttype = $ux_theme_post_meta_fields[get_post_type()];
		foreach($ux_theme_post_meta_posttype as $option){
			$format = isset($option['format']) ? 'data-format="' . $option['format'] . '"' : false; ?>
            <div class="postbox ux-theme-box ux-theme-meta-box" <?php echo $format; ?>>
                <h3 class="hndle"><span><?php echo $option['title']; ?></span></h3>
                <div class="inside">
                    <?php if(isset($option['action'])){
						do_action('ux-theme-post-meta-interface', $option['id']);
					}else{
						if(isset($option['section'])){
							foreach($option['section'] as $section){
								$subclass = isset($section['subclass']) ? 'theme-option-item-body' : false;
								$title = isset($section['title']) ? $section['title'] : false;
								$super_control = isset($section['super-control']) ? 'data-super="' . $section['super-control']['name'] . '" data-supervalue="' . $section['super-control']['value'] . '"' : false; ?>
                                
								<div class="theme-option-item" <?php echo $super_control; ?>>
									<h4 class="theme-option-item-heading">
										<?php echo '<span>' . $title . '</span>'; ?>
									</h4>
									<div class="<?php echo $subclass; ?>">
										<?php if(isset($section['item'])){
											foreach($section['item'] as $item){
												$control = isset($item['control']) ? 'data-name="' . $item['control']['name'] . '" data-value="' . $item['control']['value'] . '"' : false; 
												$item_format = isset($item['format']) ? 'data-format="' . $item['format'] . '"' : false;
												if($item['type'] == 'divider' || $item['type'] == 'description' || $item['type'] == 'gallery'){
													ux_theme_option_getfield($item, 'ux_theme_meta');
												}else{ ?>
                                                    <div class="row <?php echo $item['name']; ?>" <?php echo $control; ?> <?php echo $item_format; ?>>
                                                        <div class="col-xs-3">
                                                            <?php if(isset($item['title'])){ ?>
                                                                <h5><?php echo $item['title']; ?></h5>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-xs-9">
                                                            <?php if(isset($item['bind'])){
                                                                foreach($item['bind'] as $bind){
                                                                    if($bind['position'] == 'before'){
                                                                        ux_theme_option_getfield($bind, 'ux_theme_meta');
                                                                    }
                                                                }
                                                            }
                                                            
                                                            ux_theme_option_getfield($item, 'ux_theme_meta');
                                                            
                                                            if(isset($item['bind'])){
                                                                foreach($item['bind'] as $bind){
                                                                    if($bind['position'] == 'after'){
                                                                        ux_theme_option_getfield($bind, 'ux_theme_meta');
                                                                    }
                                                                }
                                                            } ?>
                                                            <?php if(isset($item['description'])){ ?>
                                                                <p class="text-muted"><?php echo $item['description']; ?></p>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php
												}
											}
										} ?>
									</div>
								</div>
							<?php 
							}
						}
					} ?>
                </div>
            </div>
        <?php } ?>
        <div class="ux-theme-box"><?php ux_theme_option_modal(); ?></div>
        <input type="hidden" name="custom_meta_box_nonce" value="<?php echo wp_create_nonce(ABSPATH); ?>" />
	<?php
    }
}
add_action('edit_form_after_editor', 'ux_theme_post_meta_interface');

?>