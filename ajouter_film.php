<?php
$titre = "Ajouter un film";
include 'debutSkelXhtml.php';
include 'Film.php';
include 'Recipiendaire.php';
include 'Concerne.php';

echo '<form action="ajouter_film.php" method="get" >';
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

    $concerne = Concerne::initConcerne_recipiendaire($_GET['reci']);
    $concerne->setid_film($film->getId_film());

    //$concerne->save();
    $film->save();
    echo $concerne;
    echo $film;
    echo  '<meta http-equiv="refresh" content="0;URL=page_film.php" />';
} else {
    echo '<h1>Ajout d\'un film</h1>';
    echo '<p><br/>';
    echo 'Titre : <input type="text" name="titre_film" size=50 required>';
    echo '<br/>';
    echo 'Titre original : <input type="text" name="titre_original" size=50 required>';
    echo '<br/>';
    echo 'Récipiendaire qui à réalisé ce film :';
    $recipiendaireAll = Recipiendaire::getAll();
    $comboBox = '<select name="reci">';
    for($i = 0; $i < sizeof($recipiendaireAll); $i++) {
        $comboBox .= '<option value="'.$recipiendaireAll[$i]->getid_recipiendaire().'">'.$recipiendaireAll[$i]->getnom_recipiendaire().' '.$recipiendaireAll[$i]->getprenom_recipiendaire().'</option>';
    }
    $comboBox .= '</select>';
    echo $comboBox;
    echo '<br/>';

    echo '<button type="submit" name="valider" > Valider </button>';
    echo '<button type="reset" name="annuler"> Effacer </button>';
    echo '<br/><a href="page_film.php">Retour à la liste des films</a>';
}
include  'finKtml.html';
?>