<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of LIB_CompteRendu
 * 
 * Compte rendu d'action à renvoyer du php vers le html/javascript via retour Ajax
 *
 * @author sylverscal
 */
class LIB_CompteRendu {
    private $is_ok;
    private $resume;
    private $detail;
    private $colonne;
    
    private $tableau;
    private $json;
    
    public function __construct($is_ok,$resume,$detail = [],$colonne = "") {
        $this->is_ok = $is_ok;
        $this->resume = $resume;
        $this->detail = $detail;
        $this->colonne = $colonne;
    }
    
    public function setOk() {
        $this->is_ok = true;
    }
    
    public function setKo() {
        $this->is_ok = false;
    }
    
    public function isOk() {
        return $this->is_ok;
    }
    
    public function isKo() {
        return !$this->is_ok;
    }
    
    public function getEtatErreur() {
        return $this->isOk() ? "Non" : "Oui";
    }
    
    public function getResume() {
        return $this->resume;
    }
    
    public function getDetail() {
        return $this->detail;
    }
    
    /**
     * Renvoie le tableau des informations du compte rendu à jsoniser
     */
    public function constitueTableau(){
        $tab = array();
        $tab["erreur"] = $this->is_ok ? "non" : "oui";
        $tab["erreur_resume"] = $this->resume;
        $tab["erreur_detail"] = $this->detail;
        $tab["erreur_colonne"] = $this->colonne;
        
        return $tab;
        
    }
    
    private function jsonisation(){
        $json = json_encode($this->tableau);
        
        return $json;
    }
    
    public function emissionJson(){
        $this->tableau = $this->constitueTableau();
        $this->json = $this->jsonisation();
        echo $this->json;
    }
    
    public function affiche($couleur = "") {
        ?>
                <td class="<?php echo $couleur ?>"><?php echo $this->is_ok ? "Ok" : "Ko"; ?></td>
            </tr>
            <tr>
                <td class="<?php echo $couleur ?>"><?php echo $this->resume; ?></td>
            </tr>
            <tr>
                <td class="<?php echo $couleur ?>">
                    <?php 
                    $this->affcheDetail();
                    ?>
                </td>
            </tr>
            <tr>
                <td class="<?php echo $couleur ?>"><?php echo $this->colonne; ?></td>
            </tr>
        <?php
    }
    
    private function affcheDetail() {
        foreach ($this->detail as $index => $texte) {
            if ($index > 0) {
                echo "<br>";
            }
            echo $this->detail[$index];
        }
    }
    
    public function __toString(): string {
        return "LIB_CompteRendu[is_ok=" . $this->is_ok ? "Ok" : "Ko"
                . ", resume=" . $this->resume
                . ", detail=" . $this->detail
                . ", colonne=" . $this->colonne
                . "]";
    }
}

/**
 * Petite classe pour gérer les listes de comptes rendus à renvoyer à la surface
 */
class CRDU_Liste {
    
    /**
     * Liste des comptes rendus
     * @var array
     */
    private $liste;
    /**
     * Titre pour afficher en tête du compte rendu en surface
     * @var string
     */
    private $titre;

    public function __construct() {
        $this->liste = [];
        $this->titre = "-";
    }
    
    /**
     * Ajoute un compte rendu
     * @param LIB_CompteRendu $crdu
     * @param type $titre_crdu Si besoin, mettre un titre au compte rendu
     */
    public function ajoute(LIB_CompteRendu $crdu,$titre_crdu = "-") {
        if ($titre_crdu == "-") {
            $this->liste[] = $crdu;
        } else {
            $this->liste[$titre_crdu] = $crdu;
        }
    }
    
    /**
     * Renseigne éventuellement un titre à la liste de comptes rendus
     * @param type $titre
     */
    public function setTitre($titre) {
        $this->titre = $titre;
    }
    
    /**
     * Formate la liste en json et l'affiche.
     * A utiliser dans le Ajax avant renvoi compte rendu à la surface
     */
    public function emissionJson() {
        $tab_global = [];
        $tab_global['titre'] = $this->titre;
        $tab = [];
        
        foreach ($this->liste as $index => $value) {
            $tab[$index] = $value->constitueTableau();
        }
        
        $tab_global['crdu'] = $tab;
        $json = json_encode($tab_global);
        
        echo $json;
    }
    
    /**
     * Affiche les comptes rendus
     */
    public function affiche() {
        ?>
            <div class="w3-container">
                <table class="w3-table w3-deep-orange">
                    <tr>
                        <td colspan="2" class="w3-center"><h3 class="w3-pale-yellow"><?php echo $this->titre; ?></h3></td>
                    </tr>
                    <?php
                            $nl = 0;
                            foreach ($this->liste as $titre => $crdu) {
                                $couleur = $nl++ % 2 == 0 ? "w3-pale-green" : "w3-pale-blue";
                                ?>
                                <tr>
                                    <td class=<?php echo $couleur?> rowspan="4"><?php echo $titre; ?></td>
                                    <?php
                                    $crdu->affiche($couleur);
                                    ?>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <?php
                            }
                    ?>
                </table>

            </div>
        <?php
    }
}