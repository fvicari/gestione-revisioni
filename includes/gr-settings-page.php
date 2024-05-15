<?php
function gr_settings_page_content() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['gr_save_settings']) && check_admin_referer('gr_save_settings_verify')) {
        $posts_per_page = absint($_POST['gr_posts_per_page']);
        $max_revisions = absint($_POST['gr_max_revisions']);
        $permissions = array_map('sanitize_text_field', $_POST['gr_permissions']);

        update_option('gr_posts_per_page', $posts_per_page);
        update_option('gr_max_revisions', $max_revisions);
        update_option('gr_permissions', $permissions);

        echo '<div class="updated"><p>' . esc_html__('Impostazioni salvate.', 'gestione-revisioni') . '</p></div>';
    }

    $posts_per_page = get_option('gr_posts_per_page', 50);
    $max_revisions = get_option('gr_max_revisions', 10);
    $permissions = get_option('gr_permissions', array('administrator', 'editor'));
    $roles = get_editable_roles();

    include plugin_dir_path(__FILE__) . 'templates/settings-template.php';
}
?>
