<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melodica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-size: 17px;
            background-color: #121212;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .navbar { background-color: #6b47a1; }
        .navbar-brand {
            font-family: 'Brush Script MT', cursive;
            font-size: 29px;
            margin-right: 30px;
            margin-left: 15px;
        }

        .card {
            background-color: #181818;
            border: none;
        }
        .card img { border-radius: 5px; }

        .section-title {
            margin: 20px 0;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .dropdown-menu .dropdown-item { color: white; }
        /* Modifica lo stile del menu a discesa */
        .dropdown-menu {
          background-color: #4b2c82; /* Viola scuro */
          color: white; /* Testo bianco */
        }
        /* Modifica il colore di hover degli elementi nel dropdown */
        .dropdown-item:hover {
          background-color: #6b47a1; /* Viola più chiaro per l'hover */
          color: white; /* Mantieni il testo bianco quando l'elemento è selezionato */
        }

        .search-bar { margin: 20px 0; }
        .btn-success {
            background-color: #6b47a1 !important;
            border-color: #6b47a1 !important;
        }
        .btn-success:hover {
            background-color: #6b47a1 !important;
            border-color: #6b47a1 !important;
        }

        .three-dots { margin-left: auto; }
        .three-dots svg {
          width: 30px;
          height: 30px;
          fill: white;
        }
        .three-dots button { padding: 5px; }
        .dropdown-toggle::after { display: none; }

        .hover-effect {
            width: 20px;
            height: 25px;
            transition: width 0.3s ease, height 0.3s ease, opacity 0.3s ease;
        }
        .hover-effect:hover { opacity: 0.4; }

        .link-text {
            margin-top: 15px;
            margin-bottom: 15px;
            font-size: 20px;
        }
        .link-text a {
            color: #a37ee0;
            text-decoration: none;
        }
        .link-text:hover {
            color: #a37ee0;
            text-decoration: underline;
        }
        a.link-text { color: #a37ee0; }
        strong a.link-text { text-decoration: none; }

        .pulsante button{
            padding: 10px 17px;
            background-color: #6b47a1;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .pulsante button:hover { background-color: #5a3a85; }
    </style>

    <?php
        include ("stile_popup.php");
    ?>

    <script>
        function toggleSearchBar() {
            const searchBar = document.getElementById('searchBarContainer');
            if (searchBar.style.display === 'none' || !searchBar.style.display) {
                searchBar.style.display = 'block';
            } else {
                searchBar.style.display = 'none';
            }
        }

        /* You can use any JavaScript animation library or write your own */
        $('.hover-effect').hover(function(){
          $(this).animate({
            opacity: 0.4
          });
        }, function(){
          $(this).animate({
            opacity: 1 /* ritorna all'opacità originale */
          });
        });
    </script>

</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid">
          <a class="navbar-brand">Melodica</a>
      </div>
  </nav>
  <br>
  <h5><b>&nbsp;&nbsp;&nbsp;Spunta la/le Playlist in cui vuoi aggiungere il brano:</b></h5>

  <div class="container mt-4">
      <!-- Barra di Ricerca -->
      <form name="ricerca" method="POST" action="results.php">
        <div id="searchBarContainer" class="search-bar" style="display: none;">
            <div class="input-group">
                <input name="search_txt" type="text" class="form-control" placeholder="Che cosa vuoi ascoltare?" aria-label="Search">
                <button class="btn btn-success" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zm-5.442.656a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"/>
                    </svg>
                </button>
            </div>
        </div>
      </form>
