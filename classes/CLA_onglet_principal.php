<?php

/**
 * Description of onglet_principal
 * 
 * Propriétés communes aux onglets
 *
 * @author Sylverscal
 */
abstract class CLA_onglet_principal {

    public function __construct() {
        $this->affiche();
    }

    /**
     * Affichage de l'onglet
     */
    protected abstract function affiche();
    
    protected function affiche_entete($texte) {
?>
            <div class="w3-container w3-teal">
                <h2><?php echo $texte ?></h2>
            </div>
        <?php
    }
}
