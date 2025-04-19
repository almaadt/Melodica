<?php
$host = 'localhost';
$dbname = 'melodica';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Errore di connessione al database: " . $e->getMessage()]);
    exit;
}

// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];

    // Validazione base
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Formato email non valido."]);
        exit;
    }
    if (strlen($username) < 3) {
        echo json_encode(["status" => "error", "message" => "Lo username deve avere almeno 3 caratteri."]);
        exit;
    }
    if (strlen($password) < 6) {
        echo json_encode(["status" => "error", "message" => "La password deve avere almeno 6 caratteri."]);
        exit;
    }
    if (($password) != ($password1)) {
        echo json_encode(["status" => "error", "message" => "Le password digitate devono corrispondere."]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);  // Hash della password

    try {
        // Inserimento nel database
        $stmt = $pdo->prepare("INSERT INTO utenti (email, username, password) VALUES (:email, :username, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
        echo json_encode(["status" => "success", "message" => "Registrazione completata con successo! Torna al Login per effettuare l'accesso."]);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo json_encode(["status" => "error", "message" => "Errore: L'e-mail o lo username esistono già."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Errore durante la registrazione: " . $e->getMessage()]);
        }
    }
}
?>
