/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var g_recherche;

class C_Recherche {
    affiche() {
        $('#DIV_RECHERCHE').html("<h4>Op&eacuteration en cours</h4>");
        var json = {
            domaine: 'recherche',
            action: 'affiche'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_recherche.affiche_retour(html);
                    }
                }
        );
    }
    
    affiche_retour(html) {
        $('#DIV_RECHERCHE').html(html);
        g_recherche.ecoute_evenements();
    }
    
    ecoute_evenements() {
        $('#INP_RCH').on('input',function(){
            g_recherche.applique_recherche();
        });
        $('#BTN_RCH_RAZ').click(function(){
            $('#INP_RCH').val("");
            g_recherche.applique_recherche();
        });
    }
    
    applique_recherche() {
        let recherche = $("#INP_RCH").val();
        let filtrage = $("#SEL_FTR").val();

        g_liste_courses.gestion_liste.affiche_filtree(recherche,filtrage);
    }
}