<?php

/**
 * Description of AGT_ListeIdentifiants
 * 
 * Pour gérer unhe liste d'identifiants et les afficher dans un menu.
 *
 * @author C320688
 */
abstract class LIB_Menu extends LIB_ListeChaines {

    /**
     * Parametre pour décider si la sélection multiple est possible
     * @var boolean
     */
    private $is_multiple;

    /**
     * Parametre si la première valeur est vide.
     * Pour forcer un choix ou pour le filtres
     * @var boolean
     */
    private $is_premiere_valeur_vide;

    public function __construct() {
        global $CXO;
        parent::__construct();
        $this->is_multiple = FALSE;
        $this->is_premiere_valeur_vide = FALSE;
        $requete = $this->getRequete();
        $resultat = $CXO->executeRequete($requete);
        if ($resultat->isOk()) {
            foreach ($resultat->getResultat() as $ligne) {
                $id = $ligne['id'];
                $nom = $ligne['nom'];
                $this->ajoute($this->getNomMiseEnForme($id, $nom), $id == 0 ? $nom : $id);
            }
            $this->trie();
        }
    }

    public function trie($filtre = NULL) {
        
    }

    /**
     * Renvoie le nom mis en forme si besoin
     * @param type $id
     * @param type $nom
     * @return string
     */
    protected function getNomMiseEnForme($id, $nom) {
        return $nom;
    }

    /**
     * Renvoie la requête pour récupérer les noms 
     * @return string Requête
     */
    protected abstract function getRequete();

    /**
     * Affiche un menu avec le contenu de la liste
     * @param string $name Nom du select (Renseigne l'attribut name, ex : name="foo")
     * @param string $name Valeur à afficher sélectionnée par défaut
     */
    public function afficheMenu($nom_select, $valeur = '') {
        ?>
        <div class="form-group">
            <?php
            $this->afficheLabel();
            ?>
            <select class="form-control <?php echo $this->isMultiple() ? 'selectpicker' : ''; ?>" id="LIB_SEL_<?php echo $nom_select; ?>" name="<?php echo $nom_select; ?>" <?php echo $this->isMultiple() ? 'multiple' : ''; ?>>
                <?php
                if ($this->isPremiereValeurVide()) {
                    ?>
                    <option id="LIB_Option_0" value="0">Faites un choix ...</option>
                    <?php
                }
                foreach ($this->liste as $id => $nom) {
                    $select = '';
                    if ($valeur == $nom) {
                        $select = 'selected';
                    }
                    ?>
                    <option id="LIB_Option_<?php echo $id == 0 ? $nom : $id; ?>" value="<?php echo $id == 0 ? $nom : $id; ?>" <?php echo $select; ?>><?php echo $nom; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <?php
    }

    /**
     * Affiche le label
     */
    protected function afficheLabel() {
        
    }

    /**
     * Permet la sélection multiple
     */
    public function setMultiple() {
        $this->is_multiple = TRUE;
    }

    /**
     * Renvoie si la sélection multiple est possible
     * @return boolean
     */
    private function isMultiple() {
        return $this->is_multiple;
    }

    /**
     * Permet l'affichage d'une première valeur vide
     */
    public function setPremiereValeurVide() {
        $this->is_premiere_valeur_vide = TRUE;
    }

    /**
     * Renvoie si la première valeur de la liste doit être vide
     * @return boolean
     */
    private function isPremiereValeurVide() {
        return $this->is_premiere_valeur_vide;
    }

}
