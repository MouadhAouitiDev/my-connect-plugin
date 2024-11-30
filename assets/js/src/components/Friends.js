/* Composant pour afficher la liste des amis */

import React from 'react';

const Friends = ({ friends, userId }) => {
    console.log("Friends data:", friends); // Log to see the data

    return (
        <div>
            <h2>Mes Amis</h2>
            {friends.length === 0 ? (
                <p>Aucun ami pour le moment</p>
            ) : (
                <div className="friends-list">
                    {friends.map((friend) => (
                        <div key={friend.id} className="friend-card">
                            <img
                                src={friend.photo || '/default-avatar.png'}
                                alt={friend.name}
                                className="friend-photo"
                            />
                            <p className="friend-name">{friend.name}</p>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
};

export default Friends;
