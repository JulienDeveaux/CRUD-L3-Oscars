<?php

	function nomPrixUsed(String $nom) : bool {
		$ptrDB = connexion();
		if($ptrDB != NULL){
			$query = "SELECT COUNT(*) AS count FROM prix WHERE nom_prix = $1";
			pg_prepare($ptrDB, "nomPersoUsed", $query);
			$ptrQuery = pg_execute($ptrDB, "nomPrixUsed", array($nom));
			if ($ptrQuery) {
				$resu = pg_fetch_assoc($ptrQuery);
				return $resu['count'] > 0;
			} else {
			    // Erreur : echec de la requete
				pg_close($ptrDB);
				echo '<p class="erreur">Erreur: echec de la requete (verification disponibilie du nomp de prix)</p>';
				return false;
			}
		} else return false;	
	}

	function getAllPrix() : array{
		$ptrDB = connexion();
		if($ptrDB != NULL){
			$query = "SELECT * FROM prix ORDER BY nom_prix";
			pg_prepare($ptrDB, "getAllPrix", $query);
			$ptrQuery = pg_execute($ptrDB, "getAllPrix", array());
			if ($ptrQuery) {
				$resu = pg_fetch_all($ptrQuery);
				if(!empty($resu)){
					pg_free_result($ptrQuery);
					pg_close($ptrDB);
					return $resu;
				} else {
			        // Info : Aucun Prix
					echo '<p class="info">Table des prix vide</p>';
					pg_free_result($ptrQuery);
					pg_close($ptrDB);
					return array();
				}
			} else {
			    // Erreur : echec de la requete
				pg_close($ptrDB);
				echo '<p class="erreur">Erreur: echec de la requete (selection des prix)</p>';
				return array();
			}
		} else return array();
	}

	function getPrixById(int $id) : array{
		$ptrDB = connexion();
		if($ptrDB != NULL){
			$query = "SELECT * FROM prix WHERE id_prix = $1";
			$prepartion = pg_prepare($ptrDB, "getPrixById",$query);
			$ptrQuery = pg_execute($ptrDB, "getPrixById", array($id));
			if ($ptrQuery) {
				$resu = pg_fetch_assoc($ptrQuery);
				if(!empty($resu)){
					pg_free_result($ptrQuery);
					pg_close($ptrDB);
					return $resu;
				} else {
	       			// Erreur : id ne corresond pas à un personnage
					pg_free_result($ptrQuery);
					pg_close($ptrDB);
					echo '<p class="erreur">Erreur: le prix recherché n\'existe pas </p>';
					return array();
				}
			} else {
	       		// Erreur : echec de la requete
				pg_close($ptrDB);
				echo '<p class="erreur">Erreur: echec de la requete</p>';
				return array();
			}
		} else return array();
	}

    function nextIdPersonnage($ptrDB) {
        $query = "SELECT nextval('prix_id_prix_seq') AS nextval";
        $prepartion = pg_prepare($ptrDB, "nextvalIdPrix",$query);
        $ptrQuery = pg_execute($ptrDB, "nextvalIdPrix", array());
        $nextval = pg_fetch_result($ptrQuery, 0, "nextval");
        pg_free_result($ptrQuery);
        return $nextval;
    }

?>