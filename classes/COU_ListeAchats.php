<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_ListeAchats
 * 
 * Classe pour gérer l'affichage de la liste des achats
 *
 * @author sylverscal
 */
class COU_ListeAchats {
    /**
     * Liste des achats
     * @var LIB_Table_s
     */
    private $liste_achats;
    
    public function __construct() {
        $this->prepareListe();
    }
    
    /**
     * Préparation de la liste des achats
     * @global LIB_DistributeurObjetTable $DOT
     */
    private function prepareListe() {
        global $DOT;
        
        $this->liste_achats = $DOT->getObjet("Achat_s");
    }
}
