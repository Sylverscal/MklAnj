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

/**
  $host_name = 'db5020579532.hosting-data.io';
  $database = 'dbs15734873';
  $user_name = 'dbu5155308';
  $password = '<Veuillez saisir ici votre mot de passe.>'; 
 * 
 * $schema,$database,$hostname,$password,$username
 */
class PRM_MklAnj extends PRM_Base {

    public function __construct() {
        $o = new LIB_infos_systeme();
        if ($o->getOs() == "Linux") {
            $this->setParametres('MklAnj', 'dbs15734873', 'db5020579532.hosting-data.io', '>P1eTa&6XTiNe@ST_PieRRe<', 'dbu5155308');
        } else {

            $this->setParametres('MklAnj', 'MklAnj', 'localhost:8889', 'MklAnj', 'MklAnj');
        }
    }
}

class PRM_Structure extends PRM_Base {

    public function __construct() {
        $o = new LIB_infos_systeme();
        if ($o->getOs() == "Linux") {
            $this->setParametres('dbs15734873', 'information_schema', 'db5020579532.hosting-data.io', '>P1eTa&6XTiNe@ST_PieRRe<', 'dbu5155308');
        } else {
            $this->setParametres('information_schema', 'information_schema', 'localhost:8889', 'structure', 'structure');
        }
    }
}

// -------------------------------------------------------------------------------------------------------------------------------------------------------

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

class PRM_Courses extends PRM_Base {

    public function __construct() {
        if ($this->is_distant) {
            $this->setParametres('Courses', 'db371772461', 'db371772461.db.1and1.com', 'ds4thp200', 'dbo371772461');
        } else {
            $this->setParametres('Courses', 'Courses', 'localhost:8889', 'courses', 'courses');
        }
    }
}

