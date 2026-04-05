<?php

/**
 * Description of home
 * 
 * Gestion de l'onglet principal "Home"
 *
 * @author veroscal
 */
class COU_onglet_home extends COU_onglet_principal {

    /**
     * Affiche la page d'accueil
     */
    #[\Override]
    final function affiche() {
?>
        <div class="w3-container">
            <div class="w3-panel ">
                <div class="w3-tag w3-xlarge w3-padding-large w3-round-large w3-yellow w3-text-red w3-center">
                    RELEVE DES ACHATS FAITS PENDANT LES COURSES
                </div>
            </div>
        </div>
        <?php
    }
}
