<?php

class LIB_Liste implements Iterator {

    protected $position = 0;
    protected $liste;
    protected $dateCreation;

    public function __construct() {
        $this->rewind();
        $this->liste = array();
    }

    public function __clone() {
        $this->position = $this->position;
        $this->dateCreation = $this->dateCreation;
        
        foreach ($this->liste as $cle => $valeur) {
            switch (gettype($valeur)) {
                case 'object':
                    $this->liste[$cle] = clone $valeur;
                    break;

                default:
                    $this->liste[$cle] = $valeur;
                    break;
            }
        }
    }

    public function getListe() {
        return $this->liste;
    }

    protected function date($datation = NULL) {
        if ($datation == NULL) {
            $this->dateCreation = new LIB_Datation();
        } else {
            $this->dateCreation = $datation;
        }
    }

    protected function fusionneDate($datation = NULL) {
        if ($datation == NULL) {
            $this->dateCreation = new LIB_Datation();
        } else {
            if ($this->dateCreation == NULL) {
                $this->dateCreation = clone($datation);
            } else {
                if ($this->dateCreation->isAhui()) {
                    $this->dateCreation = clone($datation);
                }
            }
        }
    }

    public function getDate() {
        if ($this->dateCreation == NULL) {
            $this->date();
        }
        return $this->dateCreation;
    }

    function ajoute($element, $cle = '') {
        if ($cle == '') {
            $n = count($this->liste);
            $this->liste[$n] = clone($element);
        } else {
            $this->liste[$cle] = $element;
        }
    }

    function ajouteSansDoublon($element) {
        $pos = $this->position($element);

        if ($pos >= 0) {
            return;
        }

        $this->ajoute($element);
    }

    function supprime($element) {
        $pos = $this->position($element);

        if ($pos < 0) {
            return;
        }

        array_splice($this->liste, $pos, 1);
    }

    function position($element) {
        foreach ($this as $key => $value) {
            if ($value == $element) {
                return $key;
            }
        }

        return -1;
    }

    public function cherche($valeur) {
        $pos = $this->position($valeur);

        if ($pos >= 0) {
            return $this->get($pos);
        } else {
            return NULL;
        }
    }

    function getListeFiltree($filtre) {
        $l = $this->duplique($filtre);

        $l->trie($filtre);

        $l->date($this->getDate());
        return $l;
    }

    protected function duplique($filtre) {
        $l = new LIB_Liste();

        foreach ($this as $v) {
            $l->ajoute($v);
        }

        return $l;
    }

    /**
     * Fusionne deux listes
     * @param LIB_Liste $liste liste à fusionner avec this
     */
    public function fusionne($liste) {
        foreach ($liste as $value) {
            $this->ajouteSansDoublon($value);
        }
        $this->trie();
    }

    /**
     * Inverse l'ordre des éléménts de la liste.
     * @param boolean $preserve_index Si vrai : Les clés sont préservés, si faux : Les clés sont refaites de 0 à n
     */
    public function inverse($preserve_index = FALSE){
        $this->liste = array_reverse($this->liste, $preserve_index);
    }
    
    protected function trie($filtre) {
        
    }
    
    /**
     * Initialise la liste
     */
    function reset(){
        $this->rewind();
        $this->liste = array();
    }

    #[\Override]
    #[\ReturnTypeWillChange]
    function rewind() {
        $this->position = 0;
    }

    #[\Override]
    #[\ReturnTypeWillChange]
    function current(): mixed {
        return $this->liste[$this->position];
    }

    #[\Override]
    #[\ReturnTypeWillChange]
    function key() {
        return $this->position;
    }

    #[\Override]
    #[\ReturnTypeWillChange]
    function next() {
        ++$this->position;
    }

    #[\Override]
    #[\ReturnTypeWillChange]
    function valid() : bool {
        return isset($this->liste[$this->position]);
    }

    function length() {
        return count($this->liste);
    }

    public function __toString() {
        $s = 'Nb elements : ' . $this->length() . LIB_Util::crlf();
        foreach ($this->liste as $index => $element) {
            $s = $s . $index . " -> " . $element . LIB_Util::crlf();
        }
        return $s;
    }

    function get($i) {
        return isset($this->liste[$i]) ? $this->liste[$i] : "";
    }

}
