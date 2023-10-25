<!--Mobild Header meta-->	
<div id="mobile-header-meta" style="">

	<?php 
    do_action('ux_interface_wc_cart');
    
    if(ux_get_option('theme_option_enable_WPML')){
            
        if(function_exists('icl_get_languages')){
    ?>
    <h3 class="mobile-header-tit"><?php _e('LANGUAGUES','ux'); ?></h3>
    <?php 
            language_flags();
        }
    } 
    ?>

    <?php //** If Theme Option enable search field
		$ux_enable_search_field = ux_get_option('theme_option_enable_search_field');
		
        if($ux_enable_search_field){
            $enter_key =  __('SEARCH','ux');?>
        
            <form id="search_form" name="" method="get" class="search-form_header" action="<?php echo home_url(); ?>/">
                <input type="text" onBlur="if (this.value == '') {this.value = '<?php echo $enter_key; ?>';}" onFocus="if (this.value == '<?php echo $enter_key; ?>') {this.value = '';}" id="s" name="s" value="<?php echo $enter_key; ?>" class="textboxsearch"><span class="submit-wrap"><input type="submit" value="" class="submitsearch" name="submitsearch"><i class="fa fa-long-arrow-right middle-ux"></i></span>
            </form>
        
    <?php }
	
	//** If Theme Option enable social
	if(ux_get_option('theme_option_show_social')){ ?>
		
        <?php //** Do Hook Hook Social
		do_action('ux_interface_mobile_social');
		
	} //End if get theme option
	?>
                            
    <div class="mobile-meta-con">
        <div class="copyright"><?php ux_interface_copyright(); ?></div>
    </div><!--End header-info-mobile-->
                        
</div>
<!--End mobile-header-meta-->