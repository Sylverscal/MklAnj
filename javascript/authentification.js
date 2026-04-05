var g_authentification;

function C_authentification() {
    this.domaine = 'authentification';
    this.id_personne = 0;
}

C_authentification.prototype.affiche_formulaire = function () {
    var json = {
        domaine: this.domaine,
        action: 'affiche_formulaire'
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (data) {
                    $('#onglet').html(data);
                    $('#COU_AUT_connexion').submit(function (event) {
                        var donnees = $(this).serializeArray();
                        g_authentification.traite_formulaire(donnees);
                        event.preventDefault();
                    });
                }
            }
    );
}

C_authentification.prototype.traite_formulaire = function (donnees) {
    var json = {
        domaine: this.domaine,
        action: 'traite_formulaire',
        donnees: donnees
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'json',
                async: 'false',
                success: function (data) {
                    var id_personne = parseInt(data.id_personne);
                    if (id_personne === 0) {
                        $('#COU_AUT_message').html('<div class="alert alert-warning"><strong>Erreur dans authentification (La consultation des albums publics est possible)</div>')
                    } else {
                        g_authentification.id_personne = id_personne;
                        g_authentification.affiche_menus_selon_personne();
                    }
                }
            }
    );

}

C_authentification.prototype.affiche_menus_selon_personne = function () {
    switch (this.id_personne) {
        case 0:
            // Public
            active_bouton_onglet('#COU_albums_publics')
            $('#COU_albums_publics').removeClass('hidden');
            $('#COU_albums_prives').addClass('hidden');
            $('#COU_administration').addClass('hidden');
            $('#COU_albums_gestion').addClass('hidden');
            $('#COU_informations_utilisateur').addClass('hidden');
            g_authentification.affiche_personne_connectee();
            affiche_albums_publics();
            break;
        case 5:
            // Administrateur
            active_bouton_onglet('#COU_albums_gestion')
            $('#COU_albums_publics').addClass('hidden');
            $('#COU_albums_prives').addClass('hidden');
            $('#COU_administration').removeClass('hidden');
            $('#COU_albums_gestion').removeClass('hidden');
            $('#COU_informations_utilisateur').removeClass('hidden');
            g_authentification.affiche_personne_connectee();
            affiche_albums_gestion();
            break;

        default:
            // Utilisateur
            active_bouton_onglet('#COU_albums_prives')
            $('#COU_albums_publics').removeClass('hidden');
            $('#COU_albums_prives').removeClass('hidden');
            $('#COU_administration').addClass('hidden');
            $('#COU_albums_gestion').addClass('hidden');
            $('#COU_informations_utilisateur').removeClass('hidden');
            g_authentification.affiche_personne_connectee();
            affiche_albums_prives();
            break;
    }
}

C_authentification.prototype.affiche_personne_connectee = function () {
    if (this.id_personne === 3) {
        $('#COU_desauthentification').addClass('hidden');
        $('#COU_informations_utilisateur').addClass('hidden');
        $('#COU_authentification').removeClass('hidden');
    } else {
        var json = {
            domaine: this.domaine,
            action: 'affiche_personne_connectee',
            id_personne: this.id_personne
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (data) {
                        $('#COU_AUT_personne_connectee').html(data);
                        $('#COU_desauthentification').removeClass('hidden');
                        $('#COU_informations_utilisateur').removeClass('hidden');
                        $('#COU_authentification').addClass('hidden');
                    }
                }
        );
    }
}

C_authentification.prototype.is_le_patron = function () {
    if (this.id_personne === 5) {
        return true;
    } else {
        return false;
    }
}