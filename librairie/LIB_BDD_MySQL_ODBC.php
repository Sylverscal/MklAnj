<?php

include_once 'LIB_BDD_Modele.php';

class LIB_BDD_MySQL_ODBC extends LIB_BDD_Modele {

	private $dsn;

	public function __construct($base = 'ANIGTI') {
		if ($base == 'ANIGTI') {
			$sn = 'b936650';
			$db = 'ANIGTI';
			$cp = 'ANIGTI';
			$pw = 'ANIGTI';
		}
		if ($base == 'SAGA') {
			$sn = 'localhost';
			$db = 'SAGA';
			$cp = 'Saga';
			$pw = 'SAGA';
		}

		$this -> dsn = "Driver={MySQL ODBC 5.3 ANSI Driver};Server=$sn;Database=$db;";
		$this -> cxo = @odbc_connect($this -> dsn, $cp, $pw);

		if ($this -> cxo == NULL) {
			$this -> dsn = "Echec";
		}
	}

	public function execute($resource = NULL) {
		if ($resource == NULL) {
			return odbc_execute($this -> getResource());
		} else {
			return odbc_execute($resource);
		}
	}

	public function fetch($resource = NULL) {
		set_time_limit(240);
		if ($resource == NULL) {
			return odbc_fetch_array($this -> getResource());
		} else {
			return odbc_fetch_array($resource);
		}
	}

	public function getInfo() {
		return 'SQL Server : ODBC : ' . $this -> dsn;
	}

	public function prepare($sql) {
		$this -> resource = odbc_prepare($this -> getConnexion(), $sql);

		return $this -> resource;
	}

	// Methode pour preparer une requete sans memorisation de l'id resource.
	// Pour pouvoir ouvrir plusieurs requete en meme temps
	public function prepareSansMemorisation($sql) {
		return odbc_prepare($this -> getConnexion(), $sql);
	}

	public function errorMsg() {
		return odbc_errormsg();
	}

	function close() {
		odbc_close($this -> getConnexion());
	}

}
