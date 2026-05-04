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
}
