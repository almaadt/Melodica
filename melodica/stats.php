<?php
    session_start();
    include("header.php");
    include("conn_db.php");
    include("popup_brano.php");
?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .contenitore {
          display: flex;
          justify-content: center;
          align-items: flex-start;
          height: 100vh;
          gap: 40px;
          flex-wrap: wrap;
        }

        .classifica {
          display: flex;
          flex-direction: column;
          gap: 10px;
          max-width: 500px;
          justify-content: flex-start;
        }

        .canzone {
          display: flex;
          align-items: center;
          border: 1px solid #ccc;
          border-radius: 10px;
          padding: 10px;
          background: #333;
          margin-right: 50px
        }
        .canzone img {
          width: 50px;
          height: 50px;
          border-radius: 5px;
          margin-right: 15px;
        }

        /* Per modificare testo e background della Top 10 */
        .info {
          display: flex;
          flex-direction: column;
        }
        .info strong {
          font-size: 16px;
          color: #fff;
        }
        .info span {
          font-size: 14px;
          color: #8c8c8c;
        }

        /* Per il grafico a torta */
        .chart-container {
          max-width: 600px;
          margin-top: 40px;
        }
        .chart-container {
          flex: 0 0 500px;
          height: 500px;
          width: 100%;
          max-width: 500px;
        }
    </style>

    <?php
        $conn = new mysqli($host, $user, $password, $dbname);
        if ($conn->connect_error) {
            die("Connessione fallita: " . $conn->connect_error);
        }

        if (!isset($_SESSION['user_id'])) {
            echo "Devi essere loggato per visualizzare le tue statistiche!";
            exit;
        }

        $user_id = $_SESSION['user_id'];

        $sql = "SELECT b.nome_brano, a.nome_artista, l.contatore, b.img_brano
                FROM ascolti l
                JOIN brani b ON l.id_brano_asc = b.id_brano
                JOIN artisti a ON b.id_artista = a.id_artista
                WHERE l.id_utente_asc = ?
                ORDER BY l.contatore DESC
                LIMIT 10";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $canzoni = [];
        while ($row = $result->fetch_assoc()) {
            $canzoni[] = [
                "titolo" => $row['nome_brano'],
                "artista" => $row['nome_artista'],
                "ascolti" => (int)$row['contatore'],
                "img" => $row['img_brano'] ?: "https://via.placeholder.com/50?text=NA"
            ];
        }

        $stmt->close();
        $conn->close();
    ?>

    <div class="contenitore">
        <div class="classifica">
        <br>
        <?php if (!empty($canzoni)): ?>
          <h2><b>🎵 Top 10 brani ascoltati</b></h2>
          <?php foreach ($canzoni as $index => $song): ?>
            <div class="canzone">
              <img src="<?= $song['img'] ?>" alt="cover">
              <div class="info">
                <strong><?= ($index + 1) ?>. <?= $song['titolo'] ?></strong>
                <span><?= $song['artista'] ?> – <?= $song['ascolti'] ?> ascolti</span>
              </div>
            </div>
          <?php endforeach; ?>
          <div style="height: 40px;"></div>
        <?php else: ?>
          <h3>Non hai ancora ascoltato brani!</h3>
        <?php endif; ?>
        </div>

      <div class="chart-container">
        <canvas id="graficoTorta" width="500" height="500"></canvas>
      </div>
    </div>

    <script>
      const titoli = <?= json_encode(array_column($canzoni, 'titolo')) ?>;
      const ascolti = <?= json_encode(array_column($canzoni, 'ascolti')) ?>;

      new Chart(document.getElementById("graficoTorta"), {
        type: 'pie',
        data: {
          labels: titoli,
          datasets: [{
            data: ascolti,
            backgroundColor: [
              '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
              '#9966FF', '#FF9F40', '#66BB6A', '#F06292',
              '#BA68C8', '#90A4AE'
            ]
          }]
        },
        options: {
          responsive: false,
          plugins: {
            legend: {
              position: 'right',
              labels: {
                padding: 25
              }
            }
          }
        }
      });
    </script>

<?php
    include("footer.php");
?>
