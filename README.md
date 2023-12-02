# Ecommerce PHP

## Progetto di Pratica Personale

Questo progetto è un'esemplificazione delle capacità di PHP nella creazione di un'ecommerce senza l'ausilio di framework. Attualmente è nella fase di progettazione.

## Istruzioni per l'Avvio Locale

### Installazione:
Clonare la repository utilizzando il link HTTPS e importarla nel tuo IDE copiando il progetto da VSC. In alternativa, scaricare il file compresso.
- #### Per gli utenti di XAMPP, posizionare la cartella in: "C:\xampp\htdocs\"
- #### Per gli utenti di Laragon, posizionare la cartella in: "C:\laragon\www\"

### Avvio di Apache
### Creare un Database Locale
In futuro, uno script automatizzato si occuperà di questo, comprese le impostazioni delle credenziali. Attualmente, utilizza MySQL per aprire una connessione e creare un database. 
Preferibilmente, nominarlo 'ecommerce' per evitare modifiche nelle impostazioni delle credenziali in inc/config.php.

In seguito, eseguire lo script situato nel percorso del progetto "database/DDL.sql". Una volta importato, le entità saranno installate nel sistema, consentendo l'accesso e risolvendo problemi visivi.

### Impostazioni Credenziali Database - Se Necessario
Modifica le definizioni del database nel file inc/config.php se necessario. Se hai eseguito il passaggio precedente nominando il database 'ecommerce' non ne hai bisogno.

### Visualizzazione del Sito
Apri http://localhost/ecommerce, e il sito sarà funzionante. Per gli utenti di Laragon, concedi i permessi a FileSystem32 e accedi nella barra degli indirizzi con ecommerce.test 
