<?php
class Recipiendaire {

    /**
     * gestion statique des accès SGBD
     * @var PDO
     */ 
    private static $_pdo;

    /**
     * gestion statique de la requête préparée de selection
     * @var PDOStatement
     */ 
    private static $_pdos_select;

    /**
     * gestion statique de la requête préparée de mise à jour
     *  @var PDOStatement
     */ 
    private static $_pdos_update;

    /**
     * gestion statique de la requête préparée de d'insertion
     * @var PDOStatement
     */ 
    private static $_pdos_insert;

    /**
     * gestion statique de la requête préparée de suppression
     * @var PDOStatement
     */ 
    private static $_pdos_delete;

    /**
     * PreparedStatement associé à un SELECT, calcule le nombre de recipiendaires de la table
     * @var PDOStatement;
        */
    private static $_pdos_count;

    /**
     * PreparedStatement associé à un SELECT, récupère tous les récipiendaires
     * @var PDOStatement;
        */
     private static $_pdos_selectAll;

    /**
     * Initialisation de la connexion et mémorisation de l'instance PDO dans Recipiendaire::$_pdo
     */ 
    public static function initPDO() {
        self::$_pdo = new PDO("pgsql:host=localhost;dbname=util", "util", "utilpass");
        // pour récupérer aussi les exceptions provenant de PDOStatement
        self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * préparation de la requête SELECT * FROM Recipiendaire
     * instantiation de self::$_pdos_selectAll
     */
    public static function initPDOS_selectAll() {
        self::$_pdos_selectAll = self::$_pdo->prepare('SELECT * FROM Recipiendaire ORDER BY id_recipiendaire');
    }

	/**
	 * préparation de la requête SELECT * FROM Recipiendaire
	 * instantiation de self::$_pdos_selectAllx
	 */
	public static function initPDOS_selectAllPrix($id_prix) {
		self::$_pdos_selectAll = self::$_pdo->prepare('SELECT DISTINCT * FROM Recipiendaire NATURAL JOIN CONCERNE NATURAL JOIN NOMINATION NATURAL JOIN Ceremonie NATURAL JOIN Prix WHERE id_prix ='.$id_prix);
	}

     /**
     * méthode statique instanciant Recipiendaire::$_pdo_select
     */ 
    public static function initPDOS_select() {
        self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM Recipiendaire WHERE id_recipiendaire= :id_recipiendaire');
    }

    /**
     * méthode statique instanciant Recipiendaire::$_pdo_update
     */ 
    public static function initPDOS_update() {
        self::$_pdos_update =  self::$_pdo->prepare('UPDATE Recipiendaire SET id_recipiendaire=:id_recipiendaire, nom_recipiendaire=:nom, prenom_recipiendaire=:prenom WHERE id_recipiendaire=:id_recipiendaire');
    }

    /**
     * méthode statique instanciant Recipiendaire::$_pdo_insert
     */ 
    public static function initPDOS_insert() {
        self::$_pdos_insert = self::$_pdo->prepare('INSERT INTO Recipiendaire VALUES(:id_recipiendaire,:nom,:prenom)');
    }

    /**
     * méthode statique instanciant Recipiendaire::$_pdo_delete
     */ 
    public static function initPDOS_delete() {
        self::$_pdos_delete = self::$_pdo->prepare('DELETE FROM Recipiendaire WHERE id_recipiendaire=:id_recipiendaire');
    }

    /**
     * préparation de la requête SELECT COUNT(*) FROM Recipiendaire
     * instantiation de self::$_pdos_count
        */
    public static function initPDOS_count() {
        if (!isset(self::$_pdo))
            self::initPDO();
        self::$_pdos_count = self::$_pdo->prepare('SELECT COUNT(*) FROM Recipiendaire');
    }

     /**
     * numéro du Recipiendaire (identifiant dans la table Recipiendaire)
     * @var int
     */ 
    protected $id_recipiendaire;

    /**
     * nom du Recipiendaire
     * @var string
     */ 
    protected $nom_recipiendaire;

    /**
     * Prenom du Recipiendaire
     *   @var string
     */ 
    protected $prenom_recipiendaire;

    /**
     * attribut interne pour différencier les nouveaux objets des objets créés côté applicatif de ceux issus du SGBD
     * @var bool
     */ 
    private $nouveau = TRUE;

    /**
     * @return $this->prenom_recipiendaire
     */ 
    public function getprenom_recipiendaire() : string {
        return $this->prenom_recipiendaire;
    }

    /**
     * @param $prenom_recipiendaire
     */ 
    public function setprenom_recipiendaire($prenom_recipiendaire): void {
        $this->prenom_recipiendaire=$prenom_recipiendaire;
    }

    /**
     * @return $this->nom_recipiendaire
     */ 
    public function getnom_recipiendaire() : string {
        return $this->nom_recipiendaire;
    }

    /**
     * @param $nom_recipiendaire
     */ 
    public function setnom_recipiendaire($nom_recipiendaire): void {
        $this->nom_recipiendaire=$nom_recipiendaire;
    }

    /**
     * @return $this->id_recipiendaire
     */ 
    public function getid_recipiendaire() : int {
        return $this->id_recipiendaire;
    }

    /**
     * @param $id_organisation
     */ 
    public function setid_recipiendaire($id_recipiendaire): void {
        $this->id_recipiendaire=$id_recipiendaire;
    }

    /**
     * @return $this->nouveau
     */ 
    public function getNouveau() : bool {
        return $this->nouveau;
    }

    /**
     * @param $nouveau
     */ 
    public function setNouveau($nouveau): void {
        $this->nouveau=$nouveau;
    }

    /**
     * @return un tableau de tous les Recipiendaire
     */ 
    public static function getAll(): array {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_selectAll))
                self::initPDOS_selectAll();
            self::$_pdos_selectAll->execute();
            // résultat du fetch dans une instance de Recipiendaire
            $lesRecipiendaires = self::$_pdos_selectAll->fetchAll(PDO::FETCH_CLASS,'Recipiendaire');
            return $lesRecipiendaires;
        }
        catch (PDOException $e) {
            print($e);
        }
    }

    /**
     * @return un tableau de tous les Recipiendaire
     */
    public static function getRecipiendaireListPrix($id_prix): array {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_selectAll))
                self::initPDOS_selectAllPrix($id_prix);
            self::$_pdos_selectAll->execute();
            // résultat du fetch dans une instance de Recipiendaire
            $lesRecipiendaires = self::$_pdos_selectAll->fetchAll(PDO::FETCH_CLASS,'Recipiendaire');
            return $lesRecipiendaires;
        }
        catch (PDOException $e) {
            print($e);
        }
    }

    /**
     * initialisation d'un objet à partir d'un enregistrement de Recipiendaire
     * @param $id_recipiendaire un identifiant de Recipiendaire
     * @return l'instance de Recipiendaire associée à $id_recipiendaire
     */ 
    public static function initRecipiendaire($id_recipiendaire) : Recipiendaire {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select();
            self::$_pdos_select->bindValue(':id_recipiendaire',$id_recipiendaire);
            self::$_pdos_select->execute();
        // résultat du fetch dans une instance de Recipiendaire
            $lr = self::$_pdos_select->fetchObject('Recipiendaire');
            if (isset($lr) && ! empty($lr))
                $lr->setNouveau(FALSE);
            if (empty($lr))
                throw new Exception("Recipiendaire $id_recipiendaire inexistant dans la table Recipiendaire.\n");
            return $lr;
        }
        catch (PDOException $e) {
            print($e);
        }
    }

    /**
     * sauvegarde d'un objet
     * soit on insère un nouvel objet
     * soit on le met à jour
     */ 
    public function save() : void {
        if (!isset(self::$_pdo))
            self::initPDO();
        if ($this->nouveau) {
            if (!isset(self::$_pdos_insert)) {
                self::initPDOS_insert();
            }
            self::$_pdos_insert->bindParam(':id_recipiendaire', $this->id_recipiendaire);
            self::$_pdos_insert->bindParam(':nom', $this->nom_recipiendaire);
            self::$_pdos_insert->bindParam(':prenom', $this->prenom_recipiendaire);
            self::$_pdos_insert->execute();
            $this->setNouveau(FALSE);
        }
        else {
            if (!isset(self::$_pdos_update))
                self::initPDOS_update();
            self::$_pdos_update->bindParam(':id_recipiendaire', $this->id_recipiendaire);
            self::$_pdos_update->bindParam(':nom', $this->nom_recipiendaire);
            self::$_pdos_update->bindParam(':prenom', $this->prenom_recipiendaire);
            self::$_pdos_update->execute();
        }
    }

    /**
     * suppression d'un objet
     */ 
    public function delete() :void {
        if (!isset(self::$_pdo))
            self::initPDO();
        if (!$this->nouveau) {
            if (!isset(self::$_pdos_delete)) {
                self::initPDOS_delete();
            }
            self::$_pdos_delete->bindParam(':id_recipiendaire', $this->id_recipiendaire);
            self::$_pdos_delete->execute();
        }
        $this->setNouveau(TRUE);
    }

    /**
     * nombre d'objets disponible dans la table
     */
    public static function getNbRecipiendaire() : int {
        if (!isset(self::$_pdos_count)) {
            self::initPDOS_count();
        }
        self::$_pdos_count->execute();
        $resu = self::$_pdos_count->fetch();
        return $resu[0];
    }

    /**
     * affichage élémentaire
     */ 
    public function __toString() : string {
        $ch = "<table border='1'><tr><th>id_recipiendaire</th><th>nom_recipiendaire</th><th>prenom_recipiendaire</th><th>nouveau</th></tr><tr>";
        $ch.= "<td>".$this->id_recipiendaire."</td>";
        $ch.= "<td>".$this->nom_recipiendaire."</td>";
        $ch.= "<td>".$this->prenom_recipiendaire."</td>";
        $ch.= "<td>".$this->nouveau."</td>";
        $ch.= "</tr></table>";
        return $ch;
    }
}
    
?>