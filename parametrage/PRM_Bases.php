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
class PRM_Courses extends PRM_Base {

    public function __construct() {
        if ($this->is_distant) {
            $this->setParametres('Courses', 'db371772461', 'db371772461.db.1and1.com', 'ds4thp200', 'dbo371772461');
        } else {
            $this->setParametres('Courses', 'Courses', 'localhost:8889', 'courses', 'courses');
        }
    }
}

class PRM_MklAnj extends PRM_Base {

    public function __construct() {
        if ($this->is_distant) {
            $this->setParametres('MklAng', 'db371772461', 'db371772461.db.1and1.com', 'ds4thp200', 'dbo371772461');
        } else {
            $this->setParametres('MklAng', 'MklAng', 'localhost:8889', 'MklAng', 'MklAng');
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

class PRM_Theatre extends PRM_Base {

    public function __construct() {
        $this->setParametres('Theatre', 'Theatre', 'localhost:8889', 'theatre', 'theatre');
    }
}

class PRM_Achats extends PRM_Base {

    public function __construct() {
        $o = new LIB_infos_systeme();
        if ($o->isMacMini()) {
            $this->setParametres('Achats', 'Achats', 'localhost:8889', 'achat', 'achat');
        }
        if ($o->isMacBookPro()) {
            $this->setParametres('Achats', 'Achats', 'localhost:8889', 'achats', 'achats');
        }
    }
}
