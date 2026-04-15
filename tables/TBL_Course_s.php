<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of TBL_Achats_s
 *
 * @author sylverscal
 */
class TBL_Course_s extends LIB_Table_s{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function afficheListe() {
        $this->charge();
        
        ?>
        <div class="w3-container" style="overflow-y: scroll; height:600px">
    
            <table id="TBL_LISTE_COURSES" class="w3-table-all w3-hoverable">
            <?php
                foreach ($this as $course) {
                    $course->affiche();
                }
            ?>
            </table>
        </div>
        <?php
    }
    /**
     * Charge la liste des fonctions de la table
     * @global LIB_BDD $CXO
     * @global LIB_DistributeurObjetTable $DOT
     */
//    public function chargePourDomaine($domaine) {
//        global $CXO;
//        global $DOT;
//        
//        $r = $CXO->executeRequete($this->getRequete($domaine));
//        if ($r->isOk()) {
//            foreach ($r->getResultat() as $ligne) {
//                $o = $DOT->getObjet("Achat");
//                $o->setId($ligne['id']);
//                $o->setDonneesPourAffichage($ligne);
//                $this->ajoute($o);
//            }
//        } else {
//            $r->affiche();
//        }
//        
//    }
    
    /**
     * Constitue la partie de requête where à partie du tableau de filtres
     */
    private function getPartieWhereDeFiltre() {
        $requete_where = "";
        
        foreach ($this->filtres as $filtre) {
            $colonne = LIB_Util::convertiTablonneEnSelect($filtre[0]);
            $valeur = $filtre[1];
            
            
            $s = sprintf(" and %s = '%s' ",$colonne,$valeur);
            $requete_where = sprintf("%s%s",$requete_where,$s);
        }
        
        return $requete_where;
    }
    
    public function setFiltre($filtres) {
        $this->filtres = $filtres;
    }
    
    public function afficheDonnees() {
        ?>
        <tbody>
            <?php
                foreach ($this as $value) {
                    $id = $value->getId();
                    $idTr = sprintf("%s",$id);
                ?>
                    <tr id="<?php echo $idTr; ?>">
                    <?php
                        $value->affiche();
                    ?>
                    </tr>
                <?php
                    }
                ?>
        </tbody>
        <?php
    }
    
    /**
     * Constitution de la requête
     * @param string $domaine
     * @return string
     */
    private function getRequete() {
        $where_de_filtre = $this->getPartieWhereDeFiltre();
        $requete = "select
	Achat.id as id, Achat.id_Article, Achat.id_Commerce,
	Enseigne.nom as Enseigne_nom,
	Ville.nom as Ville_nom,
        Ville.code_postal as Ville_code_postal,
        Commerce.localisation as Commerce_localisation,
            Produit.nom as Produit_nom,
        Marque.nom as Marque_nom,
        TypeProduit.nom as TypeProduit_nom,
        Famille.nom as Famille_nom,
        Domaine.nom as Domaine_nom,
        Contenant.nom as Contenant_nom,
        TypeContenant.nom as TypeContenant_nom,
        Contenant.quantite as Contenant_quantite,
        Contenant.capacite as Contenant_capacite,
        Contenant.capacite_reference as Contenant_capacite_reference,
        Unite.nom as Unite_nom,
        Contenant.is_a_la_piece as Contenant_is_a_la_piece,
        TypeRegroupement.nom as TypeRegroupement_nom,
        Regroupement.quantite as Regroupement_quantite,
        Article.capacite as Article_capacite,
        Achat.datation as Achat_datation,
        Achat.montant as Achat_montant
        from Course
        join Commerce on Commerce.id = Achat.id_Commerce
        join Enseigne on Enseigne.id = Commerce.id_Enseigne
        join Ville on Ville.id = Commerce.id_Ville
        join Article on Article.id = Achat.id_Article
        join Produit on Produit.id = Article.id_Produit
        join TypeProduit on TypeProduit.id = Produit.id_TypeProduit
        join Famille on Famille.id = TypeProduit.id_Famille
        join Domaine on Domaine.id = Famille.id_Domaine
        join Marque on Marque.id = Produit.id_Marque
        join Conditionnement on Conditionnement.id = Article.id_Conditionnement
        join Contenant on Contenant.id = Conditionnement.id_Contenant
        join TypeContenant on TypeContenant.id = Contenant.id_TypeContenant
        join Unite on Unite.id = Contenant.id_Unite
        join Regroupement on Regroupement.id = Conditionnement.id_Regroupement
        join TypeRegroupement on TypeRegroupement.id = Regroupement.id_TypeRegroupement
        where 
        1 = 1
        $where_de_filtre 
        order by Course.datation desc
        limit 500
        ";
        return $requete;
    }
    
    public function getItemsIndex($index) {
        global $CXO;
        
        $index_avec_point = LIB_Util::convertiTablonneEnSelect($index);
        
        $select = sprintf("%s as %s",$index_avec_point,$index);
        
        $filtre = "";
        
        $order = "order by $index_avec_point";
        
        $requete = $this->getRequeteParametrable($select, $filtre, $order);
        
        $items = [];
        $r = $CXO->executeRequete($requete);
        if ($r->isOk()) {
            foreach ($r->getResultat() as $ligne) {
                $valeur = 0;
                $libelle = $ligne[$index];

                $items[] = ["valeur" => $valeur , "libelle" => $libelle];
            }
        } else {
            $r->affiche();
        }
        
        return $items;
    }
    
    /**
     * Constitution de la requête
     * Recherche fonction de constitution de la requête paramétrable
     * @param string $domaine
     * @return string
     */
    private function getRequeteParametrable($select="",$filtre="",$order="") {
        if ($select == "") {
            $select = $this->getSelectTout();
        }
        
        if ($order == "") {
            $order = "order by Achat.datation desc ";
        }
        
        $requete = "select 
        distinct
	$select 
        from Course
        join Article on Article.id = Course.id_Article
        join Marque on Marque.id = Course.id_Marque
        join Commerce on Commerce.id = Course.id_Commerce
        join Ville on Ville.id = Course.id_Ville
        join Zone on Zone.id = Course.id_Zone
        where 
        1 = 1
        $filtre 
        $order 
        limit 500
        ";
        return $requete;
    }
    
    private function getSelectComplet() {
        $select = "";
        
        // JENSUISLA ECRIRE LE SELECT COMPLET
        
        return $select;
    }
    
    
    
}
