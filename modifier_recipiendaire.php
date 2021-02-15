<?php
$titre = "Modification d'un recipiendaire";
include 'debutSkelXhtml.php';
include 'Recipiendaire.php';
include 'Prix.php';
include 'Ceremonie.php';
include 'Concerne.php';
include 'Nomination.php';
include 'Categorie.php';
include 'Film.php';

echo '<form action="modifier_recipiendaire.php" method="get" >';
$recipiendaire = Recipiendaire::initRecipiendaire(intval($_GET['id']));
$concerne = Concerne::initConcerne_recipiendaire($recipiendaire->getid_recipiendaire());
$nomination = Nomination::initNomination($concerne->getid_nomination());
$categorie = Categorie::initCategorie($nomination->getid_categorie());
$prix = Prix::initPrix($categorie->getid_prix());
$ceremonie = Ceremonie::initCeremonie($nomination->getid_ceremonie());
if(isset ($_GET['nom'])){
	$recipiendaire = Recipiendaire::initRecipiendaire($_GET['id']);
	$concerne = Concerne::initConcerne_recipiendaire($recipiendaire->getid_recipiendaire());
	$nomination = Nomination::initNomination($concerne->getid_nomination());
	$categorie = Categorie::initCategorie($nomination->getid_categorie());
	$prix = Prix::initPrix($categorie->getid_prix());
	$ceremonie = Ceremonie::initCeremonie($nomination->getid_ceremonie());

	$recipiendaire->setNouveau(false);
	$recipiendaire->setnom_recipiendaire($_GET['nom']);
	$recipiendaire->setprenom_recipiendaire($_GET['prenom']);
	$recipiendaire->save();


	//echo  '<meta http-equiv="refresh" content="0;URL=page_recipiendaire.php" />';
} else {
	$prixAll = Prix::getAll();
	$ceremonieAll = Ceremonie::getAll();
	$filmAll = Film::getAll();
	echo '<h1>Modification d\'un recipiendaire</h1>';
	echo '<p><br/>';
	echo 'Nom : <input type="text" name="nom" value="'.$recipiendaire->getnom_recipiendaire().'" size=50 required>';
	echo '<br/>';
	echo 'Prenom : <input type="text" name="prenom" value="'.$recipiendaire->getprenom_recipiendaire().'" size=50 required>';
	echo '<br/>';
	echo 'Ceremonie Participée : /!\ Non relié';
	$combobox = '<select name="ceremonie">';
	for($i = 0; $i < sizeof($ceremonieAll); $i++) {
		$combobox .= '<option value="'.$ceremonieAll[$i]->getid_ceremonie().'">'.$ceremonieAll[$i]->getnom_ceremonie().'</option>';
	}
	$combobox .= '</select>';
	echo $combobox;
	echo '<br/>';
	echo 'Prix gagné : /!\ Non relié';
	$combobox = '<select name="prix">';
	for($i = 0; $i < sizeof($prixAll); $i++) {
		$combobox .= '<option value="'.$prixAll[$i]->getid_prix().'">'.$prixAll[$i]->getnom_prix().'</option>';
	}
	$combobox .= '</select>';
	echo $combobox;
	echo '<br/>';
	echo 'Film gagné : /!\ Non relié';
	$combobox = '<select name="film">';
	for($i = 0; $i < sizeof($filmAll); $i++) {
		$combobox .= '<option value="'.$filmAll[$i]->getId_film().'">'.$filmAll[$i]->getTitre_film().'</option>';
	}
	$combobox .= '</select>';
	echo $combobox;
	echo '<br/>';
	echo '<input type="hidden" name="id" value="'.$recipiendaire->getid_recipiendaire().'">';
	echo '<button type="submit" name="valider" > Valider </button>';
	echo '<button type="reset" name="annuler"> Effacer </button>';
	echo '<br/><a href="page_recipiendaire.php">Retour à la liste des récipiendaires</a>';
}
include 'finKtml.html';
?>