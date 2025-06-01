# PRIMO IT - Architettura del Sistema

## Panoramica
PRIMO IT è una piattaforma B2B per la vendita di stock IT (hardware e accessori) ispirata al modello di returntrading.nl. Il sistema è basato su Laravel 12 con Breeze per l'autenticazione e gestione utenti, integrato con un modulo API Node.js per servizi esterni.

## Stack Tecnologico
- **Frontend**: Blade + Tailwind CSS + Alpine.js
- **Backend**: Laravel 12 (PHP 8.3)
- **Database**: MySQL
- **API**: Node.js con Express
- **Autenticazione**: Laravel Breeze
- **Deployment**: Server Linux con Nginx

## Struttura Database

### Tabelle Principali

#### users
- id (PK)
- name
- email
- password
- role (enum: 'admin', 'customer')
- company_name
- vat_number
- phone
- address
- city
- postal_code
- country
- is_approved (boolean)
- email_verified_at
- created_at
- updated_at

#### companies
- id (PK)
- name
- vat_number
- address
- city
- postal_code
- country
- phone
- email
- website
- notes
- created_at
- updated_at

#### categories
- id (PK)
- name
- slug
- description
- parent_id (FK, self-referential)
- created_at
- updated_at

#### products
- id (PK)
- batch_number
- name
- slug
- description
- quantity
- min_order_quantity
- price (visibile solo a utenti registrati)
- status (enum: 'available', 'reserved', 'sold')
- condition (enum: 'new', 'refurbished', 'used')
- category_id (FK)
- has_product_list (boolean)
- product_list_url
- created_at
- updated_at

#### product_specifications
- id (PK)
- product_id (FK)
- key (es. "processor", "ram", "storage")
- value
- created_at
- updated_at

#### product_images
- id (PK)
- product_id (FK)
- image_path
- is_primary (boolean)
- created_at
- updated_at

#### orders
- id (PK)
- user_id (FK)
- status (enum: 'pending', 'confirmed', 'cancelled', 'completed')
- total_amount
- notes
- created_at
- updated_at

#### order_items
- id (PK)
- order_id (FK)
- product_id (FK)
- quantity
- price
- created_at
- updated_at

#### inquiries
- id (PK)
- name
- email
- company
- phone
- message
- product_id (FK, nullable)
- status (enum: 'new', 'in_progress', 'resolved')
- created_at
- updated_at

## Architettura delle API

### Laravel API (Interno)
- `/api/products` - Gestione prodotti
- `/api/users` - Gestione utenti
- `/api/orders` - Gestione ordini
- `/api/inquiries` - Gestione richieste informazioni

### Node.js API (Esterno)
- `/api/external-integration` - Integrazione con servizi esterni
- `/api/data-sync` - Sincronizzazione dati
- `/api/notifications` - Sistema di notifiche
- `/api/webhooks` - Gestione webhooks

## Ruoli e Permessi

### Visitatore
- Visualizza home page e informazioni generali
- Visualizza lista prodotti senza prezzi
- Visualizza singolo prodotto senza prezzo
- Registrazione account
- Contattare l'azienda

### Cliente B2B
- Tutto ciò che può fare un visitatore
- Visualizza prezzi
- Visualizza dettagli tecnici completi
- Scarica schede tecniche in PDF
- Richiede preventivi personalizzati
- Prenota prodotti
- Gestisce il proprio profilo

### Amministratore
- Tutto ciò che può fare un cliente B2B
- Gestisce prodotti (CRUD)
- Gestisce categorie (CRUD)
- Approva nuovi account cliente
- Gestisce ordini e prenotazioni
- Visualizza e risponde alle richieste di informazioni
- Accede a statistiche e report
- Gestisce impostazioni del sistema

## Flussi Principali

### Registrazione Cliente
1. Utente compila form di registrazione
2. Sistema invia email di verifica
3. Utente conferma email
4. Amministratore approva account
5. Cliente riceve notifica di approvazione

### Acquisto Prodotto
1. Cliente accede e naviga nel catalogo
2. Cliente seleziona prodotto
3. Cliente prenota prodotto
4. Amministratore riceve notifica
5. Amministratore conferma disponibilità
6. Cliente riceve preventivo
7. Cliente conferma ordine
8. Amministratore gestisce pagamento e spedizione

## Integrazioni
- Sistema email per notifiche
- Gateway di pagamento
- Integrazione con sistemi di logistica
- API per sincronizzazione inventario con altri sistemi
- Integrazione con sistemi CRM

## Considerazioni di Sicurezza
- Autenticazione con Laravel Breeze e Sanctum
- Protezione CSRF
- Validazione input lato server
- Rate limiting per API
- Dati sensibili criptati nel database
- HTTPS per tutte le connessioni
- Backup regolari del database 