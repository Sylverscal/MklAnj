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
        
        $requete_lecture = "select id,nombre,capacite from Course";
        
        $rlt = $CXO->executeRequete($requete_lecture);
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
                LIB_Util::printR($value);
                $id = $value['id'];
                $nombre = $value['nombre'];
                $capacite = $value['capacite'];
                
                $q = $DOT->getObjet("Quantite");
                $tab = array($nombre);
                $q->set(...$tab);
                $q->sauve();
                $q->set(...$tab);
                $q->chargeIdParNom($nombre);
                $id_q = $q->getId();
                LIB_Util::trace("Id q : $id_q");
                
                $c = $DOT->getObjet("Capacite");
                $tab = array($capacite);
                $c->set(...$tab);
                $c->sauve();
                $c->set(...$tab);
                $c->chargeIdParNom($nombre);
                $id_c = $c->getId();
                LIB_Util::trace("Id c : $id_c");
                
                $requete_maj = "update Course set id_Quantite = $id_q ,id_capacite = $id_c where id = $id ";
                
                $rlt = $CXO->executeRequete($requete_maj);
                $rlt->affiche();
            }
        } else {
            $rlt->affiche();
        }
        
        return;
    }
}
