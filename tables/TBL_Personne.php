<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of TBL_Personne
 *
 * @author sylverscal
 */
class TBL_Personne extends LIB_Table{
    
    /**
     * renvoie si le login est correct
     * @param type $login
     * @param type $mot_de_passe
     * @global LIB_BDD $CXO
     * @return bool True si login existe
     */
    public function isLoginOk($login,$mot_de_passe) {
        global $CXO;
        
        $requete = "select id from Personne where login = '$login' and mot_de_passe = '$mot_de_passe'";
        
        $rlt = $CXO->executeRequete($requete);
        
        if ($rlt->getNbResultats() == 0) {
            return false;
        }
        
        return true;
    } 
}
