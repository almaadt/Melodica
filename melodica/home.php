<?php
    session_start();
    include("conn_db.php");
    include("header.php");
    include("popup_brano.php");

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
?>

<style>
    /* Stile per la colonna responsiva */
    /*.col-md-3 {
        /*width: 25%;
        padding: 5px;
    }*/

    .col-md-3 {
        display: flex;
        justify-content: center; /* Centra orizzontalmente */
        align-items: center; /* Centra verticalmente */
        margin-right: 0;
        padding: 0;
    }

    /* Margine inferiore */
    .mb-4 { margin-bottom: 1.5rem; }

    /* Stile generale della card */
    .card {
        border: 5px solid #582d75; /* Bordo sottile */
        border-radius: 6px; /* Angoli arrotondati */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Ombreggiatura leggera */
        transition: transform 0.3s ease-in-out;
        width: 70%;
    }

    .card:hover { transform: scale(1.07); } /* Effetto zoom al passaggio del mouse */

    /* Stile per l'immagine della card */
    .card-img-top {
        width: 100%; /* Occupa tutta la larghezza della card */
        /*height: 200px; /* Altezza fissa */
        /*object-fit: cover; /* Impedisce distorsioni */
        border-top-left-radius: 1px;
        border-top-right-radius: 1px;
    }
    .card-img-top:hover { cursor: pointer; }

    /* Stile per il corpo della card */
    .card-body {
        padding: 15px;
        background-color: #212121; /* Colore di sfondo */
    }

    /* Stile per il titolo della card */
    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #e8e8e8; /* Colore del testo */
        margin-bottom: 10px;
    }
    .card-title:hover {
        text-decoration: underline;
        cursor: pointer;
    }
</style>

<script>
    function open_playlist(id_playlist, nome_playlist) {
        window.location.href = "contenuto_playlist.php?id_playlist=" + id_playlist + "&nome_playlist=" + nome_playlist;
    }
