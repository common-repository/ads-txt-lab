<?php
defined('ABSPATH') or die('No script kiddies please!');

/*
Plugin Name: ads.txt lab
Description: ads.txt lab is the easiest way to setup and manage your ads.txt file. The ads.txt file allows advertisers to verify the traffic that they buy from your website and therefore reduces adfraud. Get your ads.txt lab ID for free at <a href="http://www.adstxtlab.com">www.adstxtlab.com</a> and insert the ID in the plugin settings.
Version: 1.5
Author: ads.txtlab
Author URI: https://www.adstxtlab.com
License: GPL2
*/

require_once dirname(__FILE__) . '/AdsTxtLabMain.php';



add_action('admin_menu', 'adsTxtLabMenu');

/** Add Settings button to plugin overview page */
if (!function_exists('adsTxtLab_admin_action_links')) {
    function adsTxtLab_admin_action_links($links, $file)
    {
        if ( !current_user_can('edit_posts') ){
            return;
        }
        static $my_plugin;
        if (!$my_plugin) {
            $my_plugin = plugin_basename(__FILE__);
        }
        if ($file == $my_plugin) {
            $settings_link = "<a href='" . AdsTxtLabMain::getAdminUrl() . "'>Settings</a>";
            array_unshift($links, $settings_link);
        }
        return $links;
    }

    /** Add left main menu item */
    function adsTxtLabMenu()
    {
        if ( !current_user_can('edit_posts') ){
            return;
        }

        $icon = null; //icon for menu
        add_options_page('ads.txt lab Options', 'ads.txt lab', 'manage_options', AdsTxtLabMain::ADMIN_URL, 'displayAdminPage', $icon);
        add_action( 'admin_init', 'adsTxtLab_register_settings' );
    }


    /** Display view */
    function displayAdminPage()
    {
        if ( !current_user_can('edit_posts') )
            return;
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        include_once 'views/admin.php';
    }

    function adsTxtLab_register_settings() {
        //register our settings

    }
    
}

add_filter('plugin_action_links', 'adsTxtLab_admin_action_links', 10, 2);



//debugging function
if (!function_exists('dump')) {
    function dump($var)
    {
        echo "<pre><div align='left'>";
        print_r($var);
        echo "</div></pre>";
    }
}