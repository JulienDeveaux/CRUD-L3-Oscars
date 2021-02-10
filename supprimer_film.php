<?php
    $titre = "Supprimer un film";
    include 'debutSkelXhtml.php';
    include 'Film.php';

    echo '<form action="supprimer_film.php" method="get" >';
    if(!empty($_GET['id'])) {
        if (is_numeric($_GET['id'])) {
            $film = Film::initFilm(intval($_GET['id']));
            $film->setId_film($_GET['id']);
            $film->delete();

            echo  '<meta http-equiv="refresh" content="0;URL=page_film.php" />';
        }
    }