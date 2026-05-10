<?php
/**
 * Description of LIB_Table
 * 
 * Fournit des services pour les classes images d'une table 
 * dans la base de données
 *
 * @author C320688
 */
class LIB_Table {

    /**
     * Identifiant de la ligne dans la table
     * @var integer 
     */
    protected $id;

    /**
     * Liste des colonnes de la table
     * @var LIB_TableColonne_s
     */
    protected $colonnes;

    /**
     * Nom de la classe pour la table
     * @var string
     */
    private $nom_classe;

    /**
     * Nom de la table
     * @var string
     */
    protected $nom_table;

    /**
     * Description de la table
     * @var string
     */
    private $description_table;

    /**
     * Liste des noms des colonnes avec leurs descriptions
     * @var array
     */
    private $liste_descriptions_colonnes;
    
    /**
     * Requete select de libellé
     * @var LIB_ArbreTablesColonnes
     */
    protected $arbre_tables_colonnes;

    /**
     * Initialise l'objet : 
     * - avec la ligne lue de la base de données
     * - avec les données provenant d'un formulaire
     * @param variant $parametre 
     * @global LIB_BDD_Structure $CXO_ST
     */
    public function __construct($nom_table = "-") {
        global $CXO_ST;
        
        if ($nom_table === "-") {
            $this->nom_classe = $this->getNomClasse();
            $this->nom_table = $this->getNomTable();
        } else {
            $this->nom_table = $nom_table;
            $this->nom_classe = "LIB_$nom_table";
        }
        
        $this->liste_descriptions_colonnes = $CXO_ST->getListeDescriptionsColonnes($this->nom_table);
        $this->initialiseColonnes();
        $this->description_table = $this->initDescriptionTable();
        $this->id = 0;
        $this->arbre_tables_colonnes = null;
    }
    
    public function __clone() {
        $this->colonnes = clone $this->colonnes;
        $this->description_table = clone $this->description_table;
    }

    /**
     * Renseigne les données d'une ligne de table
     * @param arguments Nombre variable selon la table.
     * Il doit y avoir exactement le nombre de valeurs à renseigner dans l'arborescence de la table
     * Format pour des constantes : Valeurs séparées par des virgules.
     * Ex pour un commerce : "'G20','Beynes','78650','Centre commercial de la petite Mauldre'"
     * Soit : set('G20','Beynes','78650','Centre commercial de la petite Mauldre')
     * Format pour une variable : tableau :
     * Ex :
     * 
$tab
(
    [0] => G20
    [1] => Beynes
    [2] => 78650
    [3] => Centre commercial l Estandard
)
     * Soit : set(...$tab)
     * TRES IMPORTANT : ne pas oublier les "..." si on passe les arguments comme un tableau
     * @return type
     */
    public function set() {
        $nbPartiesFrom = $this->arbre_tables_colonnes->getNbPartiesFrom();
        $nbArguments = func_num_args();
        
        if ($nbArguments != $nbPartiesFrom) {
            LIB_Util::log("ERREUR : Le nombre de parties ($nbPartiesFrom) et le nombre d'arguments ($nbArguments) doivent être égaux");
            LIB_Util::logPrintR($this->arbre_tables_colonnes,"-----  Parties -----");
            LIB_Util::logPrintR(func_get_args(),"-----  Arguments -----");
            return;
        }
        $this->setDeInitialisationBase(...func_get_args());
    }
    
