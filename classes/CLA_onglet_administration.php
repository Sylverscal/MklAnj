<?php

/**
 * Description of home
 * 
 * Gestion de l'onglet principal "Home"
 *
 * @author veroscal
 */
class CLA_onglet_administration extends CLA_onglet_principal {

    /**
     * Affiche la page d'accueil
     */
    #[\Override]
    final function affiche() {
        $this->affiche_entete("Administration");

        $this->affiche_menu();
    }

    private function affiche_menu() {
        ?>
        <div class="w3-container">
            <div class="w3-sidebar w3-bar-block w3-border" style="width:25%">
                <button type="button" class="w3-bar-item w3-button w3-hover-deep-orange ADM_BTNS" id="ADM_BTN_INIT_BASE">Initialisation Base</button>
            </div>
            <div style="margin-left: 25%">
                <div class="w3-container" id="ADM_DIV_CONTENU">
                    <div class="w3-container" id="ADM_DIV_TITRE"></div>
                    <div class="w3-container" id="ADM_DIV_CORPS"></div>
                </div>
            </div>
        </div>
        <?php
    }
}
            