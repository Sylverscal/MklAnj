<?php

/**
 * Description of home
 * 
 * Gestion de l'onglet principal "Home"
 *
 * @author veroscal
 */
class MKL_onglet_mklanj extends MKL_onglet_principal {

    /**
     * Affiche la page d'accueil
     */
    #[\Override]
    final function affiche() {
        $this->affiche_entete("Achats");
        
        $a = new COU_Achats();
        $a->affiche();
    }
}

        