<?php

namespace Widgetizer;

class Disable_Widgets {
    public static function init() {
        add_action('wp_dashboard_setup', [self::class, 'disable_default_widgets']);
    }

    /**
     * Disable default WordPress dashboard widgets.
     */
    public static function disable_default_widgets() {
        global $wp_meta_boxes;

        if (!Permissions::user_can_manage()) {
            return;
        }

        // Remove default widgets
        // remove_meta_box('dashboard_primary', 'dashboard', 'side'); // WordPress News
        // remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // Quick Draft
        // remove_meta_box('dashboard_activity', 'dashboard', 'normal'); // Activity
        // remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); // At a Glance
        // remove_meta_box('dashboard_site_health', 'dashboard', 'normal'); // Site Health

        // Move all widgets from other containers to 'normal'
        /*
        foreach (['side', 'column3', 'column4'] as $container) {
            if (isset($wp_meta_boxes['dashboard'][$container])) {
                foreach ($wp_meta_boxes['dashboard'][$container] as $priority => $widgets) {
                    foreach ($widgets as $widget_id => $widget) {
                        $wp_meta_boxes['dashboard']['normal'][$priority][$widget_id] = $widget;
                    }
                }
                unset($wp_meta_boxes['dashboard'][$container]); // Clear the container after moving
            }
        }
        */
    }
}
