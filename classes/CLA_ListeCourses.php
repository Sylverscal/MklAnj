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
        <div id="DIV_VUE_PRINCIPALE" class="w3-container w3-sand">
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
     * Affiche la liste des courses
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function afficheListeCourses() {
        global $DOT;
        
        $cs = $DOT->getObjet_s("Course");
        $cs->afficheListe();
    }
    
    /**
     * Affiche les fonctions possibles sur la course sélectionnée
     */
    public function afficheFonctions() {
        ?>
            <div class="w3-container w3-lime">
                <button id="FCT_SUPPRIMER" class="w3-button w3-red w3-border w3-large w3-ripple w3-circle"><i class="fa fa-trash" aria-hidden="true"></i></button>
            </div>
        <?php
    }
}
