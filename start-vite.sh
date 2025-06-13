#!/bin/bash
# Script per avviare Vite in modalità server sempre attivo
# [2024-06-13 15:16] Generato da AI su richiesta utente
nohup npm run dev -- --host 0.0.0.0 > vite.log 2>&1 &
echo "Vite avviato in background. Log su vite.log" 