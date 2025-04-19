<?php
    session_start();
    include("header.php");
    include("conn_db.php");
    include("popup_brano.php");
?>

    <style>
        .impostazioni-btn button {
          width: 13%;
          padding: 10px;
          font-size: 17px;
          background-color: #6b47a1;
          color: #fff;
          border: none;
          border-radius: 4px;
          cursor: pointer;
        }
        .impostazioni-btn button:hover { background-color: #5a3a85; }

        .general-text {
          margin-top: 15px;
          font-size: 14px;
          text-align: left;
        }
        .general-text a {
          color: #5919bf;
          text-decoration: none;
        }
        .general-text a:hover { text-decoration: underline; }

        .username-text {
          margin-top: 0px;
          margin-bottom: 20px;
          font-size: 40px;
          font-weight: bold;
          color: #6b47a1;
          text-align: left;
        }

        img {
          width: 130px;
          height: 130px;
          border: 4px solid #555;
          border-radius: 100%;
        }
        .icon-img img {
            width: 100px;
            height: 100px;
            border: 4px solid #555;
            border-radius: 100%;
            margin-right: 3px;
        }
        .icon-img img:hover {

        }
    </style>

    <div class="impostazioni-btn">
        <button style='float: right;' onclick="window.location.href='impostazioni.php'">Impostazioni</button>
    </div>
    <div>
      <br>
      <?php
        $pfp = isset($_SESSION["pfp"]) && !empty($_SESSION["pfp"]) ? $_SESSION["pfp"] : 'img/playlist.png';
      ?>
      <img src="<?php echo $pfp; ?>" alt="[Icona Utente]">
      <br>
      <p> </p>
    </div>

<?php
    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Controlla se l'utente è loggato
    if (!isset($_SESSION['user_id'])) {
        echo "Devi essere loggato per poter visualizzare il tuo Account.";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT username FROM utenti WHERE id_utente = ?"; // Query per ottenere il nome dell'utente

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p class='username-text'><strong>" . ($row['username']) . "</strong></p>";
        }
    }

    $stmt->close();

    // Query per ottenere le playlist dell'utente
    $sql = "SELECT id_playlist, nome_playlist FROM playlist WHERE id_utente_owner = :user_id";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt1->execute();
    $playlists = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    // Mostra le playlist
    if ($playlists) {
        echo "<h3><b>Le tue playlist:<b></h3><ul>";
        foreach ($playlists as $playlist) {
            echo "<li><strong><a class='link-text' href='contenuto_playlist.php?id_playlist=".$playlist['id_playlist'].".&nome_playlist=".$playlist['nome_playlist']."'>" .
                htmlspecialchars($playlist['nome_playlist']) . "</a></strong></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nessuna playlist trovata.</p>";
    }

    $conn->close();
?>

<?php
    include("footer.php");
?>
