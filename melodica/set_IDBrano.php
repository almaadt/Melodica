<?php
session_start();
include("conn_db.php");

/*var_dump($_POST);
exit();*/

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_brano"])) {
    $id_brano = $_POST["id_brano"];
    $id_playlist = $_POST["id_playlist"];
    $user_id = $_SESSION["user_id"];

    // Salva l'immagine nel database
    $sql = "DELETE FROM brani_playlist WHERE id_brano_b = ? AND id_playlist_p = ? AND id_utente_bp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $id_brano, $id_playlist, $user_id);
    if ($stmt->execute()) {
        echo "Playlist aggiornata: n." . $stmt->affected_rows . " affected row(s).";
    } else {
        echo "Errore nel salvataggio!";
    }

    if($stmt->affected_rows == 0) {
        $sql = "INSERT INTO brani_playlist(id_brano_b, id_playlist_p, id_utente_bp) VALUES(?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $id_brano, $id_playlist, $user_id);
        if ($stmt->execute()) {
            echo "Playlist aggiornata!";
        } else {
            echo "Errore nel salvataggio!";
        }
    }
}
?>
