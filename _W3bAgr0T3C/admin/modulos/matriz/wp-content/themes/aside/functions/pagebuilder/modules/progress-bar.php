<?php
//progress bar template
function ux_pb_module_progressbar($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//progress bar confing
		$type            = get_post_meta($module_post, 'module_infographic_type', true);
		$title           = get_post_meta($module_post, 'module_infographic_title', true);
		$subtitle        = get_post_meta($module_post, 'module_infographic_subtitle', true);
		$percent         = get_post_meta($module_post, 'module_infographic_percent', true);
		$percent_color   = get_post_meta($module_post, 'module_infographic_percentage_color', true);
		$pict_actcolor   = get_post_meta($module_post, 'module_infographic_active_color', true);
		$show_background = get_post_meta($module_post, 'module_infographic_show_background', true);
		$number_active   = get_post_meta($module_post, 'module_infographic_number_active_icons', true);
		$number_color    = get_post_meta($module_post, 'module_infographic_number_color', true);
		$number_icons    = get_post_meta($module_post, 'module_infographic_number_icons', true);
		$icon            = get_post_meta($module_post, 'module_infographic_icon', true);
		$digit           = get_post_meta($module_post, 'module_infographic_digit', true);
		$items           = get_post_meta($module_post, 'module_infographic_columns', true);
		
		$default_bg_value  = ux_get_option('theme_option_color_theme_main');
		$default_bg_value  = $default_bg_value ? $default_bg_value : '#333333';
		$second_color    = ux_get_option('theme_option_color_second_auxiliary');
		$second_color    = $second_color ? $second_color : '#f7f7f7';
		$percent         = $percent ? $percent : 0;
		$digit           = $digit ? $digit : 0;
		$number_active   = $number_active ? $number_active : 0;
		$number_icons    = $number_icons ? $number_icons : 0;
		$bg_color        = $percent_color ? 'bg-' . ux_theme_switch_color($percent_color) : 'post-bgcolor-default';
		$bg_color_rgb    = $percent_color ? ux_theme_switch_color($percent_color, 'rgb') : $default_bg_value;
		$second_background = $show_background == 'on' ? $second_color : false;


		?>
		<?php
		switch($type){
			case 'bar':
				$second_background = $show_background == 'on' ? 'style="background-color:' . $second_color . ';"' : false; ?>
                <section class="infrographic bar ux-mod-nobg">
					<?php if($title){ ?><h1><?php echo $title; ?></h1><?php } ?><div class="bar-percent"><div class="bignumber-item " data-digit="<?php echo $percent; ?>">0</div>%</div>
                    
                    <div class="progress-outer">
                    	<div class="progress-wrap progress <?php echo $bg_color; ?>" data-progress-percent="<?php echo $percent; ?>">    
                        	<div class="progress-bar progress" <?php echo $second_background; ?>><div class="pr-head <?php echo $bg_color; ?>"></div></div>
                    	</div>
               		</div>
                </section>
            <?php
			break;
			
			case 'pie': ?>
                <section class="infrographic pie ux-mod-nobg">
                    <section class="pie-item">
                        <input class="knob" data-width="120" data-height="120" data-thickness=.03 data-bgcolor="<?php echo $second_background; ?>" value="0" data-val="<?php echo $percent; ?>" data-readOnly=true data-fgColor="<?php echo $bg_color_rgb; ?>">
                        <?php if($title){ ?><h1 class="infrographic-tit"><?php echo $title; ?></h1><?php } ?>
                        <?php if($subtitle){ ?><p class="infrographic-subtit"><?php echo $subtitle; ?></p><?php } ?>
                    </section>
                </section>
            <?php
            break;
			
			case 'pictorial':
				$bg_color = $pict_actcolor ? ux_theme_switch_color($pict_actcolor) : 'post-color-default'; ?>
                <section class="infrographic pictorial">
                    <div class="progress_bars_with_image_content clearfix" data-number="<?php echo $number_active; ?>">
                        <?php if(count($number_icons)){
                            for($i=0; $i < intval($number_icons); $i++){ ?>
                                <div class="bar">
                                    <i class="bar_noactive grey <?php echo $icon; ?>">&nbsp;</i>
                                    <i class="bar_active <?php echo $bg_color; ?> <?php echo $icon; ?>">&nbsp;</i>
                                </div>
                            <?php
                            }
                        } ?>
                        
                    </div>
                </section>
            <?php
            break;
			
			case 'big_number':
				$number_color = $number_color ? ux_theme_switch_color($number_color) : 'post-color-default'; ?>
                <section class="infrographic bignumber ux-mod-nobg">
                    <div class="bignumber-item <?php echo $number_color; ?>" data-digit="<?php echo $digit; ?>">0</div>
                    <?php if($title){ ?><h1 class="infrographic-tit"><?php echo $title; ?></h1><?php } ?>
                    <?php if($subtitle){ ?><p class="infrographic-subtit"><?php echo $subtitle; ?></p><?php } ?>
                </section><!--End infrographic bignumber-->
            <?php
            break;
			
			case 'column':
				$second_background = $show_background == 'on' ? 'style="background-color:' . $second_color . ';"' : false; ?>
                <section class="infrographic columns ux-mod-nobg">
					<?php if($items){
                        $items_count = count($items['items']);
						$subcontrol_value = array();
						$get_subcontrol = ux_pb_getfield_subcontrol('module_infographic_columns');
						if($get_subcontrol){
							foreach($get_subcontrol as $subcontrol => $field){
								$field_value = $field['value'];
								$field_type = $field['type']; 
								$subcontrol = $field_type == 'content' ? 'ux-pb-module-content' : $subcontrol;
								$subcontrol_value[$field_value] = $items[$subcontrol];
							}
						}
						for($i = 0; $i < $items_count; $i++){
							$title = $subcontrol_value['title'][$i];
							$percent = $subcontrol_value['percent'][$i];
							$bgcolor = $subcontrol_value['bgcolor'][$i];
							$bgcolor = $bgcolor ? ux_theme_switch_color($bgcolor, 'rgb') : $default_bg_value;  ?>
                            <div class="vbar-item"><div class="vbar" data-lbl="<?php echo $title; ?>" data-val="<?php echo $percent; ?>" data-clr="<?php echo $bgcolor; ?>" <?php echo $second_background; ?>></div></div>
						<?php }
                    } ?>
                </section>
            <?php
            break;
		}
		?>
        
	<?php	
	}
}
add_action('ux-pb-module-template-progress-bar', 'ux_pb_module_progressbar');

