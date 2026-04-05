<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_DistributeurObjets
 *
 * Classe pour servir de distributeur d'objets clonés.
 * Au lieu de créer un objet à chaque fois ce qui prend beaucoup plus de temps.
 * Cette classe sert à créer des objets pour des classes propres à l'application Courses.
 * Accessible avec la variable globale $DOU_COU
 * Pour accéder aux objets des tables au fonctionnement standard 
 * utiliser les objets lus "LIB_DistributeurObjetTable" et accessible avec la variable gloale $DOT
 * 
 * @author sylverscal
 */
class COU_DistributeurObjets {
    private $liste_objets;
    
    public function __construct() {
        $this->liste_objets = [];
    }
    
    public function constitueListeObjets() {
        $liste_noms_classes = [];
        $liste_noms_classes[] = "TBL_Achat";
        $liste_noms_classes[] = "TBL_Achat_s";
        $liste_noms_classes[] = "TBL_Contenant";
        $liste_noms_classes[] = "TBL_Domaine_s";
        $liste_noms_classes[] = "TBL_VariableSysteme";
        
        $this->liste_objets = [];
        
        foreach ($liste_noms_classes as $nom_classe) {
            $this->liste_objets[$nom_classe] = new $nom_classe();            
        }
        
    }
    
    /**
     * Calcule la requête select de libellé pour toutes les tables 
     */
    public function calculeRequeteSelectLibelle() {
        foreach ($this->liste_objets as $index => $table) {

            $test = preg_match('@TBL_(.*)_s$@i', $index);
            if ($test === 1) {
                continue;
            }

            $table->calculeRequeteSelectLibelle();
        }
    }
    
    public function getObjet($nom_classe) {

        if (isset($this->liste_objets[$nom_classe])) {
            return clone $this->liste_objets[$nom_classe];
        }
        
        return new $nom_classe();
    }
    
    public function isExisteObjet($nom_classe) {
        return isset($this->liste_objets[$nom_classe]) ? true : false;
    }
    
}
