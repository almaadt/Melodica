<?php
    session_start();
    include("conn_db.php");
    include("header_popup.php");
?>

    <script>
        function setPlaylist(id_playlist, id_brano) {
            var playlist_value = document.getElementById(id_playlist).value;
            if (document.getElementById(id_playlist).checked) {
              var flag = "true";
            } else {
              var flag = "false";
            }

            fetch("set_IDBrano.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id_brano=" + encodeURIComponent(id_brano) +
                      "&id_playlist=" + encodeURIComponent(playlist_value) +
                      "&flag=" + encodeURIComponent(flag)
            }).then(response => response.text()).then(data => {
                console.log("Risposta dal server: " + data);
            });
        }
    </script>


    <div id="popupPlaylist" class="hidden">
        <div class="popupPlaylist-content">
            <?php
                $id_brano = $_GET["id_brano"];
                $user_id = $_SESSION["user_id"];

                try {
                    $stmt = $pdo->prepare(
                        "SELECT id_playlist, nome_playlist FROM playlist WHERE id_utente_owner = :user_id ORDER BY nome_playlist"
                    );
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                    $stmt->execute();
                    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($items)) {
                        foreach ($items as $item) {
                            $id_playlist = $item["id_playlist"];

                            $stmt1 = $pdo->prepare(
                                "SELECT COUNT(*) AS trovato FROM brani_playlist WHERE id_utente_bp = :user_id AND id_brano_b = :id_brano AND id_playlist_p = :id_playlist"
                            );
                            //$stmt1->bind_param("iii", $id_brano, $id_playlist, $user_id);
                            $stmt1->bindParam(':id_brano', $id_brano, PDO::PARAM_INT);
                            $stmt1->bindParam(':id_playlist', $id_playlist, PDO::PARAM_INT);
                            $stmt1->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                            $stmt1->execute();
                            $items1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($items1 as $item1) {
                                if($item1['trovato'] == 1) {
                                    $stato = "checked";
                                } else {
                                    $stato = "";
                                }
                            }
                            echo "\n<form>" .
                                 "\n<input type='checkbox' $stato id='playlist" .$id_playlist. "' name='playlist" .$id_playlist. "' value='" .$id_playlist.
                                 "' onchange='setPlaylist(\"playlist" .$id_playlist. "\",\"$id_brano\")'>" .
                                 "<label for='playlist'>&nbsp;&nbsp;" .addslashes($item["nome_playlist"]). "</label><br>";
                            echo "\n</form>";
                        }
                    }
                } catch (PDOException $e) {
                    echo json_encode(["status" => "error", "message" => "Errore: " . $e->getMessage()]);
                }
            ?>
            <br>
        </div>
    </div>
    <p></p></li>


<?php
    include("footer.php");
?>
