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
        
        LIB_Util::log("Os : '$this->os'");
        if ($this->os == "Linux") {
            $this->local = 'non';
            LIB_Util::log("C'est Linux donc distant");
        } else {
            $this->local = 'oui';
            LIB_Util::log("Ce n'est pas Linux donc local");
        }
        LIB_Util::log("Local : ".$this->local);
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
        if ($this->local == "oui") {
            return true;
        }
        return false;
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
