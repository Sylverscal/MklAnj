<?php

include_once 'LIB_Util.php';

/**
 * Description of C_Mail
 * 
 * Gestion de l'envoi par mail de la demande spécifique
 *
 * @author C320688
 */
class LIB_Mail {

    private $destinataire;
    private $expediteur;
    private $objet;
    private $corps;
    private $piecesJointes;
    private $sautDeLigne;
    private $boundary;
    private $boundary_alt;

    /**
     * Création du mail
     * Pour les adresses, soit on renseigne l'adresse seule, ex : "gasp@foo.net"
     * Ou adresse précédée du nom séparé de l'adresse par ":", ex : "Professeur Burp : gotlib@rab.net"
     * @param chaine $destinataire Adresse du destinataire 
     * @param chaine $expediteur Adresse de l'expéditeur
     * @param chaine $objet Titre du mail
     */
    public function __construct($destinataire, $expediteur, $objet) {
        $this->destinataire = $destinataire;
        $this->expediteur = $expediteur;
        $this->objet = $objet;
        $this->corps = "";
        $this->piecesJointes = array();
        $this->header = "";
        $this->sautDeLigne = "\n";
        $this->boundary = "---=" . md5(rand());
        $this->boundary_alt = "-----=" . md5(rand());
    }

    /**
     * Renseigne le corps du message
     * @param type $corps
     */
    public function setCorps($corps) {
        $this->corps = $corps;
    }

    /**
     * Ajout d'une pièce jointe
     * @param chaine $cheminPieceJointe chemin d'accès à la pièce jointe
     */
    public function setPieceJointe($pieceJointe) {
        $this->piecesJointes[] = $pieceJointe;
    }

    /**
     * Vide la liste des pièces jointes
     */
    public function razPieceJointe() {
        $this->piecesJointes = array();
    }

    /**
     * Envoi du mail
     */
    public function envoiHtml() {
        $test = mail($this->destinataire, $this->objet, $this->constitueCorps(), $this->constitueHeader());

        $erreur = '';
        if (isset($test)) {
            if ($test) {
                $l = new COU_log();
                $l->ajoute('envoi_mail', $this->expediteur, $this->destinataire, 0, $this->objet, $this->corps);
                $erreur = 'Message envoy&eacute;';
            } else {
                $errorMessage = error_get_last()['message'];
                $erreur = $errorMessage;
            }
        } else {
            $erreur = 'Envoi inhibé';
        }
        return $erreur;
    }

    /**
     * Envoi du mail
     */
    public function envoi() {
        $header = 'From: ' . $this->expediteur . $this->sautDeLigne . 'Reply-To: ' . $this->expediteur . $this->sautDeLigne . 'X-Mailer: PHP/' . phpversion() . $this->sautDeLigne . 'Content-Type: text/plain;';
        $test = mail($this->destinataire, $this->objet, $this->corps, $header);

        $erreur = '';
        if (isset($test)) {
            if ($test) {
                $l = new COU_log();
                $l->ajoute('envoi_mail', $this->expediteur, $this->destinataire, 0, $this->objet, $this->corps);
                $erreur = 'Message envoy&eacute;';
            } else {
                $errorMessage = error_get_last()['message'];
                $erreur = $errorMessage;
            }
        } else {
            $erreur = 'Envoi inhibé';
        }
        return $erreur;
    }

    /**
     * Constiture le header du mail
     */
    private function constitueHeader() {
        $headers = 'From: ' . $this->expediteur . $this->sautDeLigne;
        $headers = 'Reply-To: ' . $this->expediteur . $this->sautDeLigne;
//*       $headers .= 'Return-Path: '. $this->expediteur . $this->sautDeLigne;
        $headers .= 'MIME-Version: 1.0' . $this->sautDeLigne;
        $headers .= 'Content-Type: multipart/mixed; boundary="' . $this->boundary . '"';

        return $headers;
    }

    /**
     * Constitue le corps du mail
     */
    private function constitueCorps() {
        $message = '--' . $this->boundary . $this->sautDeLigne;
        $message .= 'Content-Type: text/html; charset="utf-8"' . $this->sautDeLigne;
        $message .= 'Content-Transfer-Encoding: 8bit' . $this->sautDeLigne . $this->sautDeLigne;
        $message .= $this->corps . $this->sautDeLigne . $this->sautDeLigne;

        $message .= $this->constituePiecesJointes();

        $message .= '--' . $this->boundary . "--" . $this->sautDeLigne;

        return $message;
    }

    private function constituePiecesJointes() {
        $message = "";

        foreach ($this->piecesJointes as $pieceJointe) {
            $type = $pieceJointe['type'];
            $nom = $pieceJointe['nom'];
            $chemin = C_Util::getDossierPiecesJointes();
            $nomComplet = "$chemin/$nom";

            $fichier = fopen($nomComplet, 'r');
            $attachement = fread($fichier, filesize($nomComplet));
            $attachement = chunk_split(base64_encode($attachement));
            fclose($fichier);

            $message .= '--' . $this->boundary . $this->sautDeLigne;
            echo "Type : $type" . '<br>';
            $message .= 'Content-Type: ' . $type . '; name="' . $nom . '"' . $this->sautDeLigne;
            $message .= 'Content-Transfer-Encoding: base64' . $this->sautDeLigne;
            $message .= 'Content-Disposition:attachement; filename="' . $nom . '"' . $this->sautDeLigne . $this->sautDeLigne;

            $message .= chunk_split(base64_encode(file_get_contents($nomComplet))) . $this->sautDeLigne;
        }

        return $message;
    }

    private function getNomDeAdresse($adresse) {
        $resultat = preg_match("@(.*):(.*)@", $adresse, $tab);
        if ($resultat === 0) {
            return $adresse;
        }

        return $tab[0];
    }

    private function getEMailDeAdresse($adresse) {
        $resultat = preg_match("@(.*):(.*)@", $adresse, $tab);
        if ($resultat === 0) {
            return $adresse;
        }

        return $tab[1];
    }

}
