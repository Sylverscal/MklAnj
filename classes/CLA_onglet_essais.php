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
        
        $texte_ins = "Rock'n'roll";
        $texte_ins_prepare = $CXO->quote($texte_ins);
        
//        $z = $DOT->getObjet("Zone");
//        
//        $z->setNom($texte);
//        
//        $z->sauve();
        
        $r_ins = "insert into Zone (nom) values ($texte_ins_prepare)"; 
        $ret_ins = $CXO->executeRequete($r_ins);
        
        if ($ret_ins->isKo()) {
            $ret_ins->affiche();
            return;
        }
        
        $filtre = $CXO->quote("rock");
        $r_sel_ins = "select id,nom from Zone where Zone.nom like 'rock%'";
        
        $ret_sel_ins = $CXO->executeRequete($r_sel_ins);
        
        $id = 0;
        if ($ret_sel_ins->isOk()) {
            foreach ($ret_sel_ins->getResultat() as $value) {
                LIB_Util::printR($value);
                $id = $value['id'];
                break;
            }
        } else {
            $ret_sel_ins->affiche();
            return;
        }
        
        $texte_upd = "Rythm'and'blues" ;
        $texte_upd_prepare = $CXO->quote($texte_upd);
        
        $r_upd = "update Zone set nom = $texte_upd_prepare where id=$id";
        
        $ret_upd = $CXO->executeRequete($r_upd);
        
        if ($ret_upd->isKo()) {
            $ret_upd->affiche();
            return;
        }
        
        $r_sel_upd = "select id,nom from Zone where Zone.id = $id";
        
        $ret_sel_upd = $CXO->executeRequete($r_sel_upd);
        
        if ($ret_sel_upd->isOk()) {
            foreach ($ret_sel_upd->getResultat() as $value) {
                LIB_Util::printR($value);
                break;
            }
        } else {
            $ret_sel_upd->affiche();
            return;
        }
        
        
        
        $r_del = "delete from Zone where id=$id";
        
        $ret_del = $CXO->executeRequete($r_del);
        
        if ($ret_del->isKo()) {
            $ret_del->affiche();
            return;
        }
        
        return;
    }
}
