<?php
$titre= "Detail Ceremonie";
include 'debutSkelXhtml.php';
include 'Prix.php';
include 'Ceremonie.php';
include 'Film.php';
include 'Recipiendaire.php';
include 'Nomination.php';
include 'Concerne.php';

if(!empty($_GET['id'])){
    if(is_numeric($_GET['id'])){
        $film = Film::initFilm(intval($_GET['id']));
        if(!empty($film)) {
            try {
                echo '<h1>Titre : ' . $film->gettitre_film() . '</h1>';
                echo '<h2>Titre original : ' . $film->gettitre_original() . '</h2>';
                $concerne = Concerne::initConcerne_film($film->getid_film());
                $nomination = Nomination::initNomination($concerne->getid_nomination());
                $ceremonie = Ceremonie::initCeremonie($nomination->getid_ceremonie());
                $recipiendaire = Recipiendaire::initRecipiendaire($concerne->getid_recipiendaire());
                echo '<h1>Par : ' . $recipiendaire->getnom_recipiendaire() . ' ' . $recipiendaire->getprenom_recipiendaire() . '</h1>';
                if ($nomination->getgagnante_nomination() == true) {
                    echo '<h1>Récompensé par ' . $ceremonie->getnom_ceremonie() . ' le ' . $ceremonie->getdate_ceremonie() . ' à ' . $ceremonie->getlieu_ceremonie() . '</h1>';
                } else {
                    echo '<h1>A particité à ' . $ceremonie->getnom_ceremonie() . ' le ' . $ceremonie->getdate_ceremonie() . ' à ' . $ceremonie->getlieu_ceremonie() . '</h1>';
                }
                echo '<img width=100 height=150 alt="' . $film->getId_film() . '" src="Illustrations/Film/' . $film->getId_film() . '.png">';
                echo '</br>';
            } catch (Exception $e) {
                echo '<h1>Par : inconnu</h1>';
                echo '<img width=100 height=150 alt="' . $film->getId_film() . '" src="Illustrations/Film/' . $film->getId_film() . '.png">';
                echo '</br>';
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
echo '<a href="page_film.php">Retour</a>';
include 'finKtml.html';
?>