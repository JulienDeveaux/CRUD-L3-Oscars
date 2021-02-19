<?php
$titre = "Modification d'un prix";
include 'debutSkelXhtml.php';
include 'Prix.php';
include 'Organisation.php';

echo '<form action="modifier_prix.php" method="get" >';
$prix = Prix::initPrix(intval($_GET['id']));

if(isset ($_GET['nom_prix'])){
	$prix = Prix::initPrix($_GET['id']);
	$organisation = Organisation::initOrganisation($_GET['ComboBox']);
	$prix->setid_organisation($organisation->getid_organisation());
	$prix->setNouveau(false);
	$prix->setnom_prix($_GET['nom_prix']);
	$prix->save();
	echo  '<meta http-equiv="refresh" content="0;URL=page_prix.php" />';
} else {
	$organisation = Organisation::getAll();
	echo '<h1>Modification d\'un prix</h1>';
	echo '<p><br/>';
	echo 'Nom du prix : <input type="text" name="nom_prix" value="' . $prix->getnom_prix() . '" size=50 required>';
	echo '<br/>';
	echo 'Organisation du prix :';

	$combobox = '<select name="ComboBox">';
	for($i = 0; $i < sizeof($organisation); $i++) {
		$combobox .= '<option value="'
            .$organisation[$i]->getid_organisation().'">'
            .$organisation[$i]->getnom_organisation().'</option>';
	}
	$combobox .= '</select>';
	echo $combobox;

	echo '<br/>';
	echo '<input type="hidden" name="id" value="'.$prix->getid_prix().'">';

	echo '<button type="submit" name="valider" > Valider </button>';
	echo '<button type="reset" name="annuler"  > Effacer </button>';
	echo '<br/><a href="page_prix.php"         > Retour à la liste des prix</a>';
}
include 'finKtml.html';
?>