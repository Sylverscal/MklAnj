<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of CLA_Filtrage
 *
 * @author sylverscal
 */
class CLA_Filtrage {
    /**
     * Affiche le bloc de filtrage
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function affiche() {
        $tab = $this->getDonneesMenuFiltres();
        
        ?>
        <div class="w3-container w3-lime w3-padding">
            <div class="w3-row">
                <div class="w3-col w3-right" style="width: 50px">
                    <button id="BTN_FTR_RAZ" class="w3-button w3-green w3-border w3-tiny w3-ripple w3-circle w3-right"><i class="fa fa-eraser" aria-hidden="true"></i></button>
                </div>
                <div class="w3-rest">
                    <select id="SEL_FTR" class="w3-select">
                        <?php
                        foreach ($tab as $value) {
                            ?>
                            <option value="<?php echo $value['valeur'] ?>"><?php echo $value['libelle'] ?></option>
                            <?php
                        }
                        ?>
                        <option value="0">Sans filtre</option>
                    </select>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Renvoie les données pour le menu filtre.
     * Il contient :
     * - Les requêtes de la table requête
     * - Les données constituées à partir des tables Commerce,Ville,Zone 
     * pour créer automatiquement des requêtes sur ces données
     */
    private function getDonneesMenuFiltres() {
        global $DOT;
        
        $r_s = $DOT->getObjet_s("Requete");
        
        $tab = $r_s->getListeRequetes();
        
        $f_s = $DOT->getObjet_s("Course");
        
        $tab = array_merge($tab,$f_s->getElementsAssocies("Commerce"));
        $tab = array_merge($tab,$f_s->getElementsAssocies("Ville"));
        $tab = array_merge($tab,$f_s->getElementsAssocies("Zone"));
        
        return $tab;
    }
    
}
