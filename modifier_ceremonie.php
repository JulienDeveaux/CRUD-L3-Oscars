<?php
$titre = "Modification d'une cérémonie";
include 'debutSkelXhtml.php';
include 'Ceremonie.php';

echo '<form action="modifier_ceremonie.php" method="get" >';
$ceremonie = Ceremonie::initCeremonie(intval($_GET['id']));
if(isset ($_GET['nom'])){
	$ceremonie = Ceremonie::initCeremonie($_GET['id']);
	$ceremonie->setdate_ceremonie($_GET['date']);
	$ceremonie->setlieu_ceremonie($_GET['lieu']);
	$ceremonie->setnom_ceremonie($_GET['nom']);
	$ceremonie->setNouveau(false);
	$ceremonie->save();
	echo  '<meta http-equiv="refresh" content="0;URL=page_ceremonie.php" />';
} else {
	echo '<h1>Modification d\'une cérémonie</h1>';
	echo '<p><br/>';
	echo 'Nom de la ceremonie : <input type="text" name="nom" value="'.$ceremonie->getnom_ceremonie().'" size=50 required>';
	echo '<br/>';
	echo 'Lieu de la ceremonie : <input type="text" name="lieu" value="'.$ceremonie->getlieu_ceremonie().'" size="50" required>';
	echo '<br/>';
	echo 'Date de la ceremonie : <input type="date" name="date" value="'.$ceremonie->getdate_ceremonie().'" max="'. date("Y-m-d").'" size="50" required>';
	echo '<br/>';
	echo '<input type="hidden" name="id" value="'.$ceremonie->getid_ceremonie().'">';
	echo '<button type="submit" name="valider" > Valider </button>';
	echo '<button type="reset" name="annuler"> Effacer </button>';
	echo '<br/><a href="page_ceremonie.php">Retour à la liste des cérémonies</a></p>';
}
include 'finKtml.html';
?>