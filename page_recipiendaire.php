<?php 
    $titre="Recipiendaires";
    include 'debutSkelXhtml.php';
    include 'Recipiendaire.php';
    echo'<a href="index.php"> Retour accueil</a>';
    $recipiendaire = Recipiendaire::getAll();
    if(!empty($recipiendaire)){
        echo '<br/><a href="ajouter_recipiendaire.php">Ajouter un recipiendaire</a>';
        echo("<table>");
        $nomColonnesFait = false;
        foreach ($recipiendaire as $key => $recipiendaire) {
            if(!$nomColonnesFait){
                echo "<tr>";
                echo "<th>Recipiendaire</th>";
                foreach ($recipiendaire as $key) {
                    echo "<th>$key</th>";
                }
                echo "<th>Nom Prenom</th>";
                echo "<th>Action</th>";
                $nomColonnesFait = true;
            }
            echo "<tr>";
            echo '<td><img width=70 height=70 alt="'.$recipiendaire->getid_recipiendaire().'" src="Illustrations/Recipiendaire/'.$recipiendaire->getid_recipiendaire().'.png"></td>';
            echo "<td>".$recipiendaire->getnom_recipiendaire()." ".$recipiendaire->getprenom_recipiendaire()."</td>";
            echo '<td>';
            echo '<a class="bouton_sup" href="supprimer_recipiendaire.php?id='.$recipiendaire->getid_recipiendaire().'">Supprimer</a>';
            echo '<a class="bouton_mod" href="modifier_recipiendaire.php?id='.$recipiendaire->getid_recipiendaire().'">Modifier</a>';
            echo '<a class="bouton_det" href="detail_recipiendaire.php?id='.$recipiendaire->getid_recipiendaire().'">Detail</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo("</table>");
    } else {
        echo 'pas de ceremonie';
    }
    include 'finKtml.html';
?>
