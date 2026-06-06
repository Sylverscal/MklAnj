<?php // content="text/plain; charset=utf-8"
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_essais
 * 
 * Pour faire des essais d'affichages
 *
 * @author sylverscal
 */
        
class CLA_onglet_essais extends CLA_onglet_principal {

    private $db;
    
    /**
     * Affiche la page d'accueil
     */
    #[\Override]
    /**
     * 
     * @global LIB_BDD $CXOXXX
     * @global LIB_BDD_Structure $CXO_ST
     * @global LIB_DistributeurObjetTable $DOT
     * @return type
     */
    final function affiche() {
        $this->erreur = "";
        try {
	    // H = 'db5020579532.hosting-data.io' , DB = 'MklAnj' , UN = 'dbu5155308', PW = '>P1eTa&6XTiNe@ST_PieRRe<'
            $this->db = new PDO(sprintf("mysql:host=%s;dbname=%s",'db5020579532.hosting-data.io','dbs15734873'), 'dbu5155308', '>P1eTa&6XTiNe@ST_PieRRe<');
            $this->db->exec("SET CHARACTER SET utf8");
        } catch (Exception $e) {
            $this->erreur = $e->getMessage();
            LIB_Util::logPrintR($e);
        }
        
        $requete = "select id,nom from Unite";
        
        $resultat = $this->db->query($requete);
        if ($resultat === FALSE) {
            $this->trace('Ko');
            $this->trace($this->db->errorInfo()[0]);
            $this->trace($this->db->errorInfo()[1]);
            $this->trace($this->db->errorInfo()[2]);
        } else {
            $lignes = $resultat->fetchAll();
            foreach ($lignes as $ligne) {
                LIB_Util::printR($ligne);
                $nom = $ligne['nom'];
                $id = $ligne['id'];
                LIB_Util::trace("$id $nom");
            }
        }
        
        LIB_Util::trace("-------------");
        
        $CXO_ST = new LIB_BDD_Structure();
        
        $tab = $CXO_ST->getListeNomTables();
        
        LIB_Util::printR($tab);
        
        $tab = $CXO_ST->getListeNomsColonnesTable("Course");
        
        LIB_Util::printR($tab);
        
        $is = $CXO_ST->isExisteTable("Course");
        LIB_Util::trace($is ? "Existe" : "Existe pas");
        $is = $CXO_ST->isExisteTable("Foo");
        LIB_Util::trace($is ? "Existe" : "Existe pas");
        
        $tab = $CXO_ST->getListeTablesPourUneColonne("MklAnj", "nom");
        
        LIB_Util::printR($tab);
        
        
        return;
    }
}
