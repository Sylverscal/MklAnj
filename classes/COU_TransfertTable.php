<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_TransfertTable
 * 
 * Classe pour gérer le transfert d'une table de Achat à une table de Courses
 *
 * @author sylverscal
 */
class COU_TransfertTable {
    private $table_source;
    private $table_destination;
    
    public function __construct($table_source,$table_destination) {
        $this->table_source = $table_source;
        $this->table_destination = $table_destination;
    }
    
    public function affiche() {
        $style_cases_titres = "w3-padding w3-pale-blue w3-border w3-center";
        ?>
        <div class="w3-container">
            <div class='w3-container <?php echo $style_cases_titres; ?>'>
                <h2>Association des <?php echo ucfirst($this->table_source); ?>s de Achats aux <?php echo $this->table_destination; ?>s de Courses</h2>
            </div>
            <div class="w3-grid" style="grid-template-columns:1fr 1fr">
                <div class="<?php echo $style_cases_titres; ?>">
                        <h3>Liste des <?php echo ucfirst($this->table_source); ?>s à transférer</h3>
                </div>
                <div class="<?php echo $style_cases_titres; ?>">
                        <h3>Association d'un <?php echo ucfirst($this->table_source); ?> à un <?php echo $this->table_destination; ?></h3>
                </div>
                <div class="<?php echo $style_cases_titres; ?>">
                        <div id="DIV_CHOIX_MODE_AFFICHAGE class="w3-container w3-border">
                        
                            <h4>Affichage des <?php echo ucfirst($this->table_source); ?>s déjà associés</h4>
                            <p>
                                <input id="INP_RAD_MODE_AFF_NON" class="w3-radio INP_RAD_MODE_AFF" type="radio" name="INP_RAD_MODE_AFF" value="non" checked>
                                <label>Non</label>
                            </p>
                            <p>
                                <input id="INP_RAD_MODE_AFF_OUI" class="w3-radio INP_RAD_MODE_AFF" type="radio" name="INP_RAD_MODE_AFF" value="oui">
                                <label>Oui</label>
                            </p>
                        </div>
                        <div id="DIV_LISTE_SOURCES" class="w3-container" style="overflow-y: scroll; height:800px">
                        </div>
                </div>
                <div class="<?php echo $style_cases_titres; ?>">
                    <div id="DIV_SOURCE_CHOISI" class="w3-container">
                        <div id="DIV_SOURCE_CHOISI" class="w3-container">
                        </div>
                    </div>
                    <div id="DIV_FORMULAIRE_DESTINATION" class="w3-container"></div>
                    <div id="DIV_LISTE_ASSOCIATIONS_POSSIBLES" class="w3-container" style="overflow-y: scroll; height:600px"></div>
                </div>
                
            </div>
        </div>
        <?php
    }
    
    /**
     * Affiche le tableau des éléments de achats à transférer
     * @param bool $avec_deja_associes 
     * false : n'affiche que les éléments de achats pas encore associés à un élément de courses
     * true : affiche aussi les éléments de achats déjà associés à un élément de courses
     */
    public function afficheTableau($avec_deja_associes) {
        $nom_classe = sprintf("TT_Tables_%s", $this->table_source);
        $tms = new $nom_classe($this->table_source);
        $tms->charge($avec_deja_associes);
        $tms->affiche();
    }
    
    /**
     * Associe un élément de achats avec un élément de courses.
     * - Création de l'élmémént de courses avec les données saisies 
     *   ou maj si existe déjà
     * - Création du lien élément de achats -> élément de courses
     * @param type $table_destination
     * @param type $id_source
     * @param type $donnees
     */
    public function associeSourceADestination($id_source,$donnees) {
        if ($donnees == "rejeter") {
            $this->rejeteAssociation($id_source);
            return;
        } 
        
        if ($donnees == "init") {
            $this->initialiseAssociation($id_source);
            return;
        } 
        
        $element = $this->setTableDestination($this->table_destination, $donnees);

        $this->creeAssociation($id_source,$element);
    }
    
    private function setTableDestination($nom_table,$donnees) {
        global $DOT;
        
        $id = 0;
        
        $arguments = [];
        
        foreach ($donnees as $key => $value) {
            if ($key == 0) {
                $id = $value['value'];
            } else {
                $arguments[] = $value['value'];
            }
        }
        
        $o = $DOT->getObjet($nom_table);
        $o->set(...$arguments);
        $o->chargeId(true);
        
        return $o;
    }
    
    private function creeAssociation($id_source,$element_destination) {
        $json = $element_destination->getSerializeDonnees();
        $tm = new TT_TransfertTable($this->table_source,0,$id_source,$json);
        
        $tm->sauve();
    }
    
    private function rejeteAssociation($id_source) {
        $tm = new TT_TransfertTable($this->table_source,0,$id_source,"rejet");
        
        $tm->sauve();
    }
    
    private function initialiseAssociation($id_source) {
        $tm = new TT_TransfertTable($this->table_source,0,$id_source);
        
        $tm->supprime();
    }
    
