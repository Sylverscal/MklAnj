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
    
    /**
     * Renvoie une requête composée à partir d'une donnée choisie 
     * dans les tables de données Commerce, ...
     * @param string $donnee Donnée filtre
     * Pour la donnée "Alpha park" de la table "Zone", 
     * la donnée fournie est "Zone@2" : Nom table + id de la ligne
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function getRequeteCreeSelonElementTable($donnee) {
        global $DOT;
        
        // récupérer la requête par défaut
        $id_requete = $this->getIdRequeteParDefaut();
        
        $r = $DOT->getObjet('Requete');
        $r->charge($id_requete);
        $requete = $r->getValeurColonne("requete");
        
        
        // Contrôle validité $donnee
        if (preg_match("/^.*@\d*$/", $donnee,$tab) == 0) {
            return $requete;
        }
        
        $tab = explode("@", $donnee);
        
        $nom_table = $tab[0];
        $id = $tab[1];
        
        $where = " Course.id_$nom_table = '$id' ";
        
        $requete_modifiee = str_replace("1=1", $where, $requete);
        
        return $requete_modifiee;
    }
}
