<?php

/**
 * Description of LIB_TableColonne
 *
 * Représente une colonne d'une table
 * 
 * @author veroscal
 */
class LIB_TableColonne {

    /**
     * Nom du schéma auquel appartient la table
     * @var string
     */
    private $schema;

    /**
     * Nom de la table à laquelle la colonne appartient
     * @var string
     */
    private $nomTable;

    /**
     * Nom de la colonne
     * @var string
     */
    private $nomColonne;

    /**
     * Valeur brute telle que lue dans la table
     * @var string
     */
    private $valeurBrute;

    /**
     * Description de la colonne
     * @var string
     */
    private $description;

    /**
     * Type de la colonne
     * @var string 
     */
    private $type;

    /**
     * Constitue la valeur de la colonne avec son identité
     * @param string $nomTable 
     * @param string $nomColonne 
     * @param string $valeurBrute 
     */
    public function __construct($nomShema, $nomTable, $nomColonne, $description, $valeurBrute = '') {
        $this->schema = $nomShema;
        $this->nomTable = $nomTable;
        $this->nomColonne = $nomColonne;
        $this->valeurBrute = $valeurBrute;
        $this->description = $description;
        $this->type = $this->initType();
    }

    /**
     * Pour debug
     * @return string
     */
    public function __toString() {
        return "$this->nomTable - $this->nomColonne : $this->valeurBrute";
    }

    /**
     * Affiche la ligne d'édition de la valeur
     */
    public function afficheEdition() {
        ?>
        <div class="form-group">
            <label class="w3-text-indigo" for="<?php echo $this->nomColonne; ?>"><?php echo $this->initDescription()->get_decription_titre(); ?></label>
            <div class="w3-container">
                <?php
                $this->afficheLigneInput();
                ?>
            </div>
        </div>
        <?php
    }

    /**
     * Affiche la ligne d'édition de la valeur
     */
    public function afficheEditionTransfert() {
        ?>
        <div class="form-group">
            <label class="w3-text-indigo" for="<?php echo $this->nomColonne; ?>"><?php echo $this->initDescription()->get_decription_titre(); ?></label>
            <div class="w3-container">
                <?php
                $this->afficheLigneInputTexte();
                ?>
            </div>
        </div>
        <?php
    }

    /**
     * Affiche la ligne d'input
     */
    private function afficheLigneInput() {
        switch ($this->getType()) {
            case 'texte':
                $this->afficheLigneInputTexte();
                break;
            case 'datation':
                $this->afficheLigneInputTexte();
                break;
            case 'nombre':
                $this->afficheLigneInputNombre();
                break;
            case 'booleen':
                $this->afficheLigneInputBooleen();
                break;
            case 'menu':
                $this->afficheLigneInputMenu();
                break;
            default:
                $this->afficheLigneInputTexte();
                break;
        }
    }

    /**
     * Affiche la ligne d'input pour un champ texte
     */
    private function afficheLigneInputTexte() {
        ?>
        <input type="text" class="w3-input" id="<?php echo $this->nomColonne; ?>" <?php $this->afficheValeur(); ?> name="<?php echo $this->nomColonne; ?>">
        <?php
    }

    /**
     * Affiche la ligne d'input pour un champ texte
     */
    private function afficheLigneInputNombre() {
        ?>
        <input type="text" class="w3-input" id="<?php echo $this->nomColonne; ?>" <?php $this->afficheValeur(); ?> name="<?php echo $this->nomColonne; ?>">
        <?php
    }

    /**
     * Affiche la ligne d'input pour un champ "select" (menu)
     */
    private function afficheLigneInputMenu() {
        preg_match('@^id_(.*)$@i', $this->nomColonne, $tab);
        $nomTableFille = $tab[1];
        $this->afficheLigneSelect($nomTableFille);
    }

    /**
     * Affiche la ligne de sélection d'un élément parmi une liste
     * @param string $nomTable
     */
    private function afficheLigneSelect($nomTable) {
        $liste = $this->getLibellesSelect($nomTable);
        $this->afficheSelect($liste);
    }

    /**
     * Affiche la ligne d'input d'un champ "checkbox" (booléen)
     */
    private function afficheLigneInputBooleen() {
        ?>
        <input type="hidden" class="w3-input" name="<?php echo $this->nomColonne; ?>" <?php $this->afficheValeur(); ?>><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value" <?php $this->afficheChecked(); ?>>
        <?php
    }

    /**
     * Renvoie la liste des libellés des éléments de la table
     * @param string $nomTable
     * @global LIB_DistributeurObjetTable $DOT
     * @return array
     */
    private function getLibellesSelect($nomTable) {
        global $DOT;

        $nomClasseTable = "TBL_$nomTable" . '_s';
        $c = $DOT->getObjet($nomClasseTable);
        $c->charge();
        $tab = [];
        foreach ($c as $element) {
            $id = $element->getId();
            $libelle = $element->getLibelle();
            $tab[] = ['id' => $id, 'libelle' => $libelle];
        }
        $colonneLibelle = array_column($tab, "libelle");
        array_multisort($colonneLibelle, SORT_ASC,$tab);

        return $tab;
    }

