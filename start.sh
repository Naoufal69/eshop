#!/bin/bash

# Couleurs pour l'affichage
GREEN='\033[0;32m'
NC='\033[0m' # No Color

echo -e "${GREEN}⏳ Démarrage du serveur Laravel...${NC}"
cd backend
php artisan serve --host=127.0.0.1 --port=8000 &
LARAVEL_PID=$!

echo -e "${GREEN}⏳ Démarrage du serveur Vue.js (TypeScript)...${NC}"
cd ../frontend
npm run dev -- --port 8080

# À la fermeture de Vue, on arrête Laravel proprement
kill $LARAVEL_PID
