<?php

/**
 * Description of home
 * 
 * Gestion de l'onglet principal "Home"
 *
 * @author veroscal
 */
class CLA_onglet_liste_courses extends CLA_onglet_principal {

    /**
     * Affiche la page d'accueil
     */
    #[\Override]
    final function affiche() {
        $this->affiche_entete("Liste de courses");
        
        $a = new CLA_ListeCourses();
        $a->afficheEmplacementFonctionListeCourses();
    }
}

        