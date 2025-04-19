<?php
    session_start();
    include("header.php");
    include("conn_db.php");
    include("popup_brano.php");
?>

    <br>
    <h2><b>La tua Libreria</b></h2>
    <li><strong><a class='link-text' href="preferiti.php">Preferiti</a></strong></li>
    <p> </p>

<?php
    $id_utente = $_SESSION['user_id'];

    // Query per ottenere le playlist dell'utente
    $sql = "SELECT id_playlist, nome_playlist FROM playlist WHERE id_utente_owner = :id_utente";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id_utente", $id_utente, PDO::PARAM_INT);
    $stmt->execute();
    $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mostra le playlist
    if ($playlists) {
    echo "<h4>Le tue playlist:</h4><ul>";
    foreach ($playlists as $playlist) {
        echo "<li><strong><a class='link-text' href='contenuto_playlist.php?id_playlist=".$playlist['id_playlist'].".&nome_playlist=".$playlist['nome_playlist']."'>" .
            htmlspecialchars($playlist['nome_playlist']) . "</a></strong></li>";
    }
    echo "</ul>";
    } else {
    echo "<p>Nessuna playlist trovata.</p>";
    }
?>

<?php
    include("footer.php");
?>
