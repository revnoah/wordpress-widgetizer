<?php

namespace Widgetizer;

class Settings {
    public static function init() {
        add_action('admin_menu', [self::class, 'add_settings_page']);
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_block_editor_assets']);
        add_action('admin_init', [self::class, 'register_settings']);
    }

    public static function add_settings_page() {
        add_options_page(
            __('Dashboard Widgetizer', 'widgetizer'),
            __('Dashboard Widgetizer', 'widgetizer'),
            Permissions::CAP_MANAGE_WIDGETIZER,
            'widgetizer-settings',
            [self::class, 'render_settings_page'], 
            20
        );
    }

    public static function register_settings() {
        register_setting('widgetizer_settings', 'widgetizer_dynamic_content', [
            'type' => 'string',
            'sanitize_callback' => 'wp_kses_post',
        ]);
    
        register_setting('widgetizer_settings', 'widgetizer_full_width_widgets', [
            'type' => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);
    
        register_setting('widgetizer_settings', 'widgetizer_disable_meta_boxes', [
            'type' => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
        ]);

        register_setting('widgetizer_settings', 'widgetizer_disable_postbox_header', [
            'type' => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
            'default' => true,
        ]);        
    }
    
    public static function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('Dashboard Widgetizer', 'widgetizer'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('widgetizer_settings');
                do_settings_sections('widgetizer_settings');
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('Full Width Dashboard Widgets', 'widgetizer'); ?></th>
                        <td>
                            <input type="checkbox" name="widgetizer_full_width_widgets" value="1" <?php checked(get_option('widgetizer_full_width_widgets', false)); ?> />
                            <label for="widgetizer_full_width_widgets"><?php _e('Enable full-width dashboard widgets', 'widgetizer'); ?></label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Disable Default Meta Boxes', 'widgetizer'); ?></th>
                        <td>
                            <input type="checkbox" name="widgetizer_disable_meta_boxes" value="1" <?php checked(get_option('widgetizer_disable_meta_boxes', false)); ?> />
                            <label for="widgetizer_disable_meta_boxes"><?php _e('Disable default WordPress dashboard widgets (e.g., News, Activity)', 'widgetizer'); ?></label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Disable Postbox Headers', 'widgetizer'); ?></th>
                        <td>
                            <input type="checkbox" name="widgetizer_disable_postbox_header" value="1" <?php checked(get_option('widgetizer_disable_postbox_header', false)); ?> />
                            <label for="widgetizer_disable_postbox_header"><?php _e('Disable postbox headers on the dashboard', 'widgetizer'); ?></label>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public static function enqueue_block_editor_assets($hook) {
        if ($hook !== 'settings_page_widgetizer-settings') {
            return;
        }

        wp_enqueue_script(
            'widgetizer-editor',
            plugin_dir_url(__FILE__) . '../assets/editor.js',
            ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-i18n'],
            '1.0.0',
            true
        );

        wp_enqueue_style('wp-edit-blocks');
    }
}