    /**
     * Affiche la balise select pour choisir un élément parmi les libellés de la table
     * @param tableau $liste
     */
    private function afficheSelect($liste) {
        ?>
        <select class='w3-input' id="<?php echo $this->nomColonne; ?>" name="<?php echo $this->nomColonne; ?>">
            <?php
            foreach ($liste as $element) {
                $selected = '';
                if ($element['id'] == $this->valeurBrute) {
                    $selected = 'selected';
                }
                ?>
                <option value="<?php echo $element['id']; ?>" <?php echo $selected; ?>><?php echo $element['libelle']; ?></option>
                <?php
            }
            ?>
        </select>
        <?php
    }

    /**
     * Renvoie le texte à afficher quand le champ est vide
     * @return string
     */
    private function afficheValeur() {
        switch ($this->getType()) {
            case 'texte':
                $this->afficheValeurTexte();
                break;
            case 'datation':
                $this->afficheValeurdatation();
                break;
            case 'nombre':
                $this->afficheValeurNombre();
                break;
            case 'montant':
                $this->afficheValeurMontant();
                break;
            case 'booleen':
                $this->afficheValeurBooleen();
                break;
            default:
                $this->afficheValeurTexte();
                break;
        }
    }
    
    /**
     * Affiche la valeur du champ booleen
     */
    private function afficheValeurBooleen() {
        if ($this->valeurBrute == '1') {
            ?>
            value='1'
            <?php
        }
        else {
            ?>
            value='0'
            <?php
        }
    }

    /**
     * Affiche l'attribut "checked" si nécessaire
     */
    private function afficheChecked() {
        if ($this->valeurBrute == '1') {
            ?>
            checked
            <?php
        }
    }

    /**
     * Affiche la valeur du champ texte
     */
    private function afficheValeurTexte() {
        if ($this->valeurBrute == '') {
            ?>
            placeholder="<?php echo 'Renseigner ' . $this->initDescription()->get_decription_titre() . ' ...'; ?>"
            <?php
        } else {
            ?>
            value="<?php echo $this->valeurBrute; ?>"
            <?php
        }
    }

    /**
     * Affiche la valeur du champ datation
     */
    private function afficheValeurDatation() {
        if ($this->valeurBrute == '') {
            $d = new LIB_Datation();
            ?>
                value="<?php echo $d->getDate_pourAffichage(); ?>"
            <?php
        } else {
            $d = new LIB_Datation($this->valeurBrute);
            ?>
                value="<?php echo $d->getDate_pourAffichage(); ?>"
            <?php
        }
    }

    /**
     * Affiche la valeur du champ nombre
     */
    private function afficheValeurNombre() {
        if ($this->valeurBrute == '') {
            $this->valeurBrute = 0;
        }
        if ($this->valeurBrute == '') {
            ?>
            placeholder="<?php echo 'Renseigner ' . $this->initDescription()->get_decription_titre() . ' ...'; ?>"
            <?php
        } else {
            ?>
            value="<?php echo $this->valeurBrute; ?>"
            <?php
        }
    }

    /**
     * Affiche la valeur du champ montant
     */
    private function afficheValeurMontant() {
        if ($this->valeurBrute == '') {
            $this->valeurBrute = 0;
        }
        if ($this->valeurBrute == 0) {
            $m = new LIB_Montant();
            ?>
            value="<?php echo $m->get_valeur_affichage(); ?>"
            <?php
        } else {
            $m = new LIB_MontantBase($this->valeurBrute);
            ?>
            value="<?php echo $m->get_valeur_affichage(); ?>"
            <?php
        }
    }

    /**
     * Renvoie le type d'input à afficher en fonction du type de la colonne (INT,VARCHAR,...)
     * @return string
     */
    private function initType() {
        $typeColonne = $this->getTypeColonne();
        preg_match('@^(?:([[:alpha:]]+)\(([[:digit:]]+)\)|([[:alpha:]]+))$@', $typeColonne, $matches);
        $matches = LIB_Util::getTrimedArray($matches);
        $type_mysql = $matches[1];
        
        if ($this->isColonneDatation()) {
            $type = 'datation';
            return $type;
        }

        if ($this->isColonneMontant()) {
            $type = 'montant';
            return $type;
        }

        switch ($type_mysql) {
            case 'int':
                $taille = $matches[2];
                switch ($taille) {
                    case 1:
                        $type = 'booleen';
                        break;
                    case 11:
                        if (substr($this->nomColonne,0,3) == 'id_') {
                            $type = 'menu';
                        } else {
                            $type = 'nombre';
                        }
                        break;
                    default:
                        $type = 'nombre';
                        break;
                }

                break;
            case 'datetime':
                $type = 'datation';
                break;
                        
            default:
                $type = 'texte';
                break;
        }

        return $type;
    }

    public function getType() {
        return $this->type;
    }
    
    public function isMenu() {
        return $this->type == "menu" ? true : false;
    }
    
