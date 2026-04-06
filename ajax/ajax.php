<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/classes/CLA_inclusions.php";

$i = new CLA_inclusions();
$i->inclut();

global $CXO;
global $CXO_ST; // Pour accéder à la base "structure"
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
        $CXO = new LIB_BDD(new PRM_BaseLocale());
        
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
    
    protected function achats($post) {
        new MKL_onglet_mklanj();
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

class CLA_gestion_administration_Ajax extends AJX_MklAnj_Ajax {
    protected function afficheAdministration($post) {
        $nom_administration = $post['nom_administration'];
        
        $this->$nom_administration();
    }
    
    private function INIT_BASE() {
        $o = new CLA_InitialisationBase();
        $o->affiche_bloc();
    }
    
    private function TRANSFERT_BASE() {
        $o = new CLA_TransfertBase();
        $o->affichePosteCommande();
    }
    
    private function RAMASSE_MIETTES() {
        $o = new CLA_RamasseMiettes();
        $o->affiche();
    }
}

class CLA_transfert_base_Ajax extends AJX_MklAnj_Ajax {
    protected function vidageBases() {
        $o = new CLA_TransfertBase();
        $o->afficheVidageBase();
    }
    
    protected function vidageUneBase($post) {
        $nom_base = $post['nom_base'];
        $o = new CLA_TransfertBase();
        LIB_Util::logPrintR($post);
        $liste_crdus = $o->vidageUneBase($nom_base);
        
        $liste_crdus->affiche();
    }
    
    protected function getTauxTransfert() {
        $o = new CLA_TransfertBase();
        $donnees = $o->getTauxTransfert();
        
        LIB_Util::jsonise($donnees);
    }
}

class CLA_transfert_table_Ajax extends AJX_MklAnj_Ajax {
    protected function affiche($post) {
        $table_source = $post['table_source'];
        $table_destination = $post['table_destination'];
        $tm = new CLA_TransfertTable($table_source,$table_destination);
        $tm->affiche();
    }
    
    protected function afficheTableau($post) {
        $table_source = $post['table_source'];
        $table_destination = $post['table_destination'];
        $tm = new CLA_TransfertTable($table_source,$table_destination);
        $tm->afficheTableau($post['avec_deja_associes']);
    }
    
    protected function afficheElementChoisi($post) {
        $nom_classe = sprintf("TT_Table_%s",$post['table_source']);
        $tm = new $nom_classe($post['table_source'],$post['id_source']);
        $tm->charge();
        $tm->afficheElementChoisi();
    }

    /**
     * Affiche la fenêtre d'édition de l'élément pour le transfert
     * @param array $post
     * @global LIB_DistributeurObjetTable $DOT
     */
    protected function afficheEditionTransfert($post) {
        global $DOT;

        $classe = $this->getNomClasse($post);
        $table = $DOT->getObjet($classe);
        $id_source = $post['id_source'];
        $table_source = $post['table_source'];
        $table->afficheEditionTransfert($table_source,$id_source);
    }
    
    /**
     * Affiche la fenêtre d'édition de l'élément pour le transfert
     * @param array $post
     * @global LIB_DistributeurObjetTable $DOT
     */
    protected function afficheEditionPropositionTransfert($post) {
        global $DOT;

        $classe = $this->getNomClasse($post);
        $table = $DOT->getObjet($classe);
        $id_destination = $post['id_destination'];
        $table->afficheEditionPropositionTransfert($id_destination);
    }
    
    /**
     * Associe un magasin à un commerce
     * @param array $post
     * @global LIB_DistributeurObjetTable $DOT
     */
    protected function traiteAssociation($post) {
        $table_source = $post['table_source'];
        $table_destination = $post['table_destination'];
        $id_source = $post['id_source'];
        $donnees = $post['donnees'];
        
        $tm = new CLA_TransfertTable($table_source, $table_destination);
        $tm->associeSourceADestination($id_source, $donnees);
        
        /**
         * Lecture du taux de transfert pour le mettre à jour à l'affichage
         */
        $o = new CLA_TransfertBase();
        $taux = $o->getTauxTransfert();
        LIB_Util::jsonise($taux);
        
    }
    
    protected function affichePropositions($post) {
        $donnees = $post['donnees'];
        $table_source = $post['table_source'];
        $table_destination = $post['table_destination'];
        
        $tm = new CLA_TransfertTable($table_source, $table_destination);
        $tm->affichePropositions($donnees);
    }
    
    protected function calculeProposition($post) {
        $id_source = $post['id_source'];
        $table_source = $post['table_source'];
        $table_destination = $post['table_destination'];
        
        $tm = new CLA_TransfertTable($table_source, $table_destination);
        $proposition = $tm->calculeProposition($id_source);
        
        LIB_Util::jsonise($proposition);
    }
}

class CLA_transfert_articles_Ajax extends AJX_MklAnj_Ajax {
    protected function affiche() {
        $tm = new CLA_TransfertArticles();
        $tm->affiche();
    }
}

class CLA_transfert_releves_Ajax extends AJX_MklAnj_Ajax {
    protected function affiche() {
        $tm = new CLA_TransfertReleves();
        $tm->affiche();
    }
    
    protected function affiche_liste_releves($post) {
        $nb_releves = $post['nb_releves'];
        
        $tr = new CLA_TransfertReleves();
        $tr->afficheListeReleves($nb_releves);
    }
    
    protected function affiche_liste_en_attente($post) {
        $nb_releves = $post['nb_releves'];
        
        $tr = new CLA_TransfertReleves();
        $tr->afficheListeEnAttente($nb_releves);
    }
    
    protected function affiche_liste_rejetes($post) {
        $nb_releves = $post['nb_releves'];
        
        $tr = new CLA_TransfertReleves();
        $tr->afficheListeRejetes($nb_releves);
    }
    
    protected function affiche_transfert($post) {
        $id = $post['id'];
        $automatique = $post['automatique'];
        
        $tr = new CLA_TransfertReleves();
        $tr->afficheTransfert($id,$automatique);
        if ($automatique == 1) {
            $tr->transfertAutomatique($id);
        }
    }
    
    protected function transfert($post) {
        $id = $post['id'];
        
        $tr = new CLA_TransfertReleves();
        $tr->transfereReleve($id);
    }
    
    protected function rejet($post) {
        $id = $post['id'];
        
        $tr = new CLA_TransfertReleves();
        $tr->rejeteReleve($id);
    }
    
    protected function en_attente($post) {
        $id = $post['id'];
        
        $tr = new CLA_TransfertReleves();
        $tr->metReleveEnAttente($id);
    }
    
    protected function reinitialisation_releves($post) {
        $tr = new CLA_TransfertReleves();
        $tr->reinitialise();
    }
}

class CLA_achats_Ajax extends AJX_MklAnj_Ajax {
    protected function enregistreDomaineChoisi($post) {
        $id = $post["id"];
        $o = new CLA_Achats();
        $crdu = $o->enregistreDomaineChoisi($id);
        $crdu->emissionJson();
    }
    
    protected function afficheListeAchats($post) {
        $o = new CLA_Achats();
        $o->afficheListeAchats();
    }
    
    protected function afficheListeAchatsFiltree($post) {
        $o = new CLA_Achats();
        if (isset($post['filtre'])) {
            $o->afficheListeAchatsFiltree($post['filtre']);
        } else {
            $o->afficheListeAchats();
        }
    }
    
    protected function modifieValeur($post) {
        $id = $post['id_achat'];
        $colonne = $post['colonne'];
        $valeur = $post['valeur'];
        
        $o = new CLA_Achats();
        $crdu = $o->modifieValeur($id, $colonne, $valeur);
        $crdu->emissionJson();
    }
    
    protected function supprime($post) {
        global $DOT;

        $a = $DOT->getObjet("Achat");
        $a->setId($post['id']);
        $crdu = $a->supprime();
        $crdu->emissionJson();
    }
    
    protected function duplique($post) {
        global $DOT;

        $a = $DOT->getObjet("Achat");
        $a->setId($post['id']);
        $crdu = $a->duplique();
        $crdu->emissionJson();
    }
    
    protected function afficheFormulaire($post) {
        global $DOT;

        $a = $DOT->getObjet("Achat");
        $a->afficheFormulaire($post['id']);
    }
    
    protected function annuleAchatTemporaire($post) {
        global $DOT;

        $a = $DOT->getObjet("Achat");
        $crdu = $a->annuleAchatTemporaire($post['id_annule']);
        
        $crdu->emissionJson();
    }

    protected function affichePosteDeCommande($post) {
        $o = new CLA_Achats();
        $o->affichePosteDeCommande();
    }

    protected function traiteModification($post) {
        global $DOT;

        $achat = $DOT->getObjet("Achat");
        $donnees = $post['donnees'];

        $crdu = $achat->traiteModification($donnees);

        $crdu->emissionJson();
    }

    protected function getDonneesBloc($post) {
        global $DOT;
        
        $nom_table = $post['nom_table'];
        $id = $post['id'];
        
        $achat = $DOT->getObjet($nom_table);
        $achat->setId($id);
        $achat->charge();
        
        $tab = $achat->getDonneesPourMenuBloc();
        
        LIB_Util::jsonise($tab);
    }
    
    protected function afficheListeAchatsMemeArticle($post) {
        $id_achat = $post['id_achat'];
        $o = new CLA_Achats();
        $o->afficheListeAchatsMemeArticle($id_achat);
    }
}

class CLA_graphiques_Ajax extends AJX_MklAnj_Ajax {
    protected function affiche($post) {
        $id_achat = $post['id_achat']; 
        $gra = new CLA_Graphiques($id_achat);
        $gra->affiche();
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

class CLA_ramasse_miettes_Ajax extends AJX_MklAnj_Ajax {
    protected function traite_table($post) {
        $nom_table = $post['nom_table'];
        
        $rm = new CLA_RamasseMiettes();
        $rm->TraiteTable($nom_table);
    }
    
    protected function supprime_element($post) {
        global $DOT;
        
        $nom_table = $post['nom_table'];
        $id = $post['id'];
        
        $o = $DOT->getObjet($nom_table);
        $o->charge($id);
        
        $o->supprime();
        
        $o_s = $DOT->getObjet_s($nom_table);
        $nb_orphelins = $o_s->getNbElementsNonLies();
        
        LIB_Util::jsonise($nb_orphelins);
        
    }
}

class CLA_accueil_Ajax extends CLA_achats_Ajax {
    protected function affiche($post) {
        $a = new CLA_Accueil();
        $a->affiche();
    }
    
    protected function affiche_accueil_courses($post) {
        $ac = new CLA_AccueilCourses();
        $ac->affiche();
    }
}
    
class CLA_acces_Ajax extends CLA_achats_Ajax {
    protected function affiche($post) {
        $a = new CLA_Acces();
        $a->affiche();
    }
    
    protected function controle($post) {
        $donnees = $post['donnees'];
        LIB_Util::logPrintR($donnees);

        $a = new CLA_Acces();
        $crdu = $a->controle($donnees);

        $crdu->emissionJson();
    }

}
    
