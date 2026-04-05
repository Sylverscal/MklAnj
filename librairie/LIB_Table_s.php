<?php
include_once 'LIB_Liste.php';
include_once 'LIB_ResultatRequete.php';

/**
 * Description of LIB_Tables
 * 
 * Classe pour aporter des services communs au classes de liste d'objets correspondant
 * à des tables de la base de données
 *
 * @author C320688
 */
class LIB_Table_s extends LIB_Liste {
    /**
     * Nom de la table
     * @var string
     */
    private $nom_table;


    /**
     * Si faux (par défaut) : On est en mode affichage simple.
     * Si vrai : On est mode gestion (Ajout, Modification, Suppression)
     * @var boolean 
     */
    protected $modeGestion;

    /**
     * Nom de la classe de la table.
     * @var string Nom de la classe
     */
    private $nom_classe;

    /**
     * Nom de la classe des lignes de la table.
     * @var string Nom de la classe
     */
    private $nom_classe_table;

    /**
     * Description de la table
     * @var string Description
     */
    private $description;


    /**
     * Liste des noms de colonnes de la table
     * @var array
     */
    private $liste_noms_colonnes;

    /**
     * 
     * @global LIB_DistributeurObjetTable $DOT
     * @param type $nom_table Nom de la table si la classe LIB_Table_s est appelée directement.
     * Sinon c'est calculé à partir du nom de l'objet "TBL_<nom classe>_s" qui hérite de cette classe.
     */
    public function __construct($nom_table = "-") {
        global $DOT;
        parent::__construct();
        
        $this->setNomTable($nom_table);
        
        $this->nom_classe = sprintf("TBL_%s_s",$this->getNomTable());
        $this->nom_classe_table = sprintf("TBL_%s",$this->getNomTable());
        

        $this->modeGestion = false;
        
        $this->description = $this->getDescription();

        $nct = $this->getNomClasseTable();

        $o = $DOT->getObjet($nct);
        $this->liste_noms_colonnes = $o->getListeNomsColonnes();


    }
    
    /**
     * Renseigne le nom de la table
     * Si la valeur "nom_table", n'est pas renseignée, "-", 
     * le nome de la table est lu à partir du nom de la classe
     * @param string $nom_table
     */
    private function setNomTable($nom_table = "-") {
        if ($nom_table == "-") {
            $nc = get_class($this);
        $tab = [];
            preg_match('@TBL_(.*)_s@i', $nc, $tab);
            $nt = $tab[1];
            $this->nom_table = $nt;
        } else {
            $this->nom_table = $nom_table;
        }
    }

    /**
     * Renseigne le mode de gestion de la table.
     * @param boolean $modeGestion FAUX : Affichage simple , VRAI : Mode édition
     */
    public function setModeGestion($modeGestion) {
        $this->modeGestion = $modeGestion;
    }

    /**
     * Connexion à la base.
     * A redéfinir  
     */
    function connexionBase() {
        return new LIB_BDD();
    }

    /**
     * Execute une requête SQL
     * @param string $requete
     * @global LIB_BDD $CXO
     * @return type
     */
    protected function executeRequete($requete) {
        global $CXO;
        
        return $CXO->executeRequete($requete);
    }

    /**
     * Affiche le tableau des données
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function affiche() {
        global $DOT;
        
        $table = $DOT->getObjet($this->getNomClasseTable());
        if (!$this->modeGestion) {
            ?>
            <div class="w3-container w3-yellow"> 
                <?php $table->afficheDescription(); ?>
            </div>
            <?php
        }
        ?>
        <table id="LIB_Table" class="w3-table-all w3-hoverable w3-tiny" width="100%" cellspacing="0">
            <?php
            $table->afficheEntete($this->modeGestion);
            ?>
            <tbody>
                <?php
                foreach ($this as $element) {
                    $element->afficheLigne($this->modeGestion);
                }
                ?>
            </tbody>
        </table>
        <?php
        if ($this->modeGestion) {
            ?>
            <div>
                <button id="ajouter" class="w3-button w3-green" type="button">Ajouter</button>
            </div>
            <?php
        }
    }

    /**
     * Charge la liste des fonctions de la table
     * @global LIB_BDD $CXO
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function charge() {
        global $CXO;
        global $DOT;
        
        $r = $CXO->executeRequete($this->getSqlSelect());
        if ($r->isOk()) {
            foreach ($r->getResultat() as $ligne) {
                $o = $DOT->getObjet($this->getNomClasseTable());
                $o->setDeLigne($ligne);
                $this->ajoute($o);
            }
        } else {
            $r->affiche();
        }
    }
    
    /**
     * Charge les lignes qui sont liées à une table descendante 
     * Lien : colonne id.xxx ex Table Achat est liée à la table Article par la colonne id_Article
     * @param string $nom_table_liee Nom table descendante
     * @param int $id id des lignes de la table descendantes
     * @global LIB_BDD $CXO
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function chargePourLienDescendant($nom_table_liee,$id) {
        global $CXO;
        global $DOT;
        
        global $CXO;
        global $DOT;
        
        $requete = sprintf("select * from %s where id_%s = '%s'",$this->getNomTable(),$nom_table_liee,$id);
        
        $r = $CXO->executeRequete($requete);
        if ($r->isOk()) {
            foreach ($r->getResultat() as $ligne) {
                $o = $DOT->getObjet($this->getNomClasseTable());
                $o->setDeLigne($ligne);
                $this->ajoute($o);
            }
        } else {
            $r->affiche();
        }
    }
    
    

    /**
     * Renvoie la requête de sélections des éléments de la table.
     * Peut être surchargé si on veut faire une requête plus sophistiquée
     * @return string
     */
    protected function getSqlSelect() {
        $nt = $this->getNomTable();
        return "select * from $nt";
    }

