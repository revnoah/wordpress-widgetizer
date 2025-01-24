<?php

namespace Widgetizer;

class Permissions {
    const CAP_MANAGE_WIDGETIZER = 'manage_widgetizer';

    public static function init() {
        add_action('init', [self::class, 'add_capabilities']);
        add_filter('user_has_cap', [self::class, 'filter_capabilities'], 10, 4);
    }

    /**
     * Add custom capabilities to admin roles.
     */
    public static function add_capabilities() {
        $roles = ['administrator'];

        foreach ($roles as $role_name) {
            $role = get_role($role_name);

            if ($role && !$role->has_cap(self::CAP_MANAGE_WIDGETIZER)) {
                $role->add_cap(self::CAP_MANAGE_WIDGETIZER);
            }
        }
    }

    /**
     * Filter to restrict access based on the custom capability.
     */
    public static function filter_capabilities($all_caps, $caps, $args, $user) {
        if (in_array(self::CAP_MANAGE_WIDGETIZER, $caps)) {
            $all_caps[self::CAP_MANAGE_WIDGETIZER] = user_can($user, 'manage_options');
        }

        return $all_caps;
    }

    /**
     * Check if the current user has the required permission.
     */
    public static function user_can_manage() {
        return current_user_can(self::CAP_MANAGE_WIDGETIZER);
    }
}
