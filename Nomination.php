<?php
class Nomination {

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
     * PreparedStatement associé à un SELECT, calcule le nombre de nominations de la table
     * @var PDOStatement;
     */
    private static $_pdos_count;

    /**
     * PreparedStatement associé à un SELECT, récupère toutes les Nominations
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
     * préparation de la requête SELECT * FROM Nomination
     * instantiation de self::$_pdos_selectAll
     */
    public static function initPDOS_selectAll() {
        self::$_pdos_selectAll = self::$_pdo->prepare('SELECT * FROM Nomination');
    }

    /**
     * méthode statique instanciant Nomination::$_pdo_select
     */
    public static function initPDOS_select_categorie() {
        self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM Nomination WHERE id_categorie= :categorie');
    }

    /**
     * méthode statique instanciant Nomination::$_pdo_select
     */
    public static function initPDOS_select_ceremonie() {
        self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM Nomination WHERE id_ceremonie= :ceremonie');
    }

    /**
     * méthode statique instanciant Nomination::$_pdo_select
     */
    public static function initPDOS_select_nomination() {
        self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM Nomination WHERE id_nomination= :id_nomination');
    }

    /**
     * méthode statique instanciant Nomination::$_pdo_update
     */
    public static function initPDOS_update() {
        self::$_pdos_update =  self::$_pdo->prepare('UPDATE Nomination SET id_nomination=:id_nomination, gagnante_nomination=:gagnante, id_ceremonie=:ceremonie, id_categorie=:categorie WHERE id_nomination = :id_nomination');
    }

    /**
     * méthode statique instanciant Nomination::$_pdo_insert
     */
    public static function initPDOS_insert() {
        self::$_pdos_insert = self::$_pdo->prepare('INSERT INTO Nomination VALUES(:id_nomination,:gagnante,:ceremonie,:categorie)');
    }

    /**
     * méthode statique instanciant Nomination::$_pdo_delete
     */
    public static function initPDOS_delete() {
        self::$_pdos_delete = self::$_pdo->prepare('DELETE FROM Nomination WHERE id_nomination=:nomination AND gagnante_nomination:=nomination AND id_ceremonie:=ceremonie AND id_categorie:=categorie');
    }

    /**
     * préparation de la requête SELECT COUNT(*) FROM Nomination
     * instantiation de self::$_pdos_count
     */
    public static function initPDOS_count() {
        if (!isset(self::$_pdo))
            self::initPDO();
        self::$_pdos_count = self::$_pdo->prepare('SELECT COUNT(*) FROM Nomination');
    }

    /**
     * identifiant de la nomination
     * @var integer
     */
    protected $id_nomination;

    /**
     * booleen true ou false si on a gagné ou pas
     *   @var boolean
     */
    protected $gagnante_nomination;

    /**
     * id de la catégorie
     *   @var integer
     */
    protected $id_categorie;

    /**
     * id de la cérémonie
     *   @var integer
     */
    protected $id_ceremonie;

    /**
     * attribut interne pour différencier les nouveaux objets des objets créés côté applicatif de ceux issus du SGBD
     * @var bool
     */
    private $nouveau = TRUE;

    /**
     * @return $this->id_nomination
     */
    public function getid_nomination() : string {
        return $this->id_nomination;
    }

    /**
     * @param $id_nomination
     */
    public function setid_nomination($id_nomination): void {
        $this->id_nomination=$id_nomination;
    }

    /**
     * @return $this->gagnante_nomination
     */
    public function getgagnante_nomination() : string {
        return $this->gagnante_nomination;
    }

    /**
     * @param $gagnante_nomination
     */
    public function setgagnante_nomination($gagnante_nomination): void {
        $this->gagnante_nomination=$gagnante_nomination;
    }

    /**
     * @return $this->id_ceremonie
     */
    public function getid_ceremonie() : string {
        return $this->id_ceremonie;
    }

    /**
     * @param $id_ceremonie
     */
    public function setid_ceremonie($id_ceremonie): void {
        $this->id_ceremonie=$id_ceremonie;
    }

    /**
     * @return $this->id_categorie
     */
    public function getid_categorie() : string {
        return $this->id_categorie;
    }

