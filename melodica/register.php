<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melodica - Registrazione</title>
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
          width: 400px;
      }
      .login-container img {
          width: 100px;
          height: 100px;
          border-radius: 0%;
          margin-bottom: 1px;
      }
      .login-container h1 {
          font-size: 25px;
          margin-bottom: 20px;
      }
      .login-container form {
          display: flex;
          flex-direction: column;
      }
      .login-container input {
          flex: 1;
          padding: 10px;
          font-size: 16px;
          border: 1px solid rgb(204, 204, 204);
          border-radius: 4px;
      }
      .login-container button {
          padding: 10px;
          font-size: 16px;
          background-color: #6b47a1;
          color: #fff;
          border: none;
          border-radius: 4px;
          cursor: pointer;
      }
      .login-container button:hover { background-color: #6b47a1; }

      .input-container {
          display: flex;
          align-items: center;
          margin-bottom: 10px;
      }
      .input-container img {
          width: 22px;
          height: 22px;
          margin-right: 10px;
      }

      .register-text {
          margin-top: 15px;
          margin-bottom: 2px;
          font-size: 14px;
      }
      .register-text a {
          color: #5919bf;
          text-decoration: none;
      }
      .register-text a:hover { text-decoration: underline; }

      .begin-text {
          margin-top: 15px;
          font-size: 14px;
      }

      .logo-text {
        margin-top: 0px;
        margin-bottom: 20px;
        font-size: 45px;
        font-family: 'Brush Script MT', cursive;
        font-weight: bold;
        color: #6b47a1;
      }

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

      .toggle-password {
        margin-left: 10px;
        font-size: 25px;
        cursor: pointer;
        color: #6b47a1;
      }
      .toggle-password:hover { text-decoration: none; }
      .toggle-password1 {
        margin-left: 10px;
        font-size: 25px;
        cursor: pointer;
        color: #6b47a1;
      }
      .toggle-password1:hover { text-decoration: none; }
    </style>

</head>
<body>
    <div class="login-container">
        <img src="img/music.png" alt="Icon">
        <p class="logo-text">Melodica</p>
        <h1>Registrazione</h1>
        <p class="begin-text">Per iniziare, inserisci la tua e-mail e scegli un Username ed una Password:</p>
        <form id="registration-form" action="process_register.php" method="POST">
            <div class="input-container">
                <img src="img/email.png" alt="Mail Icon">
                <input type="text" name="email" placeholder="E-mail" required>
            </div>
            <div class="input-container">
                <img src="img/user1.png" alt="User Icon">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-container">
                <img src="img/lock1.png" alt="Password Icon">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="toggle-password" onclick="togglePassword()">👁</span>
            </div>
            <div class="input-container">
                <img src="img/lock1.png" alt="Password Icon">
                <input type="password" name="password1" id="password1" placeholder="Ripeti password" required>
                <span class="toggle-password1" onclick="togglePassword1()">👁</span>
            </div>
            <button type="submit">Crea Account</button>
        </form>
        <p class="register-text"><a href="login.php">Torna al Login</a></p>
    </div>

    <div id="popup" class="hidden">
      <div class="popup-content">
        <p id="popup-message"></p>
        <button id="popup-close">Chiudi</button>
      </div>
    </div>

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
    function togglePassword1() {
        const passwordField = document.getElementById('password1');
        const toggleText = document.querySelector('.toggle-password1');

        if (passwordField.type === 'password') {
            passwordField.type = 'text'; // Mostra la password
            toggleText.textContent = '◡';
        } else {
            passwordField.type = 'password'; // Nasconde la password
            toggleText.textContent = '👁';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form');
        const popup = document.getElementById('popup');
        const popupMessage = document.getElementById('popup-message');
        const popupClose = document.getElementById('popup-close');

        // Funzione per mostrare il popup
        function showPopup(message) {
            popupMessage.textContent = message;
            popup.classList.remove('hidden');
        }

        // Nasconde il popup quando si clicca sul bottone "Chiudi"
        popupClose.addEventListener('click', () => {
            popup.classList.add('hidden');
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(form);

            try {
                const response = await fetch('process_register.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    showPopup(result.message);
                    form.reset();
                } else if (result.status === 'error') {
                    showPopup(result.message);
                }
            } catch (error) {
                console.error('Errore durante la richiesta:', error);
                showPopup('Si è verificato un errore. Riprova più tardi.');
            }
        });
    });
    </script>
</body>
</html>
