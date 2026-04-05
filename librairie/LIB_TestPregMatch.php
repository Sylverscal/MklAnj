<?php

/**
 * Description of LIB_TestPregMatch
 *
 * @author veroscal
 */
class LIB_TestPregMatch {

    public function installe() {
        ?>
        <div class="row">
            <div id="LIB_TPM_Echanges" class="col-sm-2">
                <form id="LIB_TPM_Formulaire">
                    <div class="form-group">
                        <label for="pattern">Pattern</label>
                        <input type="text" class="form-control" id="pattern" name="pattern" value="@@i">
                    </div>
                    <div class="form-group">
                        <label for="texte">Texte</label>
                        <input type="text" class="form-control" id="texte" name="texte">
                    </div> 
                    <button type="submit" id="LIB_TPM_Submit"  class="btn btn-primary btn-block">Test</button> 
                </form>
            </div>
            <div id="LIB_TPM_Resultat" class="col-sm-8">

            </div>
        </div> 
        <?php
    }

    public function test($pattern, $texte) {
        $test = preg_match($pattern, $texte, $tab);
        $tab = LIB_Util::getTrimedArray($tab);
        ?>
        <table border="1">
            <tr>
                <th>Pattern</th><th><?php echo $pattern; ?></th>
            </tr>
            <tr>
                <th>Texte</th><th><?php echo $texte; ?></th>
            </tr>
            <?php
            if ($test === 1) {
                ?>
                <tr>
                    <td colspan="2">Correspondance</td>
                </tr>
                <?php
                    foreach ($tab as $index => $valeur) {
                        ?>
                <tr>
                    <td><?php echo $index; ?></td><td><?php echo $valeur; ?></td>
                </tr>
                <?php
                    }
            } else {
                ?>
                <tr>
                    <td colspan="2">Pas de correspondance</td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }

}
