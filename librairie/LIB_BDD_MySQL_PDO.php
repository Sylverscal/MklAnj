<?php
include_once 'LIB_BDD_PDO.php';
/**
 * C_ConnexionBase
 * 
 * Gestion connexion à une base
 *
 * @author C320688
 */
class LIB_BDD_MySQL_PDO extends LIB_BDD_PDO {

    #[\Override]
    public function ouvre() {
        $this->erreur = "";
        try {
            $this->db = new PDO(sprintf("mysql:host=%s;dbname=%s",$this->getParametrage()->hostname,$this->getParametrage()->database), $this->getParametrage()->username, $this->getParametrage()->password);
            $this->db->exec("SET CHARACTER SET utf8");
        } catch (Exception $e) {
            $this->erreur = $e->getMessage();
        }
    }
    
}
