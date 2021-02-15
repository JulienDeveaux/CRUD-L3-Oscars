<?php
$titre = "Supprimer un recipiendaire";
include 'debutSkelXhtml.php';
include 'Recipiendaire.php';

echo '<form action="supprimer_recipiendaire.php" method="get" >';
if(!empty($_GET['id'])) {
	if (is_numeric($_GET['id'])) {
		$recipiendaire = Recipiendaire::initRecipiendaire(intval($_GET['id']));
		$recipiendaire->delete();
		echo  '<meta http-equiv="refresh" content="0;URL=page_recipiendaire.php" />';
	}
}