    /**
     * Crée un élément vide
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function setVide() {
        global $DOT;
        
        $liste_tablonnes = $this->getArbreTablesColonnes()->getTableauArguments();
        
        $tab = [];
        foreach ($liste_tablonnes as $value) {
            if (is_numeric($value)) {
                continue;
            }
            $tab_explode = explode("_", $value);
            
            $nom_table = "";
            $nom_colonne = "";
            
            foreach ($tab_explode as $index => $value) {
                if ($index == 0) {
                    $nom_table = $value;
                }
                if ($index == 1) {
                    $nom_colonne = $value;
                }
                if ($index > 1) {
                    $nom_colonne = sprintf("%s_%s",$nom_colonne,$value);
                }
            
                
            }
            
            $o = $DOT->getObjet($nom_table);
            
            $type = $o->getTypeColonne($nom_colonne);

            $valeur = "";
            
            switch ($type) {
                case "nombre":
                    $valeur = 0;
                    break;
                case "booleen":
                    $valeur = 0;
                    break;

                default:
                    $valeur = "-";
                    break;
            }

            $tab[] = $valeur;
            
        }
                
        $this->set(...$tab);
    }
    
    /**
     * 
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function setDeInitialisationBase() {
        global $DOT;
        
        $arguments_TBL_courante = $this->arbre_tables_colonnes->getListeArgumentsNommes(...func_get_args());
        foreach ($this->colonnes->getListe() as $nom_colonne => $colonne) {
            if ($colonne->isColonneId()) {
                continue;
            }
            $valeur = 0;
            $nom_table_liee = $colonne->getNomClasseTableLiee();
            if ($colonne->isMenu()) {
                $obj_table = $DOT->getObjet($nom_table_liee);
                $arguments_TBL = $obj_table->getArbreTablesColonnes()->getExtraitListeArguments($arguments_TBL_courante);
                $obj_table->set(...$arguments_TBL->getListeValeurs());
                $obj_table->chargeId(true);
                $valeur = $obj_table->getId();
            } else {
                $nom_argument = $colonne->getNomArgument();
                if ($colonne->isColonneDatation()) {
                    $dat = new LIB_Datation($arguments_TBL_courante->getValeur($colonne->getNomArgument()));
                    $valeur = $dat->getDate_pourEcritureMySQL();
                } else {
                    $valeur = $arguments_TBL_courante->getValeur($colonne->getNomArgument());
                }
            }
            $this->setValeurColonne($nom_colonne, $valeur);
        }
    }
    
    public function setDeJson($libelle_json) {
        $tab_de_json = unserialize($libelle_json);
        
        LIB_Util::logPrintR($tab_de_json);
        
        $tab = [];
        foreach ($tab_de_json as $value) {
            $tab[] = $value;
        }
        
        $this->set(...$tab);
    }
    
    /**
     * Initialise l'élément à partir d'une ligne lue de la base de données
     * @param array $ligne Ligne brute extraite de la base par le select
     */
    public function setDeLigne($ligne) {
        $crdu = new LIB_CompteRendu(true,"","","");
        if (isset($ligne['id'])) {
            // Initialise à partir d'une ligne lue de la table de la base de données
            foreach ($ligne as $nomColonne => $valeur) {
                if (!is_numeric($nomColonne)) {
                    $colonne = $this->colonnes->get($nomColonne);
                    $colonne->setValeur($valeur);
                    if ($nomColonne == 'id') {
                        $this->id = $valeur;
                    }
                }
            }
        } else {
            // Initialise l'élément à partir de la saisie du formulaire
            $colonne = $this->colonnes->get('id');
            $colonne->setValeur(0);
            $this->id = 0;
            foreach ($ligne as $element) {
                $nomColonne = $element['name'];
                $valeur = $element['value'];
                $colonne = $this->colonnes->get($nomColonne);
                // Contrôle format bon si colonne est une datation
                if ($colonne->isColonneDatation()) {
                    if (strlen($valeur) == 0) {
                        LIB_Util::log($valeur);
                        $valeur = null;
                        LIB_Util::log($valeur);
                        continue;
                    }
                    $d = new LIB_Datation($valeur);
                    if (!$d->is_date_valide()) {
                        $tab = array();
                        $tab[] = $valeur;
                        $crdu = new LIB_CompteRendu(false,"Erreur format de date",$tab,$nomColonne);
                        return $crdu;
                    }
                    $valeur = $d->getDate_pourEcritureMySQL();
                }
                // Contrôle format bon si colonne est un montant
                if ($colonne->isColonneMontant()) {
                    $d = new LIB_Montant($valeur);
                    if (!$d->is_montant_valide()) {
                        $tab = array();
                        $tab[] = $valeur;
                        $crdu = new LIB_CompteRendu(false,"Erreur format de montant",$tab,$nomColonne);
                        return $crdu;
                    }
                    if ($d->get_valeur_brute() == 0){
                        $tab = array();
                        $tab[] = $valeur;
                        $crdu = new LIB_CompteRendu(false,"Le montant ne peut pas être nul",$tab,$nomColonne);
                        return $crdu;
                    }
                    $valeur = $d->get_valeur_mysql();
                }
                $colonne->setValeur($valeur);
                if ($nomColonne == 'id') {
                    $this->id = $valeur;
                }
            }
        }

        return $crdu;
    }

    /**
     * Renvoie la requête d'insertion dans la base
     */
    private function getSqlInsert() {
        $nt = $this->nom_table;
        $sc = $this->colonnes->getSqlInsertSectionColonnes();
        $sv = $this->colonnes->getSqlInsertSectionValeurs();
        $requete = "insert into `$nt` $sc values $sv";
        return $requete;
    }

    /**
     * Renvoie la requête de modification dans la base
     */
    private function getSqlUpdate() {
        $nt = $this->nom_table;
        $ss = $this->colonnes->getSqlUpdateSectionSet();
        return "update `$nt` $ss where `id` = $this->id";
    }

    /**
     * Renvoie la requête de suppression dans la base
     */
    private function getSqlDelete() {
        $nt = $this->nom_table;
        return "delete from `$nt` where `id` = $this->id";
    }

    /**
     * Renvoie la requête de vidage de la base
     */
    private function getSqlVidage() {
        $nt = $this->nom_table;
        $req = "delete from `$nt` where id > 0";
        return $req;
    }

    /**
     * Renvoie la requête de recherche dans la base
     */
    private function getSqlSelect() {
        $nt = $this->nom_table;
        return "select * from `$nt` where `id` = $this->id";
    }

    /**
     * Renvoie la requete pour recherche l'id en fonction des autres valeurs
     * @return string
     */
    protected function getSqlSelectId() {
        $nt = $this->nom_table;
        $w = $this->colonnes->getSqlSelectWhere();
        return "select id from `$nt` $w";
    }
    
