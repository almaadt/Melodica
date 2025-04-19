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

    $sql = "DELETE FROM brani_playlist WHERE id_brano_b = ? AND id_utente_owner = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_brano, $user_id);
    if ($stmt->execute()) {
        echo "Playlist *** aggiornata: n." . $stmt->affected_rows . " affected row(s).";
    } else {
        echo "Errore nel salvataggio!";
    }

    if($stmt->affected_rows == 0) {
        $sql = "INSERT INTO playlist(id_brano_playlist, id_utente_owner) VALUES(?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_brano, $user_id);
        if ($stmt->execute()) {
            //echo "Playlist aggiornata!";
        } else {
            echo "Errore nel salvataggio!";
        }
    }
}
?>
