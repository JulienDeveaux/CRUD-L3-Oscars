<?php
$titre = "Supprimer une cérémonie";
include 'debutSkelXhtml.php';
include 'Ceremonie.php';

echo '<form action="supprimer_ceremonie.php" method="get" >';

if(isset($_GET['Oui'])){
    if(!empty($_GET['id'])) {
        if (is_numeric($_GET['id'])) {
            $ceremonie = Ceremonie::initCeremonie(intval($_GET['id']));
            $ceremonie->delete();
            echo  '<meta http-equiv="refresh" content="0;URL=page_ceremonie.php" />';
        }
    }
}else if(isset($_GET['Annuler'])){
    echo  '<meta http-equiv="refresh" content="0;URL=page_ceremonie.php" />';
}
else {
    echo '<p> Etes vous sûr de vouloir supprimer ? </p>';
    echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
    echo '<button type="submit" name="Oui" > Oui </button>';
    echo '<button type="submit" name="Annuler" > Annuler </button>';
}