    /**
     * Charge le contenu d'un ligne en fonction de la valeur d'une colonne
     * @global LIB_BDD $CXO
     * @param string $nom_colonne Nom de la colonne 
     * @param styring $valeur Valeur
     */
    protected function chargeParNomColonne($nom_colonne,$valeur) : LIB_CompteRendu {
        global $CXO;
        // Recherche de l'élément en fonction de son nom
        $requete = sprintf("select * from %s where %s = '%s'",$this->nom_table,$nom_colonne,$valeur);
        $ret = $CXO->executeRequete($requete);
        $this->setId(0);
        if ($ret->isOk()) {
            $lignes = $ret->getResultat();
            foreach ($lignes as $ligne) {
                $this->setDeLigne($ligne);
            }
        } else {
            LIB_Util::log($ret,"Erreur pendant chargeParNomColonne : '$nom_colonne' , '$valeur'");
        }
        
        return $ret->getCompteRendu();
    }

    /**
     * Renvoie le contenu toutes les colonnes
     * @return string
     */
    public function __toString() {
        return $this->getLibelle();
    }
    
    /**
     * Renvoie la requête qui sert à obtenir le libellé.
     * Elle peut servir pour l'affichage
     * Exemple :
    select Enseigne.nom as Enseigne_nom , Ville.nom as Ville_nom , Ville.code_postal as Ville_code_postal , Commerce.localisation as Commerce_localisation 
     * from Commerce 
     * join Enseigne on Enseigne.id = Commerce.id_Enseigne 
     * join Ville on Ville.id = Commerce.id_Ville 
     * where Commerce.id = 642
     */
    public function getRequeteLibelle() {
        $requete = sprintf('%s%d',$this->arbre_tables_colonnes->getRequete(),$this->getId());
        
        return $requete;
    }
    
    /**
     * Renvoie les données de la table dans un tableau pour y accéder facilement
     * Exemple : Une ligne de la table "Contenant"
        (
            [Contenant_nom] => Emballage
            [0] => Emballage
            [TypeContenant_nom] => Papier
            [1] => Papier
            [Contenant_quantite] => 1
            [2] => 1
            [Contenant_capacite] => 0
            [3] => 0
            [Contenant_capacite_reference] => 1000
            [4] => 1000
            [Unite_nom] => g
            [5] => g
            [Contenant_is_a_la_piece] => 1
            [6] => 1
        )
     * @global LIB_BDD $CXO
     * @return array Liste des données
     */
    public function getDonneesPourAffichage() {
        global $CXO;

        $requete = $this->getRequeteLibelle();
        
        $r = $CXO->executeRequete($requete);
        if ($r->isOk()) {
            foreach ($r->getResultat() as $ligne) {
                return $this->formatePourAffichage($ligne);
            }
        }
    }
    
    /**
     * Renvoie les données de la tablebloc 
     * Chaque donnée à pour index le tablonne
     * @return array donnees de la table 
     * Exemple:
    Array
    (
        [Enseigne_nom] => Auchan
        [Ville_nom] => Plaisir
        [Ville_code_postal] => 78370
        [Commerce_localisation] => Grand Plaisir
    )
     */
    public function getDonnees() {
        $donnees = $this->getDonneesPourAffichage();
        
        $tab = [];
        
        foreach ($donnees as $key => $value) {
            if (is_numeric($key)) {
                continue;
            }
            
            $tab[$key] = $value;
        }
        
        return $tab;
    }
    
    /**
     * Renvoie les données de la tablebloc
     * Sous forme d'un tableau de couples (tablonne,valeur)
     * C'est pour être itérable dans javascript
     * Exemple 
(
    [0] => Array
        (
            [tablonne] => Enseigne_nom
            [valeur] => -
        )

    [1] => Array
        (
            [tablonne] => Ville_nom
            [valeur] => -
        )

    [2] => Array
        (
            [tablonne] => Ville_code_postal
            [valeur] => -
        )

    [3] => Array
        (
            [tablonne] => Commerce_localisation
            [valeur] => -
        )

)     * @return array
     */
    public function getTableauDonnees() {
        $donnees = $this->getDonnees();
        
        $tab = [];
        
        foreach ($donnees as $key => $value) {
            if (is_numeric($key)) {
                continue;
            }
            
            $tab[] = ['tablonne' => $key , 'valeur' => $value ];
        }
        
        return $tab;
    }
    
    /**
     * Renvoie les données de la tablebloc sous forme de json
     * @return json
     * Exemple :
    {"Enseigne_nom":"Auchan","Ville_nom":"Plaisir","Ville_code_postal":"78370","Commerce_localisation":"Grand Plaisir"}
     */
    public function getSerializeDonnees() {
        return serialize($this->getDonnees());
    }
    
    private function formatePourAffichage($ligne) {
        
        foreach ($ligne as $nom_colonne => $valeur) {
            if (preg_match("/datation/", $nom_colonne) == 1) {
                $d = new LIB_Datation($valeur);
                $ligne[$nom_colonne] = $d->getDate_pourAffichage();
            }
            if (preg_match("/montant/", $nom_colonne) == 1) {
                $m = new LIB_MontantBase($valeur);
                $ligne[$nom_colonne] = $m->get_valeur_affichage();
            }
        }
        
        return $ligne;
    }
    
