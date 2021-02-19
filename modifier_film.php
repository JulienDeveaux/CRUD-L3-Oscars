<?php
$titre = "Modification d'un film";
include 'debutSkelXhtml.php';
include 'Film.php';

echo '<form action="modifier_film.php" method="get" >';
$film = Film::initFilm(intval($_GET['id']));

if(isset ($_GET['titre_film'])){
	$film = Film::initFilm($_GET['id']);
	$film->setNouveau(false);
	$film->setTitre_film($_GET['titre_film']);
	$film->setTitre_original($_GET['titre_original']);
	$film->save();
	echo  '<meta http-equiv="refresh" content="0;URL=page_film.php" />';
} else {
	echo '<h1>Modification d\'un film</h1>';
	echo '<p><br/>';
	echo 'Titre original : <input type="text" name="titre_original" value="'.$film->getTitre_original().'" size=50 required>';
	echo '<br/>';
	echo '<p><br/>';
	echo 'Titre : <input type="text" name="titre_film" value="'.$film->getTitre_film().'" size=50 required>';
	echo '<br/>';
	echo '<input type="hidden" name="id" value="'.$film->getId_film().'">';

	echo '<button type="submit" name="valider" > Valider </button>';
	echo '<button type="reset" name="annuler"  > Effacer </button>';
	echo '<br/><a href="page_film.php"         > Retour à la liste des films</a>';
}
include 'finKtml.html';
?>