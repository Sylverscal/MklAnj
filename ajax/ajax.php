<?php

/**
 * AJAX de LISTE DE COURSES : MklAnj
 */

include_once $_SERVER['DOCUMENT_ROOT'] . "/classes/CLA_inclusions.php";

$i = new CLA_inclusions();
$i->inclut();

global $CXO;
global $CXO_ST; // Pour accéder à la base "structure"
global $CXO_C; // Pour accéder à la base "Courses"
global $DOT;

LIB_Util::log("Entrée dans AJAX", $_POST['action']=='affichePosteDeCommande' ? FALSE : TRUE);
//LIB_Util::log("Entrée dans AJAX",true);
//LIB_Util::log("Entrée dans AJAX");

LIB_Util::logPrintR($_POST,'POST');

$domaine = $_POST['domaine'];
$nomClasse = "CLA_" . $domaine . "_Ajax";
$tests = new $nomClasse($_POST);

abstract class AJX_MklAnj_Ajax {

    function __construct($post) {
        global $CXO;
        $CXO = new LIB_BDD(new PRM_MklAnj());
        
        global $CXO_C;
        $CXO_C = new LIB_BDD(new PRM_Courses());
        
        global $CXO_ST;
        $CXO_ST = new LIB_BDD_Structure();
        
        global $DOT;
        $DOT = new LIB_DistributeurObjetTable();
        $DOT->constitueListeTable();
        $DOT->calculeRequeteSelectLibelle();

        $action = isset($post ['action']) ? $post ['action'] : 0;
        $this->{$action}($post);
    }

    /**
     * Renvoie le nom de la classe de la table_s
     * @param type $post
     * @return string nom de la classe de la table_s
     */
    protected function getNomClasses($post) {
        $table = $post['nom_table'];

        $classe = "TBL_$table" . '_s';

        return $classe;
    }
    
    protected function getNomTable($post) {
        return $post['nom_table'];
    }

    /**
     * Renvoie le nom de la classe de la table
     * @param type $post
     * @return string nom de la classe de la table
     */
    protected function getNomClasse($post) {
        $table = $post['nom_table'];

        $classe = "TBL_$table";

        return $classe;
    }

}

class CLA_barre_navigation_Ajax extends AJX_MklAnj_Ajax {
    protected function affiche($post) {
        $bn = new CLA_barre_navigation();
        
        $onglet = isset($post ['onglet']) ? $post ['onglet'] : 0;

        $bn->affiche($onglet);
    }
}


/**
 * Classe pour gérer les onglets principaux
 */
class CLA_onglet_Ajax extends AJX_MklAnj_Ajax {

    protected function home($post) {
        new CLA_onglet_home();
    }
    
    protected function liste_courses($post) {
        new CLA_onglet_liste_courses();
    }
    
    protected function essais($post) {
        new CLA_onglet_essais();
    }

    protected function administration($post) {
        new CLA_onglet_administration();
    }

    protected function tables($post) {
        new CLA_onglet_tables();
    }

}

class CLA_adm_init_base_Ajax extends AJX_MklAnj_Ajax {
    protected function import_donnees($post) {
        $ib = new CLA_InitialisationBase();
        $crdu = $ib->importDonnees();
        
        $crdu->emissionJson();
    }
    
}

class CLA_gestion_administration_Ajax extends AJX_MklAnj_Ajax {
    protected function afficheAdministration($post) {
        $nom_administration = $post['nom_administration'];
        
        $this->$nom_administration();
    }
    
    private function INIT_BASE() {
        $o = new CLA_InitialisationBase();
        $o->affiche_bloc();
    }
    
}

/**
 * Classe pour gérer le mode gestion des tables
 */
class CLA_gestion_table_Ajax extends AJX_MklAnj_Ajax {

    protected function affiche_liste_tables($post) {
        $gt = new LIB_MenuTables();
        $gt->affiche();
    }

    /**
     * Affiche la descrfiption de la table
     * @param array $post
     * @global LIB_DistributeurObjetTable $DOT
     */
    protected function afficheTitre($post) {
        global $DOT;
        
        $nom_classe = $this->getNomClasses($post);
        
        $table = $DOT->getObjet($nom_classe);
        ?>
        <h1 class="w3-red w3-block"><?php echo $table->getDescription()->get_decription_titre(); ?></h1>
        <h4 class="w3-deep-orange"><?php echo $table->getDescription()->get_decription_aide(); ?></h4>
        <?php
    }

