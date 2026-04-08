/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var g_adm_init_base;

class C_adm_init_base {
    ecoute_objets_bloc_initialisation_base() {
        $('#BTN_LANCE_IMPORT_DONNEES').click(function () {
            g_adm_init_base.import_donnees();
        });
    }
    
    import_donnees() {
        var json = {
            domaine: 'adm_init_base',
            action: 'import_donnees'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'json',
                    success: function (data) {
                        if (data.erreur === "non") {
                            $('#COU_MODAL_ERREUR_RESUME').html(data.erreur_resume);
                            $('#COU_MODAL_TITRE').text("Compte rendu import données");
                            $('#COU_MODAL_ACTION').text("Tout s'est bien passé");
                            g_adm_init_base.afficheErreurDetail(data.erreur_detail);
                            document.getElementById('COU_MODAL_ERREUR').style.display='block';
                        } else {
                            $('#COU_MODAL_ERREUR_RESUME').html(data.erreur_resume);
                            $('#COU_MODAL_TITRE').text("Compte rendu import données");
                            $('#COU_MODAL_ACTION').text("CRASH !!!");
                            g_adm_init_base.afficheErreurDetail(data.erreur_detail);
                            document.getElementById('COU_MODAL_ERREUR').style.display='block';
                        }
                    }
                }
        );
    }

    afficheErreurDetail(tab) {
        let html = "";
        for (let i = 0; i < tab.length; i++) {
          let message = tab[i];

          html = html + "<h5 class='w3-khaki'>" + message + "</h5>";
        }

        $('#COU_MODAL_ERREUR_DETAIL').html(html);
    }

}



