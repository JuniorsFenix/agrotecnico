<?php

class Wp_Temporary_Login_Without_Password_Common {

    public static function create_username($data) {

        $first_name = isset($data['user_first_name']) ? $data['user_first_name'] : '';
        $last_name = isset($data['user_last_name']) ? $data['user_last_name'] : '';
        $email = isset($data['user_email']) ? $data['user_email'] : '';

        $name = '';
        if (!empty($first_name) || !empty($last_name)) {
            $name = str_replace(array('.', '+'), '', trim($first_name . $last_name));
        } else {
            if (!empty($email)) {
                $explode = explode('@', $email);
                $name = str_replace(array('.', '+'), '', $explode[0]);
            }
        }

        if (username_exists($name)) {
            $name = $name . substr(uniqid('', true), -6);
        }

        return sanitize_user($name, true);
    }

    public static function create_new_user($data) {

        if (false === Wp_Temporary_Login_Without_Password_Common::can_manage_wtlwp()) {
            return;
        }

        $time = !empty($data['expiry']) ? $data['expiry'] : 'day';

        $password = Wp_Temporary_Login_Without_Password_Common::generate_password();
        $username = Wp_Temporary_Login_Without_Password_Common::create_username($data);
        $first_name = isset($data['user_first_name']) ? sanitize_text_field($data['user_first_name']) : '';
        $last_name = isset($data['user_last_name']) ? sanitize_text_field($data['user_last_name']) : '';
        $email = isset($data['user_email']) ? sanitize_email($data['user_email']) : '';
        $user_args = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'user_login' => $username,
            'user_pass' => $password,
            'user_email' => sanitize_email($email, true),
            'role' => $data['role'],
        );

        $user_id = wp_insert_user($user_args);

        if (is_wp_error($user_id)) {
            $code = $user_id->get_error_code();
            return array(
                'error' => true,
                'errcode' => $code,
                'message' => $user_id->get_error_message($code)
            );
        }

        update_user_meta($user_id, '_wtlwp_user', true);
        update_user_meta($user_id, '_wtlwp_created', Wp_Temporary_Login_Without_Password_Common::get_current_gmt_timestamp());
        update_user_meta($user_id, '_wtlwp_expire', Wp_Temporary_Login_Without_Password_Common::get_user_expire_time($time));
        update_user_meta($user_id, '_wtlwp_token', Wp_Temporary_Login_Without_Password_Common::generate_wtlwp_token($user_id));

        update_user_meta($user_id, 'show_welcome_panel', 0);

