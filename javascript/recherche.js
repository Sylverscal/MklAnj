/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var g_recherche;

class C_Recherche {
    affiche() {
        $('#DIV_RECHERCHE').html("<h4>Op&eacuteration en cours</h4>");
        var json = {
            domaine: 'recherche',
            action: 'affiche'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_recherche.affiche_retour(html);
                    }
                }
        );
    }
    
    affiche_retour(html) {
        $('#DIV_RECHERCHE').html(html);
    }
}