<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_Achats
 * 
 * Classe pour gérer les achats.
 *
 * @author sylverscal
 */
class COU_Achats {
    /**
     * Liste des achats
     * @var TBL_Achat_s
     */
    private $liste;
    
    public function __construct() {
        $this->liste = new TBL_Achat_s();
    }
    
    
    final function affiche() {
        ?>
        <div id="DIV_ACH_GDA" class="w3-container">
            <?php
//            $this->affichePosteDeCommande();
            ?>
        </div>
        <div id="DIV_ACH_ACHATS" class="w3-container" style="overflow-y: scroll; height:1200px">

        </div>
        <?php
    }
    
    public function affichePosteDeCommande() {
        ?>
            <div class="w3-panel w3-pale-blue">
                <table>
                    <tr>
                        <?php
                            $this->afficheMenuDomaine();
                        ?>
                        <?php
                            $this->afficheBoutonsGestionAchat();
                        ?>
                    </tr>
                </table>    
            </div>
            <div class="w3-panel w3-pale-blue">
                <table>
                    <tr>
                        <td><button id="BTN_ACH_FILTRE_RAZ" class="w3-button w3-amber w3-round w3-border w3-border-brown w3-padding-small">Raz</button></td>
                        <td id="TXT_ACH_FILTRE"></td>
                    </tr>
                </table>
            </div>
            <div class="w3-panel w3-pale-blue">
                <table>
                    <tr>
                        <td>
                            <p class='w3-tooltip'>
                                <button id="BTN_FILTRE_IDENTIQUES" class="w3-button w3-pale-yellow w3-round w3-border w3-border-brown w3-padding-small">
                                    <i class="material-icons">format_list_bulleted</i>
                                </button>
                                <span class='w3-text w3-tag w3-small'>Achats avec le même article que celui séléectionné</span>
                            </p>
                        </td>
                        <td>
                        <?php $this->afficheInputMenuFiltre("Enseigne","Enseigne_nom","Enseigne"); ?>
                        </td>
                        <td>
                        <?php $this->afficheInputMenuFiltre("Famille","Famille_nom","Famille"); ?>
                        </td>
                        <td>
                        <?php $this->afficheInputMenuFiltre("Type produit","TypeProduit_nom","TypeProduit"); ?>
                        </td>
                        <td>
                        <?php $this->afficheInputMenuFiltre("Marque","Marque_nom","Marque"); ?>
                        </td>
                        <td>
                        <?php $this->afficheInputMenuFiltre("Produit","Produit_nom","Produit"); ?>
                        </td>
                    </tr>
                </table>
            </div>
        <?php  
    }
    
    private function afficheBoutonsGestionAchat() {
        $style_boutons = "w3-round w3-border w3-pale-yellow w3-border-brown w3-padding-small w3-hover-pale-blue w3-ripple";
        ?>
        <td>
            <button id="BTN_ACH_GDA_DUPLIQUE" class="w3-button <?php echo $style_boutons; ?>">Duplique</button>
        </td>
        <td>
            <button id="BTN_ACH_GDA_CREE" class="w3-button <?php echo $style_boutons; ?>">Crée</button>
        </td>
        <td>
            <button id="BTN_ACH_GDA_MODIFIE" class="w3-button <?php echo $style_boutons; ?>">Modifie</button>
        </td>
        <td>
            <button id="BTN_ACH_GDA_SUPPRIME" class="w3-button <?php echo $style_boutons; ?>">Supprime</button>
        </td>
        <td>
                <?php
                $dpg = new COU_DonneesPourGraphique();
                $dpg->afficheMenuGraphiques();
                ?>
        </td>
        <?php
    }
    
    /**
     * Affiche un champ de saisie avec possibilité de choix d'item dans un menu
     * chargé d'une table.
     * @param string $titre Titre affiché dans le label
     * @param string $nom_donnee Valeur courante de l'input
     * @param string $nom_table Nom de la table qui va alimenter le menu des items
     * @global LIB_DistributeurObjetTable $DOT
     */
    private function afficheInputMenuFiltre($titre,$nom_donnee,$nom_table) {
        global $DOT;
        
        $vs = $DOT->getObjet("VariableSysteme");
        $nom_domaine = $vs->getDomaineDernier();
        
        $achat_s = new TBL_Achat_s();
        $items = $achat_s->getItemsPourIndexEtDomaine($nom_donnee,$nom_domaine);
        
        $style_labels = "w3-sand";
        $style_input_sel = "w3-pale-green w3-border";
        
        $id_input_sel = sprintf("%s@%s",$nom_donnee,$nom_table);
        
        $class_input_sel = "SEL_ACH_GDA_FILTRE";
                ?>
            <p>
                <?php if ($titre !== "") { ?>
                    <label class="<?php echo $style_labels; ?>"><?php echo $titre; ?></label>
                <?php } ?>
                <select class="<?php echo $class_input_sel; ?> w3-select w3-border <?php echo $style_input_sel; ?>">
                    <option value="-">-</option>
                    <?php 
                    foreach ($items as $item) {
                    ?>
                        <option value="<?php echo $id_input_sel ?>"><?php echo trim($item); ?></option>
                    <?php 
                    } 
                    ?>
                </select>
            </p>
        <?php
    }

