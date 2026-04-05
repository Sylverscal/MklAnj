<?php

include_once '../Librairie/LIB_Datation.php';
include_once 'LIB_Liste.php';

class LIB_ListeDates extends LIB_Liste {

    public function __construct() {
        parent::__construct();
    }

    function trie($filtre = NULL) {
        usort($this->liste, array("LIB_ListeDates", 'cmpA'));
    }

    static function cmpA($a, $b) {
        if ($a->getDate_pourTri() == $b->getDate_pourTri()) {
            return 0;
        }

        return ($a->getDate_pourTri() > $b->getDate_pourTri()) ? +1 : -1;
    }

    function position($element) {
        foreach ($this as $key => $value) {
            if ($value->getDate_pourTri() == $element->getDate_pourTri()) {
                return $key;
            }
        }

        return -1;
    }
}
