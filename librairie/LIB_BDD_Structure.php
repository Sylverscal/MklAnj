<?php

include_once 'LIB_BDD_MySQL_PDO.php';

/**
 * Description of LIB_BDD_Structure
 * 
 * Pour gérer la connexion à la base 'information_schema'
 *
 * @author C320688
 */
class LIB_BDD_Structure extends LIB_BDD_MySQL_PDO {
    protected $infos_systeme;
    protected $db;
    private $schema;
    /**
     * Etablit la connexion à la base
     */
    public function __construct() {
        $prm = new PRM_Structure();
        parent::__construct($prm);
        
        $this->ouvre();
        
        $this->infos_systeme = new LIB_infos_systeme();
                
        if ($this->infos_systeme->getLocal() == false) {
            $database = 'information_schema';
            $hostname = 'db5020579532.hosting-data.io';
            $password = '>P1eTa&6XTiNe@ST_PieRRe<';
            $username = 'dbu5155308';
            $this->schema = 'dbs15734873';
        } else {
            $database = 'information_schema';
            $hostname = 'localhost';
            $password = 'structure';
            $username = 'structure';
            $this->schema = 'MklAnj';
        }
        
        $this->db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $this->db->exec("SET CHARACTER SET utf8");
        
    }

    /**
     * Renvoie un tableau contenant le nom des tables de la base
     * @return array
     */
    public function getListeNomTables() {        
        $requete = "select `TABLE_NAME` from `TABLES` where `TABLE_SCHEMA` = '$this->schema'";
        $resultat = $this->db->query($requete);
        $tableNoms = [];
        if ($resultat === FALSE) {
                $this->trace('Ko');
                $this->trace($db->errorInfo()[0]);
                $this->trace($db->errorInfo()[1]);
                $this->trace($db->errorInfo()[2]);
        } else {
            $lignes = $resultat->fetchAll();
            foreach ($lignes as $ligne) {
                $nt = $ligne['TABLE_NAME'];
                $tableNoms[] = $nt;
            }
        }
        return $tableNoms;
    }
    
    /**
     * Renvoie la liste des colonnes d'une table
     * @param type $nom_table
     */
    public function getListeNomsColonnesTable($nom_table) {        
        $requete = "select COLUMN_NAME from `COLUMNS` where TABLE_SCHEMA = '$this->schema' and TABLE_NAME = '$nom_table' and COLUMN_NAME <> 'id'";
        $resultat = $this->db->query($requete);
        $tableNoms = [];
        if ($resultat === FALSE) {
                $this->trace('Ko');
                $this->trace($db->errorInfo()[0]);
                $this->trace($db->errorInfo()[1]);
                $this->trace($db->errorInfo()[2]);
        } else {
            $lignes = $resultat->fetchAll();
            foreach ($lignes as $ligne) {
                $nt = $ligne['COLUMN_NAME'];
                $tableNoms[] = $nt;
            }
        }
        return $tableNoms;
    }
    
    /**
     * Renvoie le tableau de la liste des descriptions des colonnes de la table
     * @return array
     */
    public function getListeDescriptionsColonnes($nom_table) {      
        $nt = $nom_table;
        $requete = "select column_name,column_comment from columns where table_schema = '$this->schema' and table_name = '$nt'";
        $resultat = $this->db->query($requete);
        $tableNoms = [];
        if ($resultat === FALSE) {
                $this->trace('Ko');
                $this->trace($db->errorInfo()[0]);
                $this->trace($db->errorInfo()[1]);
                $this->trace($db->errorInfo()[2]);
        } else {
            $lignes = $resultat->fetchAll();
            foreach ($lignes as $ligne) {
                $nc = $ligne[0];
                $tab = [];
                $liste_filtres = ["/^id_(VoF)_.*/", "/^id_(.+)_h_$/", "/^id_(.+)$/"];
                foreach ($liste_filtres as $filtre) {
                    $test = preg_match($filtre, $nc, $tab);
                    if ($test === 1) {
                        $ntl = $tab[1];
                        $requete_table_liee = "select table_comment from `tables` where table_schema = '$this->schema' and table_name = '$ntl'";
                        $r = $this->executeRequete($requete_table_liee);
                        $desc = "Description ?";
                        if ($r->isOk()) {
                            foreach ($r->getResultat() as $ligne) {
                                $desc = $ligne[0];
                            }
                        }
                        $dc = new LIB_Description($desc);
                        break;
                    }
                }
                if (preg_match("/^id_.*/", $nc, $tab) == 0) {
                    $dc = new LIB_Description($ligne[1]);
                }
                $tableNoms[$nc] = $dc;
            }
        }

        return $tableNoms;
    }

    /**
     * Renvoie si une table existe
     * @param type $nom_table
     * @return type
     */
    public function isExisteTable($nom_table) {        
        $requete = "select `TABLE_NAME` from `TABLES` where `TABLE_SCHEMA` = '$this->schema' AND `TABLE_NAME` = '$nom_table'";
        $resultat = $this->db->query($requete);
        $n = 0;
        if ($resultat === FALSE) {
                $this->trace('Ko');
                $this->trace($db->errorInfo()[0]);
                $this->trace($db->errorInfo()[1]);
                $this->trace($db->errorInfo()[2]);
        } else {
            $lignes = $resultat->fetchAll();
            foreach ($lignes as $ligne) {
                $n++;
            }
        }
        return $n == 0 ? false : true;
    }
    
    /**
     * Renvoie la liste des tables contenant une colonne.
     * Surtout pour 
     * @param type $base
     * @param type $nom_colonne
     */
    public function getListeTablesPourUneColonne($base,$nom_colonne) {
        $requete = "SELECT `TABLE_NAME` as nom_table FROM `COLUMNS` WHERE `TABLE_SCHEMA` = '$this->schema' and `COLUMN_NAME` = '$nom_colonne'";
        
        $resultat = $this->db->query($requete);
        
        $tab = [];
        if ($resultat === FALSE) {
                $this->trace('Ko');
                $this->trace($db->errorInfo()[0]);
                $this->trace($db->errorInfo()[1]);
                $this->trace($db->errorInfo()[2]);
        } else {
            $lignes = $resultat->fetchAll();
            foreach ($lignes as $value) {
                $tab[] = $value['nom_table'];
            }
        }
        
        return $tab;
    }
    
    public function getSchema() {
        return $this->schema;
    }

}
