/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
var g_administration;


function ecouteBoutonsAdministration() {
    var prefixe = 'ADM_BTN_';
    var selecteur = '[id^=' + prefixe + ']';
    $(selecteur).click(function () {
        var id = $(this).attr('id');
        var nom_administration = id.slice(prefixe.length);
        changeCouleurBoutonAdministrationChoisi(id);
        afficheAdministration(nom_administration);
    });
}

function initialisationCouleurBoutonsAdministrations() {
    $(".ADM_BTNS").each(function(){ 
      $(this).addClass("w3-sand");
      $(this).removeClass("w3-amber");
    });
}

function changeCouleurBoutonAdministrationChoisi(id) {
    var x = document.getElementById(id);
    initialisationCouleurBoutonsAdministrations();
    x.className = x.className.replace(" w3-sand", "");
    x.className += " w3-amber";

}

function afficheAdministration(nom_administration) {
    g_administration = new C_Administration(nom_administration);
    g_administration.affiche();
}

class C_Administration {
    constructor (nom_administration) {
        this.nom_administration = nom_administration;
    }
    
    affiche() {
        $('#ADM_DIV_TITRE').html("Chargement en cours");
        var json = {
            domaine: 'gestion_administration',
            action: 'afficheAdministration',
            nom_administration: this.nom_administration
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        $('#ADM_DIV_CORPS').html("");
                        $('#ADM_DIV_TITRE').html(html);
                        g_administration.affiche_retour();
                    }
                }
        );
    }
    
    affiche_retour () {
        if (this.nom_administration === "INIT_BASE") {
            ecoute_objets_bloc_initialisation_base();
        }
        if (this.nom_administration === "TRANSFERT_BASE") {
            g_transfert_base = new C_TransfertBase();
            g_transfert_base.ecoute_poste_commande();
        }
        if (this.nom_administration === "RAMASSE_MIETTES") {
            g_ramasse_miettes = new C_RamasseMiettes();
            g_ramasse_miettes.ecoute_evenements_liste_tables();
        }
    }
}


