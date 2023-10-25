<?php
//portfolio template
function ux_pb_module_portfolio($itemid){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		//portfolio confing
		$type           = get_post_meta($module_post, 'module_portfolio_type', true);
		$sortable       = get_post_meta($module_post, 'module_portfolio_sortable', true);
		$per_page       = get_post_meta($module_post, 'module_portfolio_per_page', true);
		$category       = get_post_meta($module_post, 'module_portfolio_category', true);
		$pagination     = get_post_meta($module_post, 'module_portfolio_pagination', true);
		
		$count          = 0;
		
		switch($type){
			default:

				$spacing        = get_post_meta($module_post, 'module_portfolio_image_spacing', true);
				$size           = get_post_meta($module_post, 'module_portfolio_image_size', true);
				$size           = $type == 'brick' ? 'brick' : $size;
				
				$get_categories = get_categories('parent=' . $category);
				$per_page       = $per_page ? $per_page : -1;
				
				$isotope_style  = 'margin: -' . $spacing . ' 0 0 -' . $spacing;
				$inside_style   = 'margin: ' . $spacing . ' 0 0 ' . $spacing;
				
				if($type == 'brick'){
					$sortable = get_post_meta($module_post, 'module_portfolio_brick_sortable', true);
					$sortable_fixed = get_post_meta($module_post, 'module_portfolio_brick_filter_fixed', true);
					$sortable_fixed = $sortable_fixed == 'on' ? ' filter-floating-fixed' : false;
				}
				
				switch($sortable){
					case 'top': 
						$filter_class = 'center-ux';
						$isotope_class = 'clear';
						$isotope_margin = false;
					break;
					
					case 'left': 
						$filter_class = 'span3 onside';
						$isotope_class = 'span9';
						$isotope_margin = false;
					break;
					
					case 'right': 
						$filter_class = 'span3 onside onright pull-right';
						$isotope_class = 'span9';
						$isotope_margin = 'margin-left:0;';
					break;

					case 'floating': 
						$filter_class = 'filter-floating'.$sortable_fixed;
						$isotope_class = '';
						$isotope_margin = '';
					break;
					
					default:
						$filter_class = false;
						$isotope_class = 'clear';
						$isotope_margin = false;
					break;
				}
				
				$filter_class   = $filter_class ? $filter_class : false;
				$isotope_class  = $isotope_class ? $isotope_class : false;
				$isotope_margin = $isotope_margin ? $isotope_margin : false;
				
				$portfolio_query = get_posts(array(
					'posts_per_page' => -1,
					'cat' => $category,
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array('post-format-gallery'),
							'operator' => 'IN'
						)
					)
				));
				
				$count = count($portfolio_query); ?>
		        
		        <!--Portfolio isotope-->
		        <div class="row-fluid">
		        	
		            <?php if($sortable && $sortable != 'no'){
						
						if(is_array($category)){
							$category = $category[0];
						}
						
						$get_categories = get_categories('parent=' . $category);
						?>

		                <!--Filter-->
		                
			                <div class="clearfix filters <?php echo $filter_class; ?>">
			                    <ul>
			                    	<li class="active"><a href="#" data-filter="*"><?php _e('All', 'ux'); ?></a></li>	
			                    	<?php foreach($get_categories as $cate){ ?>		
			                        <li><a data-filter=".filter_<?php echo $cate->slug; ?>" href="#"><?php echo $cate->name; ?></a></li>
			                    	<?php } ?>
			                    </ul>
			                    <?php if($sortable == 'floating'){ ?>
		                		<div class="filter-floating-triggle hidden-phone"><i class="fa fa-filter"></i></div>
		               			<?php } ?>

			                </div><!--End filter-->

		            <?php } ?>

		            <div class="container-isotope <?php echo $isotope_class; ?>" style=" <?php echo $isotope_margin; ?>" data-post="<?php echo $itemid; ?>">
		                <div id="isotope-load">
			            	<div class="ux-loading"></div>
			            	<div class="ux-loading-transform"><div class="loading-dot1">&nbsp;</div><div class="loading-dot2">&nbsp;</div></div>
			            </div>
		                <div class="isotope masonry <?php if($spacing =='0px'){ echo 'less-space'; } ?>" data-space="<?php echo $spacing; ?>" style=" <?php echo $isotope_style; ?>" data-size="<?php echo $size; ?>">
							<?php ux_pb_module_load_portfolio($itemid, 1); ?>
		                </div>
		            </div> <!--End container-isotope-->
		        </div><!--End row-fluid-->

		    <?php break;
			
			case 'interlock_list': 

				$portfolio_query = get_posts(array(
					'posts_per_page' => -1,
					'cat' => $category,
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array('post-format-gallery'),
							'operator' => 'IN'
						)
					)
				));

				$count = count($portfolio_query);?>

				<!--Portfolio interlock list-->
		        <div class="interlock-list" data-post="<?php echo $itemid; ?>">
		        	<a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
					<?php ux_pb_module_load_portfolio($itemid, 1); ?>
		        </div><!--End interlock-list-->	

		<?php break; 
		
	}?>   

		<?php
		if($count > 2 && $type != 'brick'){
			ux_view_module_pagenums($itemid, 'portfolio', $per_page, $count, $pagination);
		}
	}
}
add_action('ux-pb-module-template-portfolio', 'ux_pb_module_portfolio');

