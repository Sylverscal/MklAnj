<?php

class LIB_Util {

    static $i;

    static function crlf() {
        return "\r\n";
    }

    static function EOL() {
        return '<br>';
    }

    static function trace($s) {
        echo ($s == NULL ? 'NULL' : $s) . LIB_Util::EOL();
    }

    /**
     * Enregistre un texte dans le fichier de log
     * @param type $s Texte à enregistrer
     * @param type $raz Si TRUE : Efface le fichier de log avant d'enregistrer le texte
     */
    static function log($s, $raz = FALSE) {
        LIB_Util::$i = 0;
        $d = new LIB_Datation();
        
        $lieu = LIB_Util::localise_trace();

        $log = $d->getDateTime_pourAffichage() . ' : ' . $lieu . ' : ' . $s . "\r\n";

        $f = (new CLA_inclusions())->getRacine() . '/log/Log.txt';

        if ($raz == TRUE) {
            if (file_exists($f)) {
                unlink($f);
            }
        }

        $fp = fopen($f, 'a+');
        fseek($fp, SEEK_END);
        fputs($fp, $log);
        fclose($fp);
    }

    /**
     * Ecrit dans log le contenu d'une variable complexe
     * @param type $v Variable
     * @param type $s Texte de commentaire à écrire dans le log avant le contenu de la variable
     */
    static public function logPrintR($v, $s = NULL) {
        if ($v != NULL) {
            LIB_Util::log($s);
        }
        LIB_Util::log(print_r($v, TRUE));
    }

    /**
     * Variante de logPrintR à utiliser dans "localise_trace" pour voir le résultat brut de debug_backtrace
     * @param type $tab Variable à enregistrer dans log
     */
    static function logPrintR_special_localise_trace($tab) {
        LIB_Util::$i = 0;
        $d = new LIB_Datation();

        $lieu = "----";
        
        $s = print_r($tab,TRUE);

        $log = $d->getDateTime_pourAffichage() . ' : ' . $lieu . ' : ' . $s . "\r\n";

        $f = (new COU_inclusions())->getRacine() . '/log/Log.txt';

        $fp = fopen($f, 'a+');
        fseek($fp, SEEK_END);
        fputs($fp, $log);
        fclose($fp);
    }


    
    static public function logVarDump($v, $s = NULL) {
        if ($v != NULL) {
            LIB_Util::log($s);
        }
        ob_start();
        var_dump($v);
        $s = ob_get_contents();
        ob_end_clean();
        LIB_Util::log($s);
    }

    static public function logVarExport($v, $s = NULL) {
        if ($v != NULL) {
            LIB_Util::log($s);
        }
        ob_start();
        var_export($v);
        $s = ob_get_contents();
        ob_end_clean();
        LIB_Util::log($s);
    }

    static public function getVarExport($v) {
        ob_start();
        var_export($v);
        $s = ob_get_contents();
        ob_end_clean();
        return $s;
    }

    static public function getType($variable) {
        $s = gettype($variable);

        switch ($s) {
            case 'object':
                $s = get_class($variable);
                break;

            default:
        }

        return $s;
    }

    static public function getDossierRacine() {
        $s = $_SERVER['DOCUMENT_ROOT'];
        if (file_exists($s))
            return $s;
        $s = "C:/wamp64/www";
        if (file_exists($s))
            return $s;
        $s = "C:/User/serveur/www";
        if (file_exists($s))
            return $s;
        $s = "/Users/veroscal/Programmation/www";
        if (file_exists($s))
            return $s;
    }

    static function varDump($v) {
        echo('<pre>');
        var_dump($v);
        echo('</pre>');
        LIB_Util::EOL();
    }

    static function printR($v) {
        echo('<pre>');
        LIB_Util::trace('--------------------------------------');
        print_r($v);
        echo('</pre>');
        LIB_Util::EOL();
    }

    static function formateChainePourSQL($chaine) {
        $s = str_replace("'", "''", $chaine);
        return $s;
    }

    static function formateChaineDeSQL($content) {
        return trim($content);
    }

    static function getHostPatron() {
        return ('B888764.inetpsa.com');
    }