//progress bar select fields
function ux_pb_module_progressbar_select($fields){
	$fields['module_infographic_type'] = array(
		array('title' => __('Bar', 'ux'), 'value' => 'bar'),
		array('title' => __('Column', 'ux'), 'value' => 'column'),
		array('title' => __('Pie', 'ux'), 'value' => 'pie'),
		array('title' => __('Pictorial', 'ux'), 'value' => 'pictorial'),
		array('title' => __('Big Number', 'ux'), 'value' => 'big_number')
	);
	
	$fields['module_infographic_style'] = array(
		array('title' => __('Doughnut', 'ux'), 'value' => 'doughnut')
	);
	
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_progressbar_select');

//progress bar config fields
function ux_pb_module_progressbar_fields($module_fields){
	$module_fields['progress-bar'] = array(
		'id' => 'progress-bar',
		'title' => __('Info-graphic', 'ux'),
		'item' =>  array(
			array('title' => __('Type', 'ux'),
				  'description' => __('Choose a info-graphic type', 'ux'),
				  'type' => 'select',
				  'name' => 'module_infographic_type',
				  'default' => 'bar'),
				  
			array('title' => __('Style', 'ux'),
				  'description' => __('Choose a style for the pie', 'ux'),
				  'type' => 'select',
				  'name' => 'module_infographic_style',
				  'default' => 'doughnut',
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'pie'
				  )),
				  
			array('title' => __('Digit', 'ux'),
				  'description' => __('Enter the number', 'ux'),
				  'type' => 'text',
				  'name' => 'module_infographic_digit',
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'big_number'
				  )),
				  
			array('title' => __('Percent', 'ux'),
				  'description' => __('Enter the percentage data for this item.', 'ux'),
				  'type' => 'text',
				  'name' => 'module_infographic_percent',
				  'unit' => __('%', 'ux'),
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'bar|pie'
				  )),
				  
			array('title' => __('Percent', 'ux'),
				  'description' => __('Enter the percentage data for this item.', 'ux'),
				  'type' => 'text',
				  'name' => 'module_infographic_column_percent',
				  'unit' => __('%', 'ux'),
				  'subcontrol' => 'module_infographic_columns|percent'),
			
			array('title' => __('Title', 'ux'),
				  'description' => __('Title for this item', 'ux'),
				  'type' => 'text',
				  'name' => 'module_infographic_title',
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'bar|pie|pictorial|big_number'
				  )),
			
			array('title' => __('Title', 'ux'),
				  'description' => __('Title for this item', 'ux'),
				  'type' => 'text',
				  'name' => 'module_infographic_column_title',
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'column'
				  ),
				  'subcontrol' => 'module_infographic_columns|title'),
			
			array('title' => __('Columns', 'ux'),
				  'type' => 'items',
				  'name' => 'module_infographic_columns',
				  'count' => 4,
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'column'
				  )),
			
			array('title' => __('Subtitle', 'ux'),
				  'description' => __('Subtitle for this item', 'ux'),
				  'type' => 'text',
				  'name' => 'module_infographic_subtitle',
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'pie|big_number'
				  )),
			
			array('title' => __('Icon','ux'),
				  'type' => 'icons',
				  'name' => 'module_infographic_icon',
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'pictorial'
				  )),
			
			array('title' => __('Number of Icons', 'ux'),
				  'description' => __('How many icons you want to show in this module', 'ux'),
				  'type' => 'text',
				  'name' => 'module_infographic_number_icons',
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'pictorial'
				  )),
			
			array('title' => __('Number of Active Icons', 'ux'),
				  'description' => __('How many icons should be highlighted', 'ux'),
				  'type' => 'text',
				  'name' => 'module_infographic_number_active_icons',
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'pictorial'
				  )),
			
			array('title' => __('Percentage Color', 'ux'),
				  'description' => __('Color for activated part', 'ux'),
				  'type' => 'bg-color',
				  'name' => 'module_infographic_percentage_color',
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'bar|pie')),
			
			array('title' => __('Column Percentage Color', 'ux'),
				  'description' => __('Color for activated part', 'ux'),
				  'type' => 'bg-color',
				  'name' => 'module_infographic_col_percentage_color',
				  'subcontrol' => 'module_infographic_columns|bgcolor'
				  ),
			
			array('title' => __('Active Icons Color', 'ux'),
				  'description' => __('Color for activated part', 'ux'),
				  'type' => 'bg-color',
				  'name' => 'module_infographic_active_color',
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'pictorial'
				  )),
			
			array('title' => __('Number Color', 'ux'),
				  'description' => __('Color for activated part', 'ux'),
				  'type' => 'bg-color',
				  'name' => 'module_infographic_number_color',
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'big_number'
				  )),
				  
			array('title' => __('Show Background Color', 'ux'),
				  'description' => __('Enable it to show background color', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_infographic_show_background',
				  'default' => 'on',
				  'control' => array(
					  'name' => 'module_infographic_type',
					  'value' => 'bar|column|pie'
				  )),
				  
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
				  ))
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_progressbar_fields');
?>