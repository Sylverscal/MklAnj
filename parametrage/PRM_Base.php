<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of PRM_ParametresBase
 * 
 * Liste des paramètres pour accèder à une base
 *
 * @author sylverscal
 */
abstract class PRM_Base {
    private string $schema;
    private string $database;
    private string $hostname;
    private string $username;
    private string $password;
    private string $is_distant;

    public function __construct() {
        $this->setParametres("", "", "", "", "");
    }
    
    protected function setParametres ($schema,$database,$hostname,$password,$username) {
        $this->schema = $schema;
        $this->database = $database;
        $this->hostname = $hostname;
        $this->username = $password;
        $this->password = $username;
        $this->is_distant = $this->isDistant();
    }
    
    public function getSchema() {
        return $this->schema;
    }
    
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    
    public function __set(string $property, mixed $valeur): void {
        if (property_exists($this, $property)) {
            $this->$property = $valeur;
        }
    }
    
    /**
     * Renvoie on accède à la base locale ou à la base distante
     * @return boolean
     */
    private function isDistant() {
        $is = new LIB_infos_systeme();
        if ($is->getLocal()){
            return FALSE;
        }
        return TRUE;
    }

}
