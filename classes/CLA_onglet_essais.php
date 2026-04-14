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
        global $DOT;
        
        $c = $DOT->getObjet("Course");
        
        $r = $c->getRequeteLibelle();
        
        
        LIB_Util::trace($r);
        
        $c->setId(2);
        $c->charge();
        
        $d = $c->getDonneesPourAffichage();
        LIB_Util::printR($d);

        $d = $c->getDonnees();
        LIB_Util::printR($d);

        return;
    }
}
