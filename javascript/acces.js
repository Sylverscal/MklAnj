/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var g_acces;

class C_Acces {
    affiche() {
        $('#DIV_ACCUEIL').html("Chargement en cours");
        var json = {
            domaine: 'acces',
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
                        g_acces.affiche_retour(html);
                    }
                }
        );
    }

    affiche_retour(html) {
        $('#DIV_ACCUEIL').html(html);
        g_acces.ecoute_evenements_acces();
    }
    
    ecoute_evenements_acces() {
        $('#FRM_ACCES_SUBMIT').click(function (e) {
            var donnees = $('#FRM_ACCES').serializeArray();
            g_acces.traite_acces(donnees);
            e.preventDefault();
        });
    }
    
    traite_acces = function (donnees) {
    var json = {
        domaine: 'acces',
        action: 'controle',
        donnees: donnees
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'json',
                success: function (data) {
                    if (data.erreur === "non") {
                        g_accueil = new C_Accueil();
                        g_accueil.affiche();
                    } else {
                        document.getElementById('MDL_ACCES').style.display='block';
                    }
                }
            });
};
}
