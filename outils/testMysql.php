<?php

$tm = new TEST_mysql();
$tm->lecturePersonne();
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
            $this->database = 'db371772461';
            $this->hostname = 'db371772461.db.1and1.com';
            $this->password = 'ds4thp200';
            $this->username = 'dbo371772461';
        } else {
            $this->database = 'photo';
            $this->hostname = 'localhost';
            $this->password = 'photo';
            $this->username = 'photo';
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

    public function lecturePersonne() {
        $sql = "select nom,prenom from personne";
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
                $prenom = $ligne['prenom'];
                $this->trace("$prenom $nom");
            }
        }
    }

    public function informationSchema() {
        $this->trace('');
        $this->trace('Lecture information Schema');
        if ($this->isDistant()) {
            $database = 'information_schema';
            $hostname = 'db371772461.db.1and1.com';
            $password = 'ds4thp200';
            $username = 'dbo371772461';
            $schema = 'db371772461';
        } else {
            $database = 'information_schema';
            $hostname = 'localhost';
            $password = 'structure';
            $username = 'structure';
            $schema = 'photo';
        }
        try {
            $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
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
        }
    }

}
