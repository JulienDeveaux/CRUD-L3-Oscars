<?php
    $titre = "Suppression du Prix";
    include 'debutSkelXhtml.php';
    include 'Prix.php';

    echo '<form action="supprimer_prix.php" method="get" >';
    if(!empty($_GET['id'])) {
        if (is_numeric($_GET['id'])) {
            $prix = Prix::initPrix(intval($_GET['id']));
            $prix->setid_prix($_GET['id']);
            $prix->delete();

            echo  '<meta http-equiv="refresh" content="0;URL=page_prix.php" />';
     }
    }
    ?>