    /**
     * Affiche le menu déroulant Domaine
     */
    private function afficheMenuDomaine() {
        $d = new TBL_Domaine_s();
        ?>
        <td>
            <?php
            $d->afficheMenu();
            ?>
        </td>
        <?php
    }
    
    /**
     * Enregistre dans les variables Système le domaine utilisé
     * @param int $id Id du Domaine
     * @return LIB_CompteRendu Compte rendu de l'opération
     */
    public function enregistreDomaineChoisi($id) : LIB_CompteRendu {
        $vs = new TBL_VariableSysteme();
        $crdu = $vs->setDomaineDernier($id);
        return $crdu;
    }
    
    /**
     * Affiche la liste des achats
     */
    public function afficheListeAchats() {
    ?>
        <table id="TBL_LISTE_ACHATS" class="w3-table-all w3-hoverable w3-tiny" width="100%" cellspacing="0">
        <?php
            $this->afficheEntete();
            $this->afficheDonnees();
        ?>
        </table>
    <?php
    }
    
    /**
     * Affiche la liste des achats filtree
     */
    public function afficheListeAchatsFiltree($filtre) {
    ?>
        <table id="TBL_LISTE_ACHATS" class="w3-table-all w3-hoverable w3-tiny" width="100%" cellspacing="0">
        <?php
            $this->afficheEntete();
            $this->afficheDonneesFiltrees($filtre);
        ?>
        </table>
    <?php
    }
    
    /**
     * Affiche la liste des achats ayant le même article.
     * @param int $id_achat Id de l'achat sélectionné.
     * Le but est d'afficher tous les achats faits pour le même article que celui de l'achat sélectionné
     */
    public function afficheListeAchatsMemeArticle($id_achat) {
    ?>
        <table id="TBL_LISTE_ACHATS" class="w3-table-all w3-hoverable w3-tiny" width="100%" cellspacing="0">
        <?php
            $this->afficheEntete();
            $this->afficheDonneesAchatsMemeArticle($id_achat);
        ?>
        </table>
    <?php
    }
    
    /**
     * Affiche la liste des données
     */
    private function afficheDonnees (){
        $this->liste = new TBL_Achat_s();
        $this->charge();
        $this->liste->afficheDonnees();
    }

    /**
     * Affiche la liste des données
     */
    private function afficheDonneesFiltrees ($filtre){
        $this->liste = new TBL_Achat_s();
        $this->liste->setFiltre($filtre);
        $this->charge();
        $this->liste->afficheDonnees();
    }

    /**
     * Affiche la liste des données des articles communs à un achat
     * @param int $id_achat Id de l'achat sélectionné.
     * @global LIB_DistributeurObjetTable $DOT
     */
    private function afficheDonneesAchatsMemeArticle($id_achat){
        global $DOT;
        
        $a = $DOT->getObjet("Achat");
        $a->setId($id_achat);
        $a->charge();
        $id_article = $a->getValeurColonne("id_Article");
        
        $tab_filtres = [];
        
        $tab_un_filtre = [];
        $tab_un_filtre[0] = "Achat_id_Article";
        $tab_un_filtre[1] = $id_article;
        
        $tab_filtres[] = $tab_un_filtre;
        
        $this->liste = new TBL_Achat_s();
        $this->liste->setFiltre($tab_filtres);
        $this->charge();
        $this->liste->afficheDonnees();
    }

    private function afficheEntete() {
        ?>
        <thead>
            <?php
            $this->afficheEnTetesColonnes();
            ?>
        </thead>
        <tfoot>
            <?php
            $this->afficheEnTetesColonnes();
            ?>
        </tfoot>
        <?php
    }
    
    private function afficheEnTetesColonnes() {
        ?>
        <tr>
            <th>Commerce</th>
            <th>Type produit</th>
            <th>Marque</th>
            <th>Produit</th>
            <th>Conditionnement</th>
            <th>Capacité</th>
            <th>Date</th>
            <th>Prix</th>
            <th>Prix au kilo</th>
        </tr>
        <?php
    }
    
    private function  charge() {
        $vs = new TBL_VariableSysteme();
        $domaine = $vs->getDomaineDernier();
        
        $this->liste->chargePourDomaine($domaine);
    }
    
    /**
     * Modifie une valeur saisie dans l'interface
     * @param type $id Ide de l'achat dont il faut modifier la valeur
     * @param type $colonne Nom de la colonne de la table à modifier
     * @param type $valeur Valeurs
     * @global LIB_DistributeurObjetTable $DOT
     * @return LIB_CompteRendu Compte rendu de l'opération
     */
    public function modifieValeur($id,$colonne,$valeur) {
        global $DOT;

        $achat = $DOT->getObjet("Achat");
        $achat->setId($id);
        $achat->charge();
        switch($colonne) {
            case 'montant' :
                $achat->setMontant((new LIB_Montant($valeur))->get_valeur_mysql());
                break;
            case 'datation' :
                $achat->setDatation((new LIB_Datation($valeur))->getDate_pourEcritureMySQL());
                break;
        }
        $crdu = $achat->sauve();
        return $crdu;
    }
}
