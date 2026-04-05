<?php // content="text/plain; charset=utf-8"
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of COU_essais
 * 
 * Pour faire des essais d'affichages
 *
 * @author sylverscal
 */
        
class COU_onglet_essais extends COU_onglet_principal {

    
    
    /**
     * Affiche la page d'accueil
     */
    #[\Override]
    /**
     * 
     * @global LIB_BDD $CXO
     * @global LIB_BDD_Structure $CXO_ST
     * @global LIB_DistributeurObjetTable $DOT
     * @return type
     */
    final function affiche() {
        global $CXO_ST;
        global $DOT;
        
        $nom_table = "Article";
        $id = 8937;
        
        $o = $DOT->getObjet($nom_table);
        $o->charge($id);
        
        $o->supprimeIntelligemment();
        
        $id = 9669;
        
        $o = $DOT->getObjet($nom_table);
        $o->charge($id);
        //LIB_Util::printR($o);
        
        $o->supprimeIntelligemment();
        
        

        return;

        echo '---<br>';
        $m = new LIB_Montant(1099);
        echo $m->get_valeur_brute().'<br>';
        echo $m->get_valeur_affichage().'<br>';
        echo $m->get_valeur_mysql().'<br>';
        echo $m->is_montant_valide() ? "Ok" : "Ko";
        echo "<br>";
        
        echo '---<br>';
        $m = new LIB_MontantBase(1099);
        echo $m->get_valeur_brute().'<br>';
        echo $m->get_valeur_affichage().'<br>';
        echo $m->get_valeur_mysql().'<br>';
        echo $m->is_montant_valide() ? "Ok" : "Ko";
        echo "<br>";
        
        echo '---<br>';
        $m = new LIB_Montant("2,67");
        echo $m->get_valeur_brute().'<br>';
        echo $m->get_valeur_affichage().'<br>';
        echo $m->get_valeur_mysql().'<br>';
        echo $m->is_montant_valide() ? "Ok" : "Ko";
        echo "<br>";
        
        $d = new LIB_Datation();
        echo '---<br>';
        $m = new LIB_Montant("0,50€");
        echo $m->get_valeur_brute().'<br>';
        echo $m->get_valeur_affichage().'<br>';
        echo $m->get_valeur_mysql().'<br>';
        echo $m->is_montant_valide() ? "Ok" : "Ko";
        echo "<br>";
        
        $d = new LIB_Datation();
        echo '---<br>';
        $m = new LIB_Montant(1000);
        echo $m->get_valeur_brute().'<br>';
        echo $m->get_valeur_affichage().'<br>';
        echo $m->get_valeur_mysql().'<br>';
        echo $m->is_montant_valide() ? "Ok" : "Ko";
        echo "<br>";
        
        $d = new LIB_Datation();
        echo '---<br>';
        $m = new LIB_Montant("1000");
        echo $m->get_valeur_brute().'<br>';
        echo $m->get_valeur_affichage().'<br>';
        echo $m->get_valeur_mysql().'<br>';
        echo $m->is_montant_valide() ? "Ok" : "Ko";
        echo "<br>";
        
        
        $d = new LIB_Datation();
        echo '---<br>';
        $m = new LIB_Montant("10,00");
        echo $m->get_valeur_brute().'<br>';
        echo $m->get_valeur_affichage().'<br>';
        echo $m->get_valeur_mysql().'<br>';
        echo $m->is_montant_valide() ? "Ok" : "Ko";
        echo "<br>";
        
        $d = new LIB_Datation();
        echo '---<br>';
        $m = new LIB_Montant("50€");
        echo $m->get_valeur_brute().'<br>';
        echo $m->get_valeur_affichage().'<br>';
        echo $m->get_valeur_mysql().'<br>';
        echo $m->is_montant_valide() ? "Ok" : "Ko";
        echo "<br>";
        
        $d = new LIB_Datation();
        echo '---<br>';
        $m = new LIB_Montant("10,00€");
        echo $m->get_valeur_brute().'<br>';
        echo $m->get_valeur_affichage().'<br>';
        echo $m->get_valeur_mysql().'<br>';
        echo $m->is_montant_valide() ? "Ok" : "Ko";
        echo "<br>";
        
        $d = new LIB_Datation();
        echo '---<br>';
        $m = new LIB_Montant("10.00€");
        echo $m->get_valeur_brute().'<br>';
        echo $m->get_valeur_affichage().'<br>';
        echo $m->get_valeur_mysql().'<br>';
        echo $m->is_montant_valide() ? "Ok" : "Ko";
        echo "<br>";
        
        $d = new LIB_Datation();
        echo '---<br>';
        $m = new LIB_Montant();
        echo $m->get_valeur_brute().'<br>';
        echo $m->get_valeur_affichage().'<br>';
        echo $m->get_valeur_mysql().'<br>';
        echo $m->is_montant_valide() ? "Ok" : "Ko";
        echo "<br>";
        
        echo '---<br>';
        $m = new LIB_Montant(50);
        echo $m->get_valeur_brute().'<br>';
        echo $m->get_valeur_affichage().'<br>';
        echo $m->get_valeur_mysql().'<br>';
        echo $m->is_montant_valide() ? "Ok" : "Ko";
        echo "<br>";
        
        echo '---<br>';
        $m = new LIB_Montant(150);
        echo $m->get_valeur_brute().'<br>';
        echo $m->get_valeur_affichage().'<br>';
        echo $m->get_valeur_mysql().'<br>';
        echo $m->is_montant_valide() ? "Ok" : "Ko";
        echo "<br>";
        
        return;
        $v = "1000";
        $pattern = "/^(\d+)(\d{2})$/";
        $r = preg_match($pattern, $v,$tab);
        echo $pattern."<br>";
        echo $v."<br>";
        echo "'".$r."'<br>";
        print_r($tab);
        echo "<br>";
        echo "<br>";
        $v = "10,00";
        $pattern = "/^(\d+),(\d{2})$/";
        $r = preg_match($pattern, $v,$tab);
        echo $pattern."<br>";
        echo $v."<br>";
        echo "'".$r."'<br>";
        print_r($tab);
        echo "<br>";
        echo "<br>";
        $v = "10,00€";
        $pattern = "/^(\d+),(\d{2})€$/";
        $r = preg_match($pattern, $v,$tab);
        echo $pattern."<br>";
        echo $v."<br>";
        echo "'".$r."'<br>";
        print_r($tab);
        echo "<br>";
        echo "<br>";
        
        
        return;
        ?>
        <div class="w3-container">
            <div class="w3-panel ">
                <div class="w3-tag w3-xlarge w3-padding-large w3-round-large w3-border w3-light-blue w3-text-deep-orange w3-center">
                    ESSAIS POUR ESSAYER LES FONCTIONS DE W3
                    <br>
                    Editer : COU_essais.php
                </div>
            </div>
        </div>

        <div class="w3-container">

            <div class="w3-container w3-block w3-brown">
                <h2>Exemple de volets (Tabs)</h2>
            </div>

            <div class="w3-bar w3-black">
                <button class="w3-bar-item w3-button" onclick="js_exemple_tabs('ChMe')">Charleville Mézières</button>
                <button class="w3-bar-item w3-button" onclick="js_exemple_tabs('BaLeDu')">Bar le Duc</button>
                <button class="w3-bar-item w3-button" onclick="js_exemple_tabs('Na')">Nancy</button>
            </div>

            <div id="ChMe" class="city">
                <h2>Charleville Mézières</h2>
                <p>Préfecture des Ardennes</p>
            </div>

            <div id="BaLeDu" class="city" style="display: none">
                <h2>Bar le Duc</h2>
                <p>Préfecture de la Meuse</p>
            </div>

            <div id="Na" class="city" style="display: none">
                <h2>Nancy</h2>
                <p>Préfecture de la Maurthe et Moselle</p>
            </div>


            <div class="w3-container w3-brown w3-block">
                <h2>Exemple d'accordéon</h2>
            </div>


            <div class="w3-panel">
                <button onclick="js_gere_accordeon('Demo1')" class="w3-btn w3-block w3-black w3-left-align">
                    Ouvre l'accordéon
                </button>

                <div id='Demo1' class='w3-container w3-hide'>
                    <h4>Accordéon</h4>
                    <p>Vive Yvette Horner</p>
                </div>
            </div>



            <div class="w3-container w3-teal">
                <h1>C'est une entête</h1>
            </div>
            <div class="w3-panel">
                <div class="w3-card-4 w3-border">
                    <div class='w3-container'>
                        <h2>The Beatles</h2>
                        <p>Le plus grand groupe de l'histoire du rock</p>
                    </div>
                    <div class='w3-container w3-teal'>
                        <p>C'est comme ça et pas autrement</p>
                    </div>
                </div>
            </div>
            <div class='w3-container w3-red w3-text-yellow'>
                <p>Je suis un "container"</p>
            </div>
            <div class="w3-panel w3-yellow">
                <p>Je suis un panel</p>
            </div>
            <div class="w3-panel w3-warning">
                <h3>Attention !</h3>
            </div>
            <div class="w3-card-4" style="width:50%">
                <header class="w3-container w3-orange">
                    <h1>Entête</h1>
                </header>
                <div class="w3-container">
                    <p class="w3-xlarge w3-border">Un peu de bla bla</p>
                    <span class="w3-xlarge w3-border">Un peu de bla bla</span>
                </div>
                <footer class="w3-container w3-brown">
                    <h5>Ça va pêter</h5>
                </footer>
            </div>

            <table class="w3-table w3-striped w3-border">
                <tr>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Version</th>
                </tr>
                <tr>
                    <td>Fender</td>
                    <td>Stratocaster</td>
                    <td>+ deluxe</td>
                </tr>
                <tr>
                    <td>Gibson</td>
                    <td>Les Paul</td>
                    <td>Standard</td>
                </tr>
            </table>

            <div class="w3-panel w3-yellow">
                <h3>Attention !</h3>
            </div>
            <div class="w3-container w3-purple">
                <h3>Foo</h3>
            </div>

            <ul class="wr-ul">
                <li><h2>Marques de vélos</h2></li>
                <li>Santa Cruz</li>
                <li>GT</li>
                <li>Cannondale</li>
            </ul>

            <div class="w3-container">
                <h3>Boutons "w3-button"</h3>
                <input class="w3-button w3-black" type="button" value="Input Button">
                <button class="w3-button w3-black">Button Button</button>
                <a href="https://www.w3schools.com" target="_blank" class="w3-button w3-black">Link button</a>
            </div>

            <div class="w3-container">
                <h3>Boutons "w3-btn"</h3>
                <input class="w3-btn w3-black" type="button" value="Input Button">
                <button class="w3-btn w3-black">Button Button</button>
                <a href="https://www.w3schools.com" target="_blank" class="w3-btn w3-black">Link button</a>
            </div>

            <div class="w3-container">
                <button class="w3-button w3-block w3-border">Bouton</button>
            </div>

            <div class="w3-panel">
                <div class="w3-center">
                    <div class="w3-bar">
                        <button class="w3-button w3-yellow">Jaune</button>
                        <button class="w3-button w3-green">Vert</button>
                        <button class="w3-button w3-blue">Bleu</button>
                    </div>
                </div>
            </div>

            <div class="w3-panel">
                <div class="w3-bar w3-black">
                    <button class="w3-bar-item w3-button w3-ripple w3-yellow">Jaune</button>
                    <button class="w3-bar-item w3-button w3-ripple w3-green">Vert</button>
                    <button class="w3-bar-item w3-button w3-ripple w3-blue">Bleu</button>
                    <button class="w3-bar-item w3-button w3-ripple w3-red w3-text-yellow w3-right w3-hover-yellow w3-hover-text-red">Rouge</button>
                </div>
            </div>

            <div class="w3-panel">
                <span class="w3-tag w3-red" style="transform:rotate(+45deg)">Foo</span>
            </div>

            <div class="w3-container">
                <div class="w3-flex" style="gap:8px;flex-direction:row;flex-wrap:wrap">
                    <?php
                    for ($i = 1; $i <= 100; $i++) {
                        ?>
                        <div class="w3-yellow"><?php echo $i; ?></div>
                        <?php
                    }
                    ?>
                </div>
            </div>

        </div>

        <script>
            function js_gere_accordeon(id) {
                var x = document.getElementById(id);
                if (x.className.indexOf("w3-show") === -1) {
                    x.className += " w3-show";
                } else {
                    x.className = x.className.replace(" w3-show", "");
                }
            }

            function js_exemple_tabs(cityName) {
                var i;
                var x = document.getElementsByClassName("city");
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                document.getElementById(cityName).style.display = "block";
            }
        </script>


        <?php
    }
}
