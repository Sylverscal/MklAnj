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
        
        $valeurs = $this->getValeurs();
        
        $checked = $this->isCourseFaite() ? "checked" : "";
        ?>
            <tr id="<?php echo $id; ?>" class="w3-hover-pale-yellow">
                <td>
                    <input class="w3-check CBX_COURSE_FAITE" type="checkbox" name="is_course_faite" value="faite" <?php echo $checked; ?>>
                </td>
                <td class="TD_COURSE">
                    <?php $this->afficheCourse($valeurs); ?>
                </td>
                <td>
                    <?php $this->afficheDatation(); ?>
                </td>
                <td>
                    <button class="w3-button BTN_ACTION"><i class="fa fa-edit"></i></button>
                </td>
            <?php

            ?>
            </tr>
        <?php
    }
    
    public function afficheFormulaire() {
        $valeurs = $this->getValeurs();
        $checked = $valeurs["Course_faite"] == 1 ? "checked" : "";
        ?>
            <form id="FRM_COURSE" class="w3-container w3-pale-red">
                <input type="hidden" id="id" name="id" value="<?php echo $this->getId(); ?>">
                <div class="w3-container w3-pale-green" style="overflow-y: scroll; height:600px">
                    <p>
                        <label>Article</label>
                        <input class="w3-input" type="text" name="Article_nom" value="<?php echo $valeurs['Article_nom']; ?>">
                    </p>
                    <p>
                        <label>Marque</label>
                        <input class="w3-input" type="text" name="Marque_nom" value="<?php echo $valeurs['Marque_nom']; ?>">
                    </p>
                    <p>
                        <label>Commerce</label>
                        <input class="w3-input" type="text" name="Commerce_nom" value="<?php echo $valeurs['Commerce_nom']; ?>">
                    </p>
                    <p>
                        <label>Ville</label>
                        <input class="w3-input" type="text" name="Ville_nom" value="<?php echo $valeurs['Ville_nom']; ?>">
                    </p>
                    <p>
                        <label>Zone</label>
                        <input class="w3-input" type="text" name="Zone_nom" value="<?php echo $valeurs['Zone_nom']; ?>">
                    </p>
                    <p>
                        <label>Date</label>
                        <input class="w3-input" type="text" name="Course_datation" value="<?php echo $valeurs['Commerce_nom']; ?>">
                    </p>
                    <p>
                        <label>Nombre</label>
                        <input class="w3-input" type="text" name="Course_nombre" value="<?php echo $valeurs['Course_nombre']; ?>">
                    </p>
                    <p>
                        <label>Capacité</label>
                        <input class="w3-input" type="text" name="Course_capacite" value="<?php echo $valeurs['Course_capacite']; ?>">
                    </p>
                    <p>
                        <label>Unité</label>
                        <input class="w3-input" type="text" name="Unite_nom" value="<?php echo $valeurs['Unite_nom']; ?>">
                    </p>
                    <p>
                        <label>Commentaire</label>
                        <input class="w3-input" type="text" name="Course_commentaire" value="<?php echo $valeurs['Course_commentaire']; ?>">
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
    /**
     * Renvoie le libellé de la courses
     */
    public function afficheCourse($valeurs) {
        if ($valeurs == null) {
            ?>
            <p class="w3-red">Les valeurs n'ont pas pu être lues</p>
            <?php
            return;
        }
        
        $texte = $valeurs['Article_nom'];

        if ($valeurs['Marque_nom'] != "-" ) {
            $texte = $texte." ".$valeurs['Marque_nom'];
        }

        $nombre = $valeurs['Course_nombre'];

        if ($nombre > 1) {
            $texte = sprintf("%s x %d",$texte,$nombre);
        }

        $capacite = $valeurs['Course_capacite'];

        if ($capacite > 0) {
            $unite = $valeurs['Unite_nom'];
            $texte = sprintf("%s %d%s",$texte,$capacite,$unite);

        }
        
        $commentaire = $valeurs['Course_commentaire'];
        
        
        ?>
        <p><?php echo $texte; ?></p>
            <?php if ($commentaire != "" && $commentaire != "-") { ?>
            <p class="w3-text-gray"><i><?php echo $commentaire; ?></i></p>
                
            <?php } ?>
        <?php
    }
    
    /**
     * Renvoie les valeurs de la course
     * @global LIB_BDD $CXO
     */
    public function getValeurs() {
        global $CXO;
        
        $requete = $this->arbre_tables_colonnes->getRequetePourFiltre();
        
        $where = sprintf(" and Course.id = '%s'",$this->getId());
        
        $requete_complete = sprintf("%s%s",$requete,$where);
        
        $rlt = $CXO->executeRequete($requete_complete);
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $valeurs) {
                return $valeurs;
            }
        }
        
        return null;
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
            foreach ($rlt->getResultat() as $key => $valeurs) {
                $course_faite = $valeurs['Course_faite'];
                
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
        global $CXO;
        
        $requete = $this->arbre_tables_colonnes->getRequetePourFiltre();
        
        $where = sprintf(" and Course.id = '%s'",$this->getId());
        
        $requete_complete = sprintf("%s%s",$requete,$where);
        
        $rlt = $CXO->executeRequete($requete_complete);
        
        $datation = null;
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $key => $valeurs) {
                $s_date = $valeurs['Course_datation'];

                $datation = new LIB_Datation($s_date);
            }
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