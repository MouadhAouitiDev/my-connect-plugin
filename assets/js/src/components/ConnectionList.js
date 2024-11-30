/* Composant pour afficher la liste des connexions */
import React from 'react';
import UserCard from './UserCard';

const ConnectionList = ({ users, onSendRequest, currentUserId }) => {
    // If no users are found, display a message
    if (users.length === 0) {
        return <p>Aucun utilisateur trouvé</p>;
    }

    return (
        <div className="user-list">
            {users.map((user) => {
                // If the user is the current user, skip rendering the card
                if (user.id === currentUserId) {
                    return null; // Skip rendering the card for the current user
                }

                return (
                    <UserCard 
                        key={user.id} 
                        user={user} 
                        onSendRequest={onSendRequest} 
                    />
                );
            })}
        </div>
    );
};

export default ConnectionList;
