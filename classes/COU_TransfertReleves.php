<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_TransfertReleves
 *
 * Classe pour gérer le transfert des relevés de Achat aux achats de Courses
 *
 * @author sylverscal
 */
class COU_TransfertReleves {
    public function affiche() {
        $style_cases_titres = "w3-padding w3-pale-yellow w3-border w3-center";
        $style_cases_titres_non_centres = "w3-padding w3-pale-yellow w3-border";
        ?>
        <div class="w3-container">
            <div class='w3-container <?php echo $style_cases_titres; ?>'>
                <h2>Transfert des relevés</h2>
            </div>
            <div class="w3-container <?php echo $style_cases_titres; ?>">
                <div class="w3-row">
                    <div class="w3-container w3-half w3-pale-blue">
                        <br>
                        <div class="w3-container">
                            <button id="BTN_TR_DEMARRAGE" class="w3-button w3-block w3-green w3-hover-light-green w3-ripple">Démarrage</button>
                        </div>
                        <br>
                        <div class="w3-container">
                            <button id="BTN_TR_ARRET" class="w3-button w3-block w3-red w3-hover-orange w3-ripple">Arrêt</button>
                        </div>
                        <hr>
                        <div class="w3-container">
                            <button id="BTN_TR_RAZ_MODAL" class="w3-button w3-block w3-yellow w3-hover-orange w3-ripple" onclick="document.getElementById('MDL_RAZ_TRANSFERT').style.display='block'">Repartir depuis le début</button>
                        </div>
                        <br>
                    </div>
                    <div class="w3-container w3-rest w3-pale-blue">
                        <div class="w3-container">
                            <label class="w3-text-yellow"><b>Nombre de transferts par salve</b></label>
                            <select id="SEL_TR_NOMBRE" class="w3-select w3-block w3-aqua" name="option">
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="5">5</option>
                              <option value="10">10</option>
                              <option value="25">25</option>
                              <option value="100">100</option>
                              <option value="1000">1000</option>
                            </select>                        
                        </div>
                        <div class="w3-container">
                            <label class="w3-text-yellow"><b>Temps entre chaque transfert</b></label>
                            <select id="SEL_TR_PERIODE" class="w3-select w3-block w3-aqua" name="option">
                              <option value="0">Aucun</option>
                              <option value="100">1/10s</option>
                              <option value="500">1/2s</option>
                              <option value="1000">1s</option>
                              <option value="5000">5s</option>
                            </select>                        
                        </div>
                        <br>
                        <div class='w3-row'>
                            <div class='w3-container w3-third'>
                                <div class="w3-container">
                                    <button id="BTN_TR_AFFICHE_A_TRANSFERER" class="w3-button w3-block w3-green w3-hover-light-green w3-ripple">A transférer</button>
                                </div>
                            </div>
                            <div class='w3-container w3-third'>
                                <div class="w3-container">
                                    <button id="BTN_TR_AFFICHE_EN_ATTENTE" class="w3-button w3-block w3-green w3-hover-light-green w3-ripple">En attente</button>
                                </div>
                            </div>
                            <div class='w3-container w3-rest'>
                                <div class="w3-container">
                                    <button id="BTN_TR_AFFICHE_REJETES" class="w3-button w3-block w3-green w3-hover-light-green w3-ripple">Rejetés</button>
                                </div>
                                
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <div class="w3-container <?php echo $style_cases_titres_non_centres; ?>">
                <div class="w3-row">
                    <div class="w3-container w3-third w3-pale-green w3-border">
                        <div class='w3-container w3-lime w3-border'>
                            <h4>Liste des relevés</h4>
                            <div id="DIV_TR_COMPTEUR"></div>
                        </div>
                        <div id="DIV_TR_LISTE_RELEVES" class="w3-container" style="overflow-y: scroll; height:1000px">
                            
                        </div>
                
                    </div>
                    <div class="w3-container w3-rest w3-pale-green w3-border">
                        <div class='w3-container w3-lime w3-border'>
                            <h4>Transfert relevé</h4>
                        </div>
                        <div id="DIV_TR_TRANSFERT" class="w3-container" style="overflow-y: scroll; height:1000px">
                            
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>
        <div class="w3-modal" id="MDL_RAZ_TRANSFERT" >
            <div class="w3-modal-content">
                <div class="w3-container w3-amber">
                    <h4 class="modal-title">Réinitialisation table transfert</h4>
                </div>
                <div class="w3-container w3-sand">
                    <H2 class="w3-red">
                        DANGER !
                    </H2>
                    <h4 class="w3-yellow w3-text-red">
                        Cette action va effacer le contenu de la table "TransfertReleves".
                        Et aussi tous les achats de la base Courses liés qui lui sont liés.
                    </h4>
                    <H3 class="w3-red">
                        Utiliser cette function seulement pendant la mise au point.
                        NE PLUS L'UTILISER UNE FOIS LA MISE EN SERVICE FAITE.
                    </H3>
                    
                </div>
                <div class="w3-container w3-amber">
                    <button class="w3-button w3-green" type="button" onclick="document.getElementById('MDL_RAZ_TRANSFERT').style.display='none'">Non</button>
                    <button id="BTN_TR_RAZ" class="w3-button w3-orange" type="button"onclick="document.getElementById('MDL_RAZ_TRANSFERT').style.display='none'">Oui</button>
                </div>
            </div>
        </div>
        <?php
    }
    
