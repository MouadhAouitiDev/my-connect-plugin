/*Composant affichant une carte d'utilisateur (photo, nom, etc.)*/
import React from 'react';

const UserCard = ({ user, onSendRequest }) => {
    return (
        <div className="user-card">
            {/* Conditionally render loading icon or user info */}
            {user.isLoading ? (
                <div className="loading-icon">
                    {/* Custom SVG Spinner */}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 50 50"
                        width="50px"
                        height="50px"
                    >
                        <circle
                            cx="25"
                            cy="25"
                            r="20"
                            stroke="#f3f3f3"
                            strokeWidth="5"
                            fill="none"
                        />
                        <circle
                            cx="25"
                            cy="25"
                            r="20"
                            stroke="#3498db"
                            strokeWidth="5"
                            strokeLinecap="round"
                            fill="none"
                            strokeDasharray="126.92"
                            strokeDashoffset="126.92"
                        >
                            <animate
                                attributeName="stroke-dashoffset"
                                values="126.92;0"
                                dur="1.5s"
                                keyTimes="0;1"
                                repeatCount="indefinite"
                            />
                        </circle>
                    </svg>
                </div>
            ) : (
                <>
                    <img src={user.photo} alt={user.name} />
                    <h2>{user.name}</h2>
                    <button onClick={() => onSendRequest(user.id)}>Envoyer une demande</button>
                </>
            )}
        </div>
    );
};

export default UserCard;
