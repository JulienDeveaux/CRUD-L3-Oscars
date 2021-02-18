<?php
class Concerne {

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
     * PreparedStatement associé à un SELECT, calcule le nombre de Concerne de la table
     * @var PDOStatement;
        */
    private static $_pdos_count;

    /**
     * PreparedStatement associé à un SELECT, récupère tous les Concerne
     * @var PDOStatement;
        */
     private static $_pdos_selectAll;

    /**
     * Initialisation de la connexion et mémorisation de l'instance PDO dans fonction_prix::$_pdo
     */ 
    public static function initPDO() {
        self::$_pdo = new PDO("pgsql:host=localhost;dbname=util", "util", "utilpass");
        // pour récupérer aussi les exceptions provenant de PDOStatement
        self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * préparation de la requête SELECT * FROM Concerne
     * instantiation de self::$_pdos_selectAll
        */
    public static function initPDOS_selectAll() {
        self::$_pdos_selectAll = self::$_pdo->prepare('SELECT * FROM Concerne');
    }

     /**
     * méthode statique instanciant Concerne::$_pdo_select
     */ 
    public static function initPDOS_select_recipiendaire() {
        self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM Concerne WHERE id_recipiendaire= :id_recipiendaire');
    }

    /**
     * méthode statique instanciant Concerne::$_pdo_select
     */ 
    public static function initPDOS_select_film() {
        self::$_pdos_select = self::$_pdo->prepare("SELECT * FROM Concerne WHERE id_film = :id_film");
    }

    /**
     * méthode statique instanciant Concerne::$_pdo_select
     */ 
    public static function initPDOS_select_nomination() {
        self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM Concerne WHERE id_nomination= :id_nomination');
    }

    /**
     * méthode statique instanciant Concerne::$_pdo_update
     */ 
    public static function initPDOS_update() {
        self::$_pdos_update =  self::$_pdo->prepare('UPDATE Concerne SET fonction=:fonction, nom_contribution=:contribution, id_film=:id_film, id_recipiendaire=:id_recipiendaire, id_nomination=:id_nomination');
    }
    /**
     * méthode statique instanciant Concerne::$_pdo_insert
     */ 
    public static function initPDOS_insert() {
        self::$_pdos_insert = self::$_pdo->prepare('INSERT INTO Concerne VALUES(:fonction,:contribution,:id_film,:id_recipiendaire,;id_nomination)');
    }

    /**
     * méthode statique instanciant Concerne::$_pdo_delete
     */ 
    public static function initPDOS_delete() {
        self::$_pdos_delete = self::$_pdo->prepare('DELETE FROM Concerne WHERE id_film=:id_film AND id_recipiendaire=:id_recipiendaire AND id_nomination=:id_nomination AND nom_contribution=:contribution AND fonction=:fonction');
    }

    /**
     * préparation de la requête SELECT COUNT(*) FROM Concerne
     * instantiation de self::$_pdos_count
        */
    public static function initPDOS_count() {
        if (!isset(self::$_pdo))
            self::initPDO();
        self::$_pdos_count = self::$_pdo->prepare('SELECT COUNT(*) FROM Concerne');
    }

    /**
     * nom de la fonction
     * @var string
     */ 
    protected $fonction;

    /**
     * nom de la contribution
     *   @var string
     */ 
    protected $nom_contribution;

    /**
     * id du film
     *   @var string
     */ 
    protected $id_film;

    /**
     * id du recipiendaire
     *   @var string
     */ 
    protected $id_recipiendaire;

    /**
     * id de la nomination
     *   @var string
     */ 
    protected $id_nomination;

    /**
     * attribut interne pour différencier les nouveaux objets des objets créés côté applicatif de ceux issus du SGBD
     * @var bool
     */ 
    private $nouveau = TRUE;

    /**
     * @return $this->fonction
     */ 
    public function getfonction() : string {
        return $this->fonction;
    }

    /**
     * @param $fonction
     */ 
    public function setfonction($fonction): void {
        $this->fonction=$fonction;
    }

    /**
     * @return $this->nom_contribution
     */ 
    public function getnom_contribution() : string {
        return $this->nom_contribution;
    }

    /**
     * @param $nom_contribution
     */ 
    public function setnom_contribution($nom_contribution): void {
        $this->nom_contribution=$nom_contribution;
    }

    /**
     * @return $this->id_film
     */ 
    public function getid_film() : string {
        return $this->id_film;
    }

    /**
     * @param $id_film
     */ 
    public function setid_film($id_film): void {
        $this->id_film=$id_film;
    }

    /**
     * @return $this->id_recipiendaire
     */ 
    public function getid_recipiendaire() : string {
        return $this->id_recipiendaire;
    }

    /**
     * @param $id_recipiendaire
     */ 
    public function setid_recipiendaire($id_recipiendaire): void {
        $this->id_recipiendaire=$id_recipiendaire;
    }

    /**
     * @return $this->id_id_nomination
     */ 
    public function getid_nomination() : string {
        return $this->id_nomination;
    }

    /**
     * @param $id_film
     */ 
    public function setid_nomination($id_nomination): void {
        $this->id_nomination=$id_nomination;
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
     * @return un tableau de tous les Concerne
     */ 
    public static function getAll(): array {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_selectAll))
                self::initPDOS_selectAll();
            self::$_pdos_selectAll->execute();
            // résultat du fetch dans une instance de Concerne
            $lesLivres = self::$_pdos_selectAll->fetchAll(PDO::FETCH_CLASS,'Concerne');
            return $lesLivres;
        }
        catch (PDOException $e) {
            print($e);
        }
    }


    /**
     * initialisation d'un objet métier à partir d'un enregistrement de Concerne
     * @param $id_recipiendaire un identifiant de Concerne
     * @return l'instance de Concerne associée à $id_recipiendaire
     */ 
    public static function initConcerne_recipiendaire($id_recipiendaire) : Concerne {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select_recipiendaire();
            self::$_pdos_select->bindValue(':id_recipiendaire',$id_recipiendaire);
            self::$_pdos_select->execute();
        // résultat du fetch dans une instance de Concerne
            $lm = self::$_pdos_select->fetchObject('Concerne');
            if (isset($lm) && ! empty($lm))
                $lm->setNouveau(FALSE);
            if (empty($lm))
                throw new Exception("Recipiendaire $id_recipiendaire inexistant dans la table Concerne.\n");
            return $lm;
        }
        catch (PDOException $e) {
            print($e);
        }
    }

    /**
     * initialisation d'un objet métier à partir d'un enregistrement de Concerne
     * @param $id_film un identifiant de Concerne
     * @return l'instance de Concerne associée à $id_film
     */ 
    public static function initConcerne_film($id_film) : Concerne {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select_film();
            self::$_pdos_select = self::$_pdo->prepare("SELECT * FROM Concerne WHERE id_film = :id_film");
            //self::$_pdos_select->bindValue(':id_film', $id_film);
            self::$_pdos_select->execute(array(':id_film' => $id_film));
        // résultat du fetch dans une instance de Concerne
            $lm = self::$_pdos_select->fetchObject('Concerne');
            if (isset($lm) && ! empty($lm))
                $lm->setNouveau(FALSE);
            if (empty($lm))
                throw new Exception("Film $id_film inexistant dans la table Concerne.\n");
            return $lm;
        }
        catch (PDOException $e) {
            print($e);
        }
    }

    /**
     * initialisation d'un objet métier à partir d'un enregistrement de Concerne
     * @param $id_nomination un identifiant de Concerne
     * @return l'instance de Concerne associée à $id_nomination
     */ 
    public static function initConcerne_nomination($id_nomination) : Concerne {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select_nomination();
            self::$_pdos_select->bindValue(':id_nomination',$id_nomination);
            self::$_pdos_select->execute();
        // résultat du fetch dans une instance de Concerne
            $lm = self::$_pdos_select->fetchObject('Concerne');
            if (isset($lm) && ! empty($lm))
                $lm->setNouveau(FALSE);
            if (empty($lm))
                throw new Exception("Nomination $id_nomination inexistant dans la table Concerne.\n");
            return $lm;
        }
        catch (PDOException $e) {
            print($e);
        }
    }

    /**
     * sauvegarde d'un objet métier
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
            self::$_pdos_insert->bindParam(':id_film', $this->id_film);
            self::$_pdos_insert->bindParam(':id_nomination', $this->id_nomination);
            self::$_pdos_insert->bindParam(':contribution', $this->nom_contribution);
            self::$_pdos_insert->bindParam(':fonction', $this->fonction);
            self::$_pdos_insert->execute();
            $this->setNouveau(FALSE);
        }
        else {
            if (!isset(self::$_pdos_update))
                self::initPDOS_update();
            self::$_pdos_update->bindParam(':id_recipiendaire', $this->id_recipiendaire);
            self::$_pdos_update->bindParam(':id_film', $this->id_film);
            self::$_pdos_update->bindParam(':id_nomination', $this->id_nomination);
            self::$_pdos_update->bindParam(':contribution', $this->nom_contribution);
            self::$_pdos_update->bindParam(':fonction', $this->fonction);
            self::$_pdos_update->execute();
        }
    }

    /**
     * suppression d'un objet métier
     */ 
    public function delete() :void {
        if (!isset(self::$_pdo))
            self::initPDO();
        if (!$this->nouveau) {
            if (!isset(self::$_pdos_delete)) {
                self::initPDOS_delete();
            }
            self::$_pdos_delete->bindParam(':id_recipiendaire', $this->id_recipiendaire);
            self::$_pdos_delete->bindParam(':id_film', $this->id_film);
            self::$_pdos_delete->bindParam(':id_nomination', $this->id_nomination);
            self::$_pdos_delete->bindParam(':contribution', $this->nom_contribution);
            self::$_pdos_delete->bindParam(':fonction', $this->fonction);
            self::$_pdos_delete->execute();
        }
        $this->setNouveau(TRUE);
    }

    /**
     * nombre d'objets metier disponible dans la table
     */
    public static function getNbConcerne() : int {
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
        $ch = "<table border='1'><tr><th>fonction</th><th>nom_contribution</th><th>id_film</th><th>id_recipiendaire</th><th>id_nomination</th><th>nouveau</th></tr><tr>";
        $ch.= "<td>".$this->fonction."</td>";
        $ch.= "<td>".$this->nom_contribution."</td>";
        $ch.= "<td>".$this->id_film."</td>";
        $ch.= "<td>".$this->id_recipiendaire."</td>";
        $ch.= "<td>".$this->id_nomination."</td>";
        $ch.= "<td>".$this->nouveau."</td>";
        $ch.= "</tr></table>";
        return $ch;
    }
}
    
?>