    public function afficheListeReleves($nb_releves) {
        $trs = new TR_Releve_s();
        $trs->afficheListeReleves($nb_releves);
    }
    
    public function afficheListeEnAttente($nb_releves) {
        $trs = new TR_Releve_s();
        $trs->afficheListeEnAttente($nb_releves);
    }
    
    public function afficheListeRejetes($nb_releves) {
        $trs = new TR_Releve_s();
        $trs->afficheListeRejetes($nb_releves);
    }
    
    public function afficheTransfert($id_releve,$automatique) {
        $r = new TR_Releve($id_releve);
        $r->charge();
        $a_magasin = $r->getMagasin();
        $tm = $a_magasin->getTransfert();
        $a_article = $r->getArticle();
        $ta = $a_article->getTransfert();
        $tr = new TR_TransfertReleve();
        $tr->setIdReleve($id_releve);
        $tr->prepare();
        ?>
        <div class="w3-container w3-block w3-sand w3-border">
            <h4 class='w3-blue-grey  w3-left-align'>Relevé</h4>
            <div class='w3-row'>
                <div class="w3-container w3-third w3-pale-blue">
                <h5>Id Relevé</h5>
                <p><?php echo $id_releve; ?></p>
                </div>
                <div class="w3-container w3-rest w3-pale-blue">
                <h5>Libellé</h5>
                <p><?php $r->afficheLigne(false) ?></p>
                </div>
            </div>
        </div>
        <div id='DIV_BLOC_TRANSFERT_ET_ACTION' class='w3-container'>
            <div class="w3-container w3-block w3-sand w3-border">
                <h4 class='w3-blue-grey  w3-left-align'>Transfert</h4>
                <div class="w3-container w3-block w3-sand w3-border">
                    <h4 class='w3-teal w3-left-align'>Magasin : <?php echo $tm->getEtat(); ?></h4>
                    <div class='w3-row'>
                        <div class="w3-container w3-half w3-yellow">
                        <h5>Achats</h5>
                        </div>
                        <div class="w3-container w3-rest w3-yellow">
                        <h5>Courses</h5>
                        </div>
                    </div>
                    <div class='w3-row'>
                        <div class="w3-container w3-half w3-pale-yellow">
                            <p><?php echo "Id = ".$a_magasin->getId(); ?></p>
                            <p><?php echo $a_magasin->getLibelle(); ?></p>
                        </div>
                        <div class="w3-container w3-rest w3-pale-yellow">
                            <p><?php echo "Id = ".$tm->getId(); ?></p>
                            <p><?php echo $tm->getLibelle(); ?></p>
                        </div>
                    </div>
                </div>
                <div class="w3-container w3-block w3-sand w3-border">
                    <h4 class='w3-teal w3-left-align'>Article : <?php echo $ta->getEtat(); ?></h4>
                    <div class='w3-row'>
                        <div class="w3-container w3-half w3-yellow">
                        <h5>Achats</h5>
                        </div>
                        <div class="w3-container w3-rest w3-yellow">
                        <h5>Courses</h5>
                        </div>
                    </div>
                    <div class='w3-row'>
                        <div class="w3-container w3-half w3-pale-yellow">
                            <p><?php echo "Id = ".$a_article->getId(); ?></p>
                            <p><?php echo $a_article->getLibelle(); ?></p>
                        </div>
                        <div class="w3-container w3-rest w3-pale-yellow">
                            <p><?php echo "Id = ".$ta->getId(); ?></p>
                            <p><?php echo $ta->getLibelle(); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($automatique == 0) { ?>
            <div class="w3-container w3-block w3-sand w3-border">
                <h4 class='w3-blue-grey  w3-left-align'>Actions</h4>
                    <div class="w3-container">
                        <?php $tr->afficheAction(); ?>
                    </div>
            </div>
            <?php } ?>
        </div>
        <?php
    }
    
    /**
     * Transfère automatiquement le relevé en fonction de son état.
     * Ou rejete ou met de côté.
     */
    public function transfertAutomatique($id_releve) {
        $tr = new TR_TransfertReleve();
        $tr->setIdReleve($id_releve);
        $tr->prepare();
        
        if ($tr->isATransferer()) {
            $this->transfereReleve($id_releve);
        }
        
        if ($tr->isARejeter()) {
            $this->rejeteReleve($id_releve);
        }
        
        if ($tr->isAMettreEnAttente()) {
            $this->metReleveEnAttente($id_releve);
        }
        
    }
    
