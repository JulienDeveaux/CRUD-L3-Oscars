<?php
$titre= "Detail Organisation";
include 'debutSkelXhtml.php';
include 'Organisation.php';

if(!empty($_GET['id'])){
	if(is_numeric($_GET['id'])){
		$organisation = Organisation::initOrganisation(intval($_GET['id']));
		if(!empty($organisation)){
			echo '<h1>'.$organisation->getnom_organisation().'</h1>';
			echo '<img width=100 height=150 alt="'.$organisation->getid_organisation().'" src="Illustrations/Organisation/'.$organisation->getid_organisation().'.png">';
			echo '</br>';
			echo '<h1> Type de l\'organisation : '.$organisation->gettype_organisation().'</h1>';
			}
	} else {
		// Erreur : id incorrecte renseigné dans l'url : cas non atteint en navigation normale sur le site
		echo '<p class="erreur">Erreur : id invalide </p>';
	}
} else {
	// Erreur : id non renseigné dans l'url : cas non atteind en navigation normale sur le site
	echo '<p class="erreur">Erreur : id non renseigne </p>';
}
echo '<a href="page_organisation.php">Retour</a>';
include 'finKtml.html';
?>