<?php
/**
 * Plugin Name: Dashboard Widgetizer
 * Description: A customizable dashboard plugin that adds dynamic widget content built using the Gutenberg block content editor.
 * Version: 1.0.1
 * Author: Noah Stewart
 * Text Domain: widgetizer
 * Domain Path: /languages
 * Namespace: Widgetizer
 */

defined('ABSPATH') || exit;

require_once plugin_dir_path(__FILE__) . 'includes/class-widgetizer-core.php';

use Widgetizer\Core;

add_action('plugins_loaded', function() {
    Core::init();
});

register_activation_hook(__FILE__, function () {
    $role = get_role('administrator');
    if ($role) {
        $role->add_cap('manage_widgetizer_widgets');
    }
});

register_deactivation_hook(__FILE__, function () {
    $role = get_role('administrator');
    if ($role) {
        $role->remove_cap('manage_widgetizer_widgets');
    }
});
