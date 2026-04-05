<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of LIB_Montant
 * 
 * Classe pour gérér le le format d'affichage et de saisie des données financières
 *
 * @author sylverscal
 */
class LIB_Montant {
    protected $montant;
    protected $is_valide;

    public function __construct($valeur = NULL) {
        $this->set_montant($valeur);
    }
    
    public function set_montant($valeur) {
        $this->set_montant_valide();
        
        // Est-ce que la valeur est le montant brut en centimes : Ex : 1200 45999
        if (preg_match("/^\d+$/", $valeur) == 1) {
            $this->montant = (int)$valeur * 100;
            return;
        }     
        
        // Est-ce que la valeur est le montant au format usuel : Ex : 12€ 459€
        if (preg_match("/^(\d+)€$/", (string)$valeur,$tab) == 1) {
            $this->montant = $tab[1] * 100;
            return;
        }        
                
        // Est-ce que la valeur est le montant au format usuel : Ex : 12,00 459,99
        if (preg_match("/^(\d+),(\d{2})$/", (string)$valeur,$tab) == 1) {
            $this->montant = $tab[1] * 100 + $tab[2];
            return;
        }        
                
        // Est-ce que la valeur est le montant au format usuel : Ex : 12,00€ 459,99€
        if (preg_match("/^(\d+),(\d{2})€$/", (string)$valeur,$tab) == 1) {
            $this->montant = $tab[1] * 100 + $tab[2];
            return;
        }        
                
        $this->montant = 0;
        $this->set_montant_pas_valide();
    }
    
    protected function set_montant_valide() {
        $this->is_valide = true;
    }

    protected function set_montant_pas_valide() {
        $this->is_valide = false;
    }
    
    public function is_montant_valide() {
        return $this->is_valide;
    }

    public function get_valeur_brute() {
        return $this->montant;
    }
    
    public function get_valeur_mysql() {
        return $this->montant;
    }
    
    public function get_valeur_affichage() {
        $s = "Erreur";
        $pattern = "/^(\d+)(\d{2})$/";
        $v = (string)$this->montant;
        while (strlen($v) < 3){
            $v = sprintf("0%s", $v);
        }
        $r = preg_match($pattern,$v,$tab);
        if ($r == 1) {
            $s = sprintf("%s,%s€",$tab[1],$tab[2]);
        }
        return $s;
    }

}
