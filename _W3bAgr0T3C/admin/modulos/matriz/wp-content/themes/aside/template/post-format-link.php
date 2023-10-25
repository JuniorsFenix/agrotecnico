<?php //if($post->post_content != ""){ ?>

<?php 
$link_item = ux_get_post_meta(get_the_ID(), 'theme_meta_link_item');

if($link_item){ ?>
    <ul class="link-wrap">
        <?php foreach($link_item['name'] as $i => $name){
            $url = $link_item['url'][$i]; ?>
            <li><a title="<?php echo $name; ?>" href="<?php echo esc_url($url); ?>"><i class="m-link"></i><?php echo $name; ?></a></li>
        <?php } ?>
	</ul>
<?php } ?>
