/* global g_achats */

$(function () {
//    g_achats = new C_Achats();
    if ($("#barre_navigation").length) {
        affiche_barre_navigation("COU_onglet_home");
        affiche_onglet_home();
    }      
    if ($("#DIV_ACCUEIL").length) {
        g_acces = new C_Acces();
        g_acces.affiche();
    }      
    $.extend( $.fn.dataTableExt.oSort, {
        "extract-date-fr-pre": function(value) {
            let elementsDate = value.split('/');
            return Date.parse(elementsDate[0] + '-' + elementsDate[1] + '-' + elementsDate[2].substring(0,4))
        },
        "extract-date-fr-asc": function(a, b) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },
        "extract-date-fr-desc": function(a, b) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });
});


function affiche_barre_navigation(onglet) {
    $('#onglet').html("<h4>Chargement barre navigation en cours</h4>");
    var json = {
        domaine: 'barre_navigation',
        action: 'affiche',
        onglet: onglet
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (data) {
                    affiche_barre_navigation_retour(data);
                }
            }
    );
}

function affiche_barre_navigation_retour(data) {
    $('#barre_navigation').html(data);
    $('#BTN_ACCUEIL').click(function () {
        g_accueil.affiche();
    });
    $('#CLA_onglet_home').click(function () {
        affiche_barre_navigation("COU_onglet_home");
        affiche_onglet_home();
    });
    $('#CLA_onglet_liste_courses').click(function () {
        affiche_barre_navigation('MKL_onglet_mklanj');
        affiche_onglet_achats();
    });
    $('#CLA_onglet_tables').click(function () {
        affiche_barre_navigation('CLA_onglet_tables');
        affiche_onglet_tables();
    });
    $('#CLA_onglet_administration').click(function () {
        affiche_barre_navigation('COU_onglet_administration');
        affiche_onglet_administration();
    });
    $('#CLA_onglet_essais').click(function () {
        affiche_barre_navigation('COU_onglet_essais');
        affiche_onglet_essais();
    });
}

function affiche_onglet_home() {
    $('#onglet').html("<h4>Op&eacuteration en cours</h4>");
    var json = {
        domaine: 'onglet',
        action: 'home'
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (data) {
                    affiche_onglet_home_retour(data);
                }
            }
    );
}

function affiche_onglet_home_retour(data) {
    $('#onglet').html(data);
}

function affiche_onglet_achats() {
    $('#onglet').html("<h4>Op&eacuteration en cours</h4>");
    var json = {
        domaine: 'onglet',
        action: 'achats'
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (data) {
                    affiche_onglet_achats_retour(data);
                }
            }
    );
}

function affiche_onglet_achats_retour(data) {
    $('#onglet').html(data);
    g_achats.afficheFenetre();
}

function affiche_onglet_tables() {
    $('#onglet').html("<h4>Op&eacuteration en cours</h4>");
    var json = {
        domaine: 'onglet',
        action: 'tables'
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (data) {
                    affiche_onglet_tables_retour(data);
                }
            }
    );
}

function affiche_onglet_tables_retour(data) {
    $('#onglet').html(data);
    initialisationCouleurBoutonsTables();
    ecouteBoutonsTables();
}

function affiche_onglet_administration() {
    $('#onglet').html("<h4>Op&eacuteration en cours</h4>");
    var json = {
        domaine: 'onglet',
        action: 'administration'
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (data) {
                    affiche_onglet_administration_retour(data);
                }
            }
    );
}

function affiche_onglet_administration_retour(data) {
    $('#onglet').html(data);

    initialisationCouleurBoutonsAdministrations();
    ecouteBoutonsAdministration();
}

function affiche_onglet_essais() {
    $('#onglet').html("<h4>Op&eacuteration en cours</h4>");
    var json = {
        domaine: 'onglet',
        action: 'essais'
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (data) {
                    affiche_onglet_home_retour(data);
                }
            }
    );
}

function affiche_onglet_essais_retour(data) {
    $('#onglet').html(data);
}

