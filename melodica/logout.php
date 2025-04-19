<?php
session_start();
include("conn_db.php"); 

// Salva l'id utente dalla sessione
$user_id_log = $_SESSION['user_id'] ?? null;
$ip = $_SERVER['REMOTE_ADDR'];

// Inserisce il log del logout nel database
if ($user_id_log !== null) {
    if ($ip === '::1') { $ip = '127.0.0.1'; }
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO logs (id_utente_log, ip, tipo_log, esito_log) VALUES (:id_utente_log, :ip, 'LOGOUT', 'OK')"
        );
        $stmt->bindParam(':id_utente_log', $user_id_log);
        $stmt->bindParam(':ip', $ip);
        $stmt->execute();
    } catch (PDOException $e) {
        //
    }
}

// Distrugge tutte le variabili di sessione
$_SESSION = array();

// Elimina anche il cookie di sessione
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Distrugge la sessione
session_destroy();

// Reindirizza alla pagina di login
header("Location: login.php");
exit();
?>
