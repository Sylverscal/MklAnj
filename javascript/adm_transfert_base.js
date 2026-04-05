/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var g_transfert_base;

class C_TransfertBase {
    ecoute_poste_commande() {
        $('#BTN_ADM_TSF_RAZ').click(function (e) {
            g_transfert_base.affiche_raz_base();
            e.preventDefault();
        });
        $('#BTN_ADM_TSF_MAG').click(function (e) {
            g_transfert_table = new C_transfert_table('magasin','Commerce');
            g_transfert_table.affiche();
        });
        $('#BTN_ADM_TSF_ART').click(function (e) {
            g_transfert_table = new C_transfert_table('article','Article');
            g_transfert_table.affiche();
        });
        $('#BTN_ADM_TSF_REL').click(function (e) {
            g_transfert_releves = new C_transfert_releves();
            g_transfert_releves.affiche();
        });
        g_transfert_base.get_taux_transfert();
    }
    
    affiche_raz_base() {
        $('#ADM_DIV_CORPS').html("Chargement raz base en cours");
        var json = {
            domaine: 'transfert_base',
            action: 'vidageBases'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_transfert_base.affiche_raz_base_retour(html);
                    }
                }
        );
    }
    
    affiche_raz_base_retour(html) {
        $('#ADM_DIV_CORPS').html(html);
        $('#BTN_ADM_TSF_RAZ_ACH_OUI').click(function (e) {
            g_transfert_base.vidage_une_base("Achats");
            e.preventDefault();
        });
        $('#BTN_ADM_TSF_RAZ_COU_OUI').click(function (e) {
            g_transfert_base.vidage_une_base("Courses");
            e.preventDefault();
        });
    }
    
    vidage_une_base(nom_base) {
        var json = {
            domaine: 'transfert_base',
            action: 'vidageUneBase',
            nom_base: nom_base
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_transfert_base.vidage_une_base_retour(html);
                    }
                }
        );
    }
    
    vidage_une_base_retour(html) {
        $('#BTN_ADM_TSF_RAZ_CRDU').html(html);
        this.get_taux_transfert();
    }
    
    get_taux_transfert() {
        var json = {
            domaine: 'transfert_base',
            action: 'getTauxTransfert'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'json',
                    success: function (data) {
                        g_transfert_base.get_taux_transfert_retour(data);
                    }
                }
        );
    }
    
    get_taux_transfert_retour(data) {
        $('#INP_ADM_TSF_MAG').val(data.magasins);
        $('#INP_ADM_TSF_ART').val(data.articles);
        $('#INP_ADM_TSF_REL').val(data.releves);
    }
}


