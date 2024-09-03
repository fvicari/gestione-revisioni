<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
function gestrev_generate_pagination($total_pages, $paged) {
    $pagination_args = array(
        'base' => add_query_arg('paged', '%#%'),
        'format' => '',
        'current' => max(1, $paged),
        'total' => $total_pages,
        'prev_text' => esc_html__('« Precedente', 'gestione-revisioni'), // Corretto: utilizza esc_html__() e virgola
        'next_text' => esc_html__('Successivo »', 'gestione-revisioni'),  // Corretto: utilizza esc_html__() e virgola
        'type' => 'array'
    );
    $pagination_links = paginate_links($pagination_args); ?>
    <?php if ($pagination_links) : ?>
        <div class="tablenav">
            <div class="tablenav-pages">
                <?php foreach ($pagination_links as $link) : ?>
                    <span class="pagination-links"><?php echo wp_kses_post($link) ?></span>
                <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>
<?php }
?>