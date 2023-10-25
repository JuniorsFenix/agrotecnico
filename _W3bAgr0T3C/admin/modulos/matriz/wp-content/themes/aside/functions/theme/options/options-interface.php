<div class="wrap">
	<div class="icon32" id="icon-themes"><br></div>
	<h2>
		<?php _e('Theme Option', 'ux') ?>
	</h2>
    
    <?php if(isset($_GET['message'])): ?>
		<?php if($_GET['message'] == 'restore'): ?>
        <div id="restore-defaults-msg">
            <div class="updated below-h2"><p><?php _e('Restore Defaults', 'ux') ?></p></div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
    
    <?php ux_theme_option_save(); ?>
    <form id="ux-theme-option-form" action="<?php echo admin_url('admin.php?page=theme-option'); ?>" method="post">
        <input type="hidden" name="action" value="save" />
        <input type="hidden" name="_uxnonce" value="<?php echo wp_create_nonce(admin_url('admin.php?page=theme-option')); ?>" />
        <div class="ux-theme-box">
            <div class="ux-theme-tabs">
                <?php $theme_config_fields = ux_theme_options_config_fields();
                if(count($theme_config_fields) > 0){ ?>
                    <ul class="nav nav-tabs">
                        <?php foreach($theme_config_fields as $i => $config){
                            $active = ($i == 0) ? 'active' : false; ?>
                            <li class="<?php echo $active; ?>"><a href="#<?php echo $config['id']; ?>" data-toggle="tab"><?php echo $config['name']; ?></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                
                <?php if(count($theme_config_fields) > 0){ ?>
                    <div class="tab-content">
                        <?php foreach($theme_config_fields as $i => $config){
                            $active = ($i == 0) ? 'active' : false; ?>
                            <div id="<?php echo $config['id']; ?>" class="tab-pane <?php echo $active; ?>">
                                <?php if(isset($config['section'])){
                                    foreach($config['section'] as $i => $section){
                                        $border = ($i != 0) ? 'border-top:1px dotted #ccc;' : false;
										$title = isset($section['title']) ? $section['title'] : false; ?>
                                        <div class="theme-option-item" style=" <?php echo $border; ?>">
                                            <h3 class="theme-option-item-heading"><?php echo $title; ?></h3>
                                            <?php if(isset($section['item'])){
                                                foreach($section['item'] as $item){
                                                    $no_margin_bottom = ($item['type'] == 'switch-color') ? 'margin-bottom:0px;' : false;
													$col_md_width = $item['type'] == 'color-scheme' ? 'col-md-12' : 'col-md-7';
                                                    $control = isset($item['control']) ? 'data-name="' . $item['control']['name'] . '" data-value="' . $item['control']['value'] . '"' : false;  ?>
                                                    <div class="row <?php echo $item['name']; ?>" style=" <?php echo $no_margin_bottom; ?>" <?php echo $control; ?>>
                                                        <?php if(isset($item['title']) && $item['type'] != 'switch-color'){ ?>
                                                            <h5 class="col-md-12"><?php echo $item['title']; ?></h5>
                                                        <?php } ?>
                                                        <div class="<?php echo $col_md_width; ?>">
                                                            <?php if(isset($item['bind'])){
                                                                foreach($item['bind'] as $bind){
                                                                    if($bind['position'] == 'before'){
                                                                        ux_theme_option_getfield($bind, 'ux_theme_option');
                                                                    }
                                                                }
                                                            }
                                                            
                                                            ux_theme_option_getfield($item, 'ux_theme_option');
                                                            
                                                            if(isset($item['bind'])){
                                                                foreach($item['bind'] as $bind){
                                                                    if($bind['position'] == 'after'){
                                                                        ux_theme_option_getfield($bind, 'ux_theme_option');
                                                                    }
                                                                }
                                                            } ?>
                                                        </div>
                                                        <?php if($item['type'] != 'color-scheme'){ ?>
                                                            <div class="col-md-5 text-muted">
                                                                <?php if(isset($item['description'])){
                                                                    echo $item['description'];
                                                                }
                                                                
                                                                if(isset($item['help_url'])){ ?>
                                                                    <a title="<?php echo $item['help_url']; ?>" class="themeoption-help-a" target="_blank" href="<?php echo $item['help_url']; ?>"><span class="themeoption-help">?</span></a>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                <?php
                                                }
                                            } ?>
                                        </div>
                                    <?php	
                                    }
                                } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="ux-theme-option-submit">
                    <div class="row">
                        <div class="col-sm-6"><button type="button" class="btn btn-default btn-sm restore_defaults" data-notice="<?php _e('All the settings you have done will be cover write to the default settings, are you sure you want to continue?', 'ux'); ?>"><?php _e('Restore Defaults', 'ux'); ?></button><a class="btn btn-default btn-sm" href="http://www.uiueux.com/a/aside/help/" target="_blank"><?php _e('Documentation', 'ux'); ?></a><a class="btn btn-default btn-sm btn-support" href="http://www.uiueux.com/forums/" target="_blank"><?php _e('Support Forum', 'ux'); ?></a></div>
                        
                        <div class="col-sm-6 text-right"><button type="submit" class="btn btn-primary btn-sm" data-loading="<?php _e('Please waitting...', 'ux'); ?>"><?php _e('Save Options', 'ux'); ?></button></div>
                    </div>
                </div>
            </div>
            
            <?php ux_theme_option_modal(); ?>
        </div>
    </form>
</div>