    /**
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function affichePropositions($donnees) {
        global $DOT;
        
        $os = $DOT->getObjet_s($this->table_destination);
        $o = $DOT->getObjet($this->table_destination);
        
        $liste_ids = $os->getListeLignesFiltrees($donnees);
        
        ?>
        <table class="w3-table">
            <?php
                    foreach ($liste_ids as $id) {
                        $o->setId($id);
                        $o->charge();
                        ?>
                        <tr>
                            <td>
                                <p id="<?php echo $id; ?>" class="w3-container w3-green CHOIX_ASSOCIATION">
                                    <?php
                                    echo $o->getLibelle();
                                    ?>
                                </p>
                            </td>
                        </tr>
                        <?php
                    }
            ?>
        </table>
        <?php
    }
    
    /**
     * Calcule une proposition d'association d'un eltdest à un eltsour
     * @param int $id_source
     * @return array Proposition calculée
     * Sous forme d'un tableau de tablonnes avec les valeurs
     */
    public function calculeProposition($id_source) {
        $classe = sprintf("TT_Table_%s",$this->table_source);
        
        $o = new $classe($this->table_source,$id_source);
        
        $proposition =  $o->calculeProposition($this->table_destination);
        
        return $proposition;
    }
}

/**
 * Classe pour gérer les éléments de achats
 */
class TT_Tables {
    protected $table;
    private $liste;
    
    public function __construct($table) {
        $this->table = $table;
        $this->liste = [];
    }
    
    /**
     * Charge les éléments de achats
     * @param string $avec_deja_associes
     * = "non" : Seulement les éléments de achats pas encore associés à un élément de Courses
     * = "oui" : Tous les éléments de achats avec l'id du élément de Courses associé dans Courses. Ou 0 si pas associé
     * @global LIB_BDD $CXO_A
     */
    public function charge($avec_deja_associes = "non") {
        global $CXO_A;
        
        $requete = $this->getRequeteListe();
        
        $rlt = $CXO_A->executeRequete($requete);
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
                if ($avec_deja_associes == "non" && $value['c_id'] != null) {
                    continue;
                }
                $nom_classe = sprintf("TT_Table_%s",$this->table);
                $m = new $nom_classe($this->table,$value['a_id'],$value['nom'],$value['c_id'],$value['libelle']);
                $this->liste[] = $m;
            }
        } else {
            $rlt->affiche();
        }
        
    }
    
    public function affiche() {
        ?>
        <table class="w3-table">
        <?php
        foreach ($this->liste as $m) {
            $m->afficheLigneTableau();
        }
        ?>
        </table>
        <?php
    }
    
    public function getRequeteListe() {
        $tab = ['{table}' => $this->table , '{Table}' => ucfirst($this->table)]; 
        $requete = strtr("SELECT 
                        Achats.{table}.id{table} as a_id , 
                        Achats.{table}.{table} as nom , 
                        Achats.Transfert{Table}.id as c_id  , 
                        Achats.Transfert{Table}.libelle as libelle  
                    FROM Achats.{table}
                    left join Achats.Transfert{Table} on Achats.{table}.id{Table} = Achats.Transfert{Table}.id_source 
                    order by Achats.{table}.{table}", $tab);
        
        return $requete;
        
    }    
    
}

class TT_Tables_magasin extends TT_Tables {
    
}

class TT_Tables_article extends TT_Tables {
    public function getRequeteListe() {
        $tab = ['{table}' => $this->table , '{Table}' => ucfirst($this->table)]; 
        $requete = strtr("SELECT 
                        Achats.{table}.id{table} as a_id , 
                        Achats.{table}.{table} as nom , 
                        Achats.Transfert{Table}.id as c_id  , 
                        Achats.Transfert{Table}.libelle as libelle  
                    FROM Achats.{table}
                    left join Achats.Transfert{Table} on Achats.{table}.id{Table} = Achats.Transfert{Table}.id_source 
                    left join Domaine on Domaine.idDomaine = {Table}.idDomaine 
                    order by Achats.{table}.{table}", $tab);
        
        return $requete;
        
    }    
}

abstract class TT_Table {
    protected $a_id;
    protected $nom;
    protected $c_id;
    protected $libelle;
    protected $table;
    /**
     * Variable utilisées pour le calcul des propositions.
     * Placées là pour faciliter le fragmentation de la fonction de calcul en petits modules
     */
    protected $ds;  // Données source
    protected $dd;  // Données destination

    public function __construct($table,$a_id,$nom="",$c_id=0,$libelle="") {
        $this->table = $table;
        $this->a_id = $a_id;
        $this->nom = $nom;
        $this->c_id = $c_id == null ? 0 : $c_id;
        $this->libelle = $libelle == null ? "" : $libelle;
    }
    
    public function afficheLigneTableau() {
        $style = "White";
        
        if ($this->c_id != 0) {
            if ($this->libelle == "rejet" || $this->libelle == "a:0:{}") {
                $style = "w3-light-grey";
            } else {
                $style = "w3-pale-yellow";
                
            }
        }
        if ($this->c_id == 0) {
            $style = "w3-yellow";
        }
        
        ?>
        <tr>
            <td>
                <p id="<?php echo $this->a_id ?>" class="TD_LISTE_SOURCE <?php echo $style ?> ">
                    <?php echo $this->getLibelle(); ?>
                </p>
            </td>
        </tr>
        <?php
    }
    
