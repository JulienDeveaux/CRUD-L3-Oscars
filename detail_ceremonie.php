<?php
	$titre= "Detail Ceremonie";
	include 'debutSkelXhtml.php';
	include 'Ceremonie.php';
	include 'Prix.php';
	include 'Organisation.php';
	include 'Categorie.php';
	include 'Film.php';
	include 'Nomination.php';
	include 'Concerne.php';
	include 'Recipiendaire.php';

	if(!empty($_GET['id'])){
		if(is_numeric($_GET['id'])){
			$ceremonie = Ceremonie::initCeremonie(intval($_GET['id']));
			if(!empty($ceremonie)){
				$prix = Prix::initPrix($ceremonie->getid_prix());
                $categorie = Categorie::initCategorie_prix($prix->getid_prix());
                $nomination = Nomination::initNomination_categorie($categorie->getid_categorie());
                $concerne = Concerne::initConcerne_nomination($nomination->getid_nomination());
                $film = Film::initFilm($concerne->getid_film());
                $recipiendaire = Recipiendaire::initRecipiendaire($concerne->getid_recipiendaire());
				if(is_int($prix->getid_organisation())) {
                    $organisation = Organisation::initOrganisation($prix->getid_organisation());
                    echo '<h1>' . $ceremonie->getnom_ceremonie() . '</h1>';
                    echo '<img width=100 height=150 alt="' . $ceremonie->getid_ceremonie() . '" src="Illustrations/Ceremonie/' . $ceremonie->getid_ceremonie() . '.png">';
                    echo '</br>';
                    echo '<h1> A organisé: <a href="detail_prix.php?id=' . $prix->getid_prix() . '">' . $prix->getnom_prix() . '</a> le ' . $ceremonie->getdate_ceremonie() . ' à ' . $ceremonie->getlieu_ceremonie() . '</h1>';
                    echo '<h1> Organisation de cette cérémonie : ' . $organisation->getnom_organisation() . ' de type ' . $organisation->gettype_organisation() . '</h1>';
                    echo '<h1>Récipiendaire nominé : '.$recipiendaire->getnom_recipiendaire().' '.$recipiendaire->getprenom_recipiendaire().'</h1>';
                    echo '<h2>Dans la catégorie '.$categorie->gettitre_categorie().'</h2>';
                    echo '<h2>Pour le film '.$film->getTitre_film().'</h2>';
                    echo '<h2>Contribution : '.$concerne->getnom_contribution().'</h2>';
                } else {
                    echo '<h1>'.$ceremonie->getnom_ceremonie().'</h1>';
                    echo '<img width=100 height=150 alt="' . $ceremonie->getid_ceremonie() . '" src="Illustrations/Ceremonie/' . $ceremonie->getid_ceremonie() . '.png">';
                    echo '</br>';
                    echo '<h1> A organisé: <a href="detail_prix.php?id=' . $prix->getid_prix() . '">' . $prix->getnom_prix() . '</a> le ' . $ceremonie->getdate_ceremonie() . ' à ' . $ceremonie->getlieu_ceremonie() . '</h1>';
                    echo '<h1>Récipiendaire nominé : <a href="detail_recipiendaire.php?id='.$recipiendaire->getid_recipiendaire().'">'.$recipiendaire->getnom_recipiendaire().' '.$recipiendaire->getprenom_recipiendaire().'</a></h1>';
                    echo '<h2>Dans la catégorie '.$categorie->gettitre_categorie().'</h2>';
                    echo '<h2>Pour le film <a href="detail_film.php?id='.$film->getId_film().'">'.$film->getTitre_film().'</a></h2>';
                    echo '<h2>Contribution : '.$concerne->getnom_contribution().'</h2>';
                    echo '<h3><font color=red>Aucune organisation associée au prix de cette cérémonie</font></h3>';
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