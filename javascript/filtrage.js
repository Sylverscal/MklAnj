/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var g_filtrage;

class C_Filtrage {
    affiche() {
        $('#DIV_FILTRAGE').html("<h4>Op&eacuteration en cours</h4>");
        var json = {
            domaine: 'filtrage',
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
                        g_filtrage.affiche_retour(html);
                    }
                }
        );
    }
    affiche_retour(html) {
        $('#DIV_FILTRAGE').html(html);
        g_filtrage.ecoute_evenements();
    }
    
    ecoute_evenements() {
        $('#SEL_FTR').change(function(){
            g_filtrage.applique_filtrage();
        });
        $('#BTN_FTR_RAZ').click(function(){
            $('#SEL_FTR').val(0);
            g_recherche.applique_recherche();
        });
    }
    
    applique_filtrage() {
        let recherche = $("#INP_RCH").val();
        let filtrage = $("#SEL_FTR").val();
        
        g_liste_courses.gestion_liste.affiche_filtree(recherche,filtrage);
    }
}
