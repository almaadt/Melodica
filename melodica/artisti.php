<?php
    session_start();
    include("header.php");
    include("conn_db.php");
    include("popup_brano.php");
?>

<style>
    .icon-img img {
        width: 150px;
        height: 150px;
        border: 4px solid #555;
        border-radius: 100%;
        margin-right: 3px;
        margin-bottom: 10px;
    }
</style>

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
    $sql = "SELECT b.nome_brano, b.id_artista, a.nome_artista, b.nome_file, b.img_brano, a.img_artista
            FROM brani b
            JOIN artisti a ON b.id_artista = a.id_artista
            WHERE a.id_artista = ".$_GET["id_artista"].
            " ORDER BY b.nome_brano";

    $stmt = $conn->prepare($sql);
    //$stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $i = 0;

    if ($result->num_rows > 0) {
        $brani = [];
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            $i = $i+1;
            if($i == 1) {
                echo "<div class='icon-img'><img src='".$row["img_artista"]."' alt='artista'></div>";
                echo "<h2><b>" . $_GET["nome_artista"] . "</b></h2><br> <h4>Brani:</h4><p></p>";
            }
            echo "<div style='margin-bottom: 10px; display: flex; align-items: center;'>
                    <img src='" . htmlspecialchars($row['img_brano']) . "' alt='Copertina' style='width: 50px; height: 50px; object-fit: cover; margin-right: 10px; border-radius: 10px;'>
                    <strong>
                        <a class='link-text' href='#' onclick='playPopup(\"" . htmlspecialchars($row['nome_file']) . "\")'>
                            " . htmlspecialchars($row['nome_brano']) . "
                        </a>
                    </strong>&nbsp;- " . htmlspecialchars($row['nome_artista']) . "
                    &nbsp;&nbsp;<span style='color: #696969;'></span>
                  </div>\n";
            $brani[] = $row['nome_file'];
        }
        echo "</ul>";
    } else {
        echo "<p>Nessun brano trovato.</p>";
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
