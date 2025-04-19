<?php
session_start();
include("conn_db.php");

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["image"])) {
    $image = $_POST["image"];
    $user_id = $_SESSION["user_id"];

    // Salva l'immagine nel database
    $sql = "UPDATE utenti SET pfp = ? WHERE id_utente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $image, $user_id);
    if ($stmt->execute()) {
        echo "Immagine di profilo aggiornata!";
        $_SESSION['pfp'] = $_POST["image"];
    } else {
        echo "Errore nel salvataggio!";
    }
}
?>
