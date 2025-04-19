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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email_or_username = $_POST['email_or_username'] ?? '';

    try {
        $stmt = $pdo->prepare(
            "SELECT * FROM utenti WHERE email = :email_or_username OR username = :email_or_username"
        );
        $stmt->bindParam(':email_or_username', $email_or_username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo json_encode(["status" => "success", "message" => "Mail inviata con successo!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "E-mail o Username errati."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Errore durante l'invio della mail: " . $e->getMessage()]);
    }
}
?>
