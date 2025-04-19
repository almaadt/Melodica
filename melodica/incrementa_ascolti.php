<?php
    session_start();
    include("conn_db.php");

    $nome_file = $_POST['nome_file'];

    try {
        $sql = "SELECT id_brano FROM brani WHERE nome_file = :nome_file";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_file', $nome_file);
        $stmt->execute();
        $brano = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_brano = $brano['id_brano'];

        $stmt0 = $pdo->prepare(
            "SELECT COUNT(*) AS trovato FROM ascolti WHERE id_utente_asc = :id_utente AND id_brano_asc = :id_brano"
        );
        $id_utente = $_SESSION['user_id'];
        $stmt0->bindParam(':id_utente', $id_utente);
        $stmt0->bindParam(':id_brano', $id_brano);
        $stmt0->execute();
        $ascolti = $stmt0->fetch(PDO::FETCH_ASSOC);

        if ($ascolti['trovato'] == 0) {
            $sql = "INSERT INTO ascolti (id_brano_asc, id_utente_asc, contatore) VALUES(:id_brano, :id_utente, 1)";
        } else {
            $sql = "UPDATE ascolti SET contatore = contatore+1 WHERE id_brano_asc = :id_brano AND id_utente_asc = :id_utente";
        }
        $stmt1 = $pdo->prepare($sql);
        $stmt1->bindParam(':id_brano', $id_brano);
        $stmt1->bindParam(':id_utente', $id_utente);
        $stmt1->execute();
    } catch (PDOException $e) {
        echo "Errore: " . $e->getMessage();
    }
?>
