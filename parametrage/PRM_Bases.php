<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of PRM_Courses
 *
 * @author sylverscal
 */
class PRM_BaseLocale extends PRM_Base {

    public function __construct() {
        if ($this->is_distant) {
            $this->setParametres('MklAnj', 'db371772461', 'db371772461.db.1and1.com', 'ds4thp200', 'dbo371772461');
        } else {
            $this->setParametres('MklAnj', 'MklAnj', 'localhost:8889', 'MklAnj', 'MklAnj');
        }
    }
}

class PRM_Structure extends PRM_Base {

    public function __construct() {
        if ($this->is_distant) {
            $this->setParametres('information_schema', 'information_schema', 'db371772461.db.1and1.com', 'ds4thp200', 'dbo371772461');
        } else {
            $this->setParametres('information_schema', 'information_schema', 'localhost:8889', 'structure', 'structure');
        }
    }
}

