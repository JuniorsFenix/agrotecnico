<?php
//team template
function ux_pb_module_team($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//team confing
		$per_page      = get_post_meta($module_post, 'module_team_per_page', true);
		$category      = get_post_meta($module_post, 'module_team_category', true);
		$orderby       = get_post_meta($module_post, 'module_select_orderby', true);
		$order         = get_post_meta($module_post, 'module_select_order', true);
		
		$per_page      = $per_page ? $per_page : -1;
		$category      = get_term_by('id', $category, 'team_cat');
		$category_slug = $category ? $category->slug : false;
		
		$get_team = get_posts(array(
			'posts_per_page' => $per_page ,
			'post_type'      => 'team',
			'team_cat'       => $category_slug,
			'orderby'        => $orderby,
			'order'          => $order
		));
		$count = count($get_team); ?>
        
        <!--allery isotope-->
        <div class="row-fluid">
        	<a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
            <div class="container-isotope" style="" data-post="<?php echo $itemid; ?>">
                <div class="isotope grid_list" data-space="40px" style="  margin: -40px 0px 0px -40px;" data-size="medium">
                    <?php ux_pb_module_load_team($itemid, 1); ?>
                </div>
            </div> <!--End container-isotope-->
        </div><!--End row-fluid-->
	<?php
	}
}
add_action('ux-pb-module-template-team', 'ux_pb_module_team');

//team load template
function ux_pb_module_load_team($itemid, $paged){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		global $post;
		
		//team confing
		$position          = get_post_meta($module_post, 'module_team_position', true);
		$email             = get_post_meta($module_post, 'module_team_email', true);
		$phone_number      = get_post_meta($module_post, 'module_team_phone_number', true);
		$social_network    = get_post_meta($module_post, 'module_team_social_network', true);
		$per_page          = get_post_meta($module_post, 'module_team_per_page', true);
		$category          = get_post_meta($module_post, 'module_team_category', true);
		$orderby           = get_post_meta($module_post, 'module_select_orderby', true);
		$order             = get_post_meta($module_post, 'module_select_order', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		
		$social_networks   = ux_theme_social_networks();
		
		$per_page          = $per_page ? $per_page : -1;
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, 'team') : false;
		
		$category          = get_term_by('id', $category, 'team_cat');
		$category_slug     = $category ? $category->slug : false;
		
		$get_team = get_posts(array(
			'posts_per_page' => $per_page,
			'paged'          => $paged,
			'team_cat'       => $category_slug,
			'orderby'        => $orderby,
			'order'          => $order,
			'post_type'      => 'team'
		));
		
		foreach($get_team as $num => $post){ setup_postdata($post);
			$team_position      = ux_get_post_meta(get_the_ID(), 'theme_meta_team_position', true);
			$team_email         = ux_get_post_meta(get_the_ID(), 'theme_meta_team_email', true);
			$team_phone_number  = ux_get_post_meta(get_the_ID(), 'theme_meta_team_phone_number', true);
			$team_social_medias = ux_get_post_meta(get_the_ID(), 'theme_meta_team_social_medias', true);
			
			?>
            <div class="width2 isotope-item <?php echo $animation_style; ?>">
                <div class="inside card" style="padding:40px 0 0 40px">
                    <div class="team-item">
						
						<div class="img-wrap"><?php the_post_thumbnail(array(520,520)); ?></div>
                        
                        <div class="team-item-con-back">
	                        <div class="team-item-con-back-inn">	
	                            <a class="team-item-title" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                            <div class="team-item-con-h">
	                                <?php if($position == 'on'){ ?>
	                                    <p class="team-position"><?php echo $team_position; ?></p>
	                                <?php }
	                                
	                                if($email == 'on'){ ?>
	                                    <p class="team-email"><?php echo $team_email; ?></p>
	                                <?php }
	                                
	                                if($phone_number == 'on'){ ?>
	                                    <p class="team-phone"><?php echo $team_phone_number; ?></p>
	                                <?php } ?>
	                            </div>
	                            <?php if($social_network == 'on'){ ?>
	                                <p class="team-icons">
										<?php if($team_social_medias && isset($team_social_medias['icontype'])){
											$icon_type = $team_social_medias['icontype'];
											foreach($icon_type as $num => $type){
												$icon = $team_social_medias['icon'][$num];
												$url = $team_social_medias['url'][$num];
												$tip = $team_social_medias['tip'][$num]; ?>
												<a href="<?php echo esc_url($url); ?>">
													<?php if($type == 'fontawesome'){ ?>
                                                        <i class="<?php echo $icon; ?>"></i>
                                                    <?php }elseif($type == 'user'){ ?>
                                                        <img src="<?php echo $icon; ?>" />
                                                    <?php } ?>
                                                </a>
											<?php
                                            }
										}
										
										/*foreach($team_social_medias['name'] as $i => $media_name){
	                                        $media_url = $team_social_medias['url'][$i];
											$social_ico = false;
											foreach($social_networks as $social){
												if($media_name == $social['slug']){
													$social_ico = $social['icon2'];
												}
											}
											if($media_url != ''){ ?>
	                                            <a href="<?php echo esc_url($media_url); ?>"><i class="<?php echo $social_ico; ?> team-icons-item"></i></a>
	                                        <?php
											}
										}*/ ?>
									</p><!--End team-icons-->
								<?php } ?>
							</div><!--End team-item-con-back-inn-->	
                        </div><!--End team-item-con-back-->
                    </div>
                </div><!--End inside-->
            </div>
		<?php
        }
		wp_reset_postdata();
	}
}

//team config fields
function ux_pb_module_team_fields($module_fields){
	$module_fields['team'] = array(
		'id' => 'team',
		'animation' => 'class-3',
		'title' => __('Team', 'ux'),
		'item' =>  array(
			array('title' => __('Show Position', 'ux'),
				  'description' => __('Show the team number\'s position in the module', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_team_position',
				  'default' => 'on'),
				  
			array('title' => __('Show Email', 'ux'),
				  'description' => __('Show the team number\'s email in the module', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_team_email',
				  'default' => 'on'),
				  
			array('title' => __('Show Phone Number', 'ux'),
				  'description' => __('Show the team number\'s phone number in the module', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_team_phone_number',
				  'default' => 'on'),
				  
			array('title' => __('Show Social Network', 'ux'),
				  'description' => __('show the team number\'s social medias in the module', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_team_social_network',
				  'default' => 'on'),
				  
			array('title' => __('Number', 'ux'),
				  'description' => __('How many items should be displayed in this module, leave it empty to show all items.', 'ux'),
				  'type' => 'text',
				  'name' => 'module_team_per_page'),
			
			array('title' => __('Team Category', 'ux'),
				  'type' => 'category',
				  'name' => 'module_team_category',
				  'taxonomy' => 'team_cat',
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
				  'name' => 'module_scroll_animation_two',
				  'default' => 'fadein',
				  'control' => array(
					  'name' => 'module_scroll_in_animation',
					  'value' => 'on'
				  ))
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_team_fields');
?>