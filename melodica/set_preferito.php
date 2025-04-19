<?php
session_start();
include("conn_db.php");

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_brano"])) {
    $id_brano = $_POST["id_brano"];
    $user_id = $_SESSION["user_id"];

    $sql = "DELETE FROM preferiti WHERE id_brano_pref = ? AND id_utente_pref = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_brano, $user_id);
    if ($stmt->execute()) {
        echo "Preferiti aggiornati: n." . $stmt->affected_rows . " affected row(s).";
    } else {
        echo "Errore nel salvataggio!";
    }

    if($stmt->affected_rows == 0) {
        $sql = "INSERT INTO preferiti(id_brano_pref, id_utente_pref) VALUES(?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_brano, $user_id);
        if ($stmt->execute()) {
            //echo "Preferiti aggiornati!";
        } else {
            echo "Errore nel salvataggio!";
        }
    }
}
?>
