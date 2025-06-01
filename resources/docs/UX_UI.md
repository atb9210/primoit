# Linee Guida UX/UI - PrimoIT B2B Platform

## Principi di Design

### 1. Semplicità e Chiarezza
- Interfacce pulite con contenuti ben organizzati
- Eliminazione di elementi non necessari
- Percorsi utente diretti e comprensibili
- Ogni pagina deve avere uno scopo chiaro

### 2. Consistenza
- Pattern di design coerenti in tutta l'applicazione
- Terminologia uniforme
- Comportamenti prevedibili per componenti simili
- Sistema di design unificato per colori, tipografia e componenti

### 3. Gerarchia Visiva
- Informazioni più importanti evidenziate
- Azioni primarie distinte visivamente dalle secondarie
- Layout che guida naturalmente l'occhio dell'utente
- Spazio bianco utilizzato strategicamente per creare separazione

### 4. Feedback e Reattività
- Conferme visibili per le azioni degli utenti
- Feedback immediato per interazioni
- Stati di caricamento chiari
- Messaggi di errore specifici e costruttivi

### 5. Accessibilità
- Contrasto di colore sufficiente (WCAG AA minimum)
- Struttura semantica HTML
- Supporto per la navigazione da tastiera
- Design responsive per tutti i dispositivi

## Palette Colori

### Colori Principali
- **Blu primario**: #1a56db - Azioni principali, branding
- **Grigio scuro**: #1f2937 - Testo principale, header
- **Bianco**: #ffffff - Sfondo, aree di contenuto

### Colori Secondari
- **Blu chiaro**: #3b82f6 - Azioni secondarie, link
- **Grigio chiaro**: #f3f4f6 - Sfondi secondari, bordi
- **Grigio medio**: #6b7280 - Testo secondario

### Colori di Stato
- **Verde**: #10b981 - Successo, approvazioni
- **Giallo**: #f59e0b - Avviso, azioni in attesa
- **Rosso**: #ef4444 - Errore, azioni distruttive

## Tipografia

### Font
- **Font principale**: Figtree (sans-serif)
- **Font di fallback**: system-ui, -apple-system, sans-serif

### Dimensioni (desktop)
- **Titoli principali**: 24px/1.5 (font-semibold)
- **Sottotitoli**: 18px/1.5 (font-medium)
- **Testo corpo**: 16px/1.5 (font-normal)
- **Testo piccolo**: 14px/1.5 (font-normal)
- **Testo molto piccolo**: 12px/1.5 (font-normal)

## Layout

### Struttura Generale
- Header fissato con navigazione principale
- Sidebar (per area admin) con navigazione contestuale
- Contenuto principale con layout a griglia responsive
- Footer con informazioni di contatto e link secondari

### Spaziatura
- Sistema di spaziatura basato su incrementi di 4px (4, 8, 16, 24, 32, 48, 64)
- Padding consistente all'interno di componenti simili
- Margini verticali tra sezioni per creare separazione visiva

## Componenti UI

### Pulsanti
- **Primario**: Blu pieno, testo bianco, hover più scuro
- **Secondario**: Grigio chiaro, testo scuro, hover più scuro
- **Terziario**: Solo testo, nessun background, hover con underline
- **Pulsanti di pericolo**: Rosso, per azioni distruttive

### Form
- Etichette chiare sopra i campi input
- Feedback di validazione in tempo reale
- Messaggi di errore specifici sotto i campi
- Placeholder significativi
- Stati focus ben definiti

### Tabelle
- Header con sfondo grigio chiaro
- Righe alternate con sfondo leggermente diverso
- Hover riga per evidenziare
- Paginazione per tabelle lunghe
- Opzioni di ordinamento chiare

### Card
- Contenitori con ombra leggera
- Padding consistente
- Header, corpo e footer ben definiti
- Hover states per card interattive

## Pattern UX Specifici per B2B

### Catalogo Prodotti
- Filtri avanzati e persistenti
- Visualizzazione lista/griglia
- Dettagli essenziali del prodotto visibili nella lista
- Indicatori di disponibilità chiari

### Processo di Ordine
- Multi-step con indicatore di progresso
- Salvataggio automatico delle informazioni
- Riepilogo dell'ordine sempre visibile
- Opzioni di spedizione e pagamento chiare

### Dashboard Admin
- Statistiche rilevanti in evidenza
- Azioni frequenti facilmente accessibili
- Notifiche per elementi che richiedono attenzione
- Filtri e ricerca potenti

### Area Cliente
- Riepilogo account con informazioni chiave
- Accesso rapido a ordini recenti
- Stato delle richieste e degli ordini ben visibile
- Self-service per azioni comuni

## Principi Responsivi

- Design mobile-first
- Breakpoint: 640px (sm), 768px (md), 1024px (lg), 1280px (xl)
- Layout a colonna singola su mobile
- Menu di navigazione collassabile su dispositivi piccoli
- Touch target sufficientemente grandi (min 44px)
- Contenuto adattivo per vari dispositivi

## Test e Ottimizzazione

- Test di usabilità regolari con utenti reali
- Analytics per tracciare il comportamento degli utenti
- Ottimizzazione iterativa basata su dati reali
- A/B testing per decisioni importanti
- Raccolta feedback dagli utenti 