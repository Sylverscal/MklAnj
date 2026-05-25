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
class TBL_Course_AFaire extends LIB_Table{
    public function ouvre($course) {
        $this->setValeurColonne("id_Course", $course);
        $this->charge();
        $this->supprime();
        
        $d = new LIB_Datation();
        $this->setValeurColonne("datation", $d);
        
        $this->sauve();
    }
    
    public function ferme($course) {
        
    }
}
