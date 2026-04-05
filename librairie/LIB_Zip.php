<?php

/**
 * Description of LIB_Zip
 * 
 * Classe pour gérer les zip
 *
 * @author veroscal
 */
class LIB_Zip {

    /**
     * Zip
     * @var ZipArchive 
     */
    private $zip;

    /**
     * Nom du zip
     * @var string 
     */
    private $nom;

    /**
     * Racine de l'application qui envoie le zip
     * @var string
     */
    private $racine;

    /**
     * Résultat dernière opération
     * @var boolean 
     */
    private $isOk;

    /**
     * Crée un zip
     * @param string $nom Nom du zip
     */
    public function __construct($nom, $racine) {
        $this->nom = $nom;
        $this->racine = $racine;
        $this->ouvre();
    }

    /**
     * Ouvre le zip
     */
    private function ouvre() {
        $nom = $this->getNomZip();
        @unlink($nom);
        $this->zip = new ZipArchive();
        $this->isOk = $this->zip->open($nom, ZipArchive::CREATE);
    }

    /**
     * Renvoie si l'opération sur le zip a réussi
     * @return boolean
     */
    public function isOk() {
        return $this->isOk;
    }

    /**
     * Ajoute un fichier au zip
     * @param string $chemin_fichier
     */
    public function ajoute_fichier($chemin_fichier, $nom_fichier) {
        $this->isOk = $this->zip->addFile($chemin_fichier, $nom_fichier);
    }

    /**
     * Ferme le zip
     */
    public function ferme() {
        $this->isOk = $this->zip->close();
    }

    /**
     * Renvoie le status de la commande exécutée juste avant
     * @return string
     */
    public function getStatus() {
        return $this->zip->getStatusString();
    }

    /**
     * Constante : Nom du dossier zip
     * @return string
     */
    public function getDossierZip() {
        return $this->racine . '/zip';
    }

    /**
     * Renvoie le nom du fichier zip avec son chemin complet
     * @return string
     */
    public function getNomZip() {
        return $this->getDossierZip() . '/' . $this->nom;
    }

    /**
     * Renvoie l'url de téléchargement
     */
    public function telecharge($base_url) {
        $array = [];
        $array['zip'] = $base_url . "zip/$this->nom";
        echo (json_encode($array));
    }

}
