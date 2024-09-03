<?php
/**
 * Plugin Name: Gestione revisioni
 * Description: Verifica il numero di revisioni dei post e permette di gestirle ed eliminarle.
 * Version: 1.9
 * Author: Francesco Vicari
 * Author URI: https://www.magazzinovirtuale.com
 * Text Domain: gestione-revisioni
 * Domain Path: /languages
 */

 define('GR_VERSION', '1.9');

 // Evita l'accesso diretto al file
 if (!defined('ABSPATH')) {
     exit;
 }
 
 // Includi i file delle pagine e la paginazione
 include plugin_dir_path(__FILE__) . 'includes/gr-settings-page.php';
 include plugin_dir_path(__FILE__) . 'includes/gr-menu-page.php';
 include plugin_dir_path(__FILE__) . 'includes/gr-pagination.php';
 
 // Aggiungi il menu per la gestione delle revisioni
 add_action('admin_menu', 'gr_add_menu_page');
 add_action('admin_menu', 'gr_add_settings_page');
 
 // Includi il file CSS e JS
 add_action('admin_enqueue_scripts', 'gr_enqueue_styles');
 
 // Carica i file di traduzione
 add_action('plugins_loaded', 'gr_load_textdomain');
 
 // Aggiungi le opzioni di default all'attivazione del plugin
 register_activation_hook(__FILE__, 'gr_add_default_settings');
 function gr_add_default_settings() {
     add_option('gr_posts_per_page', 50);
     add_option('gr_max_revisions', 10);
     add_option('gr_permissions', array('administrator', 'editor'));
 }
 
 function gr_enqueue_styles($hook) {
     if ($hook != 'toplevel_page_gestione-revisioni' && $hook != 'gestione-revisioni_page_gestione-revisioni-settings') {
         return;
     }
     wp_enqueue_style('gestione-revisioni', plugin_dir_url(__FILE__) . 'css/gestione-revisioni.css');
     wp_enqueue_script('gestione-revisioni', plugin_dir_url(__FILE__) . 'js/gestione-revisioni.js', array(), '1.0', true);
 }
 
 function gr_load_textdomain() {
     load_plugin_textdomain('gestione-revisioni', false, dirname(plugin_basename(__FILE__)) . '/languages');
 }
 
 function gr_add_menu_page() {
     add_menu_page(
         __('Gestione revisioni', 'gestione-revisioni'),    // Title of the page
         __('Gestione revisioni', 'gestione-revisioni'),    // Text to show on the menu link
         'read',                  // Capability required to view
         'gestione-revisioni',    // The slug of the page
         'gr_menu_page_content'  // The function to call to display the content
     );
 }
 
 function gr_add_settings_page() {
     add_submenu_page(
         'gestione-revisioni',
         __('Impostazioni Gestione Revisioni', 'gestione-revisioni'),
         __('Impostazioni', 'gestione-revisioni'),
         'manage_options',
         'gestione-revisioni-settings',
         'gr_settings_page_content'
     );
 }
 
 // Limita il numero massimo di revisioni
 add_filter('wp_revisions_to_keep', 'gr_limit_revisions', 10, 2);
 function gr_limit_revisions($num, $post) {
     $max_revisions = get_option('gr_max_revisions', 10);
     return $max_revisions;
 }