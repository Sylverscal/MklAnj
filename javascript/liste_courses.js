/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
/* global g_log_visualisation, g_liste_courses, g_graphiques */
var g_liste_courses;

class C_ListeCourses {
    constructor() {
    }
    
    affiche() {
        this.affiche();
    }
    ecouteEvenements() {
        // Ecoute le choix dans le menu Domaine
//        $('#SEL_ACH_DOMAINE').change(function () {
//            var id = $(this).val();
//            g_achats.enregistreDomaineChoisi(id);
//        });
        // Ecoute d'un clic sur le bouton de raz du filtre
//        $('#BTN_ACH_FILTRE_RAZ').click(function(e) {
//            e.preventDefault();
//            g_achats.filtres = new C_Filtres();
//            g_achats.filtres.affiche();
//            g_achats.affiche();
//        });
    }
    
    affiche() {
        $('#ONG_contenu').html("<h4>Op&eacuteration en cours</h4>");
        var json = {
            domaine: 'liste_courses',
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
                        g_liste_courses.affiche_Retour(html);
                    }
                }
        );
    }
    
    affiche_Retour(html) {
        $("#DIV_LISTE_COURSES").html(html);
    }
}
    
        
        
    
    
    
    
    
    