    public function transfereReleve($id_releve) {
        $tr = new TR_TransfertReleve();
        $tr->setIdReleve($id_releve);
        $tr->prepare();
        $tr->renitialise();
        $crdu = $tr->transfere();
        ?>
            <h4 class='w3-blue-grey  w3-left-align'>Compte rendu tranfert</h4>
            <div class="w3-container">
                <?php
                if ($crdu->isKo()) {
                    $crdu->affiche();
                } else {
                    $tr->afficheCompteRendu();
                }
                ?>
            </div>
        <?php
    }
    
    public function rejeteReleve($id_releve) {
        $tr = new TR_TransfertReleve();
        $tr->setIdReleve($id_releve);
        $tr->prepare();
        $tr->renitialise();
        $crdu = $tr->rejete();
        ?>
            <h4 class='w3-blue-grey  w3-left-align'>Compte rendu rejet</h4>
            <div class="w3-container">
                <?php 
                if ($crdu->isOk()) {
                    ?>
                    <h5 class='w3-pale-green w3-left-align'>Rejet bien réalisé</h5>
                    <?php
                } else {
                    ?>
                    <h5 class='w3-pale-red w3-left-align'>Echec rejet</h5>
                    <?php
                    $crdu->affiche();
                }
                ?>
            </div>
        <?php
    }
    
    public function metReleveEnAttente($id_releve) {
        $tr = new TR_TransfertReleve();
        $tr->setIdReleve($id_releve);
        $tr->prepare();
        $tr->renitialise();
        $crdu = $tr->metEnAttente();
        
        ?>
            <h4 class='w3-blue-grey  w3-left-align'>Compte rendu mise en attente</h4>
            <div class="w3-container">
            </div>
                <?php 
                if ($crdu->isOk()) {
                    ?>
                    <h5 class='w3-pale-green w3-left-align'>Mise en attente bien réalisée</h5>
                    <?php
                } else {
                    ?>
                    <h5 class='w3-pale-red w3-left-align'>Echec mise en attente</h5>
                    <?php
                    $crdu->affiche();
                }
                ?> 
        <?php
    }
    
    public function reinitialise() {
        $tr = new TR_TransfertReleve_s();
        $tr->reinitialise();
        ?>
        <h1>Réinitialisation terminée</h1>
        <?php
    }
}

class TR_Releve_s extends LIB_Liste {
    /**
     * 
     */
    public function __construct() {
        parent::__construct();

    }
    
    public function afficheListeReleves($nb_releves) {
        $this->chargeListeRelevesPasEncoreTransferes($nb_releves);
        ?>
            <table id="TBL_TR_LISTE_RELEVES" class="w3-table">
                <?php
                        foreach ($this as $r) {
                            $r->afficheLigne(true);
                        }
                ?>
            </table>
        <?php
    }
    
    public function afficheListeEnAttente($nb_releves) {
        $this->chargeListeRelevesEnAttente($nb_releves);
        ?>
            <table class="w3-table">
                <?php
                        foreach ($this as $r) {
                            $r->afficheLigne(true);
                        }
                ?>
            </table>
        <?php
    }
    
    public function afficheListeRejetes($nb_releves) {
        $this->chargeListeRelevesRejetes($nb_releves);
        ?>
            <table class="w3-table">
                <?php
                        foreach ($this as $r) {
                            $r->afficheLigne(true);
                        }
                ?>
            </table>
        <?php
    }
    
