<?php
	$titre= "Detail Prix";
	include 'debutSkelXhtml.php';
	include 'Prix.php';
	include 'Ceremonie.php';
	if(!empty($_GET['id'])){
		if(is_numeric($_GET['id'])){
			$prix = Prix::initPrix(intval($_GET['id']));
			if(!empty($prix)){
				$albums = Ceremonie::initCeremonie($prix->getid_prix());
				echo '<h1>'.$prix->getnom_prix().'</h1>';
				echo '<img width=100 height=150 alt="'.$prix->getid_prix().'" src="Illustrations/Prix/'.$prix->getid_prix().'.png">';
				//echo '<p>'.$prix['clan'].'</p>';
				echo '</br>';
				echo '<h1> A été organisé à : '.$albums->getnom_ceremonie().'</h1>';

				if(!empty($albums)){
					echo '<ul>';
					$lien = '';
					$lien .= '<li><a href="detail_ceremonie.php?id='.$albums->getid_ceremonie().'"><img width=70 height=70 alt="'.$albums->getnom_ceremonie().'" src="Illustrations/Ceremonie/'.$albums->getid_ceremonie().'.png"></a>'.$albums->getnom_ceremonie().' </li>';
					echo $lien;
				}
			}		
		} else {
			// Erreur : id incorrecte renseigné dans l'url : cas non atteint en navigation normale sur le site
			echo '<p class="erreur">Erreur : id invalide </p>';
		}
	} else {
		// Erreur : id non renseigné dans l'url : cas non atteind en navigation normale sur le site
		echo '<p class="erreur">Erreur : id non renseigne </p>';
	} 
	echo '<a href="page_prix.php">Retour</a>';
    include 'finKtml.html';
?>