# Documentation du plugin : **My Connect**

Plugin pour gérer les connexions entre utilisateurs dans WordPress.

## Installation

1. Téléchargez le plugin dans le répertoire des plugins de votre site WordPress (`/wp-content/plugins/`).
2. Activez le plugin depuis l'interface d'administration de WordPress.
3. Utilisez le shortcode `[my_connect]` dans une page ou un article WordPress pour afficher l'interface des connexions.

## Fonctionnalités

- **Envoi de demandes de connexion** : Les utilisateurs peuvent envoyer des demandes de connexion à d'autres utilisateurs.
- **Gestion des demandes de connexion** : Les utilisateurs peuvent accepter ou rejeter les demandes reçues.
- **Visualisation des connexions acceptées** : Affichez vos connexions actives dans une interface claire et intuitive.

## Utilisation

### Utilisation du shortcode

Pour afficher l'interface utilisateur du plugin sur une page WordPress :

1. Accédez à l'interface d'administration de WordPress.
2. Créez ou modifiez une page ou un article.
3. Ajoutez le shortcode suivant dans le contenu de la page :

   ```plaintext
   [my_connect]


### Explications des sections  techniques :

1. **Frontend (React)** : 
   - **Installer les dépendances** : Exécute `npm install` pour installer toutes les dépendances JavaScript nécessaires.
   - **Exécuter en mode développement** : Utilisez `npm start` pour démarrer le serveur React en mode développement.
   - **Construire pour la production** : Utilisez `npm run build` pour créer une version optimisée du frontend dans le dossier `build`.

2. **Backend (PHP)** : 
   - **Installer les dépendances PHP** : Exécute `composer install` pour installer les dépendances backend via Composer.
   - **Vérifier le dossier `vendor`** : Une fois l'installation terminée, le dossier `vendor` contient toutes les bibliothèques PHP nécessaires.
   - **Activation et vérification** : Le plugin doit être activé dans l'admin WordPress et les fonctionnalités vérifiées via le shortcode `[my_connect]`.

