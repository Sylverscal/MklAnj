<?php

class LIB_Datation {

    static $avecControleDelai;
    private $datation;
    private $is_valide;

    public function __construct($valeur = NULL) {
        $this->setDate($valeur);
    }

    public function __clone() {
        $this->datation = clone $this->datation;
    }

    function setDate($valeur = NULL) {
        $this->set_date_valide();
        
        if ($valeur == NULL) {
            $this->datation = new DateTime();
        } else {
            if ((LIB_Datation::isFormatDateOk($valeur)) === false) {
                $this->datation = NULL;
                $this->set_date_pas_valide();
                return;
            }
            // Sur le B888764 : La date est reçue de Oracle au format '23-AVR-05'
            $this->datation = DateTime::createFromFormat('d-m-Y', $valeur);
            if ($this->datation == NULL) {
                $this->datation = DateTime::createFromFormat('d/m/Y', $valeur);
            }
            if ($this->datation == NULL) {
                $this->datation = DateTime::createFromFormat('d m Y', $valeur);
            }
            if ($this->datation == NULL) {
                $this->datation = DateTime::createFromFormat('d?m?Y', $valeur);
            }
            if ($this->datation == NULL) {
                $this->datation = DateTime::createFromFormat('Y-m-d H:i:s.u', $valeur);
            }
            if ($this->datation == NULL) {
                $this->datation = DateTime::createFromFormat('Y-m-d', $valeur);
            }
            if ($this->datation == NULL) {
                $this->datation = DateTime::createFromFormat('Y-m-d H:i:s', $valeur);
            }
        }
        if ($this->datation == NULL) {            
            $this->set_date_pas_valide();
        }
    }

    function getDate() {
        return $this->datation;
    }
    
    private function set_date_valide() {
        $this->is_valide = true;
    }

    private function set_date_pas_valide() {
        $this->is_valide = false;
    }
    
    public function is_date_valide() {
        return $this->is_valide;
    }

    /**
     * Renvoie la date au format 28-08-1962
     * '-' est le séparateur passé en paramètre
     * @param string $separateur
     * @return string
     */
    function getDate_DDxMMxAAAA($separateur) {
        return $this->datation->format('d' . $separateur . 'm' . $separateur . 'Y');
    }

    /**
     * Renvoie la date au format 28-08-1962
     * @return string
     */
    function getDate_DD_MM_AAAA() {
        return $this->getDate_DDxMMxAAAA('-');
    }

    function getDate_pourTri() {
        return $this->datation->format('Ymd');
    }

    function getDate_pourSQL() {
        return $this->getDate_DDxMMxAAAA('-');
    }

    function getDate_pourEcritureSQL() {
        return $this->datation->format('m/d/Y H:i:s');
    }

    /**
     * Renvoie la date au format MySQL avec l'heure (ex:1962-08-28 12:34:54)
     * @return string
     */
    function getDate_pourEcritureMySQL() {        
        return $this->datation->format('Y-m-d H:i:s');
    }

    /**
     * Renvoie la date au format MySQL sans l'heure (ex:1962-08-28)
     * @return string
     */
    function getDate_pourEcritureMySQLCourte() {
        return $this->datation->format('Y-m-d');
    }

    function getDate_pourAffichage() {
        return $this->datation === NULL ? "?" : $this->getDate_DDxMMxAAAA('-');
    }

    function getDateTime_pourAffichage() {
        return $this->getDate_pourAffichage() . ' ' . $this->getTime_HHMMSS();
    }

    function getDate_pourExportExcel() {
        return $this->getDate_DDxMMxAAAA('/');
    }

    function getDate_MM_AA() {
        return $this->datation->format('m-Y');
    }

    function getDate_AA() {
        return $this->datation->format('Y');
    }

    function getDate_MM() {
        return $this->datation->format('m');
    }

    function getDate_AA_MM() {
        return $this->datation->format('Y-m');
    }

