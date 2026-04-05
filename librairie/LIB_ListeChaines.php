<?php
include_once 'LIB_Liste.php';

class LIB_ListeChaines extends LIB_Liste {

    public function __construct() {
        parent::__construct();
    }

    function trie($filtre = NULL) {
        usort($this->liste, array("LIB_ListeChaines", 'cmpA'));
    }

    function existe($s) {
        foreach ($this as $value) {
            if ($s == $value) {
                return TRUE;
            }
        }

        return FALSE;
    }

    function afficheEnTH() {
        foreach ($this as $s) {
            ?><th class=tableDonneesTH><?php echo $s; ?></th><?php
        }
    }

    static function cmpA($a, $b) {
        if ($a == $b) {
            return 0;
        }

        return ($a > $b) ? +1 : -1;
    }

    public function getTableau() {
        $t = array();
        foreach ($this as $s) {
            $t[] = $s;
        }
        
        return $t;
    }
}
