<?php
session_start();
include("conn_db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];

    try {
        if (isset($_POST['azione1']) && $_POST['azione1'] === "email") {
            $email = trim($_POST['email']);
            $email2 = trim($_POST['email2']);

            if ($email !== $email2) {
                echo json_encode(["status" => "error", "message" => "Errore: Le e-mail digitate devono corrispondere!"]);
                exit;
            }

            $stmt = $pdo->prepare("UPDATE utenti SET email = :email WHERE id_utente = :user_id");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        }

        if (isset($_POST['azione2']) && $_POST['azione2'] === "username") {
            $username = trim($_POST['username']);
            $username2 = trim($_POST['username2']);

            if (strlen($username) < 3) {
                echo json_encode(["status" => "error", "message" => "Errore: Lo username deve avere almeno 3 caratteri!"]);
                exit;
            }
            if ($username !== $username2) {
                echo json_encode(["status" => "error", "message" => "Errore: Gli username digitati devono corrispondere!"]);
                exit;
            }

            $stmt = $pdo->prepare("UPDATE utenti SET username = :username WHERE id_utente = :user_id");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        }

        if (isset($_POST['azione3']) && $_POST['azione3'] === "password") {
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            if (strlen($password) < 6) {
                echo json_encode(["status" => "error", "message" => "Errore: La password deve avere almeno 6 caratteri!"]);
                exit;
            }
            if ($password !== $password2) {
                echo json_encode(["status" => "error", "message" => "Errore: Le password digitate devono corrispondere!"]);
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);  // Hash della password

            $stmt = $pdo->prepare("UPDATE utenti SET password = :password WHERE id_utente = :user_id");
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        }

        echo json_encode(["status" => "success", "message" => "Aggiornamento completato con successo!"]);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo json_encode(["status" => "error", "message" => "Errore: Il campo digitato esiste già. Riprova!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Errore: " . $e->getMessage()]);
        }
    }
}
?>
