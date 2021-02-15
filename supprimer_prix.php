<?php
$titre = "Supprimer un prix";
include 'debutSkelXhtml.php';
include 'Prix.php';

echo '<form action="supprimer_prix.php" method="get" >';
if(isset($_GET['Oui'])) {
    if (!empty($_GET['id'])) {
        if (is_numeric($_GET['id'])) {
            $prix = Prix::initPrix(intval($_GET['id']));
            $prix->delete();
            echo '<meta http-equiv="refresh" content="0;URL=page_prix.php" />';
        }
    }
}else if(isset($_GET['Annuler'])){
    echo  '<meta http-equiv="refresh" content="0;URL=page_prix.php" />';
}
else {
	$prix = Prix::initPrix($_GET['id']);
	echo '<h1> Etes vous sûr de vouloir supprimer le prix '.$prix->getnom_prix().' ? </h1>';
	echo '<img width=100 height=150 alt="'.$prix->getid_prix().'" src="Illustrations/Prix/'.$prix->getid_prix().'.png">';
	echo '<br/><input type="hidden" name="id" value="'.$_GET['id'].'">';
    echo '<button type="submit" name="Oui" > Oui </button>';
    echo '<button type="submit" name="Annuler" > Annuler </button>';
}
