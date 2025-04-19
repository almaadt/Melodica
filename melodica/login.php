<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Melodica - Login</title>

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
    .login-container {
      background: #b7a9cc;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: center;
      width: 350px;
    }
    .login-container img {
      width: 110px;
      height: 110px;
      border-radius: 0%;
      margin-bottom: 0px;
    }
    .login-container h1 {
      font-size: 25px;
      margin-bottom: 20px;
    }
    .login-container form {
      display: flex;
      flex-direction: column;
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
    .login-container input {
      flex: 1;
      padding: 10px;
      font-size: 16px;
      border: 1px solid rgb(204, 204, 204);
      border-radius: 4px;
    }
    .login-container button {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      background-color: #6b47a1;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .login-container button:hover { background-color: #5a3a85; }

    .register-text {
      margin-top: 15px;
      font-size: 14px;
    }
    .register-text a {
      color: #5919bf;
      text-decoration: none;
    }
    .register-text a:hover { text-decoration: underline; }

    .pwd-text {
      margin-top: 10px;
      font-size: 12px;
    }
    .pwd-text a {
      color: #666666;
      text-decoration: none;
    }
    .pwd-text a:hover { text-decoration: underline; }

    .logo-text {
      margin-top: 0px;
      margin-bottom: 20px;
      font-size: 45px;
      font-family: 'Brush Script MT', cursive;
      font-weight: bold;
      color: #6b47a1;
    }

    .toggle-password {
      margin-left: 10px;
      font-size: 25px;
      cursor: pointer;
      color: #6b47a1;
    }
    .toggle-password:hover { text-decoration: none; }

    /* Container per il Popup */
    #popup {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6); /* Sfondo scuro trasparente */
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    #popup.hidden { display: none; } /* Nasconde il popup di default */
    /* Contenuto del Popup */
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
    .popup-content button:hover { background-color: #5a3a85; }
  </style>

  <script>
    function togglePassword() {
      const passwordField = document.getElementById('password');
      const toggleText = document.querySelector('.toggle-password');

      if (passwordField.type === 'password') {
        passwordField.type = 'text'; // Mostra la password
        toggleText.textContent = '◡';
      } else {
        passwordField.type = 'password'; // Nasconde la password
        toggleText.textContent = '👁';
      }
    }

    document.addEventListener('DOMContentLoaded', function () {
      const form = document.querySelector('.login-container form');
      const popup = document.getElementById('popup');
      const popupMessage = document.getElementById('popup-message');
      const closePopup = document.getElementById('close-popup');

      form.addEventListener('submit', async function (event) {
          event.preventDefault(); // Evita il refresh della pagina

          const formData = new FormData(form);

          try {
              const response = await fetch('process_login.php', {
                  method: 'POST',
                  body: formData,
              });

              const result = await response.json();

              // Mostra il popup con il messaggio
              popupMessage.textContent = result.message;
              popup.classList.remove('hidden');

              popupMessage.style.color = result.status === 'success' ? 'green' : 'red';

              // Se il login ha successo, reindirizza alla home dopo 2 secondi
              if (result.status === 'success') {
                  setTimeout(() => {
                      window.location.href = 'home.php';
                  }, 2000); // 1000ms = 2 secondi
              }
        } catch (error) {
            // Gestisci eventuali errori di connessione
            popupMessage.textContent = 'Errore nella connessione al server.';
            popupMessage.style.color = 'red';
            popup.classList.remove('hidden');
        }
      });

      // Gestisci la chiusura del popup
      closePopup.addEventListener('click', function () {
          popup.classList.add('hidden');
      });
    });
  </script>

</head>

<body>

  <div class="login-container">
    <img src="img/music.png" alt="Icon">
    <p class="logo-text">Melodica</p>
    <h1>Login</h1>
    <form>
      <div class="input-container">
          <img src="img/user1.png" alt="User Icon">
          <input type="text" name="email_or_username" id="email_or_username" placeholder="Username o e-mail" required>
      </div>
      <div class="input-container">
          <img src="img/lock1.png" alt="Password Icon">
          <input type="password" name="password" id="password" placeholder="Password" required>
          <span class="toggle-password" onclick="togglePassword()">👁</span>
      </div>
      <button type="submit">Accedi</button>
    </form>
    <p class="register-text">Non hai un account? <a href="register.php">Registrati</a></p>
    <p class="pwd-text"><a href="pwd.php">Hai dimenticato la password?</a></p>
  </div>

  <div id="popup" class="hidden">
    <div class="popup-content">
      <p id="popup-message"></p>
      <button id="close-popup">OK</button>
    </div>
  </div>

</body>
</html>
