<?php
//** current post id
$post_id = get_the_ID();

//** post data
$get_posts = array();

//** processing tags
$tags = array();
$get_tags = get_the_tags();
if($get_tags){
	foreach($get_tags as $num => $tag){
		array_push($tags, $tag->term_id);
	}
	
	if(count($tags)){
		$get_posts = get_posts(array(
			'posts_per_page' => 4,
			'meta_key' => '_thumbnail_id',
			'tag__in' => $tags,
			'post__not_in' => array($post_id),
			'orderby' => 'rand'
		));
	}
	
	
}

if(count($get_posts) < 4){
	//** processing category
	$category = array();
	$category_parents = array();
	$get_categories = get_the_category();
	
	foreach($get_categories as $cat){
		array_push($category, $cat->term_id);
		array_push($category_parents, $cat->parent);
	}
	
	if(count($category)){
		$get_posts = get_posts(array(
			'posts_per_page' => 4,
			'meta_key' => '_thumbnail_id',
			'category__in' => $category,
			'post__not_in' => array($post_id),
			'orderby' => 'rand'
		));
	}
	
	if(count($get_posts) < 4 && count($category_parents)){
		$get_posts = get_posts(array(
			'posts_per_page' => 4,
			'meta_key' => '_thumbnail_id',
			'category__in' => $category_parents,
			'post__not_in' => array($post_id),
			'orderby' => 'rand'
		));
	}
}

if($get_posts){
	global $post; ?>
    
    <section class="related-post-wrap clearfix">
    
        <h2 class="related-post-wrap-tit"><?php _e('Related Posts', 'ux'); ?></h2>
      
        <div class="row-fluid">
      
            <?php foreach($get_posts as $post){ setup_postdata($post);
				$image_full = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?> 
                <section class="related-post-unit">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <?php the_post_thumbnail('image-thumb', array('alt'=>get_the_title())); ?>
                    </a>
                    <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                    <div class="related-post-caption hidden-phone"><?php the_excerpt(); ?></div>
                </section><!--End relatedpost-unit-->
			<?php }
            wp_reset_postdata(); ?>
      
        </div><!--end row-fluid-->
      
    </section><!--End related-post-erap-->
    
<?php } ?>