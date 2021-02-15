<?php
$titre = "Supprimer une organisation";
include 'debutSkelXhtml.php';
include 'Organisation.php';

echo '<form action="supprimer_organisation.php" method="get" >';
if(isset($_GET['Oui'])) {
    if (!empty($_GET['id'])) {
        if (is_numeric($_GET['id'])) {
            $organisation = Organisation::initOrganisation(intval($_GET['id']));
            $organisation->delete();
            echo '<meta http-equiv="refresh" content="0;URL=page_organisation.php" />';
        }
    }
}else if(isset($_GET['Annuler'])){
    echo  '<meta http-equiv="refresh" content="0;URL=page_organisation.php" />';
}
else {
	$organisation = Organisation::initOrganisation($_GET['id']);
	echo '<h1> Etes vous sûr de vouloir supprimer l\'organisation '.$organisation->getnom_organisation().' ? </h1>';
	echo '<img width=100 height=150 alt="'.$organisation->getid_organisation().'" src="Illustrations/Organisation/'.$organisation->getid_organisation().'.png">';
	echo '<br/><input type="hidden" name="id" value="'.$_GET['id'].'">';
    echo '<button type="submit" name="Oui" > Oui </button>';
    echo '<button type="submit" name="Annuler" > Annuler </button>';
}

