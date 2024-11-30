<?php 
# Fonctions PHP supplémentaires (création de la table, gestion de l'activation)

// Fonction pour créer la table des connexions

function create_my_connect_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'connections';

    // Définir le charset et le collate
    $charset_collate = $wpdb->get_charset_collate();

    // SQL pour créer ou mettre à jour la table
    $sql = "CREATE TABLE $table_name (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id_1 BIGINT(20) UNSIGNED NOT NULL,
        user_id_2 BIGINT(20) UNSIGNED NOT NULL,
        status ENUM('pending', 'accepted', 'rejected') NOT NULL DEFAULT 'pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY unique_connection (user_id_1, user_id_2),
        KEY user_id_1 (user_id_1),
        KEY user_id_2 (user_id_2)
    ) $charset_collate;";
    

    // Inclure les fichiers nécessaires pour dbDelta
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql); // Crée ou met à jour la table
}
