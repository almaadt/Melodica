<?php
    include("header.php");
    include("popup_brano.php");
?>

    <style>
    /* Stile per i button 'Seleziona Immagine...', 'Privata', 'Pubblica' */
    .action-buttons { margin-top: 1px; }
    .action-buttons button {
        margin: 10px 10px;
        padding: 7px 14px;
        font-size: 17px;
        background-color: #6b47a1;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .action-buttons button:hover { background-color: #52377a; }
    .action-buttons button.active.pubblica {
        font-weight: bold;
        background-color: #58ba47;
        color: white;
    }
    .action-buttons button.active.privata {
        font-weight: bold;
        background-color: #c2445b;
        color: white;
    }

    /* Stile per il popup che appare quando viene cliccato 'Seleziona Immagine...' */
    #popupPlaylist {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0%;
        left: 0%;
        background-color: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    #popupPlaylist.hidden { display: none; }
    .popupPlaylist-content {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70%;
        background: #363636;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .popupPlaylist-content p {
        font-size: 25px;
        font-weight: bold;
    }
    .popupPlaylist-content button {
        padding: 10px 17px;
        background-color: #6b47a1;
        color: white;
        border: none;
        border-radius: 100%;
        cursor: pointer;
    }
    .popupPlaylist-content button:hover { background-color: #5a3a85; }

    /* Stile per le immagini della playlist */
    .icon-img img {
        width: 100px;
        height: 100px;
        border: 4px solid #555;
        border-radius: 100%;
        margin-right: 3px;
    }
    </style>

    <script>
        function handlePubblicaClick(button) {
            // Imposta il valore di visibilità su "1" (Pubblica)
            const visibilitaField = document.getElementById('visibilita');
            visibilitaField.value = "1";

            // Cambia stile del pulsante
            button.classList.add('pubblica');
            const privataButton = document.querySelector('.action-buttons .privata');
            if (privataButton) privataButton.classList.remove('privata');
        }
        function handlePrivataClick(button) {
            // Imposta il valore di visibilità su "0" (Privata)
            const visibilitaField = document.getElementById('visibilita');
            visibilitaField.value = "0";

            // Cambia stile del pulsante
            button.classList.add('privata');
            const pubblicaButton = document.querySelector('.action-buttons .pubblica');
            if (pubblicaButton) pubblicaButton.classList.remove('pubblica');
        }
        function setVisibilitaValue(value) {
            const artistInput = document.getElementById('visibilita');
            const pubblicaButton = document.getElementById('pubblica-btn');
            const privataButton = document.getElementById('privata-btn');

            artistInput.value = value; // Aggiorna il valore del campo nascosto

            // Cambia lo stile visivo per indicare quale bottone è attivo
            if (value === 1) {
              pubblicaButton.classList.add('active', 'pubblica');
              privataButton.classList.remove('active', 'privata');
            } else {
              privataButton.classList.add('active', 'privata');
              pubblicaButton.classList.remove('active', 'pubblica');
            }
        }
    </script>

    <br>
    <h2><b>Crea una nuova Playlist</b></h2> <br>
    <form method="POST" action="process_new_playlist.php">
        <label for="nome_playlist">Nome Playlist: &nbsp;</label>
        <input type="text" name="nome_playlist" required><br><br>
        <div class="action-buttons">
            <label for="visibilita">Visibilità playlist:</label>
            <button type="button" onclick="setVisibilitaValue(1)" id="pubblica-btn">Pubblica 🌍</button>
            <button type="button" onclick="setVisibilitaValue(0)" id="privata-btn">Privata 🔒</button>
        </div>
        <input type="hidden" name="visibilita" id="visibilita" value="0">
        <p> </p> <br>
        <div class="action-buttons">
            <button type="submit">Crea Playlist</button>
        </div>
    </form>

<?php
    include("footer.php");
?>
