<?php

include_once 'LIB_Liste.php';
include_once 'LIB_TableColonne.php';

/**
 * Description of LIB_TableColonne_s
 * 
 * Liste des colonnes d'une ligne d'une table
 *
 * @author veroscal
 */
class LIB_TableColonne_s extends LIB_Liste {

    public function __construct() {
        parent::__construct();
    }

    public function setSchema($schema) {
        $this->schema = $schema;
    }

    public function __toString() {
        $s = '';
        foreach ($this->liste as $cle => $colonne) {
            $s .= sprintf('| %s -> %s |', $cle, $colonne->getValeurReelle());
        }
        return $s;
    }

    /**
     * Affiche l'édition de chaque colonne
     */
    public function afficheEdition() {
        foreach ($this->liste as $colonne) {

            if (!$colonne->isColonneId()) {
                $colonne->afficheEdition();
            }
        }
        LIB_Util::log("Fin");
    }

    /**
     * Affiche l'édition de chaque colonne
     */
    public function afficheEditionTransfert() {
        foreach ($this->liste as $colonne) {

            if (!$colonne->isColonneId()) {
                $colonne->afficheEditionTransfert();
            }
        }
        LIB_Util::log("Fin");
    }

    /**
     * Renvoie une colonne par son nom
     * @param chaine $nomColonne Nom de la colonne
     * @return LIB_TableColonne
     */
    public function getColonne($nomColonne) {
        return isset ($this->liste[$nomColonne]) ? $this->liste[$nomColonne] : "$nomColonne ?";
    }

    /**
     * Renvoie la valeur d'une colonne
     * @param chaine $nomColonne
     * @return variant dépend du type de la valeur
     */
    public function getValeur($nomColonne) {
        $s = $this->getColonne($nomColonne)->getValeur();
        return $s;
    }

    /**
     * Change la valeur de la colonne
     * @param chaine $nomColonne
     * @param variant $valeur
     */
    public function setValeur($nomColonne, $valeur) {
        $this->getColonne($nomColonne)->setValeur($valeur);
    }

    /**
     * Charge la valeur de chaque colonne
     */
    public function charge() {
        foreach ($this as $colonne) {
            $colonne->charge();
        }
    }

    /**
     * Renvoie la section colonnes d'une requête Update
     * @return string
     */
    public function getSqlInsertSectionColonnes() {
        $tab = [];

        foreach ($this->liste as $nomColonne => $colonne) {
            if ($nomColonne != 'id' && !is_numeric($nomColonne)) {
                $tab[] = "`$nomColonne`";
            }
        }

        $s = implode(',', $tab);

        return "($s)";
    }

    /**
     * Renvoie la section valeurs d'une requête sql Insert
     * @return string
     */
    public function getSqlInsertSectionValeurs() {
        $tab = [];

        foreach ($this->liste as $nomColonne => $colonne) {
            if ($nomColonne != 'id' && !is_numeric($nomColonne)) {
                $v = LIB_Util::formateChainePourSQL($colonne->getValeur());
                $tab[] = "'$v'";
            }
        }

        $s = implode(',', $tab);

        return "($s)";
    }

    /**
     * Renvoie la section set d'une requête sql Update
     * @return string
     */
    public function getSqlUpdateSectionSet() {
        $tab = [];
        foreach ($this->liste as $nomColonne => $colonne) {
            if ($nomColonne != 'id' && !is_numeric($nomColonne)) {
                $c = $nomColonne;
                $v = LIB_Util::formateChainePourSQL($colonne->getValeur());
                if ($colonne->getType() == 'booleen') {
                    if ($v == '') {
                        $v = 0;
                    }
                }
                $tab[] = "`$c` = '$v'";
            }
        }
        $s = implode(',', $tab);
        return "set $s";
    }

    /**
     * Renvoie la séquence where d'une requete pour rechercher un élément 
     * @return string
     */
    public function getSqlSelectWhere() {
        $tab = [];

        foreach ($this->liste as $nomColonne => $colonne) {
            if ($nomColonne != 'id' && !is_numeric($nomColonne)) {
                $c = $nomColonne;
                $v = LIB_Util::formateChainePourSQL($colonne->getValeur());
                $tab[] = "`$c` = '$v'";
            }
        }

        $s = implode(' and ', $tab);
        return "where $s";
    }

    public function collecteInformationsRequeteSelectLibelle($requete_select_libelle) {
        foreach ($this->liste as $colonne) {
            $colonne->collecteInformationsRequeteSelectLibelle($requete_select_libelle);
        }
    }
    
    public function getListe() {
        return $this->liste;
    }
}
