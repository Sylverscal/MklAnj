<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_InitialisationBase
 * 
 * Actions pour charger la base en données pour la période des tests
 *
 * @author sylverscal
 */
class CLA_InitialisationBase {
    public function affiche_bloc() {
        $this->affiche_entete();
        
        $this->affiche_corps();
    }
    
    private function affiche_entete() {
        ?>
            <div class="w3-container w3-light-blue">
                <h2>Initialisation de la base</h2>
                <h4>Aspiration des données de la base Courses</h4>
            </div>
        <?php
    }
    
    private function affiche_corps() {
        ?>
            <div class="w3-container w3-pale-blue">
                <h3><button id="BTN_LANCE_IMPORT_DONNEES" class="w3-button">Import données</button></h3>
            </div>
        <?php
    }
       
    /**
     * 
     * @global LIB_BDD $CXO
     * @return LIB_CompteRendu Compte rendu
     */
    public function importDonnees() {
        $crdu = new LIB_CompteRendu(true, "");
        
        $crdu = $this->importVille();
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $crdu = $this->importCommerce();
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $crdu = $this->importUnite();
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $crdu = $this->importMarque();
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $crdu = $this->importArticle();
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $crdu = $this->initialiseComptes();
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $crdu = $this->initialiseZones();
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $crdu = $this->chargement_table_course();
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        return $crdu;
    }
    
    /**
     * @global LIB_BDD $CXO
     * @global LIB_BDD $CXO_C
     * 
     * @return LIB_CompteRendu Compte rendu
     */
    private function importVille() {
        global $CXO;
        global $CXO_C;
        
        $crdu = new LIB_CompteRendu(true, "");
        
        $requete_courses = "select nom from ville where nom <> '?' order by nom";
        
        $rlt_courses = $CXO_C->executeRequete($requete_courses);
        
        if ($rlt_courses->isKo()) {
            $crdu = $rlt_courses->getCompteRendu();
            return $crdu;
        }
        
        foreach ($rlt_courses->getResultat() as $value) {
            $requete_mklanj = sprintf("insert ignore into ville (nom) values ('%s')",$value['nom']);
            $rlt_mklanj = $CXO->executeRequete($requete_mklanj);
            if ($rlt_mklanj->isKo()) {
                $crdu = $rlt_mklanj->getCompteRendu();
                return $crdu;
            }
        }
        
        $requete = "INSERT IGNORE INTO `Ville` (`nom`) VALUES ('-');";
                
        $rlt = $CXO->executeRequete($requete);
        
        $crdu = $rlt->getCompteRendu();
        
        return $crdu;
    }
    
    /**
     * @global LIB_BDD $CXO
     * @global LIB_BDD $CXO_C
     * @return LIB_CompteRendu Compte rendu
     */
    private function importCommerce() {
        global $CXO;
        global $CXO_C;
        
        $crdu = new LIB_CompteRendu(true, "");
        
        $requete_courses = "select nom from enseigne where nom <> '?' order by nom";
        
        $rlt_courses = $CXO_C->executeRequete($requete_courses);
        
        if ($rlt_courses->isKo()) {
            $crdu = $rlt_courses->getCompteRendu();
            return $crdu;
        }
        
        foreach ($rlt_courses->getResultat() as $value) {
            $requete_mklanj = sprintf("insert ignore into commerce (nom) values ('%s')",$value['nom']);
            $rlt_mklanj = $CXO->executeRequete($requete_mklanj);
            if ($rlt_mklanj->isKo()) {
                $crdu = $rlt_mklanj->getCompteRendu();
                return $crdu;
            }
        }
        
        $requete = "INSERT IGNORE INTO `Commerce` (`nom`) VALUES ('-');";
                
        $rlt = $CXO->executeRequete($requete);
        
        $crdu = $rlt->getCompteRendu();
        
        return $crdu;
    }
    
