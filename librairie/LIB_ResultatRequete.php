<?php

/**
 * Description of AGT_Erreur
 * 
 * Pour transporter la description d'erreurs dans un seul objet
 *
 * @author C320688
 */
class LIB_ResultatRequete {

    private $resultat;
    private $ko;
    private $code;
    private $message;
    private $sql;

    /**
     * Initialise objet
     */
    public function __construct() {
        $this->ko = FALSE;
        $this->sql = '';
    }

    /**
     * Fixe résultat à Ok
     */
    public function setOk() {
        $this->ko = FALSE;
    }

    /**
     * Fixe résultat à Ko
     */
    public function setKo() {
        $this->ko = TRUE;
    }

    /**
     * Renseigne le résultat de la requête.
     * C'est donc un retour Ok.
     * @param variant $resultat
     */
    public function setResultat($resultat, $sql = '') {
        $this->setOk();
        $this->resultat = $resultat;
        $this->sql = $sql;
    }

    /**
     * Renseigne informations sur l'erreur.
     * C'est donc un retour Ko.
     * @param chaine $code
     * @param chaine $message
     * @param chaine $sql
     */
    public function setErreur($code, $message, $sql) {
        $this->setKo();
        $this->code = $code;
        $this->message = $message;
        $this->sql = $sql;
    }

    /**
     * Renvoie si le retour est Ko
     * @return type
     */
    public function isKo() {
        return $this->ko;
    }

    /**
     * Renvoie si le retour est Ok
     * @return type
     */
    public function isOk() {
        return !$this->isKo();
    }

    /**
     * Lit le résultat de la requête
     * @return variant
     */
    public function getResultat() {
        return $this->resultat;
    }
    
    /**
     * Renvoie un message d'erreur
     * @return string
     */
    public function getMessageErreur(){
        return "$this->code : $this->message";
    }
    
    /**
     * Renvoiie le nombre de résultats trouvés
     * @return int
     */
    public function getNbResultats(){
        return count($this->resultat);
    }

    /**
     * Affiche le résultat
     */
    public function affiche() {
        if ($this->isKo()) {
            $this->afficheKo();
        } else {
            $this->afficheOk();
        }
    }
    
    /**
     * Renvoie le résumé de l'erreur
     */
    private function getResumeErreur() {
        if ($this->isOk()) { return ""; }
        
        if (preg_match("/DUPLICATE ENTRY/i", $this->message) == 1) {
            return "Article existe déjà";
        }

        if (preg_match("/Incorrect integer value/i", $this->message) == 1) {
            return "Valeur incorrecte pour nombre Entier";
        }

        if (preg_match("/Incorrect datetime value/i", $this->message) == 1) {
            return "Valeur incorrecte pour la date<br>L'important c'est d'avoir le choix dans la date";
        }

        if (preg_match("/Integrity constraint violation/i", $this->message) == 1) {
            return "L'article ne peut pas être inséré<br><i>Un des liens vers une autre table n'est pas renseigné</i>";
        }

        if (preg_match("/Invalid datetime format/i", $this->message) == 1) {
            return "Le format date est mauvais<br>Il doit être de la forme : jj-mm-aaaa (ex : 28-08-1962)";
        }

        if (preg_match("/a foreign key constraint fails/i", $this->message) == 1) {
            return "L'article ne peut être supprimé<br><i>Il est utilisé par autre article auquel il est lié</i>";
        }

        if (preg_match("/Base table or view not found:/i", $this->message) == 1) {
            return "La table n'existe pas";
        }

        return "Y a un bucre";
    }
    
    /**
     * Renvoie le détail de l'erreur
     */
    private function getDetailErreur() {
        if ($this->isOk()) { return []; }
        
        $tab = array();
        
        $tab[] = $this->message;
        $tab[] = $this->sql;
        
        return $tab;
    }
    
    /**
     * Renvoie le comte rendu de l'opération à renvoyer en surface
     * @return type
     */
    public function getCompteRendu() {
        $crdu = new LIB_CompteRendu($this->isOk(),$this->getResumeErreur(),$this->getDetailErreur());
        return $crdu;
    }

    /**
     * Affiche la partie Ok du résultat
     */
    private function afficheOk() {
        ?>
        <table border="1">
            <tr>
                <th>Requ&ecirc;te r&eacute;ussie</th>
            </tr>
            <?php
            if ($this->sql != '') {
                ?>
                <tr>
                    <td><?php echo $this->sql; ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }

    /**
     * Affiche la partie Ko du résultat
     */
    private function afficheKo() {
        ?>
        <table border="1">
            <tr>
                <th>Code</th>
                <th>Message</th>
            </tr>
            <tr>
                <td><?php echo $this->code; ?></td>
                <td><?php echo $this->message; ?></td>
            </tr>
            <tr>
                <td colspan="2"><?php echo $this->sql; ?></td>
            </tr>
        </table>
        <?php
    }

    /**
     * N'affiche que si le résultat est Ko
     */
    public function afficheSiKo() {
        if ($this->isKo()) {
            $this->afficheKo();
        }
    }

    public function afficheResultat() {
        ?>
        <table border='1'>
            <?php
            if ($this->isOk()) {
                foreach ($this->resultat as $ligne) {
                    ?>
                    <tr>
                        <td>
                            <table border='0'>
                                <?php
                                foreach ($ligne as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?php echo $key; ?></td>
                                        <td><?php echo $value; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td>
                        Il n'y a pas de donn&eacute;es &agrave; afficher
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }

}