    function getTime_HHMMSS() {
        return $this->datation->format("H:i:s");
    }

    function decrementeMois() {
        $this->passeAuPremierJourDuMois();
        $this->datation->setDate($this->datation->format("Y"), $this->datation->format("m") - 1, $this->datation->format("d"));
    }

    function decrementeJour($nbJours = 1) {
        $this->datation->setDate($this->datation->format("Y"), $this->datation->format("m"), $this->datation->format("d") - $nbJours);
    }

    function incrementeMois() {
        $this->datation->setDate($this->datation->format("Y"), $this->datation->format("m") + 1, $this->datation->format("d"));
    }

    function incrementeJour($nbJours = 1) {
        $this->datation->setDate($this->datation->format("Y"), $this->datation->format("m"), $this->datation->format("d") + $nbJours);
    }

    function passeAuDernierJourDuMois() {
        $this->passeAuPremierJourDuMois();
        $this->incrementeMois();
        $this->decrementeJour();
    }

    function passeAuPremierJourDuMois() {
        $this->datation->setDate($this->datation->format("Y"), $this->datation->format("m"), 1);
        $this->datation->setTime(0, 0, 0);
    }

    function passeAuPremierJourDuMoisSuivant() {
        $this->datation->setDate($this->datation->format("Y"), $this->datation->format("m") + 1, 1);
        $this->datation->setTime(0, 0, 0);
    }

    /**
     * Passe l'heure de la date au début de la journée
     */
    function passeADebutJournee() {
        $this->datation->setTime(0, 0, 0);
    }

    /**
     * Passe l'heure de la date à la fin de la journée
     */
    function passeAFinJournee() {
        $this->datation->setTime(23, 59, 59);
    }

    function getStyleSelonDelai() {
        if (LIB_Datation::$avecControleDelai != TRUE) {
            return 'tableDonneesTD';
        }

        $n = $this->getDelaiDeAujourdHui();

        if ($n < LIB_Datation::DelaiJaune() * 30) {
            return 'tableDonneesTD';
        }
        if ($n < LIB_Datation::DelaiRouge() * 30) {
            return 'tableDonneesTD_Jaune';
        }

        return 'tableDonneesTD_Rouge';
    }

    function getPlage() {
        $n = $this->getDelaiDeAujourdHui();

        if ($n < LIB_Datation::DelaiJaune() * 30) {
            return 1;
        }
        if ($n < LIB_Datation::DelaiRouge() * 30) {
            return 2;
        }

        return 3;
    }

    function getDelaiDe($datation) {
        $d = $datation->getDate();
        $delai = $this->datation->diff($d);
        $s = $delai->format('%R%a');
        $n = (int) $s;
        return $n;
    }

    function getDelai($datation) {
        $d = $datation->getDate();
        $delai = $this->datation->diff($d);
        return $delai;
    }

    function getDelaiMoisDe($datation) {
        $dfa = $this->getDate_AA();
        $dfm = $this->getDate_MM();
        $fm = $dfa * 12 + $dfm;

        $dda = $datation->getDate_AA();
        $ddm = $datation->getDate_MM();
        $dm = $dda * 12 + $ddm;

        $n = $fm - $dm;

        return $n;
    }

    function getNbMoisDe($datation) {

        $n = $this->getDelaiMoisDe($datation);

        return $n + 1;
    }

    function getDureeFormateeDe($datation) {
        $d = $datation->getDate();
        $delai = $this->datation->diff($d);
        $s = $delai->format('%H:%I:%S');
        return $s;
    }

    function getDureeDe($datation) {
        return $this->getDate()->format('U') - $datation->getDate()->format('U');
    }

    function getDureeMinutesDe($datation) {
        return (int) ($this->getDureeDe($datation) / 60);
    }

    function getDureeDemiJourneeDe($datation) {
        return $this->getDureeDe($datation) / 14400;
    }

