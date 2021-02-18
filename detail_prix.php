<?php
	$titre= "Detail Prix";
	include 'debutSkelXhtml.php';
	include 'Prix.php';
	include 'Ceremonie.php';
	include 'Organisation.php';
	include 'Categorie.php';
	include 'Nomination.php';
	include 'Concerne.php';
	include 'Recipiendaire.php';

	if(!empty($_GET['id'])){
		if(is_numeric($_GET['id'])){
			$prix = Prix::initPrix(intval($_GET['id']));
			if(!empty($prix)){
			    $chararray = str_split($prix->getnom_prix());
			    for($i = 4; $i < sizeof($chararray); $i++) {
			        $chararray[$i] = '';
                }
			    $string = implode($chararray);
				$ceremonie = Ceremonie::getCeremonieByNom($string);
				echo '<h1>'.$prix->getnom_prix().'</h1>';
				echo '<img width=100 height=150 alt="'.$prix->getid_prix().'" src="Illustrations/Prix/'.$prix->getid_prix().'.png">';
				echo '</br>';
				echo '<h1> Cérémonies de ce prix :</h1>';

				if(!empty($ceremonie)){
                    echo '<ul>';
                    $lien = '';
				    for($i = 0; $i < sizeof($ceremonie); $i++) {
                        $lien .= '<li><a href="detail_ceremonie.php?id='.$ceremonie[$i]->getid_ceremonie().'"><img width=70 height=70 alt="'.$ceremonie[$i]->getnom_ceremonie().'" src="Illustrations/Ceremonie/'.$ceremonie[$i]->getid_ceremonie().'.png"></a>'.$ceremonie[$i]->getnom_ceremonie().' </li>';
                    }
					$lien .= '</ul>';
					echo $lien;
				} else {
				    echo '<h1><font color=orange>Aucune cérémonie pour ce prix</font></h1>';
                }
                try {
                    $organisation = Organisation::initOrganisation($prix->getid_organisation());
				    echo '<h1>Organisation : '.$organisation->getnom_organisation().'</h1>';
				    echo '<h2>Type de l\'organisation : '.$organisation->gettype_organisation().'</h2>';
                } catch (Exception $e) {
				    echo '<h1><font color=orange>Aucune Organisation pour ce Prix trouvé</font></h1>';
                }

				echo '<h1>Récipiendaires qui ont obtenus ce prix : </h1>';
				$recipiendaire = Recipiendaire::getRecipiendaireListPrix($prix->getid_prix());
                $lien = '<ul>';
				for($i = 0; $i < sizeof($recipiendaire); $i++) {
				    $lien .= '<li><a href="detail_recipiendaire.php?id='.$recipiendaire[$i]->getid_recipiendaire().'"><img width=70 height=70 alt="'.$recipiendaire[$i]->getnom_recipiendaire().'" src="Illustrations/Recipiendaire/'.$recipiendaire[$i]->getid_recipiendaire().'.png"></a> '.$recipiendaire[$i]->getnom_recipiendaire().' '.$recipiendaire[$i]->getprenom_recipiendaire().'</li>';
                }
				$lien .= '</ul>';
				echo $lien;
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