    /**
     * Renvoie une liste des relevés pas encore transférés
     * @param int $nb_releves Nombre de relevés
     * Si = 0 : Tous (A éviter)
     */
    public function chargeListeRelevesPasEncoreTransferes($nb_releves) {
        global $CXO_A;

        $requete = "select 
	releve.idReleve,releve.idMagasin,releve.idArticle,date as datation,prix.montant as montant,
	TransfertReleve.id as TransfertReleve_id, TransfertReleve.is_rejete as rejete, TransfertReleve.is_en_attente as en_attente
            FROM releve 
            join prix on prix.idPrix = releve.idPrix
            left join TransfertReleve on TransfertReleve.idReleve = releve.idReleve
            where 1 = 1 
            and TransfertReleve.id is NULL 
            order by releve.idReleve
            limit $nb_releves";
        
        $rlt = $CXO_A->executeRequete($requete);
        
        $this->reset();
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $tr) {
                $r = new TR_Releve($tr);
                
                $this->ajoute($r);
                
            }
        } else {
            $rlt->affiche();
        }
    }
    
    /**
     * Renvoie une liste des relevés pas encore transférés
     * @param int $nb_releves Nombre de relevés
     * Si = 0 : Tous (A éviter)
     */
    public function chargeListeRelevesEnAttente($nb_releves) {
        global $CXO_A;

        $requete = "select 
	releve.idReleve,releve.idMagasin,releve.idArticle,date as datation,prix.montant as montant,
	TransfertReleve.id as TransfertReleve_id, TransfertReleve.is_rejete as rejete, TransfertReleve.is_en_attente as en_attente
            FROM releve 
            join prix on prix.idPrix = releve.idPrix
            left join TransfertReleve on TransfertReleve.idReleve = releve.idReleve
            where 1 = 1 
            and TransfertReleve.id is not NULL 
            and TransfertReleve.is_en_attente = 1
            order by releve.idReleve
            limit $nb_releves";
        
        LIB_Util::log($requete);
        
        $rlt = $CXO_A->executeRequete($requete);
        
        $this->reset();
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $tr) {
                $r = new TR_Releve($tr);
                
                $this->ajoute($r);
                
            }
        } else {
            $rlt->affiche();
        }
    }
    
    /**
     * Renvoie une liste des relevés pas encore transférés
     * @param int $nb_releves Nombre de relevés
     * Si = 0 : Tous (A éviter)
     */
    public function chargeListeRelevesRejetes($nb_releves) {
        global $CXO_A;
        
        $nb_releves = 1000;

        $requete = "select 
	releve.idReleve,releve.idMagasin,releve.idArticle,date as datation,prix.montant as montant,
	TransfertReleve.id as TransfertReleve_id, TransfertReleve.is_rejete as rejete, TransfertReleve.is_en_attente as en_attente
            FROM releve 
            join prix on prix.idPrix = releve.idPrix
            left join TransfertReleve on TransfertReleve.idReleve = releve.idReleve
            where 1 = 1 
            and TransfertReleve.id is not NULL 
            and TransfertReleve.is_rejete = 1
            order by releve.idReleve
            limit $nb_releves";
        
        $rlt = $CXO_A->executeRequete($requete);
        
        $this->reset();
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $tr) {
                $r = new TR_Releve($tr);
                
                $this->ajoute($r);
                
            }
        } else {
            $rlt->affiche();
        }
    }
    
    /**
     * Renvoie l'id du dernier relevé à avoir été transféré
     * @return int id du relevé
     */
    public function getDernierReleveTransfere() {
        global $CXO_A;

        $requete = "SELECT max(idReleve) as idReleve FROM TransfertReleve";
        
        $rlt = $CXO_A->executeRequete($requete);
        
        $id_releve = 0;
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $tr) {
                if (is_null($tr['idReleve'])) {
                    $id_releve = 0;
                    continue;
                }

                $id_releve = $tr['idReleve'];
            }
        } else {
            $rlt->affiche();
        }
        
        return $id_releve;
    }
    
    /**
     * Renvoie l'id du prochain relevé à transférer
     * @return int id du relevé
     */
    public function getProchainReleveATransferer() {
        global $CXO_A;

        $id_dernier_releve = $this->getDernierReleveTransfere();
        
        $requete = "select min(idReleve) as idReleve from releve where releve.idReleve > $id_dernier_releve";
        
        $rlt = $CXO_A->executeRequete($requete);
        
        $id_releve = 0;
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $tr) {
                $id_releve = $tr['idReleve'];
            }
        } else {
            $rlt->affiche();
        }
        
        return $id_releve;
    }
}

class TR_Releve {
    /**
     * 
     * @var TR_Releve
     */
    private $idReleve;
    /**
     * 
     * @var TR_Magasin
     */
    private $idMagasin;
    /**
     * 
     * @var TR_Article
     */
    private $idArticle;
    /**
     * 
     * @var LIB_Datation
     */
    private $datation;
    /**
     * 
     * @var LIB_Montant
     */
    private $montant;
    
    public function __construct($donnees = null) {
        if (is_null($donnees)) {
            $this->idReleve = 0;
            $this->idMagasin = 0;
            $this->idArticle = 0;
            $this->datation = null;
            $this->montant = null;
            return;
        }
        
        if (is_numeric($donnees)) {
            $this->idReleve = $donnees;
            $this->idMagasin = 0;
            $this->idArticle = 0;
            $this->datation = null;
            $this->montant = null;
            return;
        }
        
        $this->set($donnees);
    }
    
    private function set($donnees) {
        $this->idReleve = $donnees['idReleve'];
        $this->idMagasin = $donnees['idMagasin'];
        $this->idArticle = $donnees['idArticle'];
        $this->datation = $donnees['datation'];
        $this->montant = $donnees['montant'];
    }
    
