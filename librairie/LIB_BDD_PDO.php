<?php

include_once 'LIB_Util.php';
include_once 'LIB_ResultatRequete.php';

/**
 * C_ConnexionBase
 * 
 * Gestion connexion à une base
 *
 * @author C320688
 */
abstract class LIB_BDD_PDO {

    protected $db;
    protected $erreur;
    private $prm;

    public function __construct($prm) {
        $this->db = NULL;
        $this->prm = $prm;
        $this->erreur = '';
    }
    
    public function getParametrage() {
        return $this->prm;
    }

    public abstract function ouvre();

    public function getDb() {
        return $this->db;
    }

    public function getErreur() {
        if ($this->erreur == '') {
            return 'Bon';
        } else {
            return $this->erreur;
        }
    }
    
    /**
     * Renvoie l'id créé à la dernière insertion
     * @return int id
     */
    public function getLastId() {
        $requete = "SELECT LAST_INSERT_ID() as id";
        
        $resultat = $this->executeRequete($requete);
        $id = 0;
        if ($resultat->isOk()) {
            foreach ($resultat->getResultat() as $ligne) {
                $id = $ligne['id'];
            }
        }
        return $id;
    }

    public function executeRequete($requete) : LIB_ResultatRequete {
        set_time_limit(120);
        $retour = new LIB_ResultatRequete();
        $test = preg_match("@^SELECT@i", $requete);
        if ($test == 1) {
            try {
                $resultat = $this->db->query($requete);
                if ($resultat === FALSE) {
                    $retour->setErreur(0, "Erreur dans requete", $requete);
                } else {
                    $lignes = $resultat->fetchAll();
                    $retour->setResultat($lignes, $requete);
                }
            } catch (PDOException $e) {
                $retour->setErreur($e->getCode(), $e->getMessage(), $requete);
            }
        } else {
            try {
                $rlt = $this->db->exec($requete);
                if ($rlt === FALSE) {
                    $retour->setErreur($this->getDb()->errorInfo()[0] . ":" . $this->getDb()->errorInfo()[1], $this->getDb()->errorInfo()[2], $requete);
                } else {
                    $retour->setResultat($rlt, $requete);
                }
            } catch (PDOException $e) {
                $retour->setErreur($e->getCode(), $e->getMessage(), $requete);
            }
        }
        return $retour;
    }
    
    public function getSchema() {
        return $this->prm->schema;
    }
    
}
