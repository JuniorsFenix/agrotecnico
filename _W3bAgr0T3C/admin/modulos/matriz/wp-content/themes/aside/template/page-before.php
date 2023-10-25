<?php
//** get sidebar meta
$sidebar            = ux_get_post_meta(get_the_ID(), 'theme_meta_sidebar');
$sidebar_class      = $sidebar == 'without-sidebar' ? false : 'two-cols-layout';

if(!ux_enable_portfolio_template()){ ?>

    <div class="row-fluid <?php echo $sidebar_class; ?>">

<?php } ?>