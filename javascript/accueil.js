/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var g_accueil;

class C_Accueil {
    affiche() {
        $('#DIV_ACCUEIL').html("Chargement en cours");
        var json = {
            domaine: 'accueil',
            action: 'affiche'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_accueil.affiche_retour(html);
                    }
                }
        );
    }

    affiche_retour(html) {
        $('#DIV_ACCUEIL').html(html);
        g_accueil.ecoute_evenements();
    }
    
    ecoute_evenements() {
        $('#BTN_ACC_RELEVE_COURSES').click(function() {
            g_accueil.affiche_accueil_courses();
        });
        $('#BTN_ACC_RELEVE_COURSES').click(function() {
        });
    }
    
    affiche_accueil_courses() {
        $('#DIV_ACCUEIL').html("Chargement en cours");
        var json = {
            domaine: 'accueil',
            action: 'affiche_accueil_courses'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_accueil.affiche_accueil_courses_retour(html);
                    }
                }
        );
    }

    affiche_accueil_courses_retour(html) {
        $('#DIV_ACCUEIL').html(html);
        affiche_barre_navigation("COU_onglet_home");
        affiche_onglet_home();
    }
    
    ecoute_evenements_accueil_courses() {
        $('#BTN_ACC_RELEVE_COURSES').click(function() {
            affiche_barre_navigation("COU_onglet_home");
            affiche_onglet_home();
        });
    }
    
}
