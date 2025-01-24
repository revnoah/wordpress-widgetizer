<?php

namespace Widgetizer;

class Custom_Post_Type {
    public static function init() {
        add_action('init', [self::class, 'register_widget_post_type']);
        add_action('add_meta_boxes', [self::class, 'register_metabox']);
        add_action('save_post', [self::class, 'save_post_meta']);
    }
    
    public static function register_widget_post_type() {
        $labels = [
            'name'               => __('Dashboard Widgets', 'widgetizer'),
            'singular_name'      => __('Dashboard Widget', 'widgetizer'),
            'add_new'            => __('Add New Widget', 'widgetizer'),
            'add_new_item'       => __('Add New Widget', 'widgetizer'),
            'edit_item'          => __('Edit Widget', 'widgetizer'),
            'new_item'           => __('New Widget', 'widgetizer'),
            'view_item'          => __('View Widget', 'widgetizer'),
            'all_items'          => __('Widgets', 'widgetizer'),
            'search_items'       => __('Search Widgets', 'widgetizer'),
            'not_found'          => __('No widgets found', 'widgetizer'),
            'not_found_in_trash' => __('No widgets found in Trash', 'widgetizer'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'exclude_from_search'=> true,
            'show_in_rest'       => true,
            'show_in_menu'       => 'index.php',
            'capability_type'    => 'post',
            'capabilities'       => [
                'edit_posts'   => 'manage_widgetizer_widgets',
                'delete_posts' => 'manage_widgetizer_widgets',
                'edit_others_posts' => 'manage_widgetizer_widgets',
                'publish_posts' => 'manage_widgetizer_widgets',
                'read_private_posts' => 'manage_widgetizer_widgets',
            ],
            'map_meta_cap'       => true,
            'supports'           => ['title', 'editor'],
        ];

        register_post_type('widgetizer_widget', $args);
    }

    public static function register_metabox() {
        add_meta_box(
            'widgetizer_roles',
            __('Widget Visibility by Role', 'widgetizer'),
            [self::class, 'render_metabox'],
            'widgetizer_widget',
            'side',
            'default'
        );
    }
    
    public static function render_metabox($post) {
        global $wp_roles;
        $roles = $wp_roles->roles;
        $selected_roles = get_post_meta($post->ID, '_widgetizer_roles', true) ?: [];
    
        ?>
        <p><?php _e('Select the user roles that can view this dashboard widget, or select none/all for all roles.', 'widgetizer'); ?></p>
        <ul>
            <?php foreach ($roles as $role_key => $role) : ?>
                <li>
                    <label>
                        <input type="checkbox" name="widgetizer_roles[]" value="<?php echo esc_attr($role_key); ?>"
                            <?php checked(in_array($role_key, $selected_roles)); ?>>
                        <?php echo esc_html($role['name']); ?>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
    }

    public static function save_post_meta($post_id) {
        // Verify nonce and permissions
        if (!isset($_POST['widgetizer_roles'])) {
            return;
        }
    
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    
        // Save the selected roles
        $roles = array_map('sanitize_text_field', $_POST['widgetizer_roles']);
        update_post_meta($post_id, '_widgetizer_roles', $roles);
    }
    
}
