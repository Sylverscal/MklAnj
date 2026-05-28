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
        <div class="w3-container w3-lime">
            <div class="row">
                <div class="w3-container w3-threequarter">
                    <input id="INP_RCH_TEXTE" class="w3-input" type="text" placeholder="Taper le nom de la course à chercher">
                </div>
                <div class="w3-container w3-rest">
                    <button id="BTN_RCH_OK" class="w3-button w3-green w3-border w3-large w3-ripple w3-circle w3-right"><i class="fa fa-bicycle" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
        <?php
    }
}
