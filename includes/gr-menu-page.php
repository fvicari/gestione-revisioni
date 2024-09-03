<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
function gestrev_menu_page_content() {
    $permissions = get_option('gestrev_permissions', array('administrator', 'editor'));

    if (!array_intersect($permissions, wp_get_current_user()->roles)) {
        return;
    }

    // Verify and delete revisions
    if (isset($_POST['gestrev_bulk_action']) && isset($_POST['post_ids']) && check_admin_referer('gestrev_bulk_action_verify')) {
        $action = sanitize_text_field($_POST['gestrev_bulk_action']);
        $post_ids = array_map('absint', $_POST['post_ids']);

        foreach ($post_ids as $post_id) {
            $revisions = wp_get_post_revisions($post_id);
            switch ($action) {
                case 'delete_all_except_last':
                    $first_revision = array_shift($revisions);
                    if ($first_revision) {
                        wp_restore_post_revision($first_revision->ID);
                    }
                case 'delete_all':
                    foreach ($revisions as $revision) {
                        wp_delete_post($revision->ID, true);
                    }
                    break;
            }
        }

        echo '<div class="updated"><p>' . esc_html__('Revisioni gestite con successo.', 'gestione-revisioni') . '</p></div>';
    }

    // Search filter
    $search_query = sanitize_text_field($_GET['s'] ?? '');

    // Get all public post types
    $post_types = get_post_types(['public' => true]);

    // Build a list of placeholders
    $placeholders = implode(',', array_fill(0, count($post_types), '%s'));

    // Get posts and their revisions
    $posts_per_page = get_option('gestrev_posts_per_page', 50);

    $paged = absint($_GET['paged'] ?? 1);
    $offset = ($paged - 1) * $posts_per_page;

    // Build the SQL query to filter posts based on the search
    global $wpdb;
    $search_filter = '';
    if (!empty($search_query)) {
        $search_query_like = '%' . $wpdb->esc_like($search_query) . '%';
        $search_filter = $wpdb->prepare("AND (post_title LIKE %s OR ID = %d)", array($search_query_like, $search_query));
    }

    // Get posts with revisions
    $post_ids_with_revisions = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT DISTINCT post_parent 
            FROM $wpdb->posts 
            WHERE post_type = 'revision' 
            AND post_parent IN (
                SELECT ID FROM $wpdb->posts 
                WHERE post_type IN ($placeholders) 
                AND post_status = 'publish'
                $search_filter
            ) 
            LIMIT %d OFFSET %d",
            array_merge($post_types, array($posts_per_page, $offset))
        )
    );

    $total_posts_with_revisions = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(DISTINCT post_parent) 
            FROM $wpdb->posts 
            WHERE post_type = 'revision' 
            AND post_parent IN (
                SELECT ID FROM $wpdb->posts 
                WHERE post_type IN ($placeholders) 
                AND post_status = 'publish'
                $search_filter
            )",
            $post_types
        )
    );

    $total_pages = ceil($total_posts_with_revisions / $posts_per_page);

    include plugin_dir_path(__FILE__) . 'templates/menu-template.php';
}
