<?php

include_once 'LIB_BDD_Modele.php';

class LIB_BDD_Excel extends LIB_BDD_Modele {

    public function __construct() {
        $sn = '';
        $db = $fichier;
        $cp = '';
        $pw = '';

        $this->cxo = @odbc_connect("Provider=Microsoft.ACE.OLEDB.12.0;Data Source =$db; Extended Properties ='Excel 12.0;HDR=NO;IMEX=1';", $cp, $db);
    }

    public function execute() {
        odbc_execute($this->getResource());
    }

    public function fetch() {
        return odbc_fetch_array($this->getResource());
    }

    public function getInfo() {
        return 'SQL Server : ODBC';
    }

    public function prepare($sql) {
        $this->resource = odbc_prepare($this->getConnexion(), $sql);
    }

    function close() {
        odbc_close($this->getConnexion());
    }

}

?>
