<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_DonneesPourGraphique
 * 
 * Regroupe les données nécessaires pour les graphiques
 *
 * @author sylverscal
 */
class COU_DonneesPourGraphique {

    /**
     * Numéro du graphique
     * @var int
     */
    private $numero_graphique;
    
    /**
     * Achat
     * @var TBL_Achat
     */
    private $achat;
    
    /**
     * Achat
     * @var TBL_Achat_s
     */
    private $achat_s;
    
    /**
     * Article
     * @var TBL_Article
     */
    private $article;
    
    /**
     * Tableau des séries
     * @var array
     */
    private $tableau_series;
    
    /**
     * Date la plus ancienne
     * @var LIB_Datation
     */
    private $date_plus_ancienne;

    /**
     * Date la plus récente
     * @var LIB_Datation
     */
    private $date_plus_recente;
    
    /**
     * Montant mini
     * @var LIB_Montant
     */
    private $montant_mini;
    
    /**
     * Montant maxi
     * @var LIB_Montant
     */
    private $montant_maxi;
    
    


    /**
     * Liste des noms de graphiques
     * @var array
     */
    private $tableau_noms_graphiques;
    
    public function __construct($numero_graphique = 0,$id_achat = 0) {
        $this->numero_graphique = $numero_graphique;
        
        $this->chargeObjets($id_achat);
        
        $this->creeTableauNomsGraphiques();
        
        $this->calculeDonnees();
    }
    
    private function chargeObjets($id_achat) {
        global $DOT;

        $this->achat = $DOT->getObjet("Achat");
        $this->achat->setId($id_achat);
        $this->achat->charge();

        $this->achat_s = new TBL_Achat_s();
        
        $this->article = $this->achat_s->getArticleDeAchat($id_achat);
    }

    private function creeTableauNomsGraphiques() {
        $this->tableau_noms_graphiques = [];
        $this->tableau_noms_graphiques[] = "Pas de graphique";
        $this->tableau_noms_graphiques[] = "Evolution prix pour un article";
        $this->tableau_noms_graphiques[] = "Evolution prix pour un article pour chaque magasin";
    }
    
    public function getNomGraphique($numero) {
        if ($numero < 0 || $numero > count($this->tableau_noms_graphiques)) {
            return "Pas de graphique pour le numéro : $numero";
        }
        
        return $this->tableau_noms_graphiques[$numero];
    }
    
    public function afficheMenuGraphiques() {
        ?>
        <select id="SEL_ACH_GDA_GRAPHIQUE" class="w3-select w3-round w3-border w3-pale-yellow w3-border-brown w3-padding-small w3-hover-pale-blue w3-ripple">
            <?php
                    foreach ($this->tableau_noms_graphiques as $key => $value) {
                        ?>
                            <option class="w3-select w3-round w3-border w3-pale-yellow w3-border-brown w3-padding-small w3-hover-pale-blue w3-ripple" value="<?php echo $key; ?>"><?php echo $value;?></option>
                        <?php
                    }
            ?>
        </select>
        <?php
        
    }
    
    /**
     * Ajoute le point à une série
     * @param int $id_commerce
     * @param DGP_Point $point
     */
    private function ajouteALaSerie($id_commerce,$point) {
        // Si c'est le graphique 1 on met tous les poits dans la mpême série.
        if ($this->numero_graphique == 1) {
            $id_commerce = 0;
        }
        
        if (!isset($this->tableau_series[$id_commerce])) {
            $this->tableau_series[$id_commerce] = new DGP_Serie($id_commerce);
        }
        $this->tableau_series[$id_commerce]->ajoutePoint($point);
    }
    
    private function calculeDonnees() {
        $this->date_plus_ancienne = new LIB_Datation("01-01-2000");
        $this->date_plus_recente = new LIB_Datation("01-01-2000");
        
        $tab_achats = $this->achat_s->getMontantsAchatsPourArticle($this->article->getId());
        
        foreach ($tab_achats as $index => $achat) {
            $id_commerce = $achat["id_commerce"];
            $montant = new LIB_MontantBase($achat["montant"]);
            $datation = new LIB_Datation($achat["datation"]);
            $point = new DGP_Point($montant, $datation);
            $this->ajouteALaSerie($id_commerce, $point);
            
            if ($index == 0) {
                $this->date_plus_ancienne = clone($datation);
                $this->montant_mini = clone($montant);
                $this->montant_maxi = clone($montant);
            }
            // JENSUISLA calculer montant mini maxi
            $this->date_plus_recente = clone($datation);
        }
    }
    
    public function getTitreGraphique() {
        return $this->article->getLibelle();
    }
    
    public function getSousTitreGraphique() {
        return $this->getNomGraphique($this->numero_graphique);
    }
}

class DGP_Serie {
    
    /**
     * Titre de la séri
     * @var string
     */
    private $id_commerce;
    
    /**¨
     * ¨Tableau des pooints
     */
    private $tableau_points;
    
    /**
     * Construction de l'objet.
     * En paramètre, l'id du commerce.
     * Si une seule série, laisser l'id du commerce à 0
     * @param type $id_commerce
     */
    public function __construct($id_commerce = 0) {
        $this->id_commerce = $id_commerce;
        
        $this->tableau_points = [];
    }
    
    /**
     * Ajoute un point
     * @param DGP_Point $point
     */
    public function ajoutePoint($point) {
        $this->tableau_points[] = $point;
    }
    
}

class DGP_Point {
    /**
     * Valeur du point
     * @var LIB_Montant 
     */
    private $montant;
    /**
     * Date du point
     * @var LIB_Datation
     */
    private $datation;

    /**
     * 
     * @param LIB_Montant $montant
     * @param LIB_Datation $datation
     */
    public function __construct($montant,$datation) {
        $this->montant = $montant;
        $this->datation = $datation;
    }
}

class DGP_DonneesJpGraph {

    private $donnees_sources;
    
    private $date_plus_ancienne;
    private $date_plus_recente;
    
    public function __construct($donnees_sources) {
        $this->donnees_sources =$donnees_sources;
        
        $this->extraitsDates();
        
    }
    
    private function extraitsDates() {
//        $this->date_plus_ancienne = 
    }
}
