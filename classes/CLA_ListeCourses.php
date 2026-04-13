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
    }
    
    
    final function afficheEmplacementFonctionListeCourses() {
        ?>
        <div id="DIV_FONCTION_LISTE_COURSES" class="w3-container w3-brown">
        </div>
        <?php
    }
    
    public function afficheVuePrincipale() {
        ?>
        <div id="DIV_VUE_PRINCIPALE" class="w3-container w3-sand" style="overflow-y: scroll; height:1200px">
            <div id="DIV_RECHERCHE" class="w3-container w3-yellow">
                <h2>Recherche</h2>
            </div>
            <div id="DIV_LISTE_COURSES" class="w3-container w3-yellow">
                <h2>Liste des courses</h2>
            </div>
            <div id="DIV_FILTRES" class="w3-container w3-yellow">
                <h2>Filtres</h2>
            </div>
            <div id="DIV_FONCTIONS" class="w3-container w3-yellow">
                <h2>Fonctions</h2>
                
            </div>
        </div>
        <?php
    }
    
    /**
     * 
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function afficheListeCourses() {
        global $DOT;
        
        $cs = $DOT->getObjet_s("Course");
        $cs->afficheListe();
    }
}
