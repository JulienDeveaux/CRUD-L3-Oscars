<?php


class Film
{

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
     * PreparedStatement associé à un SELECT, calcule le nombre de film de la table
     * @var PDOStatement;
     */
    private static $_pdos_count;

    /**
     * PreparedStatement associé à un SELECT, récupère tous les films
     * @var PDOStatement;
     */
    private static $_pdos_selectAll;

    /**
     * Initialisation de la connexion et mémorisation de l'instance PDO dans Film::$_pdo
     */
    public static function initPDO() {
        self::$_pdo = new PDO("pgsql:host=localhost;dbname=util", "util", "utilpass");// pour récupérer aussi les exceptions provenant de PDOStatement
        self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * préparation de la requête SELECT * FROM film
     * instantiation de self::$_pdos_selectAll
     */
    public static function initPDOS_selectAll() {
        self::$_pdos_selectAll = self::$_pdo->prepare('SELECT * FROM film ORDER BY id_film');
    }

    /**
     * méthode statique instanciant Film::$_pdo_select
     */
    public static function initPDOS_select() {
        self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM film WHERE id_film = :identifiant');
    }

    /**
     * méthode statique instanciant Film::$_pdo_update
     */
    public static function initPDOS_update() {
        self::$_pdos_update =  self::$_pdo->prepare('UPDATE film SET titre_film=:titre, titre_original=:titre_original WHERE id_film=:identifiant');
    }

    /**
     * méthode statique instanciant Film::$_pdo_insert
     */
    public static function initPDOS_insert() {
        self::$_pdos_insert = self::$_pdo->prepare('INSERT INTO film VALUES(:identifiant,:titre,:titre_original)');
    }

    /**
     * méthode statique instanciant Film::$_pdo_delete
     */
    public static function initPDOS_delete() {
        self::$_pdos_delete = self::$_pdo->prepare('DELETE FROM film WHERE id_film=:identifiant');
    }

    /**
     * préparation de la requête SELECT COUNT(*) FROM Film
     * instantiation de self::$_pdos_count
     */
    public static function initPDOS_count() {
        if (!isset(self::$_pdo))
            self::initPDO();
        self::$_pdos_count = self::$_pdo->prepare('SELECT COUNT(*) FROM film');
    }


    /**
     * numéro du film (identifiant dans la table film)
     * @var int
     */
    protected $id_film;

    /**
     * titre du film
     * @var string
     */
    protected $titre_film;

    /**
     * titre original du film
     *   @var string
     */
    protected $titre_original;

    /**
     * attribut interne pour différencier les nouveaux objets des objets créés côté applicatif de ceux issus du SGBD
     * @var bool
     */
    private $nouveau = TRUE;

    /**
     * @return $this->id_film
     */
    public function getId_film() : int {
        return $this->id_film;
    }

    /**
     * @param $id_film
     */
    public function setId_film($id_film) : void {
        $this->id_film=$id_film;
    }

    /**
     * @return $this->titre_film
     */
    public function getTitre_film() : string {
        return $this->titre_film;
    }

    /**
     * @param $titre_film
     */
    public function setTitre_film($titre_film): void {
        $this->titre_film=$titre_film;
    }

    /**
     * @return $this->titre_original
     */
    public function getTitre_original() {
        return $this->titre_original;
    }

    /**
     * @param $tire_original
     */
    public function setTitre_original($tire_original): void {
        $this->titre_original=$tire_original;
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
     * @return un tableau de tous les films
     */
    public static function getAll(): array {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_selectAll))
                self::initPDOS_selectAll();
            self::$_pdos_selectAll->execute();
            // résultat du fetch dans une instance de film
            $lesFilms = self::$_pdos_selectAll->fetchAll(PDO::FETCH_CLASS,'Film');
            return $lesFilms;
        }
        catch (PDOException $e) {
            print($e);
        }
    }

    /**
     * initialisation d'un objet à partir d'un enregistrement de Film
     * @param $id_film un identifiant de film
     * @return l'instance de Film associée à $id_film
     */
    public static function initFilm($id_film) : Film {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select();
            self::$_pdos_select->bindValue(':identifiant',$id_film);
            self::$_pdos_select->execute();
            // résultat du fetch dans une instance de Film
            $lf = self::$_pdos_select->fetchObject('Film');
            if (isset($lf) && ! empty($lf))
                $lf->setNouveau(FALSE);
            if (empty($lf))
                throw new Exception("Film $id_film inexistant dans la table Film.\n");
            return $lf;
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
            self::$_pdos_insert->bindParam(':identifiant', $this->id_film);
            self::$_pdos_insert->bindParam(':titre', $this->titre_film);
            self::$_pdos_insert->bindParam(':titre_original', $this->titre_original);
            self::$_pdos_insert->execute();
            $this->setNouveau(FALSE);
        }
        else {
            if (!isset(self::$_pdos_update))
                self::initPDOS_update();
            self::$_pdos_update->bindParam(':identifiant', $this->id_film);
            self::$_pdos_update->bindParam(':titre', $this->titre_film);
            self::$_pdos_update->bindParam(':titre_original', $this->titre_original);
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
            self::$_pdos_delete->bindParam(':identifiant', $this->id_film);
            self::$_pdos_delete->execute();
        }
        $this->setNouveau(TRUE);
    }

    /**
     * nombre d'objets film disponible dans la table
     */
    public static function getNbFilms() : int {
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
        $ch = "<table border='1'><tr><th>id_film</th><th>titre_film</th><th>titre_original</th><th>nouveau</th></tr><tr>";
        $ch.= "<td>".$this->id_film."</td>";
        $ch.= "<td>".$this->titre_film."</td>";
        $ch.= "<td>".$this->titre_original."</td>";
        $ch.= "<td>".$this->nouveau."</td>";
        $ch.= "</tr></table>";
        return $ch;
    }

}