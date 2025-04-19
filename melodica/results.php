<?php
    session_start();
    include("header.php");
    include("popup_brano.php");
?>

    <!-- Style per il popup relativo alla selezione della playlist -->
    <style>
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
            width: 400px;
            background: #363636;
            padding: 15px;
            border-radius: 8px;
            /*text-align: center;*/
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

        .icon-img img {
            width: 100px;
            height: 100px;
            border: 4px solid #555;
            border-radius: 100%;
            margin-right: 3px;
        }

        .pulsantino button {
            font-size: 20px;
            font-weight: bold;
            padding: 0 8px;
            background-color: #6b47a1;
            color: white;
            border: none;
            border-radius: 6%;
            cursor: pointer;
        }
        .pulsantino button:hover { background-color: #5a3a85; }
    </style>

    <!-- Barra di ricerca -->
    <form name="ricerca" method="POST" action="results.php">
      <div id="searchBarContainer" class="search-bar" style="display: none;">
          <div class="input-group">
              <input name="search_txt" type="text" class="form-control" placeholder="Che cosa vuoi ascoltare?" aria-label="Search">
              <button class="btn btn-success" type="submit">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zm-5.442.656a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"/>
                  </svg>
              </button>
          </div>
      </div>
    </form>

    <br>
    <h3><b>Risultati della ricerca:</b></h3>
    <p></p>

    <script>
        function openPopupPlaylist(url) {
            var overlay = document.createElement("div");
            overlay.style.position = "fixed";
            overlay.style.top = "0";
            overlay.style.left = "0";
            overlay.style.width = "100vw";
            overlay.style.height = "100vh";
            overlay.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
            overlay.style.display = "flex";
            overlay.style.justifyContent = "center";
            overlay.style.alignItems = "center";
            overlay.style.zIndex = "1000";

            var iframe = document.createElement("iframe");
            iframe.src = url;
            iframe.style.width = "50vw";
            iframe.style.height = "50vh";
            iframe.style.border = "3px solid black";
            iframe.style.backgroundColor = "white";

            var closeButton = document.createElement("button");
            closeButton.innerText = "✖";
            closeButton.style.color = "white";
            closeButton.style.position = "absolute";
            closeButton.style.backgroundColor = "#6b47a1";
            closeButton.style.borderRadius = "100%";
            closeButton.style.margin = "20px";
            closeButton.style.border = "3px solid white";
            closeButton.style.top = "10px";
            closeButton.style.right = "10px";
            closeButton.style.padding = "5px 10px";
            closeButton.style.cursor = "pointer";
            closeButton.onclick = function() {
                document.body.removeChild(overlay);
            };
            closeButton.onmouseover = function() {
                closeButton.style.backgroundColor = "#5a3a85"; // Colore più scuro
                closeButton.style.color = "#7d7d7d"; // Testo più scuro
            };
            closeButton.onmouseout = function() {
                closeButton.style.backgroundColor = "#6b47a1"; // Ritorna al colore originale
                closeButton.style.color = "white"; // Ritorna al colore originale
            };

            var modalContainer = document.createElement("div");
            modalContainer.style.position = "relative";
            modalContainer.style.background = "white";
            modalContainer.style.padding = "20px";
            modalContainer.style.borderRadius = "8px";
            modalContainer.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.3)";

            modalContainer.appendChild(closeButton);
            modalContainer.appendChild(iframe);
            overlay.appendChild(modalContainer);

            document.body.appendChild(overlay);
        }


        // Funzioni per apertura e chiusura del popup per le playlist
        /*function openPopupPlaylist(id_brano, id_playlist) {
            alert(id_brano, id_playlist);
            var allInputs = document.getElementsByTagName("input");
            for (var i = 0, max = allInputs.length; i < max; i++){
                if (allInputs[i].type === 'checkbox') {
                    //allInputs[i].checked = true;
                    let dati = { id_b: id_brano, id_p: id_playlist };

                    fetch("set_IDBrano.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify(dati)
                    })
                    .then(response => response.text())
                    .then(data => console.log("Risposta PHP:", data));
                }
            }
            document.getElementById("popupPlaylist").style.display = "block";
        }*/

        function closePopupPlaylist() {
            document.getElementById("popupPlaylist").style.display = "none";
        }

        // Funzione per apertura e chiusura dei popup relativi alle form
        /*document.addEventListener('DOMContentLoaded', () => {
            const forms = document.querySelectorAll('form');
            const popup = document.getElementById('popupPlaylist');
            const popupMessage = document.getElementById('popupPlaylist-message');
            const popupClose = document.getElementById('popupPlaylist-close');

            // Funzione per mostrare il popup
            function showPopup(message) {
                popupMessage.textContent = message;
                popup.classList.remove('hidden');
            }

            // Nasconde il popup quando si clicca sul bottone "Chiudi"
            popupClose.addEventListener('click', () => {
                popup.classList.add('hidden');
            });

            forms.forEach((form) => {
                form.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    const formData = new FormData(form);

                    try {
                        const response = await fetch('process_impostazioni.php', {
                            method: 'POST',
                            body: formData
                        });

                        if (!response.ok) {
                            showPopup(`Errore HTTP: ${response.status}`);
                            return;
                        }

                        const result = await response.json();

                        if (result.status === 'success') {
                            showPopup(result.message);
                            form.reset();
                        } else if (result.status === 'error') {
                            showPopup(result.message);
                        }
                    } catch (error) {
                        showPopup('Si è verificato un errore. Riprova più tardi.');
                    }
                });
            });
        });*/

        // Funzione AJAX per cambiare l'immagine del preferito
        function setPref(img, id) {
            //alert(img);
            if (event) event.preventDefault();

            fetch("set_preferito.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id_brano=" + encodeURIComponent(id)
            }).then(response => response.text()).then(data => {
                console.log("Risposta dal server: " + data);
            });

            if(img == 'img/empty-heart.png') {
                var img2 = 'img/full-heart.png';
                //alert('FULL');
            }
            else {
                var img2 = 'img/empty-heart.png';
                //alert('EMPTY');
            }
            document.getElementById('preferito' + id).src = img2;
            //document.getElementById('preferito' + id).onclick = 'setPref("'+img2+'", id)"';
            document.getElementById('preferito' + id).onclick = function() {
                setPref(img2, id);
            };
        }
    </script>


