<?php
session_start();
include("conn_db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email_or_username = $_POST['email_or_username'] ?? '';
    $password = $_POST['password'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'];

    try {
        $stmt = $pdo->prepare(
            "SELECT * FROM utenti WHERE email = :email_or_username OR username = :email_or_username"
        );
        $stmt->bindParam(':email_or_username', $email_or_username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login riuscito - Salva i dati nella sessione
            $_SESSION['user_id'] = $user['id_utente'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['pfp'] = $user['pfp'];

            if ($ip === '::1') { $ip = '127.0.0.1'; }
            $log_stmt = $pdo->prepare(
                "INSERT INTO logs (id_utente_log, ip, tipo_log, esito_log) VALUES (:id_utente_log, :ip, 'LOGIN', 'OK')"
            );
            $log_stmt->bindParam(':id_utente_log', $user['id_utente']);
            $log_stmt->bindParam(':ip', $ip);
            $log_stmt->execute();

            echo json_encode(["status" => "success", "message" => "Login effettuato con successo!", "user" => $user]);
        } else {
            $user_id_log = $user['id_utente'] ?? null;

            if ($ip === '::1') { $ip = '127.0.0.1'; }
            $log_stmt = $pdo->prepare(
                "INSERT INTO logs (id_utente_log, ip, tipo_log, esito_log) VALUES (:id_utente_log, :ip, 'LOGIN', 'FAILED')"
            );
            $log_stmt->bindParam(':id_utente_log', $user_id_log);
            $log_stmt->bindParam(':ip', $ip);
            $log_stmt->execute();

            echo json_encode(["status" => "error", "message" => "E-mail/Username o password errati."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Errore durante il login: " . $e->getMessage()]);
    }
}
?>
