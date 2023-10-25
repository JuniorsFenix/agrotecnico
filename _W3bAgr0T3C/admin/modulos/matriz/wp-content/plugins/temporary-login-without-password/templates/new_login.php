<h2> <?php echo __('Create a new Temporary Login', Wp_Temporary_Login_Without_Password_i18n::$text_domain); ?></h2>
<form method="post">
    <table class="form-table wtlwp-form">
        <tr class="form-field form-required">
            <th scope="row" class="wtlwp-form-row"> <label for="user_email"><?php echo __('Email*', Wp_Temporary_Login_Without_Password_i18n::$text_domain); ?> </label></th>
            <td><input name="wtlwp_data[user_email]" type="text" id="user_email" value="" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60" class="wtlwp-form-input"/></td>
        </tr>

        <tr class="form-field form-required">
            <th scope="row" class="wtlwp-form-row"> <label for="user_first_name"><?php echo __('First Name', Wp_Temporary_Login_Without_Password_i18n::$text_domain); ?> </label></th>
            <td><input name="wtlwp_data[user_first_name]" type="text" id="user_first_name" value="" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60" class="wtlwp-form-input"/></td>
        </tr>

        <tr class="form-field form-required">
            <th scope="row" class="wtlwp-form-row"> <label for="user_last_name"><?php echo __('Last Name', Wp_Temporary_Login_Without_Password_i18n::$text_domain); ?> </label></th>
            <td><input name="wtlwp_data[user_last_name]" type="text" id="user_last_name" value="" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60" class="wtlwp-form-input"/></td>
        </tr>
        <tr class="form-field">
            <th scope="row" class="wtlwp-form-row"><label for="adduser-role"><?php echo __('Role', Wp_Temporary_Login_Without_Password_i18n::$text_domain); ?></label></th>
            <td><select name="wtlwp_data[role]" id="user-role">
                    <?php wp_dropdown_roles('administrator'); ?>
                </select>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row" class="wtlwp-form-row"><label for="adduser-role"><?php echo __('Expiry', Wp_Temporary_Login_Without_Password_i18n::$text_domain); ?></label></th>
            <td><select name="wtlwp_data[expiry]" id="user-expiry-time">
                    <?php Wp_Temporary_Login_Without_Password_Common::get_expiry_duration_html(); ?>
                </select>
            </td>
        </tr>
        
        <tr class="form-field">
            <th scope="row" class="wtlwp-form-row"><label for="adduser-role"></label></th>
            <td><p class="submit"><input type="submit" class="button button-primary wtlwp-form-submit-button" value="<?php _e('Submit', Wp_Temporary_Login_Without_Password_i18n::$text_domain); ?>" class="button button-primary" id="generatetemporarylogin" name="generate_temporary_login"> <?php _e('or', Wp_Temporary_Login_Without_Password_i18n::$text_domain); ?> <span class="cancel-new-login-form" id="cancel-new-login-form"><?php _e('Cancel', Wp_Temporary_Login_Without_Password_i18n::$text_domain); ?></span></p>
            </td>
        </tr>
        <?php wp_nonce_field('wtlwp_generate_login_url', 'wtlwp-nonce', true, true); ?>
    </table>
</form>