    /**
     * @global LIB_BDD $CXO
     * @global LIB_BDD $CXO_C
     * @return LIB_CompteRendu Compte rendu
     */
    private function importUnite() {
        global $CXO;
        global $CXO_C;
        
        $crdu = new LIB_CompteRendu(true, "");
        
        $requete_courses = "select nom from Unite where nom <> '?' order by nom";
        
        $rlt_courses = $CXO_C->executeRequete($requete_courses);
        
        if ($rlt_courses->isKo()) {
            $crdu = $rlt_courses->getCompteRendu();
            return $crdu;
        }
        
        foreach ($rlt_courses->getResultat() as $value) {
            $requete_mklanj = sprintf("insert ignore into Unite (nom) values ('%s')",$value['nom']);
            $rlt_mklanj = $CXO->executeRequete($requete_mklanj);
            if ($rlt_mklanj->isKo()) {
                $crdu = $rlt_mklanj->getCompteRendu();
                return $crdu;
            }
        }
        
        $requete = "INSERT IGNORE INTO `Unite` (`nom`) VALUES ('-');";
                
        $rlt = $CXO->executeRequete($requete);
        
        $crdu = $rlt->getCompteRendu();
        
        return $crdu;
    }
    
    /**
     * @global LIB_BDD $CXO
     * @global LIB_BDD $CXO_C
     * @return LIB_CompteRendu Compte rendu
     */
    private function importMarque() {
        global $CXO;
        global $CXO_C;
        
        $crdu = new LIB_CompteRendu(true, "");
        
        $requete_courses = "select nom from marque where nom <> '?' order by nom";
        
        $rlt_courses = $CXO_C->executeRequete($requete_courses);
        
        if ($rlt_courses->isKo()) {
            $crdu = $rlt_courses->getCompteRendu();
            return $crdu;
        }
        
        foreach ($rlt_courses->getResultat() as $value) {
            $requete_mklanj = sprintf("insert ignore into Marque (nom) values ('%s')",$value['nom']);
            $rlt_mklanj = $CXO->executeRequete($requete_mklanj);
            if ($rlt_mklanj->isKo()) {
                $crdu = $rlt_mklanj->getCompteRendu();
                return $crdu;
            }
        }
        
        $requete = "INSERT IGNORE INTO `Marque` (`nom`) VALUES ('-');";
                
        $rlt = $CXO->executeRequete($requete);
        
        $crdu = $rlt->getCompteRendu();
        
        return $crdu;
    }
    
    /**
     * @global LIB_BDD $CXO
     * @global LIB_BDD $CXO_C
     * @return LIB_CompteRendu Compte rendu
     */
    private function importArticle() {
        global $CXO;
        global $CXO_C;
        
        $crdu = new LIB_CompteRendu(true, "");
        
        $requete_courses = "select 
distinct concat(TypeProduit.nom,' ',Produit.nom  ) as nom 
from Produit 
join TypeProduit on TypeProduit.id = Produit.id_TypeProduit 
join Famille on Famille.id = TypeProduit.id_famille 
join Domaine on Domaine.id = Famille.id_Domaine 
where TypeProduit.nom <> '?' and Produit.nom <> '?' and Domaine.nom <> 'Voiture'
order by nom";
        
        $rlt_courses = $CXO_C->executeRequete($requete_courses);
        
        if ($rlt_courses->isKo()) {
            $crdu = $rlt_courses->getCompteRendu();
            return $crdu;
        }
        
        foreach ($rlt_courses->getResultat() as $value) {
            $requete_mklanj = sprintf('insert ignore into article (nom) values ("%s")',$value['nom']);
            $rlt_mklanj = $CXO->executeRequete($requete_mklanj);
            if ($rlt_mklanj->isKo()) {
                $crdu = $rlt_mklanj->getCompteRendu();
                return $crdu;
            }
        }
        
        $requete = "INSERT IGNORE INTO `Article` (`nom`) VALUES ('-');";
                
        $rlt = $CXO->executeRequete($requete);
        
        $crdu = $rlt->getCompteRendu();
        return $crdu;
    }
    
    /**
     * @global LIB_BDD $CXO
     * @return LIB_CompteRendu Compte rendu
     */
    private function initialiseComptes() {
        global $CXO;

        $requete = "INSERT IGNORE INTO `Personne` (`id`, `nom`, `prenom`, `login`, `mot_de_passe`, `is_administrateur`) VALUES
(1, 'Grandjean', 'Pascal', 'Marcel', 'Mordekhai', 1),
(2, 'Grandjean', 'Véronique', 'Muzelle', 'Punky', 0);";
                
        $rlt = $CXO->executeRequete($requete);
        
        $crdu = $rlt->getCompteRendu();
        
        return $crdu;
    }
    
