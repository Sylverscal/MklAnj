<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_TransfertBase
 * 
 * Classe pour gérer le transfert de la base Achats vers la base Courses
 *
 * @author sylverscal
 */
class COU_TransfertBase {
    public static LIB_BDD $CXO_Courses;
    public static LIB_BDD $CXO_Achats;
    
    private TB_Releves $releves;
    
    public function __construct() {
        self::$CXO_Courses = new LIB_BDD(new PRM_Courses());
        self::$CXO_Achats = new LIB_BDD(new PRM_Achats());
        
    }
    
    /**
     * Affichage entête
     */
    public function affichePosteCommande() {
        ?>
            <div class="w3-container w3-khaki">
                <table class="w3-table">
                    <tr>
                        <td colspan="4" class="w3-center">
                            <div class="w3-panel w3-amber">
                              <h1 class="w3-text-yellow" style="text-shadow:1px 1px 0 #444">
                              <b>Transfert base Achats vers base Outils</b></h1>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                            <button id="BTN_ADM_TSF_RAZ" class="w3-button w3-danger w3-hover-yellow w3-hover-text-red w3-round-xlarge w3-ripple">Vidage<br>bases</button>
                        </td>
                        <td class="w3-center">
                            <button id="BTN_ADM_TSF_MAG" class="w3-button w3-block w3-blue w3-hover-aqua w3-round-large w3-ripple">Magasins</button>
                        </td>
                        <td class="w3-center">
                            <button id="BTN_ADM_TSF_ART" class="w3-button w3-block w3-blue w3-hover-aqua w3-round-large w3-ripple">Articles</button>
                        </td>
                        <td class="w3-center">
                            <button id="BTN_ADM_TSF_REL" class="w3-button w3-block w3-blue w3-hover-aqua w3-round-large w3-ripple">Relevés</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="w3-center">
                            <input id="INP_ADM_TSF_MAG" class="w3-input w3-center" type="text" readonly>
                        </td>
                        <td class="w3-center">
                            <input id="INP_ADM_TSF_ART" class="w3-input w3-center" type="text" readonly>
                        </td>
                        <td class="w3-center">
                            <input id="INP_ADM_TSF_REL" class="w3-input w3-center" type="text" readonly>
                        </td>
                    </tr>
                </table>
            </div>
        <?php
    }
    
    /**
     * Affichage de l'écran de choix de la base à vider
     */
    public function afficheVidageBase() {
        ?>
            <div class="w3-container w3-light-blue">
                <div class="w3-panel w3-blue">
                    <h2 class="w3-opacity">Vidage des bases</h2>
                </div>
                <div class="w3-panel">
                    <div class="w3-row">
                        <div class="w3-half w3-container w3-light-blue">
                            <button id="BTN_ADM_TSF_RAZ_ACH" class="w3-button w3-block w3-danger w3-hover-yellow w3-hover-text-red w3-round-xlarge w3-ripple" onclick="document.getElementById('MDL_ADM_TSF_RAZ_ACH').style.display='block'"><b>Base Achats</b><br>Vidages des équivalences<br>et des relevés transférés</button>
                        </div>
                        <div class="w3-half w3-container w3-light-blue">
                            <button id="BTN_ADM_TSF_RAZ_COU" class="w3-button w3-block w3-danger w3-hover-yellow w3-hover-text-red w3-round-xlarge w3-ripple" onclick="document.getElementById('MDL_ADM_TSF_RAZ_COU').style.display='block'"><b>Base courses</b><br>Vidage de la base</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w3-modal" id="MDL_ADM_TSF_RAZ_ACH" >
                <div class="w3-modal-content">
                    <div class="w3-container w3-amber">
                        <h4 class="modal-title">Vidage table <b>Achats</b></h4>
                    </div>
                    <div class="w3-container w3-sand">
                        <h4 class="w3-danger">
                            Voulez vous vraiment supprimer vider la table Achats</p>
                        </h4>
                    </div>
                    <div class="w3-container w3-amber">
                        <button class="w3-button w3-green" type="button" onclick="document.getElementById('MDL_ADM_TSF_RAZ_ACH').style.display='none'">Non</button>
                        <button id="BTN_ADM_TSF_RAZ_ACH_OUI" class="w3-button w3-orange" type="button"onclick="document.getElementById('MDL_ADM_TSF_RAZ_ACH').style.display='none'">Oui</button>
                    </div>
                </div>
            </div>
            <div class="w3-modal" id="MDL_ADM_TSF_RAZ_COU" >
                <div class="w3-modal-content">
                    <div class="w3-container w3-amber">
                        <h4 class="modal-title">Vidage table <b>Courses</b></h4>
                    </div>
                    <div class="w3-container w3-sand">
                        <h4 class="w3-danger">
                            Voulez vous vraiment supprimer vider la table Courses</p>
                        </h4>
                    </div>
                    <div class="w3-container w3-amber">
                        <button class="w3-button w3-green" type="button" onclick="document.getElementById('MDL_ADM_TSF_RAZ_COU').style.display='none'">Non</button>
                        <button id="BTN_ADM_TSF_RAZ_COU_OUI" class="w3-button w3-orange" type="button"onclick="document.getElementById('MDL_ADM_TSF_RAZ_COU').style.display='none'">Oui</button>
                    </div>
                </div>
            </div>
            <div id="BTN_ADM_TSF_RAZ_CRDU"></div>
        <?php
    }
    
