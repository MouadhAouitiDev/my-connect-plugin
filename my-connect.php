<?php

/*
 * Plugin Name: My Connect
 * Description: Plugin pour gérer les connexions entre utilisateurs (fonction "Ajouter un ami").
 * Version: 1.0
 * Author: Votre Nom
 * Text Domain: my-connect
 */

 defined( 'ABSPATH' ) || exit;

 // Charger la classe principale
 require_once plugin_dir_path(__FILE__) . 'includes/class-my-connect.php';
 include_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';

 
 // Activer le plugin (création de la table)
 register_activation_hook(__FILE__, 'my_connect_activate');
 function my_connect_activate() {
     require_once plugin_dir_path(__FILE__) . 'includes/functions.php';
     create_my_connect_table(); // Crée la table wp_connections
 }
 
 function my_connect_enqueue_scripts() { 
    wp_enqueue_script(
    'my-connect-react',
    plugin_dir_url(__FILE__) . 'assets/js/src/build/main.js',
    array('wp-api-fetch'), 
    null,
    true
);
wp_enqueue_style(
    'my-connect-react-styles',
    plugin_dir_url(__FILE__) . 'assets/js/src/build/main.css'
);
    wp_localize_script('my-connect-react', 'wpApiConfig', array(
        'root'   => esc_url_raw(rest_url()), 
        'nonce'  => wp_create_nonce('wp_rest'), 
        'userId' => get_current_user_id() 
    ));
 }
 add_action('wp_enqueue_scripts', 'my_connect_enqueue_scripts');
 