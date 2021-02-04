<?php
	$titre= "Detail Ceremonie";
	include 'debutSkelXhtml.php';
	include 'Prix.php';
	include 'Ceremonie.php';
	if(!empty($_GET['id'])){
		if(is_numeric($_GET['id'])){
			$ceremonie = Ceremonie::initCeremonie(intval($_GET['id']));
			echo $ceremonie;
			if(!empty($ceremonie)){
				$prix = Prix::initPrix($ceremonie->getid_prix());
				echo $prix;
				echo '<h1>'.$ceremonie->getnom_ceremonie().'</h1>';
				echo '<img width=100 height=150 alt="'.$ceremonie->getid_ceremonie().'" src="Illustrations/Ceremonie/'.$ceremonie->getid_ceremonie().'.png">';
				echo '</br>';
				echo '<h1> A organisé: <a href="detail_prix.php?id='.$prix->getid_prix().'">'.$prix->getnom_prix().'</a> le '.$ceremonie->getdate_ceremonie().' à '.$ceremonie->getlieu_ceremonie().'</h1>';

				if(!empty($albums)){
					echo '<ul>';
					$lien = '';
					foreach ($albums as $key => $album) {
						echo $album;
						echo $albums;
						$lien .= '<li><a href="detail_ceremonie.php?id='.$albums->getid_ceremonie().'"><img width=70 height=70 alt="'.$albums->getnom_ceremonie().'" src="Illustrations/Ceremonie/'.$albums->getid_ceremonie().'.png"></a>'.$albums->getnom_ceremonie().' </li>';
					}
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
	echo '<a href="page_ceremonie.php">Retour</a>';
    include 'finKtml.html';
?>