    /**
     * Lecture des taux d'éléments transférés
     */
    public function getTauxTransfert() {
        $tab = [];
        $tab["magasins"] = $this->getTauxTransfertTableFormate("magasin", "TransfertMagasin");
        $tab["articles"] = $this->getTauxTransfertTableFormate("article", "TransfertArticle");
        $tab["releves"] = $this->getTauxTransfertTableFormate("releve", "TransfertReleve");
        return $tab;
    }
    
    /**
     * Calcule le taux de transfert d'un élément
     * @param type $table Table d'origine
     * @param type $table_comptabilise Table qui comptabilise le nombre de lignes transférées
     * @return array Renvoie un tableau qui contient : 
     * - Nb lignes table à transférer
     * - Nb lignes table qui comptabilise le nombre de lignes transférées
     * - Taux de transfert
     */
    private function getTauxTransfertTable($table,$table_comptabilise) {
        $nb_table = $this->getNbLignes($table);
        $nb_table_comptablise = $this->getNbLignes($table_comptabilise);
        $taux = $nb_table == 0 ? 0 : intdiv($nb_table_comptablise * 100, $nb_table);
        
        $tab = [];
        $tab[] = $nb_table;
        $tab[] = $nb_table_comptablise;
        $tab[] = $taux;
        
        return $tab;
    }
    
    /**
     * Calcule le taux de transfert d'un élément
     * @param type $table Table d'origine
     * @param type $table_comptabilise Table qui comptabilise le nombre de lignes transférées
     * @return string renvoie le résultat sous forme de chaîne pour être affiché 
     */
    private function getTauxTransfertTableFormate($table,$table_comptabilise) {
        $tab = $this->getTauxTransfertTable($table, $table_comptabilise);
        
        $s = sprintf ("%d / %d = %d%%",$tab[0],$tab[1],$tab[2]);
        
        return $s;
    }
    
    /**
     * Renvoie le nombre de lignes d'une table
     * @param string $table Nom de la table
     * @return int Nombre de lignes. -1 si problème
     */
    private function getNbLignes($table) {
        $requete = "select count(*) as nb from $table ";
        $ret = COU_TransfertBase::$CXO_Achats->executeRequete($requete);
        if ($ret->isOk()) {
            $lignes = $ret->getResultat();
            foreach ($lignes as $ligne) {
                $nb = $ligne['nb'];
                return $nb;
            }
        }

        return -1;
    }

    public function vidageUneBase($nom_base) : CRDU_Liste {
        switch ($nom_base) {
            case "Achats":
                $as = new TB_BaseAchats();
                $liste_crdus = $as->vide();
                return $liste_crdus;
            case "Courses":
                $cs = new TB_BaseCourses();
                $liste_crdus = $cs->vide();
                return $liste_crdus;
            default:
                $crdu = new LIB_CompteRendu(false, "La base '$nom_base' est non gérée", []);
                $liste_crdus = new CRDU_Liste();
                $liste_crdus->ajoute($crdu,"Problème");
                return $liste_crdus;
        }
    }
        
    
        
}


