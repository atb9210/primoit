# PrimoIT

## Overview
PrimoIT è un'applicazione web Laravel che fornisce un sistema di gestione per rivenditori di prodotti tecnologici, con particolare focus sull'integrazione con fornitori terzi. L'applicazione include un sistema di scraping per estrarre dati da vari fornitori, tra cui ITSale.pl.

## Caratteristiche Principali

- **Sistema di Scraping**: Estrazione automatica di dati da fornitori terzi come ITSale.pl
- **Gestione Fornitori**: Sistema completo per la gestione dei fornitori terzi
- **Interfaccia Amministrativa**: Pannello di controllo per gestire prodotti, ordini e fornitori
- **Estrazione Dati Affidabile**: Pattern di riconoscimento avanzati per estrarre dati strutturati da siti web

## Tecnologie Utilizzate

- **Backend**: Laravel (PHP)
- **Frontend**: Blade, Tailwind CSS
- **Database**: MySQL
- **Scraping**: Symfony DomCrawler, HTTP Client
- **Cache**: Sistema di cache Laravel

## Installazione

1. Clona il repository:
   ```bash
   git clone https://github.com/atb9210/primoit.git
   cd primoit
   ```

2. Installa le dipendenze:
   ```bash
   composer install
   npm install
   ```

3. Configura il file di ambiente:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configura il database nel file `.env`

5. Esegui le migrazioni:
   ```bash
   php artisan migrate
   ```

6. Avvia il server:
   ```bash
   php artisan serve
   npm run dev
   ```

## Componente ITSale Scraper

Il componente `ITSaleScraperController` è uno dei principali strumenti dell'applicazione, progettato per estrarre dati strutturati dal sito ITSale.pl. Questo scraper:

- Estrae dati da due fonti principali:
  - All Available Lists: https://itsale.pl/list
  - Latest Wholesale Lists: https://itsale.pl/homepage.php?category_id=0&page=1&limit=60
- Utilizza pattern matching avanzato per identificare vari formati di liste
- Estrae informazioni come nome prodotto, unità, prezzo medio, descrizione, prezzi standard e scontati
- Presenta i dati in un'interfaccia admin user-friendly

## Manutenzione

Per pulire la cache e ottimizzare l'applicazione dopo modifiche:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize
```

## Log delle Attività

Un log dettagliato delle attività di sviluppo e manutenzione è disponibile in `storage/logs/LogCursorAttivita.md`.

## Licenza

Il progetto PrimoIT è rilasciato con licenza MIT.
