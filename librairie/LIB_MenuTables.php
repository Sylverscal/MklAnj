<?php

/**
 * Description of gestion_tables
 * 
 * Pour gérer la visualisation des tables
 *
 * @author veroscal
 */
class LIB_MenuTables {
    /**
     * @global LIB_BDD_Structure $CXO_ST
     */
    public function affiche() {
        global $CXO_ST;
        
        $lnt = $CXO_ST->getListeNomTables();
        ?>
        <div class="w3-container">
            <div class="w3-sidebar w3-bar-block w3-border" style="width:25%">
                <?php
                foreach ($lnt as $nt) {
                    $id = "GTB_BTN_$nt";
                    $description = $nt;
                    ?>
                    <button type="button" class="w3-bar-item w3-button w3-hover-deep-orange GTB_BTNS" id="<?php echo "$id"; ?>"><?php echo "$description"; ?></button>
                    <?php
                }
                ?>
            </div>
            <div style="margin-left: 25%">
                <div class="w3-container" id="GTB_DIV_CONTENU">
                    <div class="w3-container" id="GTB_DIV_TITRE"></div>
                    <div class="w3-container" id="GTB_DIV_CORPS"></div>
                </div>
            </div>
        </div>

        <?php
    }

}
