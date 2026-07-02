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
        
        foreach ($c_s as $c) {
            LIB_Util::printR($c->getDonnees());
            LIB_Util::trace($c->getValeurDeColonne("Marque_nom"));
            
            $tablonne = "Marque_nom";
            
            $c->isExisteTablonne($tablonne) ? LIB_Util::trace("$tablonne existe") : LIB_Util::trace("$tablonne inconnu");
            
            $tablonne = "Requete_rexete";
            
            if ($c->isExisteTablonne($tablonne)) {
            LIB_Util::trace("$tablonne existe");}else{LIB_Util::trace("$tablonne inconnu");
            }
        }
        
        return;
    }
}
