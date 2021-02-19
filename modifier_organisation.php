<?php
$titre = "Modification d'une organisation";
include 'debutSkelXhtml.php';
include 'Organisation.php';

echo '<form action="modifier_organisation.php" method="get" >';
$organisation = Organisation::initOrganisation(intval($_GET['id']));

if(isset ($_GET['nom'])){
	$organisation = Organisation::initOrganisation($_GET['id']);
	$organisation->setNouveau(false);
	$organisation->settype_organisation($_GET['type']);
	$organisation->setnom_organisation($_GET['nom']);
	$organisation->save();
	echo  '<meta http-equiv="refresh" content="0;URL=page_organisation.php" />';
} else {
	$organisationAll = Organisation::getAll();
	echo '<h1>Modification d\'une Organisation</h1>';
	echo '<p><br/>';
	echo 'Nom de l\'organisation : <input type="text" name="nom" value="' . $organisation->getnom_organisation() . '" size=50 required>';
	echo '<br/>';
	echo 'Type de l\'organisation : ';

	$combobox  = '<select name="type">';
	$combobox .= '<option value="Académie">Académie</option>';
	$combobox .= '<option value="Associations">Associations</option>';
	$combobox .= '<option value="Média">Média</option>';
	$combobox .= '<option value="Festival">Festival</option></select>';
	echo $combobox;

	echo '</br>';
	echo '<input type="hidden" name="id" value="'.$organisation->getid_organisation().'">';

	echo '<button type="submit" name="valider" > Valider </button>';
	echo '<button type="reset" name="annuler"  > Effacer </button>';
	echo '<br/><a href="page_prix.php"         > Retour à la liste des prix</a>';
}
include 'finKtml.html';
?>