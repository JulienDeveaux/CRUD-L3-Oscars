<?php
$titre = "Supprimer une organisation";
include 'debutSkelXhtml.php';
include 'Organisation.php';

echo '<form action="supprimer_organisation.php" method="get" >';
if(!empty($_GET['id'])) {
	if (is_numeric($_GET['id'])) {
		$organisation = Organisation::initOrganisation(intval($_GET['id']));
		$organisation->delete();
		echo  '<meta http-equiv="refresh" content="0;URL=page_organisation.php" />';
	}
}