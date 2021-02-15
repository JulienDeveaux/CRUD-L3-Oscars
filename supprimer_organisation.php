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
    echo '<p> Etes vous sûr de vouloir supprimer ? </p>';
    echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
    echo '<button type="submit" name="Oui" > Oui </button>';
    echo '<button type="submit" name="Annuler" > Annuler </button>';
}