function affiche_onglet(domaine, action) {
    $('#onglet').html("<h4>Op&eacuteration en cours</h4>");
    var json = {
        domaine: domaine,
        action: action
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (data) {
                    affiche_onglet_retour(data);
                }
            }
    );
}

function affiche_onglet_retour(data) {
    $('#onglet').html(data);
    $('#BTN_tables').click(function () {
        gestion_tables();
    });
    $('#BTN_import_photos').click(function () {
        import_photos();
    });
    $('#BTN_tests').click(function () {
        action_simple('tests', 'tests_divers');
    });
    $('#BTN_test_preg_match').click(function () {
        g_test_preg_match = new C_test_preg_match();
    });
    $('#BTN_phpinfo').click(function () {
        action_simple('tests', 'phpinfo');
    });
    $('#BTN_infos_systeme').click(function () {
        action_simple('tests', 'infos_systeme');
    });
    $('#BTN_test_mysql').click(function () {
        action_simple('tests', 'test_mysql');
    });
    $('#BTN_gestion_logs').click(function () {
        g_log = new C_Log();
        $('#ONG_contenu').html("<h4>Installation log activit&eacute; en cours</h4>");
        g_log.installe();
    });
    $('#BTN_visualisation').click(function () {
        $('#ONG_contenu').html("<h4>Installation log utilisation application</h4>");
        g_log_visualisation.installe();
    });
    $('#BTN_diffusion_albums').click(function () {
        $('#ONG_contenu').html("<h4>Installation diffusion albums</h4>");
        g_diffusion_albums = new C_diffusion_albums('administration');
        g_diffusion_albums.installe();
    });
}

function gestion_tables() {
    $('#GTB_Contenu').html("<h4>Op&eacuteration en cours</h4>");
    var json = {
        domaine: 'gestion_table',
        action: 'affiche_liste_tables'
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (data) {
                    gestion_tables_retour(data);
                }
            }
    );
}

function gestion_tables_retour(data) {
    $('#ONG_contenu').html(data);
    ecouteBoutonsTables();
}

function action_simple(domaine, action) {
    $('#ONG_contenu').html("<h4>Op&eacuteration en cours</h4>");
    var json = {
        domaine: domaine,
        action: action
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (data) {
                    actionSimple_retour(data);
                }
            }
    );
}

function action_simple_avec_parametre(domaine, action, parametre) {
    $('#ONG_contenu').html("<h4>Op&eacuteration en cours</h4>");
    var json = {
        domaine: domaine,
        action: action,
        parametre: parametre
    };
    $.ajax(
            {
                type: 'POST',
                url: 'ajax/ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (data) {
                    actionSimple_retour(data);
                }
            }
    );
}

function actionSimple_retour(data) {
    $('#ONG_contenu').html(data);
}

function afficheModalCompteRendu(crdu) {
    if (crdu.erreur === "oui") {
        $('#COU_MODAL_ERREUR_RESUME').html(crdu.erreur_resume);
        afficheModalCompteRenduDetail(crdu.erreur_detail);
        document.getElementById('COU_MODAL_ERREUR').style.display='block';
    }
}

function afficheModalCompteRenduDetail (tab) {
    let html = "";
    for (let i = 0; i < tab.length; i++) {
      let message = tab[i];
      
      html = html + "<h5 class='w3-khaki'>" + message + "</h5>";
    }
    
    $('#COU_MODAL_ERREUR_DETAIL').html(html);

};
function parametre_datatable(id_table) {
    $("#"+id_table).DataTable({
        // Cible les colonnes N°2 et 3 (1 et 2 avec la numérotation à 0)
        language : {
            processing:     "Traitement en cours...",
            search:         "Rechercher&nbsp;:",
            lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
            info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix:    "",
            loadingRecords: "Chargement en cours...",
            zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable:     "Aucune donnée disponible dans le tableau",
            paginate: {
                first:      "Premier",
                previous:   "Pr&eacute;c&eacute;dent",
                next:       "Suivant",
                last:       "Dernier"
            },
            aria: {
                sortAscending:  ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        }
//        ,
//        columnDefs: [
//            { 
//                type: "extract-date-fr", 
//                targets: [4]
//            }
//        ]
    });

}

