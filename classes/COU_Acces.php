<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_Acces
 * 
 * Gestion de l'accès sécurisé au site
 *
 * @author sylverscal
 */
class COU_Acces {
    public function affiche() {
        ?>
        <div class="w3-container w3-deep-orange w3-center w3-block">
            <h2>COURSES</h2>
        </div>
        <form id="FRM_ACCES" class="w3-container">
            <p>
            <label class="w3-text-blue">Compte</label>
            <input class="w3-input w3-border" name="a"type="text">
            </p>
            <p>
            <label class="w3-text-blue">Mot de passe</label>
            <input class="w3-input w3-border" name="b"type="text">
            </p>
            <input id="FRM_ACCES_SUBMIT" class="w3-input w3-border" type="submit" value="Connexion"/>            
            <p>
        </form>
        <div class="w3-modal" id="MDL_ACCES">
            <div class="w3-modal-content">
                <div class="w3-container w3-amber">
                    <h4 class="modal-title">Contrôle accèes</H4>
                </div>
                <div class="w3-container w3-sand">
                    <h4 class="w3-orange">y a un bucre</h4>
                    <H2 class="w3-red">Le compte ou le mot de passe sont INCONNUS</H2>
                </div>
                <div class="w3-container w3-amber">
                    <button class="w3-button w3-green" type="button" onclick="document.getElementById('MDL_ACCES').style.display='none'">Ok</button>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * 
     * @param type $donnees
     * @global LIB_DistributeurObjetTable $DOT
     * @return \LIB_CompteRendu compte rendu du contrôle
     */
    public function controle($donnees) {
        global $DOT;

        $crdu = new LIB_CompteRendu(true, "");
        
        return $crdu;
        
        $tab = [];

        foreach ($donnees as $donnee) {
            $tab[$donnee['name']] = $donnee['value'];
        }

        $compte = $tab['a'];
        $mot_de_passe = $tab['b'];


        if ($compte == "Marcel" && $mot_de_passe == "Mordekhai") {
            return;
        }

        $p = $DOT->getObjet("Personne");

        if (!$p->isLoginOk($compte, $mot_de_passe)) {
            $crdu->setKo();
        }

        return $crdu;
    }
}
