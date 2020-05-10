<?php

if (modern_is_fineuploader()) {
    if (!OC_ADMIN) {
        osc_enqueue_style('fine-uploader-css', osc_assets_url('js/fineuploader/fineuploader.css'));
    }
    osc_enqueue_script('jquery-fineuploader');
}

function modern_is_fineuploader() {
    return Scripts::newInstance()->registered['jquery-fineuploader'] && method_exists('ItemForm', 'ajax_photos');
} 
if (function_exists('osc_admin_menu_appearance')) {
    osc_admin_menu_appearance(__('Header logo', 'modern'), osc_admin_render_theme_url('oc-content/themes/modern/admin/header.php'), 'header_modern');
    osc_admin_menu_appearance(__('Theme settings', 'modern'), osc_admin_render_theme_url('oc-content/themes/modern/admin/settings.php'), 'settings_modern');
} else {

    function modern_admin_menu() {
        echo '<h3><a href="#">' . __('Brasil theme', 'modern') . '</a></h3>
            <ul>
                <li><a href="' . osc_admin_render_theme_url('oc-content/themes/modern/admin/header.php') . '">&raquo; ' . __('Header logo', 'modern') . '</a></li>
                <li><a href="' . osc_admin_render_theme_url('oc-content/themes/modern/admin/settings.php') . '">&raquo; ' . __('Theme settings', 'modern') . '</a></li>

            </ul>';
    }

    osc_add_hook('admin_menu', 'modern_admin_menu');
}

?>