    static function isHostDuPatron() {
        $h1 = LIB_Util::getHostPatron();
        $h2 = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        if ($h1 == $h2) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    static function nomDuMois($numMois) {
        $nomsMois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        $nomMois = $nomsMois[$numMois - 1];
        return $nomMois;
    }

    static function estUtilisateurHumain($identifiant) {
        if (strlen($identifiant) != 7) {
            return FALSE;
        }

        $i = 2;

        while ($i < 7) {
            if (!is_numeric(substr($identifiant, $i, 1))) {
                return FALSE;
            }
            $i++;
        }
        return TRUE;
    }

    static function echoJsonOk() {
        $array = ['resultat' => 'OK'];
        echo json_encode(new LIB_ArrayValue($array), JSON_PRETTY_PRINT);
    }

    /**
     * Supprime toutes éléments vides d'un tableau.
     * Créé pour purger les tableau renvoyés par preg_match.
     * @param array $array Tableau à nettoyer
     * @return array Tableau nettoyé
     */
    public static function getTrimedArray($array) {
        $tab = [];

        foreach ($array as $element) {
            if ($element != '') {
                $tab[] = $element;
            }
        }

        return $tab;
    }
    
    /**
     * Renvoie la localisation d'une trace dans le programme
     * @return Chaîne sous la forme : Nom fichier -> Classe -> Fonction -> Numéro de ligne
     * Ex : 
     */
    public static function localise_trace()
    {
        $tab = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        
        $dim_tab = count($tab);
        
        //LIB_Util::logPrintR_special_localise_trace($tab);

        if ($dim_tab == 0){
            return "Tableau retourné par debug_backtrace vide";
        }
        
        $fichier =  "?";
        $ligne =  "?";
        $fonction =  "?";
        $classe =  "?";

        for ($i = 0;$i < $dim_tab && $fichier == "?";$i++){
            $nom =  $tab[$i]['class'];
            if ($nom != "LIB_Util"){
                $fichier = $nom;
                $ligne =  $tab[$i]['line'];
                $fonction =  $tab[$i]["function"];
                $classe =  $tab[$i]["class"];
            }
        }
            
        $tab_chaine_nom_fichier = explode('/', $fichier);
        $nom_fichier = $tab_chaine_nom_fichier[count($tab_chaine_nom_fichier)-1];
        
        $format = "%s -> %s -> %s -> %d";
        $localisation = sprintf($format,$nom_fichier,$classe,$fonction,$ligne);
        
        return $localisation;
    }
    
    public static function getClasseCourante() {
        $tab = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        
        $dim_tab = count($tab);
        
        //LIB_Util::logPrintR_special_localise_trace($tab);

        if ($dim_tab == 0){
            return "Tableau retourné par debug_backtrace vide";
        }
        
        $fichier =  "?";
        $ligne =  "?";
        $fonction =  "?";
        $classe =  "?";

        for ($i = 0;$i < $dim_tab && $fichier == "?";$i++){
            $nom =  $tab[$i]['class'];
            if ($nom != "LIB_Util"){
                $fichier = $nom;
                $ligne =  $tab[$i]['line'];
                $fonction =  $tab[$i]["function"];
                $classe =  $tab[$i]["class"];
            }
        }
            
        return $classe;
    }
    
    /**
     * Jsonise une variable et la transmet.
     * A utiliser dans une fonction Ajax avant le retour d'une donnée vers la surface
     * @param type $variable
     */
    public static function jsonise($variable) {
        $json = json_encode($variable);
        echo $json;
    }

// © Jérome Réaux : http://j-reaux.developpez.com - http://www.jerome-reaux-creations.fr
// ---------------------------------------------------
// Fonction de REDIMENSIONNEMENT physique "PROPORTIONNEL" et Enregistrement
// ---------------------------------------------------
// retourne : true si le redimensionnement et l'enregistrement ont bien eu lieu, sinon false
// ---------------------
// La FONCTION : fctredimimage ($W_max, $H_max, $rep_Dst, $img_Dst, $rep_Src, $img_Src)
// Les paramètres :
// - $W_max : LARGEUR maxi finale --> ou 0
// - $H_max : HAUTEUR maxi finale --> ou 0
// - $rep_Dst : repertoire de l'image de Destination (déprotégé) --> ou '' (même répertoire)
// - $img_Dst : NOM de l'image de Destination --> ou '' (même nom que l'image Source)
// - $rep_Src : repertoire de l'image Source (déprotégé)
// - $img_Src : NOM de l'image Source
// ---------------------
// 3 options :
// A- si $W_max!=0 et $H_max!=0 : a LARGEUR maxi ET HAUTEUR maxi fixes
// B- si $H_max!=0 et $W_max==0 : image finale a HAUTEUR maxi fixe (largeur auto)
// C- si $W_max==0 et $H_max!=0 : image finale a LARGEUR maxi fixe (hauteur auto)
// Si l'image Source est plus petite que les dimensions indiquées : PAS de redimensionnement.
// ---------------------
// $rep_Dst : il faut s'assurer que les droits en écriture ont été donnés au dossier (chmod)
// - si $rep_Dst = ''   : $rep_Dst = $rep_Src (même répertoire que l'image Source)
// - si $img_Dst = '' : $img_Dst = $img_Src (même nom que l'image Source)
// - si $rep_Dst='' ET $img_Dst='' : on ecrase (remplace) l'image source !
// ---------------------
// NB : $img_Dst et $img_Src doivent avoir la meme extension (meme type mime) !
// Extensions acceptées (traitees ici) : .jpg , .jpeg , .png
// Pour Ajouter d autres extensions : voir la bibliotheque GD ou ImageMagick
// (GD) NE fonctionne PAS avec les GIF ANIMES ou a fond transparent !
// ---------------------
// UTILISATION (exemple) :
// $redimOK = fctredimimage(120,80,'reppicto/','monpicto.jpg','repimage/','monimage.jpg');
// if ($redimOK==true) { echo 'Redimensionnement OK !';  }
// ---------------------------------------------------
    public static function fctredimimage($W_max, $H_max, $rep_Dst, $img_Dst, $rep_Src, $img_Src) {
        $condition = 0;
        // Si certains paramètres ont pour valeur '' :
        if ($rep_Dst == '') {
            $rep_Dst = $rep_Src;
        } // (même répertoire)
        if ($img_Dst == '') {
            $img_Dst = $img_Src;
        } // (même nom)
        // ---------------------
        // si le fichier existe dans le répertoire, on continue...
        if (file_exists("$rep_Src/$img_Src") && ($W_max != 0 || $H_max != 0)) {
            // ----------------------
            // extensions acceptées : 
            $extension_Allowed = 'jpg,jpeg,png'; // (sans espaces)
            // extension fichier Source
            $extension_Src = strtolower(pathinfo($img_Src, PATHINFO_EXTENSION));
            // ----------------------
            // extension OK ? on continue ...
            if (in_array($extension_Src, explode(',', $extension_Allowed))) {
                // ------------------------
                // récupération des dimensions de l'image Src
                $img_size = getimagesize("$rep_Src/$img_Src");
                $W_Src = $img_size[0]; // largeur
                $H_Src = $img_size[1]; // hauteur
                // ------------------------
                // condition de redimensionnement et dimensions de l'image finale
                // ------------------------
                // A- LARGEUR ET HAUTEUR maxi fixes
                if ($W_max != 0 && $H_max != 0) {
                    $ratiox = $W_Src / $W_max; // ratio en largeur
                    $ratioy = $H_Src / $H_max; // ratio en hauteur
                    $ratio = max($ratiox, $ratioy); // le plus grand
                    $W = $W_Src / $ratio;
                    $H = $H_Src / $ratio;
                    $condition = ($W_Src > $W) || ($W_Src > $H); // 1 si vrai (true)
                }
                // ------------------------
                // B- HAUTEUR maxi fixe
                if ($W_max == 0 && $H_max != 0) {
                    $H = $H_max;
                    $W = $H * ($W_Src / $H_Src);
                    $condition = ($H_Src > $H_max); // 1 si vrai (true)
                }
                // ------------------------
                // C- LARGEUR maxi fixe
                if ($W_max != 0 && $H_max == 0) {
                    $W = $W_max;
                    $H = $W * ($H_Src / $W_Src);
                    $condition = ($W_Src > $W_max); // 1 si vrai (true)
                }
                // ---------------------------------------------
                // REDIMENSIONNEMENT si la condition est vraie
                // ---------------------------------------------
                // - Si l'image Source est plus petite que les dimensions indiquées :
                // Par defaut : PAS de redimensionnement.
                // - Mais on peut "forcer" le redimensionnement en ajoutant ici :
                // $condition = 1; (risque de perte de qualité)
                if ($condition == 1) {
                    // ---------------------
                    // creation de la ressource-image "Src" en fonction de l extension
                    switch ($extension_Src) {
                        case 'jpg':
                        case 'jpeg':
                            $Ress_Src = imagecreatefromjpeg("$rep_Src/$img_Src");
                            break;
                        case 'png':
                            $Ress_Src = imagecreatefrompng("$rep_Src/$img_Src");
                            break;
                    }
                    // ---------------------
                    // creation d une ressource-image "Dst" aux dimensions finales
                    // fond noir (par defaut)
                    switch ($extension_Src) {
                        case 'jpg':
                        case 'jpeg':
                            $Ress_Dst = imagecreatetruecolor($W, $H);
                            break;
                        case 'png':
                            $Ress_Dst = imagecreatetruecolor($W, $H);
                            // fond transparent (pour les png avec transparence)
                            imagesavealpha($Ress_Dst, true);
                            $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
                            imagefill($Ress_Dst, 0, 0, $trans_color);
                            break;
                    }
                    // ---------------------
                    // REDIMENSIONNEMENT (copie, redimensionne, re-echantillonne)
                    imagecopyresampled($Ress_Dst, $Ress_Src, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src);
                    // ---------------------
                    // ENREGISTREMENT dans le repertoire (avec la fonction appropriee)
                    switch ($extension_Src) {
                        case 'jpg':
                        case 'jpeg':
                            imagejpeg($Ress_Dst, "$rep_Dst/$img_Dst");
                            break;
                        case 'png':
                            imagepng($Ress_Dst, "$rep_Dst/$img_Dst");
                            break;
                    }
                    // ------------------------
                    // liberation des ressources-image
                    imagedestroy($Ress_Src);
                    imagedestroy($Ress_Dst);
                }
                // ------------------------
            }
        }
        // ---------------------------------------------------
        // retourne : true si le redimensionnement et l'enregistrement ont bien eu lieu, sinon false
        if ($condition == 1 && file_exists("$rep_Dst/$img_Dst")) {
            return true;
        } else {
            return false;
        }
        // ---------------------------------------------------
    }
    
    public static function isExisteFichierClasseTable($nom_table) {
        $chemin = sprintf("%s/tables/TBL_%s.php", LIB_Util::getDossierRacine(),$nom_table);
        
        return file_exists($chemin);
    }
    
    /**
     * Convertit un tablonne en partie de select
     * Ex :
     * Achat_montant -> Achat.montant
     * @param string $tablone Tablone
     * @return string partie de select
     */
    public static function convertiTablonneEnSelect ($tablonne) {
        $tab = explode("_", $tablonne, 2);

        $pds = $tablonne;
        if (count($tab)==2) {
            $pds = sprintf("%s.%s",$tab[0],$tab[1]);
        }
        
        return $pds;
    }

    /**
     * Renvoie la partie table d'un tablonne
     * Ex = Achat_montant -> Achat
     * @param string $tablonne
     * @return string
     */
    public static function getTableDeTablonne($tablonne) {
        $tab = explode("_", $tablonne, 2);

        $nom_table = $tablonne;
        if (count($tab)==2) {
            $nom_table = $tab[0];
        }
        
        return $nom_table;
    }

    /**
     * Renvoie la partie table d'un tablonne
     * Ex = Achat_montant -> Achat
     * @param string $tablonne
     * @return string
     */
    public static function getColonneDeTablonne($tablonne) {
        $tab = explode("_", $tablonne, 2);

        $nom_colonne = $tablonne;
        if (count($tab)==2) {
            $nom_colonne = $tab[1];
        }
        
        return $nom_colonne;
    }
    
    /**
     * Convertit le tableau reçu par POST au travers d'ajax 
     * en un tableau plus facile à utiliser.
     * Exemple données reçues :
    [donnees] => Array
        (
            [0] => Array
                (
                    [name] => id
                    [value] => 2
                )

            [1] => Array
                (
                    [name] => Article_nom
                    [value] => Croûtons Nature
                )

            [2] => Array
                (
                    [name] => Marque_nom
                    [value] => -
                )

            [3] => Array
                (
                    [name] => Commerce_nom
                    [value] => G20
                )
        )
     * Tableau renvoyé :
    Array
        (
            [id] => 2
            [Article_nom] = Croûtons Nature
            [Marque_nom] = -
            [Commerce_nom] = G20
        )

     * @param array $donnees Données reçues du formulaire
     * @return array Tableau converti
     */
    public static function getTableauDeDonneesFormulaire($donnees) {
        $tab = [];
        
        foreach ($donnees as $value) {
            $tab[$value['name']] = $value['value'];
        }
        
        return $tab;
    }
}
