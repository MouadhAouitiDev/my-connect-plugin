/* Composant pour gérer les demandes de connexion */

import React from 'react';
import { Button, Card } from 'react-bootstrap'; // Import Bootstrap components

const ConnectionRequest = ({ invitation, onInvitationAccepted, onInvitationRejected }) => {
    return (
        <Card className="mb-3">
            <Card.Body>
                <Card.Title>
                    Demande de connexion de {invitation.user_id_1} à {invitation.user_id_2}
                </Card.Title>
                <Card.Text>Status: {invitation.status}</Card.Text>
                <Card.Text>Envoyee le: {new Date(invitation.created_at).toLocaleString()}</Card.Text>

                <Button variant="success" onClick={() => onInvitationAccepted(invitation.id)}>
                    Accepter
                </Button>
                <Button variant="danger" className="ml-2" onClick={() => onInvitationRejected(invitation.id)}>
                    Rejeter
                </Button>
            </Card.Body>
        </Card>
    );
};

export default ConnectionRequest;
