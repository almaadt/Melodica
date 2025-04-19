<?php
session_start();
include("conn_db.php");

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['playlist_modify'])) {
        $id_playlist = $_POST['playlist_id'];

        $stmt = $pdo->prepare("UPDATE playlist SET nome_playlist = :nome_playlist, visibilita = :visibilita WHERE id_playlist = :id_playlist");
        $stmt->bindParam(':nome_playlist', $_POST['playlist_modify']);
        $stmt->bindParam(':visibilita', $_POST['visibilita']);
        $stmt->bindParam(':id_playlist', $id_playlist);
        $stmt->execute();

        $pagina = "contenuto_playlist.php?id_playlist=".$id_playlist."&nome_playlist=".$_POST['playlist_modify'];
    }

    if (isset($_POST['playlist_delete'])) {
        $id_playlist = $_POST['playlist_delete'];
        $stmt = $pdo->prepare("DELETE FROM playlist WHERE id_playlist = :id_playlist");
        $stmt->bindParam(':id_playlist', $id_playlist);
        $stmt->execute();

        $stmt = $pdo->prepare("DELETE FROM brani_playlist WHERE id_playlist_p = :id_playlist");
        $stmt->bindParam(':id_playlist', $id_playlist);
        $stmt->execute();

        $pagina = "libreria.php";
    }
    mysqli_close($conn);
}
header("Location: $pagina");
?>