    /**
     * 
     * @return array Tableau des données formatées pour être utilisable
     * par le javascript.
     * Lequel va afficher les données dans les différents "input text" 
     * Exemple pour une ligne de la table "Commerce"
        (
            [0] => Array
                (
                    [id] => Enseigne_nom
                    [index] => Auchan
                )

            [1] => Array
                (
                    [id] => Ville_nom
                    [index] => Plaisir
                )

            [2] => Array
                (
                    [id] => Ville_code_postal
                    [index] => 78370
                )

            [3] => Array
                (
                    [id] => Commerce_localisation
                    [index] => Grand Plaisir
                )

        )
     */
    public function getDonneesPourMenuBloc() {
        $tab = $this->getDonneesPourAffichage();
        
        $donnees = [];
        foreach ($tab as $id => $index) {
            if (is_numeric($id)) {
                continue;
            }
            $donnees[] = ["id" => $id , "index" => $index];
        }
        
        return $donnees;
    }

    /**
     * Renvoi d'une chaîne pour résumer le contenu de l'élément
     * @global LIB_BDD $CXO 
     * Exemple :
    Auchan Plaisir 78370 Grand Plaisir
     */
    public function getLibelle() {
        global $CXO;
        
        $requete = $this->getRequeteLibelle();
        
        $libelle = "";

        $r = $CXO->executeRequete($requete);
        if ($r->isOk()) {
            foreach ($r->getResultat() as $ligne) {
                $n = count($ligne);
                $n2 = $n/2;
                $libelle = "";
                for($i = 0;$i < $n2;$i++){
                    $libelle = sprintf("%s %s",$libelle,$ligne[$i]);
                }
            }
        } else {
            $r->affiche();
            $libelle = "Y a un bucre dans la lecture du libellé";
        }

        return $libelle;
    }
    
    /**
     * Renvoie la valeur correspondant à l'index pour l'objet courant
     * @param type $index ("Table_colonne")
     * @return string Valeur trouvée
     */
    public function getValeurDeColonne($index) {
        $liste = $this->getDonneesPourAffichage();
        $valeur = $liste[$index];
        return $valeur;
    }

    /**
     * Charge les données de l'élément de la table.
     * Chargement dans un tableau constitué au fur et à mesure de la lecture de chaque colonne
     * @param int $id Id de l'achat
     * @return LIB_ResultatRequete Résultat action sur base
     */
    public function charge($id = 0) {
        if ($id != 0) {
            $this->id = $id;
        }
        if ($this->getId() == 0) {
        } else {
            return $this->chargePourModification();
        }
    }

    /**
     * Initialise l'élément vierge pour créer un nouvel élément
     * @global LIB_BDD $CXO 
     */
    private function initialiseColonnes() {
        global $CXO;

        $this->colonnes = new LIB_TableColonne_s();
        foreach (array_keys($this->liste_descriptions_colonnes) as $nomColonne) {
            $tc = new LIB_TableColonne($CXO->getSchema(), $this->nom_table, $nomColonne, $this->description_table);
            $this->colonnes->ajoute($tc, $nomColonne);
        }
    }

    /**
     * Charge l'élément pour modification des valeurs
     * @global LIB_BDD $CXO 
     * @return LIB_ResultatRequete Résultat action sur base
     */
    private function chargePourModification() {
        global $CXO;
        
        $requete = $this->getSqlSelect();
        $ret = $CXO->executeRequete($requete);
        if ($ret->isOk()) {
            $lignes = $ret->getResultat();
            foreach ($lignes as $ligne) {
                $this->setDeLigne($ligne);
            }
        }
        return $ret;
    }

    /**
     * Charge l'id en fonction des données
     * Si pas d'élément existant en fonction des données, id reste à 0
     * @global LIB_BDD $CXO 
     */
    public function chargeId($cree_auto = false) {
        global $CXO;
        
        $requete = $this->getSqlSelectId();
        
        $ret = $CXO->executeRequete($requete);
        if ($ret->isOk()) {
            $lignes = $ret->getResultat();
            foreach ($lignes as $ligne) {
                $this->setDeLigne($ligne);
            }
        }
        // Si demande de création automatique des éléments manquants ...
        if ($cree_auto) {
            // ... et si l'élément n'a pas été trouvé, le créer
            if ($this->getId() == 0) {
                $crdu = $this->insert();
                if ($crdu->isOk()) {
                    $this->chargeId();
                }
                
            }
        }
        $ret->afficheSiKo();
    }