<?php
if (trim($_POST['search_txt']) == '' || !isset($_POST['search_txt'])){
    echo("Inserire un testo valido da cercare.");
    exit();
}
include("conn_db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $search_txt = $_POST['search_txt'] ?? '';
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT id_brano AS id, CONCAT(nome_brano, ' - ', nome_artista) AS nome, '(brano)' AS tipo, nome_file FROM brani b, artisti a WHERE b.id_artista = a.id_artista AND nome_brano LIKE :search_txt UNION ".
           "SELECT id_artista AS id, nome_artista AS nome, '(artista)' AS tipo, '' AS nome_file FROM artisti WHERE nome_artista LIKE :search_txt UNION ".
           "SELECT id_playlist AS id, nome_playlist AS nome, '(playlist)' AS tipo, '' AS nome_file FROM playlist WHERE nome_playlist LIKE :search_txt AND (id_utente_owner = :user_id OR visibilita = 1)";

    try {
        $stmt = $pdo->prepare($sql);
        $search_txt = "%$search_txt%";
        $stmt->bindParam(':search_txt', $search_txt, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->execute();

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($items)) {
            foreach ($items as $item) {
                $img = "img/empty-heart.png";
                if($item['tipo'] == "(artista)") {
                    $heart = "";
                    $risultati = "<li><strong>
                                 <a href='artisti.php?id_artista=".$item['id']."&nome_artista=".$item['nome']."' style='color: #5c58d1;' class='link-text'>" .
                                 htmlspecialchars($item['nome']) .
                                 "</a></strong>&nbsp;&nbsp;<span style='font-size: 16px;'>" .
                                 htmlspecialchars($item['tipo']) .
                                 "</span>" . $heart . "<p></p></li>";
                    echo $risultati;

                    /*$risultati = "<div style='margin-bottom: 10px; display: flex; align-items: center;'>
                                    <img src='" . htmlspecialchars($item['img_artista']) . "' alt='Artista' style='width: 50px; height: 50px; object-fit: cover; margin-right: 10px; border-radius: 10px;'>
                                    <div>
                                        <strong>
                                            <a href='artisti.php?id_artista=" . $item['id'] . "&nome_artista=" . urlencode($item['nome']) . "' style='color: #5c58d1;' class='link-text'>
                                                " . htmlspecialchars($item['nome']) . "
                                            </a>
                                        </strong>&nbsp;&nbsp;
                                        <span style='font-size: 16px;'>" . htmlspecialchars($item['tipo']) . "</span>
                                        " . $heart . "
                                    </div>
                                  </div>\n";
                    echo $risultati;*/

                }
                else if($item['tipo'] == "(playlist)") {
                    $heart = "";
                    $risultati = "<li><strong><a href='contenuto_playlist.php?id_playlist=".$item['id']."&nome_playlist=".$item['nome']."' style='color: #58bdd1; 'class='link-text'>" .
                                 htmlspecialchars($item['nome']) .
                                 "</a></strong>&nbsp;&nbsp;<span style='font-size: 16px;'>" .
                                 htmlspecialchars($item['tipo']) .
                                 "</span>" . $heart . "<p></p></li>";
                    echo $risultati;
                }
                else {
                    if($item['tipo'] == "(brano)") {
                        $stmt1 = $pdo->prepare(
                            "SELECT COUNT(*) AS trovato FROM preferiti WHERE id_brano_pref = :id_brano AND id_utente_pref = :user_id"
                        );
                        $id_brano = $item['id'];
                        $stmt1->bindParam(':id_brano', $id_brano, PDO::PARAM_INT);
                        $stmt1->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                        $stmt1->execute();
                        $preferito = $stmt1->fetch(PDO::FETCH_ASSOC);
                        if($preferito['trovato'] == 1) {
                            $img = "img/full-heart.png";
                        }
                    }
                    $heart = "\n&nbsp;&nbsp;<a href='#' class='hover-effect'><img id='preferito$id_brano' style='width:20px; height:20px;' ".
                             " src='$img' alt='preferiti' onclick='setPref(\"$img\", $id_brano)'></a>";

                    $risultati = "<li><strong><a href='#' style='color: #a37ee0;' class='link-text' onclick='playPopup(\"" . htmlspecialchars($item['nome_file'])."\")'>" .
                                 htmlspecialchars($item['nome']) .
                                 "</a></strong>&nbsp;&nbsp;<span style='font-size: 16px;'>" .
                                 htmlspecialchars($item['tipo']) .
                                 "</span>" . $heart . "&nbsp;&nbsp;";
                    echo $risultati;
                    ?>

                        <a class="pulsantino">
                            <button onclick="openPopupPlaylist('elenco_playlist.php?id_brano=<?php echo $id_brano; ?>')" id="img-btn"><b>...</b></button>
                        </a>

                        <div id="popupPlaylist" class="hidden">
                            <div class="popupPlaylist-content">
                                <button onclick="closePopupPlaylist()" style='float: right;'>✖</button>
                                <br><br>

                                <?php
                                    try {
                                        $stmt = $pdo->prepare(
                                            "SELECT id_playlist, nome_playlist FROM playlist WHERE id_utente_owner = :user_id ORDER BY nome_playlist"
                                        );
                                        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                                        $stmt->execute();
                                        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if (!empty($items)) {
                                            foreach ($items as $item) {
                                                $id = $item["id_playlist"];
                                                echo "\n<form>" .
                                                    "\n<input type='checkbox' id='playlist" .$id. "' name='playlist" .$id. "' value='" .$id. "'>" .
                                                    "<label for='playlist'>&nbsp;&nbsp;" .addslashes($item["nome_playlist"]). "</label><br>";
                                                echo "\n</form>";
                                            }
                                        }
                                    } catch (PDOException $e) {
                                        echo json_encode(["status" => "error", "message" => "Errore: " . $e->getMessage()]);
                                    }
                                ?>
                                <br>
                            </div>
                        </div>
                        <p></p></li>

                    <?php
                }
            }
        } else {
            echo "Nessun risultato corrispondente alla ricerca trovato.";
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Errore: " . $e->getMessage()]);
    }
}
?>

    <div id="popupPlaylist" class="hidden">
      <div class="popupPlaylist-content">
        <p id="popupPlaylist-message"></p>
        <button id="popupPlaylist-close">OK</button>
      </div>
    </div>

<?php
    include("footer.php");
?>
