<?php // content="text/plain; charset=utf-8"
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_essais
 * 
 * Pour faire des essais d'affichages
 *
 * @author sylverscal
 */
        
class CLA_onglet_essais extends CLA_onglet_principal {

    private $db;
    
    /**
     * Affiche la page d'accueil
     */
    #[\Override]
    /**
     * 
     * @global LIB_BDD $CXO
     * @global LIB_BDD_Structure $CXO_ST
     * @global LIB_DistributeurObjetTable $DOT
     * @return type
     */
    final function affiche() {
        global $CXO;
        global $DOT;
        
        ?>
        <div id="DIV_TEST_MODAL_DATATION">
        <p>
            <label>Date</label>
            <input id="INP_DATATION" class="w3-input input-datation w3-border" type="text" name="Course_datation" value="">
            <button id="BTN_DATATION" class="w3-button w3-blue" type="button">Le choix dans la date</button>
        </p>
        </div>
        <div class="w3-modal" id="COU_MODAL_DATATION">
            <div class="w3-modal-content">
                <div class="w3-container w3-aqua">
                    <div id="COU_MODAL_DATATION_TITRE"><h4>Datation</h4></div>
                </div>
                <div class="w3-container w3-light-blue">
                    <div id="COU_MODAL_DATATION_CALENDRIER" class="w3-blue"><h4>En construction</h4></div>

                </div>
                <div class="w3-container w3-aqua">
                    <button id="COU_MODAL_DATATION_SANS" class="w3-button w3-deep-purple w3-right w3-circle" type="button" onclick="document.getElementById('COU_MODAL_DATATION').style.display='none'">-</button>
                    <button id="COU_MODAL_DATATION_VENDREDI_PROCHAIN" class="w3-button w3-deep-purple w3-right w3-circle" type="button" onclick="document.getElementById('COU_MODAL_DATATION').style.display='none'">->V</button>
                </div>
            </div>
        </div>
        <?php 
        
        
        return;
    }
}
