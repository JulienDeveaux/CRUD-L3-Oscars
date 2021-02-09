<?php
    $titre = "Ajouter un film";
    include 'debutSkelXhtml.php';
    include 'Film.php';

    echo '<form action="ajout_film.php" method="get" >';
    $film = Film::initFilm(1);
    $idFilmMax =  $film->getNbFilms();
    if(isset($idFilmMax)) {
        $idFilmMax++;
    }
    if(isset ($_GET['titre_film'])){
        $film = Film::initFilm(1);
        $film->setId_film($idFilmMax + 1);
        $film->setNouveau(true);
        $film->setTitre_film($_GET['titre_film']);
        $film->setTitre_original($_GET['titre_original']);
        $film->save();
        //echo $film;
       echo  '<meta http-equiv="refresh" content="0;URL=page_film.php" />';
    } else {
        echo '<h1>Ajout d\'un film</h1>';
        echo '<p><br/>';
        echo 'Titre original : <input type="text" name="titre_original" size=50 required>';
        echo '<br/>';
        echo '<p><br/>';
        echo 'Titre : <input type="text" name="titre_film" size=50 required>';
        echo '<br/>';

        echo '<button type="submit" name="valider" > Valider </button>';
        echo '<button type="reset" name="annuler"> Effacer </button>';
        echo '<br/><a href="page_film.php">Retour à la liste des films</a>';
    }
    include  'finKtml.html';
    ?>