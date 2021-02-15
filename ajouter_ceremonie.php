<?php
$titre = "Ajouter une Cérémonie";
include 'debutSkelXhtml.php';
include 'Ceremonie.php';

echo '<form action="ajouter_ceremonie.php" method="get" >';
$ceremonie = Ceremonie::initCeremonie(1);
$idCeremMax =  $ceremonie->getNbCeremonie();
if(isset($idCeremMax)) {
	$idCeremMax++;
}
if(isset ($_GET['nom'])){
	$ceremonie = Ceremonie::initCeremonie(1);
	$ceremonie->setid_ceremonie($idCeremMax + 1);
	$ceremonie->setNouveau(true);
	$ceremonie->setnom_ceremonie($_GET['nom']);
	$ceremonie->setlieu_ceremonie($_GET['lieu']);
	$ceremonie->setdate_ceremonie($_GET['date']);
	$ceremonie->save();
	echo  '<meta http-equiv="refresh" content="0;URL=page_ceremonie.php" />';
} else {
	echo '<h1>Création d\'une cérémonie</h1>';
	echo '<p><br/>';
	echo 'Nom de la ceremonie : <input type="text" name="nom" value="" size=50 required>';
	echo '<br/>';
	echo 'Lieu de la ceremonie : <input type="text" name="lieu" value="" size="50" required>';
	echo '<br/>';
	echo 'Date de la ceremonie : <input type="date" name="date" value="" max="'.date("Y-m-d").'" size="50" required>';
	echo '<br/>';

	echo '<button type="submit" name="valider" > Valider </button>';
	echo '<button type="reset" name="annuler"> Effacer </button>';
	echo '<br/><a href="page_ceremonie.php">Retour à la liste des Ceremonies</a>';
}
include  'finKtml.html';
?>