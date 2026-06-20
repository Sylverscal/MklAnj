/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
/* global g_log_visualisation, g_liste_courses, g_graphiques */
var g_liste_courses;

class C_ListeCourses {
    constructor() {
        this.gestion_liste = new C_GestionListe();
        this. gestion_fonctions = new C_GestionFonctions();
    }
    
    affiche() {
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
                        g_liste_courses.affiche_retour(html);
                    }
                }
        );
    }
    
    affiche_retour(html) {
        $(g_acces.div_accueil_fonction_liste_course).html(html);
        g_liste_courses.gestion_liste.affiche();
        g_recherche = new C_Recherche();
        g_recherche.affiche();
        g_filtrage = new C_Filtrage();
        g_filtrage.affiche();
    }
    
}
    
class C_GestionListe {
    constructor () {
        this.id_selectionne = 0;
        this.liste_articles_interdits = [];
        this.article_course_courante = "";
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
                        g_liste_courses.gestion_liste.affiche_retour(html);
                    }
                }
        );
    }
    
    affiche_filtree(recherche,filtrage) {
        var json = {
            domaine: 'liste_courses',
            action: 'affiche_liste_courses_filtree',
            recherche: recherche,
            filtrage: filtrage
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_liste_courses.gestion_liste.affiche_retour(html);
                    }
                }
        );
    }
    
    affiche_retour(html) {
        $("#DIV_LISTE_COURSES").html(html);
        g_liste_courses.gestion_liste.ecouteEvenements();
        g_liste_courses.gestion_fonctions.affiche();

    }

    ecouteEvenements() {
        g_liste_courses.gestion_liste.majCouleurLignes();
       
        // Ecoute le état case à cocher "course faite"
        $('.CBX_COURSE_FAITE').on("change",function () {
            var th = $(this).closest("tr");
            var id = $(th).attr(('id'));
            var etat = ($(this).is(':checked')) ? 1 : 0;
            
            g_liste_courses.gestion_liste.changeEtatFaite(id,etat);
        });
        // Ecoute d'un clic sur le bouton de raz du filtre
        $('.BTN_FORMULAIRE').on("click",function() {
            var th = $(this).closest("tr");
            var id = $(th).attr('id');
            g_liste_courses.gestion_liste.affiche_formulaire(id);
        });
        $('.TD_COURSE').on("click",function() {
            var th = $(this).closest("tr");
            var id = $(th).attr('id');
            g_liste_courses.gestion_liste.id_selectionne = id;
            g_liste_courses.gestion_liste.majCouleurLignes();
        });
    }
    
    ecouteEvenementsNouvelleLigne() {
        let id = $('#TBL_LISTE_COURSES_BODY').find('tr').first().attr('id');

        g_liste_courses.gestion_liste.majCouleurLignes();
       
        let nd = $('#TBL_LISTE_COURSES_BODY').find('tr#'+id);
        // Ecoute le état case à cocher "course faite"
        $(nd).find('input.CBX_COURSE_FAITE').on("change",function () {
            var th = $(this).closest("tr");
            var id = $(th).attr(('id'));
            var etat = ($(this).is(':checked')) ? 1 : 0;
            
            g_liste_courses.gestion_liste.changeEtatFaite(id,etat);
        });
        // Ecoute d'un clic sur le bouton de raz du filtre
        $(nd).find('button.BTN_FORMULAIRE').on("click",function() {
            var th = $(this).closest("tr");
            var id = $(th).attr('id');
            g_liste_courses.gestion_liste.affiche_formulaire(id);
        });
        $(nd).find('td.TD_COURSE').on("click",function() {
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
                        g_filtrage.applique_filtrage();
                    }
                }
        );
    }
    
    affiche_formulaire(id) {
        g_filtrage.filtrage_courant = $("#SEL_FTR").val();

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
//        $(g_acces.div_accueil_fonction_liste_course).html(html);
        $('#DIV_LISTE_COURSES').html(html);
        g_liste_courses.gestion_liste.getListeArticlesInterdits();
    }
    
    getListeArticlesInterdits() {
        var json = {
            domaine: 'gestion_liste_courses',
            action: 'get_liste_articles_interdits'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'json',
                    async: 'false',
                    success: function (data) {
                        g_liste_courses.gestion_liste.getListeArticlesInterdits_retour(data);
                    }
                }
        );
    }

    getListeArticlesInterdits_retour(data) {
        g_liste_courses.gestion_liste.liste_articles_interdits = data;
        g_liste_courses.gestion_liste.article_course_courante = $("#FRM_COURSE input[name=Article_nom]").val();
        g_liste_courses.gestion_liste.ecouteEvenementsFormulaire();
        
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
            g_liste_courses.gestion_liste.affiche_filtree("",g_filtrage.filtrage_courant);
        });
        $('#BTN_FRM_SUPPRIMER').on("click",function(e){
            e.preventDefault();
            let id = $('#FRM_COURSE input[name=id]').val();
            g_liste_courses.gestion_liste.supprimeCourse(id);
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
        $('#BTN_DATATION').click(function(e){
            e.preventDefault();
            document.getElementById('COU_MODAL_DATATION').style.display='block';
            g_datation = new C_Datation();
            g_datation.ecouteEvenements();
        });
        $('#FRM_COURSE input[type="checkbox"').change(function(){
            const etat = $(this).prop('checked') ? 1 : 0;
            
            $(this).next('input[type="hidden"').val(etat);
        });
        $('input[name=Article_nom]').on('input',function(){
            let nom_article = $(this).val();
            
            var select = $(this).parent('p').find('select option');
            
            let is_nom_dans_liste = g_liste_courses.gestion_liste.isValeurDansMenu(select,nom_article);
            
            if (is_nom_dans_liste) {
                $('#BTN_FRM_VALIDER').prop('disabled',true);
                $(this).css('color','red');
            } else {
                $('#BTN_FRM_VALIDER').prop('disabled',false);
                $(this).css('color','black');
            }
        });
        const elem = document.querySelector('#FRM_COURSE input[name="Course_datation"]');
//        const datepicker = new DatePicker(elem,{
//            
//        });
    }
    
    isValeurDansMenu(menu,valeur) {
        var is = false;
        g_liste_courses.gestion_liste.liste_articles_interdits.forEach((article,index) => {
            if (valeur === article && valeur !== g_liste_courses.gestion_liste.article_course_courante) {
                is = true;
                return;
            }
        });
        return is;
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
                              g_filtrage.affiche();
                              g_liste_courses.gestion_liste.affiche_filtree("",g_filtrage.filtrage_courant);
                        } else {
                            afficheModalCompteRendu(crdu);
                        }
                    }
                }
        );
    }
    
    supprimeCourse(id) {
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
                            g_liste_courses.gestion_liste.affiche_filtree("",g_filtrage.filtrage_courant);
                        } else {
                            afficheModalCompteRendu(crdu);
                        }
                    }
                }
        );
    }
    
    afficheNouvelleCourse() {
        var json = {
            domaine: 'gestion_liste_courses',
            action: 'affiche_nouvelle_course'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_liste_courses.gestion_liste.afficheNouvelleCourse_retour(html);
                    }
                }
        );
    }
    
    afficheNouvelleCourse_retour(html) {
        $('#TBL_LISTE_COURSES_BODY').prepend(html);
        
        $('TR[id=0]').on('focus');
        
        $('#INP_LIGNE_EDITABLE_VALEUR').on("input",function(){
            let nom_article = $('#INP_LIGNE_EDITABLE_VALEUR').val();
            
            g_liste_courses.gestion_liste.controleArticleExisteDeja(nom_article);
        });
        $('#BTN_LIGNE_EDITABLE_OK').on("click",function(){
            $('#BTN_FCT_CREER').prop('disabled',false);
            let nom_article = $('#INP_LIGNE_EDITABLE_VALEUR').val();
            
            $(this).parents('tr').remove();
            g_liste_courses.gestion_liste.valideNouvelleCourse(nom_article);
        });
        $('#BTN_LIGNE_EDITABLE_KO').on("click",function(){
            $('#BTN_FCT_CREER').prop('disabled',false);
            $(this).parents('tr').remove();
        });
        $('#SEL_NOM_ARTICLE').on("change",function(){
            let val = $(this).val();
            $(this).parents('tr').find('input').val(val);
        });
    }
    
    controleArticleExisteDeja(nom_article) {
        var json = {
            domaine: 'gestion_liste_courses',
            action: 'controle_article_existe_deja',
            nom_article: nom_article
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'json',
                    success: function (data) {
                        g_liste_courses.gestion_liste.controleArticleExisteDeja_retour(data);
                    }
                }
        );
    }
    
    controleArticleExisteDeja_retour(data) {
        if (data.is_existe === "oui") {
            $('#INP_LIGNE_EDITABLE_VALEUR').css('color','orange');
            $('#BTN_LIGNE_EDITABLE_OK').prop('disabled',true);
        } else {
            $('#INP_LIGNE_EDITABLE_VALEUR').css('color','black');
            $('#BTN_LIGNE_EDITABLE_OK').prop('disabled',false);
        }
    }
    
    valideNouvelleCourse(nom_article) {
        var json = {
            domaine: 'gestion_liste_courses',
            action: 'valide_nouvelle_course',
            nom_article: nom_article
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_liste_courses.gestion_liste.valideNouvelleCourse_retour(html);
                    }
                }
        );
    }
    
    valideNouvelleCourse_retour(html) {
        $('#TBL_LISTE_COURSES_BODY').prepend(html);
        g_liste_courses.gestion_liste.ecouteEvenementsNouvelleLigne();        
    }
}  

class C_GestionFonctions {
    
    affiche() {
        var json = {
            domaine: 'liste_courses',
            action: 'affiche_fonctions'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_liste_courses.gestion_fonctions.affiche_retour(html);
                    }
                }
        );
    }
    
    affiche_retour(html) {
        $("#DIV_FONCTIONS").html(html);
        g_liste_courses.gestion_fonctions.ecoute_evenements();
    }
    
    ecoute_evenements() {
        $('#BTN_FCT_SUPPRIMER').click(function(){
            let id = g_liste_courses.gestion_liste.id_selectionne;
            
            if (id === 0) {
                return;
            }
            
            g_liste_courses.gestion_liste.supprimeCourse(id);
        });
        $('#BTN_FCT_CREER').on("click",function(){
            $(this).prop('disabled',true);
            g_liste_courses.gestion_liste.afficheNouvelleCourse();
        });
        $('#BTN_FCT_MODIFIER').on("click",function(){
        });
    }
    
    
}

function afficheModalConfirmation(titre,action) {
    $('#COU_MODAL_CONFIRMATION_TITRE').html(titre);
    $('#COU_MODAL_CONFIRMATION_ACTION').html(action);
    document.getElementById('COU_MODAL_CONFIRMATION').style.display='block';
}

