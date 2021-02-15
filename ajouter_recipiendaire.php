<?php
$titre = "Ajouter un Recipiendaire";
include 'debutSkelXhtml.php';
include 'Recipiendaire.php';

echo '<form action="ajouter_recipiendaire.php" method="get" >';
$recipiendaire = Recipiendaire::initRecipiendaire(1);
$idRecipiendaireMax =  $recipiendaire->getNbRecipiendaire();
if(isset($idRecipiendaireMax)) {
	$idRecipiendaireMax++;
}
if(isset ($_GET['nom'])){
	$recipiendaire = Recipiendaire::initRecipiendaire(1);
	$recipiendaire->setid_recipiendaire($idRecipiendaireMax + 1);
	$recipiendaire->setNouveau(true);
	$recipiendaire->setnom_recipiendaire($_GET['nom']);
	$recipiendaire->setprenom_recipiendaire($_GET['prenom']);
	$recipiendaire->save();
	echo  '<meta http-equiv="refresh" content="0;URL=page_recipiendaire.php" />';
} else {
	echo '<h1>Ajout d\'un recipiendaire</h1>';
	echo '<p><br/>';
	echo 'Nom du récipiendaire : <input type="text" name="nom" size=50 required>';
	echo '<br/>';
	echo '<p><br/>';
	echo 'Prénom du récipiendaire : <input type="text" name="prenom" size=50 required>';
	echo '<br/>';

	echo '<button type="submit" name="valider" > Valider </button>';
	echo '<button type="reset" name="annuler"> Effacer </button>';
	echo '<br/><a href="page_recipiendaire.php">Retour à la liste des récipiendaires</a>';
}
include  'finKtml.html';
?>