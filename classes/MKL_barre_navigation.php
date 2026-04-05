<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_barre_navigation
 *
 * @author sylverscal
 */
class MKL_barre_navigation {
    
    public function affiche($onglet_surligne) {
        ?>
        <div class="w3-container">
            <div class="w3-bar w3-border w3-yellow">
                
                <?php
                $this->affiche_bouton_accueil();
                $this->affiche_bouton_onglet("ACHATS","MKL_onglet_home", $onglet_surligne );
                $this->affiche_bouton_onglet("Courses","MKL_onglet_achats", $onglet_surligne );
                $this->affiche_bouton_onglet("Tables","MKL_onglet_tables", $onglet_surligne );
                $this->affiche_bouton_onglet("Administration","MKL_onglet_administration", $onglet_surligne );
                $this->affiche_bouton_onglet("Essais","MKL_onglet_essais", $onglet_surligne, true );
                ?>
            </div>
        </div>
        <?php
    }
    
    private function affiche_bouton_accueil() {
        ?>
            <a id="BTN_ACCUEIL" href="#" class="w3-bar-item w3-button"><i class="fa fa-home"></i></a>
        <?php
    }
    
    private function affiche_bouton_onglet($texte, $onglet, $onglet_surligne, $is_a_droite = false) {
        ?>
            <a id="<?php echo $onglet ?>" href="#" class="w3-bar-item w3-button <?php echo $is_a_droite ? " w3-right " : "" ?> <?php echo $onglet == $onglet_surligne ? "w3-blue " : "" ?> COU_bouton_onglet"><?php echo $texte ?></a>

        <?php
    }
}
