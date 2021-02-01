<?php 

include 'fonction_album.php';
include 'fonction_prix.php';
include 'fonction_auteur.php';

function connexion() {
  $strConnex = "host=localhost dbname=util user=util password=utilpass";
  $ptrDB = pg_connect($strConnex);
  if(empty($ptrDB)){
    // Erreur : echec de la connexion a la BD
    echo '<p class="erreur">Erreur: echec de la connexion a la BD </p>';
    return NULL;
  } else return $ptrDB;
}
?>