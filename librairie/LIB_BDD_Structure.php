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

    /**
     * Etablit la connexion à la base
     */
    public function __construct() {
        parent::__construct(new PRM_Structure());
        
        $this->ouvre();
    }

    /**
     * Renvoie un tableau contenant le nom des tables de la base
     * @global LIB_BDD $CXO 
     * @return array
     */
    public function getListeNomTables() {
        global $CXO;
        
        $schema = $CXO->getSchema();
        $requete = "select `TABLE_NAME` from `TABLES` where `TABLE_SCHEMA` = '$schema'";
        $resultat = $this->executeRequete($requete);
        $tableNoms = [];
        if ($resultat->isOk()) {
            foreach ($resultat->getResultat() as $ligne) {
                $nt = $ligne['TABLE_NAME'];
                $tableNoms[] = $nt;
            }
        }
        return $tableNoms;
    }
    
    /**
     * Renvoie la liste des colonnes d'une table
     * @global LIB_BDD $CXO 
     * @param type $nom_table
     */
    public function getListeNomsColonnesTable($nom_table) {
        global $CXO;
        
        $schema = $CXO->getSchema();
        $requete = "select COLUMN_NAME from `COLUMNS` where TABLE_SCHEMA = '$schema' and TABLE_NAME = '$nom_table' and COLUMN_NAME <> 'id'";
        $resultat = $this->executeRequete($requete);
        $tableNoms = [];
        if ($resultat->isOk()) {
            foreach ($resultat->getResultat() as $ligne) {
                $nt = $ligne['COLUMN_NAME'];
                $tableNoms[] = $nt;
            }
        }
        return $tableNoms;
    }
    
    /**
     * Renvoie le tableau de la liste des descriptions des colonnes de la table
     * @global LIB_BDD $CXO 
     * @return array
     */
    public function getListeDescriptionsColonnes($nom_table) {
        global $CXO;
        
        $nt = $nom_table;
        $s = $CXO->getSchema();
        $requete = "select column_name,column_comment from columns where table_schema = '$s' and table_name = '$nt'";
        $r = $this->executeRequete($requete);
        $tableNoms = [];
        if ($r->isOk()) {
            foreach ($r->getResultat() as $ligne) {
                $nc = $ligne['column_name'];
                $tab = [];
                $liste_filtres = ["/^id_(VoF)_.*/", "/^id_(.+)_h_$/", "/^id_(.+)$/"];
                foreach ($liste_filtres as $filtre) {
                    $test = preg_match($filtre, $nc, $tab);
                    if ($test === 1) {
                        $ntl = $tab[1];
                        $requete_table_liee = "select table_comment from `tables` where table_schema = '$s' and table_name = '$ntl'";
                        $r = $this->executeRequete($requete_table_liee);
                        $desc = "Description ?";
                        if ($r->isOk()) {
                            foreach ($r->getResultat() as $ligne) {
                                $desc = $ligne['table_comment'];
                            }
                        }
                        $dc = new LIB_Description($desc);
                        break;
                    }
                }
                if (preg_match("/^id_.*/", $nc, $tab) == 0) {
                    $dc = new LIB_Description($ligne['column_comment']);
                }
                $tableNoms[$nc] = $dc;
            }
        } else {
            $r->affiche();
        }

        return $tableNoms;
    }

    /**
     * Renvoie si une table existe
     * @param type $nom_table
     * @global LIB_BDD $CXO 
     * @return type
     */
    public function isExisteTable($nom_table) {
        global $CXO;
        
        $schema = $CXO->getParametrage()->getSchema();
        $requete = "select `TABLE_NAME` from `TABLES` where `TABLE_SCHEMA` = '$schema' AND `TABLE_NAME` = '$nom_table'";
        $resultat = $this->executeRequete($requete);
        $n = 0;
        if ($resultat->isOk()) {
            foreach ($resultat->getResultat() as $ligne) {
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
        $requete = "SELECT `TABLE_NAME` as nom_table FROM `COLUMNS` WHERE `TABLE_SCHEMA` = '$base' and `COLUMN_NAME` = '$nom_colonne'";
        
        $rlt = $this->executeRequete($requete);
        
        $tab = [];
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
                $tab[] = $value['nom_table'];
            }
        }
        
        return $tab;
    }
    
    

}
