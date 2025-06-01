// Gestione immagini per evitare richieste infinite
document.addEventListener('DOMContentLoaded', function() {
    // Interrompi qualsiasi richiesta potenzialmente infinita dopo 5 secondi
    setTimeout(function() {
        var spinners = document.querySelectorAll('.animate-spin, .spinner, .loading, [class*="spinner"], [class*="loading"]');
        spinners.forEach(function(spinner) {
            spinner.style.display = 'none';
            spinner.style.animation = 'none';
            spinner.style.opacity = '0';
            spinner.style.visibility = 'hidden';
        });
        
        // Interrompi anche eventuali caricamenti immagini in corso
        var images = document.querySelectorAll('img');
        images.forEach(function(img) {
            if (!img.complete) {
                // Se l'immagine non è ancora caricata, usa il fallback
                var fallbackSrc = img.getAttribute('data-fallback') || 
                                  img.getAttribute('data-src-fallback') || 
                                  '/images/fallback/hardware.svg';
                img.src = fallbackSrc;
            }
        });
    }, 5000);
    
    // Gestisci gli errori di caricamento delle immagini
    document.querySelectorAll('img').forEach(function(img) {
        // Salva il fallback originale se presente
        var originalFallback = img.getAttribute('onerror');
        
        // Imposta una funzione di gestione degli errori che non causerà loop infiniti
        img.onerror = function() {
            // Usa il fallback predefinito se l'attributo onerror non è stato impostato
            if (!originalFallback) {
                // Controlla se è già stato impostato un fallback per evitare loop
                if (img.src.indexOf('/fallback/') === -1) {
                    img.src = '/images/fallback/hardware.svg';
                }
            }
            
            // Imposta onerror a null per evitare ulteriori chiamate
            img.onerror = null;
        };
    });
}); 