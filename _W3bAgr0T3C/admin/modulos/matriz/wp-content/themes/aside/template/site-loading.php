<?php if(is_front_page() || is_home()){ ?>

    <div class="site-loading">
        <div class="site-loading-inn">
            <div class="page-loading-transform">
            	<div class="ux-loading"></div>
                <div class="ux-loading-transform"><div class="loading-dot1">&nbsp;</div><div class="loading-dot2">&nbsp;</div></div>
                <?php ux_interface_logo('loading'); ?>
            </div>
        </div>
    </div>

<?php } ?>