    /**
     * Charge l'id en fonction des données
     * Si pas d'élément existant en fonction des données, id reste à 0
     * @param boolean $cree_auto Si = True : Si l'élément n'existe pas, il est créé automatiquement  
     * @global LIB_BDD $CXO 
     */
    public function chargeIdParNom($cree_auto = false) {
        global $CXO;
        // Recherche de l'élément en fonction de son nom
        $requete = sprintf("select id from %s where nom = '%s'",$this->nom_table,$this->getNom());
        $ret = $CXO->executeRequete($requete);
        if ($ret->isOk()) {
            $lignes = $ret->getResultat();
            foreach ($lignes as $ligne) {
                $this->setDeLigne($ligne);
            }
        }
        // Si demande de création automatique des éléments manquants ...
        if ($cree_auto) {
            // ... et si l'élément n'a pas été trouvé, le créer
            if ($this->getId() == 0) {
                $crdu = $this->insert();
                if ($crdu->isOk()) {
                    $this->chargeIdParNom();
                }
                
            }
        }
        $ret->afficheSiKo();
    }

    /**
     * Sauve l'élément dans la table
     */
    public function sauve() : LIB_CompteRendu {
        if ($this->getId() == 0) {
            $crdu = $this->insert();
        } else {
            $crdu = $this->update();
        }
        return $crdu;
    }

    /**
     * Crée l'élément dans la table
     * @global LIB_BDD $CXO 
     */
    private function insert() : LIB_CompteRendu  {
        global $CXO;
        $requete = $this->getSqlInsert();
        $ret = $CXO->executeRequete($requete);
        if ($ret->isOk()) {
            $this->setId($CXO->getLastId());
        }
        $crdu = $ret->getCompteRendu();
        return $crdu;
    }

    /**
     * Met à jour l'élément dans la table
     * @global LIB_BDD $CXO 
     */
    private function update() : LIB_CompteRendu  {
        global $CXO;

        $requete = $this->getSqlUpdate();
        $ret = $CXO->executeRequete($requete);
        $crdu = $ret->getCompteRendu();
        return $crdu;
    }

    /**
     * Supprime l'élément de la table.
     * @global LIB_BDD $CXO 
     */
    public function supprime() : LIB_CompteRendu  {
        global $CXO;
        
        $requete = $this->getSqlDelete();
        $ret = $CXO->executeRequete($requete);
        $crdu = $ret->getCompteRendu();
        return $crdu;
    }
    
    /**
     * Supprime inteligemment la ligne.
     * Si la ligne est utilisée par une table ascendante : Ne suprime pas
     * Supprime les lignes des tables descendantes.  Seulement si elles ne sont pas utilisées par d'autres lignes dans d'autre table
     * @global LIB_BDD $CXO
     * @global LIB_BDD_Structure $CXO_ST
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function supprimeIntelligemment() {
        global $CXO;
        global $CXO_ST;
        global $DOT;
        
        if (!$this->isExiste()) {
            return;
        }
        
        $o_s = $DOT->getObjet_s($this->nom_table);
        // Voir si la ligne est utilisée par au moins une ligne d'une table ascendante
        // - Charger liste des tables ascendantes
        $liste_tables_ascendantes = $o_s->getListeTablesLiees();
        
        // Pour chaque table ascendante, voir si il y a au moins une ligne liée vers la ligne courante
        $nb_utilisations_totales = 0;
        foreach ($liste_tables_ascendantes as $nom_table) {
            $o =  $DOT->getObjet_s($nom_table);
            $o->chargePourLienDescendant($this->nom_table,$this->getId());
            $nb_utilisations = $o->length();            
            
            $nb_utilisations_totales += $nb_utilisations;
        }
        // Oui : Fin
        if ($nb_utilisations_totales > 0) {
            return;
        }
        // Non : Supprimer la ligne
        $crdu = $this->supprime();
        
        if ($crdu->isKo()) {
            $crdu->affiche();
            return;
        }
        
        // Parcourir les colonnes "menu" de la ligne
        foreach ($this->colonnes->getListe() as $colonne) {
            if ($colonne->isMenu()) {
                // Pour chaque colonne :
                // - Supprimer intelligemment la ligne de la table correspondant à l'id de la colonne menu
                $nom_table_liee = $colonne->getNomTableLiee();
                
                $o = $DOT->getObjet($nom_table_liee);
                $o->setId($colonne->getValeur());
                $o->charge();
                $o->supprimeIntelligemment();
            }
        }
    }
    
    /**
     * Vide la table
     * @global LIB_BDD $CXO 
     */
    public function vide() : LIB_CompteRendu  {
        global $CXO;

        $requete = $this->getSqlVidage();
        $ret = $CXO->executeRequete($requete);
        $crdu = $ret->getCompteRendu();
        return $crdu;
    }
    
    /**
     * Supprime les liens avec d'autres éléments d'autres tables
     * @global LIB_BDD $CXO 
     * @global LIB_BDD_Structure $CXO_ST
     */
    private function supprimeLiens() {
        global $CXO;
        global $CXO_ST;
        $is = FALSE;

        $nomIdCleEtrangere = $this->getNomCleEtrangere();

        $s = $CXO->getSchema();
        $requeteST = "select `TABLE_NAME` from columns where table_schema = '$s' and column_name = '$nomIdCleEtrangere'";
        $retST = $CXO_ST->executeRequete($requeteST);
        if ($retST->isOk()) {
            foreach ($retST->getResultat() as $ligne) {
                $tableEtrangere = $ligne['TABLE_NAME'];
                $requete = "delete from $tableEtrangere where $nomIdCleEtrangere = $this->id";
                $ret = $CXO->executeRequete($requete);
                if ($ret->isOk()) {
                }
                else
                {
                    $ret->afficheSiKo();
                }
            }
        } else {
            $retST->afficheSiKo();
        }

    }

