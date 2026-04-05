<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of LIB_Description
 * 
 * Mise en forme des descriptions de tables et de colonnes
 * 
 * La description dans table ou colonne est formatée comme suit:
 * T@Ville@
 * A@Localisation du commerce
 * 
 * La ligne T est le titre.
 * La ligne A est une aide compléméntaire 
 *
 * @author Sylverscal
 */
class LIB_Description {
    
    /**
     * Description brute extraite de la description extraite de la base structure
     * @var string
     */
    private $description_brute;

    /**
     * Description : Titre 
     * @var string
     */
    private $description_titre;

    /**
     * Description : Aide 
     * @var string
     */
    private $description_aide;
    
    public function __construct($description) {
        
        $this->description_brute = $description;
        
        $this->traite();
        
    }
    
    public function __toString(): string {
        return "description_brute=" . $this->description_brute
                . ", description_titre=" . $this->description_titre
                . ", description_aide=" . $this->description_aide;
    }
    
    /**
     * Extrait les parties Titre et Aide de la description brute.
     * Si le format ne correspond pas à T@....@A@....@ : 
     * Description_titre = description_brute
     * Description_aide = ""
     */
    private function traite() {
        $test = preg_match("/^T@(.+)@.*\R*.*A@(.+)@$/", $this->description_brute, $tab);
        if ($test == 1) {
            $this->description_titre = $tab[1];
            $this->description_aide = str_replace("_","<br>",$tab[2]);
            
        } else {
            $test = preg_match("/^T@(.+)@/", $this->description_brute, $tab);
            if ($test == 1) {
                $this->description_titre = $tab[1];
                $this->description_aide = "";
            } else {
                $this->description_titre = $this->description_brute;
                $this->description_aide = "";
            }
        }
    }

    public function get_decription_titre(){
        return $this->description_titre;
    }
    
    public function get_decription_aide(){
        return $this->description_aide;
    }
    
    public function ecrit_html_titre_colonne() {
        ?>
        <p class="w3-tooltip">
            <?php echo $this->get_decription_titre(); ?> <span class="w3-text w3-tag"><?php echo $this->get_decription_aide(); ?></span>
        </p>
        <?php
        }
    }
