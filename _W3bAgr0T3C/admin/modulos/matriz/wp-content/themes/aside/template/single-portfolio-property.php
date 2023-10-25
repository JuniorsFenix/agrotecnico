<?php //** get property
$property = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_portfolio_property');
$enable_meta = ux_get_option('theme_option_enable_meta_post_page');
$showmeta    = ux_get_option('theme_option_posts_showmeta');

if ($property || $enable_meta) { ?>
	<ul class="gallery-info-property span3">
		<?php 
		if ($property && isset($property['title']))  {
		$property_title = $property['title']; ?>
	
		<?php foreach($property_title as $num => $title){
			$content = $property['content'][$num];
			$url = $property['url'][$num];
			$content = !empty($url) ? '<a href="' . esc_url($url) . '">' . $content . '</a>' : $content;
			$title = $title ? $title . ':' : false;
			
			if($title || $content){ ?>
			
                <li>
                    <span class="gallery-info-property-tit"><?php echo $title; ?></span>
                    <span><?php echo $content; ?></span>
                </li>
                    
            <?php
			}
		} ?>

	<?php } 

	//** Show Meta On Post Page
	if($enable_meta){	
	?>
			<?php if(in_array('date', $showmeta)){ ?>
				<li>
					<span class="gallery-info-property-tit date"><?php _e('Date: ', 'ux'); ?></span>
					<span><?php echo get_the_time('F j Y'); ?></span>
				</li>
			<?php }
			
			if(in_array('category', $showmeta)){ ?>
				<li>
					<span class="gallery-info-property-tit category"><?php _e('Category: ', 'ux'); ?></span>
					<span><?php the_category(', '); ?></span>
				</li>
			<?php }
			
			if(in_array('tag', $showmeta) && get_the_tags()){ ?>
				<li>
					<span class="gallery-info-property-tit tag"><?php _e('Tags: ', 'ux'); ?></span>
					<span><?php the_tags('',', '); ?></span>
				</li>
			<?php }
				
			if(in_array('author', $showmeta)){ ?>
				<li>
					<span class="gallery-info-property-tit author"><?php _e('Author: ', 'ux'); ?></span>
					<span><?php the_author(); ?></span>
				</li>
			<?php } ?>

	<?php } ?>

		
	</ul>	

<?php } ?>