<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of LIB_DistributeurObjetTable
 * 
 * Classe pour servir de distributeur d'objet cloné.
 * Au lieu de créer un objet à chaque fois ce qui prend beaucoup plus de temps.
 * Cette classe sert à créer des objets pour le module d'accès aux tables 
 * en se basant sur la structure de la base.
 * Pour d'autres objets utiliser la classe "COU_DistributeurObjetTable".
 *
 * @author sylverscal
 */
class LIB_DistributeurObjetTable {
    private $liste_tables;
    
    public function __construct() {
        $this->liste_tables = [];
    }
    
    public function constitueListeTable() {
        $bs = new LIB_BDD_Structure();
        
        $liste_nom_tables = $bs->getListeNomTables();
        
        $this->liste_tables = [];
        
        foreach ($liste_nom_tables as $nom_table) {
            $nom_classe_table = sprintf("TBL_%s", $nom_table);
            if (LIB_Util::isExisteFichierClasseTable($nom_table)) {
                $this->liste_tables[$nom_classe_table] = new $nom_classe_table();
            } else {
                $this->liste_tables[$nom_classe_table] = new LIB_Table($nom_table);
            }
            
            $nom_classe_table_s = sprintf("%s_s", $nom_classe_table);
                        
            $this->liste_tables[$nom_classe_table_s] = new LIB_Table_s($nom_table);
            
        }
                
    }
    
    /**
     * Renvoie l'objet table
     * @param type $nom_table
     * @return \nom_classe_table
     */
    public function getObjet($nom_table) {
//        global $DOT_COU;

        $nom_classe_table = strpos($nom_table, "TBL_") !== 0 ? sprintf("TBL_%s", $nom_table) : $nom_table;
        
//        if ($DOT_COU->isExisteObjet($nom_classe_table)) {
//            return $DOT_COU->getObjet($nom_classe_table);
//        }
//
        if (isset($this->liste_tables[$nom_classe_table])) {
            return clone $this->liste_tables[$nom_classe_table];
        }
        
        return new $nom_classe_table();
    }
    
    /**
     * Renvoie l'objet table
     * @param type $nom_table
     * @return \nom_classe_table
     */
    public function getObjet_s($nom_table) {

        $nom_classe_table = preg_match("/^TBL_.*_s$/", $nom_table) == 1 ? $nom_table : sprintf("TBL_%s_s", $nom_table);

        if (isset($this->liste_tables[$nom_classe_table])) {
            return clone $this->liste_tables[$nom_classe_table];
        }
        
        return new $nom_classe_table();
    }
    
    /**
     * Calcule la requête select de libellé pour toutes les tables 
     */
    public function calculeRequeteSelectLibelle() {
        foreach ($this->liste_tables as $index => $table) {

            $test = preg_match('@TBL_(.*)_s$@i', $index);
            if ($test === 1) {
                continue;
            }

            $table->calculeRequeteSelectLibelle();
        }
    }
}
