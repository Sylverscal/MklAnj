<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of CLA_Datation
 *
 * @author sylverscal
 */
class CLA_Datation extends LIB_Datation {
    public function __construct($valeur = NULL) {  
        if ($valeur == "-") {
            $valeur = '01-01-2000';
        }
        parent::__construct($valeur);
    }
    
    public function getDate_pourFormulaire() {
        $dpd = $this->getDatePasDeDate();
        
        if ($this->isEgaleJour($dpd)) {
            return "-";
        }
        
        return $this->getDate_DD_MM_AAAA();
    }
    
    public static function getDatePasDeDate() {
        $d = new LIB_Datation("01-01-2000");
        
        return $d;
    }
    
    public function afficheModal() {
        ?>
        <div class="w3-modal" id="COU_MODAL_DATATION">
            <div class="w3-modal-content">
                <div class="w3-container w3-aqua">
                    <div id="COU_MODAL_DATATION_TITRE"><h4>Datation</h4></div>
                </div>
                <?php
                $this->afficheCalendrier();
                ?>
                <div class="w3-container w3-aqua w3-block">
                    <button class="w3-button w3-yellow w3-left w3-circle" type="button" onclick="document.getElementById('COU_MODAL_DATATION').style.display='none'"><i class="fa fa-close"></i></button>
                    <button id="COU_MODAL_DATATION_SANS" class="w3-button w3-deep-purple w3-right w3-circle" type="button" onclick="document.getElementById('COU_MODAL_DATATION').style.display='none'">-</button>
                    <button id="COU_MODAL_DATATION_VENDREDI_PROCHAIN" class="w3-button w3-deep-purple w3-right w3-circle" type="button" onclick="document.getElementById('COU_MODAL_DATATION').style.display='none'">->V</button>
                </div>
            </div>
        </div>
        <?php
    }
    
    private function afficheCalendrier() {
        $d = new LIB_Datation();
        ?>
        <div class="w3-container w3-light-blue">
            <div class="w3-container w3-cyan">
                <button id="BTN_MOIS_PREC" class="w3-button w3-cobalt w3-left"><i class="fa fa-chevron-left"></i></button>
                <button id="BTN_AHUI" class="w3-button w3-cobalt w3-center"><i class="fa fa-chevron-down"></i></button>
                <button id="BTN_MOIS_SUCC" class="w3-button w3-cobalt w3-right"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="w3-container w3-light-blue">
            <?php
            $this->afficheMois();
            ?>
        </div>
        <div class="w3-container w3-light-blue">
            <div class="w3-container w3-cyan">
                <div class="w3-container w3-pale-blue centre_bouton">
                    <button id="BTN_MOIS_SUCC" class="w3-button w3-cobalt" style="width: 150px"><?php echo $d->getDate_DD_MM_AAAA(); ?></button>
                </div>
            </div>
        </div>
        <?php
    }
    
    private function afficheMois() {
        ?>
            <div class="w3-container w3-cyan">
                <h1>Ici sera la grille</h1>
            </div>
        <?php
        
    }
}
