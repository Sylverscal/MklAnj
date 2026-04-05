<?php

/**
 * Description of BDD
 * 
 * Pour gérer la connexion à la base 
 *
 * @author C320688
 */
class LIB_BDD extends LIB_BDD_MySQL_PDO {

    /**
     * Etablit la connexion à la base
     */
    public function __construct($prm) {
        parent::__construct($prm);
        
        $this->ouvre();
    }

}
