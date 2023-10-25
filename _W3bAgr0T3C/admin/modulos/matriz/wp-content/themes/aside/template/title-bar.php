<?php 
//** title bar before if enable pb set class container
if(ux_enable_pb() && !ux_enable_sidebar()){
	echo '<div class="container">';
} 

$show_title_bar_center = false;
if(is_page()){				
	$show_title_bar_center = ux_get_post_meta(get_the_ID(), 'theme_meta_show_title_center'); 
}	
?>

<div class="title-bar-wrap <?php if($show_title_bar_center){ echo 'title-centered'; } ?>" id="title-bar">
    
    <div id="title-wrap">
        
        <div class="title-wrap-inn">

            <div id="main-title">
                <h1 class="main-title">
					<?php
					if(is_category()){
						
						echo __('Category : ', 'ux') ;
						echo single_cat_title();
						
					}elseif(is_tag()){
						
						echo __('Tag : ', 'ux') ;
						echo single_cat_title();
						
					}elseif(is_search()){
						
						echo __('Search Results', 'ux') ;
				
					}elseif(is_archive()){
						
						if(is_day()){
							printf( __( 'Archives: %s', 'ux' ), get_the_date());
					
						}elseif(is_month()){
							printf( __( 'Archives: %s', 'ux' ), get_the_date(_x( 'F Y', 'monthly archives date format', 'ux' )));
					
						}elseif(is_year()){
							printf( __( 'Archives: %s', 'ux' ), get_the_date(_x( 'Y', 'yearly archives date format', 'ux' )));
					
						}else{
							 _e( 'Archives', 'ux' );
					
						};
					}elseif(is_page() || is_single()){
						
						the_title();
						
					}elseif(is_home()){ 	
					
						_e( 'Latest News', 'ux' );
						
					}else{
						
						_e( 'Archives', 'ux' );
					} ?>
                
                </h1>
                
                <?php if(is_single()){
				
					//** Show Meta On Post Page
					$enable_meta = ux_get_option('theme_option_enable_meta_post_page');
					$showmeta    = ux_get_option('theme_option_posts_showmeta');
					
					if($enable_meta){  ?>
				
						<div class="post-meta">
							<?php if(in_array('date', $showmeta)){ ?>
								<span class="post-meta-unit date"><?php _e('Date: ', 'ux'); ?><?php echo get_the_time('F j Y'); ?></span>
							<?php }
							
							if(in_array('category', $showmeta)){ ?>
								<span class="post-meta-unit category"><?php _e('Category: ', 'ux'); ?><?php the_category(', '); ?></span>
							<?php }
							
							if(in_array('tag', $showmeta)){ ?>
								<span class="post-meta-unit tag"><?php the_tags(__('Tags: ', 'ux'), ', '); ?></span>
							<?php }
								
							if(in_array('author', $showmeta)){ ?>
								<span class="poste-meta-unit author"><?php _e('Author: ', 'ux'); ?><?php the_author(); ?></span>
							<?php } ?>
						</div>
						
					<?php
					}
				} ?>
            </div>
            
            <?php if(is_search() || is_page()){
				
				$show_title_bar_expert = false;
				
				if(is_page()){
					//** Show Expert on Title Bar
					$show_title_bar_expert = ux_get_post_meta(get_the_ID(), 'theme_meta_title_bar_expert');
				}
				
				if(is_page() && $show_title_bar_expert){

					$post_expert = get_the_excerpt();
					
					if($post_expert!=''){ echo '<div class="post-expert">'.$post_expert.'</div>'; }
						
				}elseif(is_search()){
					
					echo '<div class="post-expert">';
					printf(__('Search for: %s', 'ux'), get_search_query());
					echo '</div>';

				} ?>
                
    
			<?php
			}
			
			if(is_search()){
				
				$enter_key =  __('Enter keyword to search','ux'); ?>
                
                <form action="#" method="get" name="search" class="search-form">

                    <input type="text" name="s" value="<?php echo $enter_key; ?>" onfocus="if (this.value == '<?php echo $enter_key; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $enter_key; ?>';}">
                    
                </form>
            
            <?php } ?>
                                        
        </div>

    </div><!--End #title-wrap-->

</div><!--End #title-bar-wrap"-->

<?php 
//** title bar after if enable pb set class container end
if(ux_enable_pb() && !ux_enable_sidebar()){
	echo '</div>';
} ?>