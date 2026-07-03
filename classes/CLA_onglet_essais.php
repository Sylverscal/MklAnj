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
     * @global LIB_BDD $CXO
     * @global LIB_BDD_Structure $CXO_ST
     * @global LIB_DistributeurObjetTable $DOT
     * @return type
     */
    final function affiche() {
        global $CXO;
        global $DOT;
        
        $c_s = $DOT->getObjet_s("Course");
        $c_s->charge();
        
        $c = $DOT->getObjet("Course");
        
        $tab = $c->getListeTablonnes();
        LIB_Util::printR($tab);
        
        
        
        LIB_Util::trace($c_s->getSqlSelectColonnes());
        
        $tablonne = "Article_nom";
        
        $c_s->trie($tablonne);
        
        foreach ($c_s as $c) {
//            LIB_Util::printR($c->getDonnees());
            LIB_Util::trace($c->getValeurDeColonne($tablonne));
        }
        
        $c_s->trie($tablonne, false);
        
        foreach ($c_s as $c) {
//            LIB_Util::printR($c->getDonnees());
            LIB_Util::trace($c->getValeurDeColonne($tablonne));
        }
        
        return;
    }
}
