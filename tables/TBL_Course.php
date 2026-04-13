<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of TBL_Achat
 * 
 * Classe pour gérer des actions et comportements propres aux achats
 *
 * @author sylverscal
 */
class TBL_Course extends LIB_Table{

    public function __construct() {
        parent::__construct();
//        $this->calculeRequeteSelectLibelle();
        
    }
    
    public function affiche() {
        $id = $this->getId();
        $libelle = $this->getLibelle();
        $checked = $this->isCourseFaite() ? "checked" : "";
        ?>
            <tr>
                <td>
                    <input id="<?php echo $id; ?>" class="w3-check CBX_COURSE_FAITE" type="checkbox" name="is_course_faite" value="faite" <?php echo $checked; ?>>
                </td>
                <td>
                    <?php echo $libelle; ?>
                </td>
                <td>
                    <button class="w3-button"><i class="fa fa-gear"></i></button>

                    
                </td>
            <?php

            ?>
            </tr>
        <?php
    }
    
    
    /**
     * Renvoie le libellé de la courses
     * @global LIB_BDD $CXO
     */
    #[\Override]
    public function getLibelle() {
        global $CXO;
        
        $requete = $this->arbre_tables_colonnes->getRequetePourFiltre();
        
        $where = sprintf(" and Course.id = '%s'",$this->getId());
        
        $requete_complete = sprintf("%s%s",$requete,$where);
        
        $rlt = $CXO->executeRequete($requete_complete);
        
        $libelle = "-";
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $key => $value) {
                $libelle = $value['Article_nom'];
                
                if ($value['Marque_nom'] != "-" ) {
                    $libelle = $libelle." ".$value['Marque_nom'];
                }
            }
        }
        
        return $libelle;
        
    }
    
    /**
     * Renvoie si la course a été faite
     * @global LIB_BDD $CXO
     * @return bool Vrai si la course a été faite
     */
    public function isCourseFaite() {
        global $CXO;
        
        $requete = $this->arbre_tables_colonnes->getRequetePourFiltre();
        
        $where = sprintf(" and Course.id = '%s'",$this->getId());
        
        $requete_complete = sprintf("%s%s",$requete,$where);
        
        $rlt = $CXO->executeRequete($requete_complete);
        
        $is_faite = false;
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $key => $value) {
                $course_faite = $value['Course_faite'];
                
                if ($course_faite == 1) {
                    $is_faite = true;
                }
            }
        }
        
        return $is_faite;
        
    }
    
    /**
     * Modifie l'état "Course faite"
     * @param int $etat = 1 : la course a été faite
     * @global LIB_BDD $CXO
     */
    public function majEtatCourseFaite($etat) {
        global $CXO;
        
    }
        
}