<?php
    session_start();
    include("header.php");
    include("conn_db.php");
    include("popup_brano.php");
?>

<?php
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Controlla se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    echo "Devi essere loggato per vedere i tuoi preferiti.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Query per ottenere i preferiti dell'utente
$sql = "SELECT p.id_preferito, b.nome_brano, b.id_artista, p.data_pref, a.nome_artista, b.nome_file, b.img_brano
        FROM preferiti p
        JOIN brani b ON p.id_brano_pref = b.id_brano
        JOIN artisti a ON b.id_artista = a.id_artista
        WHERE p.id_utente_pref = ?
        ORDER BY p.data_pref DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$brani = [];

if ($result->num_rows > 0) {
    echo "<br><h2><b>I tuoi Preferiti</b></h2><br>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<div style='margin-bottom: 10px;'>
            <img src='" . htmlspecialchars($row['img_brano']) . "' alt='img/playlist.png' style='width: 50px; height: 50px; object-fit: cover; vertical-align: middle; margin-right: 10px; border-radius: 10px;'>
            <strong>
                <a class='link-text' href='#' onclick='playPopup(\"" . htmlspecialchars($row['nome_file']) . "\")'>
                    " . htmlspecialchars($row['nome_brano']) . "
                </a>
            </strong> - " . htmlspecialchars($row['nome_artista']) . "
            &nbsp;&nbsp;<span style='color: #696969;'>(Aggiunto il: " . substr($row['data_pref'], 0, 16) . ")</span>
            </div>\n";
        $brani[] = $row['nome_file'];
    }
    echo "</ul>";
} else {
    echo "<br><h4><b>Non hai ancora brani preferiti.</b></h4>";
}

$stmt->close();
$conn->close();
?>


<script>
    let playlist = JSON.parse('<?= json_encode($brani); ?>');
    let currentIndex = 0;

    localStorage.setItem("playlist", playlist);
    localStorage.setItem("currentIndex", currentIndex);
</script>


<?php
    include("footer.php");
?>