/*
 * Requêtes sur la base Achats
 * 
 * Requête de toutes les colonnes sur toutes les tables 
 * SELECT * FROM Achats.releve
join Achats.prix on Prix.idPrix = releve.idPrix
join Achats.article on article.idArticle = releve.idArticle
join Achats.typeArticle on typeArticle.idTypeArticle = releve.idTypeArticle
join Achats.domaine on domaine.idDomaine = releve.idDomaine
join Achats.marque on marque.idMarque = releve.idMarque
join Achats.magasin on magasin.idMagasin = releve.idMagasin
order by Achats.releve.date desc
 * 
 * Requête avec que les colonnes utiles
 * SELECT D.domaine,Mg.magasin,TA.typeArticle,Mq.marque,A.article,R.date,P.montant,A.poids FROM Achats.releve R
join Achats.prix P on P.idPrix = R.idPrix
join Achats.article A on A.idArticle = R.idArticle
join Achats.typeArticle TA on TA.idTypeArticle = R.idTypeArticle
join Achats.domaine D on D.idDomaine = R.idDomaine
join Achats.marque Mq on Mq.idMarque = R.idMarque
join Achats.magasin Mg on Mg.idMagasin = R.idMagasin
order by R.date desc
 * 
 * Requête articles
 * SELECT distinct D.domaine,TA.typeArticle,Mq.marque,A.article,A.poids FROM Achats.releve R
join Achats.article A on A.idArticle = R.idArticle
join Achats.typeArticle TA on TA.idTypeArticle = R.idTypeArticle
join Achats.domaine D on D.idDomaine = R.idDomaine
join Achats.marque Mq on Mq.idMarque = R.idMarque
 * 
 * Requête magasins
 * select distinct m.magasin from Achats.magasin m
 * 
 */

class TB_BaseAchats {
    public function vide() : CRDU_Liste {
        $liste_crdus = new CRDU_Liste();
        $liste_crdus->setTitre("Compte rendu vidage de la base 'Achats'");
        
        $rs = new TB_Releves();
        $crdu_rs = $rs->vide();
        $liste_crdus->ajoute($crdu_rs,"Relevés");
        
        $as = new TB_Articles();
        $crdu_as = $as->vide();
        $liste_crdus->ajoute($crdu_as,"Articles");
        
        $ms = new TB_Magasins();
        $crdu_ms = $ms->vide();
        $liste_crdus->ajoute($crdu_ms,"Magasins");
        
        return $liste_crdus;
    }
}

class TB_BaseCourses {
    public function vide() : CRDU_Liste {
        $liste_crdus = new CRDU_Liste();
        $liste_crdus->setTitre("Compte rendu vidage de la base 'Courses'");
        
        $liste_crdus->ajoute(new LIB_CompteRendu(true, "Fonction pas encore écrite", []), "Courses");
        $liste_crdus->ajoute(new LIB_CompteRendu(false, "Fonction pas encore écrite", []), "Foo");
        $liste_crdus->ajoute(new LIB_CompteRendu(true, "Fonction pas encore écrite", []), "Gasp");
        
        LIB_Util::logPrintR($liste_crdus);
        
        return $liste_crdus;
    }
}

/**
 * Classe pour gérer ce qui est commun aux classes 
 */
class TB_Elements {
    /**
     * Nom de la table
     * @var string
     */
    protected $nom_table;
    /**
     * Liste d'éléments chargés
     * @var array
     */
    protected $liste;
    /**
     * 
     * @var string
     */
    protected $requete;
    
    public function __construct() {
        $this->nom_table = "";
        $this->liste = [];
    }
    
    public function vide() {
        $requete = "delete from $this->nom_table where id > 0";
        $r = COU_TransfertBase::$CXO_Achats->executeRequete($requete);
        $crdu = $r->getCompteRendu();
        return $crdu;
    }
    