    public function getLibelle() {
        return $this->nom;
    }
    
    /**
     * Calcul d'une proposition en fonction de l'id_source déjà enregistré
     * @global LIB_DistributeurObjetTable $DOT
     * @param type $table_destination
     */
    public function calculeProposition($table_destination) {
        global $DOT;
        
        $o = $DOT->getObjet($table_destination);
        
        $o->setVide();
        $o->sauve();
        
        $this->dd = $o->getDonnees();
        
        $this->calcul();
        
        $proposition = [];
        
        foreach ($this->dd as $key => $value) {
            $proposition[] = ['tablonne' => $key , 'valeur' => $value];
        }
        
        $o->supprimeIntelligemment();
        
        return $proposition;
    }
    
    public function calcul() {
    }

    /**
     * @global LIB_BDD $CXO_A
     */
    public function charge() {
        global $CXO_A;

        $tab = ['{table}' => $this->table , '{Table}' => ucfirst($this->table) , '{id}' => $this->a_id]; 
        $requete = strtr("SELECT {table}.id{Table} as a_id , {table}.{table} as nom , Transfert{Table}.id as c_id , Transfert{Table}.libelle as libelle FROM {table}
            left join Transfert{Table} on {table}.id{Table} = Transfert{Table}.id_source where {table}.id{Table} = {id}",$tab);

        $rlt = $CXO_A->executeRequete($requete);
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
                $this->a_id = $value['a_id'];
                $this->nom = $value['nom'];
                $this->c_id = $value['c_id'] == null ? 0 : $value['c_id'];
                $this->libelle = $value['libelle'] ==  null ? "" : $value['libelle'];
            }
        } else {
            $rlt->affiche();
        }
    }
    
    public function afficheElementChoisi() {
        ?>
            <h4><?php echo ucfirst($this->table); ?> choisi</h4>
            <h3 id="NOM_SOURCE_CHOISI" class='w3-wide w3-blue'>
                <?php echo $this->getLibelle(); ?>
            </h3>
            <button id="BTN_CALCULE_PROPOSITION" class="w3-button w3-light-blue">Calcule proposition</button>
        <?php
    }
    
}

class TT_Table_magasin extends TT_Table {
    
}

