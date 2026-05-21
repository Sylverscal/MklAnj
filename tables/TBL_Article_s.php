<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of TBL_Article_s
 *
 * @author sylverscal
 */
class TBL_Article_s extends LIB_Table_s {
    /**
     * Renvoie la liste des articles pas encore utilisés dans une course
     * @global LIB_BDD $CXO
     */
    public function getArticlesInutilises() {
        global $CXO;
        
        $requete = "SELECT Article.id as id,Article.nom as nom FROM Article
            left join Course on Course.id_Article = Article.id
            where Course.id is null";
        
        
        $rlt = $CXO->executeRequete($requete);
        
        $tab = [];
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
                $tab[] = ["valeur" => $value['id'] , "libelle" => $value['nom']];
            }
        }
        
        $rlt->afficheSiKo();
        
        return $tab;
    }
}
