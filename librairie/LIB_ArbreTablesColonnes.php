<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of LIB_ArbreTablesColonnes
 * 
 * Conservation de l'arborescence des tables et des colonne.
 * Celle-ci,est constituée au moment de la création des objets tables.
 * Elle sert de sources pour diverses restitutions où il n'est besoin de connaître que les noms des tables et des colonnes.
 * 
 *
 * @author sylverscal
 */
class LIB_ArbreTablesColonnes {
    
    /**
     * Nom de la table dont on veut calculer la requête select du libellé
     * @var type
     */
    private $nom_table;
    
    /**
     * Composants de la partie "from" de la requête
     * @var ATC_ListePartiesDeFrom
     */
    private $parties_de_from;
    
    /**
     * Composants de la partie "join" de la requête
     * @var ATC_ListePartiesDeJoin
     */
    private $parties_de_join;
    
    /**
     * Liste des arguments passés par la méthode set pour la table
     * @var ATC_Arguments
     */
    private $arguments_methode_set;
    
    /**
     * Requête précalculée
     * @var string
     */
    private $requete;
    
    /**
     * Mémorisation de la colonne id_VoF_xxx
     * Réservé base "Théâtre" 
     * Sert à constituer l'alias de la table liée dans le join
     * @var string
     */
    private $nom_colonne_VoF;
    
    public function __construct($nom_table) {
        $this->nom_table = $nom_table;
        $this->parties_de_from = new ATC_ListePartiesDeFrom();
        $this->parties_de_join = new ATC_ListePartiesDeJoin();
        $this->arguments_methode_set = new ATC_Arguments();
        $this->requete = "-";
    }
    
    /**
     * Ajoute la partie de select.
     * -> From si colonne normale
     * -> Join si colonne table liée (id_xxxx)
     * @param type $nom_table
     * @param type $nom_colonne
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function ajoutePartie($nom_table,$nom_colonne) {
        global $DOT;
        
        // Ne pas collecter les colonnes id
        if ($nom_colonne == "id") {
            return;
        }
        
        $tab = [];
        $liste_filtres = ["/^id_(VoF)_.*/","/^id_(.+)_h_$/","/^id_(.+)$/"];
        foreach ($liste_filtres as $filtre) {
            $test = preg_match($filtre, $nom_colonne,$tab);
            if ($test === 1) {
                $this->nom_colonne_VoF = $nom_colonne;
                $this->parties_de_join->ajoute($nom_table, $nom_colonne);
                $classe = sprintf('TBL_%s', $tab[1]);
                $element = $DOT->getObjet($classe);
                $element->collecteInformationsRequeteSelectLibelle($this);
                break;
            } 
        }
        
        if ($nom_table === "VoF") {
            if (preg_match("/^id_(.*)/", $this->nom_colonne_VoF, $tab) == 1) {
                $nom_table = $tab[1];
            }
        }
        
