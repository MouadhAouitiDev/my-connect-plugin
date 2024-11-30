

/* Point d'entrée pour React, montage des composants */

import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';

// Créer une racine pour le montage de l'application React
const root = ReactDOM.createRoot(document.getElementById('root'));

root.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
);
