<?php 
$quote = ux_get_post_meta(get_the_ID(), 'theme_meta_quote');

if($quote){  ?>
    <div class="quote-wrap">
        <i class="icon-m-quote-left"></i><?php echo $quote; ?>
    </div>
<?php } ?>