    /**
     * Calcule le nombre de jours écoulés de puis la date jusqu'à aujourd'hui
     * @return int 
     */
    function getDelaiDeAujourdHui() {
        $d = new LIB_Datation();
        return $this->getDelaiDe($d);
    }

    public function isEgaleASaufJour($d) {
        if ($d == NULL) {
            return TRUE;
        }
        if ($this->getDate_AA_MM() == $d->getDate_AA_MM()) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Renvoie si la date est = à la date passée en paramètre.
     * Ne compre que le jour, l'heure n'est pas comparée.
     * @param LIB_Datation $d
     * @return boolean vrai si dates égales
     */
    public function isEgaleJour($d) {
        if ($d == NULL) {
            return TRUE;
        }
        if ($this->getDate_DD_MM_AAAA() == $d->getDate_DD_MM_AAAA()) {
            return TRUE;
        }
        return FALSE;
    }

    public function isInferieureOuEgaleASaufJour($d) {
        if ($d == NULL) {
            return TRUE;
        }
        if ($this->getDate_AA_MM() <= $d->getDate_AA_MM()) {
            return TRUE;
        }
        return FALSE;
    }

    public function isSuperieureOuEgaleASaufJour($d) {
        if ($d == NULL) {
            return TRUE;
        }
        if ($this->getDate_AA_MM() >= $d->getDate_AA_MM()) {
            return TRUE;
        }
        return FALSE;
    }

    public function isInferieureASaufJour($d) {
        if ($d == NULL) {
            return TRUE;
        }
        if ($this->getDate_AA_MM() < $d->getDate_AA_MM()) {
            return TRUE;
        }
        return FALSE;
    }

    public function isSuperieureASaufJour($d) {
        if ($d == NULL) {
            return TRUE;
        }
        if ($this->getDate_AA_MM() > $d->getDate_AA_MM()) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Teste si la date est <= à la date passée en paramètre
     * @param LIB_Datation $d Date à comparer
     * @return boolean Vrai si la date est inférieure
     */
    public function isInferieureOuEgaleA($d) {
        if ($d == NULL) {
            return TRUE;
        }
        if ($this->getDate() <= $d->getDate()) {
            return TRUE;
        }
        return FALSE;
    }

    public function isInferieureA($d) {
        if ($d == NULL) {
            return TRUE;
        }
        if ($this->getDate() < $d->getDate()) {
            return TRUE;
        }
        return FALSE;
    }

    public function isSuperieureA($d) {
        if ($d == NULL) {
            return TRUE;
        }
        if ($this->getDate() > $d->getDate()) {
            return TRUE;
        }
        return FALSE;
    }

    public function isEgaleA($d) {
        if ($d == NULL) {
            return TRUE;
        }
        if ($this->getDate() == $d->getDate()) {
            return TRUE;
        }
        return FALSE;
    }

    public function isSuperieureOuEgaleA($d) {
        if ($d == NULL) {
            return TRUE;
        }
        if ($this->getDate() >= $d->getDate()) {
            return TRUE;
        }
        return FALSE;
    }

    public function isCompriseEntre($dd, $df) {
        if ($df == NULL) {
            return $this->isSuperieureOuEgaleA($dd);
        }
        if ($this->isSuperieureOuEgaleA($dd) && $this->isInferieureOuEgaleA($df)) {
            return TRUE;
        }
        return FALSE;
    }

    public function isAhui() {
        $d = new LIB_Datation();

        if ($d->isEgaleA($this)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function __toString() {
        return $this->getDate_DD_MM_AAAA();
    }

    public function getValeurPourExcel() {
        return $this->getDate_pourExportExcel();
    }

    static function DelaiJaune() {
        return 2;
    }

    static function DelaiRouge() {
        return 6;
    }

    public static function convertitSecondesVersHHMMSS($s) {
        $hh = floor($s / 3600);
        $reste = $s % 3600;
        $mm = floor($reste / 60);
        $ss = $reste % 60;

        return sprintf('%1dh%02dmn%02ds', $hh, $mm, $ss);
    }

    public static function getDureeUtilisationMaterielParDefaut() {
        return 14400;
    }

    public static function getDureeDemiJournee() {
        return 14400;
    }

    public static function getFiltreDateIntervalle_MySQL($dateDebut, $dateFin) {
        $dd = clone $dateDebut;
        $df = clone $dateFin;
        $sdd = $dd->getDate_pourEcritureMySQL();
        $sdf = $df->getDate_pourEcritureMySQL();

        return "BETWEEN '$sdd' AND '$sdf'";
    }

    public static function getFiltreDateIntervalleMoisComplet_MySQL($dateDebut, $dateFin) {
        $dd = clone $dateDebut;
        $df = clone $dateFin;

        $dd->passeAuPremierJourDuMois();
        $df->passeAuPremierJourDuMoisSuivant();

        return LIB_Datation::getFiltreDateIntervalle_MySQL($dd, $df);
    }

    /**
     * Renvoie si le format de la date est bon
     * @param type $valeur Date à tester
     * @return bool true : format est bon
     */
    public static function isFormatDateFrOk($valeur) {
        $test = preg_match("@^(\d\d)[-\/ ](\d\d)[-\/ ](\d\d\d\d)$@i", $valeur,$tab);
        if (!$test) {
            return false;
        }
        
        $jour = $tab[1];
        $mois = $tab[2];
        $annee = $tab[3];
        
        if ($annee < 1900 || $annee > 2070) {
            return false;
        }
        
        if ($mois < 1 || $mois > 12) {
            return false;
        }
        
        if ($jour < 1 || $jour > 31) {
            return false;
        }
        
        switch ($mois) {
            case 2 : 
                if ($jour > (LIB_Datation::isAnneeBisextile($annee) ? 29 : 28)) {
                    return false;
                }
                break;
            case 4 : 
                if ($jour > 30) {
                    return false;
                }
                break;
            case 6 : 
                if ($jour > 30) {
                    return false;
                }
                break;
            case 9 : 
                if ($jour > 30) {
                    return false;
                }
                break;
            case 11 : 
                if ($jour > 30) {
                    return false;
                }
                break;
        }
        
        return true;
    }
    
    public static function isFormatDateEnOk($valeur) {
        $test = preg_match("@^(\d\d\d\d)[-\/ ](\d\d)[-\/ ](\d\d)@i", $valeur,$tab);
        if (!$test) {
            return false;
        }
        
        $jour = $tab[3];
        $mois = $tab[2];
        $annee = $tab[1];
        
        if ($annee < 1900 || $annee > 2070) {
            return false;
        }
        
        if ($mois < 1 || $mois > 12) {
            return false;
        }
        
        if ($jour < 1 || $jour > 31) {
            return false;
        }
        
        switch ($mois) {
            case 2 : 
                if ($jour > (LIB_Datation::isAnneeBisextile($annee) ? 29 : 28)) {
                    return false;
                }
                break;
            case 4 : 
                if ($jour > 30) {
                    return false;
                }
                break;
            case 6 : 
                if ($jour > 30) {
                    return false;
                }
                break;
            case 9 : 
                if ($jour > 30) {
                    return false;
                }
                break;
            case 11 : 
                if ($jour > 30) {
                    return false;
                }
                break;
        }
        
        return true;
    }
    
    public static function isFormatdateOk($valeur) {
        return LIB_Datation::isFormatDateEnOk($valeur) || LIB_Datation::isFormatDateFrOk($valeur);
    }
    
    /**
     * Calcule si une année est bissextile
     * @param type $annee
     * @return bool vrai : L'année est bissextile
     */
    public static function isAnneeBisextile($annee) {
        if ($annee % 100 == 0) {
            if ($annee % 400 !=0) {
                return false;
            }
        }
        
        if ($annee % 4 != 0) {
            return false;
        }
            
            
        return true;
    }
    
}

?>
