<?php
    $titre = "Supprimer un film";
    include 'debutSkelXhtml.php';
    include 'Film.php';

    echo '<form action="supprimer_film.php" method="get" >';
    if(isset($_GET['Oui'])) {
        if (!empty($_GET['id'])) {
            if (is_numeric($_GET['id'])) {
                $film = Film::initFilm(intval($_GET['id']));
                $film->delete();
                echo '<meta http-equiv="refresh" content="0;URL=page_film.php" />';
            }
        }
    }else if(isset($_GET['Annuler'])){
    echo  '<meta http-equiv="refresh" content="0;URL=page_film.php" />';
    }
    else {
		$film = Film::initFilm($_GET['id']);
		echo '<h1> Etes vous sûr de vouloir supprimer le filom '.$film->getTitre_film().' ? </h1>';
		echo '<img width=100 height=150 alt="'.$film->getId_film().'" src="Illustrations/Film/'.$film->getId_film().'.png">';
		echo '<br/><input type="hidden" name="id" value="'.$_GET['id'].'">';
        echo '<button type="submit" name="Oui" > Oui </button>';
        echo '<button type="submit" name="Annuler" > Annuler </button>';
    }
