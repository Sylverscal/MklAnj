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
            <select class="w3-select">
                <?php
                foreach ($tab as $value) {
                    ?>
                    <option value="<?php echo $value['valeur'] ?>"><?php echo $value['libelle'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <?php
    }
}
