<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of TBL_Achat
 * 
 * Classe pour gérer des actions et comportements propres aux achats
 *
 * @author sylverscal
 */
class TBL_Course extends LIB_Table{

    public function __construct() {
        parent::__construct();
//        $this->calculeRequeteSelectLibelle();
        
    }
    
    public function affiche() {
        $id = $this->getId();
        $libelle = $this->getLibelle();
        ?>
            <tr id="<?php echo $id; ?>">
                <td>
                    <input class="w3-check" type="checkbox">
                </td>
                <td>
                    <?php echo $libelle; ?>
                </td>
                <td>
                    <button class="w3-button"><i class="fa fa-work"></i></button>
                </td>
            <?php

            ?>
            </tr>
        <?php
    }
        
}