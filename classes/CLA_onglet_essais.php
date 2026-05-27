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

    
    
    /**
     * Affiche la page d'accueil
     */
    #[\Override]
    /**
     * 
     * @global LIB_BDD $CXO
     * @global LIB_BDD_Structure $CXO_ST
     * @global LIB_DistributeurObjetTable $DOT
     * @return type
     */
    final function affiche() {
        global $CXO_ST;
        global $CXO;
        global $DOT;
        
        $c_s = $DOT->getObjet_s("Course");
        
        $c = $c_s->getCoursePourArticle("Abricot");
        
        LIB_Util::trace($c);
        
        $caf = $DOT->getObjet("Course_AFaire_s");
        
        $caf->ouvre($c);
        
        
        
        return;
    }
}