    public function afficheLigne($avec_bouton=false) {
        $ma = new TR_Magasin($this->idMagasin);
        $a = new TR_Article($this->idArticle);
        $d = new LIB_Datation($this->datation);
        $mo = new LIB_MontantBase($this->montant);
        ?>
        <tr id="<?php echo $this->idReleve; ?>" class="TR_TR_LIGNE_RELEVE w3-amber w3-border">
            <td>
                <?php echo sprintf("%s<br>%s",$ma->getLibelle(),$a->getLibelle()); ?>
            </td>
            <td>
                <?php echo $d->getDate_pourAffichage(); ?>
            </td>
            <td>
                <?php echo $mo->get_valeur_affichage(); ?>
            </td>
        </tr>
            <?php if($avec_bouton == true) { ?>
        <tr>
            <td>
                <button id="<?php echo $this->idReleve; ?>" class="BTN_TR_TRANSFERE_AUTO">
                    <i class="fa fa-hand-o-right"></i>
                </button>                                    
            </td>
        </tr>
            <?php } ?>
        <?php
    }
    
    public function getMagasin() {
        $m = new TR_Magasin($this->idMagasin);
        return $m;
    }
    
    public function getArticle() {
        $a = new TR_Article($this->idArticle);
        return $a;
    }
    
    public function getDatationFormate() {
        $d = new LIB_Datation($this->datation);
        
        return $d->getDate_DD_MM_AAAA();
    }
    
    public function getMontantFormate() {
        return $this->montant;
    }
    
    public function charge() {
        global $CXO_A;
        
        $requete = "SELECT 
            releve.idReleve,releve.idMagasin,releve.idArticle,date as datation,prix.montant as montant 
            FROM releve 
            join prix on prix.idPrix = releve.idPrix
            where idReleve = $this->idReleve";
        
        $rlt = $CXO_A->executeRequete($requete);
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $tr) {
                $this->set($tr);
            }
        } else {
            $rlt->affiche();
        }
    }
}

class TR_Magasin {
    private $id;
    
    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getLibelle() {
        global $CXO_A;
        
        $requete = "SELECT magasin FROM Achats.magasin where idMagasin = $this->id";
        
        $rlt = $CXO_A->executeRequete($requete);
        
        $libelle = "";
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $tr) {
                $magasin = $tr['magasin'];
                
                $libelle = $magasin;
            }
        } else {
            $rlt->affiche();
        }
        
        return $libelle;
        
    }
    
    public function getTransfert() {
        $tm = new TR_TransfertMagasin();
        $tm->chercheParIdSource($this->getId());
        return $tm;
    }
}

class TR_Article {
    private $id;
    
    public function __construct($id) {
        $this->id = $id;

        }
    
    public function getId() {
        return $this->id;
    }
    
    public function getLibelle() {
        global $CXO_A;

        $requete = "SELECT 
domaine.domaine as domaine ,
marque.marque as marque ,
typeArticle.typeArticle as typeArticle , 
article.article as article ,
article.poids as poids
FROM article
join typeArticle on typeArticle.idTypeArticle = article.idTypeArticle
join domaine on domaine.idDomaine = article.idDomaine
join marque on marque.idMarque = article.idMarque where article.idArticle = $this->id";
        
        $rlt = $CXO_A->executeRequete($requete);
        
        $libelle = "";
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $tr) {
                $domaine = $tr['domaine'];
                $typeArticle = $tr['typeArticle'];
                $article = $tr['article'];
                $marque = $tr['marque'];
                $poids = $tr['poids'];
                
                $libelle = sprintf("%s<br>%s %s %s %s",$domaine,$marque,$typeArticle,$article,$poids);
            }
        } else {
            $rlt->affiche();
        }
        
        return $libelle;
        
    }
    
    public function getTransfert() {
        $tm = new TR_TransfertArticle();
        $tm->chercheParIdSource($this->getId());
        return $tm;
    }
}

class TR_TransfertReleve {
    private $id;
    private $id_releve;
    private $releve;
    private $transfert_magasin;
    private $transfert_article;
    private $is_rejete;
    private $is_en_attente;
    private $id_Achat;

    public function __construct($id = 0) {
        $this->id = $id;
        $this->is_rejete = 0;
        $this->is_en_attente = 0;
        $this->id_Achat = 0;
    }
    
    public function setIdReleve($id_releve) {
        $this->id_releve = $id_releve;
    }
    
    public function prepare() {
        if ($this->id > 0) {
            $this->charge();
        } else {
            if ($this->id_releve > 0) {
                $this->chargeParIdReleve();
            }
        }
        
        $this->releve = new TR_Releve($this->id_releve);
        $this->releve->charge();
        
        $this->transfert_magasin = new TR_TransfertMagasin();
        $this->transfert_magasin->chercheParIdSource($this->releve->getMagasin()->getId());
        $this->transfert_article = new TR_TransfertArticle();
        $this->transfert_article->chercheParIdSource($this->releve->getArticle()->getId());
    }
    
