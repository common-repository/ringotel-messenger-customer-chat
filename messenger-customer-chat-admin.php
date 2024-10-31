<?php
  

    class Ringotel_MCC_Admin {

        public static function init() {
            $plugin = plugin_basename( __FILE__ );

            add_action( 'admin_menu', array( 'Ringotel_MCC_Admin', 'add_menu') );
            add_action( 'admin_init', array( 'Ringotel_MCC_Admin', 'register_plugin_options') );
            add_action('wp_enqueue_scripts', array( 'Ringotel_MCC_Admin', 'add_plugin_scripts') );
            add_filter( "plugin_action_links_$plugin", array( 'Ringotel_MCC_Admin', 'plugin_add_settings_link') );
        }

        public static function add_menu() {
            add_options_page( 'Messenger Customer Chat', 'Messenger Customer Chat', 'manage_options', '  messenger-customer-chat', array( 'Ringotel_MCC_Admin', 'add_options') );
        }

        public static function add_options() {
            if ( !current_user_can( 'manage_options' ) )  {
                wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
            }

            echo '<div class="wrap">';
            echo '<h1>Messenger Customer Chat</h1>';
            echo '<form method="post" action="options.php">';

            settings_fields( 'plugin_options' );
            do_settings_sections( 'plugin' );
            submit_button();

            echo "</form>";
            echo '</div>';
        }

        public static function register_plugin_options() { // whitelist options
            register_setting( 'plugin_options', 'page_id', array( 'Ringotel_MCC_Admin', 'validate_page_id') );
            register_setting( 'plugin_options', 'locale', array( 'Ringotel_MCC_Admin', 'validate_locale') );
            // register_setting( 'plugin_options', 'api_version', 'validate_api_version' );

            add_settings_section('plugin_main', 'Plugin Options', array( 'Ringotel_MCC_Admin', 'plugin_section_text'), 'plugin');

            add_settings_field('page_id', 'Page ID', array( 'Ringotel_MCC_Admin', 'setting_string'), 'plugin', 'plugin_main', array('option_id' => 'page_id', 'description' => self::getFieldDescription('page_id')));
            add_settings_field('locale', 'Locale', array( 'Ringotel_MCC_Admin', 'setting_string'), 'plugin', 'plugin_main', array('option_id' => 'locale', 'default_value' => 'en_US'));
        }

        public static function plugin_section_text() {
            echo (
                '<p>In order for plugin to work on your website, whitelist your website\'s domain name in your Facebook Page settings.<br>To do that: </p>'
                . '<ol>'
                . '<li>You have to be Page Admin</li>'
                . '<li>Go to www.facebook.com/your_page</li>'
                . '<li>Click Settings at the top of your Page</li>'
                . '<li>Click Messenger Platform on the left</li>'
                . '<li>Edit whitelisted domains for your page in the Whitelisted Domains section</li>'
                . '</ol>'
                . '<p>For more info, go to <a href="https://developers.facebook.com/docs/messenger-platform/discovery/customer-chat-plugin">https://developers.facebook.com/docs/messenger-platform/discovery/customer-chat-plugin</a></p>'
            );
        }

        public static function setting_string($opts) {
            $option_id = $opts['option_id'];
            $option = get_option($option_id);
            $defaultValue = "";
            $value = "";

            if(array_key_exists('default_value', $opts)) {
                $defaultValue = $opts['default_value'];
            }

            if(empty($option)) {
                $value = $defaultValue;
            } else {
                $value = $option;
            }

            echo "<input id='$option_id' name='$option_id' size='40' type='text' value='$value' />";
            echo ("<p class=\"description\">" . $opts['description'] . "</p>");
        }

        public static function plugin_add_settings_link( $links ) {
           $settings_link = '<a href="options-general.php?page=plugin_name">' . __( 'Settings' ) . '</a>';
           array_push( $links, $settings_link );
           return $links;
        }

        public static function getFieldDescription($field_id) {
            $desc = '';

            switch($field_id) {
                case 'page_id':
                    $desc = 'To obtain Page ID: go to your www.facebook.com/your_page -> <em>About</em> -> <em>Page ID</em> at the bottom';
                    break;
            }

            return $desc;
        }
      
        public static function validate_page_id($input) {
            return $input;
        }

        public static function validate_locale($input) {
            return $input;
        }

        // public static function validate_api_version($input) {
        //    return $input;
        // }
    }

?>