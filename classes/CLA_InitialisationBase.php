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
    private $compteur_achats_ajoutes;
    
    public function affiche_bloc() {
        $this->affiche_entete();
        
        $this->affiche_corps();
    }
    
    private function affiche_entete() {
        ?>
            <div class="w3-container w3-light-blue">
                <h2>Initialisation de la base</h2>
                <h4>Choix des tables où ensemble de table à charger</h4>
                <h4 class="w3-red">A n'utiliser que pendant la mise au point de l'application</h4>
            </div>
        <?php
    }
    
    private function affiche_corps() {
        ?>
            <div class="w3-container w3-pale-blue">
                <form id="formulaire_choix_tables" class="w3-container">
                    <div class="w3-grid" style="grid-template-columns: auto auto">
                        <div class="w3-container w3-border">
                            <div class="w3-container w3-cyan">
                                <p>
                                    <span>Achat</span><input class="w3-check w3-right CAC_INIBASE_ACH_TOUT" type="checkbox">
                                </p>
                            </div>
                            <p>
                                <input class="w3-check CAC_INIBASE_ACH" type="checkbox" name="Achat" checked>
                                <label>Achat</label>
                            </p>
                        </div>
                        <div class="w3-container w3-border">
                            <p>
                                <input id="tout_selectionner" class="w3-check CAC_INIBASE_TOUT" type="checkbox">
                                <label>Tout sélectionner</label>
                            </p>
                        </div>
                        
                        <div class="w3-container w3-border">
                            <div class="w3-container w3-cyan">
                                <p>
                                    <span>Administration</span><input class="w3-check w3-right CAC_INIBASE_ADM_TOUT" type="checkbox">
                                </p>
                            </div>
                            <p>
                                <input class="w3-check CAC_INIBASE_ADM" type="checkbox" name="VariableSysteme" checked>
                                <label>Variable système</label>
                            </p>
                            <p>
                                <input class="w3-check CAC_INIBASE_ADM" type="checkbox" name="Personne" checked>
                                <label>Personne</label>
                            </p>
                        </div>
                        <div class="w3-container w3-border">
                            <div class="w3-container w3-cyan">
                                <p>
                                    <span>Choses à acheter</span><input class="w3-check w3-right CAC_INIBASE_CHA_TOUT" type="checkbox">
                                </p>
                            </div>
                            <p>
                                <input class="w3-check CAC_INIBASE_CHA" type="checkbox" name="Article">
                                <label>Article</label>
                            </p>
                            <p>
                                <input class="w3-check CAC_INIBASE_CHA" type="checkbox" name="Produit">
                                <label>Produit</label>
                            </p>
                            <p>
                                <input class="w3-check CAC_INIBASE_CHA" type="checkbox" name="Marque">
                                <label>Marque</label>
                            </p>
                            <p>
                                <input class="w3-check CAC_INIBASE_CHA" type="checkbox" name="TypeProduit">
                                <label>Type produit</label>
                            </p>
                            <p>
                                <input class="w3-check CAC_INIBASE_CHA" type="checkbox" name="Famille">
                                <label>Famille</label>
                            </p>
                            <p>
                                <input class="w3-check CAC_INIBASE_CHA" type="checkbox" name="Domaine">
                                <label>Domaine</label>
                            </p>
                        </div>
                        <div class="w3-container w3-border">
                            <div class="w3-container w3-cyan">
                                <p>
                                    <span>Lieu achat</span><input class="w3-check w3-right CAC_INIBASE_LIA_TOUT" type="checkbox">
                                </p>
                            </div>
                            <p>
                                <input class="w3-check CAC_INIBASE_LIA" type="checkbox" name="Commerce">
                                <label>Commerce</label>
                            </p>
                            <p>
                                <input class="w3-check CAC_INIBASE_LIA" type="checkbox" name="Enseigne">
                                <label>Enseigne</label>
                            </p>
                            <p>
                                <input class="w3-check CAC_INIBASE_LIA" type="checkbox" name="Ville">
                                <label>Ville</label>
                            </p>
                        </div>
                        <div class="w3-container w3-border">
                            <div class="w3-container w3-cyan">
                                <p>
                                    <span>Présentation des choses à acheter</span><input class="w3-check w3-right CAC_INIBASE_PCA_TOUT" type="checkbox">
                                </p>
                            </div>
                            <p>
                                <input class="w3-check CAC_INIBASE_PCA" type="checkbox" name="Conditionnement">
                                <label>Conditionnement</label>
                            </p>
                            <p>
                                <input class="w3-check CAC_INIBASE_PCA" type="checkbox" name="Contenant">
                                <label>Contenant</label>
                            </p>
                            <p>
                                <input class="w3-check CAC_INIBASE_PCA" type="checkbox" name="TypeContenant">
                                <label>Type contenant</label>
                            </p>
                            <p>
                                <input class="w3-check CAC_INIBASE_PCA" type="checkbox" name="Unite">
                                <label>Unité</label>
                            </p>
                            <p>
                                <input class="w3-check CAC_INIBASE_PCA" type="checkbox" name="Regroupement">
                                <label>Regroupement</label>
                            </p>
                            <p>
                                <input class="w3-check CAC_INIBASE_PCA" type="checkbox" name="TypeRegroupement">
                                <label>Type regroupement</label>
                            </p>

                        </div>
                        <div class="w3-container w3-border">
                            <p>
                                <button id="formulaire_choix_tables_validation" type="submit" class="w3-btn w3-padding w3-teal" style="width:120px">Action &nbsp; ❯</button>
                            </p>
                            <p>
                                <input class="w3-check" type="checkbox" name="ViderAvant" checked>
                                <label>Vider toute la base avant</label>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
            <div id="formulaire_choix_tables_crdu" class="w3-container">

            </div>
        <?php
    }
    
    public function choix_tables($donnees) {
        ?>
            <H1 class="w3-purple">Compte rendu initialisation des tables</H1>
        <?php
        
        if ($this->isVidageToutesTablesDemande($donnees)) {
            $this->vidage_toutes_tables();
        }
        
        //$this->vidage_tables($donnees);
        
        $this->chargement_tables($donnees);
    }
    
    /**
     * Renvoie si on a demandé le vidage de toutes les tables avant d'initialiser les tables.
     * On le sait si, dans le tableau "donnees", il y a l'élément "ViderAvant"
     * @param type $donnees
     * @return bool 
     */
    private function isVidageToutesTablesDemande($donnees) {
        foreach ($donnees as $element) {
            if ($element['name'] == "ViderAvant") {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Vider toutes les tables
     */
    private function vidage_toutes_tables(){
        ?>
            <H1 class="w3-red">Vider toutes les tables</H1>
        <?php
        
        $b = new LIB_BDD_Structure();
        $liste_tables = $b->getListeNomTables();
        
        $is_erreur = true;
        
        while($is_erreur) {
            ?>
                <H5 class="w3-amber">Giclée de vidages</H5>
            <?php
            $is_erreur = false;
            
            foreach ($liste_tables as $nom_table) {
                // Ici le vidage de la table avec capture de l'erreur
                $crdu = $this->vidage_une_table($nom_table,true);
                
                if ($crdu->isKo()) {
                    $is_erreur = true;
                }
            }
            
        }
    }
    
    /**
     * Vider seulement les tables choisies
     * @param type $donnees Liste des tables choisies
     */
    private function vidage_tables($donnees) {
        ?>
            <H2 class="w3-deep-purple">Phase 1 : Vidage des tables</H2>
        <?php
        $b = new LIB_BDD_Structure();
        foreach ($donnees as $element) {
            $nom_table = $element['name'];
            if ($b->isExisteTable($nom_table)) {
                $this->vidage_une_table($nom_table);
            }
        }
    }
    
    /**
     * 
     * @global LIB_BDD $CXO
     * @param type $nom_table
     * @param type $is_trace_seulement_si_erreur
     */
    private function vidage_une_table($nom_table,$is_trace_seulement_si_erreur = false) {
        global $CXO;
        
        $requete_delete = "delete from `$nom_table` where id > 0";
        $retour = $CXO->executeRequete($requete_delete);
        $crdu = $retour->getCompteRendu();
        
        if ($crdu->isKo() || (!$is_trace_seulement_si_erreur && $crdu->isOk())) {
        ?>
            <H3 class="w3-indigo">Vidage une table : <?php echo $nom_table; ?></H3>
            <table class="w3-table">
                <tr>
                    <th colspan="2">Compte rendu</th>
                </tr>
                <tr>
                    <th>Erreur</th>
                    <th><?php echo $crdu->getEtatErreur(); ?></th>
                </tr>
                <?php
                    if ($crdu->getEtatErreur()) {
                ?>
                <tr>
                    <th>Résumé</th>
                    <td><?php echo $crdu->getResume(); ?></td>
                </tr>
                <tr>
                    <th>Détail</th>
                    <td>
                        <?php 
                        foreach ($crdu->getDetail() as $index => $message){
                            if ($index > 0) {
                                echo '<br>';
                            }
                            echo $message;
                        }
                        ?>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        <?php
        }
        
        return $crdu;
    }
    
    private function chargement_tables($donnees) {
        ?>
            <H2 class="w3-deep-purple">Phase 2 : Chargement des tables</H2>
        <?php
        $b = new LIB_BDD_Structure();
        $tab = array_reverse($donnees);
        foreach ($tab as $element) {
            $nom_table = $element['name'];
            if ($b->isExisteTable($nom_table)) {
                $this->chargement_une_table($nom_table);
            }
        }
    }
    
    private function chargement_une_table($nom_table) {
        ?>
            <H3 class="w3-indigo">Chargement une table : <?php echo $nom_table; ?></H3>
        <?php
        
        $fonction = sprintf ("chargement_table_%s",$nom_table);
        ?>
            <h5 class="w3-yellow"><?php echo $fonction; ?></h5>
        <?php
        
        ?>
            <table class="w3-table w3-border">
        <?php
        $this->$fonction();
        ?>
            </table>
        <?php
        
    }
    
    private function chargement_table_Achat() {
        $this->compteur_achats_ajoutes = 0;
        
//        $this->chargement_table_Achat_Test();
//        $this->chargement_table_Achat_UnSeul();
        $this->chargement_table_Achat_Voiture();
        $this->chargement_table_Achat_Alimentation();
    }
    
    private function chargement_table_Achat_Test() {
        global $DOT;
        $achat = $DOT->getObjet("Achat");

        $achat->set(
                "AAAAA", "BBBBB", "CCCCC", "DDDDD", "EEEEE",
                "FFFFF", "GGGGG", "HHHHH", "IIIII", "JJJJJ", 
                "KKKKK", 1212121, 1313131, 1414141, "OOOOO", 
                1616161, "QQQQQ", 1717171, 1818181, "05-12-2025",
                2020202, "VVVVV"
        );

        $this->affiche_crdu_ajout($achat) ;
    }

    private function chargement_table_Achat_UnSeul() {
        global $DOT;
        $achat = $DOT->getObjet("Achat");

        $achat->set(
                "Intermarché", "Jouars Pontchartrain", "78760", "La Bonde",
                "Reblochon de Savoie", "Pochat", "Fromage", "Laitage", "Alimentation",
                "Emballage", "Papier", 1, 0, 1000, "g", 1, "Unité", 1,
                450,
                "05-12-2025",
                379,
                ""
        );

        $this->affiche_crdu_ajout($achat) ;
    }

    private function chargement_table_Achat_Alimentation() {
        global $DOT;
        $achat = $DOT->getObjet("Achat");
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Reblochon de Savoie","Pochat","Fromage","Laitage","Alimentation",   
                "Emballage","Papier",1,0,1000,"g",1,"Unité",1,   
                450,
                "05-12-2001",
                999901,
                ""
                );
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "G20","Beynes","78650","Centre commercial l Estandard",
                "Cocktail Tropical","Pago","Multifruit","Jus de fruit","Alimentation",   
                "Bouteille","Plastique",1,750,1000,"ml",0,"Unité",1,   
                750,
                "10-02-2002",
                999902,
                ""
                );
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "G20","Beynes","78650","Centre commercial l Estandard",
                "Orange sans pulpe","Pago","Multifruit","Jus de fruit","Alimentation",   
                "Bouteille","Plastique",1,750,1000,"ml",0,"Unité",1,   
                750,
                "10-02-2003",
                999903,
                ""
                );
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Ptit Yop Vanille","Yoplait","Yaourt à boire","Laitage","Alimentation",
                "Bouteille","Plastique",1,180,1000,"g",1,"Pack",6,
                1080,
                "05-12-2004",
                999904,
                ""
                );
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Jaune",                // Nom produit
                "-",                    // Marque
                "Banane",               // Type de produit
                "Fruit",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "-",                    // Nom de contenant
                "-",                    // Type de contenant (matière)
                0,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                0,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                1000,                    // Poids
                
                "12-12-2005",           // Date
                999905,
                ""
                );
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "Navel","-","Orange","Fruit","Alimentation",
                "-","-",0,0,1000,"g",0,
                "Unité",1,
                1000,
                "12-12-2006",
                999906,
                ""
                );
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde", 
                "-","-","Poireau","Légume","Alimentation",
                "-","-",0,0,1000,"g",0,
                "Unité",1,
                1000,
                "12-12-2007",
                999907,
                ""
                );
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Grappe","-","Tomate","Légume","Alimentation",
                "-","-",0,0,1000,"g",0,
                "Unité",1,
                1000,
                "12-12-2008",           // Date
                999908,
                ""
                );
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Leclerc", "Bois d Arcy", "78390", "-",
                "Classic", "Coca cola", "Soda", "Boisson non alcoolisée", "Alimentation",
                "Bouteille", "Verre", "1", "250", "1000", "ml", "0",
                "Carton", 6,
                '1500',
                "10-02-2009",
                '999909',
                ""
                );
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                'Leclerc', 'Bois d Arcy', '78390', '-', 'Classic', 'Coca cola', 'Soda', 'Boisson non alcoolisée', 'Alimentation', 'Bouteille', 'Plastique', '1', '330', '1000', 'ml', '0', 'Carton', '6', '1980', '2010-02-10 20:39:56', '999910', ''
                );
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "-",                    // Nom produit
                "-",                    // Marque
                "Endive",               // Type de produit
                "Légume",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "-",                    // Nom de contenant
                "-",                    // Type de contenant (matière)
                0,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                0,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                1000,                    // Poids
                
                "12-12-2025",           // Date
                379                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "-",                    // Nom produit
                "-",                    // Marque
                "Carotte",               // Type de produit
                "Légume",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "-",                    // Nom de contenant
                "-",                    // Type de contenant (matière)
                0,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                0,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                1000,                    // Poids
                
                "12-12-2025",           // Date
                379                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "-",                    // Nom produit
                "-",                    // Marque
                "Clémentine",               // Type de produit
                "Fruit",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "-",                    // Nom de contenant
                "-",                    // Type de contenant (matière)
                0,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                0,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                1000,                    // Poids
                
                "12-12-2025",           // Date
                299                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Lavallée",             // Nom produit
                "-",                    // Marque
                "Raisin",               // Type de produit
                "Fruit",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "-",                    // Nom de contenant
                "-",                    // Type de contenant (matière)
                0,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                0,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                1000,                    // Poids
                
                "12-12-2025",           // Date
                299                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Bio",                  // Nom produit
                "-",                    // Marque
                "Kiwi",                 // Type de produit
                "Fruit",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "-",                    // Nom de contenant
                "-",                    // Type de contenant (matière)
                0,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                0,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                0,                      // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...) 0 si à vendu à la pièce
                "",                     // Unité
                1,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Carton",                 // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                6,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                0,                      // Poids
                
                "12-12-2025",           // Date
                499                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Céréales méditéranéennes",                    // Nom produit
                "Tipiak",                    // Marque
                "Céréales",               // Type de produit
                "Légumes secs",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "Boîte",                    // Nom de contenant
                "Carton",                    // Type de contenant (matière)
                1,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet) 0 si pas dénombrable
                400,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                400,                    // Poids
                
                "12-12-2025",           // Date
                210                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Basilic",                    // Nom produit
                "Mutti",                    // Marque
                "Sauce tomate",               // Type de produit
                "Condiment",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "Boîte",                    // Nom de contenant
                "Carton",                    // Type de contenant (matière)
                1,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet) 0 si pas dénombrable
                400,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                400,                    // Poids
                
                "12-12-2025",           // Date
                248                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Tomate de Marmande et Basilic",                    // Nom produit
                "Georgelin",                    // Marque
                "Sauce tomate",               // Type de produit
                "Condiment",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "Boîte",                    // Nom de contenant
                "Carton",                    // Type de contenant (matière)
                1,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet) 0 si pas dénombrable
                300,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                300,                    // Poids
                
                "12-12-2025",           // Date
                270                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Crunchy avoine et chocolat noir",                    // Nom produit
                "Nature valley",                    // Marque
                "Barree de céréales",               // Type de produit
                "Friandise",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "Boîte",                    // Nom de contenant
                "Carton",                    // Type de contenant (matière)
                1,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet) 0 si pas dénombrable
                210,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                210,                    // Poids
                
                "12-12-2025",           // Date
                281                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
         
         
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Céréales méditéranéennes",                    // Nom produit
                "Tipiak",                    // Marque
                "Céréales",               // Type de produit
                "Légumes secs",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "Boîte",                    // Nom de contenant
                "Carton",                    // Type de contenant (matière)
                1,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet) 0 si pas dénombrable
                400,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                400,                    // Poids
                
                "11-12-2025",           // Date
                525                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Muesli crisp au chocolat noir",                    // Nom produit
                "Chabrior",                    // Marque
                "Céréales",               // Type de produit
                "Petit déjeuner",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "Boîte",                    // Nom de contenant
                "Carton",                    // Type de contenant (matière)
                1,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                500,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                500,                    // Poids
                
                "12-12-2025",           // Date
                244                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
         
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Corn flakes bio","Chabrior","Céréales","Petit déjeuner","Alimentation",
                "Boîte","Carton",1,375,1000,"g",0,"Unité",1,
                375,
                "13-12-2025",
                270
                ,"");
        $this->affiche_crdu_ajout($achat) ;
         
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Bio",                    // Nom produit
                "Ivoria",                    // Marque
                "Pâte à tartiner",               // Type de produit
                "Petit déjeuner",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "Bocal",                    // Nom de contenant
                "Verre",                    // Type de contenant (matière)
                1,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                350,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                350,                    // Poids
                
                "14-12-2025",           // Date
                270                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
         
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Croquant","Daucy","Maïs","Légume en conserve","Alimentation",
                "Boîte","Métal",1,150,1000,"g",0,
                "Boîte",3,
                450,
                "31-12-2025",           // Date
                240                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
         
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Bio",                    // Nom produit
                "Danone",                    // Marque
                "Petit suisse",               // Type de produit
                "Laitage",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "Pot",                    // Nom de contenant
                "Plastique",                    // Type de contenant (matière)
                6,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                60,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Boîte",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                6,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                360,                    // Poids
                
                "12-12-2025",           // Date
                177                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                // Commerce
                "G20","Beynes","78650","Centre commercial l Estandard",                     
                // Produit
                "Fumée",                    // Nom produit
                "-",                    // Marque
                "Poitrine",               // Type de produit
                "Boucherie",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "-",                    // Nom de contenant
                "-",                    // Type de contenant (matière)
                0,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                0,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                1000,                    // Poids
                
                "06-12-2025",           // Date
                1599                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "Biologique demi écrémé","Paturage","Lait","Laitage","Alimentation",
                "Bouteille","Plastique",1,1,1,"l",0,
                "Pack",6,
                6,
                "05-12-2025",
                654
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Frite",                    // Nom produit
                "Mon marché plaisir",                    // Marque
                "Pomme de terre",               // Type de produit
                "Légume",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "Filet",                    // Nom de contenant
                "-",                    // Type de contenant (matière)
                1,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                2500,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                2500,                    // Poids
                
                "05-12-2025",           // Date
                399                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Raisin","Paquito","Jus de fruit","Boisson","Alimentation",         // Domaine
                "Bouteille","Plastique",1,1000,1000,"ml",0,
                "Unité",1,
                1000,
                "31-12-2025",
                158                     
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Banane","Paquito","Nectar","Boisson","Alimentation",         // Domaine
                "Bouteille","Plastique",1,1000,1000,"ml",0,
                "Unité",1,
                1000,
                "31-12-2025",
                212                     
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Délices d agrumes","Pulco","Sirop","Boisson","Alimentation",         // Domaine
                "Bouteille","Verre",1,700,1000,"ml",0,
                "Unité",1,
                700,
                "31-12-2025",
                293                     
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Nocciolata",                    // Nom produit
                "Rigoni d Asiago",                    // Marque
                "Pâte à tartiner",               // Type de produit
                "Petit déjeuner",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "Bocal",                    // Nom de contenant
                "Verre",                    // Type de contenant (matière)
                1,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                700,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "ml",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                700,                    // Poids
                
                "05-12-2025",           // Date
                830                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Grenadine",                    // Nom produit
                "Paquito",                    // Marque
                "Sirop",               // Type de produit
                "Boisson",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "Bouteille",                    // Nom de contenant
                "Verre",                    // Type de contenant (matière)
                1,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                500,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "ml",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                500,                    // Poids
                
                "05-12-2025",           // Date
                255                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                // Produit
                "Noisette et chocolat blanc",                    // Nom produit
                "Georgelin",                    // Marque
                "Pâte à tartiner",               // Type de produit
                "Petit déjeuner",                // Famille
                "Alimentation",         // Domaine
                // Contenant
                "Bocal",                    // Nom de contenant
                "Verre",                    // Type de contenant (matière)
                1,                      // Quantité d'éléments si dénombrables (ex : nb biscuits dans un paquet)
                400,                      // Capacité du contenant (volume ou poids, selon). 0 si à vendu à la pièce
                1000,                   // Capacité de référence pour calculer le prix à la capacité (Au litre, au kilo, ...)
                "g",                    // Unité
                0,                      // Vendu au poids (0) ou à la pièce (1)
                // Regroupement (lot, pack, ...)
                "Unité",                // Type de regroupement ("Unité" : Si pas de regroupement, vendu à l'unité)
                1,                       // Quantité de produits regroupés (1 si vendu à l'unité)
                
                400,                    // Poids
                
                "05-12-2025",           // Date
                459                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde", 
                "Terrine","Pédigrée","Pâtée","Alimentation","Animalerie",
                "Boîte","Métal",1,400,1000,"g",0,
                "Carton",6,
                2400,
                "05-12-2025",
                934,
                "");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Les cuisinés en sauce","Pédigrée","Pâtée","Alimentation","Animalerie",
                "Boîte","Métal",1,400,1000,"g",0,
                "Carton",6,
                2400,
                "05-12-2025",
                953,
                "");
        $this->affiche_crdu_ajout($achat) ;
                        
        $achat->set("G20","Beynes","78650","Centre commercial l Estandard",
                "-","-","Banane","Fruit","Alimentation",
                "-","-",0,0,1000,"g",0,
                "Unité",1,
                1000,                    // Poids
                "17-12-2025",           // Date
                229                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("G20","Beynes","78650","Centre commercial l Estandard",
                "Chocolat noir","Danette","Crème","Déssert","Alimentation",
                "Pot","Plastique",4,125,1000,"g",0,
                "Unité",1,
                1000,                    // Poids
                "17-12-2025",           // Date
                172                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "G20","Beynes","78650","Centre commercial l Estandard",
                "Vanille","Danette","Crème","Déssert","Alimentation",
                "Pot","Plastique",4,125,1000,"g",0,
                "Unité",1,
                1000,                    // Poids
                "17-12-2025",           // Date
                159                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "vanille","Danette","Crème","Déssert","Alimentation",
                "Pot","Plastique",4,125,1000,"g",0,
                "Unité",1,
                1000,                    // Poids
                "28-11-2025",           // Date
                153                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Chocolat noir","Danette","Crème","Déssert","Alimentation",
                "Pot","Plastique",4,125,1000,"g",0,
                "Unité",1,
                1000,                    // Poids
                "28-11-2025",           // Date
                165                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Yaos nature","Nestlé","Yaourt","Laitage","Alimentation",
                "Pot","Plastique",4,150,1000,"g",0,
                "Unité",1,
                1000,                    // Poids
                "28-11-2025",           // Date
                165                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "-","-","Pomelo","Fruit","Alimentation",
                "-","Unité",0,0,0,"-",1,
                "Unité",1,
                0,                    // Poids
                "28-11-2025",           // Date
                99                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Pur jus de raisin blanc","Itinéraire des saveurs","Jus de fruit","Boisson","Alimentation",
                "Bouteille","Verre", // contenant
                1,750,1000,"ml",0,
                "Unité",1,                  // Regroupemennt
                750,                    // Poids
                "28-11-2025",           // Date
                318                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Bio","Pressade","Nectar multifruits","Boisson","Alimentation",
                "Brique","Plastique",1,1500,1000,"ml",0,
                "Unité",1,                  // Regroupemennt
                1500,                    // Poids
                "31-12-2025",           // Date
                229                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "-","-","Banane","Fruit","Alimentation", // Produit
                "-","-",0,0,1000,"g",0,   // Mode de conditionnement
                "Unité",1,                  // Regroupemennt
                1000,                    // Poids
                "28-11-2025",           // Date
                199                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Bio","-","Kiwi","Fruit","Alimentation",
                "-","-",0,0,0,"-",1,
                "Boîte",6,
                0,                    // Poids
                "28-11-2025",           // Date
                499                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Bio","Paturage","Fromage blanc","Laitage","Alimentation",
                "Pot","Plastique",8,100,1000,"g",0, 
                "Unité",1,
                800,                    
                "28-11-2025",           
                323                     
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Bio","Paturage","Fromage blanc","Laitage","Alimentation",
                "Pot","Plastique",8,100,1000,"g",0, 
                "Unité",1,
                800,                    
                "31-12-2025",           
                325                     
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Moulé doux","Paturage","Beurre","Laitage","Alimentation",
                "Emballage","papier",1,500,1000,"g",0, 
                "Unité",1,
                500,                    
                "31-12-2025",           
                524                     
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "Biologique demi écrémé","Paturage","Lait","Laitage","Alimentation",
                "Bouteille","Plastique",1,1,1,"l",0,
                "Pack",6,
                6,
                "31-12-2025",
                654
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "Biscoff The original speculoos Family format","Lotus","Spéculoos","Biscuit","Alimentation",
                "Paquet","Papier",1,750,1000,"g",0,
                "Unité",1,
                750,
                "31-12-2025",
                444
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "Noir extra","Côte d Or","Tablette","Chocolat","Alimentation",
                "Emballage","Papier",1,200,1000,"g",0,
                "Unité",1,
                200,
                "31-12-2025",
                293
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "Lait extra","Côte d Or","Tablette","Chocolat","Alimentation",
                "Emballage","Papier",1,200,1000,"g",0,
                "Unité",1,
                200,
                "31-12-2025",
                289
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "Bio","Chabrior","Blanche","Farine","Alimentation",
                "Paquet","Papier",1,1000,1000,"g",0,
                "Unité",1,
                1000,
                "31-12-2025",
                100
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "Biologique demi écrémé","Paturage","Lait","Laitage","Alimentation","Bouteille",                    // Nom de contenant
                "Plastique",1,1,1,"l",0,
                "Pack",6,
                6,
                "05-01-2026",
                654                     
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "Navel","-","Orange","Fruit","Alimentation",
                "-","-",0,0,1000,"g",0,
                "Unité",1,
                1000,
                "05-01-2026",
                299
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "-","-","Poireau","Légume","Alimentation",
                "-","-",0,0,1000,"g",0,
                "Unité",1,
                1000,
                "05-01-2026",
                229
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "Granny","-","Pomme","Fruit","Alimentation",
                "-","-",0,0,1000,"g",0,
                "Unité",1,
                1000,
                "05-01-2026",
                339
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "-","-","Banane","Fruit","Alimentation",
                "-","-",0,0,1000,"g",0,
                "Unité",1,
                1000,
                "05-01-2026",
                209
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "Jaune","-","Kiwi","Fruit","Alimentation",
                "-","-",0,0,0,"-",1,
                "Unité",1,
                0,
                "05-01-2026",
                65
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "Vert","-","Kiwi","Fruit","Alimentation",
                "-","-",0,0,0,"-",1,
                "Boîte",6,
                0,
                "05-01-2026",
                399
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Bio","Pressade","Nectar multifruits","Boisson","Alimentation",
                "Brique","Carton",1,1500,1000,"ml",0,
                "Unité",1,
                1500,
                "05-01-2026",
                229
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Bio","Pressade","Nectar de pomme","Boisson","Alimentation",
                "Brique","Carton",1,1500,1000,"ml",0,
                "Unité",1,                  // Regroupemennt
                1500,                    // Poids
                "05-01-2026",
                240                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "-","Paquito","Jus d ananas","Boisson","Alimentation",
                "Bouteille","Plastique",1,1000,1000,"ml",0,
                "Unité",1,                  // Regroupemennt
                1000,                    // Poids
                "05-01-2026",
                212                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "-","Paquito","Jus de raisin","Boisson","Alimentation",
                "Brique","Plastique",1,0,1000,"ml",0,
                "Unité",1,                  // Regroupemennt
                1000,                    // Poids
                "05-01-2026",
                158                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Délices d agrumes","Pulco","Sirop","Boisson","Alimentation",         // Domaine
                "Bouteille","Verre",1,700,1000,"ml",0,
                "Unité",1,
                700,
                "05-01-2026",
                293                     
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Bio","Bouton d or","Olive","Huile","Alimentation",         // Domaine
                "Bouteille","Verre",1,750,1000,"ml",0,
                "Unité",1,
                750,
                "05-01-2026",
                841                     
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Bio","Bouton d or","Balsamique","Vinaigre","Alimentation",         // Domaine
                "Bouteille","Verre",1,500,1000,"ml",0,
                "Unité",1,
                500,
                "05-01-2026",
                372                     
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Basilic","Barilla","Tomate","Sauce","Alimentation",
                "Bocal","Verre",1,400,1000,"g",0,
                "Unité",1,
                400,
                "05-01-2026",
                180
                ,"");
        $this->affiche_crdu_ajout($achat) ;
         
        $achat->set(
                // Commerce
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Céréales méditéranéennes","Tipiak","Céréales","Légumes secs","Alimentation",
                "Boîte","Carton",1,400,1000,"g",0,
                "Unité",1,
                400,
                "23-01-2026",
                210,
                "");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Bio","Pressade","Nectar multifruits","Boisson","Alimentation",
                "Brique","Carton",1,1500,1000,"ml",0,
                "Unité",1,                  // Regroupemennt
                1500,                    // Poids
                "23-01-2026",           // Date
                240,
                "");
        
        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Chocolat noir","Danette","Crème","Déssert","Alimentation",
                "Pot","Plastique",4,125,1000,"g",0,
                "Unité",1,
                500,                    // Poids
                "23-01-2026",           // Date
                165,
                "");
        $this->affiche_crdu_ajout($achat) ;

        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "-","-","Mandarine","Fruit","Alimentation",
                "-","-",0,0,1000,"g",0,
                "Unité",1,
                1000,
                "23-01-2026",
                168,
                ""
                );
        $this->affiche_crdu_ajout($achat) ;

        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Bio","Paturage","Fromage blanc","Laitage","Alimentation",
                "Pot","Plastique",8,100,1000,"g",0, 
                "Unité",1,
                800,                    
                "23-01-2026",           
                336                     
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde", 
                "Terrine","Pédigrée","Pâtée","Alimentation","Animalerie",
                "Boîte","Métal",1,400,1000,"g",0,
                "Carton",6,
                2400,
                "18-01-2026",
                956,
                "");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde", 
                "Cuisinés en sauce","Pédigrée","Pâtée","Alimentation","Animalerie",
                "Boîte","Métal",1,400,1000,"g",0,
                "Carton",6,
                2400,
                "18-01-2026",
                1099,
                "");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde", 
                "Terrine","Pédigrée","Pâtée","Alimentation","Animalerie",
                "Boîte","Métal",1,400,1000,"g",0,
                "Carton",6,
                2400,
                "24-01-2026",
                953,
                "");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde", 
                "Cuisinés en sauce","Pédigrée","Pâtée","Alimentation","Animalerie",
                "Boîte","Métal",1,400,1000,"g",0,
                "Carton",6,
                2400,
                "24-01-2026",
                1089,
                "");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde", 
                "Terrine","Pédigrée","Pâtée","Alimentation","Animalerie",
                "Boîte","Métal",1,400,1000,"g",0,
                "Carton",6,
                2400,
                "31-01-2026",
                953,
                "");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde", 
                "Cuisinés en sauce","Pédigrée","Pâtée","Alimentation","Animalerie",
                "Boîte","Métal",1,400,1000,"g",0,
                "Carton",6,
                2400,
                "31-01-2026",
                1089,
                "");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set(
                "Intermarché","Jouars Pontchartrain","78760","La Bonde",                     
                "-","-","Mandarine","Fruit","Alimentation",
                "-","-",0,0,1000,"g",0,
                "Unité",1,
                1000,
                "30-01-2026",
                168,
                ""
                );
        $this->affiche_crdu_ajout($achat) ;

        $achat->set("Intermarché","Jouars Pontchartrain","78760","La Bonde",
                "Bio","Paturage","Fromage blanc","Laitage","Alimentation",
                "Pot","Plastique",8,100,1000,"g",0, 
                "Unité",1,
                800,                    
                "30-01-2026",           
                336                     
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        
}

        
    
    private function chargement_table_Achat_Voiture() {

        
        $this->chargement_table_Achat_Voiture_Peage();
        
        $this->chargement_table_Achat_Voiture_Carburant();
    }
    
    private function chargement_table_Achat_Voiture_Carburant() {
        global $DOT;
        $achat = $DOT->getObjet("Achat");

        $achat->set("Auchan","Plaisir","78370","Grand Plaisir",
                "SP95 E10","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "10-12-2025",           // Date
                164                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Auchan","Plaisir","78370","Grand Plaisir",
                "SP95 E10","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "10-12-2025",           // Date
                164                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Total Energie","Jouars Pontchartrain","78760","Relais",
                "SP95 E10","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "28-11-2025",           // Date
                169                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Total Energie","Jouars Pontchartrain","78760","Relais",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "06-11-2025",           // Date
                179                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Total Energie","Jouars Pontchartrain","78760","Relais",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "24-10-2025",           // Date
                177                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("G20","Thoiry","78770","-",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "19-10-2025",           // Date
                177                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Total Energie","Jouars Pontchartrain","78760","Relais",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "17-10-2025",           // Date
                177                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Auchan","Plaisir","78370","Ebisoires",
                "SP95 E10","","Essence","Carburant","Voiture","-",
                "-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "10-10-2025",           // Date
                175                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Total Energie","Jouars Pontchartrain","78760","Relais",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "26-09-2025",           // Date
                178                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Carrefour","Verdun","55100","-",
                "SP95 E10","Carrefour","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "24-09-2025",           // Date
                166                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Total Energie","Jouars Pontchartrain","78760","Relais",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "12-09-2025",           // Date
                177                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Total Energie","Jouars Pontchartrain","78760","Relais",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "29-08-2025",           // Date
                177                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("DATS","Vigneulles les Hattonchatel","55210","Colruyt",
                "-","","Gasoil","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "16-08-2025",           // Date
                158                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Auchan","Plaisir","78370","Ebisoires",
                "-","","Gasoil","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "08-08-2025",           // Date
                160                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Auchan","Plaisir","78370","Ebisoires",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "01-08-2025",           // Date
                173                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Total Energie","Jouars Pontchartrain","78760","Relais",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "11-07-2025",           // Date
                178                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Total Energie","Jouars Pontchartrain","78760","Relais",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "04-07-2025",           // Date
                177                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Total Energie","Jouars Pontchartrain","78760","Relais",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "27-06-2025",           // Date
                179                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Maulette","78550","-",
                "SP98","Intermarché","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "18-06-2025",           // Date
                194                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Total Energie","Jouars Pontchartrain","78760","Relais",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "23-05-2025",           // Date
                176                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Leclerc","Bois d Arcy","78390","-",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "11-05-2025",           // Date
                170                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Leclerc","Bois d Arcy","78390","-",
                "SP95 E10","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "04-05-2025",           // Date
                163                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Intermarché","Digoin","71160","-",
                "Gasoil","Intermarché","Gasoil","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "27-12-2025",           // Date
                153                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;

        $achat->set("Total Energie","Jouars Pontchartrain","78760","Relais",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "02-01-2026",           // Date
                173                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Leclerc","Bois d Arcy","78390","-",
                "SP95 E10","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "04-01-2026",           // Date
                167                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Leclerc","Bois d Arcy","78390","-",
                "SP95 E10","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "04-01-2026",           // Date
                167                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Total Energie","Jouars Pontchartrain","78760","Relais",
                "SP98","","Essence","Carburant","Voiture",
                "-","-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "12-01-2026",           // Date
                178                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("Auchan","Plaisir","78370","Ebisoires",
                "SP98","","Essence","Carburant","Voiture","-",
                "-",0,0,1,"l",0,"Unité",1,
                1,                    // Poids
                "25-01-2026",           // Date
                175                     // Prix
                ,"");
        $this->affiche_crdu_ajout($achat) ;
        
    }
    
    private function chargement_table_Achat_Voiture_Peage() {
        
        global $DOT;
        $achat = $DOT->getObjet("Achat");
        
        $achat->set("SANEF","-","-","-","Saint Mihiel -> Paris","A13","Autoroute","Péage","Voiture","-","-",0,0,1,"km",0,"Unité",1,2250,"11-10-2025",210,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("SANEF","-","-","-","Buchelay","A13","Autoroute","Péage","Voiture","-","-",0,0,1,"km",1,"Unité",1,0,"23-11-2025",300,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("ASF","-","-","-","Villefranche Limas -> Mâcon sud","A6","Autoroute","Péage","Voiture","-","-",0,0,1,"km",0,"Unité",1,412,"23-11-2025",590,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("ASF","-","-","-","Digoin -> Allainville","A79 A71 A10","Autoroute","Péage","Voiture","-","-",0,0,1,"km",0,"Unité",1,374,"23-11-2025",3640,"");
        $this->affiche_crdu_ajout($achat) ;
        
        $achat->set("ASF","-","-","-","Fleury en Bière -> Villefranche Limas","A6","Autoroute","Péage","Voiture","-","-",0,0,1,"km",0,"Unité",1,66,"20-11-2025",4090,"");
        $this->affiche_crdu_ajout($achat) ;
                
    }
    
    private function chargement_table_Achat_repetition_du_meme() {
        global $DOT;
        $achatRepete = $DOT->getObjet("Achat");

        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;

        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;

        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;

        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;

        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;

        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;

        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;

        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;

        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;

        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;
        $achatRepete->set("Intermarché","Jouars Pontchartrain","78760","La Bonde","Bio","Paturage","Fromage blanc","Laitage","Alimentation","Pot","Plastique",8,100,1000,"g",0,"-",0,800,"28-11-2025",323,"");
        $this->affiche_crdu_ajout($achatRepete) ;

        
    }
    
    private function chargement_table_Article() {
        global $DOT;
        $c = $DOT->getObjet("Article");
        $c->set(
                "Reblochon de Savoie","Pochat","Fromage","Laitage","Alimentation",
                "Emballage","Papier",1,0,1000,"g",1,"Unité",1,
                450
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "Biologique demi écrémé","Paturage","Lait","Laitage","Alimentation",
                "Bouteille","Plastique",1,100,100,"cl",1,"Pack",6,
                6
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "Frite","Mon marché Plaisir","Pomme de terre","Légume","Alimentation",
                "Filet","Plastique",1,0,1000,"g",1,"Unité",1,
                2500
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "Ptit Yop Vanille","Yoplait","Yaourt à boire","Laitage","Alimentation",
                "Bouteille","Plastique",1,180,1000,"g",1,"Pack",6,
                1080
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "-","Paquito","Ananas","Jus de fruit","Alimentation",
                "Bouteille","Plastique",1,1,1,"l",1,"Unité",1,
                1
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "Nocciolata","Rigoni di Asiago","Pâte à tartiner","Petit déjeuner","Alimentation",
                "Bocal","Verre",1,700,1000,"g",1,"Unité",1,
                700
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "Navel","-","Orange","Fruit","Alimentation",
                "-","-",0,0,1000,"g",0,"Unité",1,
                700
                );
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_Commerce() {
        global $DOT;
        $c = $DOT->getObjet("Commerce");
        $c->set("Intermarché","Jouars Pontchartrain","78760","La Bonde");
        $this->affiche_crdu_ajout($c) ;
        $c->set("G20","Beynes","78650","Centre commercial l Estandard");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Colruyt","Vigneules les Hattonchatel","55210","-");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Leclerc","Bois d Arcy","78390","-");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Leclerc","Querqueville","50460","-");
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_Conditionnement() {
        global $DOT;
        $c = $DOT->getObjet("Conditionnement");
        $c->set(
                "Emballage","Papier",1,0,1000,"g",1,
                "Unité",1
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "Bouteille","Plastique",1,100,100,"cl",1,
                "Pack",6
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "Bouteille","Plastique",1,180,1000,"g",1,
                "Pack",6
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "Filet","Plastique",1,0,1000,"g",1,
                "Unité",1
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "Bouteille","Plastique",1,1,1,"l",1,
                "Unité",1
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "Bocal","Verre",1,700,1000,"g",1,
                "Unité",1
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "-","-",1,0,1000,"g",0,
                "Unité",1
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "Paquet","Carton",1,300,1000,"g",0,
                "Unité",1
                );
        $this->affiche_crdu_ajout($c) ;
        $c->set(
                "Paquet","Carton",1,300,1000,"g",0,
                "Lot",3
                );
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_Contenant() {
        global $DOT;
        $c = $DOT->getObjet("Contenant");
        $c->set("Bouteille","Plastique",1,100,100,"cl",0);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Bouteille","Plastique",1,1,1,"l",0);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Emballage","Papier",1,0,1000,"g",0);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Filet","Plastique",1,0,1000,"g",0);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Bouteille","Plastique",1,100,100,"cl",0);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Bouteille","Plastique",1,180,1000,"g",0);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Bocal","Verre",1,700,1000,"g",0);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Paquet","Carton",1,300,1000,"g",0);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Paquet","Carton",15,20,1000,"g",0);
        $this->affiche_crdu_ajout($c) ;
        $c->set("-","-",1,0,0,"-",1);
        $this->affiche_crdu_ajout($c) ;
        $c->set("-","-",1,0,1000,"g",0);
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_Domaine() {
        global $DOT;
        $c = $DOT->getObjet("Domaine");
        $c->set("Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Animalerie");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Voiture");
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_Enseigne() {
        global $DOT;
        $c = $DOT->getObjet("Enseigne");
        $c->set("Auchan");
        $this->affiche_crdu_ajout($c) ;
        $c->set("G20");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Intermarché");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Les traditions de Beynes");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Les traditions de Villiers");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Leclerc");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Total Energies");
        $this->affiche_crdu_ajout($c) ;
       
    }
    
    private function chargement_table_Famille() {
        global $DOT;
        $c = $DOT->getObjet("Famille");
        $c->set("Fruit","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Légume","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Condiment","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Petit déjeuner","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Jus de fruit","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Sirop","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Laitage","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Carburant","Voiture");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Péage","Voiture");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Entretien","Voiture");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Nourriture","Animalerie");
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_Marque() {
        global $DOT;
        $c = $DOT->getObjet("Marque");
        $c->set("Paquito");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Chabrior");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Pulco");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Côte d Or");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Amora");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Whaou");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Pochat");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Georgelin");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Rigoni di Asiago");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Paturage");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Mon marché Plaisir");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Yoplait");
        $this->affiche_crdu_ajout($c) ;
        $c->set("-");
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_Personne() {
        global $DOT;
        $c = $DOT->getObjet("Personne");
        $c->set("Grandjean","Pascal","Sylverscal","2165sm78",1);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Grandjean","Véronique","Gisquette","Chérie",0);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Babylas","Blondeau Georges Jacques","Suspect","RAB",0);
        $this->affiche_crdu_ajout($c) ;
        
    }
    
    private function chargement_table_Produit() {
        global $DOT;
        $c = $DOT->getObjet("Produit");
        $c->set("Grappe","-","Tomate","Légume","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Navel","-","Orange","Fruit","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Noisette et chocolat blanc","Georgelin","Pâte à tartiner","Petit déjeuner","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Reblochon de Savoie","Pochat","Fromage","Laitage","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Biologique demi écrémé","Paturage","Lait","Laitage","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Frite","Mon marché Plaisir","Pomme de terre","Légume","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Ptit Yop Vanille","Yoplait","Yaourt à boire","Laitage","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Jus d ananas","Paquito","Jus d ananas","Jus de fruit","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Nocciolata","Rigoni di Asiago","Pâte à tartiner","Petit déjeuner","Alimentation");
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_Regroupement() {
        global $DOT;
        $c = $DOT->getObjet("Regroupement");
        $c->set("Pack",6);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Pack",12);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Lot",3);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Boîte",6);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Unité",1);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Paquet",24);
        $this->affiche_crdu_ajout($c) ;
        $c->set("Sachet",15);
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_TypeContenant() {
        global $DOT;
        $c = $DOT->getObjet("TypeContenant");
        $c->set("Plastique");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Métal");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Verre");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Carton");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Papier");
        $this->affiche_crdu_ajout($c) ;
        $c->set("-");
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_TypeProduit() {
        global $DOT;
        $c = $DOT->getObjet("TypeProduit");
        $c->set("Tomate","Légume","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Salade","Légume","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Concombre","Légume","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Pomme de terre","Légume","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Endive","Légume","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Fenouil","Légume","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Banane","Fruit","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Pomme","Fruit","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Raisin","Fruit","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Pamplemousse","Fruit","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Orange","Fruit","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Kiwi","Fruit","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Pâte à tartiner","Petit déjeuner","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Fromage","Laitage","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Lait","Laitage","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Yaourt à boire","Laitage","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Jus d ananas","Jus de fruit","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Sirop de grenadine","Sirop","Alimentation");
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_TypeRegroupement() {
        global $DOT;
        $c = $DOT->getObjet("TypeRegroupement");
        $c->set("Pack");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Carton");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Boîte");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Lot");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Unité");
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_Unite() {
        global $DOT;
        $c = $DOT->getObjet("Unite");
        $c->set("l");
        $this->affiche_crdu_ajout($c) ;
        $c->set("cl");
        $this->affiche_crdu_ajout($c) ;
        $c->set("ml");
        $this->affiche_crdu_ajout($c) ;
        $c->set("g");
        $this->affiche_crdu_ajout($c) ;
        $c->set("-");
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_VariableSysteme() {
        global $DOT;
        $c = $DOT->getObjet("VariableSysteme");
        $c->set("DOMAINE_FAVORI","0","Alimentation");
        $this->affiche_crdu_ajout($c) ;
        $c->set("DOMAINE_DERNIER","0","Alimentation");
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function chargement_table_Ville() {
        global $DOT;
        $c = $DOT->getObjet("Ville");
        $c->set("Argentan","61200");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Beynes","78650");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Bois d'Arcy","78390");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Bordeaux","33000");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Jouars Pontchartrain","78760");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Le Chesnay","78150");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Les Clayes sous Bois","78165");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Maulette","78550");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Maurepas","78310");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Plaisir","78370");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Thoiry","78770");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Verdun","55100");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Vigneulles les Hattonchatel","55210");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Villepreux","78450");
        $this->affiche_crdu_ajout($c) ;
        $c->set("Villiers Saint Frédéric","78640");
        $this->affiche_crdu_ajout($c) ;
    }
    
    private function affiche_crdu_ajout($objet_table) {
//        usleep(50);
        $this->compteur_achats_ajoutes++;
        $crdu = $objet_table->sauve();
        
        ?>
                <tr>
                    <th>Compte rendu ajout<br><?php echo $this->compteur_achats_ajoutes; ?></th><th><?php echo $objet_table->getLibelle(); ?></th>
                </tr>
                <tr>
                    <td>Erreur</td>
                    <td><?php echo $crdu->getEtatErreur(); ?></td>
                </tr>
                <?php
                    if ($crdu->isKo()) {
                        LIB_Util::log("Crdu = Ko");
                ?>
                <tr>
                    <th>Résumé</th>
                    <td><?php echo $crdu->getResume(); ?></td>
                </tr>
                <tr>
                    <th>Détail</th>
                    <td>
                        <?php 
                        foreach ($crdu->getDetail() as $ligne) {
                                echo $ligne."<br>"; 
                        }
                        ?>
                    </td>
                </tr>
                <?php
                    }
                ?>
        <?php
        
        $objet_table->setId(0);
        
    }
    
}

