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
    constructor () {
        this.id_selectionne = 0;
    }
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
            g_liste_courses.gestion_liste.majCouleurLignes();
       
        // Ecoute le état case à cocher "course faite"
        $('.CBX_COURSE_FAITE').change(function () {
            var th = $(this).closest("tr");
            var id = $(th).attr(('id'));
            var etat = ($(this).is(':checked')) ? 1 : 0;
            
            g_liste_courses.gestion_liste.changeEtatFaite(id,etat);
        });
        // Ecoute d'un clic sur le bouton de raz du filtre
        $('.BTN_FORMULAIRE').click(function() {
            var th = $(this).closest("tr");
            var id = $(th).attr('id');
            g_liste_courses.gestion_liste.affiche_formulaire(id);
        });
        $('.TD_COURSE').click(function() {
            var th = $(this).closest("tr");
            var id = $(th).attr('id');
            g_liste_courses.gestion_liste.id_selectionne = id;
            g_liste_courses.gestion_liste.majCouleurLignes();
        });
    }
    
    /**
     * Met à jour la couleur des ligns en fonction de celle qui est sélectionnée 
     * 
     */
    majCouleurLignes() {
        $("#TBL_LISTE_COURSES tr").each(function(index){
            var id = $(this).attr('id');
            
            if (id === g_liste_courses.gestion_liste.id_selectionne) {
                $(this).css('background-color','lightblue');
            } else {
                if (index % 2 === 0) {
                    $(this).css('background-color','white');
                } else {
                    $(this).css('background-color','lightgrey');
                    
                }
            }
                
                
        });
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
    
    affiche_formulaire(id) {
        var json = {
            domaine: 'gestion_liste_courses',
            action: 'affiche_formulaire',
            id: id
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_liste_courses.gestion_liste.affiche_formulaire_retour(html);
                    }
                }
        );
    }
    
    affiche_formulaire_retour(html) {
        $("#DIV_FONCTION_LISTE_COURSES").html(html);
        g_liste_courses.gestion_liste.ecouteEvenementsFormulaire(html);
    }
    
    ecouteEvenementsFormulaire() {
        $('#BTN_FRM_VALIDER').on( "click", function( e ){
            e.preventDefault();
            if (g_liste_courses.gestion_liste.isChampsNombresValides() === false) {
                return;
            }
            if (g_liste_courses.gestion_liste.isChampsDatationsValides() === false) {
                return;
            }
            
            var donnees = $('#FRM_COURSE').serializeArray();
            g_liste_courses.gestion_liste.valideFormulaire(donnees);
        });
        $('#BTN_FRM_ANNULER').on( "click", function( e ){
            e.preventDefault();
            g_liste_courses.affiche();
        });
        $('#BTN_FRM_SUPPRIMER').on("click",function(e){
            e.preventDefault();
            let val = $("#FRM_COURSE input[name='Article_nom'").val();
            afficheModalConfirmation("Suppression course","Voulez-vous vraiment supprimer la course : "+val);
        });
        $('#COU_MODAL_CONFIRMATION_OUI').on("click",function(){
            g_liste_courses.gestion_liste.supprimeCourse();
        });
        $('#FRM_COURSE select').change(function(){
            const id = $(this).val();
            const text = $(this).find("option:selected").text();
            const tag_p = $(this).parent("p");
            const tag_input = $(tag_p).children("input");
            $(tag_input).val(text);
        });
        $('.input-nombre-entier').on('input',function(){
            var tag = $(this);
            const valeur = $(tag).val();
            
            if (g_liste_courses.gestion_liste.isChampNombreValide($(this))) {
                $(tag).css('color','black');
            } else {
                $(tag).css('color','red');
            }
        });
        $('.input-datation').on('input',function(){
            var tag = $(this);
            const valeur = $(tag).val();
            
            if (g_liste_courses.gestion_liste.isChampDatationValide($(this))) {
                $(tag).css('color','black');
            } else {
                $(tag).css('color','red');
            }
        });
        $('#FRM_COURSE input[type="checkbox"').change(function(){
            const etat = $(this).prop('checked') ? 1 : 0;
            
            $(this).next('input[type="hidden"').val(etat);
        });
    }
    isChampNombreValide(tag) {
        const valeur = $(tag).val();


        if(isNombreEntierPositif(valeur) === true) {
            return true;
        }
        
        return false;
    }
    
    isChampsNombresValides() {
        var is = true;
        $('.input-nombre-entier').each(function(index){
            if (g_liste_courses.gestion_liste.isChampNombreValide($(this)) === false) {
                is = false;
            }
            
        });
        
        return is;
    }

    isChampDatationValide(tag) {
        const valeur = $(tag).val();


        if(isDatationValide(valeur) === true) {
            return true;
        }
        
        return false;
    }
    
    isChampsDatationsValides() {
        var is = true;
        $('.input-datation').each(function(index){
            if (g_liste_courses.gestion_liste.isChampDatationValide($(this)) === false) {
                is = false;
            }
            
        });
        
        return is;
    }

    valideFormulaire(donnees) {
        var json = {
            domaine: 'gestion_liste_courses',
            action: 'valide_formulaire',
            donnees: donnees
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'json',
                    success: function (crdu) {
                        if (crdu.erreur === "non") {
                            g_liste_courses.affiche();
                        } else {
                            afficheModalCompteRendu(crdu);
                        }
                    }
                }
        );
    }
    
    supprimeCourse() {
        let id = $('#FRM_COURSE input[name=id]').val();
        
        var json = {
            domaine: 'gestion_liste_courses',
            action: 'supprime_course',
            id: id
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'json',
                    success: function (crdu) {
                        if (crdu.erreur === "non") {
                            g_liste_courses.affiche();
                        } else {
                            afficheModalCompteRendu(crdu);
                        }
                    }
                }
        );
    }
    
}  

function afficheModalConfirmation(titre,action) {
    $('#COU_MODAL_CONFIRMATION_TITRE').html(titre);
    $('#COU_MODAL_CONFIRMATION_ACTION').html(action);
    document.getElementById('COU_MODAL_CONFIRMATION').style.display='block';
}