    public function afficheAction() {
        if ($this->transfert_magasin->getNiveauEtat() == 1 && $this->transfert_article->getNiveauEtat() == 1) {
            ?>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_TRANSFERE w3-button w3-block w3-green w3-hover-light-green w3-ripple">Transfert</button>
                </div>
                <br>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_REJETE w3-button w3-block w3-red w3-hover-pink w3-ripple">Rejeter</button>
                </div>
                <br>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_EN_ATTENTE w3-button w3-block w3-khaki w3-hover-lime w3-ripple">Mettre en attente</button>
                </div>
                <br>
            <?php
            return;
        }
            
        if ($this->transfert_magasin->getNiveauEtat() == -1 || $this->transfert_article->getNiveauEtat() == -1) {
            ?>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_REJETE w3-button w3-block w3-red w3-hover-pink w3-ripple">Rejeter</button>
                </div>
                <br>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_EN_ATTENTE w3-button w3-block w3-khaki w3-hover-lime w3-ripple">Mettre en attente</button>
                </div>
                <br>
            <?php
            return;
        }
        
        if ($this->transfert_magasin->getNiveauEtat() == 0 && $this->transfert_article->getNiveauEtat() == 0) {
            ?>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_EXAMEN_MAGASIN w3-button w3-block w3-blue w3-hover-cyan w3-ripple">Examen Magasin</button>
                </div>
                <br>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_EXAMEN_ARTICLE w3-button w3-block w3-blue w3-hover-cyan w3-ripple">Examen Article</button>
                </div>
                <br>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_REJETE w3-button w3-block w3-red w3-hover-pink w3-ripple">Rejeter</button>
                </div>
                <br>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_EN_ATTENTE w3-button w3-block w3-khaki w3-hover-lime w3-ripple">Mettre en attente</button>
                </div>
                <br>
            <?php
            return;
        }
            
        if ($this->transfert_magasin->getNiveauEtat() == 1 && $this->transfert_article->getNiveauEtat() == 0) {
            ?>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_EXAMEN_ARTICLE w3-button w3-block w3-blue w3-hover-cyan w3-ripple">Examen Article</button>
                </div>
                <br>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_REJETE w3-button w3-block w3-red w3-hover-pink w3-ripple">Rejeter</button>
                </div>
                <br>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_EN_ATTENTE w3-button w3-block w3-khaki w3-hover-lime w3-ripple">Mettre en attente</button>
                </div>
                <br>
            <?php
            return;
        }
            
        if ($this->transfert_magasin->getNiveauEtat() == 0 && $this->transfert_article->getNiveauEtat() == 1) {
            ?>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_EXAMEN_MAGASIN w3-button w3-block w3-blue w3-hover-cyan w3-ripple">Examen Magasin</button>
                </div>
                <br>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_REJETE w3-button w3-block w3-red w3-hover-pink w3-ripple">Rejeter</button>
                </div>
                <br>
                <div class="w3-container">
                    <button id="<?php echo $this->id_releve; ?>" class="BTN_TR_EN_ATTENTE w3-button w3-block w3-khaki w3-hover-lime w3-ripple">Mettre en attente</button>
                </div>
                <br>
            <?php
            return;
        }
            
    }
    
    /**
     * Rejetre un relevé
     * @return LIB_CompteRendu
     */
    public function rejete() {
        return $this->metEnAttenteOuRejete($this::ACTION_REJETE);
    }
    
    /**
     * Met en attente un relevé
     * @return LIB_CompteRendu
     */
    public function metEnAttente() {
        return $this->metEnAttenteOuRejete($this::ACTION_MET_EN_ATTENTE);
    }
    
    /**
     * 
     * @global LIB_BDD $CXO_A
     */
    private function metEnAttenteOuRejete($action) {
        global $CXO_A;
        $tab = 
            [
            '{idReleve}' => $this->id_releve ,
            '{libelle}' => "" ,
            '{id_Achat}' => 0,
            '{id_TransfertMagasin}' => $this->transfert_magasin->getId(),
            '{id_TransfertArticle}' => $this->transfert_article->getId(),
            '{is_rejete}' => $action == self::ACTION_REJETE ? 1 : 0,
            '{is_en_attente}' => $action == self::ACTION_MET_EN_ATTENTE ? 1 : 0
            ];
            
        $requete = strtr(
                "INSERT INTO `TransfertReleve`"
                . "(`idReleve`, `libelle`, `id_Achat`, `id_TransfertMagasin`, `id_TransfertArticle`, `is_rejete`, `is_en_attente`) "
                . "VALUES "
                . "({idReleve},'{libelle}',{id_Achat},{id_TransfertMagasin},{id_TransfertArticle},{is_rejete},{is_en_attente})", $tab);
        
        $rlt = $CXO_A->executeRequete($requete);
        
        $rlt->afficheSiKo();
        
        $crdu = $rlt->getCompteRendu();
        
        return $crdu;
    }
    
