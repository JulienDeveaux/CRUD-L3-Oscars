<?php
$titre = "Supprimer une cérémonie";
include 'debutSkelXhtml.php';
include 'Ceremonie.php';

echo '<form action="supprimer_ceremonie.php" method="get" >';
if(!empty($_GET['id'])) {
	if (is_numeric($_GET['id'])) {
		$ceremonie = Ceremonie::initCeremonie(intval($_GET['id']));
		$ceremonie->delete();
		echo  '<meta http-equiv="refresh" content="0;URL=page_ceremonie.php" />';
	}
}