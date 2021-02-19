<?php
$titre = "Supprimer un film";
include 'debutSkelXhtml.php';
include 'Film.php';

echo '<form action="supprimer_film.php" method="get" >';
if(isset($_GET['Oui'])) {

    if (!empty($_GET['id'])) {

        if (is_numeric($_GET['id'])) {

            try {
                $film = Film::initFilm(intval($_GET['id']));
                $film->delete();
                echo '<meta http-equiv="refresh" content="0;URL=page_film.php" />';
            } catch (PDOException $e) {
                echo '<h2>La structure de notre base de donnée de nous permets pas de faire des supression en cascade nécéssaires pour supprimer un film qui est aussi dans concerne.</h2>';
                echo '<h2>La suppression de film ne marche donc que pour les films nouvellement ajoutés par notre site</h2>';
                echo '<br/><a href="page_film.php">Retour à la liste des films</a>';
            }
        }
    }
}else if(isset($_GET['Annuler'])){

    echo  '<meta http-equiv="refresh" content="0;URL=page_film.php" />';
}else {

    $film = Film::initFilm($_GET['id']);
    echo '<h1> Etes vous sûr de vouloir supprimer le film '.$film->getTitre_film().' ? </h1>';
    echo '<img width=100 height=150 alt="'.$film->getId_film().'" src="Illustrations/Film/'.$film->getId_film().'.png">';
    echo '<br/><input type="hidden" name="id" value="'.$_GET['id'].'">';
    echo '<button type="submit" name="Oui" > Oui </button>';
    echo '<button type="submit" name="Annuler" > Annuler </button>';
}
?>