    /**
     * 
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function transfere() {
        global $DOT;
        
        $arguments = $this->getLibelleAchat();
        
        $a = $DOT->getObjet("Achat");
        
        $a->set(...$arguments);
        $crdu = $a->sauve();
        
        if ($crdu->isKo()) {
            return $crdu;
        }
        
        $this->id_Achat = $a->getId();
        
        if ($this->id_Achat == 0) {
            $crdu = new LIB_CompteRendu(false, "L'achat n'a pas été créé dans la base Course");
            return $crdu;
        }
        
        $crdu = $this->sauve();
        
        return $crdu;
        
    }
    
    /**
     * Sauve les informations du transfert dans la table TransfertRelevé
     * @return LIB_CompteRendu Compte rendu opération
     */
    private function sauve() {
        global $CXO_A;
        
        $tr = new TR_TransfertReleve();
        $tr->setIdReleve($this->id_releve);
        $tr->prepare();
        LIB_Util::logPrintR($tr);
        $tr->renitialise();
        
        $tab = 
            [
            '{idReleve}' => $this->id_releve ,
            '{libelle}' => serialize($this->getLibelleAchat()) ,
            '{id_Achat}' => $this->id_Achat,
            '{id_TransfertMagasin}' => $this->transfert_magasin->getId(),
            '{id_TransfertArticle}' => $this->transfert_article->getId(),
            '{is_rejete}' => 0,
            '{is_en_attente}' => 0
            ];
        $requete = strtr(
                "INSERT INTO `TransfertReleve`"
                . "(`idReleve`, `libelle`, `id_Achat`, `id_TransfertMagasin`, `id_TransfertArticle`, `is_rejete`, `is_en_attente`) "
                . "VALUES "
                . "({idReleve},'{libelle}',{id_Achat},{id_TransfertMagasin},{id_TransfertArticle},{is_rejete},{is_en_attente})", $tab);
        
        $rlt = $CXO_A->executeRequete($requete);
        
        $rlt->afficheSiKo();
        
        $crdu = $rlt->getCompteRendu();
        
        return $crdu;
    }
    
    
    /**
     * Compose le libellé de l'achat en fonction des données associées au relevé
     * @return tableau des arguments
     * Exemple :
    (
        [0] => Auchan
        [1] => Plaisir
        [2] => 78370
        [3] => Grand Plaisir
        [4] => Nutella 
        [5] => Ferrero
        [6] => Pâte à tartiner
        [7] => Petit déjeuner
        [8] => Alimentation
        [9] => Bocal
        [10] => Verre
        [11] => 1
        [12] => 750
        [13] => 1000
        [14] => g
        [15] => 0
        [16] => Unité
        [17] => 1
        [18] => 750
        [19] => 29-11-2012
        [20] => 405
        [21] =>         ( Commentaire )
    )
     */
    private function getLibelleAchat() {
        $tab_libelle_commerce = unserialize($this->transfert_magasin->getLibelle());
        $tab_libelle_article = unserialize($this->transfert_article->getLibelle());
        
        $tab = [];
        
        foreach ($tab_libelle_commerce as $value) {
            $tab[] = $value;
        }
        foreach ($tab_libelle_article as $value) {
            $tab[] = $value;
        }
        
        $tab[] = $this->releve->getDatationFormate();
        $tab[] = $this->releve->getMontantFormate();
        $tab[] = "";
        
        return $tab;
    }
    
    /**
     * 
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function afficheCompteRendu() {
        global $DOT;
        
        $a = $DOT->getObjet("Achat");
        $a->setId($this->id_Achat);
        $a->charge();
        
        ?>
        <div class="w3-container w3-block w3-sand w3-border">
            <h4 class='w3-blue-grey  w3-left-align'>Achat</h4>
            <div class='w3-row'>
                <div class="w3-container w3-third w3-pale-yellow">
                <h5>Id Achat</h5>
                <p><?php echo $a->getId(); ?></p>
                </div>
                <div class="w3-container w3-rest w3-pale-yellow">
                <h5>Libellé</h5>
                <p><?php echo $a->getLibelle(); ?></p>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Supprime le transfert_releve
     * @global LIB_BDD $CXO_A
     */
    public function supprime() {
        global $CXO_A;
        
        $requete = "delete from TransfertReleve where id = $this->id";
        
        LIB_Util::log($requete);
        
        $rlt = $CXO_A->executeRequete($requete);
        
        $rlt->afficheSiKo();
        
    }
    
    public function isATransferer() {
        if ($this->transfert_magasin->getNiveauEtat() == 1 && $this->transfert_article->getNiveauEtat() == 1) {
            return true;
        }
        
        return false;
    }
    
    public function isARejeter() {
        if ($this->transfert_magasin->getNiveauEtat() == -1 || $this->transfert_article->getNiveauEtat() == -1) {
            return true;
        }
        
        return false;
    }
    
    public function isAMettreEnAttente() {
        if ($this->isATransferer()) {
            return false;
        }
        
        if ($this->isARejeter()) {
            return false;
        }
        
        return true;
    }
    
    public function renitialise() {
        $this->supprimeAchat($this->id_Achat);

        $this->supprimeTransfert($this->id);
    }
    
