<?php
   /*
   Plugin Name: Messenger Customer Chat Plugin
   Description: Easily add an official Messenger Customer Chat Plugin to your website. More info about the plugin on https://developers.facebook.com/docs/messenger-platform/discovery/customer-chat-plugin
   Version: 1.0.0
   Author: Ringotel
   License: GPL3
   */
  

   // Make sure we don't expose any info if called directly
   if ( !function_exists( 'add_action' ) ) {
      echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
      exit;
   }

   define('RINGOTEL_MCC_VERSION', '1.0.0');
   define( 'RINGOTEL_MCC__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

   // add_action( 'admin_menu', 'messenger_customer_chat_menu' );
   if ( is_admin() ){ // admin actions
      require_once( RINGOTEL_MCC__PLUGIN_DIR . 'messenger-customer-chat-admin.php' );
      add_action( 'init', array( 'Ringotel_MCC_Admin', 'init' ) );

   } else {
     // non-admin enqueues, actions, and filters
     ringotel_mcc_add_client_scripts();
   }

   function ringotel_mcc_add_client_scripts() {
      wp_enqueue_script( 'messenger-customer-chat', plugins_url('/messenger-customer-chat.js',  __FILE__ ), array('jquery'), RINGOTEL_MCC_VERSION, true);

      $data = array(
         'page_id' => get_option('page_id'),
         'locale' => get_option('locale')
         // 'api_version' => get_option('api_version')
      );

      wp_localize_script( 'messenger-customer-chat', 'plugin_options', $data );
   }


?>