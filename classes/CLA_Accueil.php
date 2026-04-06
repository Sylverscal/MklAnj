<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_Accueil
 * 
 * Page d'accueil du logiciel
 *
 * @author sylverscal
 */
class CLA_Accueil {
    public function affiche() {
        ?>
        <div class="w3-container">
            <div class="w3-panel w3-warning w3-center">
                <h3><button id="BTN_ACC_RELEVE_COURSES" class="w3-button">Achats</button></h3>
            </div>        
            <div class="w3-panel w3-warning w3-center">
                <h3><button id="BTN_ACC_LISTE_COURSES" class="w3-button">Liste de courses</button></h3>
            </div>        
        </div>
        <?php
    }
}
