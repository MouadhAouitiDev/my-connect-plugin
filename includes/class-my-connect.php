<?php 
/*Classe principale du plugin, gestion des fonctionnalités backend (API REST)*/


class My_Connect {
    public function __construct() {
        add_action('rest_api_init', [$this, 'register_api_endpoints']);
    }

    public function register_api_endpoints() {
        register_rest_route('my-connect/v1', '/send/', [
            'methods' => 'POST',
            'callback' => [$this, 'send_connection_request'],
          
        ]);
        register_rest_route('my-connect/v1', '/accept/', [
            'methods' => 'POST',
            'callback' => [$this, 'accept_connection_request'],
           
        ]);
        register_rest_route('my-connect/v1', '/reject/', [
            'methods' => 'POST',
            'callback' => [$this, 'reject_connection_request'],
           
        ]);
        register_rest_route('my-connect/v1', '/requests/', [
            'methods' => 'GET',
            'callback' => [$this, 'get_connection_requests'],

            
        ]);
       
        register_rest_route('my-connect/v1', '/users/', [
            'methods' => 'GET',
            'callback' => [$this, 'my_connect_get_users'],
          
        ]);
        register_rest_route('my-connect/v1', '/friends/', [
            'methods' => 'GET',
            'callback' => [$this, 'get_friends'],
        ]);

     
        
    }

    // Vérification des permissions avant d'accepter ou rejeter une demande
    public function check_user_permission() {
        return is_user_logged_in(); // Assure que l'utilisateur est connecté
    }

    // Fonction pour envoyer une demande de connexion
    public function send_connection_request(WP_REST_Request $request) {
        global $wpdb;
    
        // Récupérer les identifiants des utilisateurs
        $user_id_1 = get_current_user_id();
        $user_id_2 = $request->get_param('user_id_2');
    
        // Vérifier si l'utilisateur tente de s'envoyer une invitation
        if ($user_id_1 == $user_id_2) {
            return new WP_REST_Response('Vous ne pouvez pas vous envoyer une invitation.', 400);
        }
    
        // Vérifier si user_id_2 est valide
        if (!$user_id_2 || !is_numeric($user_id_2)) {
            return new WP_REST_Response('ID utilisateur 2 invalide.', 400);
        }
    
        $table_name = $wpdb->prefix . 'connections';
    
        // Préparer les données à insérer
        $data = [
            'user_id_1' => $user_id_1,
            'user_id_2' => $user_id_2,
            'status' => 'pending', // Le statut de l'invitation est "pending"
            'created_at' => current_time('mysql'),  // Ajouter un timestamp de création
            'updated_at' => current_time('mysql')   // Ajouter un timestamp de mise à jour
        ];
    
        // Insérer une nouvelle demande de connexion
        $inserted = $wpdb->insert($table_name, $data);
    
        // Debugging - check if insert was successful
        if (!$inserted) {
            // Loguer l'erreur pour aider au débogage
            error_log('Error inserting: ' . $wpdb->last_error);
            return new WP_REST_Response('Erreur lors de l\'envoi de la demande.', 500);
        }
    
        // Retourner une réponse de succès
        return new WP_REST_Response('Demande envoyée avec succès.', 200);
    }
    
    
    

    // Fonction pour accepter une demande de connexion
    public function accept_connection_request(WP_REST_Request $request) {
        global $wpdb;

        $connection_id = $request->get_param('connection_id');
        
        $table_name = $wpdb->prefix . 'connections';
        
        // Vérifier si la connexion existe
        $connection = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d AND status = 'pending'", $connection_id
        ));

        if (!$connection) {
            return new WP_REST_Response('Demande de connexion invalide ou déjà traitée.', 400);
        }

        // Mettre à jour le statut de la connexion à 'accepted'
        $wpdb->update($table_name, ['status' => 'accepted'], ['id' => $connection_id]);

        return new WP_REST_Response('Demande acceptée', 200);
    }

    // Fonction pour rejeter une demande de connexion
    public function reject_connection_request(WP_REST_Request $request) {
        global $wpdb;

        $connection_id = $request->get_param('connection_id');
        
        $table_name = $wpdb->prefix . 'connections';
        
        // Vérifier si la connexion existe
        $connection = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d AND status = 'pending'", $connection_id
        ));

        if (!$connection) {
            return new WP_REST_Response('Demande de connexion invalide ou déjà traitée.', 400);
        }

        // Mettre à jour le statut de la connexion à 'rejected'
        $wpdb->update($table_name, ['status' => 'rejected'], ['id' => $connection_id]);

        return new WP_REST_Response('Demande rejetée', 200);
    }

    // Fonction pour récupérer les demandes de connexion en attente
    // Function to retrieve pending connection requests
    public function get_connection_requests(WP_REST_Request $request) {

        $user_id = get_current_user_id();
    
       
    
        // Retrieve pending requests as before
        global $wpdb;
        $table_name = $wpdb->prefix . 'connections';
        $pending_requests = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM $table_name WHERE (user_id_1 = %d OR user_id_2 = %d) AND status = 'pending'",
                $user_id,
                $user_id
            )
        );
    
        return new WP_REST_Response($pending_requests, 200);
    }


    
    // Callback function to return all users
function my_connect_get_users() {
    // Fetch all users (adjust parameters as needed)
    $users = get_users(array(
        'fields' => array('ID', 'user_login', 'user_email', 'user_avatar'), // Select only needed fields
    ));

    // Prepare and return response
    $user_data = array();
    foreach ($users as $user) {
        $user_data[] = array(
            'id' => $user->ID,
            'name' => $user->user_login,
            'email' => $user->user_email,
            'photo' => get_avatar_url($user->ID), // Gravatar URL or custom photo
        );
    }

    return $user_data;
}
// Fonction pour récupérer les amis d'un utilisateur
public function get_friends(WP_REST_Request $request) {
    $user_id = get_current_user_id();
    global $wpdb;
    $table_name = $wpdb->prefix . 'connections';

    // Récupérer les amis de l'utilisateur (tous les utilisateurs qui ont accepté une demande)
    $friends = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT user_id_1, user_id_2 FROM $table_name WHERE (user_id_1 = %d OR user_id_2 = %d) AND status = 'accepted'",
            $user_id, $user_id
        )
    );

    // Retourner une réponse avec la liste des amis
    $friend_ids = [];
    foreach ($friends as $friend) {
        // Ajouter l'ID des amis dans le tableau
        $friend_ids[] = ($friend->user_id_1 == $user_id) ? $friend->user_id_2 : $friend->user_id_1;
    }

    // Récupérer les informations des utilisateurs amis
    $friend_data = [];
    foreach ($friend_ids as $friend_id) {
        $user = get_user_by('id', $friend_id);
        if ($user) {
            $friend_data[] = [
                'id' => $user->ID,
                'name' => $user->user_login,
                'email' => $user->user_email,
                'photo' => get_avatar_url($user->ID),
            ];
        }
    }

    return new WP_REST_Response($friend_data, 200);
}

}

new My_Connect();
