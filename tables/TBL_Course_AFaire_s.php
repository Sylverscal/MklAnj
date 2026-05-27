<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of TBL_Course_AFaire
 *
 * @author veroscal
 */
class TBL_Course_AFaire_s extends LIB_Table_s{
    /**
     * Ouverture d'une course ou passage à l'état "A faire"
     * @param TBL_Course $course
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function ouvre($course) {
        global $DOT; 
        
        $this->ferme($course);
        
        $d = new LIB_Datation();
        
        $caf = $DOT->getObjet("Course_AFaire");
        $caf->setValeurColonne("id_Course",$course->getId());
        $caf->setValeurColonne("datation",$d->getDate_pourEcritureMySQL());
        
        $crdu = $caf->sauve();
        LIB_Util::trace("$crdu");
    }
    
    /**
     * Fermeture d'une course ou passage à l'état "Faite"
     * @param TBL_Course $course
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function ferme($course) {
        global $DOT; 
        
        $caf = $DOT->getObjet("Course_AFaire");
        $caf->chargeParNomColonne("id_Course",$course->getId());
        $caf->supprime();
    }
}