//portfolio load template
function ux_pb_module_load_portfolio($itemid, $paged){
	$module_post = ux_pb_item_postid($itemid);
	
	if($module_post){
		global $post;
		
		//portfolio confing
		$type              = get_post_meta($module_post, 'module_portfolio_type', true);
		$pagination        = get_post_meta($module_post, 'module_portfolio_pagination', true);
		$per_page          = get_post_meta($module_post, 'module_portfolio_per_page', true);
		$double_size       = get_post_meta($module_post, 'module_portfolio_double_size', true);
		$hover_effect      = get_post_meta($module_post, 'module_portfolio_hover_effect', true);
		$spacing           = get_post_meta($module_post, 'module_portfolio_image_spacing', true);
		$ratio             = get_post_meta($module_post, 'module_portfolio_image_ratio', true);
		$category          = get_post_meta($module_post, 'module_portfolio_category', true);
		$orderby           = get_post_meta($module_post, 'module_select_orderby', true);
		$order             = get_post_meta($module_post, 'module_select_order', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$post_meta         = get_post_meta($module_post, 'module_portfolio_meta', true);
		$size              = get_post_meta($module_post, 'module_portfolio_image_size', true);
		$brick_hover       = get_post_meta($module_post, 'module_portfolio_brick_hover', true);
		$gray              = get_post_meta($module_post, 'module_portfolio_brick_style', true);
		
		$per_page          = $per_page ? $per_page : -1;
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, 'portfolio') : false;
		$isotope_style     = 'margin: -' . $spacing.' 0 0 -' . $spacing . ';';
		$inside_style      = $hover_effect == 'flip' ? 'padding:' . $spacing . ' 0 0 ' . $spacing . ';' : 'margin:' . $spacing . ' 0 0 ' . $spacing . ';';
		$back_con_style    ='padding-left: ' . $spacing . ';';
		$back_bg_style     = 'left: ' . $spacing . '; top: -' . $spacing . ';';
		$back_tit_style    = 'margin-top: -' . $spacing . ';' ;
		$brick_hover       = $brick_hover == 'on' ? 'brick-hover' : false; 
		
		$sticky = get_option('sticky_posts');
		
		$get_sticky = get_posts(array(
			'posts_per_page' => $per_page,
			'paged'          => $paged,
			'cat'            => $category,
			'orderby'        => $orderby,
			'order'          => $order,
			'post__in'       => $sticky
		));
		
		$portfolio_query = get_posts(array(
			'posts_per_page' => $per_page,
			'paged' => $paged,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $order,
			'post__not_in' => $sticky,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array(
						'post-format-gallery'
					),
					'operator' => 'IN'
				)
			)
		));
		
		if($sticky){
			$portfolio_query = array_merge_recursive($get_sticky, $portfolio_query);
		}
		
		switch($type){
			case 'masonry_list':

		foreach($portfolio_query as $num => $post){ setup_postdata($post);
			$bg_color          = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
			$bg_color          = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';
			$ux_portfolio      = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio');
			$thumbnail_url     = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
			$thumb_src_preview = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'standard-thumb');
			if($ratio == 'landscape'){

				$thumb_src_preview = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'image-thumb');
			}else if($ratio == 'square'){
				if($size=='small'){
					$thumb_src_preview = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'imagebox-thumb');
				}else{
					$thumb_src_preview = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'image-thumb-1');
				}	
			}else{
				$thumb_src_preview = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'standard-thumb');
			}
			
			$width_item = $num == 0 && $paged == 1 ? $double_size == 'on' ? 'width4' : 'width2' : 'width2';
			
			$portfolio_categories = get_the_category(get_the_ID());
			$separator = ' ';
			$output = '';
			if($portfolio_categories){
				foreach($portfolio_categories as $category){
					$output .= 'filter_' . $category->slug . $separator;
				}
			}
			
			if($hover_effect == 'flip'){ ?>
                <div class="<?php echo trim($output, $separator); ?> <?php echo $width_item; ?> isotope-item container3d <?php echo $animation_style; ?>">
                    <div class="inside card" style=" <?php echo $inside_style; ?>">
                        <div class="flip_wrap_back back face">
                            <div class="flip_wrap_back_con centered-ux" style=" <?php echo $back_con_style; ?>">
                                <h2 style=" <?php echo $back_tit_style; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <?php if($ux_portfolio){ ?>
                                    <ul class="hover_thumb_wrap">
                                        <?php foreach($ux_portfolio as $num => $image){
                                            $thumb_src_full = wp_get_attachment_image_src($image, 'full');
                                            $thumb_src = wp_get_attachment_image_src($image, 'blog-thumb');
                                            if($num < 3){ ?>
                                                <li class="hover_thumb_unit"><a href="<?php echo $thumb_src_full[0]; ?>" title="<?php echo get_the_title($image); ?>" class="imgwrap lightbox" data-rel="post<?php the_ID(); ?>"><img width="50" height="50" src="<?php echo $thumb_src[0]; ?>" /></a></li>
                                            <?php
                                            }
                                        } ?>
                                    </ul>
                                <?php } ?>
                                
                            </div>
                            <div class="flip_wrap_back_bg <?php echo $bg_color; ?>" style=" <?php echo $back_bg_style; ?>"></div>
                        </div>
                        <?php if(has_post_thumbnail()) { ?>
							<img src="<?php echo $thumb_src_preview[0]; ?>" class="front face">
						<?php } ?>
                    
                    </div><!--End inside-->
                </div>
            <?php }else if($hover_effect == 'mask'){ ?>
            	<div class="<?php echo trim($output, $separator); ?> <?php echo $width_item; ?> isotope-item mask-hover <?php echo $animation_style; ?>">
                    <div class="inside" style=" <?php echo $inside_style; ?>">

                    	<div class="mask-hover-inn">
							<img src="<?php echo $thumb_src_preview[0]; ?>" class="isotope-list-thumb" />
							<div class="mask-hover-caption">
								<span class="mask-hover-caption-block centered-ux <?php echo $bg_color; ?>">

									<p><a href="<?php echo $thumbnail_url[0]; ?>" class="lightbox"><?php _e('PREVIEW','ux'); ?></a></p>
									<p><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php _e('READMORE','ux'); ?></a></p>

								</span>
							</div>
						</div>

                    </div><!--End inside-->
                </div><!--End isotope-item --> 	
			<?php }else{ ?>
                <div class="<?php echo trim($output, $separator); ?> <?php echo $width_item; ?> isotope-item captionhover <?php echo $animation_style; ?>">
                    <div class="inside" style=" <?php echo $inside_style; ?>">
                        <figure style=" <?php echo $bg_color; ?>">
                            <div class="img_wrap">
								<?php if(has_post_thumbnail()) { ?>
                                    <img src="<?php echo $thumb_src_preview[0]; ?>">
                                <?php } ?>
                            </div>
                            <figcaption class="<?php echo $bg_color; ?>">
                                
                                <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                                <div class="btn_wrap"><a href="<?php echo $thumbnail_url[0]; ?>" class="lightbox"><i class="icon-m-view"></i></a><a href="<?php the_permalink(); ?>" class="more"><i class="icon-m-more"></i></a></div>
                            </figcaption>
                        </figure>
                    </div><!--End inside-->
                </div>
            <?php	
			}
		}

		break;

		case 'interlock_list': 

			foreach($portfolio_query as $num => $post){ setup_postdata($post);
				$bg_color          = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
				$bg_color          = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';
				$ux_portfolio      = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio');
				$thumbnail_url     = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
				$thumb_src_preview = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'image-thumb');

		?>
			<?php if(has_post_thumbnail()) { ?>
				<section class="interlock-item <?php echo $animation_style; ?>">
					<div class="iterlock-item-img">
						
						<a class="lightbox ux-hover-wrap" href="<?php echo $thumbnail_url[0]; ?>" style="background-image:url(<?php echo $thumb_src_preview[0]; ?>)">
                        	<div class="blog-item-img-hover ux-hover-icon-wrap"><i class="icon-m-view <?php echo $bg_color; ?>"></i></div>
                        	
                        </a>	
                        
					</div>
					<div class="iterlock-caption">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h2><?php the_title(); ?></h2></a>
						<div class="iterblock-expt hidden-phone"><?php the_excerpt(); ?></div>

						<?php if ($post_meta != 'off') { ?>
                            <ul class="blog_meta hidden-phone">
                                <li class="blog_meta_date"><i class="fa fa-calendar"></i><?php echo get_the_time('F j Y'); ?></li>
                                <li class="blog_meta_cate"><i class="fa fa-folder-o"></i><?php the_category(' / '); ?></li>
                                <?php $posttags = get_the_tags(); if($posttags) { ?><li class="blog_meta_cate"><i class="fa fa-tag"></i><?php the_tags('',' / ',''); ?></li><?php } ?>
                                <li class="blog_meta_auhtor"><i class="fa fa-user"></i><?php the_author(); ?></li>
                            </ul><!--End .blog_meta-->
                        <?php } ?>
					</div>
				</section>
			<?php } ?>
		<?php

			} //End foreach

		break;
		
		case 'brick':
		
			foreach($portfolio_query as $num => $post){ setup_postdata($post);
				$bg_color          = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
				$bg_color          = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';
				
				$thumbnail_size    = ux_get_post_meta(get_the_ID(), 'theme_meta_thumbnail_size');
				$thumbnail_size    = $thumbnail_size ? $thumbnail_size : 'imagebox-thumb';
				
				$the_excerpt       = $post->post_excerpt ? get_the_excerpt() : false;
				
				switch($thumbnail_size){
					case 'imagebox-thumb': $width_item = 'width-and-small'; $thumbnail_size_final = 'imagebox-thumb'; break;
					case 'image-thumb-1': $width_item = 'width-and-big'; $thumbnail_size_final = 'image-thumb-1'; break;
					case 'standard-blog-thumb': $width_item = 'width-and-long'; $thumbnail_size_final = 'standard-blog-thumb'; break;
					case 'image-thumb-2': $width_item = 'width-and-height'; $thumbnail_size_final = 'image-thumb-2'; break;
				}
				
				$portfolio_categories = get_the_category(get_the_ID());
				$separator = ' ';
				$output = '';
				if($portfolio_categories){
					foreach($portfolio_categories as $category){
						$output .= 'filter_' . $category->slug . $separator;
					}
				} ?>
                
                <div class="<?php echo trim($output, $separator); ?> <?php echo $width_item; ?> isotope-item <?php if(has_post_thumbnail()){ echo ' brick-with-img'; } ?> <?php echo $animation_style; ?>">
                    
                    <div class="inside brick-inside <?php echo $bg_color; ?>" style=" <?php echo $inside_style; ?>">
                        
                        <?php if($gray=='grey') { ?>

						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="brick-link brick-link-gray">
	                        <div class="brick-hover-mask <?php echo $brick_hover; ?>">
		                        <h3 class="brick-title"><?php the_title(); ?></h3>
	                        </div>

	                        <div class="brick-content brick-grey">
	                            <?php if(has_post_thumbnail()){
									the_post_thumbnail($thumbnail_size_final,array('class' => 'grayscale'));
								} ?>
	                        	<div class="brick-conteng-bg"></div>

							</div>
						</a>

						<?php 
						}else{ 
						?>

						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="brick-link">
							<div class="brick-hover-mask <?php echo $brick_hover; ?>">
	                            <h3 class="brick-title"><?php the_title(); ?></h3>
	                        </div>

							<div class="brick-content"> 
	                            <?php if(has_post_thumbnail()){
									the_post_thumbnail($thumbnail_size_final);
								} ?>
							</div>
						</a>
						<?php } ?>

                    </div><!--End inside-->
                </div>
			
            <?php
            }
		
		break;

	} //End swith type

		wp_reset_postdata();
	}
}

