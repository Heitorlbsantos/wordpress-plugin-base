<?php
/**
 * Plugin Name: Plugin Name
 * Description: Base for WordPress plugin development
 * Version: 1.0
 * Author: Heitor L. B. Santos
 * Author URI: https://heitorlbsantos.com.br
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: example-domain
 * Domain Path: /languages
 **/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('Plugin_Main_Class')) {
    class Plugin_Main_Class {
        public function __construct() {
            $this->define_constants();

            // Insert the plugin's actions, filters or classes here.
        }

        /**
         * Define plugin constants.
         *
         * The constants PLUGIN_INTG_PATH and PLUGIN_INTG_URL are defined if not
         * already set. PLUGIN_INTG_PATH is the absolute path to the plugin directory,
         * and PLUGIN_INTG_URL is the URL to the plugin directory.
         */
        public function define_constants() {
            if (!defined('PLUGIN_INTG_PATH')) {
                define('PLUGIN_INTG_PATH', plugin_dir_path(__FILE__));
            }
            if (!defined('PLUGIN_INTG_URL')) {
                define('PLUGIN_INTG_URL', plugin_dir_url(__FILE__));
            }
        }

        /**
         * Plugin activation function.
         *
         * This function is called when the plugin is activated. Its responsibility
         * is to flush the rewrite rules and prepare the environment.
         *
         * @return void
         */
        public static function activate() {
            flush_rewrite_rules();
        }

        /**
         * Plugin deactivation function.
         *
         * @return void
         */
        public static function deactivate() {
            flush_rewrite_rules();
        }
    }
}

if (class_exists('Plugin_Main_Class')) {
    register_activation_hook(__FILE__, array('Plugin_Main_Class', 'activate'));
    register_deactivation_hook(__FILE__, array('Plugin_Main_Class', 'deactivate'));

    new Plugin_Main_Class();
}