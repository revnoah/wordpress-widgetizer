<?php

namespace Widgetizer;

class Dynamic_Widget {
    const CACHE_KEY = 'widgetizer_dynamic_content_cache';
    const CACHE_KEY_STYLES = 'widgetizer_theme_styles';

    public static function init() {
        add_action('wp_dashboard_setup', [self::class, 'add_dynamic_widgets']);
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_block_styles']);
        add_action('updated_option', [self::class, 'clear_cache'], 10, 2);
    }

    /**
     * Add dynamic widgets to the dashboard.
     */
    public static function add_dynamic_widgets() {
        $user = wp_get_current_user();
        $user_roles = (array) $user->roles;

        $widgets = apply_filters('widgetizer_widget_query', get_posts([
            'post_type'   => 'widgetizer_widget',
            'post_status' => 'publish',
            'numberposts' => -1,
        ]));

        foreach ($widgets as $widget) {
            $widget_roles = get_post_meta($widget->ID, '_widgetizer_roles', true) ?: [];
            $should_display = array_intersect($user_roles, $widget_roles);

            if ($should_display || count($widget_roles) === 0) {
                wp_add_dashboard_widget(
                    'widgetizer_widget_' . $widget->ID,
                    $widget->post_title,
                    function () use ($widget) {
                        echo apply_filters('the_content', $widget->post_content);
                    }
                );
                add_filter("postbox_classes_dashboard_widgetizer_widget_{$widget->ID}", function ($classes) {
                    $classes[] = 'widgetizer-full-width';
                    return $classes;
                });
            }
        }
    }

    public static function add_dynamic_widget() {
        wp_add_dashboard_widget(
            'widgetizer_dynamic_content',
            __('Dynamic Content', 'widgetizer'),
            [self::class, 'render_widget']
        );
    }

    public static function render_widget() {
        $cache_key = apply_filters('widgetizer_cache_key', self::CACHE_KEY);
        $cached_content = get_transient($cache_key);
    
        if ($cached_content === false) {
            $content = get_option('widgetizer_dynamic_content', '');
            $content = apply_filters('widgetizer_raw_content', $content);
            $cached_content = apply_filters('the_content', wp_kses_post($content));
            $cached_content = apply_filters('widgetizer_cached_content', $cached_content);
            set_transient($cache_key, $cached_content, apply_filters('widgetizer_cache_duration', 12 * HOUR_IN_SECONDS));
        }
    
        echo $cached_content ?: '<p>' . __('No content available.', 'widgetizer') . '</p>';
    }

    public static function enqueue_block_styles($hook) {
        if ($hook === 'index.php') {
            // Enqueue core block styles
            wp_enqueue_style('wp-block-library');
            wp_enqueue_style('wp-block-library-theme');
    
            // Enqueue theme.json global styles
            $theme_styles = get_transient(self::CACHE_KEY_STYLES);
            if (!$theme_styles) {
                $theme_styles = wp_get_global_stylesheet();
                set_transient(self::CACHE_KEY_STYLES, $theme_styles, DAY_IN_SECONDS);
            }
            wp_add_inline_style('wp-block-library', $theme_styles);
        }
    }
    
    public static function clear_cache($option_name, $old_value) {
        if ($option_name === 'widgetizer_dynamic_content') {
            delete_transient(self::CACHE_KEY);
        }
    }
}
