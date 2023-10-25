<?php
//theme meta slider name
function ux_theme_meta_slider_name(){
	$meta = array(
		array('title' => __('Select slider name', 'ux'), 'value' => '-1')
	);
	
	if(post_type_exists('zoomslider')){
		$object = get_post_type_object('zoomslider');
		$push = array(
			'title' => $object->labels->name,
			'value' => $object->name
		);
		array_push($meta, $push);
	}
	
	if(is_plugin_active('revslider/revslider.php')){
		array_push($meta, array(
			'title' => __('Revolution Slider', 'ux'), 'value' => 'revolutionslider'
		));
	}
	
	if(is_plugin_active('LayerSlider/layerslider.php')){
		array_push($meta, array(
			'title' => __('LayerSlider', 'ux'), 'value' => 'layerslider'
		));
	}
	
	return $meta;
}

//theme meta slider revolution
function ux_theme_meta_slider_revolutionslider(){
	global $wpdb;
	$table_revslider = $wpdb->prefix . "revslider_sliders";
	
	$wpdb->hide_errors();
	$revslidersliders = $wpdb->get_results("SELECT * FROM $table_revslider ORDER BY id ASC");
	
	$meta = array(
		array('title' => __('Select slider name', 'ux'), 'value' => 0)
	);
	
	
	if(count($revslidersliders)){
		$slider_revslider = array();
		foreach($revslidersliders as $num => $slider){
			$params = (array) json_decode($slider->params);
			if(isset($params['template'])){
				$template = $params['template'] == 'true' ? true : false;
				if(!$template){
					array_push($meta, array(
						'title' => $slider->title, 'value' => $slider->alias
					));
				}
			}
		}
	}
	
	return $meta;
}

