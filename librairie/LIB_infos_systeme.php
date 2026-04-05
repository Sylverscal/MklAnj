<?php

/**
 * Description of LIB_infos_systeme
 * 
 * Classe avec des fonctions pour obtenir des informations sur le système
 *
 * @author veroscal
 */
class LIB_infos_systeme {

    private $os;
    private $systeme;
    private $local;


    public function __construct() {
        $this->os = $this->getOs();
        $this->systeme = $this->getSysteme();
        
        $this->local = $this->os == "Darwin" ? TRUE : FALSE;
    }
    public function affiche() {
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Information</th>
                    <th>Valeur</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Nom OS</th>
                    <td><?php echo $this->getOs(); ?></td>
                </tr>
                <tr>
                    <th>Nom Système</th>
                    <td><?php echo $this->getSysteme(); ?></td>
                </tr>
                <tr>
                    <th>Localisation</th>
                    <td><?php echo $this->getLocal() ? "Local" : "Distant"; ?></td>
                </tr>
            </tbody>
        </table>
        <?php
    }

    /**
     * Renvoie le nom du système d'exploitation
     * @return string Os
     */
    public function getOs() {
        return PHP_OS;
    }
    
    /**
     * Renvoie le nom complet du système
     * @return string Nom de système
     */
    public function getSysteme(){
        return php_uname();
    }

    public function getLocal() {
        return $this->local;
    }
    
    public function isMacBookPro() {
        $test = preg_match("/MBPdeVeronique/i", $this->getSysteme());
        if ($test) {
            return true;
        }
        
        return false;
    }
    
    public function isMacMini() {
        $test = preg_match("/Mac-mini-de-Sylverscal/i", $this->getSysteme());
        if ($test) {
            return true;
        }
        
        return false;
    }
}
