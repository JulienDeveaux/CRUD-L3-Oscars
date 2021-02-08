<?php
    $titre = "Ajouter un film";
    include 'debutSkelXhtml.php';
    include 'Film.php';

    echo '<form action="ajout_film.php" method="get" >';
    if(isset ($_GET['titre_film'])){
        $film = Film::getAll();
        $film->save();
      //  echo  '<meta http-equiv="refresh" content="0;URL=page_film.php" />';
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