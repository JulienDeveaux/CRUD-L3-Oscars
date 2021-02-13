<?php
	$titre= "Detail Recipiendaire";
	include 'debutSkelXhtml.php';
	include 'Recipiendaire.php';
	include 'Prix.php';
	include 'Ceremonie.php';
	include 'Concerne.php';
	include 'Nomination.php';
	include 'Categorie.php';
	if(!empty($_GET['id'])){
		if(is_numeric($_GET['id'])){
			$recipiendaire = Recipiendaire::initRecipiendaire(intval($_GET['id']));
			if(!empty($recipiendaire)){
				$concerne = Concerne::initConcerne_recipiendaire($recipiendaire->getid_recipiendaire());
				$nomination = Nomination::initNomination(($concerne->getid_nomination()));
				$ceremonie = Ceremonie::initCeremonie($nomination->getid_ceremonie());
				echo $concerne;
				echo $nomination;
				echo $ceremonie;
				echo '<h1>'.$recipiendaire->getnom_recipiendaire().' '.$recipiendaire->getprenom_recipiendaire().'</h1>';
				echo '<img width=100 height=150 alt="'.$recipiendaire->getid_recipiendaire().'" src="Illustrations/Recipiendaire/'.$recipiendaire->getid_recipiendaire().'.png">';
				echo '</br>';
				echo '<h1> A été participé à : </h1>';

				if(!empty($ceremonie)){
					echo '<ul>';
					$lien = '';
					$lien .= '<li><a href="detail_ceremonie.php?id='.$ceremonie->getid_ceremonie().'"><img width=70 height=70 alt="'.$ceremonie->getnom_ceremonie().'" src="Illustrations/Ceremonie/'.$ceremonie->getid_ceremonie().'.png"></a>'.$ceremonie->getnom_ceremonie().' </li>';
					echo $lien;
					echo '</ul>';
				}
				if($nomination->getgagnante_nomination() == true) {
					$categorie = Categorie::initCategorie_prix($nomination->getid_categorie());
					echo $categorie;
					$prix = Prix::initPrix($categorie->getid_prix());
					echo $prix;
					echo '<h1>Prix gagné(s) : <h1>';
					if(!empty($prix)){
						echo '<ul>';
						$lien = '';
						$lien .= '<li><a href="detail_prix.php?id='.$prix->getid_prix().'"><img width=70 height=70 alt="'.$prix->getnom_prix().'" src="Illustrations/Prix/'.$prix->getid_prix().'.png"></a>'.$prix->getnom_prix().' </li>';
						echo $lien;
						echo '</ul>';
					}
				} else {
					echo '<h1>Aucun Prix gagné<h1>';
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