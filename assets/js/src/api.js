/* Fichier pour gérer les appels à l'API REST (send, accept, reject)*/

import axios from 'axios';

const API_URL = '/wp-json/my-connect/v1';

// Envoi de la demande de connexion
export const sendConnectionRequest = (userId) => {
    return axios.post(`${API_URL}/send`, { user_id_2: userId });
};

// Accepter la demande de connexion
export const acceptConnectionRequest = (connectionId) => {
    return axios.post(`${API_URL}/accept`, { connection_id: connectionId });
};

// Rejeter la demande de connexion
export const rejectConnectionRequest = (connectionId) => {
    return axios.post(`${API_URL}/reject`, { connection_id: connectionId });
};

// Récupérer les demandes en attente
export const getPendingRequests = () => {
    return axios.get(`${API_URL}/requests`)
        .then(response => response.data)
        .catch(error => {
            console.error("Erreur lors de la récupération des demandes en attente :", error);
            throw error;
        });
};
