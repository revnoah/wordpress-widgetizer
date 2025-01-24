<?php

namespace Widgetizer;

class Style_Handler {
    public static function init() {
        // Hook to output CSS dynamically
        add_action('admin_head', [self::class, 'output_dashboard_styles']);
        add_action('admin_head', [self::class, 'disable_postbox_header']);
    }

    /**
     * Outputs custom CSS for the dashboard.
     */
    public static function output_dashboard_styles() {
        // Check if the "Full Width Dashboard Widgets" option is enabled
        if (!get_option('widgetizer_full_width_widgets', false)) {
            return;
        }

        // Ensure we are on the admin dashboard page
        $screen = get_current_screen();
        if ($screen && $screen->id === 'dashboard') {
            echo '<style>
                #dashboard-widgets-wrap {
                    width: 100%;
                }
                #dashboard-widgets .postbox-container {
                    width: 100% !important;
                    margin: 0 auto;
                }
                #dashboard-widgets .postbox-container:not(:first-child) {
                    display: none !important;
                }
            </style>';
        }
    }

    public static function disable_postbox_header() {
        if (!get_option('widgetizer_disable_postbox_header', true)) {
            return;
        }

        $screen = get_current_screen();
        if ($screen && $screen->id === 'dashboard') {
            echo '<style>
                h1 {
                    display: none;
                }
                #dashboard-widgets .postbox-header {
                    display: none !important;
                }
            </style>';
        }
    }
}
