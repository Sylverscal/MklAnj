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
        global $DOT;
        
        $r_s = $DOT->getObjet_s("Requete");
        
        $tab = $r_s->getItemsPourInputSelect();
        
        ?>
        <div class="w3-container w3-lime w3-padding">
            <div class="w3-row">
                <div class="w3-col w3-right" style="width: 50px">
                    <button id="BTN_FTR_RAZ" class="w3-button w3-green w3-border w3-tiny w3-ripple w3-circle w3-right"><i class="fa fa-eraser" aria-hidden="true"></i></button>
                </div>
                <div class="w3-rest">
                    <select id="SEL_FTR" class="w3-select">
                        <option value="0">Sans filtre</option>
                        <?php
                        foreach ($tab as $value) {
                            ?>
                            <option value="<?php echo $value['valeur'] ?>"><?php echo $value['libelle'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <?php
    }
}
