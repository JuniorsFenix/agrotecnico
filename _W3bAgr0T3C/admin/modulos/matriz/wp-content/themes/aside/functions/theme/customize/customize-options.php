<?php
//ux customize controls scripts
function ux_theme_customize_controls_scripts(){
	wp_enqueue_script('ux-admin-customize-controls');
}
add_action('customize_controls_print_scripts', 'ux_theme_customize_controls_scripts');

//ux customize controls styles
function ux_theme_customize_controls_styles(){
	wp_enqueue_style('style-customize', UX_THEME . '/css/customize-controls.css');
}
add_action('customize_controls_enqueue_scripts', 'ux_theme_customize_controls_styles');

//ux customize register
function ux_theme_customize_register($wp_customize){
	
	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
	
	//Color Scheme
	$color_scheme = ux_get_option('theme_option_color_scheme');
	
	if(!$color_scheme){
		$get_option = get_option('ux_theme_option');
		$get_option['theme_option_color_scheme'] = ux_theme_options_color_scheme();
		update_option('ux_theme_option', $get_option);
		$color_scheme =  ux_get_option('theme_option_color_scheme');
	}
	
	$customize_scheme = array(__('select scheme', 'ux'));
	
	if($color_scheme){
		foreach($color_scheme as $id => $schemes){
			$customize_scheme[$id] = $id; ?>
            
			<div id="customize_scheme-<?php echo $id; ?>">
				<?php foreach($schemes as $i => $scheme){ ?>
                    <input type="hidden" name="<?php echo $scheme['name']; ?>" value="<?php echo $scheme['value']; ?>" />
                <?php } ?>
			</div>
            
		<?php
		}
	}
	
	$wp_customize->add_section('ux_color_scheme', array(
		'title'    => __('Color Scheme', 'ux'),
		'priority' => 899,
	));
	
	$wp_customize->add_setting('ux_theme_color_scheme', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
        'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field'
    ));
	
    $wp_customize->add_control('ux_color_scheme_select', array(
        'settings' => 'ux_theme_color_scheme',
        'label'   => __('Select a predefined color scheme', 'ux'),
        'section' => 'ux_color_scheme',
        'type'    => 'select',
        'choices' => $customize_scheme
    ));
	
	$theme_config_fields = ux_theme_options_config_fields();
	if($theme_config_fields){
		foreach($theme_config_fields as $config){
			if($config['id'] == 'options-schemes' && isset($config['section'])){
				foreach($config['section'] as $section){
					if($section['id'] != 'color-scheme' && isset($section['item'])){
						$section_title = isset($section['title']) ? $section['title'] : false;
						$section_id    = isset($section['id']) ? $section['id'] : false;
						
						$key = 900;
						$wp_customize->add_section($section_id, array(
							'title'    => $section_title,
							'priority' => $key++,
						));
						
						foreach($section['item'] as $item){
							$item_title   = isset($item['title']) ? $item['title'] : false;
							$item_name    = isset($item['name']) ? $item['name'] : false;
							$item_default = isset($item['default']) ? $item['default'] : false;
							$item_type    = isset($item['type']) ? $item['type'] : false;
							$scheme_name  = isset($item['scheme-name']) ? $item['scheme-name'] : false;
							
							switch($item_type){
								case 'switch-color': 
								
									$wp_customize->add_setting('ux_theme_option[' . $item_name . ']', array(
										'default'           => $item_default,
										'sanitize_callback' => 'sanitize_hex_color',
										'capability'        => 'edit_theme_options',
										'transport'         => 'postMessage',
										'type'              => 'option'
								 
									));
								 
									$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 
										$scheme_name, array(
											'label'    => $item_title,
											'section'  => $section_id,
											'settings' => 'ux_theme_option[' . $item_name . ']')
									));
									
								break;
								
								case 'upload':
								
									$wp_customize->add_setting('ux_theme_option[' . $item_name . ']', array(
										'default'           => $item_default,
										'capability'        => 'edit_theme_options',
										'transport'         => 'postMessage',
										'type'              => 'option',
										'sanitize_callback' => 'sanitize_text_field'
									));
								 
									$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,
										$scheme_name, array(
											'label'    => $item_title,
											'section'  => $section_id,
											'settings' => 'ux_theme_option[' . $item_name . ']')
									));
								
								break;
								
								case 'select':
								
									$wp_customize->add_setting('ux_theme_option[' . $item_name . ']', array(
										'default'           => $item_default,
										'capability'        => 'edit_theme_options',
										'transport'         => 'postMessage',
										'type'              => 'option',
										'sanitize_callback' => 'sanitize_text_field'
									));
									
									$wp_customize->add_control($scheme_name, array(
										'settings' => 'ux_theme_option[' . $item_name . ']',
										'label'    => $item_title,
										'section'  => $section_id,
										'type'     => 'select',
										'choices'  => ux_theme_customize_select_fields($item_name)
									));
								
								break;
							}
						}
					}
				}
			}
		}
	}
	
	//ux customize live preview function action
	if($wp_customize->is_preview()){
		add_action('wp_footer', 'ux_theme_customize_preview', 21);
	}
}
add_action('customize_register', 'ux_theme_customize_register');

