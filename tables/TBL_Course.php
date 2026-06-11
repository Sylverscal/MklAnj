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
                    <button class="w3-button w3-green w3-tiny w3-border w3-ripple w3-circle w3-right BTN_FORMULAIRE"><i class="fa fa-edit"></i></button>
                </td>
            <?php

            ?>
            </tr>
        <?php
    }
    
    public function afficheFormulaire() {
        $this->chargeValeurs();
        $checked = $this->isCourseFaite() ? "checked" : "";
        $value_course_faite = $this->isCourseFaite() ? 1 : 0;
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
                        <input class="w3-check" type="checkbox" <?php echo $checked; ?>>
                        <input type="hidden" name="Course_faite" value='<?php echo $value_course_faite; ?>'>
                    </p>
                </div>
                <div class="w3-container w3-pale-blue">
                    <button id="BTN_FRM_VALIDER" class="w3-button w3-green w3-right">Valider</button>
                    <button id="BTN_FRM_SUPPRIMER" class="w3-button w3-red w3-right">Supprimer</button>
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
        
        if ($nom_table == "Article") {
            $tab = $m_s->getArticlesInutilises();
        } else {
            $tab = $m_s->getItemsPourInputSelect();
        }
        
        $valeur = $this->valeurs[$tablonne];
        ?>
        <p>
            <label><?php echo $titre ?></label>
            <select class="w3-select">
                <?php
                        foreach ($tab as $value) {
                            $selected = "";
                            if (isset($value['libelle'])) {
                                if (trim($valeur) == trim($value['libelle'])) {
                                    $selected = "selected";
                                }
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
        $d = new CLA_Datation($this->valeurs['Course_datation']);
        ?>
        <p>
            <label>Date</label>
            <div id="inline" data-date="05/22/2026"></div>
            <input class="w3-input input-datation" type="text" name="Course_datation" value="<?php echo $d->getDate_pourFormulaire(); ?>">
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
            <span id="COURSE_TEXTE_<?php echo $this->getId() ?>"><?php echo $texte; ?></span>
            <?php if ($localisation != "") { ?>
                <span class='w3-text-blue w3-right w3-small'><?php echo $localisation; ?></span>
            <?php } ?>
            <?php if ($commentaire != "" && $commentaire != "-") { ?>
            <span class="w3-text-gray w3-small"><i><?php echo $commentaire; ?></i></span>
                
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
        global $CXO;
        
        $id = $this->getId();
        $requete = "SELECT count(Course_AFaire.id) as nb FROM Course_AFaire
            where id_Course = $id";

        $is_faite = false;

        $rlt = $CXO->executeRequete($requete);
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
                if ($value['nb'] == 0) {
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
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function majEtatCourseFaite($etat) {
        global $CXO;
        global $DOT;
        
        // Mise à jour des tables statistiques
        if ($etat == 1) {
            $cf = $DOT->getObjet_s("Course_Faite");
            $cf->ferme($this);
            $caf = $DOT->getObjet_s("Course_Afaire");
            $caf->ferme($this);
        } else {
            $caf = $DOT->getObjet_s("Course_Afaire");
            $caf->ouvre($this);
        }
        
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
            <span>Date ?</span>
            <?php
            
            return;
        }
        
        $d_ref = new LIB_Datation("01-01-2000");
        
        if ($datation->isEgaleA($d_ref)) {
            ?>
            <span>-</span>
            <?php
            
            return;
        }
        
        $d_ahui = new LIB_Datation();
        
        $couleur = "";
        if (!$this->isCourseFaite()) {
            if ($datation->isInferieureA($d_ahui)) {
                $couleur = "w3-red";
            }

            if ($datation->isEgaleA($d_ahui)) {
                $couleur = "w3-blue";
            }

            if ($datation->isSuperieureA($d_ahui)) {
                $couleur = "w3-green";
            }
        }
        
        ?>
        <span class="<?php echo $couleur; ?>"><?php echo $datation->getDate_pourAffichage(); ?></span>
        <?php
    }
    
    /**
     * Valide le formulaire de saisie d'une course.
     * Si tout ok : Mise à jour base
     * @param type $donnees
     * Exemple :
(
    [id] => 1
    [Article_nom] => Biscuit Avoine complet Nutri+
    [Marque_nom] => Bjorg
    [Commerce_nom] => -
    [Ville_nom] => -
    [Zone_nom] => -
    [Course_datation] => -
    [Course_nombre] => 1
    [Course_capacite] => 0
    [Unite_nom] => -
    [Course_commentaire] => -
    [Course_faite] => 1
)
     * @return \LIB_CompteRendu Compte rendu de l'opération
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function valideFormulaire($donnees) {
        global $DOT;
        $crdu = new LIB_CompteRendu(true, "");
                
        $this->charge();
        
        // Contrôle des données reçues
        
        $datation = new CLA_Datation($donnees['Course_datation']);
        
        if (!$datation->is_date_valide()) {
            $detail = [$donnees['Course_datation']];
            
            $crdu = new LIB_CompteRendu(false, "Mauvais format date",$detail);
            
            return $crdu;
        }
        
        $nombre = $donnees['Course_nombre'];
        $capacite = $donnees['Course_capacite'];
        $commentaire = $donnees['Course_commentaire'];
        $course_faite = $donnees['Course_faite'];
        
        
        // Préparation des colonnes liées de Course
        $id = $this->getId();
        
        $idArticle = $this->prepareColonne("Article", trim($donnees['Article_nom']));
            
        $idMarque = $this->prepareColonne("Marque", trim($donnees['Marque_nom']));
        $idCommerce = $this->prepareColonne("Commerce", trim($donnees['Commerce_nom']));
        $idVille = $this->prepareColonne("Ville", trim($donnees['Ville_nom']));
        $idZone = $this->prepareColonne("Zone", trim($donnees['Zone_nom']));
        $idUnite = $this->prepareColonne("Unite", trim($donnees['Unite_nom']));
        
        
        $a = $DOT->getObjet("Article");
        $a->charge($idArticle);
        $tab = [];
        $tab[0] = trim($donnees['Article_nom']);
        $a->set(...$tab);
        $a->sauve();
        
        $this->setValeurColonne('id_Article', "$idArticle");
        $this->setValeurColonne('id_Marque', "$idMarque");
        $this->setValeurColonne('id_Commerce', "$idCommerce");
        $this->setValeurColonne('id_Ville', "$idVille");
        $this->setValeurColonne('id_Zone', "$idZone");
        $this->setValeurColonne('datation', $datation->getDate_pourEcritureMySQLCourte());
        $this->setValeurColonne('nombre', "$nombre");
        $this->setValeurColonne('capacite', "$capacite");
        $this->setValeurColonne('id_Unite', "$idUnite");
        $this->setValeurColonne('commentaire', $commentaire);
        
        $this->majEtatCourseFaite($course_faite);
        
        // Enregistrement Course
        
        $crdu = $this->sauve();
        
        return $crdu;
    }
    
    /**
     * Prépare une des données liée de la Course
     * A n'utiliser que sur des tables ne contenant que les colonnes id et nom.
     * @param type $nom_table
     * @param type $donnee
     * @global LIB_DistributeurObjetTable $DOT
     */
    private function prepareColonne($nom_table,$donnee) {
        global $DOT;
        
        $objet = $DOT->getObjet($nom_table);
        $objet->set(...[$donnee]);
        $objet->chargeIdParNom(true);
        $id = $objet->getId();
        
        return $id;
    }
    
    public function afficheLigneEditable($id = 0) {
        global $DOT;
        
        $a_s = $DOT->getObjet_s("Article");
        $tab_articles = $a_s->getArticlesInutilises();
        
        ?>
            <tr id="<?php echo $id; ?>" class="w3-hover-pale-yellow">
                <td colspan="4">
                    <div class="w3-container ">
                        <div class="w3-row">
                            <div class="w3-col" style="width:100px">
                                <button id="BTN_LIGNE_EDITABLE_KO" class="w3-button w3-red w3-circle w3-right w3-tiny"><i class="fa fa-ban"></i></button>
                                <button id="BTN_LIGNE_EDITABLE_OK" class="w3-button w3-green w3-circle w3-right w3-tiny"><i class="fa fa-check"></i></button>
                            </div>
                            <div class="w3-rest">
                                <select id="SEL_NOM_ARTICLE" class="w3-select w3-left">
                                    <?php
                                            foreach ($tab_articles as $value) {
                                                ?>
                                                <option value="<?php echo $value['libelle'] ?>"><?php echo $value['libelle'] ?></option>
                                                <?php
                                            }
                                    ?>
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    <div class="w3-container ">
                            <input id="INP_LIGNE_EDITABLE_VALEUR" class="w3-input" type="text" name="nom_article" value="">
                    </div>
                </td>
            </tr>
        <?php
    }
    
    /**
     * Création d'une nouvelle course à partir de l'aticle saisi
     * @param type $nom_article
     */
    public function creationNouvelleCourse($nom_article) {
        $donnees = $this->getTableauDonneesVierge();
        
        $donnees['Article_nom'] = $nom_article;
        
        $crdu = $this->valideFormulaire($donnees);
        
        
        if ($crdu->isKo()) {
            $crdu->affiche();
            return;
        }
        
        $this->majEtatCourseFaite(0);
        
        $this->affiche();
    }
    
    /**
     * Renvoie un modèle de tableau de données vierge
     * @return array
     */
    private function getTableauDonneesVierge() {
        $tab = [];
        $tab['id'] = 0;
        $tab['Article_nom'] = "-";
        $tab['Marque_nom'] = "-";
        $tab['Commerce_nom'] = "-";
        $tab['Ville_nom'] = "-";
        $tab['Zone_nom'] = "-";
        $tab['Course_datation'] = "01-01-2000";
        $tab['Course_nombre'] = 1;
        $tab['Course_capacite'] = 0;
        $tab['Unite_nom'] = "-";
        $tab['Course_commentaire'] = "-";
        $tab['Course_faite'] = 1;
        
        return $tab;
    }
    
    public function isCourseExistePourArticle($nom_article) {
        global $CXO;
        
        $requete = "SELECT count(Course.id) as nb FROM Course
        join Article on Article.id = Course.id_Article
        where Article.nom = '$nom_article'";
        
        $rlt = $CXO->executeRequete($requete);
        
        $nb = 0;
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $valeur) {
                $nb = $valeur['nb'];
            }
        }
        
        return $nb == 1;
    }
    
    public function isCorrespond($recherche){
        if ($recherche == "") {
            return true;
        }
        $nom = $this->getValeurDeColonne("Article_nom");
        LIB_Util::log($nom." ".$recherche);
        
        if (preg_match("/$recherche/i", $nom) == 1) {
            return true;
        }
        
        return $false;
    }
}