    /**
     * @param $id_categorie
     */
    public function setid_categorie($id_categorie): void {
        $this->id_categorie=$id_categorie;
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
     * @return un tableau de tous les Nomination
     */
    public static function getAll(): array {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_selectAll))
                self::initPDOS_selectAll();
            self::$_pdos_selectAll->execute();
            // résultat du fetch dans une instance de Nomination
            $lesLivres = self::$_pdos_selectAll->fetchAll(PDO::FETCH_CLASS,'Nomination');
            return $lesLivres;
        }
        catch (PDOException $e) {
            print($e);
        }
    }

    /**
     * initialisation d'un objet métier à partir d'un enregistrement de Nomination
     * @param $id_nomination identifiant de Nomination
     * @return l'instance de Concerne associée à $id_nomination
     */
    public static function initNomination($id_nomination) : Nomination {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select_nomination();
            self::$_pdos_select->bindValue(':id_nomination',$id_nomination);
            self::$_pdos_select->execute();
            // résultat du fetch dans une instance de Nomination
            $lm = self::$_pdos_select->fetchObject('Nomination');
            if (isset($lm) && ! empty($lm))
                $lm->setNouveau(FALSE);
            if (empty($lm))
                throw new Exception("Nomination $id_nomination inexistant dans la table Nomination.\n");
            return $lm;
        }
        catch (PDOException $e) {
            print($e);
        }
    }

    /**
     * initialisation d'un objet métier à partir d'un enregistrement de Nomination
     * @param $id_ceremonie un identifiant de Nomination
     * @return l'instance de Concerne associée à $id_ceremonie
     */
    public static function initNomination_ceremonie($id_ceremonie) : Nomination {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select_ceremonie();
            self::$_pdos_select->bindValue(':ceremonie',$id_ceremonie);
            self::$_pdos_select->execute();
            // résultat du fetch dans une instance de Nomination
            $lm = self::$_pdos_select->fetchObject('Nomination');
            if (isset($lm) && ! empty($lm))
                $lm->setNouveau(FALSE);
            if (empty($lm))
                throw new Exception("Nomination $id_ceremonie inexistant dans la table Nomination.\n");
            return $lm;
        }
        catch (PDOException $e) {
            print($e);
        }
    }

    /**
     * initialisation d'un objet métier à partir d'un enregistrement de Nomination
     * @param $id_categorie un identifiant de Nomination
     * @return l'instance de Nomination associée à $id_categorie
     */
    public static function initNomination_categorie($id_categorie) : Nomination {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select_categorie();
            self::$_pdos_select->bindValue(':categorie',$id_categorie);
            self::$_pdos_select->execute();
            // résultat du fetch dans une instance de Concerne
            $lm = self::$_pdos_select->fetchObject('Nomination');
            if (isset($lm) && ! empty($lm))
                $lm->setNouveau(FALSE);
            if (empty($lm))
                throw new Exception("Categorie $id_categorie inexistant dans la table Nomination.\n");
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
            self::$_pdos_insert->bindParam(':id_nomination', $this->id_nomination);
            self::$_pdos_insert->bindParam(':gagnante', $this->gagnante_nomination);
            self::$_pdos_insert->bindParam(':ceremonie', $this->id_ceremonie);
            self::$_pdos_insert->bindParam(':categorie', $this->id_categorie);
            self::$_pdos_insert->execute();
            $this->setNouveau(FALSE);
        }
        else {
            if (!isset(self::$_pdos_update))
                self::initPDOS_update();
            self::$_pdos_update->bindParam(':id_nomination', $this->id_nomination);
            self::$_pdos_update->bindParam(':gagnante', $this->gagnante_nomination);
            self::$_pdos_update->bindParam(':ceremonie', $this->id_ceremonie);
            self::$_pdos_update->bindParam(':categorie', $this->id_categorie);
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
            self::$_pdos_delete->bindParam(':id_nomination', $this->id_nomination);
            self::$_pdos_delete->bindParam(':gagnante', $this->gagnante_nomination);
            self::$_pdos_delete->bindParam(':ceremonie', $this->id_ceremonie);
            self::$_pdos_delete->bindParam(':categorie', $this->id_categorie);
            self::$_pdos_delete->execute();
        }
        $this->setNouveau(TRUE);
    }

    /**
     * nombre d'objets metier disponible dans la table
     */
    public static function getNbNomination() : int {
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
        $ch = "<table border='1'><tr><th>id_nomination</th><th>gagnante_nomination</th><th>id_ceremonie</th><th>id_categorie</th><th>nouveau</th></tr><tr>";
        $ch.= "<td>".$this->id_nomination."</td>";
        $ch.= "<td>";
        if($this->gagnante_nomination == true) {
            $ch .= "true";
        } else {
            $ch .= "false";
        }
        $ch .= "</td>";
        $ch.= "<td>".$this->id_ceremonie."</td>";
        $ch.= "<td>".$this->id_categorie."</td>";
        $ch.= "<td>".$this->nouveau."</td>";
        $ch.= "</tr></table>";
        return $ch;
    }
}
?>