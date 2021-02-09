<?php
$titre = "Ajouter un Prix";
include 'debutSkelXhtml.php';
include 'Prix.php';

echo '<form action="ajout_prix.php" method="get" >';
$prix = Prix::initPrix(1);
$idPrixMax =  $prix->getNbPrix();
if(isset($idPrixMax)) {
    $idPrixMax++;
}
if(isset ($_GET['nom_prix'])){
    $prix = Prix::initPrix(1);
    $prix->setid_prix($idPrixMax + 1);
    $prix->setNouveau(true);
    $prix->setnom_prix($_GET['nom_prix']);
    $prix->save();
    echo  '<meta http-equiv="refresh" content="0;URL=page_prix.php" />';
} else {
    echo '<h1>Ajout d\'un prix</h1>';
    echo '<p><br/>';
    echo 'Nom : <input type="text" name="nom_prix" size=50 required>';
    echo '<br/>';

    echo '<button type="submit" name="valider" > Valider </button>';
    echo '<button type="reset" name="annuler"> Effacer </button>';
    echo '<br/><a href="page_prix.php">Retour à la liste des Prix</a>';
}
include  'finKtml.html';
?>