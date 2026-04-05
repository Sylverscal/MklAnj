<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of LIB_MontantBase
 * 
 * Représente un montant lu de la base de données.
 * Lequel est représenté en centimes.
 * Car celui venant de l'IHM est en euros
 *
 * @author veroscal
 */
class LIB_MontantBase extends LIB_Montant{

    #[\Override]
    public function set_montant($valeur) {
        $this->set_montant_valide();
        
        // Est-ce que la valeur est le montant brut en centimes : Ex : 1200 45999
        if (preg_match("/^\d+$/", $valeur) == 1) {
            $this->montant = (int)$valeur;
            return;
        }     
        
        $this->montant = 0;
        $this->set_montant_pas_valide();
    }
}

