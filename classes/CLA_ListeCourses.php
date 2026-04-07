<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_Achats
 * 
 * Classe pour gérer les achats.
 *
 * @author sylverscal
 */
class CLA_ListeCourses {
    /**
     * Liste des achats
     * @var TBL_Achat_s
     */
    private $liste;
    
    public function __construct() {
        $this->liste = new TBL_Achat_s();
    }
    
    
    final function affiche() {
        ?>
        <div id="DIV_ACH_GDA" class="w3-container">
            <h1>Poste de commande</h1>
        </div>
        <div id="DIV_ACH_ACHATS" class="w3-container" style="overflow-y: scroll; height:1200px">
            <h1>Liste</h1>
        </div>
        <?php
    }
    
}
