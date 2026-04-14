/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
/* global g_log_visualisation, g_liste_courses, g_graphiques */
var g_liste_courses;

class C_ListeCourses {
    constructor() {
        this.gestion_liste = new C_GestionListe();
    }
    
    affiche() {
        this.affiche();
    }
    
    affiche() {
        $('#ONG_contenu').html("<h4>Op&eacuteration en cours</h4>");
        var json = {
            domaine: 'liste_courses',
            action: 'affiche_vue_principale'
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
        $("#DIV_FONCTION_LISTE_COURSES").html(html);
        g_liste_courses.gestion_liste.affiche();
    }

}
    
class C_GestionListe {
    affiche() {
        var json = {
            domaine: 'liste_courses',
            action: 'affiche_liste_courses'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_liste_courses.gestion_liste.affiche_Retour(html);
                    }
                }
        );
    }
    
    affiche_Retour(html) {
        $("#DIV_LISTE_COURSES").html(html);
        g_liste_courses.gestion_liste.ecouteEvenements();
    }

    ecouteEvenements() {
        // Ecoute le état case à cocher "course faite"
        $('.CBX_COURSE_FAITE').change(function () {
            var id = $(this).attr('id');
            var etat = ($(this).is(':checked')) ? 1 : 0;
            
            g_liste_courses.gestion_liste.changeEtatFaite(id,etat);
        });
        // Ecoute d'un clic sur le bouton de raz du filtre
//        $('#BTN_ACH_FILTRE_RAZ').click(function(e) {
//            e.preventDefault();
//            g_achats.filtres = new C_Filtres();
//            g_achats.filtres.affiche();
//            g_achats.affiche();
//        });
    }

    changeEtatFaite(id,etat) {
        var json = {
            domaine: 'gestion_liste_courses',
            action: 'change_etat_faite',
            id: id,
            etat: etat
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'json',
                    async: 'false',
                    success: function (data) {
                    }
                }
        );
    }
    
}  
        
    
    
    
    
    
    
