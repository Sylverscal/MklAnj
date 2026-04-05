<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_Graphiques
 * 
 * Classe pour gérer les graphiques
 *
 * @author sylverscal
 */
class COU_Graphiques {
    
    private $id_achat;
    
    private $produit;
    
    private $mode_par_article_et_magasin = false;
    
    public function __construct($id_achat) {
        $this->id_achat = $id_achat;
        
        $achat_s = new TBL_Achat_s();
        
        $this->produit = $achat_s->getProduitDeAchat($id_achat);
    }

    public function affiche() {
        ?>
        <div id="DIV_GRA" class="w3-container">
            <?php
            $this->affichePosteCommandes();
            $this->afficheGraphique();
            ?>

        </div>
        <?php
    }
    
    /**
     * Affiche le bloc des commandes de l'affichage des graphiques
     */
    public function affichePosteCommandes() {
        ?>
        <div id="DIV_GRA_POC" class="w3-container">
            <table class="w3-table">
                <tr>
                    <th colspan="2">
                        <div class="w3-panel w3-yellow">
                            <p>
                            <h3>Courbe d'évolution du prix du produit</h3>
                            </p>
                            <p >
                            <h2 class="w3-center w3-text-teal"><?php echo $this->produit->getLibelle(); ?> </h2>
                            </p>
                        </div> 
                    </th>
                </tr>
                <tr class="w3-sand">
                    <td>Id Produit</td><td><?php echo $this->produit->getId(); ?></td>
                </tr>
            </table>
        </div>
        <?php
    }
    
    /**
     * Affiche le bloc du graphique
     */
    public function afficheGraphique($mode_par_article_et_magasin = false) {
        ?>
        <div id="DIV_GRA_POC" class="w3-container">
            <a href="https://courses:8890/essais.php" target="_blank">Ouvrir page</a>;
        </div>
        <?php
        
    }
}
