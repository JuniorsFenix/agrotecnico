<?php
//testimonials template
function ux_pb_module_testimonials($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//testimonials confing
		$category      = get_post_meta($module_post, 'module_testimonials_category', true);
		$orderby       = get_post_meta($module_post, 'module_select_orderby', true);
		$order         = get_post_meta($module_post, 'module_select_order', true);
		$position      = get_post_meta($module_post, 'module_testimonials_position', true);
		$link          = get_post_meta($module_post, 'module_testimonials_link', true);
		$avatar        = get_post_meta($module_post, 'module_testimonials_avatar', true);
		$navigation    = get_post_meta($module_post, 'module_testimonials_navigation', true);
		
		$category      = get_term_by('id', $category, 'testimonial_cat');
		$category_slug = $category ? $category->slug : false;
		$navigation    = $navigation == 'on' ? 'true' : 'false';
		
		$get_testimonials = get_posts(array(
			'posts_per_page'  => -1,
			'post_type'       => 'testimonials',
			'testimonial_cat' => $category_slug,
			'orderby'         => $orderby,
			'order'           => $order
		));
		
		if($get_testimonials){
			global $post; ?>
            <div class="flex-slider-wrap testimonial-wrap" data-direction="false" data-control="<?php echo $navigation; ?>" data-speed="5" data-animation="fade">
                <div class="flexslider">
                    <ul class="slides clearfix">
                        <?php foreach($get_testimonials as $post){ setup_postdata($post);
							$t_cite     = ux_get_post_meta(get_the_ID(), 'theme_meta_testimonial_cite');
							$t_position = ux_get_post_meta(get_the_ID(), 'theme_meta_testimonial_position');
							$t_title    = ux_get_post_meta(get_the_ID(), 'theme_meta_testimonial_link_title');
							$t_link     = ux_get_post_meta(get_the_ID(), 'theme_meta_testimonial_link');
							
							$t_position = $position == 'on' ? $t_position : false;  ?> 
                            
                            <li class=" testimonial-item">
                            	
                                <?php if($avatar == 'on' && has_post_thumbnail()){ 
                                	echo '<div class="testimonial-thum">';
									the_post_thumbnail('thumbnail');
									echo '</div>';
									
								} else{
									echo '<div class="testimonial-thum testimonial-thum-bg"><i class="fa fa-quote-left"></i></div><!--End testimonial-thum-->';
								} ?>
								
                                <blockquote> 
                                    <p><?php the_content(); ?></p> 
                                    <cite>
										 ---- <?php echo $t_cite; ?>
                                        <?php echo $t_position; ?>
                                        <?php if($link == 'on'){ ?>
											<a href="<?php echo esc_url($t_link); ?>"><?php echo $t_title; ?></a> 
										<?php } ?>
                                    </cite> 
                                </blockquote> 
                            </li><!--loop Li wrap-->
                            
                        <?php }
						wp_reset_postdata(); ?>
                    </ul> 
                </div> 
            </div>
        <?php	
		}
	}
}
add_action('ux-pb-module-template-testimonials', 'ux_pb_module_testimonials');

//testimonials select fields
function ux_pb_module_testimonials_select($fields){
	$fields['module_testimonials_columns'] = array(
		array('title' => __('1', 'ux'), 'value' => '1'),
		array('title' => __('2', 'ux'), 'value' => '2'),
		array('title' => __('3', 'ux'), 'value' => '3')
	);
	
	$fields['module_testimonials_rows'] = array(
		array('title' => __('1', 'ux'), 'value' => '1'),
		array('title' => __('2', 'ux'), 'value' => '2'),
		array('title' => __('3', 'ux'), 'value' => '3'),
		array('title' => __('4', 'ux'), 'value' => '4')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_testimonials_select');

//testimonials config fields
function ux_pb_module_testimonials_fields($module_fields){
	$module_fields['testimonials'] = array(
		'id' => 'testimonials',
		'title' => __('Testimonials', 'ux'),
		'item' =>  array(
			array('title' => __('Testimonials Category', 'ux'),
				  'description' => __('The testimonials under the category you selected would be shown in this module', 'ux'),
				  'type' => 'category',
				  'name' => 'module_testimonials_category',
				  'taxonomy' => 'testimonial_cat',
				  'default' => '0'),
				  
			array('title' => __('Order by', 'ux'),
				  'description' => __('Select sequence rules for the list', 'ux'),
				  'type' => 'orderby',
				  'name' => 'module_select_orderby',
				  'default' => 'date'),
				  
			/*array('title' => __('Columns', 'ux'),
				  'description' => __('Setup the number of columns you want to show in front end', 'ux'),
				  'type' => 'select',
				  'name' => 'module_testimonials_columns',
				  'default' => '1'),
				  
			array('title' => __('Rows', 'ux'),
				  'description' => __('Setup the number of rows you want to show in front end', 'ux'),
				  'type' => 'select',
				  'name' => 'module_testimonials_rows',
				  'default' => '1'),*/
				  
			array('title' => __('Show Avatar', 'ux'),
				  'description' => __('Descriptions', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_testimonials_avatar',
				  'default' => 'on'),
				  
			array('title' => __('Show Position', 'ux'),
				  'description' => __('Descriptions', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_testimonials_position',
				  'default' => 'on'),
				  
			array('title' => __('Show Link', 'ux'),
				  'description' => __('Descriptions', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_testimonials_link',
				  'default' => 'on'),
				  
			array('title' => __('Show Navigation Buttons', 'ux'),
				  'description' => __('Descriptions', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_testimonials_navigation',
				  'default' => 'on'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_testimonials_fields');
?>