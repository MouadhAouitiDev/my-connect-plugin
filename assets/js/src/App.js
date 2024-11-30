/* Composant principal de l'application React*/

/* Composant principal de l'application React */

import React, { useState, useEffect } from "react";
import axios from "axios";
import {
  sendConnectionRequest,
  rejectConnectionRequest,
  acceptConnectionRequest,
} from "./api";
import ConnectionRequest from "./components/ConnectionRequest";
import ConnectionList from "./components/ConnectionList";
import Friends from "./components/Friends";

const App = () => {
  const [users, setUsers] = useState([]);
  const [pendingRequests, setPendingRequests] = useState([]);
  const [friends, setFriends] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [successMessage, setSuccessMessage] = useState(null);
  const [currentUserId] = useState(1);

  // Fetch all data on component mount
  useEffect(() => {
    const fetchData = async () => {
      setLoading(true);
      try {
        const [usersResponse, requestsResponse, friendsResponse] =
          await Promise.all([
            fetchUsers(),
            fetchPendingRequests(),
            fetchFriends(),
          ]);

        setUsers(usersResponse);
        setPendingRequests(requestsResponse);
        setFriends(friendsResponse);
      } catch (err) {
        console.error("Erreur lors du chargement des données :", err);
        setError("Une erreur est survenue lors du chargement des données.");
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, []);

  // Fetch users
  const fetchUsers = async () => {
    try {
      const response = await axios.get("/wp-json/my-connect/v1/users/");
      return response.data;
    } catch (err) {
      console.error("Erreur lors du chargement des utilisateurs :", err.message);
      throw new Error("Erreur lors du chargement des utilisateurs.");
    }
  };

  // Fetch pending requests
  const fetchPendingRequests = async () => {
    try {
      const response = await axios.get("/wp-json/my-connect/v1/requests/");
      console.log("PendingRequests from API:", response.data);
      return response.data;
    } catch (err) {
      console.error("Erreur lors du chargement des demandes :", err.message);
      throw new Error("Erreur lors du chargement des demandes.");
    }
  };

  // Fetch friends
  const fetchFriends = async () => {
    try {
      const response = await axios.get("/wp-json/my-connect/v1/friends/");
      return response.data;
    } catch (err) {
      console.error("Erreur lors du chargement des amis :", err.message);
      throw new Error("Erreur lors du chargement des amis.");
    }
  };

  // Handle actions
  const handleSendRequest = async (targetUserId) => {
    if (targetUserId === currentUserId) {
      alert("Vous ne pouvez pas envoyer de demande à vous-même.");
      return;
    }

    setLoading(true);
    try {
      await sendConnectionRequest(targetUserId);
      alert("Demande envoyée");
      setSuccessMessage("Demande envoyée avec succès.");
    } catch (err) {
      setError("Erreur lors de l'envoi de la demande.");
    } finally {
      setLoading(false);
    }
  };

  const handleRejectRequest = (connectionId) => {
    rejectConnectionRequest(connectionId)
      .then(() => {
        alert("Demande rejetée");
        setPendingRequests((prev) =>
          prev.filter((request) => request.id !== connectionId)
        );
      })
      .catch(() => setError("Erreur lors du rejet de la demande."));
  };

  const handleAcceptRequest = (connectionId) => {
    acceptConnectionRequest(connectionId)
      .then(() => {
        alert("Demande acceptée");
        setPendingRequests((prev) =>
          prev.filter((request) => request.id !== connectionId)
        );
      })
      .catch(() => setError("Erreur lors de l'acceptation de la demande."));
  };

  // Render loading state
  if (loading) {
    return <div>Chargement en cours...</div>;
  }

  return (
    <div>
      <h1>Bienvenue</h1>
      {error && <div className="error-message">{error}</div>}
      {successMessage && <div className="success-message">{successMessage}</div>}

      <Friends friends={friends} userId={currentUserId} />

      <h2>Liste des utilisateurs</h2>
      <ConnectionList
        users={users}
        onSendRequest={handleSendRequest}
        currentUserId={currentUserId}
      />

      <h2>Demandes en attente</h2>
      {pendingRequests.length === 0 ? (
        <p>Aucune demande en attente</p>
      ) : (
        pendingRequests.map((request) => (
          <ConnectionRequest
            key={request.id}
            invitation={request}
            onInvitationAccepted={handleAcceptRequest}
            onInvitationRejected={handleRejectRequest}
          />
        ))
      )}
    </div>
  );
};

export default App;
