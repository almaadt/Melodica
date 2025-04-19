<?php
session_start();
include("conn_db.php");
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_utente_owner = $_SESSION['user_id'];
    echo("Utente " . $_SESSION["user_id"]);
    $nome_playlist = mysqli_real_escape_string($conn, $_POST['nome_playlist']);
    $visibilita = isset($_POST['visibilita']) ? (int) $_POST['visibilita'] : 0;

    $query = "INSERT INTO playlist (id_utente_owner, nome_playlist, visibilita)
             VALUES ('$id_utente_owner', '$nome_playlist', '$visibilita')";

    if (mysqli_query($conn, $query)) {
        /*echo " - Playlist creata con successo con visibilità ";
        if($visibilita == 0){ echo("Privata."); }
        else { echo("Pubblica."); }*/

        header("Location: libreria.php");
        exit();
    } else {
        echo "Errore: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
