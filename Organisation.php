<?php
class Organisation {

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
	 * PreparedStatement associé à un SELECT, calcule le nombre d'organisations de la table
	 * @var PDOStatement;
	 */
	private static $_pdos_count;

	/**
	 * PreparedStatement associé à un SELECT, récupère toutes les Organisations
	 * @var PDOStatement;
	 */
	private static $_pdos_selectAll;

	/**
	 * Initialisation de la connexion et mémorisation de l'instance PDO dans fonction_prix::$_pdo
	 */
	public static function initPDO() {
		self::$_pdo = new PDO("pgsql:host=localhost;dbname=justine", "justine", "Polaris:27");
		// pour récupérer aussi les exceptions provenant de PDOStatement
		self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * préparation de la requête SELECT * FROM Organisation
	 * instantiation de self::$_pdos_selectAll
	 */
	public static function initPDOS_selectAll() {
		self::$_pdos_selectAll = self::$_pdo->prepare('SELECT * FROM Organisation ORDER BY id_organisation');
	}

	/**
	 * méthode statique instanciant Organisation::$_pdo_select
	 */
	public static function initPDOS_select() {
		self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM Organisation WHERE id_organisation=:id_organisation');
	}

	/**
	 * méthode statique instanciant Organisation::$_pdo_update
	 */
	public static function initPDOS_update() {
		self::$_pdos_update =  self::$_pdo->prepare('UPDATE Organisation SET id_organisation=:id_organisation, nom_organisation=:nom, type_organisation=:type WHERE id_organisation = :id_organisation');
	}

	/**
	 * méthode statique instanciant Organisation::$_pdo_insert
	 */
	public static function initPDOS_insert() {
		self::$_pdos_insert = self::$_pdo->prepare('INSERT INTO Organisation VALUES(:id_organisation,:nom,:type)');
	}

	/**
	 * méthode statique instanciant Organisation::$_pdo_delete
	 */
	public static function initPDOS_delete() {
		self::$_pdos_delete = self::$_pdo->prepare('DELETE FROM Organisation WHERE id_organisation=:id_organisation AND nom_organisation=:nom AND type_organisation=:type');
	}

	/**
	 * préparation de la requête SELECT COUNT(*) FROM Organisation
	 * instantiation de self::$_pdos_count
	 */
	public static function initPDOS_count() {
		if (!isset(self::$_pdo))
			self::initPDO();
		self::$_pdos_count = self::$_pdo->prepare('SELECT COUNT(*) FROM Organisation');
	}

	/**
	 * identifiant de l'organisation
	 * @var integer
	 */
	protected $id_organisation;

	/**
	 * nom de l'organisation
	 *   @var string
	 */
	protected $nom_organisation;

	/**
	 * type de l'organisation
	 *   @var string
	 */
	protected $type_organisation;

	/**
	 * attribut interne pour différencier les nouveaux objets des objets créés côté applicatif de ceux issus du SGBD
	 * @var bool
	 */
	private $nouveau = TRUE;

	/**
	 * @return $this->id_organisation
	 */
	public function getid_organisation() : string {
		return $this->id_organisation;
	}

	/**
	 * @param $id_organisation
	 */
	public function setid_organisation($id_organisation): void {
		$this->id_organisation=$id_organisation;
	}

	/**
	 * @param $nom_organisation
	 */
	public function setnom_organisation($nom_organisation): void {
		$this->nom_organisation=$nom_organisation;
	}

	/**
	 * @return $this->nom_organisation
	 */
	public function getnom_organisation() : string {
		return $this->nom_organisation;
	}

	/**
	 * @return $this->type_organisation
	 */
	public function gettype_organisation() : string {
		return $this->type_organisation;
	}

	/**
	 * @param $type_organisation
	 */
	public function settype_organisation($type_organisation): void {
		$this->type_organisation=$type_organisation;
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
	 * @return un tableau de tous les Organisation
	 */
	public static function getAll(): array {
		try {
			if (!isset(self::$_pdo))
				self::initPDO();
			if (!isset(self::$_pdos_selectAll))
				self::initPDOS_selectAll();
			self::$_pdos_selectAll->execute();
			// résultat du fetch dans une instance de Organisation
			$lesLivres = self::$_pdos_selectAll->fetchAll(PDO::FETCH_CLASS,'Organisation');
			return $lesLivres;
		}
		catch (PDOException $e) {
			print($e);
		}
	}

	/**
	 * initialisation d'un objet métier à partir d'un enregistrement de Organisation
	 * @param $id_organisation identifiant de Organisation
	 * @return l'instance de Organisation associée à $id_organisation
	 */
	public static function initOrganisation($id_organisation) : Organisation {
		try {
			if (!isset(self::$_pdo))
				self::initPDO();
			if (!isset(self::$_pdos_select))
				self::initPDOS_select();
			self::$_pdos_select->bindValue(':id_organisation',$id_organisation);
			self::$_pdos_select->execute();
			// résultat du fetch dans une instance de Nomination
			$lm = self::$_pdos_select->fetchObject('Organisation');
			if (isset($lm) && ! empty($lm))
				$lm->setNouveau(FALSE);
			if (empty($lm))
				throw new Exception("Organisation $id_organisation inexistant dans la table Organisation.\n");
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
			self::$_pdos_insert->bindParam(':id_organisation', $this->id_organisation);
			self::$_pdos_insert->bindParam(':nom', $this->nom_organisation);
			self::$_pdos_insert->bindParam(':type', $this->type_organisation);
			self::$_pdos_insert->execute();
			$this->setNouveau(FALSE);
		}
		else {
			if (!isset(self::$_pdos_update))
				self::initPDOS_update();
			self::$_pdos_update->bindParam(':id_organisation', $this->id_organisation);
			self::$_pdos_update->bindParam(':nom', $this->nom_organisation);
			self::$_pdos_update->bindParam(':type', $this->type_organisation);
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
			self::$_pdos_delete->bindParam(':id_organisation', $this->id_organisation);
			self::$_pdos_delete->bindParam(':nom', $this->nom_organisation);
			self::$_pdos_delete->bindParam(':type', $this->type_organisation);
			self::$_pdos_delete->execute();
		}
		$this->setNouveau(TRUE);
	}

	/**
	 * nombre d'objets metier disponible dans la table
	 */
	public static function getNbOrganisation() : int {
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
		$ch = "<table border='1'><tr><th>id_organisation</th><th>nom_organisation</th><th>type_organisation</th><th>nouveau</th></tr><tr>";
		$ch.= "<td>".$this->id_organisation."</td>";
		$ch.= "<td>".$this->nom_organisation."</td>";
		$ch.= "<td>".$this->type_organisation."</td>";
		$ch.= "<td>".$this->nouveau."</td>";
		$ch.= "</tr></table>";
		return $ch;
	}
}
?>