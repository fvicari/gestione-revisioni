<div class="wrap">
    <h1><?php esc_html_e('Gestione revisioni', 'gestione-revisioni'); ?></h1>
    <form method="get" style="margin-bottom: 20px;">
        <input type="hidden" name="page" value="gestione-revisioni">
        <input type="text" name="s" value="<?php echo esc_attr($search_query) ?>" placeholder="<?php esc_attr_e('Cerca per titolo o ID', 'gestione-revisioni') ?>">
        <input type="submit" class="button" value="<?php esc_attr_e('Cerca', 'gestione-revisioni'); ?>">
    </form>

    <?php if (!empty($post_ids_with_revisions)) : ?>
        <form method="post">
            <?php wp_nonce_field('gr_bulk_action_verify'); ?>
            <div class="wp-list-table widefat fixed striped table-view-list posts revision-list">
                <div class="revision-container">
                    <div class="revision-row header">
                        <div class="revision-cell check-column"><input type="checkbox" id="gr_select_all"></div>
                        <div class="revision-cell"><?php esc_html_e('Titolo', 'gestione-revisioni'); ?></div>
                        <div class="revision-cell"><?php esc_html_e('Revisioni', 'gestione-revisioni'); ?></div>
                        <div class="revision-cell"><?php esc_html_e('Dettaglio', 'gestione-revisioni'); ?></div>
                        <div class="revision-cell ultima-revisione visualizza-mobile"><?php esc_html_e('Ultima Revisione', 'gestione-revisioni'); ?></div>
                        <div class="revision-cell actions"><?php esc_html_e('Azioni', 'gestione-revisioni'); ?></div>
                    </div>

                    <?php
                    $row_count = 0;
                    $found_revisions = false;
                    foreach ($post_ids_with_revisions as $post_id) :
                        $post = get_post($post_id);
                        $revisions = wp_get_post_revisions($post_id);
                        $revision_count = count($revisions);
                        if ($revision_count > 0) :
                            $found_revisions = true;
                            $last_revision = reset($revisions);
                            $last_revision_date = $last_revision->post_date;
                            $row_class = $row_count % 2 == 0 ? 'alternate' : '';
                            $row_count++; ?>

                            <div class="revision-row <?php echo esc_attr($row_class); ?>">
                                <div class="revision-cell check-column"><input type="checkbox" name="post_ids[]" value="<?php echo esc_attr($post_id); ?>"></div>
                                <div class="revision-cell"><?php echo esc_html(get_the_title($post)); ?></div>
                                <div class="revision-cell"><?php echo esc_html($revision_count); ?></div>
                                <div class="revision-cell"><button type="button" class="button gr_toggle_revisions" data-post-id="<?php echo esc_attr($post_id); ?>"></button></div>
                                <div class="revision-cell ultima-revisione visualizza-mobile"><?php echo esc_html($last_revision_date); ?></div>
                                <div class="revision-cell actions">
                                    <a href="<?php echo esc_url(get_edit_post_link($post_id)); ?>" class="button button-visualizza"><?php esc_html_e('Modifica', 'gestione-revisioni'); ?></a>
                                    <a href="<?php echo esc_url(get_edit_post_link($post_id)); ?>" class="button button-visualizza-mobile"></a>
                                </div>
                            </div>

                            <div class="revision-detail" id="gr_revisions_<?php esc_attr_e($post_id); ?>">
                                <?php foreach ($revisions as $revision) :
                                    $revision_date = gmdate('Y-m-d', strtotime($revision->post_date));
                                    $revision_time = gmdate('H:i:s', strtotime($revision->post_date));
                                    $revision_author = get_the_author_meta('display_name', $revision->post_author); ?>

                                    <div class="revision-detail-row">
                                        <div class="revision-cell"><?php esc_html_e('Post ID', 'gestione-revisioni'); ?>: <?php echo esc_html($post_id); ?></div>
                                        <div class="revision-cell"><?php esc_html_e('Data Revisione', 'gestione-revisioni'); ?>: <?php echo esc_html($revision_date); ?></div>
                                        <div class="revision-cell"><?php esc_html_e('Ora Revisione', 'gestione-revisioni'); ?>: <?php echo esc_html($revision_time); ?></div>
                                        <div class="revision-cell"><?php esc_html_e('Autore Revisione', 'gestione-revisioni'); ?>: <?php echo esc_html($revision_author); ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if (!$found_revisions) : ?>
                <p><?php esc_html_e('Nessuna revisione presente.', 'gestione-revisioni'); ?></p>
            <?php elseif (current_user_can('edit_others_posts')) : ?>
                <div class="tablenav bottom">
                    <div class="alignleft actions bulkactions">
                        <select name="gr_bulk_action">
                            <option value=""><?php esc_html_e('Azioni di gruppo', 'gestione-revisioni'); ?></option>
                            <option value="delete_all"><?php esc_html_e('Elimina tutte le revisioni', 'gestione-revisioni'); ?></option>
                            <option value="delete_all_except_last"><?php esc_html_e('Elimina tutte tranne l\'ultima revisione', 'gestione-revisioni'); ?></option>
                        </select>
                        <input type="submit" class="button action" value="<?php esc_attr_e('Applica', 'gestione-revisioni'); ?>">
                    </div>
                </div>
            <?php endif; ?>
        </form>


        <?php if ($total_posts_with_revisions > $posts_per_page) {
            // Paginazione
            gr_generate_pagination($total_pages, $paged);
        }

        wp_reset_postdata(); ?>
    <?php else : ?>
        <p><?php esc_html_e('Nessun post trovato con revisioni.', 'gestione-revisioni'); ?></p>
    <?php endif; ?>

    <!-- Credits e versione del plugin -->
    <div class="gr-credits">
        <p>
            <strong>V <?php echo esc_html(GR_VERSION); ?></strong> Credits: JGV -
            <a href="https://www.magazzinovirtuale.com" target="_blank">
                <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'img/mv.png'); ?>" alt="Magazzino Virtuale" />
                Magazzino Virtuale
            </a>
        </p>
    </div>
    <div class="supporta">
        <h3>Supporta lo sviluppo Fai una donazione via PayPal</h3>
        <form action="https://www.paypal.com/donate" method="post" target="_top">
            <input type="hidden" name="hosted_button_id" value="76MAU39GPQE2Q" />
            <input type="image" src="https://pics.paypal.com/00/s/Y2JjNWMzYWMtMGFjNC00ZThkLWE3N2UtNDZjMDk1OWRkYzU4/file.PNG" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
            <img alt="" border="0" src="https://www.paypal.com/en_IT/i/scr/pixel.gif" width="1" height="1" />
        </form>
    </div>
</div>