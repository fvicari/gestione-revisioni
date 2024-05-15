<div class="wrap">
    <h1><?php esc_html_e('Impostazioni Gestione Revisioni', 'gestione-revisioni'); ?></h1>
    <form method="post" action="">
        <?php wp_nonce_field('gr_save_settings_verify'); ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="gr_posts_per_page"><?php esc_html_e('Post per pagina', 'gestione-revisioni'); ?></label>
                </th>
                <td>
                    <input name="gr_posts_per_page" type="number" id="gr_posts_per_page" value="<?= esc_attr($posts_per_page); ?>" class="small-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="gr_max_revisions"><?php esc_html_e('Numero massimo di revisioni', 'gestione-revisioni'); ?></label>
                </th>
                <td>
                    <input name="gr_max_revisions" type="number" id="gr_max_revisions" value="<?= esc_attr($max_revisions); ?>" class="small-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="gr_permissions"><?php esc_html_e('Permessi di accesso', 'gestione-revisioni'); ?></label>
                </th>
                <td>
                    <select name="gr_permissions[]" id="gr_permissions" multiple>
                        <?php foreach ($roles as $role_name => $role_info) :
                            $selected = in_array($role_name, $permissions); ?>

                            <option value="<?= esc_attr($role_name) ?>" <?php selected($selected); ?>>
                                <?= esc_html($role_info['name']) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <p class="description">
                        <?php esc_html_e('Tieni premuto il tasto CTRL (Windows) o CMD (Mac) per selezionare più ruoli.', 'gestione-revisioni'); ?>
                    </p>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="gr_save_settings" id="submit" class="button button-primary" value="<?php esc_attr_e('Salva Impostazioni', 'gestione-revisioni'); ?>">
        </p>
    </form>
</div>