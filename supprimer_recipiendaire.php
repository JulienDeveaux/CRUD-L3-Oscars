<?php
$titre = "Supprimer un recipiendaire";
include 'debutSkelXhtml.php';
include 'Recipiendaire.php';

echo '<form action="supprimer_recipiendaire.php" method="get" >';
if(isset($_GET['Oui'])) {
    if (!empty($_GET['id'])) {
        if (is_numeric($_GET['id'])) {
            $recipiendaire = Recipiendaire::initRecipiendaire(intval($_GET['id']));
            $recipiendaire->delete();
            echo '<meta http-equiv="refresh" content="0;URL=page_recipiendaire.php" />';
        }
    }
}else if(isset($_GET['Annuler'])){
    echo  '<meta http-equiv="refresh" content="0;URL=page_recipiendaire.php" />';
}
else {
    echo '<p> Etes vous sûr de vouloir supprimer ? </p>';
    echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
    echo '<button type="submit" name="Oui" > Oui </button>';
    echo '<button type="submit" name="Annuler" > Annuler </button>';
}
