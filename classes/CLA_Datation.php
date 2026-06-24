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
                    <button id="COU_MODAL_DATATION_OK" class="w3-button w3-green w3-left w3-circle" type="button" onclick="document.getElementById('COU_MODAL_DATATION').style.display='none'"><i class="fa fa-check"></i></button>
                    <button id="COU_MODAL_DATATION_SANS" class="w3-button w3-deep-purple w3-right w3-circle" type="button" onclick="document.getElementById('COU_MODAL_DATATION').style.display='none'">-</button>
                    <button id="COU_MODAL_DATATION_VENDREDI_PROCHAIN" class="w3-button w3-deep-purple w3-right w3-circle" type="button" onclick="document.getElementById('COU_MODAL_DATATION').style.display='none'">->V</button>
                </div>
            </div>
        </div>
        <?php
    }
    
    private function afficheCalendrier() {
        ?>
        <div class="w3-container w3-light-blue">
            <div class="w3-container w3-cyan">
                <button id="COU_MODAL_DATATION_MOIS_PREC" class="w3-button w3-cobalt w3-left"><i class="fa fa-chevron-left"></i></button>
                <button id="COU_MODAL_DATATION_AHUI" class="w3-button w3-cobalt w3-center"><i class="fa fa-chevron-down"></i></button>
                <button id="COU_MODAL_DATATION_MOIS_SUCC" class="w3-button w3-cobalt w3-right"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="w3-container w3-light-blue">
            <?php
            $this->afficheMois();
            ?>
        </div>
        <div class="w3-container w3-light-blue">
            <div class="w3-container w3-cyan">
                <div class="w3-container w3-pale-blue w3-center">
                    <h3 id="COU_MODAL_DATE_CHOISIE" class="w3-cobalt"><?php echo $this->getDate_DD_MM_AAAA(); ?></h3>
                </div>
            </div>
        </div>
        <?php
    }
    
    private function afficheMois() {
        ?>
            <div class="w3-container w3-cyan">
                <table class="w3-table">
                    <thead>
                    <div class="w3-container w3-indigo w3-center">
                        <h3 id="COU_MODAL_MOIS" ><?php echo $this->getNomMois(); ?></h3>
                    </div>
                    </thead>
                    <tbody id="COU_MODAL_GRILLE_JOURS">
                        <?php 
                        $this->afficheGrilleJours();
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        
    }
    
    public function afficheGrilleJours() {
        ?>
        <tr>
            <th>L</th><th>M</th><th>m</th><th>J</th><th>V</th><th>S</th><th>D</th>
        </tr>
        <?php
        LIB_Util::log($this->getDate_DD_MM_AAAA());
        $datation = new CLA_Datation($this->getDate_DD_MM_AAAA());
        
        $datation->passeAuPremierJourDuMois();
        LIB_Util::logPrintR($datation);
        LIB_Util::log("Datation : ".$datation->getDate_DD_MM_AAAA());
        $nb_semaine_mois = $datation->getNbSemainesMois();
        $nb_jours_mois = $datation->getNbJoursMois();
        $dans_mois = false;
        for ($num_semaine = 1; $num_semaine <= $nb_semaine_mois; $num_semaine++) {
            LIB_Util::log($nb_semaine_mois." -> ".$num_semaine);
            ?>
            <tr>
                <?php
                for ($num_jour = 1;$num_jour<=7;$num_jour++) {
                    ?>
                    <td>
                        <?php 
                            LIB_Util::trace($num_semaine." ".$num_jour); 
                            LIB_Util::trace($dans_mois?"Oui":"Non"); 
                            if ($num_jour == $datation->getNumeroJourUnDuMois()) {
                                $dans_mois = true;
                            }
                            if ($dans_mois) {
                                LIB_Util::trace($datation->getDate_DD());
                                if ((int)$datation->getDate_DD() == $nb_jours_mois) {
                                    $dans_mois = false;
                                } else {
                                    $datation->incrementeJour();
                                }
                            }
                        ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
            <?php
            
        }
        
    }
}
