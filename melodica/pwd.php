<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reimpostazione Password</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #181024;
    }

    .email-container {
      background: #b7a9cc;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: center;
      width: 400px;
    }
    .email-container img {
      width: 100px;
      height: 100px;
      margin-bottom: 0px;
    }
    .email-container h1 {
      font-size: 25px;
      margin-bottom: 20px;
    }
    .email-container input {
      flex: 1;
      padding: 10px;
      font-size: 16px;
      border: 1px solid rgb(204, 204, 204);
      border-radius: 4px;
    }
    .email-container button {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      background-color: #6b47a1;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .email-container button:hover {
      background-color: #5a3a85;
    }

    .input-container {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }
    .input-container img {
      width: 22px;
      height: 22px;
      margin-right: 10px;
    }

    .email-text a {
      color: #5919bf;
      text-decoration: none;
    }
    .email-text a:hover {
      text-decoration: underline;
    }

    .pass-text {
      margin-top: 10px;
      font-size: 14px;
    }
    .pass-text a {
      color: #007BFF;
      text-decoration: none;
    }
    .pass-text a:hover {
      text-decoration: underline;
    }

    #popup {
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
    #popup.hidden {
      display: none;
    }
    .popup-content {
      background: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .popup-content p {
      margin: 0 0 15px;
      font-size: 16px;
    }
    .popup-content button {
      padding: 10px 20px;
      background-color: #6b47a1;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .popup-content button:hover {
      background-color: #5a3a85;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <img src="img/music.png" alt="Icon">
    <h1>Reimpostazione Password</h1>
    <p class="pass-text">Inserisci il tuo indirizzo e-mail o il tuo username e ti invieremo un link per accedere di nuovo al tuo account.</p>
    <form id="email-form" method="POST">
      <div class="input-container">
        <img src="img/user1.png" alt="User Icon">
        <input type="text" name="email_or_username" id="email_or_username" placeholder="Username o e-mail" required>
      </div>
      <button type="submit">Conferma</button>
    </form>
    <p class="email-text"><a href="login.php">Torna al Login</a></p>
  </div>

  <div id="popup" class="hidden">
    <div class="popup-content">
      <p id="popup-message"></p>
      <button id="close-popup">OK</button>
    </div>
  </div>

  <script>
    document.getElementById('email-form').addEventListener('submit', async function(event) {
      event.preventDefault(); // Evita il refresh della pagina

      const formData = new FormData(this);
      const popup = document.getElementById('popup');
      const popupMessage = document.getElementById('popup-message');

      try {
        const response = await fetch('process_pwd.php', {
          method: 'POST',
          body: formData
        });

        const result = await response.json();

        // Mostra il popup con il messaggio ricevuto dal server
        popupMessage.textContent = result.message;
        popup.classList.remove('hidden');

        // Cambia il colore del messaggio in base al risultato
        popupMessage.style.color = result.status === 'success' ? 'green' : 'red';
      } catch (error) {
        // Gestisce eventuali errori di connessione
        popupMessage.textContent = 'Errore nella connessione al server.';
        popupMessage.style.color = 'red';
        popup.classList.remove('hidden');
      }
    });

    document.getElementById('close-popup').addEventListener('click', function() {
      document.getElementById('popup').classList.add('hidden');
    });
  </script>
</body>
</html>
