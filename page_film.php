<?php
$titre="Film";
include 'debutSkelXhtml.php';
include 'Film.php';
echo'<a href="index.php"> Retour accueil</a>';
$film = Film::getAll();

if(!empty($film)){
    echo '<br/><a href="ajouter_film.php">Ajouter un film</a>';
    echo("<table>");
    $nomColonnesFait = false;

    foreach ($film as $key => $film) {
        if(!$nomColonnesFait){
            echo "<tr>";
            echo "<th>Film</th>";
            echo "<th>Nom</th>";

            foreach ($film as $key => $value) {
                echo "<th>$key</th>";
            }

            echo "<th>Action</th>";
            $nomColonnesFait = true;
        }

        echo "<tr>";
        echo '<td><img width=70 height=70 alt="'.$film->getId_film().'" src="Illustrations/Film/'.$film->getId_film().'.png"></td>';
        echo "<td>".$film->getTitre_film()."</td>";
        echo '<td>';

        echo '<a class="bouton_sup" href="supprimer_film.php?id='.$film->getId_film().'">Supprimer</a>';
        echo '<a class="bouton_mod" href="modifier_film.php?id=' .$film->getId_film().'">Modifier</a>';
        echo '<a class="bouton_det" href="detail_film.php?id='   .$film->getId_film().'">Detail</a>';

        echo '</td>';
        echo '</tr>';
    }
    echo("</table>");
} else {
    echo 'Pas de film';
}
include 'finKtml.html';
?>