<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('widgetizer_dynamic_content');
delete_transient('widgetizer_dynamic_content_cache');
