<?php
$titre = "Ajouter un Prix";
include 'debutSkelXhtml.php';
include 'Prix.php';
include 'Organisation.php';

echo '<form action="ajouter_prix.php" method="get" >';
$prix = Prix::initPrix(1);
$idPrixMax =  $prix->getNbPrix();
if(isset($idPrixMax)) {
	$idPrixMax++;
}
if(isset ($_GET['nom'])){
	$prix = Prix::initPrix(1);
	$organisation = Organisation::initOrganisation(1);
	$prix->setid_prix($idPrixMax + 1);
	$prix->setNouveau(true);
	$prix->setnom_prix($_GET['nom']);
	$prix->setid_organisation($_GET['orga']);
	$prix->save();
	echo  '<meta http-equiv="refresh" content="0;URL=page_prix.php" />';
} else {
	echo '<h1>Ajout d\'un prix</h1>';
	echo '<p><br/>';
	echo 'Nom du prix : <input type="text" name="nom" size=50 required>';
	echo '<br/>';
	echo '<p><br/>';
	echo 'Organisation :';
	$orga = Organisation::getAll();
	$comboBox = '<select name="orga">';
	for($i = 0; $i < sizeof($orga); $i++) {
		$comboBox .= '<option value="'.$orga[$i]->getid_organisation().'">'.$orga[$i]->getnom_organisation().'</option>';
	echo $orga[$i]->getid_organisation();
	}
	$comboBox .= '</select>';
	echo $comboBox;
	echo '<br/>';

	echo '<button type="submit" name="valider" > Valider </button>';
	echo '<button type="reset" name="annuler"> Effacer </button>';
	echo '<br/><a href="page_prix.php">Retour à la liste des prix</a>';
}
include  'finKtml.html';
?>