<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of TBL_Course_Faite
 *
 * @author veroscal
 */
class TBL_Course_Faite_s extends LIB_Table_s {
    /**
     * Ouverture d'une course ou passage à l'état "A faire"
     * @param TBL_Course $course
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function ferme($course) {
        global $DOT; 
        
        $d = new LIB_Datation();
        
        $caf = $DOT->getObjet("Course_Faite");
        $caf->setValeurColonne("id_Course",$course->getId());
        $caf->setValeurColonne("datation",$d->getDate_pourEcritureMySQL());
        
        $crdu = $caf->sauve();
        LIB_Util::trace("$crdu");
    }
    
    
    
}
