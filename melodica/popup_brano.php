
<style>
    #popup {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    #popup.hidden { display: none; }
    .popup-content {
        position: absolute;
        top: 74%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70%;
        background: #363636;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .popup-content p {
        font-size: 20px;
        font-weight: bold;
    }
    .popup-content button {
        padding: 10px 17px;
        background-color: #6b47a1;
        color: white;
        border: none;
        border-radius: 100%;
        cursor: pointer;
    }
    .popup-content button:hover { background-color: #5a3a85; }

    .controls button {
        margin-top: 3px;
        padding: 4px 4px;
        background-color: #6b47a1;
        color: white;
        border: none;
        border-radius: 0;
        cursor: pointer;
        font-size: 10px;
    }
    .controls button:hover { background-color: #5a3a85; }
</style>

<div id="popup" class="popup-content" style="display: none;">
    <div class="popup-close">
        <button onclick="closePopup()">✖</button>
    </div>
    <p id="titolo_brano">&nbsp;</p>
    <audio onended="nextSong()" controls id="brano">
        <source id="nome_file" src="" type="audio/mpeg">
        Il tuo browser non supporta l'elemento audio.
    </audio>
    <div class="controls">
        <button onclick="prevSong()">|◀◀</button>&nbsp;
        <button onclick="nextSong()">▶▶|</button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Recupera i dati salvati
        const savedTrack = localStorage.getItem("currentTrack");
        const savedTime = localStorage.getItem("trackTime");
        const wasPlaying = localStorage.getItem("isPlaying") === "true";  // Converte in booleano

        const playlist = localStorage.getItem("playlist");
        const currentIndex = localStorage.getItem("currentIndex");

        if (savedTrack) {
            playPopup(savedTrack, parseFloat(savedTime || 0), wasPlaying);
        }
    });

    function openPopup() {
        document.getElementById("popup").style.display = "block";
    }

    function closePopup() {
        let brano = document.getElementById("brano");
        brano.pause();
        document.getElementById("popup").style.display = "none";
        localStorage.removeItem("currentTrack");
        localStorage.removeItem("trackTime");
        localStorage.removeItem("isPlaying");
    }

    function playPopup(nome_file, startTime = 0, shouldPlay = true) {
        document.getElementById("nome_file").src = nome_file;
        document.getElementById("titolo_brano").innerText = nome_file.substring(6, nome_file.length - 4);

        let brano = document.getElementById("brano");
        brano.load();

        // Per passare i dati ad incrementa_ascolti.php
        let dati = new URLSearchParams();
        dati.append("nome_file", nome_file);

        fetch("incrementa_ascolti.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: dati
        })
        .then(response => response.text())

        brano.onloadedmetadata = function () {
            brano.currentTime = startTime;  // Riprendi dalla posizione salvata
            if (shouldPlay) {
                brano.play();
            }
        };

        openPopup();

        // Salva lo stato nel localStorage
        localStorage.setItem("currentTrack", nome_file);
        localStorage.setItem("trackTime", startTime);
        localStorage.setItem("isPlaying", shouldPlay);

        // Salva il tempo di riproduzione e lo stato di pausa/play
        brano.ontimeupdate = function () {
            localStorage.setItem("trackTime", brano.currentTime);
        };

        brano.onplay = function () {
            localStorage.setItem("isPlaying", "true");
        };

        brano.onpause = function () {
            localStorage.setItem("isPlaying", "false");
        };
    }


    function prevSong() {
        if (playlist.length === 0) return;
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : playlist.length - 1;
        playPopup(playlist[currentIndex]);
    }

    function nextSong() {
        if (playlist.length === 0) return;
        currentIndex = (currentIndex < playlist.length - 1) ? currentIndex + 1 : 0;
        playPopup(playlist[currentIndex]);
    }
</script>
