<?php
    session_start();
    include("header.php");
    include("conn_db.php");
    include("popup_brano.php");
?>

<style>
    .conferma button{
        padding: 9px 15px;
        background-color: #6b47a1;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }
    .conferma button:hover { background-color: #5a3a85; }

    .conferma1 button{
        padding: 10px 17px;
        background-color: #c2445b;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }
    .conferma1 button:hover { background-color: #822e3d; }

    .link-txt {
        margin-top: 15px;
        margin-bottom: 15px;
        font-size: 20px;
        text-decoration: none;
        color: #a37ee0;
    }
    .link-txt:hover { text-decoration: underline; }

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
</style>

<script>
    function modifyDiv(my_div) {
        var x = document.getElementById(my_div);
        var otherDiv = my_div === "playlist_div" ? document.getElementById("delete_div") : document.getElementById("playlist_div");

        // Chiude l'altro div se è aperto
        if (otherDiv.style.display === "block") {
            otherDiv.style.display = "none";
        }

        // Alterna la visibilità del div selezionato
        x.style.display = (x.style.display === "none" || x.style.display === "") ? "block" : "none";
    }
</script>

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

<?php
    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    if (!isset($_SESSION['user_id'])) {
        echo "<h4><b>Devi effettuare il login per accedere alle funzionalità della pagina.</h4></b>";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $id_playlist = $_GET["id_playlist"];

    // 1. Prima query: dati della playlist (visibile solo se è privata dell'utente attuale, o pubblica di altri utenti)
    $info_sql = "SELECT p.nome_playlist, p.id_utente_owner, p.visibilita, u.username
                 FROM playlist p
                 JOIN utenti u ON p.id_utente_owner = u.id_utente
                 WHERE p.id_playlist = ? AND (p.id_utente_owner = ? OR p.visibilita = 1)";
    $info_stmt = $conn->prepare($info_sql);
    $info_stmt->bind_param("ii", $id_playlist, $user_id);
    $info_stmt->execute();
    $info_result = $info_stmt->get_result();

    if ($info_row = $info_result->fetch_assoc()) {
        echo "<a style='font-size: 29px;'><b>" . htmlspecialchars($info_row["nome_playlist"]) . "&nbsp;&nbsp;</b></a>";

        // Solo il proprietario vede le icone di modifica
        if ($info_row['id_utente_owner'] == $_SESSION['user_id']) {
            echo "<a style='font-size: 23px;' class='link-txt' href='#' onclick='modifyDiv(\"playlist_div\")'>🖊</a>&nbsp;" .
                 "&nbsp;<a style='font-size: 23px;' class='link-txt' href='#' onclick='modifyDiv(\"delete_div\")'>✖</a>";

            $visibilita = $info_row['visibilita'] == 1 ? "Pubblica 🌍" : "Privata 🔒";
            echo "<p style='font-size: 15px; color: gray; margin-bottom: 5px;'>Playlist: <b>$visibilita</b></p>";

            echo '<div>
                    <form id="generic-form" action="process_playlist.php" method="POST">
                        <input type="hidden" id="azione" name="azione" value="playlist">
                        <div style="display: none;" id="playlist_div" class="input-container">
                            <br>
                            <a id="mod_playlist" style="font-size: 19px;">Modifica il nome della playlist: &nbsp;&nbsp;</a>
                            <input type="playlist" id="playlist" value="' . htmlspecialchars($_GET["nome_playlist"]) . '" name="playlist_modify" placeholder="Nuovo nome" required>
                            <input type="hidden" id="playlist_id" name="playlist_id" value="' . htmlspecialchars($_GET["id_playlist"]) . '">
                            <p> </p>
                            <a id="mod_visibilita" style="font-size: 19px;">Modifica la visibilità della playlist:</a>
                            <input type="hidden" id="visibilita_attuale" name="visibilita_attuale" value="<?php echo $visibilita; ?>">
                            <span class="action-buttons" style="display: inline-flex; gap: 5px;">
                                <button type="button" onclick="setVisibilitaValue(1)" id="pubblica-btn">Pubblica 🌍</button>
                                <button type="button" onclick="setVisibilitaValue(0)" id="privata-btn">Privata 🔒</button>
                            </span>
                            <input type="hidden" name="visibilita" id="visibilita" value="0">
                            <input type="hidden" id="playlist_id1" name="playlist_id1" value="' . htmlspecialchars($_GET["id_playlist"]) . '">
                            <p> </p>
                            <div class="conferma">
                                <button>Conferma</button>
                            </div>
                            <br>
                        </div>
                    </form>

                    <form id="generic-form1" action="process_playlist.php" method="POST">
                        <div style="display: none;" id="delete_div" class="input-container">
                            <br>
                            <p><a id="delete_playlist" style="font-size: 19px;"><b>Confermi di voler eliminare la playlist?</b></a></p>
                            <input type="hidden" id="delete" name="playlist_delete" value="' . htmlspecialchars($_GET["id_playlist"]) . '">
                            <p> </p>
                            <div class="conferma1">
                                <button><b>Conferma</b></button>
                            </div>
                            <br>
                        </div>
                    </form>
                  </div>';
        }
        echo "di " . htmlspecialchars($info_row['username']) . "<p></p>";
    } else {
        echo "Playlist non trovata o non visibile.";
        exit;
    }

    // 2. Seconda query per brani (visibili solo se la playlist è visibile all’utente)
    $sql = "SELECT bp.id_playlist_p, bp.id_brano_b, bp.data_brano_playlist,
                   b.nome_brano, b.id_artista, b.nome_file, b.img_brano,
                   a.nome_artista
            FROM brani_playlist bp
            JOIN brani b ON bp.id_brano_b = b.id_brano
            JOIN artisti a ON b.id_artista = a.id_artista
            JOIN playlist p ON bp.id_playlist_p = p.id_playlist
            WHERE p.id_playlist = ? AND (p.id_utente_owner = ? OR p.visibilita = 1)
            ORDER BY bp.data_brano_playlist";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_playlist, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $brani = [];
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<div style='margin-bottom: 10px; display: flex; align-items: center;'>
            <img src='" . htmlspecialchars($row['img_brano']) . "' alt='img/playlist.png' style='width: 50px; height: 50px; object-fit: cover; margin-right: 10px; border-radius: 10px;'>
            <strong>
                <a class='link-text' href='#' onclick='playPopup(\"" . htmlspecialchars($row['nome_file']) . "\")'>
                    " . htmlspecialchars($row['nome_brano']) . "
                </a>
            </strong>&nbsp;- " . htmlspecialchars($row['nome_artista']) . "
            &nbsp;&nbsp;<span style='color: #696969;'>(Aggiunto il: " . substr($row['data_brano_playlist'], 0, 16) . ")</span>
            </div>\n";
            $brani[] = $row['nome_file'];
        }
        echo "</ul>";
    } else {
        echo "<br><h5><b>Questa playlist non contiene ancora brani.<b></h5>";
    }

    $stmt->close();
    $conn->close();
    ?>

<script>
    let playlist = JSON.parse('<?= json_encode($brani); ?>');
    let currentIndex = 0;

    localStorage.setItem("playlist", playlist);
    localStorage.setItem("currentIndex", currentIndex);
</script>

<?php
    include("footer.php");
?>
