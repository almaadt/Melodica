<?php
    session_start();
    include("conn_db.php");

    // Controlla se l'utente è autenticato
    if (!isset($_SESSION["user_id"])) {
        echo json_encode(["success" => false, "message" => "Accesso negato."]);
        exit;
    }

    $user_id = $_SESSION["user_id"];

    // Connessione al database
    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Inizia una transazione per eliminare i dati correlati
    $conn->begin_transaction();

    try {
        // Elimina i dati correlati
        $conn->query("DELETE FROM playlist WHERE id_utente_owner = $user_id");
        $conn->query("DELETE FROM preferiti WHERE id_utente_pref = $user_id");

        // Elimina l'utente
        $stmt = $conn->prepare("DELETE FROM utenti WHERE id_utente = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $conn->commit();    // Conferma l'eliminazione
            session_destroy();  // Logout dell'utente
            echo json_encode(["success" => true, "message" => "Profilo eliminato con successo."]);
        } else {
            throw new Exception("Errore durante l'eliminazione del profilo.");
        }
    } catch (Exception $e) {
        $conn->rollback();  // Annulla le modifiche in caso di errore
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    // Chiudi la connessione
    $conn->close();
?>
