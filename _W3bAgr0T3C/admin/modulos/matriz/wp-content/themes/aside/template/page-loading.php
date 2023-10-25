<?php
$visible = 'visible';
if(is_front_page() && is_home()){
	$visible = false;
}

//** enable page loading
$ux_enable_fadein_effect = ux_get_option('theme_option_enable_fadein_effect');

if($ux_enable_fadein_effect){ ?>

    <div class="page-loading <?php echo $visible; ?>">
        <div class="page-loading-inn">
            <div class="page-loading-transform">
            	<div class="ux-loading"></div>
            	<div class="ux-loading-transform"><div class="loading-dot1">&nbsp;</div><div class="loading-dot2">&nbsp;</div></div>
            	<?php ux_interface_logo('loading'); ?>
        	</div>
        </div>
    </div>

<?php } ?>