/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

function ecoute_objets_bloc_initialisation_base() {
    ecoute_objets_bloc_initialisation_base_section('ADM');
    
    ecoute_objets_bloc_initialisation_base_section('CHA');
    
    ecoute_objets_bloc_initialisation_base_section('PCA');
    
    ecoute_objets_bloc_initialisation_base_section('LIA');

    ecoute_objets_bloc_initialisation_base_section('ACH');

    ecoute_objets_bloc_initialisation_base_tout();
    
    ecoute_objets_bloc_initialisation_base_formulaire();
}

function ecoute_objets_bloc_initialisation_base_section(nom_section) {
    $('.CAC_INIBASE_'+nom_section+'_TOUT').click(function() {
        var etat = $(this).prop('checked');
        
        $('.CAC_INIBASE_'+nom_section).prop('checked',etat);

        if (etat === false) {
            $('.CAC_INIBASE_TOUT').prop('checked',false);
        }
    });
    
    $('.CAC_INIBASE_'+nom_section).click(function() {
        var etat = $(this).prop('checked');
        
        if (etat === false) {
            $('.CAC_INIBASE_'+nom_section+'_TOUT').prop('checked',false);
            $('.CAC_INIBASE_TOUT').prop('checked',false);
        }
    });
}

function ecoute_objets_bloc_initialisation_base_tout() {
    $('.CAC_INIBASE_TOUT').click(function() {
        var etat = $(this).prop('checked');
        
        $('[class*="CAC_INIBASE_"').prop('checked',etat);
    });
}

function ecoute_objets_bloc_initialisation_base_formulaire() {
        $('#formulaire_choix_tables_validation').click(function (e) {
            var donnees = $('#formulaire_choix_tables').serializeArray();
            $("#formulaire_choix_tables_crdu").html("<h1>Initialisation tables choisies en cours</h1>");
            initialisation_base_traite_validation(donnees);
            e.preventDefault();
        });
}

function initialisation_base_traite_validation(donnees) {
    var json = {
        domaine: 'initialisation_base',
        action: 'choix_tables',
        donnees: donnees
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (data) {
                    $('#formulaire_choix_tables_crdu').html(data);
                }
            });
}

