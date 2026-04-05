/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
/* global g_achats, g_graphiques */

class C_Graphiques {
    constructor() {
    }
    afficheFenetre(id_achat) {
        this.afficheGraphique(id_achat);
    }
    ecouteEvenementsx() {
        // Ecoute le choix dans le menu Domaine
        $('GASP').change(function () {
            var id = $(this).val();
            g_achats.enregistreDomaineChoisi(id);
        });
        // Ecoute d'un clic sur le bouton de raz du filtree
        $('OURGL').click(function() {
            g_achats.filtres = new C_Filtres();
            g_achats.filtres.affiche();
            g_achats.afficheListeAchats();
        });
    }
    
    afficheGraphique(id_achat) {
        $('#ONG_contenu').html("<h4>Opération en cours</h4>");
        var json = {
            domaine: 'graphiques',
            action: 'affiche',
            id_achat: id_achat
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_graphiques.afficheGraphique_Retour(html);
                    }
                }
        );
    }
    
    afficheGraphique_Retour(html) {
        $("#DIV_ACH_ACHATS").html(html);
    }
    
    
}
    