    /**
     * @global LIB_BDD $CXO
     * @return LIB_CompteRendu Compte rendu
     */
    private function initialiseZones() {
        global $CXO;

        $requete = "INSERT IGNORE INTO `Zone` (`nom`) VALUES
('-'),
('Alpha Park'),
('Mon Grand Plaisir')
;";
                
        $rlt = $CXO->executeRequete($requete);
        
        $crdu = $rlt->getCompteRendu();
        
        return $crdu;
    }
    
    /**
     * Remplit la table Course avec des exemples
     * @global LIB_DistributeurObjetTable $DOT
     * Exemple :
    [Article_nom] => Biscotte Complets
    [Marque_nom] => Brossard
    [Commerce_nom] => Intermarché
    [Ville_nom] => Jouars Pontchartrain
    [Zone_nom] => Alpha Park
    [Course_datation] => 14-04-2026
    [Course_nombre] => 1
    [Course_capacite] => 2
    [Unite_nom] => g
    [Course_commentaire] => Foo
    [Course_faite] => 0
     * -> Commande set
        $c->set(
                "Article_nom","Marque_nom",
                "Commerce_nom","Ville_nom","Zone_nom",
                "Course_datation",
                "Course_nombre","Course_capacite","Unite_nom",
                "Course_commentaire",
                "Course_faite"
                );
     */
    private function chargement_table_course() {
        global $DOT;
        $c = $DOT->getObjet("Course");
//        $c->set(
//                "Article_nom","Marque_nom",
//                "Commerce_nom","Ville_nom","Zone_nom",
//                "Course_datation",
//                "Course_nombre","Course_capacite","Unite_nom",
//                "Course_commentaire",
//                "Course_faite"
//                );
//        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "Biscuit Avoine complet Nutri+","Bjorg",
                "-","-","-",
                "01-01-2000",
                "1","0","-",
                "-",
                "0"
                );
        $crdu = $this->affiche_crdu_ajout($c) ;
        
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $c->set(
                "Croûtons nature","-",
                "G20","-","-",
                "01-01-2000",
                "1","0","-",
                "-",
                "0"
                );
        $crdu = $this->affiche_crdu_ajout($c) ;
        
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $c->set(
                "Désinfectant en pulvérisateur","Sanytol",
                "-","-","-",
                "01-01-2000",
                "1","0","-",
                "-",
                "0"
                );
        $crdu = $this->affiche_crdu_ajout($c) ;
        
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $c->set(
                "Jambon blanc","-",
                "-","-","-",
                "01-01-2000",
                "4","0","-",
                "-",
                "0"
                );
        $crdu = $this->affiche_crdu_ajout($c) ;
        
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $c->set(
                "Muesli amandes noisettes chocolat","-",
                "-","-","-",
                "01-01-2000",
                "1","0","-",
                "-",
                "0"
                );
        $crdu = $this->affiche_crdu_ajout($c) ;
        
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $c->set(
                "Pains grillés suédois bio complets","Krisprolls",
                "-","-","-",
                "01-01-2000",
                "1","0","-",
                "-",
                "0"
                );
        $crdu = $this->affiche_crdu_ajout($c) ;
        
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $c->set(
                "Palet breton","-",
                "-","-","-",
                "01-01-2000",
                "1","0","-",
                "-",
                "0"
                );
        $crdu = $this->affiche_crdu_ajout($c) ;
        
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $c->set(
                "Poisson pané rectangle surgelé","-",
                "-","-","-",
                "01-01-2000",
                "1","0","-",
                "-",
                "0"
                );
        $crdu = $this->affiche_crdu_ajout($c) ;
        
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $c->set(
                "Pâtée chien medium ageing","Royal canin",
                "-","-","-",
                "01-01-2000",
                "1","0","-",
                "-",
                "0"
                );
        $crdu = $this->affiche_crdu_ajout($c) ;
        
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $c->set(
                "Sachet pâtée en sauce","Pédigrée",
                "-","-","-",
                "01-01-2000",
                "1","0","-",
                "-",
                "0"
                );
        $crdu = $this->affiche_crdu_ajout($c) ;
        
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $c->set(
                "Vinaigre ménager","-",
                "-","-","-",
                "01-01-2000",
                "1","0","-",
                "-",
                "0"
                );
        $crdu = $this->affiche_crdu_ajout($c) ;
        
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        return $crdu;
    }
    
    private function affiche_crdu_ajout($objet_table) {
        $crdu = $objet_table->sauve();
        
        $objet_table->setId(0);
        
        return $crdu;
    }
}

