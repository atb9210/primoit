# PRIMO IT - Linee Guida UX/UI

## Ispirazione
Il design è ispirato al sito [Return Trading](https://www.returntrading.nl/), mantenendo un'interfaccia pulita e professionale adatta al settore B2B per la vendita di stock IT.

## Principi generali
- **Semplicità**: Design pulito e funzionale che mette in risalto i prodotti
- **Trasparenza**: Tutte le informazioni sui prodotti devono essere facilmente accessibili
- **B2B-oriented**: Focus sull'esperienza utente aziendale, con funzionalità specifiche per acquisti all'ingrosso
- **Responsive**: Design ottimizzato per desktop, tablet e mobile

## Palette colori
- **Primario**: #3D5AFE (Blu acceso)
- **Secondario**: #FF6D00 (Arancione per call-to-action)
- **Neutro chiaro**: #F5F7FA
- **Neutro scuro**: #212B36
- **Accento**: #00C853 (Verde per stati positivi)
- **Errore**: #D50000

## Tipografia
- **Titoli**: Poppins, bold
- **Corpo**: Inter, regular
- **Accento**: Poppins, semibold
- **Dimensioni**:
  - H1: 36px
  - H2: 28px
  - H3: 22px
  - Corpo: 16px
  - Small: 14px

## Componenti UI

### Header
- Logo aziendale
- Menu di navigazione principale
- Pulsanti di accesso/registrazione
- Pulsante "Stock disponibile" in evidenza
- Contatti diretti (telefono)

### Footer
- Menu di navigazione secondario
- Informazioni di contatto
- Collegamenti a pagine legali
- Copyright

### Pagina Home
- Hero section con slogan e pulsante CTA
- Slider dei prodotti in evidenza
- Sezione "Chi siamo" breve
- Sezione "Come funziona" con step
- Form di contatto

### Pagina Listino Prodotti
- Filtri per categorie
- Card dei prodotti con:
  - Immagine
  - Numero batch
  - Titolo descrittivo
  - Breve descrizione tecnica
  - Stato (disponibile, riservato, venduto)
  - Pulsante "Maggiori informazioni"

### Pagina Singolo Prodotto
- Galleria immagini
- Dettagli completi del prodotto
- Scheda tecnica dettagliata
- Numero di lotto
- Quantità disponibile
- Prezzo (visibile solo a utenti registrati)
- Pulsante "Prenota ora" (visibile solo a utenti registrati)
- Sezione download PDF specifiche
- Form di contatto rapido

### Componenti comuni
- **Pulsanti**:
  - Primario: sfondo blu, testo bianco
  - Secondario: sfondo bianco, bordo blu, testo blu
  - CTA: sfondo arancione, testo bianco
- **Card**:
  - Sfondo bianco
  - Ombra leggera
  - Bordi arrotondati (4px)
- **Form**:
  - Input con label sopra
  - Validazione in tempo reale
  - Messaggi di errore chiari

## Stati utente
1. **Visitatore**: Accesso limitato, vede prodotti ma non prezzi
2. **Cliente B2B registrato**: Accesso completo a prezzi, dettagli e funzionalità di acquisto
3. **Amministratore**: Gestione completa dei prodotti e utenti

## Comportamenti responsivi
- **Desktop**: Layout completo a 3-4 colonne per i prodotti
- **Tablet**: Layout a 2 colonne, menu compattato
- **Mobile**: Layout a 1 colonna, menu a hamburger

## Elementi di accessibilità
- Contrasto adeguato per tutti i testi
- Testi alternativi per tutte le immagini
- Navigazione possibile da tastiera
- Messaggi di feedback chiari per le azioni

## Funzionalità specifiche B2B
- Richiesta preventivi personalizzati
- Download listino prezzi in PDF
- Richiesta di riservare stock
- Visualizzazione storico ordini
- Area personale con dashboard cliente