</script>

        <!-- Sezione: Playlist consigliate -->
        <br><h3><b>Brani consigliati</b></h3><p></p>
        <div class="row">
            <?php
            $sql = <<<SQL
                          SELECT b.*, a.img_artista, a.id_artista, b.img_brano FROM brani b
                          INNER JOIN artisti a ON a.id_artista = b.id_artista
                          WHERE id_genere_brano IN
                          (
                             SELECT b.id_genere_brano FROM brani b
                             INNER JOIN preferiti p ON p.id_brano_pref = b.id_brano
                             WHERE p.id_utente_pref = $user_id
                             UNION
                             SELECT b.id_genere_brano FROM brani b
                             INNER JOIN brani_playlist bp ON bp.id_brano_b = b.id_brano
                             WHERE bp.id_utente_bp = $user_id
                          )
                          ORDER BY RAND() LIMIT 8
                      SQL;

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            $suggeriti = [];

            if ($result->num_rows > 0) {
                $suggeriti = []; // QUESTO PENSO SI POSSA TOGLIERE
                while ($row = $result->fetch_assoc()) {
                    array_push($suggeriti, [
                        "nome_brano" => $row['nome_brano'],
                        "id_brano" => $row['id_brano'],
                        "image" => $row['img_brano'],
                        "nome_file" => $row['nome_file']
                    ]);
                }
            } else {
                //////////////////////////////////////////////
                $sql_random = "SELECT id_brano, nome_brano, img_brano, nome_file FROM brani ORDER BY RAND() LIMIT 8";
                $result_random = $conn->query($sql_random);

                if ($result_random->num_rows > 0) {
                    while ($suggerito = $result_random->fetch_assoc()) {
                        echo '<div onclick="playPopup(\'' . $suggerito["nome_file"] . '\')" class="col-md-3 mb-4">
                                <div class="card">
                                    <img src="' . $suggerito["img_brano"] . '" class="card-img-top" alt="' . htmlspecialchars($suggerito["nome_brano"]) . '">
                                    <div class="card-body">
                                        <h5 class="card-title">' . htmlspecialchars($suggerito["nome_brano"]) . '</h5>
                                    </div>
                                </div>
                              </div>';
                    }
                }
                //////////////////////////////////////////////
            }
            $stmt->close();

            foreach ($suggeriti as $suggerito) {
                $nome = $suggerito["nome_brano"];
                $id_brano = $suggerito["id_brano"];

                echo '<div onclick="playPopup(\''.$suggerito["nome_file"].'\')" class="col-md-3 mb-4">
                        <div class="card">
                            <img src="' . $suggerito["image"] . '" class="card-img-top" alt="' . $suggerito["nome_brano"] . '">
                            <div class="card-body">
                                <h5 class="card-title">' . $suggerito["nome_brano"] . '</h5>
                            </div>
                        </div>
                      </div>';
            }
            ?>
        </div>

        <!-- Sezione: Le tue Playlist -->
        <br><h3><b>Le tue Playlist</b></h3><p></p>
        <div class="row">
            <?php
            $sql = "SELECT * FROM playlist WHERE id_utente_owner = $user_id";
            $stmt = $conn->prepare($sql);
            //$stmt->bindParam('i', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->get_result();

            $playlists = [];

            if ($result->num_rows > 0) {
                $playlists = []; // QUESTO PENSO SI POSSA TOGLIERE
                while ($row = $result->fetch_assoc()) {
                    array_push($playlists, [
                        "name" => $row['nome_playlist'],
                        "image" => "img/playlist1.png",
                        "id_playlist" => $row['id_playlist']
                    ]);
                }
            } else {
                echo "<p>Non hai ancora creato Playlist.</p>";
            }
            $stmt->close();

            foreach ($playlists as $playlist) {
                $nome = $playlist["name"];
                $id_playlist = $playlist["id_playlist"];

                echo '<div onclick="open_playlist('.$id_playlist.',\''.$nome.'\')" class="col-md-3 mb-4">
                        <div class="card">
                            <img src="' . $playlist["image"] . '" class="card-img-top" alt="' . $playlist["name"] . '">
                            <div class="card-body">
                                <h5 class="card-title">' . $playlist["name"] . '</h5>
                            </div>
                        </div>
                     </div>';
            }
            ?>
        </div>

        <!-- Sezione: I tuoi Preferiti -->
        <!--<div class="section-title">I tuoi Preferiti</div>-->
        <br><h3><b>I tuoi Preferiti</b></h3><p></p>
        <div class="row">
            <?php
            $sql = "SELECT p.id_utente_pref, p.id_brano_pref, b.nome_brano, b.nome_file, b.id_artista, b.img_brano, a.img_artista, a.id_artista " .
                   "FROM brani b " .
                   "INNER JOIN preferiti p ON p.id_brano_pref = b.id_brano " .
                   "INNER JOIN artisti a ON b.id_artista = a.id_artista WHERE id_utente_pref = $user_id";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            $preferiti = [];

            if ($result->num_rows > 0) {
                $preferiti = []; // QUESTO PENSO SI POSSA TOGLIERE
                while ($row = $result->fetch_assoc()) {
                    array_push($preferiti, [
                        "nome_brano" => $row['nome_brano'],
                        "id_brano" => $row['id_brano_pref'],
                        "image" => $row['img_brano'],
                        "nome_file" => $row['nome_file']
                    ]);
                }
            } else {
                echo "<p>Non hai ancora aggiunto brani tra i Preferiti.</p>";
            }
            $stmt->close();

            foreach ($preferiti as $preferito) {
                $nome = $preferito["nome_brano"];
                $id_brano = $preferito["id_brano"];

                echo '<div onclick="playPopup(\''.$preferito["nome_file"].'\')" class="col-md-3 mb-4">
                        <div class="card">
                            <img src="' . $preferito["image"] . '" class="card-img-top" alt="' . $preferito["nome_brano"] . '">
                            <div class="card-body">
                                <h5 class="card-title">' . $preferito["nome_brano"] . '</h5>
                            </div>
                        </div>
                    </div>';
            }
            ?>
        </div>

    </div>

<?php
    $conn->close();
    include("footer.php");
?>