    /**
     * Affiche la table
     * @param array $post
     * @global LIB_DistributeurObjetTable $DOT
     */
    protected function afficheTable($post) {
        global $DOT;
        
        $classe = $this->getNomClasses($post);
        $table = $DOT->getObjet($classe);
        $table->setModeGestion(TRUE);
        $table->charge();
        $table->affiche();
    }

    /**
     * Affiche la fenêtre d'édition de l'élément
     * @param array $post
     * @global LIB_DistributeurObjetTable $DOT
     */
    protected function afficheEdition($post) {
        global $DOT;

        $classe = $this->getNomClasses($post);
        $table = $DOT->getObjet($classe);
        $table->setModeGestion(TRUE);
        $id = $post['id'];
        $table->afficheEdition($id);
    }

    protected function traiteModification($post) {
        global $DOT;

        $classe = $this->getNomClasses($post);
        $table = $DOT->getObjet($classe);
        $table->setModeGestion(TRUE);
        $id = $post['id'];
        $donnees = $post['donnees'];

        $crdu = $table->modifieElement($id, $donnees);

        $crdu->emissionJson();
    }

    protected function traiteSuppression($post) {
        global $DOT;

        $classe = $this->getNomClasses($post);
        $table = $DOT->getObjet($classe);
        $table->setModeGestion(TRUE);
        $id = $post['id'];

        $crdu = $table->supprimeElement($id);
        $crdu->emissionJson();
        
    }

    protected function traiteAjout($post) {
        global $DOT;

        $classe = $this->getNomClasses($post);
        $table = $DOT->getObjet($classe);
        $table->setModeGestion(TRUE);
        $donnees = $post['donnees'];

        $crdu = $table->ajouteElement($donnees);
        $crdu->emissionJson();
    }

    protected function renseigneMenu($post) {
        global $DOT;

        $classe = $this->getNomClasses($post);
        $table = $DOT->getObjet($classe);
        $table->setModeGestion(TRUE);

        $table->renseigneMenu();
    }

    protected function litValeur($post) {
        global $DOT;

        $classe = $this->getNomClasses($post);
        $table = $DOT->getObjet($classe);
        $table->setModeGestion(TRUE);

        $id = $post['id'];
        $colonne = $post['colonne'];

        $table->getValeurColonne($id, $colonne);
    }

    protected function incrementeValeur($post) {
        global $DOT;

        $classe = $this->getNomClasses($post);
        $table = $DOT->getObjet($classe);
        $table->setModeGestion(TRUE);

        $id = $post['id'];
        $colonne = $post['colonne'];
        $increment = $post['increment'];

        $table->incrementeValeurColonne($id, $colonne, $increment);
    }

}

class CLA_initialisation_base_Ajax extends AJX_MklAnj_Ajax {
    protected function affiche_bloc($post) {

        $ca = new CLA_InitialisationBase();
        $ca->affiche_bloc();
        
    }
    
    protected function choix_tables($post) {

        $ca = new CLA_InitialisationBase();
        $ca->choix_tables($post['donnees']);
        
    }
}

class CLA_accueil_Ajax extends AJX_MklAnj_Ajax {
    protected function affiche($post) {
        $a = new CLA_Accueil();
        $a->affiche();
    }
    
    protected function affiche_accueil_courses($post) {
        $ac = new CLA_AccueilCourses();
        $ac->affiche();
    }
}
    
class CLA_acces_Ajax extends AJX_MklAnj_Ajax {
    protected function affiche($post) {
        $a = new CLA_Acces();
        $a->affiche();
    }
    
    protected function controle($post) {
        $donnees = $post['donnees'];

        $a = new CLA_Acces();
        $crdu = $a->controle($donnees);

        $crdu->emissionJson();
    }

}
    
class CLA_liste_courses_Ajax extends AJX_MklAnj_Ajax {
    protected function affiche_vue_principale($post) {
        $a = new CLA_ListeCourses();
        $a->afficheVuePrincipale();
    }
    
    protected function affiche_liste_courses($post) {
        $lc = new CLA_ListeCourses();
        $lc->afficheListeCourses();
    }
}

class CLA_gestion_liste_courses_Ajax extends AJX_MklAnj_Ajax {
    protected function change_etat_faite($post) {
        global $DOT;
        
        $id = $post['id'];
        $etat =$post['etat'];
        
        $c = $DOT->getObjet("Course");
        $c->setId($id);
        $c->majEtatCourseFaite($etat);
    }
}