        return $user_id;
    }

    /**
     * get the expiry duration
     * 
     * @param type $key
     * @return boolean|array
     */
    public static function get_expiry_duration($key = '') {

        $expiry_duration = array(
            '3_days' => array(
                'value' => DAY_IN_SECONDS * 3,
                'label' => __('Three Days', Wp_Temporary_Login_Without_Password_i18n::$text_domain)
            ),
            'day' => array(
                'value' => DAY_IN_SECONDS,
                'label' => __('One Day', Wp_Temporary_Login_Without_Password_i18n::$text_domain)
            ),
            '3_hours' => array(
                'value' => HOUR_IN_SECONDS * 3,
                'label' => __('Three Hours', Wp_Temporary_Login_Without_Password_i18n::$text_domain)
            ),
            'hour' => array(
                'value' => HOUR_IN_SECONDS,
                'label' => __('One Hour', Wp_Temporary_Login_Without_Password_i18n::$text_domain)
            ),
            'week' => array(
                'value' => WEEK_IN_SECONDS,
                'label' => __('One Week', Wp_Temporary_Login_Without_Password_i18n::$text_domain)
            ),
            'month' => array(
                'value' => DAY_IN_SECONDS * 30,
                'label' => __('One Month', Wp_Temporary_Login_Without_Password_i18n::$text_domain)
            ),
        );


        if (empty($key)) {
            return $expiry_duration;
        } elseif (isset($expiry_duration[$key])) {
            return $expiry_duration[$key];
        } else {
            return;
        }
    }

    static function get_expiry_duration_html($selected = '') {

        $p = '';
        $r = '';

        $expiry_duration = self::get_expiry_duration();

        foreach ($expiry_duration as $key => $duration) {
            $label = $duration['label'];
            if ($selected == $key)
                $p = "\n\t<option selected='selected' value='" . esc_attr($key) . "'>$label</option>";
            else
                $r .= "\n\t<option value='" . esc_attr($key) . "'>$label</option>";
        }

        echo $p . $r;
    }

    public static function generate_password() {
        return wp_generate_password(absint(15), true, false);
    }

    public static function get_user_expire_time($time = '') {
        $data = self::get_expiry_duration($time);
        $range = !empty($data['value']) ? $data['value'] : DAY_IN_SECONDS;

        return self::get_current_gmt_timestamp() + floatval($range);
    }

    public static function get_current_gmt_timestamp() {
        return strtotime(gmdate('Y-m-d H:i:s', time()));
    }

    public static function get_temporary_logins( $role = '') {

        $args = array(
            'fields' => 'all',
            'meta_key' => '_wtlwp_expire',
            'order' => 'DESC',
            'orderby' => 'meta_value',
            'meta_query' => array(
                0 => array(
                    'key' => '_wtlwp_user',
                    'value' => 1
                )
            )
        );

        if (!empty($role)) {
            $args['role'] = $role;
        }

        $users = new WP_User_Query($args);

        if (!($users->results)) {
            return false;
        }

        return $users->results;
    }

    public static function format_date_display($stamp = 0, $type = 'date_format') {

        $type_format = 'date_format';
        if ($type == 'date_format') {
            $type_format = get_option('date_format');
        } else if ($type == 'time_format') {
            $type_format = get_option('time_format');
        }


        $timezone = get_option('timezone_string');

        if (empty($timezone)) {
            return date($type_format, $stamp);
        }

        $date = new DateTime('@' . $stamp);

        $date->setTimezone(new DateTimeZone($timezone));

        return $date->format($type_format);
    }

    public static function get_redirect_link($result = array()) {

        if (empty($result)) {
            return false;
        }

        $base_url = menu_page_url('wp-temporary-login-without-password', false);

        if (empty($base_url)) {
            return false;
        }

        $query_string = '';
        if (!empty($result['status'])) {
            if ($result['status'] == 'success') {
                $query_string .= '&wtlwp_success=1';
            } elseif ($result['status'] == 'error') {
                $query_string .= '&wtlwp_error=1';
            }
        }

        if (!empty($result['message'])) {
            $query_string .= '&wtlwp_message=' . $result['message'];
        }

        $redirect_link = $base_url . $query_string;

        return $redirect_link;
    }

    public static function can_manage_wtlwp($user_id = 0) {

        if (empty($user_id)) {
            $user_id = get_current_user_id();
        }

        if (empty($user_id)) {
            return false;
        }

        $check = get_user_meta($user_id, '_wtlwp_user', true);

        return !empty($check) ? false : true;
    }

    public static function is_login_expired($user_id = 0) {

        if (empty($user_id)) {
            $user_id = get_current_user_id();
        }

        if (empty($user_id)) {
            return false;
        }

        $expire = get_user_meta($user_id, '_wtlwp_expire', true);

        return !empty($expire) && self::get_current_gmt_timestamp() >= floatval($expire) ? true : false;
    }

    public static function generate_wtlwp_token($user_id) {
        $str = $user_id . time() . uniqid('', true);
        return md5($str);
    }

    public static function get_valid_user_based_on_wtlwp_token($token = '', $user_id = 0, $fields = 'all') {
        $users_data = array();
        if (empty($token)) {
            return false;
        }

        $args = array(
            'fields' => $fields,
            'meta_key' => '_wtlwp_expire',
            'order' => 'DESC',
            'orderby' => 'meta_value',
            'meta_query' => array(
                0 => array(
                    'key' => '_wtlwp_token',
                    'value' => sanitize_text_field($token),
                    'compare' => '='
                )
            )
        );

        $users = new WP_User_Query($args);

        if (empty($users->results)) {
            return false;
        }

        $users_data = $users->results;
        foreach ($users_data as $key => $user) {
            $expire = get_user_meta($user->ID, '_wtlwp_expire', true);
            if ($expire <= self::get_current_gmt_timestamp()) {
                unset($users_data[$key]);
            }
        }

        return $users_data;
    }

    public static function is_valid_temporary_login($user_id = 0, $check_expiry = true) {

        if (empty($user_id)) {
            return false;
        }

        $check = get_user_meta($user_id, '_wtlwp_user', true);

        if (!empty($check) && $check_expiry) {
            $check = !(self::is_login_expired($user_id));
        }

        return !empty($check) ? true : false;
    }

    public static function get_manage_login_url($user_id, $action = '') {

        if (empty($user_id) || empty($action)) {
            return;
        }

        $base_url = menu_page_url('wp-temporary-login-without-password', false);
        $args = array();

        switch ($action) {
            case 'disable';
                $args = array('wtlwp_action' => 'disable', 'user_id' => $user_id);
                break;
            case 'enable';
                $args = array('wtlwp_action' => 'enable', 'user_id' => $user_id);
                break;
            case 'delete';
                $args = array('wtlwp_action' => 'delete', 'user_id' => $user_id);
                break;
            default:
                break;
        }

        $manage_login_url = '';
        if (!empty($args)) {
            $base_url = add_query_arg($args, trailingslashit($base_url));
            $manage_login_url = wp_nonce_url($base_url, 'manage-temporary-login_' . $user_id, 'manage-temporary-login');
        }

        return $manage_login_url;
    }

    public static function get_login_url($user_id) {

        if (empty($user_id)) {
            return;
        }

        $is_valid_temporary_login = self::is_valid_temporary_login($user_id, false);
        if (!$is_valid_temporary_login) {
            return;
        }

        $wtlwp_token = get_user_meta($user_id, '_wtlwp_token', true);
        if (empty($wtlwp_token)) {
            return;
        }

        $login_url = add_query_arg('wtlwp_token', $wtlwp_token, trailingslashit(admin_url()));

        return $login_url;
    }

    public static function manage_login($user_id = 0, $action = '') {

        if (empty($user_id) || empty($action)) {
            return;
        }

        $is_valid_temporary_login = self::is_valid_temporary_login($user_id, false);
        if (!$is_valid_temporary_login) {
            return;
        }

        $manage_login = false;
        if ($action == 'disable') {
            $manage_login = update_user_meta($user_id, '_wtlwp_expire', self::get_current_gmt_timestamp());
        } elseif ($action == 'enable') {
            $manage_login = update_user_meta($user_id, '_wtlwp_expire', self::get_user_expire_time());
        }

        if ($manage_login) {
            return true;
        }

        return false;
    }

    public static function time_elapsed_string($time, $ago = false) {

        if ($ago) {
            $etime = self::get_current_gmt_timestamp() - $time;
        } else {
            $etime = $time - self::get_current_gmt_timestamp();
        }

        if ($etime < 1) {
            return __('Expired', Wp_Temporary_Login_Without_Password_i18n::$text_domain);
        }

        $a = array(365 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        $a_plural = array('year' => 'years',
            'month' => 'months',
            'day' => 'days',
            'hour' => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                if ($ago) {
                    return __(sprintf('%d %s ago', $r, ($r > 1 ? $a_plural[$str] : $str)), Wp_Temporary_Login_Without_Password_i18n::$text_domain);
                } else {
                    return __(sprintf('%d %s remaining', $r, ($r > 1 ? $a_plural[$str] : $str)), Wp_Temporary_Login_Without_Password_i18n::$text_domain);
                }
            }
        }
    }

    public static function get_blocked_pages() {
        $blocked_pages = array('wp-temporary-login-without-password', 'user-new.php', 'user-edit.php', 'profile.php');
        $blocked_pages = apply_filters('wtlwp_restricted_pages_for_temporary_users', $blocked_pages);
        return $blocked_pages;
    }
    
    public static function delete_temporary_logins () {
        
        $temporary_logins = Wp_Temporary_Login_Without_Password_Common::get_temporary_logins();

        if (count($temporary_logins) > 0) {
            foreach ($temporary_logins as $user) {
                if ($user instanceof WP_User) {
                    $user = wp_delete_user($user->ID); // Delete User
                }
            }
        }
        
        
    }
    

}