    protected function trie($filtre) {
        
    }

    /**
     * Renvoie le nom de la classe de l'objet
     * @return string
     */
    private function getNomClasse() {
        return get_class($this);
    }
    
    /**
     * Renvoie le nom de la table représentée par la classe de l'objet
     * @return char nom de la table
     */
    private function getNomTable() {
        return $this->nom_table;
    }

    /**
     * Renvoie le nom de la classe de la tble
     * @return char nom de la classe de la table
     */
    private function getNomClasseTable() {
        $nc = $this->nom_classe;
        $tab = [];
        preg_match('@(.*)_s@i', $nc, $tab);
        $fc = $tab[1];
        return $fc;
    }

    /**
     * Renvoie la description de l atable
     * @global LIB_DistributeurObjetTable $DOT
     * @return char description de la table
     */
    public function getDescription() {
        global $DOT;
        
        $c = $DOT->getObjet($this->getNomClasseTable());
        return $c->getDescriptionTable();
    }

    /**
     * Affiche la fenêtre d'édition d'un élément
     * @param int $id id de l'élément à éditer
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function afficheEdition($id) {
        global $DOT;
        
        $c = $DOT->getObjet($this->getNomClasseTable());
        $c->charge($id);
        $c->afficheEdition();
    }

    /**
     * Affiche la fenêtre d'édition d'un élément pour le transfert
     * @param int $id id de l'élément à éditer
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function afficheEditionTransfert($id) {
        global $DOT;
        
        $c = $DOT->getObjet($this->getNomClasseTable());
        $c->charge($id);
        $c->afficheEditionTransfert();
    }

    /**
     * Ajoute l'élément dans la base
     * @param array $donnees
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function ajouteElement($donnees) {
        global $DOT;
        
        $c = $DOT->getObjet($this->getNomClasseTable());
        $crdu = $c->setDeLigne($donnees);
        LIB_Util::logPrintR($crdu);
        if (!$crdu->isOk()) {
            return $crdu;
        }
        $crdu = $c->sauve();

        return $crdu;
    }

    /**
     * Modifie les données d'un élément
     * @param type $id Id de l'élément
     * @param type $donnees Données de l'élément
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function modifieElement($id, $donnees) {
        global $DOT;
        
        $donnees[] = ['name' => 'id', 'value' => $id];

        $c = $DOT->getObjet($this->getNomClasseTable());
        $c->setDeLigne($donnees);
        $crdu = $c->sauve();

        return $crdu;
    }

    /**
     * Supprime un élément par son Id
     * @param type $id Id de l'élément à supprimer
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function supprimeElement($id) {
        global $DOT;
        
        $c = $DOT->getObjet($this->getNomClasseTable());
        $c->charge($id);
        $crdu = $c->supprime();

        return $crdu;
    }

    /**
     * Renvoie si un id existe
     * @param int $id Id recherche
     * @return boolean Vrai si existe, Faux si n'existe pas
     */
    public function isExisteId($id) {

        foreach ($this as $element) {
            if ($id == $element->getId()) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Renvoie la liste des noms de colonne.
     * Dans le tableau l'index est le nom de la colonne et la valeur est la description
     * Format tables
     * @return array
     */
    public function getListeNomsColonnes() {
        return $this->liste_noms_colonnes;
    }

    /**
     * Renvoie la section des noms de colonnes pour une requête select
     * @return string
     */
    protected function getSqlSelectColonnes() {
        $nt = $this->getNomTable();
        $liste = $this->getListeNomsColonnes();
        $tab = [];

        foreach (array_keys($liste) as $nomColonne) {
            $tab[] = "`$nt`.`$nomColonne`";
        }

        $s = implode(',', $tab);

        return $s;
    }

    /**
     * Renvoie la liste des lignes de la table sous forme d'un tableau
     * compatible avec l'input Select
     * Le libellé c'est le condensé de toutes les valeurs an aval d'une colonne.
     * @return array items à afficher dans le menu
     */
    public function getItemsPourInputSelect() {
        $this->charge();
        
        $items = [];
        
        foreach ($this as $ligne) {
            $valeur = $ligne->getId();
            $libelle = $ligne->getLibelle();
            
            $items[] = ["valeur" => $valeur , "libelle" => $libelle];
        }
        
        $colonneLibelle = array_column($items, "libelle");
        array_multisort($colonneLibelle, SORT_ASC,$items);
        
        return $items;
    }
    
    public function ordonneParLibelle($a, $b) {
        //retourner 0 en cas d'égalité
        if ($a->date == $b->date) {
            return 0;
        } else if ($a->date < $b->date) {//retourner -1 en cas d’infériorité
            return -1;
        } else {//retourner 1 en cas de supériorité 
            return 1;
        }
    }
    
    /**
     * Renvoie la liste des lignes de la table sous forme d'un tableau
     * compatible avec l'input Select
     * Le libellé c'est le condensé de toutes les valeurs an aval d'une colonne.
     * @return array items à afficher dans le menu
     */
    public function getItemsPourMenuFiltre() {
        $this->charge();
        
        $items = [];
        
        foreach ($this as $ligne) {
            $nom = $ligne->getNom();
            
            $items[] = $nom;
        }
        
        asort($items);
        
        return $items;
    }
    
    /**
     * Renvoie la liste des libelles de la table courante une fois filtrée.
     * @param array $donnees 
     * Exemple pour commerce pour renvoyer la liste des Auchan.
     * Note : id ne sert à rien mais il est dans le formulaire
    [donnees] => Array
        (
            [0] => Array
                (
                    [name] => id
                    [value] => 1293
                )

            [1] => Array
                (
                    [name] => Enseigne_nom
                    [value] => Auchan
                )

            [2] => Array
                (
                    [name] => Ville_nom
                    [value] => -
                )

            [3] => Array
                (
                    [name] => Ville_code_postal
                    [value] => -
                )

            [4] => Array
                (
                    [name] => Commerce_localisation
                    [value] => -
                )

        )
     * @return array Liste des ids des Commerces trouvés.  Pas besoin de plus d'informations,elles seront chargées des tables en temps voulu.
     * @global LIB_DistributeurObjetTable $DOT
     * @global LIB_BDD $CXO
     */
    public function getListeLignesFiltrees($donnees) {
        global $DOT;
        global $CXO;
        /**
         * Requete à constituer
            select Commerce.id as Commerce_id , Enseigne.nom as Enseigne_nom , Ville.nom as Ville_nom , Ville.code_postal as Ville_code_postal , Commerce.localisation as Commerce_localisation 
            from Commerce 
            join Enseigne on Enseigne.id = Commerce.id_Enseigne join Ville on Ville.id = Commerce.id_Ville 
            where 
            (1 = 1)
            and (Ville.nom like '%ais%')         
         */
        $o = $DOT->getObjet($this->nom_table);
        $atc = $o->getArbreTablesColonnes();
        
        $requete = $atc->getRequetePourFiltre($donnees);
        
        LIB_Util::log($requete);
        
        $ret = $CXO->executeRequete($requete);
        
        $tab = [];
        
        if ($ret->isOk()) {
            foreach ($ret->getResultat() as $value) {
                $id = $value['id'];
                $tab[] = $id;
            }
        }
        
        return $tab;
    }
    
    /**
     * Renvoie la liste des tables ascendantes à la table courantes 
     * @global type $CXO_ST
     * @return array
     * Exemple
        Nom table : Article
        Table liée :
        Array
        (
            [0] => Achat
        )
     */
    public function getListeTablesLiees() {
        global $CXO_ST;
        
        $nom_colonne_liee = sprintf("id_%s",$this->nom_table);
        
        $liste = $CXO_ST->getListeTablesPourUneColonne("Courses",$nom_colonne_liee);
        
        return $liste;
    }
    
    /**
     * Renvoie le tableau des lignes.
     * Pour chaque ligne : Liste tables vers lesquelles il n'y a pas de lien.
     * @return array
        Ex : Contenant
        (
            [3944] => Array
                (
                )

            [3945] => Array
                (
                )

            ...

            [4168] => Array
                (
                )

            [4169] => Array
                (
                    [0] => Conditionnement
                )
        )
     * Le contenant d'id 4169 est orphelin
     */
    public function getListeLiens() {
        $this->charge();
        
        $tab_liens_lignes = [];
        foreach ($this as $ligne) {
            $id = $ligne->getId();
            
            $tab_liens_lignes[$id] = $ligne->getLiens(); 
        }
        
        return $tab_liens_lignes;
    }
    
    /**
     * Renvoie le nombre de lignes orphelines.
     * Qui n'ont pas de liens vers la table ascendante
     * @return int
        Ex : Contenant
        (
            [0] => 4169
        )
     * Le contenant d'id 4169 est orphelin
     */
    public function getElementsNonLies() {
        $tab = [];
        
        $liste_liens = $this->getListeLiens();
        
        foreach ($liste_liens as $key => $value) {
            if (count($value) > 0) {
                $tab[] = $key;
            }
        }
        
        return $tab;
    }
    
    /**
     * Renvoie le nombre de lignes orphelines
     * @return int
     */
    public function getNbElementsNonLies() {
        return count($this->getElementsNonLies());
    }
    
}