    /**
     * Teste si l'élément est utilisé dans une autre table
     * @global LIB_BDD $CXO 
     * @global LIB_BDD_Structure $CXO_ST
     * @return boolean
     */
    private function isIdUtilise() {
        global $CXO;
        global $CXO_ST;

        $is = FALSE;

        $nomIdCleEtrangere = $this->getNomCleEtrangere();

        $s = $CXO->getSchema();
        $requeteST = "select `TABLE_NAME` from columns where table_schema = '$s' and column_name = '$nomIdCleEtrangere'";
        $retST = $CXO_ST->executeRequete($requeteST);
        if ($retST->isOk()) {
            foreach ($retST->getResultat() as $ligne) {
                $tableEtrangere = $ligne['TABLE_NAME'];
                $requete = "select id from $tableEtrangere where $nomIdCleEtrangere = $this->id";
                $ret = $CXO->executeRequete($requete);
                if ($ret->isOk()) {
                    $nb = count($ret->getResultat());
                    if ($nb != 0) {
                        $is = TRUE;
                        break;
                    }
                }
            }
        } else {
            $retST->afficheSiKo();
        }

        return $is;
    }
    
    /**
     * Affiche le formulaire d'édition pour une proposition de transfert
     * @param int $id Id de l'élément dans ka base Courses
     */
    public function afficheEditionPropositionTransfert($id_destination) {
        $this->setId($id_destination);
        $this->charge();
        $this->afficheFormulaireTransfert();
    }
    
    /**
     * Affiche le formulaire d'édition de l'élément pour le transfert.
     */
    public function afficheEditionTransfert($table_source,$id_source) {
        $tm = new TT_TransfertTable($table_source);
        
        if ($tm->isExiste($id_source)) {
            $this->setDeJson($tm->getLibelle());
        } else {
            $this->setVide();
        }  
        $this->chargeId(true);
        
        $this->afficheFormulaireTransfert();
    }    
    
