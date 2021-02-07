<?php 
    $titre="Ceremonie";
    include 'debutSkelXhtml.php';
    include 'Ceremonie.php';
    echo'<a href="index.php"> Retour accueil</a>';
    $ceremonie = Ceremonie::getAll();
    if(!empty($ceremonie)){
        echo '<br/><a href="ajouter_ceremonie.php">Ajouter une Ceremonie</a>';
        echo("<table>");
        $nomColonnesFait = false;
        foreach ($ceremonie as $key => $ceremonie) {
            if(!$nomColonnesFait){
                echo "<tr>";
                echo "<th>Ceremonie</th>";
                foreach ($ceremonie as $key) {
                    echo "<th>$key</th>";
                }
                echo "<th>Nom</th>";
                echo "<th>Action</th>";
                $nomColonnesFait = true;
            }
            echo "<tr>";
            echo '<td><img width=70 height=70 alt="'.$ceremonie->getid_ceremonie().'" src="Illustrations/Ceremonie/'.$ceremonie->getid_ceremonie().'.png"></td>';
            echo "<td>".$ceremonie->getnom_ceremonie()."</td>";
            echo '<td>';
            echo '<a class="bouton_sup" href="supprimer_ceremonie.php?id='.$ceremonie->getid_ceremonie().'">Supprimer</a>';
            echo '<a class="bouton_mod" href="modifier_ceremonie.php?id='.$ceremonie->getid_ceremonie().'">Modifier</a>';
            echo '<a class="bouton_det" href="detail_ceremonie.php?id='.$ceremonie->getid_ceremonie().'">Detail</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo("</table>");
    } else {
        echo 'pas de ceremonie';
    }
    include 'finKtml.html';
?>
