/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var g_transfert_table;

class C_transfert_table {
    constructor(table_source,table_destination) {
        this.table_source = table_source;
        this.table_destination = table_destination;
        this.id_source = 0;
        this.id_destination = 0;
        this.affiche_deja_associes = 0;
    }
    
    affiche() {
        $('#ADM_DIV_CORPS').html("Chargement raz base en cours");
        var json = {
            domaine: 'transfert_table',
            action: 'affiche',
            table_source: g_transfert_table.table_source,
            table_destination: g_transfert_table.table_destination
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_transfert_table.affiche_retour(html);
                    }
                }
        );
    }
    
    affiche_retour(html) {
        $('#ADM_DIV_CORPS').html(html);
        g_transfert_table.ecoute_evenements();
        g_transfert_table.affiche_tableau_elements_source("non");
    }
    
    ecoute_evenements() {
        $('.INP_RAD_MODE_AFF').change(function() {
            var val = $(this).val();
            g_transfert_table.affiche_deja_associes = val;
            g_transfert_table.affiche_tableau_elements_source(val);
            g_transfert_table.initialise_blocs_association();
        });
    }
    
    affiche_tableau_elements_source(avec_deja_associes) {
        var json = {
            domaine: 'transfert_table',
            action: 'afficheTableau',
            table_source: g_transfert_table.table_source,
            table_destination: g_transfert_table.table_destination,
            avec_deja_associes: avec_deja_associes
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_transfert_table.affiche_tableau_elements_source_retour(html);
                    }
                }
        );
    }

    affiche_tableau_elements_source_retour(html) {
        $('#DIV_LISTE_SOURCES').html(html);
        g_transfert_table.ecoute_evenements_tableau_elements_source();
    }
    
    ecoute_evenements_tableau_elements_source() {
        $('.TD_LISTE_SOURCE').click(function () {
            g_transfert_table.id_source = $(this).attr("id");
            g_transfert_table.affiche_element_source_choisi(g_transfert_table.id_source);
            $('#DIV_LISTE_ASSOCIATIONS_POSSIBLES').html("");
        });
    }
    
    affiche_element_source_choisi() {
        var json = {
            domaine: 'transfert_table',
            action: 'afficheElementChoisi',
            table_source: g_transfert_table.table_source,
            id_source: g_transfert_table.id_source
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_transfert_table.affiche_element_source_choisi_retour(html);
                    }
                }
        );
    }

    affiche_element_source_choisi_retour(data) {
        $('#DIV_SOURCE_CHOISI').html(data);
        $('#BTN_CALCULE_PROPOSITION').click(function() {
            g_transfert_table.calculeProposition(g_transfert_table.id_source);
        });
        g_transfert_table.affiche_formulaire_elements_destination();
//        g_transfert_table.calculeProposition(g_transfert_table.id_source);
    }
    
    affiche_formulaire_elements_destination() {
        var json = {
            domaine: 'transfert_table',
            action: 'afficheEditionTransfert',
            table_source: g_transfert_table.table_source,
            nom_table: g_transfert_table.table_destination,
            id_source: g_transfert_table.id_source
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_transfert_table.affiche_formulaire_elements_destination_retour(html);
                    }
                }
        );
    }

    affiche_formulaire_elements_destination_retour(html) {
        $('#DIV_FORMULAIRE_DESTINATION').html(html);
        g_transfert_table.ecoute_evenements_formulaire_elements_destination()
    }
    
    ecoute_evenements_formulaire_elements_destination() {
        $('#element-associer').click(function (e) {
            var donnees = $('#formulaire-element-transfert').serializeArray();
            g_transfert_table.traiteAssociation(donnees);
            e.preventDefault();
        });
        $('#element-rejeter').click(function (e) {
            g_transfert_table.traiteAssociation("rejeter");
            e.preventDefault();
        });
        $('#element-init').click(function (e) {
            g_transfert_table.traiteAssociation("init");
            e.preventDefault();
        });
        $('.INP_FRM_TR').on('input', function(e) {
            var donnees = $('#formulaire-element-transfert').serializeArray();
            g_transfert_table.affichePropositions(donnees);
            e.preventDefault();
        });
    }
    
    affichePropositions(donnees) {
        var json = {
            domaine: 'transfert_table',
            action: 'affichePropositions',
            table_source: g_transfert_table.table_source,
            table_destination: g_transfert_table.table_destination,
            donnees: donnees
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_transfert_table.affichePropositions_retour(html);
                    }
                }
                );
    }
    
    affichePropositions_retour(html) {
        $('#DIV_LISTE_ASSOCIATIONS_POSSIBLES').html(html);
        g_transfert_table.ecoute_evenements_choix_proposition();
    }
    
    ecoute_evenements_choix_proposition() {
        $('.CHOIX_ASSOCIATION').click(function(){
            var id = $(this).attr('id');
            g_transfert_table.id_destination = id;
            g_transfert_table.affiche_formulaire_proposition();
        });
    }
    
    affiche_formulaire_proposition() {
        var json = {
            domaine: 'transfert_table',
            action: 'afficheEditionPropositionTransfert',
            nom_table: g_transfert_table.table_destination,
            id_destination: g_transfert_table.id_destination
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_transfert_table.affiche_formulaire_proposition_retour(html);
                    }
                }
        );
    }

    affiche_formulaire_proposition_retour(html) {
        $('#DIV_FORMULAIRE_DESTINATION').html(html);
        g_transfert_table.ecoute_evenements_formulaire_elements_destination();
    }
    
    traiteAssociation = function (donnees) {
        var json = {
            domaine: 'transfert_table',
            action: 'traiteAssociation',
            table_source: g_transfert_table.table_source,
            table_destination: g_transfert_table.table_destination,
            id_source: g_transfert_table.id_source,
            donnees: donnees
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'json',
                    success: function (data) {
                        g_transfert_table.traiteAssociation_retour(data);
                    }
                });
    };

    traiteAssociation_retour(data) {
        // Rafraichit les valeurs de taux de tranbsfert
        g_transfert_base.get_taux_transfert_retour(data);
        
        g_transfert_table.initialise_blocs_association();

        g_transfert_table.affiche_tableau_elements_source(g_transfert_table.affiche_deja_associes);
    }
    
    calculeProposition = function (id_source) {
        var json = {
            domaine: 'transfert_table',
            action: 'calculeProposition',
            table_source: g_transfert_table.table_source,
            table_destination: g_transfert_table.table_destination,
            id_source: g_transfert_table.id_source
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'json',
                    success: function (data) {
                        g_transfert_table.calculeProposition_retour(data);
                    }
                });
    };

    calculeProposition_retour(data) {
        for (const element of data) {
            const id_tablonne = "#"+element.tablonne;
            $(id_tablonne).val(element.valeur);
        }
        
        
    }
    
    initialise_blocs_association() {
        $('#DIV_SOURCE_CHOISI').html("");
        $('#DIV_FORMULAIRE_DESTINATION').html("");
        $('#DIV_LISTE_ASSOCIATIONS_POSSIBLES').html("");
    }
    
}