<?php

/**
 * Description of home
 * 
 * Gestion de l'onglet principal "Home"
 *
 * @author veroscal
 */
class CLA_onglet_home extends CLA_onglet_principal {

    /**
     * Affiche la page d'accueil
     */
    #[\Override]
    final function affiche() {
        $chemin_image = "https://mklanj:8890/image/Liste_courses_MichalAnge.jpg";
    ?>
        <div class="w3-container">
            <div class="w3-panel ">
                <div class="w3-tag w3-xlarge w3-padding-large w3-round-large w3-yellow w3-text-red w3-center">
                    LISTE DES COURSES
                </div>
            </div>
            <div class="w3-card-4">
                <div class="w3-container">
                    <p>Liste de courses faite par Michel Ange à un serviteur
                        <br>
                        Avec des dessins car il était analphabète.
                        <br>
                        1518
                    </p>
                </div>
                <img src="<?php echo $chemin_image; ?>" alt="Liste de courses de Michel Ange">
            </div>
            
        </div>
        <?php
    }
}