//portfolio select fields
function ux_pb_module_portfolio_select($fields){

	$fields['module_portfolio_type'] = array(
		array('title' => __('Grid List', 'ux'), 'value' => 'masonry_list'),
		array('title' => __('Interlock List', 'ux'), 'value' => 'interlock_list'),
		array('title' => __('Brick', 'ux'), 'value' => 'brick')
	);
	
	$fields['module_portfolio_image_spacing'] = array(
		array('title' => __('0px', 'ux'), 'value' => '0px'),
		array('title' => __('1px', 'ux'), 'value' => '1px'),
		array('title' => __('2px', 'ux'), 'value' => '2px'),
		array('title' => __('5px', 'ux'), 'value' => '5px'),
		array('title' => __('10px', 'ux'), 'value' => '10px'),
		array('title' => __('20px', 'ux'), 'value' => '20px')
	);
	
	$fields['module_portfolio_image_size'] = array(
		array('title' => __('Medium', 'ux'), 'value' => 'medium'),
		array('title' => __('Large', 'ux'), 'value' => 'large'),
		array('title' => __('Small', 'ux'), 'value' => 'small')
	);
	
	$fields['module_portfolio_image_ratio'] = array(
		array('title' => 'landscape(Grid)', 'value' => 'landscape'),
		array('title' => '1:1(Grid)', 'value' => 'square'),
		array('title' => __('Auto Ratio(Masonry)', 'ux'), 'value' => 'auto')
	);
	
	$fields['module_portfolio_sortable'] = array(
		array('title' => __('No', 'ux'), 'value' => 'no'),
		array('title' => __('Top', 'ux'), 'value' => 'top'),
		array('title' => __('Left', 'ux'), 'value' => 'left'),
		array('title' => __('Right', 'ux'), 'value' => 'right')
	);
	
	$fields['module_portfolio_brick_sortable'] = array(
		array('title' => __('No', 'ux'), 'value' => 'no'),
		array('title' => __('Top', 'ux'), 'value' => 'top'),
		array('title' => __('Left', 'ux'), 'value' => 'left'),
		array('title' => __('Right', 'ux'), 'value' => 'right'),
		array('title' => __('Floating', 'ux'), 'value' => 'floating')
	);
	
	$fields['module_portfolio_brick_style'] = array(
		array('title' => __('Standard', 'ux'), 'value' => 'standard'),
		array('title' => __('Grey', 'ux'), 'value' => 'grey')
	);
	
	$fields['module_portfolio_hover_effect'] = array(
		array('title' => __('Folding', 'ux'), 'value' => 'folding'),
		array('title' => __('Flip', 'ux'), 'value' => 'flip'),
		array('title' => __('Mask', 'ux'), 'value' => 'mask')
	);
	
	$fields['module_portfolio_pagination'] = array(
		array('title' => __('No', 'ux'), 'value' => 'no'),
		array('title' => __('Page Number', 'ux'), 'value' => 'page_number'),
		array('title' => __('Load More', 'ux'), 'value' => 'twitter')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_portfolio_select');

//portfolio config fields
function ux_pb_module_portfolio_fields($module_fields){
	$module_fields['portfolio'] = array(
		'id' => 'portfolio',
		'animation' => 'class-3',
		'title' => __('Portfolio', 'ux'),
		'item' =>  array(
			array('title' => __('List Type', 'ux'),
				  'description' => '',
				  'type' => 'select',
				  'name' => 'module_portfolio_type',
				  'default' => 'masonry_list'),

			array('title' => __('Spacing Between Images', 'ux'),
				  'description' => __('Choose the spacing between images', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_image_spacing',
				  'default' => '0px',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list|brick'
				  )),
				  
			array('title' => __('Image Size', 'ux'),
				  'description' => __('Choose a size for the images', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_image_size',
				  'default' => 'medium',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list'
				  )),
				  
			array('title' => __('Image Ratio', 'ux'),
				  'description' => __('From portfilio post featured image, recommended size: larger than 600px * 600px', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_image_ratio',
				  'default' => 'landscape',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list'
				  )),
				  
			array('title' => __('Sortable', 'ux'),
				  'description' => __('Choose whether you want the list to be sortable or not', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_sortable',
				  'default' => 'no',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list'
				  )),
				  
			array('title' => __('Pagination', 'ux'),
				  'description' => __('The "Twitter" option is to show a "Load More" button on the bottom of the list', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_pagination',
				  'default' => 'no',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list|interlock_list'
				  )),
				  
			array('title' => __('Hover Effect', 'ux'),
				  'description' => __('Choose a mouseover effect for the images', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_hover_effect',
				  'default' => 'folding',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list'
				  )),
				  
			array('title' => __('Double Size First Item', 'ux'),
				  'description' => __('Enlarge the first image in the list', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_portfolio_double_size',
				  'default' => 'on',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list'
				  )),
				  
			array('title' => __('Post Number per Page', 'ux'),
				  'description' => __('How many items should be displayed per page, leave it empty to show all items in one page', 'ux'),
				  'type' => 'text',
				  'name' => 'module_portfolio_per_page',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list|interlock_list'
				  )),
				  
			array('title' => __('Category', 'ux'),
				  'description' => __('The featured images of the Portfolio posts under the category you selected would be shown in this module', 'ux'),
				  'type' => 'category',
				  'name' => 'module_portfolio_category',
				  'default' => '0'),
				  
			array('title' => __('Order by', 'ux'),
				  'description' => __('Select sequence rules for the list', 'ux'),
				  'type' => 'orderby',
				  'name' => 'module_select_orderby',
				  'default' => 'date',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list|interlock_list'
				  )),
			
			array('title' => __('Enable Post Meta','ux'),
				  'description' => __('Turn on it to enable post meta information','ux'),
				  'type' => 'switch',
				  'name' => 'module_portfolio_meta',
				  'default' => 'on',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'interlock_list'
				  )),
				  
			array('title' => __('Style', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_brick_style',
				  'default' => 'standard',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'brick'
				  )),
				  
			array('title' => __('Sortable', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_brick_sortable',
				  'default' => 'no',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'brick'
				  )),
				  
			array('title' => __('Filter Fixed', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_portfolio_brick_filter_fixed',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_portfolio_brick_sortable',
					  'value' => 'floating'
				  )),
				  
			array('title' => __('Hover Effect', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_portfolio_brick_hover',
				  'default' => 'on',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'brick'
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
add_filter('ux_pb_module_fields', 'ux_pb_module_portfolio_fields');
?>