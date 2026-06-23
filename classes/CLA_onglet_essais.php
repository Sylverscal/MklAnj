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
        
        $d = new LIB_Datation();
        $nbj = $d->getNbJoursMois();
        LIB_Util::trace($d->getDate_DD_MM_AAAA()." : ".$nbj);
        LIB_Util::trace($d->isBissextile()?"Bissextile":"Pff");
        LIB_Util::trace($d->getNbSemainesMois());
        LIB_Util::trace($d->getNumeroJourSemaine());
        LIB_Util::trace();
        
        $d = new LIB_Datation("25-02-2024");
        $nbj = $d->getNbJoursMois();
        LIB_Util::trace($d->getDate_DD_MM_AAAA()." : ".$nbj);
        LIB_Util::trace($d->isBissextile()?"Bissextile":"Pff");
        LIB_Util::trace($d->getNbSemainesMois());
        LIB_Util::trace($d->getNumeroJourSemaine());
        LIB_Util::trace();
        
        
        $d = new LIB_Datation("21-06-2026");
        $nbj = $d->getNbJoursMois();
        LIB_Util::trace($d->getDate_DD_MM_AAAA()." : ".$nbj);
        LIB_Util::trace($d->isBissextile()?"Bissextile":"Pff");
        LIB_Util::trace($d->getNbSemainesMois());
        LIB_Util::trace($d->getNumeroJourSemaine());
        LIB_Util::trace();
        
        $d = new LIB_Datation("25-02-2021");
        $nbj = $d->getNbJoursMois();
        LIB_Util::trace($d->getDate_DD_MM_AAAA()." : ".$nbj);
        LIB_Util::trace($d->isBissextile()?"Bissextile":"Pff");
        LIB_Util::trace($d->getNbSemainesMois());
        LIB_Util::trace($d->getNumeroJourSemaine());
        LIB_Util::trace();
        
        $d = new LIB_Datation();
        for ($i = 0;$i < 7;$i++) {
            LIB_Util::trace($d->getDate_DD_MM_AAAA()." : ".$d->getNumeroJourSemaine());
            $d->incrementeJour();
            
        }
        
        return;
    }
}