    private function charge() {
        global $CXO_A;
        
        $requete = "select id,idReleve,id_Achat,id_TransfertMagasin,id_TransfertArticle,libelle,is_rejete,is_en_attente from TransfertReleve where id = $this->id";
                
        $rlt = $CXO_A->executeRequete($requete);
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
                $this->id = $value['id'];
                $this->id_Achat = $value['id_Achat'];
                $this->id_releve = $value['idReleve'];
                $this->id_TranfertMagasin = $value['id_TranfertMagasin'];
                $this->id_TranfertArticle = $value['id_TransfertArticle'];
                $this->libelle = $value['libelle'];
                $this->is_rejete = $value['is_rejete'];
                $this->is_en_attente = $value['is_en_attente'];
            }
        }
    }
    
    private function chargeParIdReleve() {
        global $CXO_A;
        
        $requete = "select id,idReleve,id_Achat,id_TransfertMagasin,id_TransfertArticle,libelle,is_rejete,is_en_attente from TransfertReleve where idReleve = $this->id_releve";
                
        $rlt = $CXO_A->executeRequete($requete);
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
                $this->id = $value['id'];
                $this->id_Achat = $value['id_Achat'];
                $this->id_releve = $value['idReleve'];
                $this->id_TranfertMagasin = $value['id_TranfertMagasin'];
                $this->id_TranfertArticle = $value['id_TransfertArticle'];
                $this->libelle = $value['libelle'];
                $this->is_rejete = $value['is_rejete'];
                $this->is_en_attente = $value['is_en_attente'];
            }
        }
    }
    
    /**
     * 
     * @param type $id_Achat
     * @global LIB_DistributeurObjetTable $DOT
     */
    private function supprimeAchat($id_Achat) {
        global $DOT;
        
        if ($id_Achat == 0) {
            return;
        }
        
        $a = $DOT->getObjet('Achat');
        $a->setId($id_Achat);
        $a->supprime();
    }
    
    private function supprimeTransfert($id) {
        $tr = new TR_TransfertReleve($id);
        $tr->supprime();
    }
    public const ACTION_REJETE = "rejete";
    public const ACTION_MET_EN_ATTENTE = "en_attente";
}
    
class TR_TransfertReleve_s extends LIB_Liste {
    /**
     * Réinitialise la table des relevés.
     * En même temps on supprime les achats liés à chaque transfert_relevé
     * @global LIB_BDD $CXO_A
     */
    public function reinitialise() {
        global $CXO_A;
        
        $requete = "select id,id_Achat from TransfertReleve order by id";
        
        $rlt = $CXO_A->executeRequete($requete);
        
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $value) {
                $tr = new TR_TransfertReleve($value['id']);
                $tr->prepare();
                $tr->renitialise();
                
            }
        }
    }

    /**
     * 
     * @param type $id_Achat
     * @global LIB_DistributeurObjetTable $DOT
     */
    private function supprimeAchat($id_Achat) {
        global $DOT;
        
        if ($id_Achat == 0) {
            return;
        }
        
        $a = $DOT->getObjet('Achat');
        $a->setId($id_Achat);
        $a->supprime();
    }
    
    private function supprimeTransfert($id) {
        $tr = new TR_TransfertReleve($id);
        $tr->supprime();
    }
}

class TR_TransfertTable {
    protected $nom_table;
    protected $id;
    protected $id_source;
    protected $libelle;
    
    public function __construct() {
        $this->id = 0;
        $this->id_source = 0;
        $this->libelle = "-";
    }

    public function chercheParIdSource($id_source) {
        global $CXO_A;
        
        $requete = "SELECT id,id_source,libelle FROM Transfert$this->nom_table where id_source = $id_source";

        $rlt = $CXO_A->executeRequete($requete);
                
        if ($rlt->isOk()) {
            foreach ($rlt->getResultat() as $donnees) {
                if (is_null($donnees['id'])) {
                    continue;
                }
                $this->id = $donnees['id'];
                $this->id_source = $donnees['id_source'];
                $this->libelle = $donnees['libelle'];
            }
        } else {
            $rlt->affiche();
        }
        
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getIdSource() {
        return $this->id_source;
    }
    
    public function getLibelle() {
        return $this->libelle;
    }
    
    public function getEtat() {
        if ($this->id_source == 0) {
            return "Pas traité";
        }
        
        if ($this->id_source > 0 && $this->libelle == "rejet") {
            return "Rejeté";
        }
        
        return "Transféré";
    }
    
    public function getNiveauEtat() {
        if ($this->id_source == 0) {
            return 0;
        }
        
        if ($this->id_source > 0 && $this->libelle == "rejet") {
            return -1;
        }
        
        return 1;
    }
}

class TR_TransfertMagasin extends TR_TransfertTable {
    
    public function __construct() {
        $this->nom_table = "Magasin";
        parent::__construct();
    }
    
    
}

class TR_TransfertArticle extends TR_TransfertTable {
    
    public function __construct() {
        $this->nom_table = "Article";
        parent::__construct();
    }
    
}