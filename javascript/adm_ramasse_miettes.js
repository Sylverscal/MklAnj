/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var g_ramasse_miettes;

class C_RamasseMiettes {
    constructor() {
        var nom_table = "";
        var id = 0;
    }
    
    ecoute_evenements_liste_tables() {
        $(".BTN_RM_TABLES").click(function() {
            g_ramasse_miettes.nom_table = $(this).attr('id');
            
            g_ramasse_miettes.traite_table();
        });
    }
    
    traite_table() {
        $('#DIV_RM_TRAITEMENT_TABLE').html("Chargement traitement table en cours");
        var json = {
            domaine: 'ramasse_miettes',
            action: 'traite_table',
            nom_table: g_ramasse_miettes.nom_table
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_ramasse_miettes.traite_table_retour(html);
                    }
                }
        );
    }
    
    traite_table_retour(html) {
        $('#DIV_RM_TRAITEMENT_TABLE').html(html);
        g_ramasse_miettes.ecoute_evenements_traitement_table();
    }
    
    ecoute_evenements_traitement_table() {
        $('.BTN_RM_SUPPR_ELT').click(function() {
            g_ramasse_miettes.id = $(this).attr('id');
            g_ramasse_miettes.supprime_element();
        });
    }
    
    supprime_element() {
        $('#DIV_RM_TRAITEMENT_TABLE').html("Chargement traitement table en cours");
        var json = {
            domaine: 'ramasse_miettes',
            action: 'supprime_element',
            nom_table: g_ramasse_miettes.nom_table,
            id: g_ramasse_miettes.id
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'json',
                    success: function (data) {
                        g_ramasse_miettes.supprime_element_retour(data);
                    }
                }
        );
    }
    
    supprime_element_retour(data) {
        const sel = ".RM_NB_ORPHELINS#"+g_ramasse_miettes.nom_table;
        $(sel).html(data);
        g_ramasse_miettes.traite_table();
    }
    
}
