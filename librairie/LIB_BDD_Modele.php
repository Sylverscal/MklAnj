<?php

abstract class LIB_BDD_Modele {
    protected $cxo;
    protected $resource;
    
    abstract public function __construct();
    
    public final function getConnexion(){
        return $this->cxo;
    }
    
    protected final function getResource(){
        return $this->resource;
    }
    
    abstract function prepare($sql);
    
    abstract function execute();
        
    abstract function fetch();
        
    abstract function getInfo();
    
    public function close(){
        
    }
}
