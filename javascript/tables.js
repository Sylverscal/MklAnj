var g_table;
var g_element;

/**
 * Préparation écoute des boutons d'affichage des tables
 * @returns {undefined}
 */
function ecouteBoutonsTables() {
    var prefixe = 'GTB_BTN_';
    var selecteur = '[id^=' + prefixe + ']';
    $(selecteur).click(function () {
        var id = $(this).attr('id');
        var nomtable = id.slice(prefixe.length);
        changeCouleurBoutonTableChoisi(id);
        afficheTable(nomtable);
    });
}

function initialisationCouleurBoutonsTables() {
    $(".GTB_BTNS").each(function(){ 
      $(this).addClass("w3-sand");
      $(this).removeClass("w3-amber");
    });
}

function changeCouleurBoutonTableChoisi(id) {
    var x = document.getElementById(id);
    initialisationCouleurBoutonsTables();
    x.className = x.className.replace(" w3-sand", "");
    x.className += " w3-amber";

}

function afficheTable(nom_table) {
    g_table = new C_Table(nom_table);
    g_table.affiche();
}

function gereAccordeon(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") === -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}

function C_Table(nom_table) {
    this.nom_table = nom_table;
}

C_Table.prototype.affiche = function () {
    this.afficheEntete();
};

C_Table.prototype.afficheEntete = function () {
    var json = {
        domaine: 'gestion_table',
        action: 'afficheTitre',
        nom_table: this.nom_table
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (html) {
                    $('#GTB_DIV_TITRE').html(html);
                    $('#GTB_DIV_CORPS').html("Chargement en cours");
                    g_table.afficheCorps();
                }
            }
    );
};

C_Table.prototype.afficheCorps = function () {
    var json = {
        domaine: 'gestion_table',
        action: 'afficheTable',
        nom_table: this.nom_table
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                async: 'false',
                success: function (html) {
                    $('#GTB_DIV_CORPS').html(html);
                    $('a[id^="element-"').on("click", function () {
                        var href = $(this).attr('id');
                        var tab = href.split('-');
                        g_element = new C_Element(tab[1], tab[2]);
                        g_element.afficheEdition();
                    });
                    parametre_datatable('LIB_Table');
                    $('#ajouter').on("click", function () {
                        g_element = new C_Element(g_table.nom_table, 0);
                        g_element.afficheEdition();
                    });
                }
            }
    );
};



function C_Element(nom_table, id) {
    this.nom_table = nom_table;
    this.id = id;
}

C_Element.prototype.afficheEdition = function () {
    var json = {
        domaine: 'gestion_table',
        action: 'afficheEdition',
        nom_table: this.nom_table,
        id: this.id
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'html',
                success: function (html) {
                    $('#GTB_DIV_CORPS').html(html);
                    $('#element-annuler').click(function (e) {
                        g_table.afficheCorps();
                        e.preventDefault();
                    });
                    $('#element-modifier').click(function (e) {
                        var donnees = $('#formulaire-element').serializeArray();
                        g_element.traiteModification(donnees);
                        e.preventDefault();
                    });
                    $('#element-supprimer').click(function (e) {
                        e.preventDefault();
                    });
                    $('#element-supprimer-oui').on("click", function (e) {
                        g_element.traiteSuppression();
                        e.preventDefault();
                    });
                    $('#element-ajouter').click(function (e) {
                        var donnees = $('#formulaire-element').serializeArray();
                        g_element.traiteAjout(donnees);
                        e.preventDefault();
                    });
                }
            });
};

C_Element.prototype.traiteModification = function (donnees) {
    var json = {
        domaine: 'gestion_table',
        action: 'traiteModification',
        nom_table: this.nom_table,
        id: this.id,
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
                        g_table.afficheCorps();
                    } else {
                        $('#erreur_resume').html(data.erreur_resume);
                        g_element.afficheErreurDetail(data.erreur_detail);
                        document.getElementById('element-erreur-format').style.display='block';
                    }
                }
            });
};
C_Element.prototype.traiteAjout = function (donnees) {
    var json = {
        domaine: 'gestion_table',
        action: 'traiteAjout',
        nom_table: this.nom_table,
        id: this.id,
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
                        g_table.afficheCorps();
                    } else {
                        $('#erreur_resume').html(data.erreur_resume);
                        g_element.afficheErreurDetail(data.erreur_detail);
                        document.getElementById('element-erreur-format').style.display='block';
                    }
                }
            });
};
C_Element.prototype.afficheErreurDetail = function(tab) {
    let html = "";
    for (let i = 0; i < tab.length; i++) {
      let message = tab[i];
      
      html = html + "<h5 class='w3-khaki'>" + message + "</h5>";
    }
    
    $('#erreur_detail').html(html);

};
C_Element.prototype.traiteSuppression = function () {
    var json = {
        domaine: 'gestion_table',
        action: 'traiteSuppression',
        nom_table: this.nom_table,
        id: this.id
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'json',
                success: function (data) {
                    if (data.erreur === "non") {
                        g_table.afficheCorps();
                    } else {
                        $('#erreur_resume').html(data.erreur_resume);
                        g_element.afficheErreurDetail(data.erreur_detail);
                        document.getElementById('element-erreur-format').style.display='block';
                    }
                }
            });
};

