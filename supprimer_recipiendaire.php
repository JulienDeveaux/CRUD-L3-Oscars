<?php
$titre = "Supprimer un recipiendaire";
include 'debutSkelXhtml.php';
include 'Recipiendaire.php';

echo '<form action="supprimer_recipiendaire.php" method="get" >';
if(isset($_GET['Oui'])) {
    if (!empty($_GET['id'])) {
        if (is_numeric($_GET['id'])) {
            $recipiendaire = Recipiendaire::initRecipiendaire(intval($_GET['id']));
            $recipiendaire->delete();
            echo '<meta http-equiv="refresh" content="0;URL=page_recipiendaire.php" />';
        }
    }
}else if(isset($_GET['Annuler'])){
    echo  '<meta http-equiv="refresh" content="0;URL=page_recipiendaire.php" />';
}else {
	$recipiendaire = Recipiendaire::initRecipiendaire($_GET['id']);
    echo '<h1> Etes vous sûr de vouloir supprimer '.$recipiendaire->getnom_recipiendaire().' '.$recipiendaire->getprenom_recipiendaire().' ? </h1>';
	echo '<img width=100 height=150 alt="'.$recipiendaire->getid_recipiendaire().'" src="Illustrations/Recipiendaire/'.$recipiendaire->getid_recipiendaire().'.png">';
    echo '<br/><input type="hidden" name="id" value="'.$_GET['id'].'">';
    echo '<button type="submit" name="Oui" > Oui </button>';
    echo '<button type="submit" name="Annuler" > Annuler </button>';
}