        // Autrisation de mettre la lecture des id dans les parties de from
//        if (preg_match("/^id_(.*)/", $nom_colonne, $tab) == 0) {
            $this->parties_de_from->ajoute($nom_table, $nom_colonne);
//        }
        
        
    }
    
    /**
     * Calcule la requête et la stocke pour une utilisation future
     */
    public function calculeRequete() {
        $partie_from = $this->parties_de_from->getPartiesRequete();
        $partie_join = $this->parties_de_join->getPartiesRequete();
        
        $this->requete = sprintf("select %s from %s %s where %s.id = ",$partie_from,$this->nom_table,$partie_join,$this->nom_table);
    }
    
    /**
     * Calcule la partie select from de la requete sans la partie where qui sera 
     * ajoutée plus tard
     */
    private function getRequetePartieSelect() {
        $partie_from = $this->parties_de_from->getPartiesRequete();
        $partie_join = $this->parties_de_join->getPartiesRequete();
        
        $partie_id = sprintf(" %s.id as id , ", $this->nom_table);
        
        $requete = sprintf("select %s%s from %s %s",$partie_id,$partie_from,$this->nom_table,$partie_join,$this->nom_table);
        
        return $requete;
    }
    
    public function getRequete() {
        if ($this->requete === "-") {
            $this->calculeRequete();
        }
        
        return $this->requete;
    }
    
    /**
     * Composer la requête pour filtrer une tablebloc pour la recherche
     * de propositions pour le transfert de Achats vers Courses
     * @param type $donnees
     * Exemple :
            [donnees] => Array
                (
                    [0] => Array
                        (
                            [name] => id
                            [value] => 1293
                        )

                    [1] => Array
                        (
                            [name] => Enseigne_nom
                            [value] => Auch
                        )

                    [2] => Array
                        (
                            [name] => Ville_nom
                            [value] => Pla
                        )

                    [3] => Array
                        (
                            [name] => Ville_code_postal
                            [value] => -
                        )

                    [4] => Array
                        (
                            [name] => Commerce_localisation
                            [value] => -
                        )

                )
     * @return string requete
     * Exemple :
        select Commerce.id as Commerce_id , Enseigne.nom as Enseigne_nom , Ville.nom as Ville_nom , Ville.code_postal as Ville_code_postal , Commerce.localisation as Commerce_localisation 
        from Commerce 
        join Enseigne on Enseigne.id = Commerce.id_Enseigne join Ville on Ville.id = Commerce.id_Ville 
        where 
        (1 = 1)
        and (Ville.nom like '%ais%')
        and (Enseigne.nom like '%au%')
     * 
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function getRequetePourFiltre($donnees=[]) {
        global $DOT;
        
        $requete = sprintf("%s where (1=1) ",$this->getRequetePartieSelect());
        
        foreach ($donnees as $value) {
            $tablonne = $value['name'];
            
            if ($tablonne == "id") {
                continue;
            }

            $valeur = $value['value'];
            
            $nom_table = LIB_Util::getTableDeTablonne($tablonne);
            $nom_colonne = LIB_Util::getColonneDeTablonne($tablonne);
            
            $o = $DOT->getObjet($nom_table);
            $type = $o->getTypeColonne($nom_colonne);
            
            $tablonne_avec_point = LIB_Util::convertiTablonneEnSelect($tablonne);
            
            $partie_where = "";
            switch ($type) {
                case 'nombre':
                    if ($valeur == 0) {
                        continue;
                    }
                    $partie_where = sprintf(" and %s = '%s' ",$tablonne_avec_point,$valeur);
                case 'texte':
                    if ($valeur == "-" || $valeur == "") {
                        continue;
                    }
                    $partie_where = sprintf(" and %s like '%s%s%s' ",$tablonne_avec_point,'%',$valeur,'%');
                default:
                    continue;
            }

            
            
            $requete = sprintf("%s%s",$requete,$partie_where);

        }
        
        return $requete;
    }
    
    /**
     * Renvoie le nombre de tablonnes de la table
     * @return int
     */
    public function getNbPartiesFrom() {
        return $this->parties_de_from->getNbParties();
    }
    
    /**
     * Renvoie la liste des arguments avec leur tablonne
     * @return array Liste des arguments
     */
    public function getListeArgumentsNommes() {
        return $this->parties_de_from->getListeArguments(...func_get_args());
    }
    
    public function getExtraitListeArguments($arguments_table_mere) {
        return $this->parties_de_from->getExtraitArguments($arguments_table_mere);
    }
    
    public function getTableauArguments() {
        return $this->parties_de_from->getTableauArguments();
    }
}

class ATC_ListeParties {
    protected $liste;
    
    public function __construct() {
        $this->liste = [];
    }
    
    protected function ajoutePartie($partie) {
        $this->liste[] = $partie;
    }
    
    public function getPartiesRequete() {
        $s = "";
        
        foreach ($this->liste as $index => $partie) {
            if ($index > 0) {
                $p = $partie->getSeparateur();
                $s = sprintf("%s%s",$s,$p);
            }
            $p = $partie->getExtraitRequete();
            $s = sprintf("%s%s",$s,$p);
        }
        
        return $s;
    }
    
    public function getNbParties() {
        return count($this->liste);
    }
    
    /**
     * Renvoie la dernière partie
     * @return type Dernière partie
     */
    public function getDernierePartie() {
        return $this->liste[$this->getNbParties()-1];
    }
}

/**
 * Classe pour gérer les informations permettant de constituer la partie "from" 
 * de la requête select de libellé
 * Chaque élément de la table est un couple (Identifiant argument,valeur argument) 
 * Ex : Ville_nom , Beynes
*/
class ATC_ListePartiesDeFrom extends ATC_ListeParties {
    public function __construct() {
        parent::__construct();
    }
    
    public function ajoute($nom_table,$nom_colonne) {
        $partie = new ATC_PartieDeFrom($nom_table,$nom_colonne);
        $this->ajoutePartie($partie);
    }

    /**
     * Utilisation de cette liste pour calculer la liste des arguments reçus 
     * dans la méthode set de la table.
     * @param array Liste des arguments du "set" (invsible dans les paramètres de la fonction car à taille variable)
     * @return \ATC_Arguments Liste des arguments du set de la table courante 
     */
    public function getListeArguments() {
        $args = new ATC_Arguments();

        foreach ($this->liste as $index => $nom_argument) {
            $args->ajouteArgument($nom_argument->getIdentifiant(),func_get_arg($index));
        }

        return $args;
    }

    /**
     * Extrait les arguments de la table mère (paramètre) pour créer les arguments 
     * de la table fille (courante) en y copiant seulement ceux qui lui sont nécessaires
     * @param type $arguments
     * @return \ATC_Arguments
     */
    public function getExtraitArguments($arguments) {
        $args = new ATC_Arguments();

        foreach ($this->liste as $partie_from) {
            $args->ajouteArgument($partie_from->getIdentifiant(),$arguments->getValeur($partie_from->getIdentifiant()));
        }

        return $args;
    }
    
