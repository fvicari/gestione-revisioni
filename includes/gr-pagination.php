<?php
function gr_generate_pagination($total_pages, $paged) {
    $pagination_args = array(
        'base' => add_query_arg('paged', '%#%'),
        'format' => '',
        'current' => max(1, $paged),
        'total' => $total_pages,
        'prev_text' => esc_html__('« Precedente'),
        'next_text' => esc_html__('Successivo »'),
        'type' => 'array'
    );

    $pagination_links = paginate_links($pagination_args);

    if ($pagination_links) {
        echo '<div class="tablenav"><div class="tablenav-pages">';
        foreach ($pagination_links as $link) {
            echo '<span class="pagination-links">' . wp_kses_post($link) . '</span>';
        }
        echo '</div></div>';
    }
}
?>