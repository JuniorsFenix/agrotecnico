<?php
//price template
function ux_pb_module_price($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//price confing
		$items        = get_post_meta($module_post, 'module_price_items', true);
		$currency     = get_post_meta($module_post, 'module_price_currency', true);
		$runtime      = get_post_meta($module_post, 'module_price_runtime', true);
		$runtime_show = get_post_meta($module_post, 'module_price_runtime_show', true);
		
		$currency     = $currency ? $currency : '$';
		
		$runtime_data = array();
		if($runtime_show){
			if(is_array($runtime_show)){
				$runtime_data = $runtime_show;
			}else{
				array_push($runtime_data, $runtime_show);
			}
		}
		
		if($items){ ?>
            <div class="price-wrap">
				<?php
                $items_count = count($items['items']);
				$subcontrol_value = array();
                $get_subcontrol = ux_pb_getfield_subcontrol('module_price_items');
                if($get_subcontrol){
                    foreach($get_subcontrol as $subcontrol => $field){
                        $field_value = $field['value'];
                        $field_type = $field['type']; 
                        $subcontrol_value[$field_value] = $items[$subcontrol];
                    }
                }
                
                for($i = 0; $i < $items_count; $i++){
                    $bgcolor     = $subcontrol_value['bgcolor'][$i];
                    $title       = $subcontrol_value['title'][$i];
                    $price       = $subcontrol_value['price'][$i];
                    $details     = $subcontrol_value['textarea'][$i];
                    $button_text = $subcontrol_value['button_text'][$i];
                    $button_link = $subcontrol_value['button_link'][$i];
					$bgcolor     = $bgcolor ? 'bg-' . ux_theme_switch_color($bgcolor) : 'bg-theme-color-1';
					$button_link = $button_link ? $button_link : __('Buy Now','ux'); ?>
                    
                    <section class="pirce-item <?php echo $bgcolor; ?>">
                        <h2 class="pirce-title"><?php echo $title; ?></h2>
                        <div class="price-number">
                        <div class="price-mask"></div>
                            <p class="price-number-b"><?php echo $price; ?></p>
                            <p class="price-currency"><?php echo $currency; ?></p>
                            <?php if(!in_array("hide_runtime", $runtime_data)){ ?>
                                <p class="price-runtime"><?php echo $runtime; ?></p>
                            <?php } ?>
                        </div>
                        <?php 
						if($details != ''){
							$details = explode('|||', $details);
							if(count($details)){ ?>
                                <ul class="price-list">
									<?php foreach($details as $detail){
										$detail = explode('||', $detail);
										$detail_text = $detail[1];
										
										$icon_class = isset($detail[0]) ? '<i class="'.$detail[0].'"></i>' : false;
										$icon_noting = isset($detail[0]) && $detail[0] == 'noting' ? 'price-list-item-no-icon' : false; ?>
                                        <li class="price-list-item">
											<?php echo $icon_class; ?>
                                            <p class="price-list-item-text <?php echo $icon_noting; ?>"><?php echo $detail_text; ?></p></li>
                                    <?php } ?>
                                </ul>
                            
                            <?php
							}
						} ?>
                        <a href="<?php echo esc_url($button_link); ?>" class="price-button"><?php echo $button_text; ?></a>
                    </section><!--End price-item-->
                    
                <?php } ?>
            </div>
		<?php
		}
    }
	
}
add_action('ux-pb-module-template-price', 'ux_pb_module_price');

//price select fields
function ux_pb_module_price_select($fields){
	$fields['module_price_runtime_show'] = array(
		array('title' => __('Hide Runtime','ux'), 'value' => 'hide_runtime')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_price_select');

//price config fields
function ux_pb_module_price_fields($module_fields){
	$module_fields['price'] = array(
		'id' => 'price',
		'animation' => 'class-2',
		'title' => __('Price', 'ux'),
		'item' =>  array(
			array('title' => __('Currency', 'ux'),
				  'description' => __('Enter the Currency Symbol', 'ux'),
				  'type' => 'text',
				  'name' => 'module_price_currency',
				  'unit' => __('$', 'ux')),
				  
			array('title' => __('Runtime', 'ux'),
				  'description' => __('Enter the runtime, e.g. per month', 'ux'),
				  'type' => 'text',
				  'name' => 'module_price_runtime',
				  'bind' => array(
					  array('type' => 'checkbox-group',
							'name' => 'module_price_runtime_show',
							'position' => 'after')
				  )),
			
			array('title' => __('Add Item', 'ux'),
				  'description' => __('Press the "Add" button to add an item', 'ux'),
				  'type' => 'items',
				  'name' => 'module_price_items',
				  'count' => 4),
			
			array('title' => __('Color', 'ux'),
				  'description' => __('Select a color for the price card', 'ux'),
				  'type' => 'bg-color',
				  'name' => 'module_price_card_color',
				  'subcontrol' => 'module_price_items|bgcolor'
				  ),
			
			array('title' => __('Title', 'ux'),
				  'description' => __('Enter the name of this product, it would be placed on the top of the card.', 'ux'),
				  'type' => 'text',
				  'name' => 'module_price_card_title',
				  'subcontrol' => 'module_price_items|title'),
				  
			array('title' => __('Price', 'ux'),
				  'description' => __('Enter the price of this product.', 'ux'),
				  'type' => 'text',
				  'name' => 'module_price_card_price',
				  'subcontrol' => 'module_price_items|price'),
				  
			array('title' => __('Details', 'ux'),
				  'description' => __('EPress "Add" button to add detail items', 'ux'),
				  'type' => 'price-item',
				  'name' => 'module_price_card_price_details',
				  'subcontrol' => 'module_price_items|textarea'),

			array('title' => __('Button Text', 'ux'),
				  'description' => __('Enter the text you want to show on button, e.g. Buy Now!', 'ux'),
				  'type' => 'text',
				  'name' => 'module_price_card_button_text',
				  'subcontrol' => 'module_price_items|button_text'),
				  
			array('title' => __('Button Link', 'ux'),
				  'description' => __('Enter the link for this button', 'ux'),
				  'type' => 'text',
				  'name' => 'module_price_card_button_link',
				  'subcontrol' => 'module_price_items|button_link'),
			
			array('title' => __('Advanced Settings', 'ux'),
				  'description' => __('magin and animations', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_advanced_settings',
				  'default' => 'off'),
				  
			array('title' => __('Bottom Margin', 'ux'),
				  'description' => __('the spacing outside the bottom of module', 'ux'),
				  'type' => 'select',
				  'name' => 'module_bottom_margin',
				  'default' => 'bottom-space-40',
				  'control' => array(
					  'name' => 'module_advanced_settings',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Scroll in Animation', 'ux'),
				  'description' => __('enable to select Scroll in animation effect', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_scroll_in_animation',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_advanced_settings',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Scroll in Animation Effect', 'ux'),
				  'description' => __('animation effect when the module enter the scene', 'ux'),
				  'type' => 'select',
				  'name' => 'module_scroll_animation_one',
				  'default' => 'fadein',
				  'control' => array(
					  'name' => 'module_scroll_in_animation',
					  'value' => 'on'
				  ))
				  
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_price_fields');
?>