    /**
     * Renvoie le tableau des arguments à fournir à une méthode set.
     * @return array Tableau simple avec tous les noms des arguments au format 
     * "Table_colonne". 
     * Ex : Unite_nom , Contenant_capacite , ...
     */
    public function getTableauArguments() {
        $arguments = [];
        
        foreach ($this->liste as $argument) {
            $arguments[] = $argument->getIdentifiant();
        }
        
        return $arguments;
    }
}

class ATC_ListePartiesDeJoin extends ATC_ListeParties {

    public function __construct() {
        parent::__construct();
    }

    public function ajoute($nom_table, $nom_colonne) {
        $partie = new ATC_PartieDeJoin($nom_table, $nom_colonne);
        $this->ajoutePartie($partie);
    }
    
}

/**
 * Classe pour gérer les parties de from
 *      select from <nom_table>.<nom_colonne> as <nom_table>_<nom_colonne>
 *      Ex : Select <Achat>.<montant> as <Achat>_<montant>
 */
class ATC_PartieDeFrom {
    /**
     * Nom de la table
     */
    private $nom_table;
    
    /**
     * Nom de la colonne
     */
    private $nom_colonne;
    
    public function __construct($nom_table,$nom_colonne) {
        $this->nom_table = $nom_table;
        $this->nom_colonne = $nom_colonne;
    }

    /**
     * Renvoie la partie from d'une colonne
     * Ex : Ville.code_postal as Ville_code_postal
     * Pour les tables VoF c'est différent
     * Zx : VoF_RGPD.nom as VoF_RGBD_nom
     * @return string
     */
    public function getExtraitRequete() {
        return sprintf('%1$s.%2$s as %1$s_%2$s',$this->nom_table,$this->nom_colonne);
    }

    public function getIdentifiant() {
        return sprintf('%1$s_%2$s',$this->nom_table,$this->nom_colonne);
    }

    public function getSeparateur() {
        return " , ";
    }

}

/**
 * Classe pour gérer les parties de from
 *      join <nom_table>.<nom_colonne> = <nom_table_liee>.id
 *      Ex : <Achat>.<id_Commerce> = <Commerce>.id
 */
class ATC_PartieDeJoin {
    /**
     * Nom de la table
     */
    private $nom_table;
    
    /**
     * Nom de la table liée
     */
    private $nom_table_liee;
    
    /**
     * Nom de la colonne
     */
    private $nom_colonne;

    /**
     * Alias de la table liée.
     * Calculé à partir du nom de la colonne
     * Ex : "id_ville" -> "ville"
     * Ex : "id_VoF_tarif_interne" -> "VoF_tarif_interne"
     * @var string
     */
    private $alias_table_liee;
    
    public function __construct($nom_table, $nom_colonne) {
        $this->nom_table = $nom_table;
        $tab = [];
        $liste_filtres = ["/^id_(VoF)_.*/","/^id_(.+)_h_$/","/^id_(.+)$/"];
        foreach ($liste_filtres as $filtre) {
            if (preg_match($filtre, $nom_colonne, $tab) == 1) {
                $ntl = $tab[1];
                break;
            } 
        }
        
        $this->nom_table_liee = $ntl;
        $this->nom_colonne = $nom_colonne;
    }
    
    /**
     * Renvoie la partie de join 
     * Ex : join Domaine on Domaine.id = Famille.id_Domaine
     * Pour les tables VoF c'est différent
     * Ex : join VoF VoF_tarif_interne on VoF_tarif_interne.id = Ville.id_VoF_tarif_interne
     * @return type
     */
    public function getExtraitRequete() {
        if ($this->nom_table_liee == "VoF") {
            $tab = [];
            $test = preg_match("/^id_(.+)$/", $this->nom_colonne,$tab);
            $this->alias_table_liee = "alias_table_liee ?";
            if ($test === 1) {
                $this->alias_table_liee = $tab[1];
            }
            $s = sprintf('join %s %s on %s.id = %s.%s',$this->nom_table_liee,$this->alias_table_liee,$this->alias_table_liee,$this->nom_table,$this->nom_colonne);
        } else {
            $s = sprintf('join %s on %s.id = %s.%s',$this->nom_table_liee,$this->nom_table_liee,$this->nom_table,$this->nom_colonne);
        }
        return $s;
    }
    
    public function getSeparateur() {
        return " ";
    }
    
}

class ATC_Arguments {
    private $liste;
    
    public function __construct() {
        $this->liste = [];
    }
    
    public function ajouteArgument($nom_colonne,$valeur)  {
        $this->liste[$nom_colonne] = new ATC_Argument($nom_colonne,$valeur);
    }
    
    public function getValeur($nom_colonne) {
        return $this->liste[$nom_colonne]->getValeur();
    }

    public function getListeValeurs() {
        $tab = [];
        foreach ($this->liste as $argument) {
            $tab [] = $argument->getValeur();
        }
        return $tab;
    }
}

class ATC_Argument {
    private $nom_colonne;
    private $valeur;
    
    public function __construct($nom_colonne,$valeur) {
        $this->nom_colonne = $nom_colonne;
        $this->valeur = $valeur;
    }
    
    public function getValeur() {
        return $this->valeur;
    }
}