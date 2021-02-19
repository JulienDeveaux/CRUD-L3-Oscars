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
}else if(isset($_GET['Annuler'])) {

    echo '<meta http-equiv="refresh" content="0;URL=page_ceremonie.php" />';
} else {

	$ceremonie = Ceremonie::initCeremonie($_GET['id']);
	echo '<h1> Etes vous sûr de vouloir supprimer la cérémonie '.$ceremonie->getnom_ceremonie().' ? </h1>';
	echo '<img width=100 height=150 alt="'.$ceremonie->getid_ceremonie().'" src="Illustrations/Ceremonie/'.$ceremonie->getid_ceremonie().'.png">';
	echo '<br/><input type="hidden" name="id" value="'.$_GET['id'].'">';
    echo '<button type="submit" name="Oui" > Oui </button>';
    echo '<button type="submit" name="Annuler" > Annuler </button>';
}
?>