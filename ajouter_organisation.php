<?php
$titre = "Ajouter une Organisation";
include 'debutSkelXhtml.php';
include 'Organisation.php';

echo '<form action="ajouter_organisation.php" method="get" >';
$organisation = Organisation::initOrganisation(1);
$idOrgaMax =  $organisation->getNbOrganisation();
if(isset($idOrgaMax)) {
	$idOrgaMax++;
}
if(isset ($_GET['nom'])){
	$organisation = Organisation::initOrganisation(1);
	$organisation->setid_organisation($idOrgaMax + 1);
	$organisation->setNouveau(true);
	$organisation->setnom_organisation($_GET['nom']);
	$organisation->settype_organisation($_GET['type']);
	$organisation->save();
	echo  '<meta http-equiv="refresh" content="0;URL=page_organisation.php" />';
} else {
	echo '<h1>Ajout d\'une organisation</h1>';
	echo '<p><br/>';
	echo 'Nom de l\'organisation : <input type="text" name="nom" size=50 required>';
	echo '<br/>';
	echo '<p><br/>';
	echo 'Type de l\'organisation : ';
	$combobox = '<select name="type">';
	$combobox .= '<option value="Académie">Académie</option>';
	$combobox .= '<option value="Associations">Associations</option>';
	$combobox .= '<option value="Média">Média</option>';
	$combobox .= '<option value="Festival">Festival</option></select>';
	echo $combobox;
	echo '<br/>';

	echo '<button type="submit" name="valider" > Valider </button>';
	echo '<button type="reset" name="annuler"> Effacer </button>';
	echo '<br/><a href="page_organisation.php">Retour à la liste des organisations</a>';
}
include  'finKtml.html';
?>