    private function afficheFormulaireTransfert() {
        ?>
        <div class="w3-container">
            <form id="formulaire-element-transfert" class="w3-container" method="POST" action="../ajax/ajax.php">
                <input type="hidden" id="id" name="id" value="<?php echo $this->id; ?>">
                <div class="w3-container-body">
                    <?php
                    $this->afficheDonneesTransfert();
                    ?>
                </div>
                <div class="w3-container">
                    <button id="element-associer" name="associer" class="w3-button w3-green" type="submit">Associer</button>
                    <button id="element-rejeter" name="rejeter" class="w3-button w3-amber" type="submit">Rejeter</button>
                    <button id="element-init" name="init" class="w3-button w3-yellow" type="submit">Init</button>
                </div>
            </form>
        </div>
        <div class="w3-modal" id="element-erreur-format">
            <div class="w3-modal-content">
                <div class="w3-container w3-amber">
                    <h4 class="modal-title">Vérification validité saisie dans la table : </H4><h3><span class="w3-blue"><?php echo $this->description_table->get_decription_titre(); ?></span></h3>
                </div>
                <div class="w3-container w3-sand">
                    <h4 class="w3-orange">Corrigez les erreurs</h4>
                    <button id="erreur_resume" onclick="gereAccordeon('erreur_detail')" class="w3-bouton w3-block w3-yellow w3-left-align"></button>
                    <div id="erreur_detail" class="w3-container w3-pale-yellow w3-hide"></div>

                </div>
                <div class="w3-container w3-amber">
                    <button class="w3-button w3-green" type="button" onclick="document.getElementById('element-erreur-format').style.display='none'">Ok</button>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Affiche les données du formulaire édition transfert
     */
    private function afficheDonneesTransfert() {
        $tab_donnees = $this->getDonneesPourAffichage();
        foreach ($tab_donnees as $key => $value) {
            
            if (is_numeric($key)) {
                continue;
            }
            
            $this->afficheUneDonneeTransfert($key, $value);
        }
    }
    
    private function afficheUneDonneeTransfert($index,$valeur) {
        ?>
        <div class="form-group">
            <label class="w3-text-indigo" for="<?php echo $index; ?>"><?php echo $index; ?></label>
            <div class="w3-container">
                <input type="text" class="w3-input INP_FRM_TR" id="<?php echo $index; ?>" value="<?php echo $valeur; ?>" name="<?php echo $index; ?>">
            </div>
        </div>
        <?php
    }

    /**
     * Affiche le formulaire d'édition de l'élément.
     */
    public function afficheEdition() {
        if ($this->id == 0) {
            $modeModification = FALSE;
        } else {
            $modeModification = TRUE;
        }
        ?>
        <div class="w3-container">
            <form id="formulaire-element" class="w3-container" method="POST" action="../ajax/ajax.php">
                <div class="w3-container-body">
                    <?php
                    $this->colonnes->afficheEdition();
                    ?>
                </div>
                <div class="w3-container">
                    <button id="element-annuler" name="annuler" class="w3-button w3-orange" type="submit">Annuler</button>
                    <?php
                    if ($modeModification) {
                        ?>
                        <button id="element-supprimer" name="supprimer" class="w3-button w3-red w3-right" type="submit" onclick="document.getElementById('element-supprimer-confirme').style.display='block'">Supprimer</button>
                        <button id="element-modifier" name="valider" class="w3-button w3-green w3-right" type="submit">Modifier</button>
                        <?php
                    } else {
                        ?>
                        <button id="element-ajouter" name="ajouter" class="w3-button w3-green w3-right" type="submit">Ajouter</button>
                        <?php
                    }
                    ?>
                </div>
            </form>
        </div>
        <div class="w3-modal" id="element-supprimer-confirme" >
            <div class="w3-modal-content">
                <div class="w3-container w3-amber">
                    <h4 class="modal-title">Suppression dans table <?php echo $this->description_table->get_decription_titre(); ?></h4>
                </div>
                <div class="w3-container w3-sand">
                    <p>
                        Voulez vous supprimer : </p>
                    <h4 class="w3-pale-yellow">
                        <?php
                        echo $this->getId() == 0 ? "" : $this->getLibelle();
                        ?>
                    </h4>
                    
                </div>
                <div class="w3-container w3-amber">
                    <button class="w3-button w3-green" type="button" onclick="document.getElementById('element-supprimer-confirme').style.display='none'">Non</button>
                    <button id="element-supprimer-oui" class="w3-button w3-orange" type="button"onclick="document.getElementById('element-supprimer-confirme').style.display='none'">Oui</button>
                </div>
            </div>
        </div>
        <div class="w3-modal" id="element-erreur-format">
            <div class="w3-modal-content">
                <div class="w3-container w3-amber">
                    <h4 class="modal-title">Vérification validité saisie dans la table : </H4><h3><span class="w3-blue"><?php echo $this->description_table->get_decription_titre(); ?></span></h3>
                </div>
                <div class="w3-container w3-sand">
                    <h4 class="w3-orange">Corrigez les erreurs</h4>
                    <button id="erreur_resume" onclick="gereAccordeon('erreur_detail')" class="w3-bouton w3-block w3-yellow w3-left-align"></button>
                    <div id="erreur_detail" class="w3-container w3-pale-yellow w3-hide"></div>

                </div>
                <div class="w3-container w3-amber">
                    <button class="w3-button w3-green" type="button" onclick="document.getElementById('element-erreur-format').style.display='none'">Ok</button>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Affiche l'élément dans le tableau affiché
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function afficheLigneTableau() {
        global $DOT;

        foreach ($this->liste_descriptions_colonnes as $nom_colonne => $description_table) {
            if ($nom_colonne == "id") {
                continue;
            }
            $tab = [];
            $liste_filtres = ["/^id_(VoF)_.*/","/^id_(.+)_h_$/","/^id_(.+)$/"];
            foreach ($liste_filtres as $filtre) {
                if (preg_match($filtre, $nom_colonne, $tab) == 1) {
                    $nom_classe = (sprintf("TBL_%s", $tab[1]));
                    $id = $this->getValeurColonne($nom_colonne);
                    $o = $DOT->getObjet($nom_classe);
                    $o->setId($id);
                    $o->charge();
                    $libelle = $o->getLibelle();
                    break;
                } 
            }
            if (preg_match("/^id_.*/", $nom_colonne, $tab) == 0) {
                $valeur = $this->getValeurColonne($nom_colonne);
                if (preg_match("/^datation/", $nom_colonne) == 1) {
                    $d = new LIB_Datation($valeur);
                    $valeur = $d->getDate_pourAffichage();
                }
                if (preg_match("/^montant/", $nom_colonne) == 1) {
                    $m = new LIB_MontantBase($valeur);
                    $valeur = $m->get_valeur_affichage();
                }
                $libelle = $valeur;
            }
        ?>
            <td><?php echo $libelle; ?></td>
        <?php
        }
    }

    /**
     * Affiche le bouton d'édition
     */
    protected function afficheBoutonEdit() {
        $code = $this->nom_table;
        $id = $this->getId();
        $sMod = "element-$code-$id";
        ?>
        <td>
            <a href="#" id="<?php echo $sMod; ?>">
                <span class="fa fa-edit w3-blue"></span>
            </a>
            <span class="w3-text-light-blue">
            <?php echo "Id = $this->id"; ?>
            </span>
        </td>
        <?php
    }

    /**
     * Affiche la ligne de données
     * @param boolean $modeGestion Vrai : Affiche entête un bouton pour permettre la modification
     */
    public function afficheLigne($modeGestion) {
        ?>
        <tr class="w3-hover-yellow">
            <?php
            if ($modeGestion) {
                $this->afficheBoutonEdit();
            }
            $this->afficheLigneTableau();
            ?>
        </tr>
        <?php
    }

    /**
     * Renvoie l'id de l'élément dans la table
     * @return entier
     */
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * Renvoie le nom de la table représentée par la table
     * @return string
     */
    protected function getNomTable() {
        $nc = $this->nom_classe;
        $tab = [];
        preg_match('@TBL_(.*)@i', $nc, $tab);
        return $tab[1];
    }

    private function getNomCleEtrangere() {
        $nt = $this->nom_table;
        return 'id_'.$nt;
    }

    public function getValeurColonne($nomColonne) {
        $s = $this->colonnes->getValeur($nomColonne);
        return $s;
    }

    public function setValeurColonne($nomColonne, $valeur) {
        $this->colonnes->setValeur($nomColonne, $valeur);
    }
    
    public function getNom() {
        return $this->colonnes->getValeur("nom");
    }

    /**
     * Renvoie la description de la table
     * @global LIB_BDD_Structure $CXO_ST
     * @global LIB_BDD $CXO 
     * 
     * @return string
     */
    private function initDescriptionTable() {
        global $CXO;
        global $CXO_ST;

        $nt = $this->nom_table;
        $s = $CXO->getSchema();
        $requete = "select table_comment from `tables` where table_schema = '$s' and table_name = '$nt'";
        $r = $CXO_ST->executeRequete($requete);
        if ($r->isOk()) {
            foreach ($r->getResultat() as $ligne) {
                $description = $ligne['table_comment'];
            }
        } else {
            $r->affiche();
            $description = '?';
        }
        $d = new LIB_Description($description);
        return $d;
    }

    public function getDescriptionTable() {
        return $this->description_table;
    }

    public function getListeNomsColonnes() {
        return $this->liste_descriptions_colonnes;
    }
    

    /**
     * Affiche la description de la table
     */
    public function checkafficheDescription() {
        ?>
        <h2><?php echo "Table des " . $this->getDescriptionTable(); ?></h2>
        <?php
    }

    /**
     * Affiche l'entête et l'enqueue des des tables
     */
    public function afficheEntete($modeGestion) {
        ?>
        <thead>
            <?php
            $this->afficheNomsColonnes($this->liste_descriptions_colonnes, $modeGestion);
            ?>
        </thead>
        <tfoot>
            <?php
            $this->afficheNomsColonnes($this->liste_descriptions_colonnes, $modeGestion);
            ?>
        </tfoot>
        <?php
    }

    /**
     * Affiche le nom des colonnes
     * Si mode gestion : Afficher en tête une colonne pour prévoir le bouton de modification dans les lignes
     * @param array $lnc
     * @param boolean $modeGestion
     */
    protected function afficheNomsColonnes($lnc, $modeGestion) {
        ?>
        <tr class="w3-lime">
            <?php
            if ($modeGestion) {
                ?>
                <th>Mod.</th>
                <?php
            }
            foreach ($lnc as $nomColonne => $descriptionColonne) {
                if ($nomColonne != 'id') {
                    ?>
                    <th><?php $descriptionColonne->ecrit_html_titre_colonne(); ?></th>
                    <?php
                }
            }
            ?>
        </tr>
        <?php
    }

    /**
     * Renvoie le nom de la classe de l'objet
     * @return string
     */
    private function getNomClasse() {
        return get_class($this);
    }
    
    public function calculeRequeteSelectLibelle(){
        $this->arbre_tables_colonnes = new LIB_ArbreTablesColonnes($this->nom_table);
        
        $this->collecteInformationsRequeteSelectLibelle($this->arbre_tables_colonnes);
        $this->arbre_tables_colonnes->calculeRequete();
    }
    
    public function collecteInformationsRequeteSelectLibelle($arbre_tables_colonnes) {
        $this->colonnes->collecteInformationsRequeteSelectLibelle($arbre_tables_colonnes);
    }

    public function getArbreTablesColonnes() {
        return $this->arbre_tables_colonnes;
    }
    
    public function getTypeColonne($nom_colonne) {
        $colonne = $this->colonnes->get($nom_colonne);
        
        $type = $colonne->getType();
        
        return $type;
    }
    
    public function getLiens() {
        global $CXO;
        global $DOT;
        
        $table_s = $DOT->getObjet_s($this->nom_table);
        
        $liste_tables_liees = $table_s->getListeTablesLiees();
        $tab_orphelins = [];
        
        foreach ($liste_tables_liees as $nom_table) {
            
            $id = $this->getId();
            
            $requete = "select id from $nom_table where id_$this->nom_table = $id";
            
            $rlt = $CXO->executeRequete($requete);
            
            if ($rlt->isOk()) {
                if ($rlt->getNbResultats() == 0) {
                    $tab_orphelins[] = $nom_table;
                }
            }
        }
        
        return $tab_orphelins;
    }
    
    /**
     * Renvoie si l'élément existe (l'id est renseigné)
     * @global LIB_BDD $CXO
     */
    public function isExiste() {
        global $CXO;
        
        $requete = "select id from $this->nom_table where id = $this->id";
        
        $rlt = $CXO->executeRequete($requete);
        
        $nb = 0;
            
        if ($rlt->isOk()) {
            $nb = $rlt->getNbResultats();
        } else {
            $rlt->afficheSiKo();
        }
        
        return $nb == 0 ? false : true;
    }
}
