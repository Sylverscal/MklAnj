<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of TBL_Requete_s
 *
 * @author sylverscal
 */
class TBL_Requete_s extends LIB_Table_s{
    /**
     * renvoie la liste des requêtes
     * @global LIB_BDD $CXO
     */
    public function getListeRequetes(){
        global $CXO;
        
        $requete = "select id,nom from Requete order by ordre";
        
        $rlt = $CXO->executeRequete($requete);
        
        $items = [];
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
                $valeur = $value['id'];
                $libelle = $value['nom'];
                
                $items[] = ["valeur" => $valeur , "libelle" => $libelle];
            }
        }
        
        return $items;
    }
    
    /**
     * renvoie la requête à envoyer par défaut
     * @global LIB_BDD $CXO
     */
    public function getIdRequeteParDefaut() {
        global $CXO;
        
        $requete = "select id from Requete where defaut = 1";
        
        $rlt = $CXO->executeRequete($requete);
        
        $id = 0;
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
                $id = $value['id'];
            }
        }
        
        return $id;
    }
}
