<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of CLA_GestionRequetes
 *
 * @author sylverscal
 */
class CLA_GestionRequetes {
    public function affiche_bloc() {
        $this->affiche_entete();
        
        $this->affiche_corps();
    }
    
    private function affiche_entete() {
        ?>
            <div class="w3-container w3-light-blue">
                <h2>Gestion des requêtes</h2>
                <h4>Outil pour simplifier la gestion des requêtes</h4>
            </div>
        <?php
    }
    
    private function affiche_corps() {
        ?>
            <div class="w3-container w3-pale-blue">
                <h3>En travaux</h3>
            </div>
        <?php
    }
       
}
