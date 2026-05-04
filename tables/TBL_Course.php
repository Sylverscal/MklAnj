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
    /**
     * Valeurs sous forme de tablonnes pour un accès plus simple aux valeurs des sous tables
     * @var array
     */
    private $valeurs = null;
    
    public function __construct() {
        parent::__construct();
//        $this->calculeRequeteSelectLibelle();
        
    }
    
    public function affiche() {
        $this->chargeValeurs();
        
        $checked = $this->isCourseFaite() ? "checked" : "";
        ?>
            <tr id="<?php echo $this->getId(); ?>" class="w3-hover-pale-yellow">
                <td>
                    <input class="w3-check CBX_COURSE_FAITE" type="checkbox" name="is_course_faite" value="faite" <?php echo $checked; ?>>
                </td>
                <td class="TD_COURSE">
                    <?php $this->afficheCourse(); ?>
                </td>
                <td>
                    <?php $this->afficheDatation(); ?>
                </td>
                <td>
                    <button class="w3-button BTN_FORMULAIRE"><i class="fa fa-edit"></i></button>
                </td>
            <?php

            ?>
            </tr>
        <?php
    }
    
    public function afficheFormulaire() {
        $this->chargeValeurs();
        $checked = $this->valeurs["Course_faite"] == 1 ? "checked" : "";
        ?>
            <form id="FRM_COURSE" class="w3-container w3-pale-red">
                <input type="hidden" id="id" name="id" value="<?php echo $this->getId(); ?>">
                <div class="w3-container w3-pale-green" style="overflow-y: scroll; height:600px">
                    <?php 
                    $this->afficheFormulaireElement("Article","Article","Article_nom");  
                    $this->afficheFormulaireElement("Marque","Marque","Marque_nom");  
                    $this->afficheFormulaireElement("Commerce","Commerce","Commerce_nom");  
                    $this->afficheFormulaireElement("Ville","Ville","Ville_nom");  
                    $this->afficheFormulaireElement("Zone","Zone","Zone_nom");  
                    $this->afficheFormulaireDate();  
                    $this->afficheFormulaireNombre("Nombre", "Course_nombre");
                    $this->afficheFormulaireNombre("Capacité", "Course_capacite");
                    $this->afficheFormulaireElement("Unité","Unite","Unite_nom");  
                    ?>
                    <p>
                        <label>Commentaire</label>
                        <input class="w3-input" type="text" name="Course_commentaire" value="<?php echo $this->valeurs['Course_commentaire']; ?>">
                    </p>
                    <p>
                        <label>Course faite</label>
                        <input type="hidden" name="Course_faite" value='0'>
                        <input class="w3-check" type="checkbox" name="Course_faite" <?php echo $checked; ?> value='1'>
                    </p>
                </div>
                <div class="w3-container w3-pale-blue">
                    <button id="BTN_FRM_VALIDER" class="w3-button w3-green w3-right">Valider</button>
                    <button id="BTN_FRM_ANNULER" class="w3-button w3-yellow w3-left">Annuler</button>
                </div>
            </form>
        <?php
    }
    
    private function afficheFormulaireNombre($titre,$tablonne) {
        global $DOT;
        
        $valeur = $this->valeurs[$tablonne];
        ?>
        <p>
            <label><?php echo $titre ?></label>
            <input class="w3-input input-nombre-entier" type="text" name="<?php echo $tablonne ?>" value="<?php echo $valeur; ?>">
        </p>
        <?php
    }
    
    private function afficheFormulaireElement($titre,$nom_table,$tablonne) {
        global $DOT;
        
        $m_s = $DOT->getObjet_s($nom_table);
        
        $tab = $m_s->getItemsPourInputSelect();
        
        $valeur = $this->valeurs[$tablonne];
        ?>
        <p>
            <label><?php echo $titre ?></label>
            <select class="w3-select">
                <?php
                        foreach ($tab as $value) {
                            $selected = "";
                            if (trim($valeur) == trim($value['libelle'])) {
                                $selected = "selected";
                            }
                            ?>
                            <option value="<?php echo $value['valeur'] ?>" <?php echo $selected ?>><?php echo $value['libelle'] ?></option>
                            <?php
                        }
                ?>
            </select>
            <input class="w3-input" type="text" name="<?php echo $tablonne ?>" value="<?php echo $valeur; ?>">
        </p>
        <?php
    }
    
    private function afficheFormulaireDate() {
        $d = new LIB_Datation($this->valeurs['Course_datation']);
        ?>
        <p>
            <label>Date</label>
            <input class="w3-input" type="text" name="Course_datation" value="<?php echo $d->getDate_DD_MM_AAAA(); ?>">
        </p>
        <?php
    }
    /**
     * Renvoie le libellé de la courses
     */
    public function afficheCourse() {
        if ($this->valeurs == null) {
            ?>
            <p class="w3-red">Les valeurs n'ont pas pu être lues</p>
            <?php
            return;
        }
        
        $texte = $this->valeurs['Article_nom'];

        if ($this->valeurs['Marque_nom'] != "-" ) {
            $texte = $texte." ".$this->valeurs['Marque_nom'];
        }

        $nombre = $this->valeurs['Course_nombre'];

        if ($nombre > 1) {
            $texte = sprintf("%s x %d",$texte,$nombre);
        }

        $capacite = $this->valeurs['Course_capacite'];

        if ($capacite > 0) {
            $unite = $this->valeurs['Unite_nom'];
            $texte = sprintf("%s %d%s",$texte,$capacite,$unite);

        }
        
        $localisation = $this->getLocalisation();
        
        $commentaire = $this->valeurs['Course_commentaire'];
        
        
        ?>
        <p>
            <span><?php echo $texte; ?></span><span class='w3-text-blue w3-right w3-small'><?php echo $localisation; ?></span>
        </p>
            <?php if ($commentaire != "" && $commentaire != "-") { ?>
            <p class="w3-text-gray w3-small"><i><?php echo $commentaire; ?></i></p>
                
            <?php } ?>
        <?php
    }
    
    private function getLocalisation() {
        $commerce = $this->valeurs['Commerce_nom'];
        $ville = $this->valeurs['Ville_nom'];
        $zone = $this->valeurs['Zone_nom'];
        
        $localisation = "";
        
        if ($commerce != "" && $commerce != "-") {
            $localisation = sprintf("%s%s",$localisation,$commerce);
        }
        if ($ville != "" && $ville != "-") {
            $localisation = sprintf("%s%s%s",$localisation,$localisation == "" ? "" : "<br>",$ville);
        }
        if ($zone != "" && $zone != "-") {
            $localisation = sprintf("%s%s%s",$localisation,$localisation == "" ? "" : "<br>",$zone);
        }
        
        return $localisation;
    }
    
    /**
     * Charge les valeurs de la course
     * @global LIB_BDD $CXO
     */
    public function chargeValeurs() {
        global $CXO;
        
        $requete = $this->arbre_tables_colonnes->getRequetePourFiltre();
        
        $where = sprintf(" and Course.id = '%s'",$this->getId());
        
        $requete_complete = sprintf("%s%s",$requete,$where);
        
        $rlt = $CXO->executeRequete($requete_complete);
        
        $this->valeurs = null;
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $valeurs) {
                $this->valeurs = $valeurs;
            }
        }
    }
    
    /**
     * Renvoie si la course a été faite
     * @global LIB_BDD $CXO
     * @return bool Vrai si la course a été faite
     */
    public function isCourseFaite() {
        $is_faite = false;
        if (isset($this->valeurs['Course_faite'])) {
            $course_faite = $this->valeurs['Course_faite'];

            if ($course_faite == 1) {
                $is_faite = true;
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
        
        $requete = sprintf("update Course set faite = '%s' where id = '%d'",$etat,$this->getId());
        
        $rlt = $CXO->executeRequete($requete);
        
        $rlt->afficheSiKo();
        
    }
    
    /**
     * Renvoie la date
     * @global LIB_BDD $CXO
     * @return LIB_Datation Date
     */
    public function getDatation() {
        $datation = new LIB_Datation("01-01-1900");
        
        if (isset($this->valeurs['Course_datation'])) {
            $datation = new LIB_Datation($this->valeurs['Course_datation']);
        }
        

        return $datation;
    }
    
    /**
     * Affiche la datation
     */
    public function afficheDatation() {
        $datation = $this->getDatation();
        
        if ($datation == null) {
            ?>
            <p>Date ?</p>
            <?php
            
            return;
        }
        
        $d_ref = new LIB_Datation("01-01-2000");
        
        if ($datation->isEgaleA($d_ref)) {
            ?>
            <p>-</p>
            <?php
            
            return;
        }
        
        $d_ahui = new LIB_Datation();
        
        if ($datation->isInferieureOuEgaleA($d_ahui)) {
            ?>
            <p class="w3-red"><?php echo $datation->getDate_pourAffichage(); ?></p>
            <?php
            return;
        }
        
        if ($datation->isSuperieureA($d_ahui)) {
            ?>
            <p class="w3-green"><?php echo $datation->getDate_pourAffichage(); ?></p>
            <?php
            return;
        }
    }
        
    public function valideFormulaire($post) {
        $crdu = new LIB_CompteRendu(true, "");
        
        return $crdu;
    }
}