//theme meta select fields
function ux_theme_meta_select_fields($fields){
	$fields['theme_meta_sidebar'] = array(
		array('title' => __('Right Sidebar', 'ux'), 'value' => 'right-sidebar'),
		array('title' => __('Left Sidebar', 'ux'), 'value' => 'left-sidebar'),
		array('title' => __('Without Sidebar', 'ux'), 'value' => 'without-sidebar')
	);
	$fields['theme_meta_title_bar_height'] = array(
		array('title' => __('290', 'ux'), 'value' => 'header-bg-height-1'),
		array('title' => __('670', 'ux'), 'value' => 'header-bg-height-2'),
		array('title' => __('Auto', 'ux'), 'value' => 'header-bg-height-auto')
	);
	$fields['theme_meta_title_bar_slider_value'] = array(
		array('title' => __('Select a slider', 'ux'), 'value' => '-1')
	);
	
	$fields['theme_meta_showmeta'] = array(
		array('title' => __('Meta', 'ux'), 'value' => 'meta')
	);
	$fields['theme_meta_audio_type'] = array(
		array('title' => __('Self Hosted Audio', 'ux'), 'value' => 'self-hosted-audio'),
		array('title' => __('Soundcloud', 'ux'), 'value' => 'soundcloud')
	);
	$fields['theme_meta_portfolio_list_style'] = array(
		array('title' => __('Vertical List', 'ux'), 'value' => 'verticle'),
		array('title' => __('Slider', 'ux'), 'value' => 'slider'),
		array('title' => __('Masonry', 'ux'), 'value' => 'masonry')
	);
	$fields['theme_meta_video_ratio'] = array(
		array('title' => __('4:3', 'ux'), 'value' => '4:3'),
		array('title' => __('16:9', 'ux'), 'value' => '16:9'),
		array('title' => __('Custom', 'ux'), 'value' => 'custom')
	);
	
	$fields['theme_meta_sidebar_widgets'] = ux_theme_register_sidebar();
	$fields['theme_meta_title_bar_slider_name'] = ux_theme_meta_slider_name();
	
	$fields['theme_meta_page_portfolio_template'] = array(
		array('title' => __('FullScreen Post Slider', 'ux'), 'value' => 'fullscreen_post_slider'),
		//array('title' => __('Slider', 'ux'), 'value' => 'show_slider'),
		array('title' => __('Revolution Slider', 'ux'), 'value' => 'show_slider'),
		array('title' => __('Half Page', 'ux'), 'value' => 'show_featured_image')
	);
	
	$fields['theme_meta_orderby'] = array(
		array('title' => __('Please Select','ux'), 'value' => 'none'),
		array('title' => __('Title','ux'), 'value' => 'title'),
		array('title' => __('Date','ux'), 'value' => 'date'),
		array('title' => __('ID','ux'), 'value' => 'id'),
		array('title' => __('Modified','ux'), 'value' => 'modified'),
		array('title' => __('Author','ux'), 'value' => 'author'),
		array('title' => __('Comment count','ux'), 'value' => 'comment_count')
	);
	
	$fields['theme_meta_order'] = array(
		array('title' => __('Ascending','ux'), 'value' => 'ASC'),
		array('title' => __('Descending','ux'), 'value' => 'DESC')
	);
	
	$fields['theme_meta_page_portfolio_navigation_button_align'] = array(
		array('title' => __('Upper Right','ux'), 'value' => 'upper_right'),
		array('title' => __('Lower Right','ux'), 'value' => 'lower_right')
	); 
	
	$fields['theme_meta_page_portfolio_transition'] = array(
		array('title' => __('Fade','ux'), 'value' => 'fade'),
		array('title' => __('Slide','ux'), 'value' => 'slide'),
		array('title' => __('Pulse','ux'), 'value' => 'pulse'),
		array('title' => __('Fadeslide','ux'), 'value' => 'fadeslide'),
		array('title' => __('Flash','ux'), 'value' => 'flash')
	);
	
	$fields['theme_meta_enable_portfolio_list_style'] = array(
		array('title' => __('Vertical List','ux'), 'value' => 'vertical'),
		array('title' => __('Masonry','ux'), 'value' => 'masonry'),
		array('title' => __('Slider - Fill ','ux'), 'value' => 'fill'),
		array('title' => __('Slider - Fit','ux'), 'value' => 'fit')
	);
	
	$fields['theme_meta_enable_portfolio_panel_align'] = array(
		array('title' => __('Right','ux'), 'value' => 'right'),
		array('title' => __('Left','ux'), 'value' => 'left'),
		array('title' => __('Fullwidth','ux'), 'value' => 'fullwidth')
	);
	
	$fields['theme_meta_thumbnail_size'] = array(
		array('title' => __('Small','ux'), 'value' => 'imagebox-thumb'),
		array('title' => __('Big','ux'), 'value' => 'image-thumb-1'),
		array('title' => __('Long','ux'), 'value' => 'standard-blog-thumb'),
		array('title' => __('Height','ux'), 'value' => 'image-thumb-2')
	);
	
	$fields['theme_meta_page_portfolio_slider'] = ux_theme_meta_slider_revolutionslider();
	
	return $fields;
}
add_filter('theme_config_select_fields', 'ux_theme_meta_select_fields');