class TT_Table_article extends TT_Table {
    public function getLibelle() {
        global $CXO_A;
        
        $requete = "SELECT 
            article.idArticle as id,
            article.article as article ,  
            domaine.domaine as domaine,
            typeArticle.typeArticle as typeArticle ,
            marque.marque as marque ,
            article.poids as poids
            FROM article
            join typeArticle on article.idTypeArticle = typeArticle.idTypeArticle
            join domaine on article.idDomaine = domaine.idDomaine
            join marque on article.idMarque = marque.idMarque
            where article.idArticle = $this->a_id";
        
        $rlt = $CXO_A->executeRequete($requete);
        
        $s = "?";
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
                $tab = [
                    '{article}' => $value['article'] ,
                    '{domaine}' => $value['domaine'] ,
                    '{marque}' => $value['marque'] ,
                    '{typeArticle}' => $value['typeArticle'] ,
                    '{poids}' => $value['poids'] 
                ];
                $s = strtr("{article} : {domaine} {typeArticle} {marque} {poids}",$tab);
            }
        } else {
            $rlt->affiche();
        }
        
        return $s;
    }

    #[\Override]
    /**
     * Calcul de proposition en analysant les données source pour renseigner les données destination
     */
    public function calcul() {
        $this->ds = $this->getDonnees($this->a_id);
        
        $this->ds['article'] = str_replace("'"," ", $this->ds['article']);
        $this->ds['domaine'] = str_replace("'"," ", $this->ds['domaine']);
        $this->ds['typeArticle'] = str_replace("'"," ", $this->ds['typeArticle']);
        $this->ds['marque'] = str_replace("'"," ", $this->ds['marque']);
        /**
         * Structure données source
        (
            [id] => 627
            [article] => A11 - Ablis Chartres
            [domaine] => Voiture
            [typeArticle] => Péage
            [marque] => -
            [poids] => 0
        )
         */

        /**
         * Structure donnees destination
        (
            [Produit_nom] => -
            [Marque_nom] => -
            [TypeProduit_nom] => -
            [Famille_nom] => -
            [Domaine_nom] => -
            [Contenant_nom] => -
            [TypeContenant_nom] => -
            [Contenant_quantite] => 0
            [Contenant_capacite] => 0
            [Contenant_capacite_reference] => 0
            [Unite_nom] => -
            [Contenant_is_a_la_piece] => 0
            [TypeRegroupement_nom] => -
            [Regroupement_quantite] => 0
            [Article_capacite] => 0
        )
         */
        
        LIB_Util::logPrintR($this->ds);
        LIB_Util::logPrintR($this->dd);
        
        if ($this->ds['domaine'] == "Alimentation") {
            $this->calculeAlimentation();
        }
        if ($this->ds['domaine'] == "Voiture") {
            $this->calculeVoiture();
        }
        
            $this->dd['Produit_nom'] = str_replace("'","",$this->dd['Produit_nom']);
            $this->dd['Marque_nom'] = str_replace("'","",$this->dd['Marque_nom']);
            $this->dd['TypeProduit_nom'] = str_replace("'"," ",$this->dd['TypeProduit_nom']);
            $this->dd['Famille_nom'] = str_replace("'","",$this->dd['Famille_nom']);
        
    }
    
    private function calculeVoiture() {
        
        if ($this->ds['typeArticle'] == "Péage") {
            $this->calculePeage();
        }
        if ($this->ds['typeArticle'] == "Carburant") {
            $this->calculeCarburant();
        }
        
    }
    
    /**
     * calcul proposition pour un péage d'autoroute
     */
    private function calculePeage() {
            $this->dd['Produit_nom'] = $this->ds['article'];
            $this->dd['Famille_nom'] = $this->ds['typeArticle'];
            $this->dd['TypeProduit_nom'] = 'Autoroute';
            $this->dd['Domaine_nom'] = $this->ds['domaine'];
            $tab = explode("-", $this->ds['article'], 2);
            if (count($tab) == 2) {
                $this->dd['Marque_nom'] = trim($tab[0]);
                $this->dd['Produit_nom'] = trim($tab[1]);
            } else {
                $this->dd['Produit_nom'] = $this->ds['article'];
            }
            $this->dd['Contenant_nom'] = '-';
            $this->dd['TypeContenant_nom'] = '-';
            $this->dd['Contenant_quantite'] = 0;
            $this->dd['Contenant_capacite'] = 0;
            $this->dd['Contenant_capacite_reference'] = 1;
            $this->dd['Unite_nom'] = 'km';
            $this->dd['Contenant_is_a_la_piece'] = 1;
            $this->dd['TypeRegroupement_nom'] = 'Unité';
            $this->dd['Regroupement_quantite'] = 1;
            $this->dd['Article_capacite'] = $this->ds['poids'];
    }
    
    private function calculeCarburant() {
        
            $tab = explode(" ", $this->ds['article'], 2);
            if (count($tab) == 2) {
                $this->dd['Produit_nom'] = $tab[1];
                $this->dd['TypeProduit_nom'] = $tab[0];
            } else {
                
                $this->dd['TypeProduit_nom'] = $this->ds['article'];
                $this->dd['Produit_nom'] = '-';
                if ($this->dd['TypeProduit_nom'] == 'Gasoil') {
                    $this->dd['Produit_nom'] = 'B7';
                }
                if ($this->dd['TypeProduit_nom'] == 'Essence') {
                    $this->dd['Produit_nom'] = 'E10';
                }
                
            }
        
            
            $this->dd['Marque_nom'] = $this->ds['marque'];
            $this->dd['Famille_nom'] = $this->ds['typeArticle'];
            $this->dd['Domaine_nom'] = $this->ds['domaine'];
            $this->dd['Contenant_nom'] = '-';
            $this->dd['TypeContenant_nom'] = '-';
            $this->dd['Contenant_quantite'] = 0;
            $this->dd['Contenant_capacite'] = 0;
            $this->dd['Contenant_capacite_reference'] = 1;
            $this->dd['Unite_nom'] = 'l';
            $this->dd['Contenant_is_a_la_piece'] = 0;
            $this->dd['TypeRegroupement_nom'] = 'Unité';
            $this->dd['Regroupement_quantite'] = 1;
            $this->dd['Article_capacite'] = $this->ds['poids'];
    }
    
    private function calculeAlimentation() {
            $this->dd['Produit_nom'] = $this->ds['article'];
            $this->dd['Marque_nom'] = $this->ds['marque'];
            $this->dd['TypeProduit_nom'] = $this->ds['typeArticle'];
            $this->dd['Famille_nom'] = '-';
            $this->dd['Domaine_nom'] = $this->ds['domaine'];
            $this->dd['Contenant_nom'] = '-';
            $this->dd['TypeContenant_nom'] = '-';
            $this->dd['Contenant_quantite'] = 1;
            $this->dd['Contenant_capacite'] = $this->ds['poids'];
            $this->dd['Contenant_capacite_reference'] = 1000;
            $this->dd['Unite_nom'] = 'g';
            $this->dd['Contenant_is_a_la_piece'] = 0;
            $this->dd['TypeRegroupement_nom'] = 'Unité';
            $this->dd['Regroupement_quantite'] = 1;
            $this->dd['Article_capacite'] = $this->ds['poids'];
            
            
            $this->corrigeFamille();
            
            $this->corrigePieceOuPoids();
            
            $this->corrigeContenantQuantites();
            
            $this->corrigeContenantMateriel();
            
            
            
            
    }
    
    /**
     * 
     * @global LIB_BDD $CXO
     */
    private function corrigeFamille() {
        global $CXO;
        
        $critere = $this->dd['TypeProduit_nom'];
        $requete = "SELECT  Famille.nom as Famille_nom
            FROM TypeProduit
            join Famille on Famille.id = TypeProduit.id_Famille
            where TypeProduit.nom = \"$critere\"";
        
        LIB_Util::log($requete);
        
        $rlt = $CXO->executeRequete($requete);
        
        $this->dd['Famille_nom'] = '-';
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
                LIB_Util::logPrintR($value);
                $this->dd['Famille_nom'] = $value['Famille_nom'];
            }
        } else {
            $rlt->affiche();
        }
        
    }
    
    private function corrigeContenantMateriel() {
        
        if ($this->dd['TypeProduit_nom'] == 'Pâtée pour chien') {
            $this->dd['TypeProduit_nom'] = "Pâtée";
            $this->dd['Famille_nom'] = "Nourriture chien";
            $this->dd['Domaine_nom'] = "Animalerie";
            $this->dd['Contenant_nom'] = "Boîte";
            $this->dd['TypeContenant_nom'] = "Métal";
        }
        if ($this->dd['TypeProduit_nom'] == 'Beurre') {
            $this->dd['Contenant_nom'] = "Emballage";
            $this->dd['TypeContenant_nom'] = "Papier";
        }
        if ($this->dd['TypeProduit_nom'] == 'Pineau') {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Verre";
            $this->dd['Famille_nom'] = "Apéritif";
        }
        if (preg_match("/^Sirop.*/i",$this->dd['TypeProduit_nom']) == 1) {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Verre";
            $this->dd['Famille_nom'] = "Boisson non alcoolisée";
        }
        if ($this->dd['TypeProduit_nom'] == "Jus tropical") {
            $this->dd['TypeProduit_nom'] = "Jus multifrtuit";
        }
        if (preg_match("/^Jus .*/i",$this->dd['TypeProduit_nom']) == 1) {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Verre";
            $this->dd['Famille_nom'] = "Jus de fruit";
            if ($this->dd['Marque_nom'] == "Paquito") {
                $this->dd['Contenant_nom'] = "Bouteille";
                $this->dd['TypeContenant_nom'] = "Plastique";
            }
            if ($this->dd['Marque_nom'] == "Pago") {
                $this->dd['Contenant_nom'] = "Bouteille";
                $this->dd['TypeContenant_nom'] = "Plastique";
            }
            if ($this->dd['Marque_nom'] == "Pressade") {
                $this->dd['Contenant_nom'] = "Brique";
                $this->dd['TypeContenant_nom'] = "Plastique";
            }
        }
        if ($this->dd['TypeProduit_nom'] == 'Cacao') {
            $this->dd['Contenant_nom'] = "Boîte";
            $this->dd['TypeContenant_nom'] = "Plastique";
        }
        if ($this->dd['TypeProduit_nom'] == 'Margarine') {
            $this->dd['Contenant_nom'] = "Boîte";
            $this->dd['TypeContenant_nom'] = "Plastique";
            $this->dd['Famille_nom'] = "Cuisine";
        }
        if ($this->dd['TypeProduit_nom'] == 'Biscuit') {
            $this->dd['Contenant_nom'] = "Paquet";
            $this->dd['TypeContenant_nom'] = "Papier";
        }
        if ($this->dd['TypeProduit_nom'] == 'Yaourt à boire') {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Plastique";
        }
        if ($this->dd['TypeProduit_nom'] == "Pain au lait") {
            $this->dd['Contenant_nom'] = "Sachet";
            $this->dd['TypeContenant_nom'] = "Plastique";
            $this->dd['Famille_nom'] = "Viennoiserie";
        }
        if ($this->dd['TypeProduit_nom'] == "Nectar de banane") {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Plastique";
            $this->dd['Famille_nom'] = "Boisson non alcoolisée";
        }
        if ($this->dd['TypeProduit_nom'] == "Nectar de poire") {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Plastique";
            $this->dd['Famille_nom'] = "Boisson non alcoolisée";
        }
        if ($this->dd['TypeProduit_nom'] == "Nectar de mangue") {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Plastique";
            $this->dd['Famille_nom'] = "Boisson non alcoolisée";
        }
        if ($this->dd['TypeProduit_nom'] == "Limonade") {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Plastique";
            $this->dd['Famille_nom'] = "Boisson non alcoolisée";
        }
        if ($this->dd['TypeProduit_nom'] == "Jus multifruits") {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Plastique";
            $this->dd['Famille_nom'] = "Boisson non alcoolisée";
            if ($this->dd['Marque_nom'] == "Pressade") {
                $this->dd['Contenant_nom'] = "Brique";
                $this->dd['TypeContenant_nom'] = "Carton";
            }
        }
        if ($this->dd['TypeProduit_nom'] == "Jus de pomme") {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Plastique";
            $this->dd['Famille_nom'] = "Boisson non alcoolisée";
            if ($this->dd['Marque_nom'] == "Pressade") {
                $this->dd['Contenant_nom'] = "Brique";
                $this->dd['TypeContenant_nom'] = "Carton";
            }
        }
        if ($this->dd['TypeProduit_nom'] == 'Pâte à tartiner') {
            $this->dd['Contenant_nom'] = "Bocal";
            $this->dd['TypeContenant_nom'] = "Verre";
        }
        if ($this->dd['Marque_nom'] == 'Coca Cola') {
            $this->dd['TypeProduit_nom'] = "Cola";
            $this->dd['Famille_nom'] = "Soda";
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Plastique";
            if ($this->dd['Contenant_capacite'] == 330)
            {
                $this->dd['Contenant_nom'] = "Canette";
                $this->dd['TypeContenant_nom'] = "Métal";
            }
            if ($this->dd['Contenant_capacite'] == 200)
            {
                $this->dd['Contenant_nom'] = "Bouteille";
                $this->dd['TypeContenant_nom'] = "Verre";
            }
        }
        if ($this->dd['TypeProduit_nom'] == 'Fromage') {
            $this->dd['Contenant_nom'] = "Emballage";
            $this->dd['TypeContenant_nom'] = "Papier";
        }
        if ($this->dd['TypeProduit_nom'] == 'Brioche') {
            $this->dd['Contenant_nom'] = "Emballage";
            $this->dd['TypeContenant_nom'] = "Plastique";
            $this->dd['Famille_nom'] = "Viennoiserie";
        }
        if ($this->dd['TypeProduit_nom'] == 'Gâche') {
            $this->dd['Contenant_nom'] = "Emballage";
            $this->dd['TypeContenant_nom'] = "Plastique";
            $this->dd['Famille_nom'] = "Viennoiserie";
        }
        if ($this->dd['TypeProduit_nom'] == 'Brownie') {
            $this->dd['Contenant_nom'] = "Boîte";
            $this->dd['TypeContenant_nom'] = "Carton";
        }
        if ($this->dd['Famille_nom'] == 'Légume en conserve') {
            $this->dd['Contenant_nom'] = "Boîte";
            $this->dd['TypeContenant_nom'] = "Métal";
        }
        if ($this->dd['TypeProduit_nom'] == 'Apéritif') {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Verre";
            $this->dd['Famille_nom'] = "Boisson alcoolisée";
        }
        if ($this->dd['TypeProduit_nom'] == 'Vin') {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Verre";
            $this->dd['Famille_nom'] = "Boisson alcoolisée";
        }
        if ($this->dd['TypeProduit_nom'] == 'Huile d olives') {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Verre";
        }
        if ($this->dd['TypeProduit_nom'] == 'Vinaigre balsamique') {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Verre";
        }
        if ($this->dd['TypeProduit_nom'] == 'Céréales') {
            $this->dd['Contenant_nom'] = "Boîte";
            $this->dd['TypeContenant_nom'] = "Carton";
            $this->dd['Famille_nom'] = "Féculent";
            if ($this->dd['Marque_nom'] == "Chabrior") {
                $this->dd['Famille_nom'] = "Petit déjeuner";
            }
        }
        if ($this->dd['TypeProduit_nom'] == 'Fruits en conserve') {
            $this->dd['Contenant_nom'] = "Boîte";
            $this->dd['TypeContenant_nom'] = "Métal";
        }
        if ($this->dd['Famille_nom'] == 'Charcuterie') {
            $this->dd['Contenant_nom'] = "Emballage";
            $this->dd['TypeContenant_nom'] = "Plastique";
        }
        if ($this->dd['TypeProduit_nom'] == 'Fromage blanc') {
            $this->dd['Contenant_nom'] = "Pot";
            $this->dd['TypeContenant_nom'] = "Plastique";
        }
        if ($this->dd['TypeProduit_nom'] == 'Moutarde') {
            $this->dd['Contenant_nom'] = "Bocal";
            $this->dd['TypeContenant_nom'] = "Verre";
            $this->dd['Famille_nom'] = "Assaisonnement";
        }
        if ($this->dd['TypeProduit_nom'] == 'Cordon bleu') {
            if ($this->dd['Contenant_is_a_la_piece'] == 0) {
                $this->dd['Contenant_nom'] = "Boîte";
                $this->dd['TypeContenant_nom'] = "Carton";
                $this->dd['Famille_nom'] = "Volaille";
            } else {
                $this->dd['Contenant_nom'] = "-";
                $this->dd['TypeContenant_nom'] = "-";
                $this->dd['Famille_nom'] = "Volaille";
            }
        }
        if ($this->dd['TypeProduit_nom'] == 'Mayonnaise') {
            $this->dd['Contenant_nom'] = "Bocal";
            $this->dd['TypeContenant_nom'] = "Verre";
            $this->dd['Famille_nom'] = "Assaisonnement";
        }
        if ($this->dd['TypeProduit_nom'] == 'Fromage de chèvre') {
            $this->dd['TypeProduit_nom'] = 'Chèvre';
            $this->dd['Contenant_nom'] = "Emballage";
            $this->dd['TypeContenant_nom'] = "Papier";
            $this->dd['Famille_nom'] = "Fromage";
        }
        if ($this->dd['TypeProduit_nom'] == 'Cornichon') {
            $this->dd['Contenant_nom'] = "Bocal";
            $this->dd['TypeContenant_nom'] = "Verre";
            $this->dd['Famille_nom'] = "Condiment";
        }
        if ($this->dd['TypeProduit_nom'] == 'Confiture') {
            $this->dd['Contenant_nom'] = "Bocal";
            $this->dd['TypeContenant_nom'] = "Verre";
            $this->dd['Famille_nom'] = "Petit déjeuner";
        }
        if ($this->dd['TypeProduit_nom'] == 'Lait') {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Plastique";
        }
        if ($this->dd['TypeProduit_nom'] == 'Compote') {
            $this->dd['Contenant_nom'] = "Bocal";
            $this->dd['TypeContenant_nom'] = "Verre";
        }
        if ($this->dd['TypeProduit_nom'] == 'Sirop d Agrumes') {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Verre";
        }
        if ($this->dd['TypeProduit_nom'] == 'Eau tranquille') {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Plastique";
            $this->dd['Famille_nom'] = "Boisson non alcoolisée";
        }
        if ($this->dd['TypeProduit_nom'] == 'Eau tumultueuse') {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Plastique";
            $this->dd['Famille_nom'] = "Boisson non alcoolisée";
        }
        if ($this->dd['TypeProduit_nom'] == 'Crêpe fourrée') {
            $this->dd['Contenant_nom'] = "Sachet";
            $this->dd['TypeContenant_nom'] = "Plastique";
        }
        if ($this->dd['TypeProduit_nom'] == 'Croûtons') {
            $this->dd['Contenant_nom'] = "Sachet";
            $this->dd['TypeContenant_nom'] = "Plastique";
        }
        if ($this->dd['TypeProduit_nom'] == 'Crème dessert') {
            $this->dd['Contenant_nom'] = "Pot";
            $this->dd['TypeContenant_nom'] = "Plastique";
        }
        if ($this->dd['TypeProduit_nom'] == 'Crème fraîche') {
            $this->dd['Contenant_nom'] = "Bocal";
            $this->dd['TypeContenant_nom'] = "Verre";
        }
        if ($this->dd['TypeProduit_nom'] == 'Sauce tomate') {
            $this->dd['Famille_nom'] = "Sauce";
            $this->dd['Contenant_nom'] = "Bocal";
            $this->dd['TypeContenant_nom'] = "Verre";
        }
        if ($this->dd['TypeProduit_nom'] == 'Tomate') {
            $this->dd['Famille_nom'] = "Légume";
            $this->dd['Contenant_nom'] = "-";
            $this->dd['TypeContenant_nom'] = "-";
        }
        if ($this->dd['TypeProduit_nom'] == 'Petit suisse') {
            $this->dd['Contenant_nom'] = "Pot";
            $this->dd['TypeContenant_nom'] = "Plastique";
        }
        if ($this->dd['TypeProduit_nom'] == 'Pâtes') {
            $this->dd['Contenant_nom'] = "Boîte";
            $this->dd['TypeContenant_nom'] = "Carton";
        }
        if ($this->dd['TypeProduit_nom'] == 'Camembert') {
            $this->dd['Contenant_nom'] = "Boîte";
            $this->dd['TypeContenant_nom'] = "Carton";
        }
        if ($this->dd['TypeProduit_nom'] == 'Biscotte') {
            $this->dd['Contenant_nom'] = "Boîte";
            $this->dd['TypeContenant_nom'] = "Carton";
        }
        if ($this->dd['TypeProduit_nom'] == 'Tablette de chocolat') {
            $this->dd['Contenant_nom'] = "Emballage";
            $this->dd['TypeContenant_nom'] = "Papier";
        }
        if ($this->dd['TypeProduit_nom'] == 'Crème anglaise') {
            $this->dd['Contenant_nom'] = "Brique";
            $this->dd['TypeContenant_nom'] = "Carton";
        }
        if ($this->dd['TypeProduit_nom'] == 'Yaourt') {
            $this->dd['Contenant_nom'] = "Pot";
            $this->dd['TypeContenant_nom'] = "Carton";
            if ($this->dd['Contenant_capacite'] > 250) {
                $this->dd['TypeContenant_nom'] = "Plastique";
            }
        }
        
        if ($this->dd['Famille_nom'] == 'Boisson') {
            $this->dd['Contenant_nom'] = "Bouteille";
            $this->dd['TypeContenant_nom'] = "Verre";
            if ($this->dd['TypeProduit_nom'] == 'Jus agrumes') {
                $this->dd['TypeContenant_nom'] = "Plastique";
            }
        }
    }
    
    private function corrigeContenantQuantites() {
        
        $tab = $this->dissequeNomProduit($this->dd['Produit_nom']);
                
        $this->dd['Produit_nom'] = $tab['nom'];
        $this->dd['Contenant_quantite'] = $tab['cont'];
        $this->dd['Regroupement_quantite'] = $tab['regr'];
        $this->dd['Contenant_capacite'] = intdiv($this->dd['Article_capacite'],$this->dd['Contenant_quantite']);
        $this->dd['Contenant_capacite'] = intdiv($this->dd['Contenant_capacite'],$this->dd['Regroupement_quantite']);
        
    }
    
    private function corrigePieceOuPoids() {
        if ($this->dd['Article_capacite'] == 0 ) {
            $this->dd['Contenant_is_a_la_piece'] = 1;
            $this->dd['Contenant_capacite_reference'] = 1;
        }
    }
    
    private function dissequeNomProduit($nom) {
        $tab = [];
        
        $nom_purge = $nom;
                
        if (preg_match("/(x\s*\d+)/",$nom_purge,$t) == 1){
            $s = $t[1];
            $nom_purge = str_replace($s, '', $nom_purge);
        }
        
        if (preg_match("/(\*\s*\d+)/",$nom_purge,$t) == 1){
            $s = $t[1];
            $nom_purge = str_replace($s, '', $nom_purge);
        }
        
        $tab["nom"] = $nom_purge;
        $tab["cont"] = 1;
        $tab["regr"] = 1;
        
        if (preg_match("/x\s*(\d+)/",$nom,$t) == 1){
            $tab["cont"] = $t[1];
        }
        
        if (preg_match("/\*\s*(\d+)/",$nom,$t) == 1){
            $tab["regr"] = $t[1];
        }
        
        return $tab;
    }
    /**
     * 
     * @global LIB_BDD $CXO_A
     * @param int $id
     * @return array
     */
    private function getDonnees($id) {
        global $CXO_A;
        
        $requete = $this->getRequeteArticle($id);

        $rlt = $CXO_A->executeRequete($requete);
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
            }
        } else {
            $rlt->affiche();
        }
                
        $tab = [];
        
        foreach ($value as $key => $value) {
            if (is_numeric($key)) {
                continue;
            }
            
            $tab[$key] = $value;
        }
                
        return $tab;
        
    }
    
    private function getRequeteArticle($id) {
        $requete = "SELECT 
article.idArticle as id , 
article.article as article , 
domaine.domaine as domaine , 
typeArticle.typeArticle as typeArticle , 
marque.marque as marque , 
article.poids as poids 
FROM article 
join typeArticle on article.idTypeArticle = typeArticle.idTypeArticle 
join domaine on article.idDomaine = domaine.idDomaine 
join marque on article.idMarque = marque.idMarque 
where 
(1 = 1) 
and article.idArticle = $id 
and domaine.domaine in ('Alimentation','Voiture','Animalerie')";
        
        return $requete;
    }
}

