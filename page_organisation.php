<?php
$titre="Organisation";
include 'debutSkelXhtml.php';
include 'Organisation.php';
echo'<a href="index.php"> Retour accueil</a>';
$organisation = Organisation::getAll();
if(!empty($organisation)){
	echo '<br/><a href="ajouter_organisation.php">Ajouter une organisation</a>';
	echo("<table>");
	$nomColonnesFait = false;
	foreach ($organisation as $key => $organisation) {
		if(!$nomColonnesFait){
			echo "<tr>";
			echo "<th>Prix</th>";
			foreach ($organisation as $key => $value) {
				echo "<th>$key</th>";
			}
			echo "<th>Nom</th>";
			echo "<th>Action</th>";
			$nomColonnesFait = true;
		}
		echo "<tr>";
		echo '<td><img width=70 height=70 alt="'.$organisation->getid_organisation().'" src="Illustrations/Organisation/'.$organisation->getid_organisation().'.png"></td>';
		echo "<td>".$organisation->getnom_organisation()."</td>";
		echo '<td>';
		echo '<a class="bouton_sup" href="supprimer_organisation.php?id='.$organisation->getid_organisation().'">Supprimer</a>';
		echo '<a class="bouton_mod" href="modifier_organisation.php?id='.$organisation->getid_organisation().'">Modifier</a>';
		echo '<a class="bouton_det" href="detail_organisation.php?id='.$organisation->getid_organisation().'">Detail</a>';
		echo '</td>';
		echo '</tr>';
	}
	echo("</table>");
} else {
	echo 'pas de prix';
}
include 'finKtml.html';
?>
