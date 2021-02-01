<?php 
    $titre="Prix";
    include 'debutSkelXhtml.php';
    include 'Prix.php';
    echo'<a href="index.php"> Retour accueil</a>';
    $prix = fonction_prix::getAll();
    if(!empty($prix)){
        echo '<br/><a href="ajouter_prix.php">Ajouter un prix</a>';
        echo("<table>");
        $nomColonnesFait = false;
        foreach ($prix as $key => $prix) {
            if(!$nomColonnesFait){
                echo "<tr>";
                echo "<th>Prix</th>";
                foreach ($prix as $key => $value) {
                    echo "<th>$key</th>";
                }
                echo "<th>Nom</th>";
                echo "<th>Action</th>";
                $nomColonnesFait = true;
            }
            echo "<tr>";
            echo '<td><img width=70 height=70 alt="'.$prix->getid_prix().'" src="../Illustrations/Prix/'.$prix->getid_prix().'.png"></td>';
            echo "<td>".$prix->getnom_prix()."</td>";
            echo '<td>';
            echo '<a class="bouton_sup" href="supprimer_prix.php?id='.$prix->getid_prix().'">Supprimer</a>';
            echo '<a class="bouton_mod" href="modifier_prix.php?id='.$prix->getid_prix().'">Modifier</a>';
            echo '<a class="bouton_det" href="detail_prix.php?id='.$prix->getid_prix().'">Detail</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo("</table>");
    } else {
        echo 'pas de prix';
    }
    include 'finKtml.html';
?>