//theme meta fields
function ux_theme_post_meta_fields(){
	$ux_theme_post_meta_fields = array(
		'page' => array(
			array(
				'id' => 'page-options',
				'title' => __('Page Options','ux'),
				'section' => array(
					array(
						'item' => array(
							
							/** Enable Portfolio Template *********************/
							array('title' => __('Enable Page Template','ux'),
								  'type' => 'switch',
								  'name' => 'theme_meta_enable_portfolio_template',
								  'default' => 'false'),
								  
							array('title' => __('Template','ux'),
								  'type' => 'select',
								  'name' => 'theme_meta_page_portfolio_template',
								  'default' => 'fullscreen_post_slider',
								  'col_size' => 'margin-bottom:10px;',
								  'control' => array(
									  'name' => 'theme_meta_enable_portfolio_template',
									  'value' => 'true'
								  ),
								  'bind' => array(
									  
									  array('type' => 'select',
											'name' => 'theme_meta_page_portfolio_slider',
											'default' => '-1',
											'position' => 'after',
											'col_size' => 'width:300px;margin-bottom:10px;',
											'control' => array(
												'name' => 'theme_meta_page_portfolio_template',
												'value' => 'show_slider'
											)
									  )
								  )),
								  
							array('title' => __('Category','ux'),
								  'type' => 'category',
								  'name' => 'theme_meta_page_portfolio_category',
								  'default' => 0,
								  'control' => array(
									  'name' => 'theme_meta_page_portfolio_template',
									  'value' => 'fullscreen_post_slider'
								  )),
								  
							array('title' => __('Order by','ux'),
								  'type' => 'orderby',
								  'name' => 'theme_meta_orderby',
								  'default' => 'date',
								  'control' => array(
									  'name' => 'theme_meta_page_portfolio_template',
									  'value' => 'fullscreen_post_slider'
								  )),
								  
							array('title' => __('Number To Show','ux'),
								  'type' => 'text',
								  'name' => 'theme_meta_portfolio_number',
								  'default' => 6,
								  'control' => array(
									  'name' => 'theme_meta_page_portfolio_template',
									  'value' => 'fullscreen_post_slider'
								  )),
								  
							array('title' => __('Navigation Button Align','ux'),
								  'type' => 'select',
								  'name' => 'theme_meta_page_portfolio_navigation_button_align',
								  'default' => 'upper_right ',
								  'control' => array(
									  'name' => 'theme_meta_page_portfolio_template',
									  'value' => 'fullscreen_post_slider'
								  )),
								  
							array('title' => __('Transition','ux'),
								  'type' => 'select',
								  'name' => 'theme_meta_page_portfolio_transition',
								  'default' => 'fade',
								  'control' => array(
									  'name' => 'theme_meta_page_portfolio_template',
									  'value' => 'fullscreen_post_slider'
								  )),
								  
							array('title' => __('Interval time(ms)','ux'),
								  'type' => 'text',
								  'name' => 'theme_meta_page_portfolio_time',
								  'default' => 5000,
								  'control' => array(
									  'name' => 'theme_meta_page_portfolio_template',
									  'value' => 'fullscreen_post_slider'
								  )),

							array('title' => __('Fill to Wrap','ux'),
								  'type' => 'switch',
								  'name' => 'theme_meta_page_portfolio_fill',
								  'default' => 'true',
								  'control' => array(
									  'name' => 'theme_meta_page_portfolio_template',
									  'value' => 'fullscreen_post_slider'
								  )),

							array('title' => __('With Border','ux'),
								  'type' => 'switch',
								  'name' => 'theme_meta_page_portfolio_border',
								  'default' => 'true',
								  'control' => array(
									  'name' => 'theme_meta_page_portfolio_template',
									  'value' => 'fullscreen_post_slider'
								  )),

							array('title' => __('With link','ux'),
								  'type' => 'switch',
								  'name' => 'theme_meta_page_portfolio_withlink',
								  'default' => 'true',
								  'control' => array(
									  'name' => 'theme_meta_page_portfolio_template',
									  'value' => 'fullscreen_post_slider'
								  )),

							array('title' => __('Show Title','ux'),
								  'type' => 'switch',
								  'name' => 'theme_meta_page_portfolio_withtitle',
								  'default' => 'true',
								  'control' => array(
									  'name' => 'theme_meta_page_portfolio_template',
									  'value' => 'fullscreen_post_slider'
								  )),

							
							/** Sidebar *********************/
							array('title' => __('Sidebar','ux'),
								  'type' => 'image-select',
								  'name' => 'theme_meta_sidebar',
								  'size' => '126:80',
								  'default' => 'without-sidebar',
								  'bind' => array(
									  array('type' => 'select',
											'name' => 'theme_meta_sidebar_widgets',
											'col_size' => 'width:200px;',
											'position' => 'after')
								  ),
								  'control' => array(
									  'name' => 'theme_meta_enable_portfolio_template',
									  'value' => 'false'
								  )),
								  
							array('type' => 'divider')
						)
					),
					
					/** Advanced Settings *********************/
					array(
						'super-control' => array(
							'name' => 'theme_meta_enable_portfolio_template',
							'value' => 'false'
						),
						'item' => array(
							array('title' => __('Advanced Settings','ux'),
								  'type' => 'switch',
								  'name' => 'theme_meta_advanced_settings',
								  'default' => 'false'),
								  
							array('title' => __('Show Title Bar','ux'),
								  'type' => 'switch',
								  'name' => 'theme_meta_show_title_bar',
								  'default' => 'true',
								  'control' => array(
									  'name' => 'theme_meta_advanced_settings',
									  'value' => 'true'
								  )),
								  
							array('title' => __('Show Expert on Title Bar','ux'),
								  'type' => 'switch',
								  'name' => 'theme_meta_title_bar_expert',
								  'default' => 'false',
								  'control' => array(
									  'name' => 'theme_meta_show_title_bar',
									  'value' => 'true'
								  )),
								  
							array('title' => __('Title Centered','ux'),
								  'type' => 'switch',
								  'name' => 'theme_meta_show_title_center',
								  'default' => 'false',
								  'control' => array(
									  'name' => 'theme_meta_advanced_settings',
									  'value' => 'true'
								  )),
							
							array('title' => __('Show Logo on Content Area','ux'),
								  'type' => 'switch',
								  'default' => 'false',
								  'name' => 'theme_meta_show_logo_on_content_area',
								  'control' => array(
									  'name' => 'theme_meta_advanced_settings',
									  'value' => 'true'
								  )),

								  
							array('type' => 'divider')
						)
					),
					
					/** Spacer *********************/
					array(
						'super-control' => array(
							'name' => 'theme_meta_enable_portfolio_template',
							'value' => 'false'
						),
						'item' => array(
							array('title' => __('Show Top Spacer','ux'),
								  'type' => 'switch',
								  'default' => 'false',
								  'name' => 'theme_meta_show_top_spacer'),
								  
							array('title' => __('Show Bottom Spacer','ux'),
								  'type' => 'switch',
								  'default' => 'true',
								  'name' => 'theme_meta_show_bottom_spacer')
						)
					),
					
					/** Other *********************/
					array(
						'item' => array(
							array('title' => __('Show Logo on Content Area','ux'),
								  'type' => 'switch',
								  'default' => 'false',
								  'name' => 'theme_meta_portfolio_logo_on_content_area',
								  'control' => array(
									  'name' => 'theme_meta_enable_portfolio_template',
									  'value' => 'true'
								  ))
						)
					)
				)
			)
		),
		'post' => array(
			array(
				'id' => 'select-images',
				'title' => __('Select Images','ux'),
				'format' => 'gallery',
				'section' => array(
					array(
						'item' => array(
							array('type' => 'gallery',
								  'name' => 'theme_meta_portfolio')
								  
						)
					)
				)
			),
			array(
				'id' => 'images-settings',
				'title' => __('Images Settings','ux'),
				'format' => 'image',
				'section' => array(
					array(
						'item' => array(
							array('title' => __('Link','ux'),
								  'type' => 'text',
								  'name' => 'theme_meta_image_link')
								  
						)
					)
				)
			),
			array(
				'id' => 'audio-settings',
				'title' => __('Audio Settings','ux'),
				'format' => 'audio',
				'section' => array(
					array(
						'item' => array(
							array('title' => __('Audio Type','ux'),
								  'type' => 'image-select',
								  'size' => '106:43',
								  'default' => 'self-hosted-audio',
								  'name' => 'theme_meta_audio_type'),
								  
							array('type' => 'divider'),
							
							array('title' => __('Artist','ux'),
								  'type' => 'text',
								  'name' => 'theme_meta_audio_artist',
								  'control' => array(
									  'name' => 'theme_meta_audio_type',
									  'value' => 'self-hosted-audio'
								  )),
							
							array('title' => __('MP3','ux'),
								  'type' => 'social-medias',
								  'name' => 'theme_meta_audio_mp3',
								  'special' => 'mp3',
								  'placeholder' => array(__('Title', 'ux'), __('URL', 'ux')),
								  'control' => array(
									  'name' => 'theme_meta_audio_type',
									  'value' => 'self-hosted-audio'
								  )),
							
							array('title' => __('Code for WP','ux'),
								  'type' => 'textarea',
								  'name' => 'theme_meta_audio_soundcloud',
								  'description' => __('*Format: https://soundcloud.com/imam-lepast-konyol/maher-zain-always-be-there-1', 'ux'),
								  'control' => array(
									  'name' => 'theme_meta_audio_type',
									  'value' => 'soundcloud'
								  ))
						)
					)
				)
			),
			array(
				'id' => 'video-settings',
				'title' => __('Video Settings','ux'),
				'format' => 'video',
				'section' => array(
					array(
						'item' => array(
							array('description' => __('You could find the embed code on the source video page.', 'ux').'<div class="show-hide-guide-wrap"><a href="http://www.uiueux.com/a/newtea/documentation/video-guide.html" target="_blank"><span>?</span></a></div>',
								  'type' => 'description'),
							
							array('title' => __('Embeded Code','ux'),
								  'type' => 'textarea',
								  'name' => 'theme_meta_video_embeded_code'),
								  
							array('title' => __('Ratio', 'ux'),
								  'type' => 'select',
								  'name' => 'theme_meta_video_ratio',
								  'default' => '4:3'),
								  
							array('type' => 'ratio',
								  'name' => 'theme_meta_video_custom_ratio',
								  'control' => array(
									  'name' => 'theme_meta_video_ratio',
									  'value' => 'custom'
								  ))
						)
					)
				)
			),
			array(
				'id' => 'quote-settings',
				'title' => __('Quote Settings','ux'),
				'format' => 'quote',
				'section' => array(
					array(
						'item' => array(
							array('title' => __('The Quote','ux'),
								  'description' => __('Write your quote in this field.', 'ux'),
								  'type' => 'textarea',
								  'name' => 'theme_meta_quote')
						)
					)
				)
			),
			array(
				'id' => 'link-settings',
				'title' => __('Link Settings','ux'),
				'format' => 'link',
				'section' => array(
					array(
						'item' => array(
							array('title' => __('Link Item','ux'),
								  'type' => 'social-medias',
								  'name' => 'theme_meta_link_item',
								  'special' => 'mp3',
								  'placeholder' => array(__('Title', 'ux'), __('URL', 'ux')))
						)
					)
				)
			),
			array(
				'id' => 'post-options',
				'title' => __('Post Options','ux'),
				'section' => array(
					array(
						'item' => array(
							/** Featured Color *********************/
							array('title' => __('Featured Color','ux'),
								  'type' => 'bg-color',
								  'name' => 'theme_meta_bg_color'),
								  
							/** Thumbnail Size *********************/
							array('title' => __('Thumbnail Size','ux'),
								'description' => __('Optional, for the Page Builder > Portfolio Module > List Type: Brick','ux'),
								  'type' => 'image-select',
								  'name' => 'theme_meta_thumbnail_size',
								  'size' => '80:80',
								  'default' => 'imagebox-thumb',
								  'format' => 'gallery'),
								  
							array('type' => 'divider'),
								  
							/** Enable Portfolio Template *********************/
							array('title' => __('Use Portfolio Template','ux'),
								  'type' => 'switch',
								  'name' => 'theme_meta_enable_portfolio_template',
								  'default' => 'false',
								  'format' => 'gallery'),
								  
							array('title' => __('Image List Style','ux'),
								  'type' => 'select',
								  'name' => 'theme_meta_enable_portfolio_list_style',
								  'default' => 'vertical_list',
								  'format' => 'gallery',
								  'control' => array(
									  'name' => 'theme_meta_enable_portfolio_template',
									  'value' => 'true'
								  )),
								  
							array('title' => __('Text Content Align','ux'),
								  'type' => 'select',
								  'name' => 'theme_meta_enable_portfolio_panel_align',
								  'default' => 'right',
								  'format' => 'gallery',
								  'control' => array(
									  'name' => 'theme_meta_enable_portfolio_template',
									  'value' => 'true'
								  )),  
								  
							array('title' => __('Property','ux'),
								  'type' => 'property',
								  'name' => 'theme_meta_enable_portfolio_property',
								  'format' => 'gallery',
								  'control' => array(
									  'name' => 'theme_meta_enable_portfolio_template',
									  'value' => 'true'
								  ),
								  'placeholder' => array(
									  __('Title','ux'),
									  __('Content','ux'),
									  __('URL','ux')
								  )),
								  
							array('title' => __('Show Related Post','ux'),
								  'type' => 'switch',
								  'name' => 'theme_meta_enable_portfolio_related',
								  'default' => 'true',
								  'format' => 'gallery',
								  'control' => array(
									  'name' => 'theme_meta_enable_portfolio_template',
									  'value' => 'true'
								  ))
							
						)
					),
					
					/** Sidebar *********************/
					array(
						'super-control' => array(
							'name' => 'theme_meta_enable_portfolio_template',
							'value' => 'false'
						),
						'item' => array(
							array('title' => __('Sidebar','ux'),
								  'type' => 'image-select',
								  'name' => 'theme_meta_sidebar',
								  'size' => '126:80',
								  'default' => 'right-sidebar',
								  'bind' => array(
									  array('type' => 'select',
											'name' => 'theme_meta_sidebar_widgets',
											'col_size' => 'width:200px;',
											'position' => 'after')
								  )),
							

							array('type' => 'divider')
						)
					),
					
					/** Spacer ********************
					array(
						'super-control' => array(
							'name' => 'theme_meta_enable_portfolio_template',
							'value' => 'false'
						),
						'item' => array(
							array('title' => __('Show Bottom Spacer','ux'),
								  'type' => 'switch',
								  'default' => 'true',
								  'name' => 'theme_meta_show_bottom_spacer')
						)
					)*/
				)
			)
		),
		'jobs' => array(
			array(
				'id' => 'jobs-meta',
				'title' => __('Jobs Meta','ux'),
				'section' => array(
					array(
						'item' => array(
							array('title' => __('Location','ux'),
								  'type' => 'text',
								  'name' => 'theme_meta_jobs_location'),
								  
							array('title' => __('Number','ux'),
								  'type' => 'text',
								  'name' => 'theme_meta_jobs_number')
						
						)
					)
				)
			)
		),
		'testimonials' => array(
			array(
				'id' => 'testimonials-meta',
				'title' => __('Testimonials Meta','ux'),
				'section' => array(
					array(
						'item' => array(
							array('title' => __('Testimonial Cite','ux'),
								  'type' => 'text',
								  'name' => 'theme_meta_testimonial_cite'),
								  
							array('title' => __('Position','ux'),
								  'type' => 'text',
								  'name' => 'theme_meta_testimonial_position'),
								  
							array('title' => __('Link','ux'),
								  'type' => 'text',
								  'name' => 'theme_meta_testimonial_link_title',
								  'placeholder' => __('Title','ux'),
								  'col_style' => 'width:30%;margin-right:5%;float:left;',
								  'bind' => array(
									  array('type' => 'text',
											'name' => 'theme_meta_testimonial_link',
											'position' => 'after',
											'placeholder' => __('Link','ux'),
											'col_style' => 'width:65%;float:left;',)
								  ))
						
						)
					)
				)
			)
		),
		'clients' => array(
			array(
				'id' => 'clients-meta',
				'title' => __('Clients Meta','ux'),
				'section' => array(
					array(
						'item' => array(
							array('title' => __('Client Link','ux'),
								  'type' => 'text',
								  'name' => 'theme_meta_client_link')
						
						)
					)
				)
			)
		),
		'team' => array(
			array(
				'id' => 'team-meta',
				'title' => __('Team Meta','ux'),
				'section' => array(
					array(
						'item' => array(
							array('title' => __('Position','ux'),
								  'type' => 'text',
								  'name' => 'theme_meta_team_position'),
								  
							array('title' => __('Email','ux'),
								  'type' => 'text',
								  'name' => 'theme_meta_team_email'),
								  
							array('title' => __('Phone Number','ux'),
								  'type' => 'text',
								  'name' => 'theme_meta_team_phone_number'),
								  
							array('title' => __('Social Networks','ux'),
								  'type' => 'new-social-medias',
								  'name' => 'theme_meta_team_social_medias')
						
						)
					)
				)
			)
		)
	);
	$ux_theme_post_meta_fields = apply_filters('ux_theme_post_meta_fields', $ux_theme_post_meta_fields);
	return $ux_theme_post_meta_fields;
}

//require theme meta interface
require_once locate_template('/functions/theme/post/post-meta-interface.php');
?>