<?php

$tm = new TEST_mysql();
$tm->lectureArticle();
$tm->informationSchema();

class TEST_mysql {

    private $db;
    private $hostname;
    private $database;
    private $username;
    private $password;
    private $erreur;

    function __construct() {
        $this->renseigneParametres();
        $this->ouvre();
        $this->trace("Ouverture connexion : $this->erreur");
    }

    private function renseigneParametres() {
        if ($this->isDistant()) {
            $this->database = 'dbs15734873';
            $this->hostname = 'db5020579532.hosting-data.io';
            $this->password = '>P1eTa&6XTiNe@ST_PieRRe<';
            $this->username = 'dbu5155308';
        } else {
            $this->database = 'MklAnj';
            $this->hostname = 'localhost:8889';
            $this->password = 'MklAnj';
            $this->username = 'MklAnj';
        }
    }

    private function ouvre() {
        $this->erreur = "";
        try {
            $this->db = new PDO("mysql:host=$this->hostname;dbname=$this->database", $this->username, $this->password);
            $this->db->exec("SET CHARACTER SET utf8");
            $this->erreur = "Connexion Ok";
        } catch (Exception $e) {
            $this->erreur = $e->getMessage();
        }
    }

    private function isDistant() {
        if (PHP_OS == 'Darwin') {
            return FALSE;
        }
        return TRUE;
    }

    private function trace($texte) {
        echo "$texte<br>";
    }

    public function lectureArticle() {
        $sql = "select nom from Commerce";
        $resultat = $this->db->query($sql);
        if ($resultat === FALSE) {
            $this->trace('Ko');
            $this->trace($this->db->errorInfo()[0]);
            $this->trace($this->db->errorInfo()[1]);
            $this->trace($this->db->errorInfo()[2]);
        } else {
            $lignes = $resultat->fetchAll();
            foreach ($lignes as $ligne) {
                $nom = $ligne['nom'];
                $this->trace("$nom");
            }
        }
    }

    public function informationSchema() {
        $this->trace('');
        $this->trace('Lecture information Schema');
        if ($this->isDistant()) {
            $database = 'information_schema';
            $hostname = 'db5020579532.hosting-data.io';
            $password = '>P1eTa&6XTiNe@ST_PieRRe<';
            $username = 'dbu5155308';
            $schema = 'dbs15734873';
        } else {
            $database = 'information_schema';
            $hostname = 'localhost';
            $password = 'structure';
            $username = 'structure';
            $schema = 'MklAnj';
        }
        try {
            $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            $db->exec("SET CHARACTER SET utf8");
            $this->trace('Connexion information schema : Ok');
            $sql = "select `TABLE_NAME` from `TABLES` where `TABLE_SCHEMA` = '$schema'";
            $resultat = $db->query($sql);
            if ($resultat === FALSE) {
                $this->trace('Ko');
                $this->trace($db->errorInfo()[0]);
                $this->trace($db->errorInfo()[1]);
                $this->trace($db->errorInfo()[2]);
            } else {
                $lignes = $resultat->fetchAll();
                foreach ($lignes as $ligne) {
                    $table_name = $ligne['TABLE_NAME'];
                    $this->trace($table_name);
                }
            }
        } catch (Exception $e) {
            $this->trace('Connexion information schema : Ko');
            print_r($e);
        }
    }

}