    /**
     * Renvoie si la colonne est de type Datation.
     * Pour que cela fonctionne il faut que la colonne commence par "datation". Ex : "datation_naissance".
     * Réserver les noms de colonnes "datation***" uniquement pour représenter des dates.
     * @return type
     */
    public function isColonneDatation() {
        $test = 0;
        $str = $this->nomColonne;
        $pattern = "/^datation.*$/i"; 
        $test = preg_match($pattern, $str); 
        
        return $test == 1 ? True : False;
       
    }

    /**
     * Renvoie si la colonne est de type Montant.
     * Pour que cela fonctionne il faut que la colonne commence par "montant". Ex : "montant_recette".
     * Réserver les noms de colonnes "montant***" uniquement pour représenter des valeurs financières.
     * @return type
     */
    public function isColonneMontant() {
        $str = $this->nomColonne;
        $pattern = "/^montant.*$/i"; 
        $test = preg_match($pattern, $str); 
        
        return $test == 1 ? True : False;
       
    }

    /**
     * Renvoie si la colonne est l'id de l'élément
     * @return boolean
     */
    public function isColonneId() {
        return $this->nomColonne == 'id';
    }

    /**
     * Renseigne la valeur de la colonne
     * @param string $valeurBrute
     */
    public function setValeur($valeurBrute) {
        $this->valeurBrute = $valeurBrute;
    }

    /**
     * Renvoie la valeur de la colonne
     * @return variant dépend du type de la variable
     */
    public function getValeur() {
        return $this->valeurBrute;
    }
    /**
     * 
     * @global LIB_DistributeurObjetTable $DOT
     * @return type
     */
    public function getValeurReelle() {
        global $DOT;
        
        $test = preg_match('@^id_(.*)$@i', $this->nomColonne, $tab);
        if ($test === 1) {
            $id = $this->getValeur();
            $classe = sprintf('TBL_%s', $tab[1]);
            $element = $DOT->getObjet("$classe");
            $element->charge($id);
            return $element->getLibelle();
        } else {
            return $this->getValeur();
        }
    }

    /**
     * Initialise la description de la colonne
     * @param string $nomTable
     * @param string $nomColonne
     * @global LIB_DistributeurObjetTable $DOT
     * @global LIB_BDD_Structure $CXO_ST
     * @return string
     */
    private function initDescription() {
        global $CXO_ST;
        global $DOT;

        $r = $CXO_ST->executeRequete("select column_comment from `COLUMNS` where table_schema = '$this->schema' and table_name = '$this->nomTable' and column_name = '$this->nomColonne'");
        if ($r->isOk()) {
            foreach ($r->getResultat() as $ligne) {
                $tab = [];
                $liste_filtres = ["/^id_(VoF)_.*/", "/^id_(.+)_h_$/", "/^id_(.+)$/"];
                foreach ($liste_filtres as $filtre) {
                    preg_match($filtre, $this->nomColonne, $tab);
                    if (isset($tab[1])) {
                        $nomTableFille = $tab[1];
                        $nomClasseFille = "TBL_$nomTableFille";
                        $c = $DOT->getObjet($nomClasseFille);
                        $d = $c->getDescriptionTable();
                        break;
                    }
                }
                if (preg_match("/^id_.*/", $this->nomColonne, $tab) == 0) {
                    $description = $ligne['column_comment'];
                    $d = new LIB_Description($description);
                }
            }
        } else {
            $r->affiche();
            $d = new LIB_Description("?");
        }
        return $d;
    }

    /**
     * Renvoie la description de la colonne
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Renvoie le type de la colonne de la table
     * @global LIB_BDD_Structure $CXO_ST
     * @return string
     */
    private function getTypeColonne() {
        global $CXO_ST;
        
        $r = $CXO_ST->executeRequete("select column_type from `COLUMNS` where table_schema = '$this->schema' and table_name = '$this->nomTable' and column_name = '$this->nomColonne'");
        if ($r->isOk()) {
            foreach ($r->getResultat() as $ligne) {
                $dt = $ligne['column_type'];
            }
        } else {
            $r->affiche();
            $dt = '?';
        }
        
        return $dt;
    }
    
    public function collecteInformationsRequeteSelectLibelle($requete_select_libelle) {
//        LIB_Util::log("Table   : $this->nomTable");
//        LIB_Util::log("Colonne : $this->nomColonne");
        $requete_select_libelle->ajoutePartie($this->nomTable,$this->nomColonne);
    }
    
    public function getNomColonne() {
        return $this->nomColonne;
    }
    
    public function getNomTable() {
        return $this->nomTable;
    }
    
    public function getNomArgument() {
        return sprintf("%s_%s",$this->nomTable,$this->nomColonne);
    }
    
    public function getNomTableLiee() {
        if (!$this->isMenu()) {
            return "-";
        }
        
        preg_match('@^id_(.*)$@i', $this->nomColonne, $tab);
        
        return $tab[1];
    }
    
    public function getNomClasseTableLiee() {
        return "TBL_".$this->getNomTableLiee();
    }

}