    public function getNb() {
        $requete = "select count(id) as nb from $this->nom_table";
        $ret = COU_TransfertBase::$CXO_Achats->executeRequete($requete);
        if ($ret->isOk()) {
            $lignes = $ret->getResultat();
            foreach ($lignes as $ligne) {
                $nb = new TB_Releve($ligne['nb']);
                return $nb;
            }
        }
        
        return -1;
    }
}
/**
 * Classe pour gérer la liste des relevés de la base Achats
 */
class TB_Releves extends TB_Elements{
    
    public function __construct() {
        $this->nom_table = "TransfertReleve";
    }
    
}

/**
 * Classe pour gérer les relevés chargés de la base Achats
 */
class TB_Releve{
    private int $id;
    private TB_Article $article;
    private TB_Magasin $magasin;
    private LIB_Datation $date;
    private LIB_Montant $montant;
    
    public function __construct(int $id) {
//        $this->id = $id;
//        
//        $this->charge();
        
    }
    
    /**
     * Charge le relevé en fonction de l'id
     */
    private function charge() {
        
        $requete = "SELECT R.idArticle as idArticle,R.idMagasin as idMagasin,R.date as date,P.montant as montant FROM Achats.releve R
            join Achats.prix P on P.idPrix = R.idPrix
            join Achats.domaine D on D.idDomaine = R.idDomaine
            where D.domaine in ('Alimentation','Voiture' and idReleve = $this->id and date > '2026-01-15')
            order by R.date desc ";
        
        $ret = COU_TransfertBase::$CXO_Achats->executeRequete($requete);
        if ($ret->isOk()) {
            $lignes = $ret->getResultat();
            foreach ($lignes as $ligne) {
                LIB_Util::logPrintR($ligne);
//                $this->article = new TB_Article($ligne['idArticle']);
//                $this->magasin = new TB_Magasin($ligne['idMagasin']);
//                $this->date = new LIB_Datation($ligne['date']);
//                $this->montant = new LIB_Montant($ligne['montant']);
            }
        }
        
    }
}

class TB_Articles extends TB_Elements{
    public function __construct() {
        $this->nom_table = "TransfertArticle";
    }
    
}

class TB_Article {
    private int $id;
    private string $domaine;
    private string $typeArticle;
    private string $marque;
    private string $article;
    private string $poids;
    
    public function __construct(int $id) {
        $this->id = $id;
        
        $this->charge();
    }
    
    /**
     * Charge le relevé en fonction de l'id
     */
    private function charge() {
        
        $requete = "SELECT distinct D.domaine as domaine,TA.typeArticle as typeArticle,Mq.marque as marque,A.article as article,A.poids as poids 
            FROM Achats.article A
            join Achats.typeArticle TA on TA.idTypeArticle = A.idTypeArticle
            join Achats.domaine D on D.idDomaine = A.idDomaine
            join Achats.marque Mq on Mq.idMarque = A.idMarque
            where domaine in ('Alimentation','Voiture') and idArticle = $this->id 
            order by domaine,typeArticle,Marque,Article";
        
        $ret = COU_TransfertBase::$CXO_Achats->executeRequete($requete);
        if ($ret->isOk()) {
            $lignes = $ret->getResultat();
            foreach ($lignes as $ligne) {
                $this->domaine = $ligne['domaine'];
                $this->typeArticle = $ligne['typeArticle'];
                $this->marque = $ligne['marque'];
                $this->article = $ligne['article'];
                $this->poids = $ligne['poids'];
            }
        }
    }
}

class TB_Magasin {
    private int $id;
    private string $magasin;

        public function __construct(int $id) {
        $this->id = $id;
        
        $this->charge();
    }
    
    /**
     * Charge le relevé en fonction de l'id
     */
    private function charge() {
        
        $requete = "select magasin from magasin where idMagasin = $this->id order by magasin";
        
        $ret = COU_TransfertBase::$CXO_Achats->executeRequete($requete);
        if ($ret->isOk()) {
            $lignes = $ret->getResultat();
            foreach ($lignes as $ligne) {
                $this->magasin = $ligne['magasin'];
            }
        }
    }
}

class TB_Magasins extends TB_Elements {
    public function __construct() {
        $this->nom_table = "TransfertMagasin";
    }
    
    
    
}

