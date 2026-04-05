/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var g_transfert_releves;

class C_transfert_releves {
    constructor() {
        this.id_releve = 0;
        this.transfert_automatique = 0;
        this.nb_transferts_par_salve = 0;
    }
    
    affiche() {
        $('#ADM_DIV_CORPS').html("Chargement raz base en cours");
        var json = {
            domaine: 'transfert_releves',
            action: 'affiche'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_transfert_releves.affiche_retour(html);
                    }
                }
        );
    }
    
    affiche_retour(html) {
        $('#ADM_DIV_CORPS').html(html);
        g_transfert_releves.ecoute_evenements();
        g_transfert_releves.affiche_liste_releves('affiche_liste_releves');
    }
    
    ecoute_evenements() {
        $('#BTN_TR_DEMARRAGE').click(function () {
            // Mémoriser le nombre de transferts par salve
            g_transfert_releves.nb_transferts_par_salve = $("#SEL_TR_NOMBRE").val();
            // Mode transfert automatique
            g_transfert_releves.transfert_automatique = 1;
            // Afficher la la liste des relevés à transfér;er
            g_transfert_releves.affiche_liste_releves('affiche_liste_releves');
        });
        $('#BTN_TR_ARRET').click(function () {
            // Mémoriser le nombre de transferts par salve
            g_transfert_releves.nb_transferts_par_salve = 0;
            $('#DIV_TR_COMPTEUR').html("");
        });
        $('#SEL_TR_NOMBRE').change(function () {
            g_transfert_releves.affiche_liste_releves('affiche_liste_releves');
        });
        $('#BTN_TR_RAZ').on("click", function () {
            g_transfert_releves.reinitialisation_releves();
        });
        $('#BTN_TR_AFFICHE_A_TRANSFERER').click(function () {
            g_transfert_releves.affiche_liste_releves('affiche_liste_releves');
        });
        $('#BTN_TR_AFFICHE_EN_ATTENTE').click(function () {
            g_transfert_releves.affiche_liste_releves('affiche_liste_en_attente');
        });
        $('#BTN_TR_AFFICHE_REJETES').click(function () {
            g_transfert_releves.affiche_liste_releves('affiche_liste_rejetes');
        });
    }
    
    affiche_liste_releves($action) {
        var nb_releves;
        if (g_transfert_releves.nb_transferts_par_salve === 0) {
            nb_releves = $("#SEL_TR_NOMBRE").val();
        } else {
//            nb_releves = g_transfert_releves.nb_transferts_par_salve;
            nb_releves = 1;
        }
        
        var json = {
            domaine: 'transfert_releves',
            action: $action,
            nb_releves: nb_releves
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_transfert_releves.affiche_liste_releves_retour(html);
                    }
                }
        );
    }
    
    affiche_liste_releves_retour(html) {
        $('#DIV_TR_LISTE_RELEVES').html(html);
        
        if (g_transfert_releves.nb_transferts_par_salve === 0) {
            $('#DIV_TR_COMPTEUR').html("");
            g_transfert_releves.ecoute_evenements_liste_releves();
        } else {
            const id = g_transfert_releves.get_id_premier_releve_liste();
            $('#DIV_TR_COMPTEUR').html(g_transfert_releves.nb_transferts_par_salve);
            g_transfert_releves.transfert_automatique = 1;
            g_transfert_releves.affiche_transfert(id);
        }
    }
    
    get_id_premier_releve_liste() {
        const id = $('.TR_TR_LIGNE_RELEVE').first().attr('id');
        return id;
    }
    
    ecoute_evenements_liste_releves() {
        $('.TR_TR_LIGNE_RELEVE').click(function () {
            const id = $(this).attr('id');
            g_transfert_releves.transfert_automatique = 0;
            g_transfert_releves.affiche_transfert(id);
        });
        $('.BTN_TR_TRANSFERE_AUTO').click(function () {
            const id = $(this).attr('id');
            g_transfert_releves.transfert_automatique = 1;
            g_transfert_releves.affiche_transfert(id);
        });
    }
    
    affiche_transfert(id) {
        var json = {
            domaine: 'transfert_releves',
            action: 'affiche_transfert',
            id: id,
            automatique: g_transfert_releves.transfert_automatique
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        if (g_transfert_releves.transfert_automatique === 0) {
                            g_transfert_releves.affiche_transfert_retour(html);
                        } else {
                            g_transfert_releves.affiche_transfert_automatique_retour(html);
                        }
                    }
                }
        );
    }
    
    affiche_transfert_retour(html) {
        $('#DIV_TR_TRANSFERT').html(html);
        g_transfert_releves.ecoute_evenements_affiche_transfert();
    }
    
    affiche_transfert_automatique_retour(html) {
        $('#DIV_TR_TRANSFERT').html(html);
        if (g_transfert_releves.nb_transferts_par_salve > 0) {
            g_transfert_releves.nb_transferts_par_salve--;
        }
        g_transfert_releves.affiche_liste_releves('affiche_liste_releves');
        g_transfert_base.get_taux_transfert();
        
    }
    
    ecoute_evenements_affiche_transfert() {
        $('.BTN_TR_EXAMEN_MAGASIN').click(function () {
            const id = $(this).attr('id');
            g_transfert_table = new C_transfert_table('magasin','Commerce');
            g_transfert_table.affiche();
        });
        $('.BTN_TR_EXAMEN_ARTICLE').click(function () {
            const id = $(this).attr('id');
            g_transfert_table = new C_transfert_table('article','Article');
            g_transfert_table.affiche();
        });
        $('.BTN_TR_TRANSFERE').click(function () {
            g_transfert_releves.id_releve = $(this).attr('id');
            g_transfert_releves.action_releve('transfert');
            
        });
        $('.BTN_TR_REJETE').click(function () {
            g_transfert_releves.id_releve = $(this).attr('id');
            g_transfert_releves.action_releve('rejet');
        });
        $('.BTN_TR_EN_ATTENTE').click(function () {
            g_transfert_releves.id_releve = $(this).attr('id');
            g_transfert_releves.action_releve('en_attente');
        });
    }
    
    action_releve(action) {
        var json = {
            domaine: 'transfert_releves',
            action: action,
            id: g_transfert_releves.id_releve
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_transfert_releves.action_releve_retour(html);
                    }
                }
        );
    }
    
    action_releve_retour(html) {
        $('#DIV_BLOC_TRANSFERT_ET_ACTION').html(html);
        g_transfert_releves.affiche_liste_releves('affiche_liste_releves');
        g_transfert_base.get_taux_transfert();
    }
    
    reinitialisation_releves() {
        var json = {
            domaine: 'transfert_releves',
            action: 'reinitialisation_releves'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_transfert_releves.reinitialisation_releves_retour(html);
                    }
                }
        );
    }
    
    reinitialisation_releves_retour(html) {
        $('#DIV_TR_TRANSFERT').html(html);
        g_transfert_base.get_taux_transfert();
        g_transfert_releves.affiche_liste_releves('affiche_liste_releves');
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
                        g_transfert_releves.get_taux_transfert_retour(data);
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