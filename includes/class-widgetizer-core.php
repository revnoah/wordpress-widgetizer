<?php

namespace Widgetizer;

class Core {
    public static function init() {
        self::load_dependencies();
        self::add_hooks();
    }

    private static function load_dependencies() {
        require_once plugin_dir_path(__FILE__) . 'class-custom-post-type.php';
        require_once plugin_dir_path(__FILE__) . 'class-permissions.php';
        require_once plugin_dir_path(__FILE__) . 'class-disable-widgets.php';
        require_once plugin_dir_path(__FILE__) . 'class-dynamic-widget.php';
        require_once plugin_dir_path(__FILE__) . 'class-settings.php';
        require_once plugin_dir_path(__FILE__) . 'class-style-handler.php';
    }

    private static function add_hooks() {
        Custom_Post_Type::init();
        Permissions::init();
        Disable_Widgets::init();
        Dynamic_Widget::init();
        Settings::init();
        Style_Handler::init();
        
        // Load admin styles
        add_action('admin_enqueue_scripts', function() {
            wp_enqueue_style('widgetizer-admin', plugin_dir_url(__FILE__) . '../assets/admin-style.css');

            do_action('widgetizer_enqueue_dashboard_styles');
        });

        // Load translations
        add_action('plugins_loaded', function() {
            load_plugin_textdomain('widgetizer', false, dirname(plugin_basename(__FILE__)) . '/../languages');
        });
    }
}
