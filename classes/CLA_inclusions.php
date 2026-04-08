<?php

class CLA_inclusions {

    private $document_root;

    function __construct() {
        $this->document_root = $_SERVER['DOCUMENT_ROOT'];
    }

    public function inclut() {
//        $this->inclutExt('PHPMailer-master/src/Exception.php');
//        $this->inclutExt('PHPMailer-master/src/PHPMailer.php');
//        $this->inclutExt('PHPMailer-master/src/SMTP.php');
        $this->inclutLibrairie('LIB_Datation.php');
        $this->inclutLibrairie('LIB_CompteRendu.php');
        $this->inclutLibrairie('LIB_Montant.php');
        $this->inclutLibrairie('LIB_MontantBase.php');
        $this->inclutLibrairie('LIB_Description.php');
        $this->inclutLibrairie('LIB_Util.php');
        $this->inclutLibrairie('LIB_Liste.php');
        $this->inclutLibrairie('LIB_ListeChaines.php');
        $this->inclutLibrairie('LIB_Table.php');
        $this->inclutLibrairie('LIB_Table_s.php');
        $this->inclutLibrairie('LIB_Zip.php');
        $this->inclutLibrairie('LIB_TestPregMatch.php');
        $this->inclutLibrairie('LIB_Menu.php');
        $this->inclutLibrairie('LIB_Mail.php');
        $this->inclutLibrairie('LIB_infos_systeme.php');
        $this->inclutLibrairie('LIB_BDD_PDO.php');
        $this->inclutLibrairie('LIB_BDD_MySQL_PDO.php');
        $this->inclutLibrairie('LIB_BDD_Structure.php');
        $this->inclutLibrairie('LIB_BDD.php');
        $this->inclutLibrairie('LIB_ArbreTablesColonnes.php');
//        $this->inclutClasses('COU_log.php');
//        $this->inclutClasses('COU_gestion_logs.php');
        $this->inclutLibrairie('LIB_DistributeurObjetTable.php');
        $this->inclutLibrairie('LIB_MenuTables.php');
        $this->inclutLibrairie('LIB_TableColonne.php');
        $this->inclutLibrairie('LIB_TableColonne_s.php');
        
        $this->inclutClasses('CLA_onglet_principal.php');
        $this->inclutClasses('CLA_onglet_home.php');
        $this->inclutClasses('CLA_onglet_essais.php');
        $this->inclutClasses('CLA_onglet_liste_courses.php');
        $this->inclutClasses('CLA_onglet_tables.php');
        $this->inclutClasses('CLA_onglet_administration.php');
        $this->inclutClasses('CLA_barre_navigation.php');
        $this->inclutClasses('CLA_InitialisationBase.php');
        $this->inclutClasses('CLA_DistributeurObjets.php');
        $this->inclutClasses('CLA_Accueil.php');
        $this->inclutClasses('CLA_AccueilCourses.php');
        $this->inclutClasses('CLA_Acces.php');
        $this->inclutClasses('CLA_ListeCourses.php');
        $this->inclutParametres('PRM_Base.php');
        $this->inclutParametres('PRM_Bases.php');
        $this->inclutTables('TBL_Course.php');
        $this->inclutTables('TBL_Course_s.php');
        $this->inclutTables('TBL_Personne.php');
        
    }

    /**
     * Inclut le fichier
     * @param string $fichier
     */
    public function inclutFichier($fichier) {
        include_once $fichier;
    }

    public function inclutClasses($fichier) {
        $this->inclutFichier($this->getRacine() . $this->getCheminClasses() . $fichier);
    }

    public function inclutLibrairie($fichier) {
        $this->inclutFichier($this->getRacine() . $this->getCheminLibrairie() . $fichier);
    }

    public function inclutTables($fichier) {
        $this->inclutFichier($this->getRacine() . $this->getCheminTables() . $fichier);
    }

    public function inclutFonctions($fichier) {
        $this->inclutFichier($this->getRacine() . $this->getCheminFonctions() . $fichier);
    }

    public function inclutJavascript($fichier) {
        $this->inclutFichier($this->getRacine() . $this->getCheminJavascript() . $fichier);
    }

    public function inclutStyles($fichier) {
        $this->inclutFichier($this->getRacine() . $this->getCheminStyles() . $fichier);
    }

    public function inclutExt($fichier) {
        $this->inclutFichier($this->getRacine() . $this->getCheminExt() . $fichier);
    }

    public function inclutParametres($fichier) {
        $this->inclutFichier($this->getRacine() . $this->getCheminParametres() . $fichier);
    }

    /**
     * Renvoie le chemin entre racine et classes
     * @return string
     */
    private function getCheminClasses() {
        return 'classes/';
    }

    /**
     * Renvoie le chemin entre racine et librairie
     * @return string
     */
    private function getCheminLibrairie() {
        return 'librairie/';
    }

    /**
     * Renvoie le chemin entre racine et les classes de tables
     * @return string
     */
    private function getCheminTables() {
        return 'tables/';
    }

    /**
     * Renvoie le chemin entre racine et les classes de tables
     * @return string
     */
    private function getCheminFonctions() {
        return 'fonctions/';
    }

    /**
     * Renvoie le chemin entre racine et les classes de tables
     * @return string
     */
    private function getCheminJavascript() {
        return 'javascript/';
    }

    /**
     * Renvoie le chemin entre racine et styles
     * @return string
     */
    private function getCheminStyles() {
        return 'styles/';
    }

    /**
     * Renvoie le chemin entre racine et les extensions
     * @return string
     */
    private function getCheminExt() {
        return 'ext/';
    }

    /**
     * Renvoie le chemin entre racine et les extensions
     * @return string
     */
    private function getCheminParametres() {
        return 'parametrage/';
    }

    /**
     * Renvoie le chemin vers ajax
     * @return string
     */
    public function getCheminAjax() {
        return $this->getRacine() . 'ajax/';
    }

    /**
     * Renvoie la racine du site
     * @return string
     */
    public function getRacine() {
        return $this->document_root . '/';
    }

}