//ux customize jquery live preview
function ux_theme_customize_preview(){ ?>
	<script type="text/javascript">
		(function($){
			//Main Colors
			//Theme Main Color
			wp.customize('ux_theme_option[theme_option_color_theme_main]', function(value){
				value.bind(function(val){
					$('a:hover,.entry p a,.archive-tit a:hover,.text_block a,.post_meta > li a:hover, #sidebar a:hover, #comments .comment-author a:hover,#comments .reply a:hover,.fourofour-wrap a,.blog_meta a:hover,.breadcrumbs a:hover,.link-wrap a:hover,.item_title a:hover,.item_des a:hover,.archive-wrap h3 a:hover,.post-color-default,.latest-posts-tags a:hover, .carousel-wrap a:hover,.iocnbox:hover i,.blog-item-main h2 a:hover,div.bbp-template-notice,h1.main_title .bbp-breadcrumb a:hover,.related-post-wrap h3:hover a,.latest-posts-tit-a:hover').css('color', val);
					$('.pagenums a:hover,.pagenums .current,.page-numbers.current,.sidebar_widget .tagcloud a:hover,.related-post-wrap h3:before,.header-slider-item-more:hover,.process-bar,.nav-tabs > li > a:hover,.testimenials:hover,.testimenials:hover .arrow-bg, .sidebar_widget .widget_uxconatactform input#idi_send:hover,input.idi_send:hover,.page-numbers:hover,#bbp-user-navigation li a:hover').css('background-color', val);
					$('textarea:focus,input[type="text"]:focus,input[type="password"]:focus,input[type="datetime"]:focus,input[type="datetime-local"]:focus,input[type="date"]:focus,input[type="month"]:focus,input[type="time"]:focus,input[type="week"]:focus,input[type="number"]:focus,input[type="email"]:focus,input[type="url"]:focus,input[type="search"]:focus,input[type="tel"]:focus,input[type="color"]:focus,.uneditable-input:focus,.sidebar_widget .widget_uxconatactform textarea:focus,.sidebar_widget .widget_uxconatactform input[type="text"]:focus,#respondwrap textarea:focus,#respondwrap input:focus').css('border-color', val);
				});
			});

			// Auxiliary Color
			wp.customize('ux_theme_option[theme_option_color_second_auxiliary]', function(value){
				value.bind(function(val){
					$('.slider-panel,.quote-wrap,#main_title_wrap,.nav-tabs > li,.item_des,.audio_player_list,.promote-wrap,.process-bar-wrap,.post_meta,.pagenumber a,.countdown_section,.progress-wrap .progress-bar,.interlock-item,.pagenumber span,.testimenials,.testimenials .arrow-bg,.carousel-wrap a,.pagenums a,.pagenums span,.accordion-heading,.page-numbers,.testimonial-thum-bg,.twitter-mod:before,.latest-posts-tit,div #bbpress-forums li.bbp-header,#bbp-user-navigation li a,.single-feild,.gallery-wrap-sidebar .related-post-wrap,.gallery-wrap-sidebar .comment-wrap').css('background-color', val);
					$('.progress_bars_with_image_content .bar .bar_noactive.grey').css('color', val);
					$('.border-style2,.border-style3,.nav-tabs > li > a,.tab-content,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.tabs-v,.single-feild').css('border-color', val);
					$('.nav.nav-tabs, .tabs-v .nav-tabs > li:last-child.active>a').css('border-bottom-color', val);
					$('.tab-content.tab-content-v').css('border-left-color', val);
					$('.tabs-v .nav-tabs > .active > a').css('border-top-color', val);
				});
			});
			

			//Logo Color
			
			wp.customize('ux_theme_option[theme_option_color_logo]', function(value){
				value.bind(function(val){
					$('#logo a, #logo-page a, #logo-mobile a,#logo a:hover, #logo-page a:hover, #logo-mobile a:hover,.site-loading-logo').css('color', val);
				});
			});


			//Menu bar
			//Menu bar BG
			wp.customize('ux_theme_option[theme_option_bg_left_menu_bar]', function(value){
				value.bind(function(val){
					$('#sidebar,.site-loading,.page-loading,#navi ul li ul.sub-menu li, #navi ul li:hover,.brick-grey').css('background-color', val);
				});
			});

			//Menu Item Text Color
			wp.customize('ux_theme_option[theme_option_color_menu_item_text]', function(value){
				value.bind(function(val){
					$('#navi a,#mobile-advanced a,.menu-icon i,#navi ul li ul.sub-menu:before,input[type="text"].textboxsearch,.submit-wrap i,.icons-sidebar-unit').css('color', val);
					$('.site-loading .loading-dot1, .site-loading .loading-dot2,.page-loading .loading-dot1, .page-loading .loading-dot2').css('background-color', val);
				});
			});
			
			//Activated Item Text Color
			wp.customize('ux_theme_option[theme_option_color_menu_activated_item_text]', function(value){
				value.bind(function(val){
					$('#navi ul li:hover>a,#navi ul li.current-menu-item>a,#navi ul li.current-menu-ancestor>a,#mobile-advanced li>a:hover,#mobile-advanced li.current-menu-item>a,#mobile-advanced li.current-menu-ancestor>a,.icons-sidebar-unit:hover i').css('color', val);
					$('#navi ul li a:before').css('background-color', val);
				});
			});
			
			
			//Submenu Font Color
			wp.customize('ux_theme_option[theme_option_color_submenu_text]', function(value){
				value.bind(function(val){
					$('#navi ul.sub-menu a').css('color', val);
				});
			});

			//copyright text
			wp.customize('ux_theme_option[theme_option_color_copyright]', function(value){
				value.bind(function(val){
					$('.copyright,.copyright a').css('color', val);
				});
			});
			
			
			//Posts & Pages
			//Title Color
			wp.customize('ux_theme_option[theme_option_color_title_light]', function(value){
				value.bind(function(val){
					$('#comments .comment-author a,h1,h2,h3,h4,h5,h6,.archive-tit a,.blog-item-main h2 a,.item_title a,#sidebar .social_active i:hover,.countdown_amount,.latest-posts-tit a,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.accordion-heading .accordion-toggle,.item_des .item_title a,.infrographic.bar .bar-percent,.jqbar.vertical span,.item_title a,.team-item-con-back a,.team-item-con-back i,.team-item-con-h p,.slider-panel-item h2.slider-title a,#respondwrap textarea, #respondwrap input, .contactform input[type="text"], .contactform textarea,#respondwrap input#submit:hover,.contactform input[type="submit"]:hover,input.wpcf7-form-control.wpcf7-submit:hover').css('color', val);
					$('li.commlist-unit,.gallery-wrap-fullwidth .gallery-info-property,.accordion-heading,#respondwrap textarea, #respondwrap input, .contactform input[type="text"], .contactform textarea,#respondwrap input#submit,.contactform input[type="submit"]').css('border-color', val);
					$('h1.main-title:before,.team-item-con,.archive-wrap li:before,.ux-btn:hover,.related-post-wrap h2:before,.galleria-info,#float-bar-triggler,.float-bar-inn,.galleria-image-nav-left:after, .galleria-image-nav-right:after,.comm-reply-title:after,#respondwrap input#submit,.contactform input[type="submit"],.promote-button:hover,.filters li, .filter-floating-triggle,.item_title:before,.accordion-style-b .accordion-heading a:before,.accordion-style-b .accordion-heading a:after,.separator_inn.bg-,.carousel-indicators li').css('background-color', val);
				});
			});
			
			//Content Text Color
			wp.customize('ux_theme_option[theme_option_color_content_text_light]', function(value){
				value.bind(function(val){
					$('body,a,.entry p a:hover,.text_block a:hover,#content_wrap,#comments .reply a,#comments,.blog-item-excerpt,.item_des,.item_des a,h3#reply-title small, #comments .nav-tabs li.active h3#reply-title .logged,#comments .nav-tabs li a:hover h3 .logged,.header-info-mobile,.carousel-wrap a.disabled:hover').css('color', val);
				});
			});
			
			//Auxiliary Content Color
			wp.customize('ux_theme_option[theme_option_color_auxiliary_content_light]', function(value){
				value.bind(function(val){
					$('.post_meta>li,.post_meta>li a,.blog_meta,.blog_meta a,.post-meta, .post-meta a,.archive-meta-unit,.archive-meta-unit a,.latest-posts-tags a,#mobile-header-meta p,.bbp-meta,.bbp-meta a,.bbp-author-role,.bbp-pagination-count,span.bbp-author-ip,.bbp-forum-content,.infrographic-subtit').css('color', val);
				});
			});
			
			//Selected text bg color
			wp.customize('ux_theme_option[theme_option_color_selected_text_bg]', function(value){
				value.bind(function(val){
					$('::selection').css('background-color', val);
					$('::-moz-selection').css('background-color', val);
					$('::-webkit-selection').css('background-color', val);
				});
			});

			//Page Bg Color
			wp.customize('ux_theme_option[theme_option_bg_page_post]', function(value){
				value.bind(function(val){
					$('#main,.separator h4,.float-bar-triggler-inn:before, .float-bar-triggler-inn:after, .float-bar-triggler-inn,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.tab-content,.filters li a:before').css('background-color', val);
					$('.testimenials span.arrow,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus').css('border-bottom-color', val);
					$('.tabs-v .nav-tabs > .active > a').css('border-right-color', val);
					$('#post-navi ,#post-navi a,.float-bar-social-share button,#respondwrap input#submit,.contactform input[type="submit"],.filters a,.filters a:hover,.filters i,.galleria-info-title, .galleria-image-nav, .galleria-counter').css('color', val);
				});
			});
			
			
			//Sidebar
			//Sidebar BG Color
			wp.customize('ux_theme_option[theme_option_color_sidebar_widget_bg]', function(value){
				value.bind(function(val){
					$('#sidebar-widget').css('background-color', val);
				});
			});

			//Sidebar Widget Title Color
			wp.customize('ux_theme_option[theme_option_color_sidebar_widget_title]', function(value){
				value.bind(function(val){
					$('.sidebar_widget h3.widget-title,.sidebar_widget h3.widget-title a').css('color', val);
				});
			});
			
			//Sidebar Widget Content Color
			wp.customize('ux_theme_option[theme_option_color_sidebar_content_color]', function(value){
				value.bind(function(val){
					$('.sidebar_widget,.sidebar_widget a').css('color', val);
				});
			});

			//Slider
			//BG
			wp.customize('ux_theme_option[theme_option_bg_fullscreen_post_slider]', function(value){
				value.bind(function(val){
					$('.galleria-container').css('background-color', val);
				});
			});

		})(jQuery);
	</script>
<?php
}

//ux customize select fields
function ux_theme_customize_select_fields($name){
	$config_select_fields = ux_theme_options_config_select_fields();
	
	$select_fields = array();
	if(isset($config_select_fields[$name])){
		foreach($config_select_fields[$name] as $select){
			$select_fields[$select['value']] = $select['title'];
		}
	}
	
	return $select_fields;
}


?>