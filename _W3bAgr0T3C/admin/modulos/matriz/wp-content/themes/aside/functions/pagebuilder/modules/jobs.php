<?php
//jobs template
function ux_pb_module_jobs($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//jobs confing
		$category      = get_post_meta($module_post, 'module_jobs_category', true);
		$orderby       = get_post_meta($module_post, 'module_select_orderby', true);
		$order         = get_post_meta($module_post, 'module_select_order', true);
		
		$category      = get_term_by('id', $category, 'job_cat');
		$category_slug = $category ? $category->slug : false;
		
		$get_jobs = get_posts(array(
			'posts_per_page' => -1,
			'post_type'      => 'jobs',
			'job_cat'        => $category_slug,
			'orderby'        => $orderby,
			'order'          => $order
		)); ?>
        
        <div id="accordion-<?php echo $module_post; ?>" class="accordion_toggle accordion-style-b ux-mod-nobg job-mod accordion-ux">
        	
			<?php if($get_jobs){
				global $post;
				foreach($get_jobs as $post){ setup_postdata($post);
					$ux_theme_meta = get_post_meta(get_the_ID(), 'ux_theme_meta', true);
					
					$jobs_location = isset($ux_theme_meta['theme_meta_jobs_location']) ? $ux_theme_meta['theme_meta_jobs_location'] : false;
					$jobs_number = isset($ux_theme_meta['theme_meta_jobs_number']) ? $ux_theme_meta['theme_meta_jobs_number'] : false; ?>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a href="#collapse_<?php the_ID(); ?>" data-parent="#accordion-<?php $module_post; ?>" data-toggle="collapse" class="accordion-toggle"><?php the_title(); ?></a>
                        </div><!--End accordion-heading-->
                        
                        <div class="accordion-body collapse" id="collapse_<?php the_ID(); ?>">
                            <div class="accordion-inner">
                                <p class="job-meta"><span><?php echo __('Location:', 'ux'). ' '.$jobs_location; ?></span> <span><?php echo __('Number:', 'ux').' '.$jobs_number; ?></span></p>
                                <?php the_content(); ?>
                            </div><!--End accordion-inner-->
                        </div><!--End accordion-body-->
                    </div>
				
				<?php
				}
				wp_reset_postdata();
			} ?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-jobs', 'ux_pb_module_jobs');

//jobs config fields
function ux_pb_module_jobs_fields($module_fields){
	$module_fields['jobs'] = array(
		'id' => 'jobs',
		'title' => __('Jobs', 'ux'),
		'item' =>  array(
			array('title' => __('Jobs Category', 'ux'),
				  'description' => __('The jobs under the category you selected would be shown in this module', 'ux'),
				  'type' => 'category',
				  'name' => 'module_jobs_category',
				  'taxonomy' => 'job_cat',
				  'default' => '0'),
				  
			array('title' => __('Order by', 'ux'),
				  'description' => __('Select sequence rules for the list', 'ux'),
				  'type' => 'orderby',
				  'name' => 'module_select_orderby',
				  'default' => 'date'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_jobs_fields');
?>