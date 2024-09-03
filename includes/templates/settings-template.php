<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div class="wrap">
    <h1><?php esc_html_e('Impostazioni Gestione Revisioni', 'gestione-revisioni'); ?></h1>
    <form method="post" action="">
        <?php wp_nonce_field('gestrev_save_settings_verify'); ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="gestrev_posts_per_page"><?php esc_html_e('Post per pagina', 'gestione-revisioni'); ?></label>
                </th>
                <td>
                    <input name="gestrev_posts_per_page" type="number" id="gestrev_posts_per_page" value="<?php echo esc_attr($posts_per_page); ?>" class="small-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="gestrev_max_revisions"><?php esc_html_e('Numero massimo di revisioni', 'gestione-revisioni'); ?></label>
                </th>
                <td>
                    <input name="gestrev_max_revisions" type="number" id="gestrev_max_revisions" value="<?php echo esc_attr($max_revisions); ?>" class="small-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="gestrev_permissions"><?php esc_html_e('Permessi di accesso', 'gestione-revisioni'); ?></label>
                </th>
                <td>
                    <select name="gestrev_permissions[]" id="gestrev_permissions" multiple>
                        <?php foreach ($roles as $role_name => $role_info) :
                            $selected = in_array($role_name, $permissions); ?>

                            <option value="<?php echo esc_attr($role_name) ?>" <?php selected($selected); ?>>
                                <?php echo esc_html($role_info['name']) ?>
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
            <input type="submit" name="gestrev_save_settings" id="submit" class="button button-primary" value="<?php esc_attr_e('Salva Impostazioni', 'gestione-revisioni'); ?>">
        </p>
    </form>
</div>