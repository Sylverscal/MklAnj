<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of CLA_Recherche
 *
 * @author sylverscal
 */
class CLA_Recherche {
    public function affiche() {
        ?>
        <div class="w3-container w3-lime w3-padding">
            <div class="w3-row">
                <div class="w3-col w3-right" style="width: 50px">
                    <button id="BTN_RCH_RAZ" class="w3-button w3-green w3-border w3-large w3-ripple w3-circle w3-right"><i class="fa fa-eraser" aria-hidden="true"></i></button>
                </div>
                <div class="w3-rest">
                    <input id="INP_RCH" class="w3-input" type="text" placeholder="Taper le nom de la course à chercher">
                    
                </div>
            </div>
        </div>
        <?php
    }
}
