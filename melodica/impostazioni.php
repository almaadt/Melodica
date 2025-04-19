<?php
    session_start();
    include("header.php");
    include("popup_brano.php");
?>

    <!-- Style per i popup relativi all'immagine profilo -->
    <style>
    #popupImg {
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
    #popupImg.hidden { display: none; }
    .popupImg-content {
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
    .popupImg-content p {
        font-size: 25px;
        font-weight: bold;
    }
    .popupImg-content button {
        padding: 10px 17px;
        background-color: #6b47a1;
        color: white;
        border: none;
        border-radius: 100%;
        cursor: pointer;
    }
    .popupImg-content button:hover { background-color: #5a3a85; }

    .icon-img img {
        width: 100px;
        height: 100px;
        border: 4px solid #555;
        border-radius: 100%;
        margin-right: 3px;
    }

    .pulsante1 button{
        padding: 10px 17px;
        background-color: #c2445b;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }
    .pulsante1 button:hover { background-color: #822e3d; }
    </style>

    <script>
        // Funzione necessaria per nascondere i div e farli apparire una volta cliccati
        function modifyDiv(my_div){
            var x = document.getElementById(my_div);
            if(x.style.display === "none"){
                x.style.display = "block";
            } else{
                x.style.display = "none";
            }
        }

        // Funzioni per apertura e chiusura del popup per immagine profilo
        function openPopupImg() {
            document.getElementById("popupImg").style.display = "block";
        }
        function closePopupImg() {
            document.getElementById("popupImg").style.display = "none";
        }

        // Funzione per apertura e chiusura dei popup relativi alle form
        document.addEventListener('DOMContentLoaded', () => {
            const forms = document.querySelectorAll('form');
            const popup = document.getElementById('popup1');
            const popupMessage = document.getElementById('popup1-message');
            const popupClose = document.getElementById('popup1-close');

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
        });
    </script>

    <br>
    <h2><b>Impostazioni</b></h2><br>

    <div>
        <p class="link-text"><a id="mod_email" href="#" onclick="modifyDiv('email_div')">Modifica la tua e-mail</a></p>
        <div>
            <form id="generic-form1" action="process_impostazioni.php" method="POST">
                <input type="hidden" id="azione1" name="azione1" value="email">
                <div style="display: none;" id="email_div" class="input-container">
                    <input type="email" id="email" name="email" placeholder="Nuova e-mail" required> &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="email" id="email2" name="email2" placeholder="Ripeti nuova e-mail" required>
                    <p> </p>
                    <div class="pulsante">
                        <button>Conferma</button>
                    </div>
                </div>
            </form>
        </div>

        <p class="link-text"><a id="mod_username" href="#" onclick="modifyDiv('username_div')">Modifica il tuo username</a></p>
        <div>
            <form id="generic-form2" action="process_impostazioni.php" method="POST">
                <div class="input-container">
                    <input type="hidden" id="azione2" name="azione2" value="username">
                    <div style="display: none;" id="username_div" class="input-container">
                        <input type="text" id="username" name="username" placeholder="Nuovo username" required> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" id="username2" name="username2" placeholder="Ripeti nuovo username" required>
                        <p> </p>
                        <div class="pulsante">
                            <button>Conferma</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <p class="link-text"><a id="mod_pwd" href="#" onclick="modifyDiv('pwd_div')">Modifica la tua password</a></p>
        <div>
            <form id="generic-form3" action="process_impostazioni.php" method="POST">
                <div class="input-container">
                    <input type="hidden" id="azione3" name="azione3" value="password">
                    <div style="display: none;" id="pwd_div" class="input-container">
                        <input type="password" id="password" name="password" placeholder="Nuova password" required> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="password" id="password2" name="password2" placeholder="Ripeti nuova password" required>
                        <p> </p>
                        <div class="pulsante">
                            <button>Conferma</button>
                        </div>
                    </div>
                </div>
             </form>
        </div>
    </div>

    <p class="link-text"><a id="mod_icon" href="#" onclick="modifyDiv('icon_div')">Modifica la tua immagine profilo</a></p>
    <div>
        <div style="display: none;" id="icon_div" class="input-container">
            <div class="pulsante">
                <div class="icon-img">
                    <p>Immagine profilo attuale:&nbsp;&nbsp;&nbsp;
                    <?php
                        $pfp = isset($_SESSION['pfp']) && !empty($_SESSION['pfp']) ? $_SESSION['pfp'] : 'img/playlist.png';
                    ?>
                    <img src="<?php echo $pfp; ?>" alt="img" id="profile-pic"></p>
                    <button onclick="openPopupImg()" id="img-btn"><b>Seleziona Immagine...</b></button>
                </div>
            </div>
            <div id="popupImg" class="hidden">
                <div class="popupImg-content">
                    <button onclick="closePopupImg()" style='float: right;'>✖</button>
                    <br><br>
                    <p id="popupImg-message">Immagini disponibili:<br></p>
                    <br>
                    <div class="icon-img">
                        <img src="img/icon-1.png" alt="img1" class="img-button">
                        <img src="img/icon-2.png" alt="img2" class="img-button">
                        <img src="img/icon-3.png" alt="img3" class="img-button">
                        <img src="img/icon-4.png" alt="img4" class="img-button">
                        <img src="img/icon-5.png" alt="img5" class="img-button">
                        <img src="img/icon-6.png" alt="img6" class="img-button">
                        <img src="img/icon-7.png" alt="img7" class="img-button">
                        <img src="img/icon-8.png" alt="img8" class="img-button">
                    </div>
                    <br><br>
                    <button onclick="closePopupImg()" style="border-radius: 4px;">Conferma</button>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
    <br>

    <p class="link-text"><a id="delete" href="#" onclick="modifyDiv('delete_div')">Elimina il tuo profilo</a></p>
    <div>
        <form>
            <div style="display: none;" id="delete_div" class="input-container">
                <p><b>Attenzione! Tutti i dati relativi al tuo profilo verranno eliminati con esso. Confermare l'eliminazione?</b></p>
                <div class="pulsante1">
                    <button id="delete-btn"><b>Conferma</b></button>
                </div>
            </div>
        </form>
    </div>

    <!-- Style e Div per i popup della form -->
    <style>
    #popup1 {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    #popup1.hidden { display: none; }
    .popup1-content {
      background: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      color: black;
      font-weight: bold;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .popup1-content p {
      margin: 0 0 15px;
      font-size: 16px;
    }
    .popup1-content button {
      padding: 9px 15px;
      background-color: #6b47a1;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .popup1-content button:hover { background-color: #5a3a85; }
    </style>

    <div id="popup1" class="hidden">
      <div class="popup1-content">
        <p id="popup1-message"></p>
        <button id="popup1-close">OK</button>
      </div>
    </div>

    <!-- Style e Script per le immagini profilo -->
    <style>
        .img-button {
            transition: filter 0.3s ease;
            cursor: pointer;
        }
        .img-button:hover { filter: brightness(75%); }
        .img-button.active { filter: brightness(70%); }
    </style>

    <script>
        document.querySelectorAll(".img-button").forEach(function(button) {
            button.addEventListener("click", function() {
                // Rimuove la classe "active" da tutti i bottoni
                document.querySelectorAll(".img-button").forEach(function(btn) {
                    btn.classList.remove("active");
                });

                this.classList.add("active");  // Aggiunge la classe "active" solo all'elemento cliccato
                cambiaImmagine(this.src);
                saveProfileImage(baseName(this.src));  // Salva la nuova immagine nel database (AJAX + PHP)
            });
        });

        function cambiaImmagine(nomeImg) {
            document.getElementById("profile-pic").src = nomeImg;
        }

        // Funzione AJAX per salvare l'immagine scelta nel database
        function saveProfileImage(imageName) {
            fetch("save_profile_img.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "image=" + encodeURIComponent(imageName)
            }).then(response => response.text()).then(data => {
                console.log("Risposta dal server: " + data);
            });
        }

        function baseName(str) {
            var base = new String(str).substring(str.lastIndexOf('/') + 1);
            if(base.lastIndexOf(".") != -1)
            base = base.substring(0, base.lastIndexOf("."));
            return 'img/' + base + '.png';
        }
    </script>

    <!-- Script per eliminazione del profilo -->
    <script>
        const LOGGED_IN_USER_ID = <?php echo isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null'; ?>;
        function getLoggedInUserId() {
            return LOGGED_IN_USER_ID;
        }

        document.getElementById("delete-btn").addEventListener("click", async function() {
        const userId = getLoggedInUserId(); // Funzione per ottenere l'ID dell'utente loggato

        if (!userId) {
            alert("Errore: ID utente non trovato.");
            return;
        }

        if (!confirm("Sei sicuro di voler eliminare il tuo profilo? Questa azione è irreversibile!")) {
            return;
        }

        try {
            const response = await fetch("delete_user.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ user_id: userId }),
            });

            const result = await response.json();

            if (response.ok) {
                alert("Profilo eliminato con successo.");
                window.location.href = "logout.php";
            } else {
                alert(`Errore: ${result.message}`);
            }
        } catch (error) {
            console.error("Errore nella richiesta:", error);
            alert("Si è verificato un errore. Riprova più tardi.");
        }
        });
    </script>

<?php
  include("footer.php");
?>