class TT_TransfertTable {
    private $table;
    private $id;
    private $id_source;
    private $libelle;
    
    public function __construct($table,$id=0,$id_source=0,$libelle="") {
        $this->table = $table;
        $this->init($id,$id_source,$libelle);
    }
    
    private function init($id=0,$id_source=0,$libelle="") {
        $this->id = $id;
        $this->id_source = $id_source;
        $this->libelle = $libelle;
    }
    
    /**
     * 
     * @global LIB_BDD $CXO_A
     * @param int $id_source
     */
    public function chargeParIdSource($id_source) {
        global $CXO_A;
        
        $tab = ['{Table}' => ucfirst($this->table) , '{id_source}' => $id_source]; 
        $requete = strtr("SELECT id,id_source,libelle FROM Transfert{Table} where id_source = {id_source}",$tab);
        
        $ret = $CXO_A->executeRequete($requete);
        
        $ret->afficheSiKo();
        
        foreach ($ret->getResultat() as $key => $value) {
            $this->init($value["id"], $value["id_source"], $value["libelle"]);
        }        
    }
    
    /**
     * Sauve l'obket
     * @global LIB_BDD $CXO_A
     */
    public function sauve() {
        global $CXO_A;
        
        if ($this->isExiste($this->id_source)) {
            $this->modifie();
            return;
        }
        
        LIB_Util::log("$this->id_source -> $this->libelle");
        
        $tab = ['{Table}' => ucfirst($this->table) , '{id_source}' => $this->id_source, '{libelle}' => $this->libelle]; 
        $requete = strtr("insert into Transfert{Table} (id_source,libelle) values ('{id_source}','{libelle}')",$tab);
        
        LIB_Util::log($requete);
        
        $rlt = $CXO_A->executeRequete($requete);
        $rlt->afficheSiKo();
    }
    
    /**
     * Sauve l'obket
     * @global LIB_BDD $CXO_A
     */
    public function supprime() {
        global $CXO_A;
        
        $tab = ['{Table}' => ucfirst($this->table) , '{id_source}' => $this->id_source]; 
        $requete = strtr("delete from Transfert{Table} where id_source = {id_source}",$tab);
        
        LIB_Util::log($requete);
        
        $rlt = $CXO_A->executeRequete($requete);
        $rlt->afficheSiKo();
    }
    
    public function modifie() {
        global $CXO_A;
        
        if (!$this->isExiste($this->id_source)) {
            return;
        }
        
        $tab = ['{Table}' => ucfirst($this->table) , '{id_source}' => $this->id_source, '{libelle}' => $this->libelle]; 
        $requete = strtr("update Transfert{Table} set libelle = '{libelle}' where id_source = {id_source}",$tab);
        
        $rlt = $CXO_A->executeRequete($requete);
        $rlt->afficheSiKo();
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getIdSource() {
        return $this->id_source;
    }
    
    public function getLibelle() {
        return $this->libelle;
    }
    
    public function isExiste($id_source) {
        $this->chargeParIdSource($id_source);
        
        return $this->getId() == 0 ? false : true; 
    }
}


