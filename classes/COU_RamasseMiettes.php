<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_RamasseMiette
 * 
 * Classe pour gérer le ramasse miette
 * Suppression des éléments orphelins
 *
 * @author veroscal
 */
class COU_RamasseMiettes {
    /**
     * @global LIB_BDD_Structure $CXO_ST
     * @global LIB_DistributeurObjetTable $DOT
     */
    public function affiche() {
        global $CXO_ST;
        global $DOT;
        
        $lt = $CXO_ST->getListeNomTables();
        
        
        ?>
            <div class="w3-container w3-pale-green w3-center">
                <h1>Ramasse miettes</h1>
            </div>
            <div class="w3-container w3-pale-yellow w3-center">
                <div class="w3-row">
                    <div class="w3-container w3-third w3-yellow">
                        <div class="w3-container w3-center w3-sand">
                            <h3>Tables</h3>
                        </div>
                        <div class="w3-container w3-center w3-orange">
                            <table class="w3-table">
                                <tr>
                                    <th>Nom</th><th>Nb</th><th></th>
                                </tr>
                                    <?php   
                                        foreach ($lt as $nom_table) {
                                            $table = $DOT->getObjet_s($nom_table);
                                            $nb_orphelins = $table->getNbElementsNonLies();
                                            ?>
                                                <tr class="w3-blue">
                                                    <td class="w3-border"><?php echo $nom_table; ?></td>
                                                    <td id="<?php echo $nom_table; ?>" class="w3-border RM_NB_ORPHELINS"><?php echo $nb_orphelins; ?></td>
                                                    <td class="w3-border">
                                                        <?php if ($nb_orphelins > 0) { ?>
                                                        <button id="<?php echo $nom_table; ?>" class="BTN_RM_TABLES">
                                                            <i class="fa fa-wrench"></i>
                                                        </button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    ?>

                            </table>
                        </div>
                    </div>
                    <div class="w3-container w3-rest w3-amber">
                        <div class="w3-container w3-center w3-seal">
                            <h3>Traitement une table</h3>
                        </div>
                        <div id="DIV_RM_TRAITEMENT_TABLE" class="w3-container w3-center w3-khaki">
                        </div>
                    </div>
                </div>

            </div>
        <?php
    }
    
    public function TraiteTable($nom_table) {
        global $DOT;
        
        $o = $DOT->getObjet_s($nom_table);
        $liste_liens = $o->getElementsNonLies();
        ?>
            <div class="w3-container w3-teal w3-center">
                <h2>Traitement table : <?php echo $nom_table; ?></h2>
            </div>
            <div class="w3-container w3-light-green w3-center" style="overflow-y: scroll; height:700px">
                <table class="w3-table">
                    <?php
                        foreach ($liste_liens as $id) {
                            $elt = $DOT->getObjet($nom_table);
                            $elt->charge($id);
                            ?>
                                <tr class="w3-lime">
                                    <td>
                                        <?php echo $elt->getLibelle(); ?>
                                    </td>
                                    <td>
                                        <button id="<?php echo $id; ?>" class="BTN_RM_SUPPR_ELT">
                                            <i class="fa fa-trash"></i>
                                        </button>                                    
                                    </td>
                                </tr>
                            <?php
                        }
                    ?>
                </table>
            </div>
        <?php
    }
}

