/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
/* global g_log_visualisation, g_achats, g_graphiques */

class C_Achats {
    constructor() {
        this.id = 0;
        this.filtres = new C_Filtres();
        $('#TXT_ACH_FILTRE').html("");
    }
    afficheFenetre() {
        this.afficheListeAchats();
    }
    ecouteEvenements() {
        // Ecoute le choix dans le menu Domaine
        $('#SEL_ACH_DOMAINE').change(function () {
            var id = $(this).val();
            g_achats.enregistreDomaineChoisi(id);
        });
        // Ecoute d'un clic sur le bouton de raz du filtre
        $('#BTN_ACH_FILTRE_RAZ').click(function(e) {
            e.preventDefault();
            g_achats.filtres = new C_Filtres();
            g_achats.filtres.affiche();
            g_achats.afficheListeAchats();
        });
        // Ecoute les boutons de gestion des achats
        $('#BTN_ACH_GDA_CREE').click(function() {
            $('#DIV_ACH_GDA').hide();
            g_achats.gestionAchatsAfficheFormulaire(0);
        });
        $('#BTN_ACH_GDA_MODIFIE').click(function() {
            var id = g_achats.id;
            if (id === 0) return;
            $('#DIV_ACH_GDA').hide();
            g_achats.gestionAchatsAfficheFormulaire(id);
        });
        $('#BTN_ACH_GDA_SUPPRIME').click(function() {
            var id = g_achats.id;
            if (id === 0) return;
            g_achats.gestion_achats_supprime(id);
        });
        $('#BTN_ACH_GDA_DUPLIQUE').click(function() {
            var id = g_achats.id;
            if (id === 0) return;
            g_achats.gestion_achats_duplique(id);
        });
        $('#SEL_ACH_GDA_GRAPHIQUE').change(function() {
            var num_choix = $(this).children("option:selected").val();
            if (num_choix === 0) {
                return;
            }
            if (g_achats.id === 0) {
                return;
            }
            g_achats.afficheGraphique(num_choix,g_achats.id);
        });
        // Ecoute la sélection d'une valeur dans les filtre sur une table 
        $(".SEL_ACH_GDA_FILTRE").change(function() {
            var id = $(this).children("option:selected").val();
            var texte = $(this).children("option:selected").text();
            if (id === "-") {
                return;
            }
            g_achats.filtres.controleExistance(id,texte);
            g_achats.filtres.affiche();
            g_achats.ecouteBoutonsFiltre();
            g_achats.afficheListeAchatsFiltree();
        });
        $("#BTN_FILTRE_IDENTIQUES").click(function(){
            var id = g_achats.id;
            if (id === 0) {
                return;
            }
            g_achats.afficheListeAchatsMemeArticle(id);
        });
    }
    
    afficheListeAchatsMemeArticle(id) {
        $('#ONG_contenu').html("<h4>Op&eacuteration en cours</h4>");
        var json = {
            domaine: 'achats',
            action: 'afficheListeAchatsMemeArticle',
            id_achat: id
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_achats.afficheListeAchats_Retour(html);
                    }
                }
        );
    }
    
    enregistreDomaineChoisi(id) {
        var json = {
            domaine: 'achats',
            action: 'enregistreDomaineChoisi',
            id: id
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'json',
                    success: function (crdu) {
                        g_achats.enregistreDomaineChoisi_retour(crdu);
                    }
                }
        );
    }
    
    enregistreDomaineChoisi_retour(crdu) {
        afficheModalCompteRendu(crdu);
        g_achats.afficheListeAchats();
        g_achats.filtres = new C_Filtres();
        g_achats.filtres.affiche();
    }
    
    afficheListeAchats() {
        $('#ONG_contenu').html("<h4>Op&eacuteration en cours</h4>");
        var json = {
            domaine: 'achats',
            action: 'afficheListeAchats'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_achats.afficheListeAchats_Retour(html);
                    }
                }
        );
    }
    
    afficheListeAchatsFiltree() {
        $('#ONG_contenu').html("<h4>Op&eacuteration en cours</h4>");
        var tab = g_achats.filtres.getTableau();
        var json = {
            domaine: 'achats',
            action: 'afficheListeAchatsFiltree',
            filtre: tab
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_achats.afficheListeAchatsFiltree_Retour(html);
                    }
                }
        );
    }
    
    afficheListeAchats_Retour(html) {
        g_achats.id = 0;
        $("#DIV_ACH_ACHATS").html(html);
        g_achats.affichePosteDeCommande();
    }
    
    afficheListeAchatsFiltree_Retour(html) {
        $("#DIV_ACH_ACHATS").html(html);
//        g_achats.ecouteEvenements();
        g_achats.ecouteEvenementsTableauAchats();
    }
    
    affichePosteDeCommande() {
        var tab = g_achats.filtres.getTableau();
        var json = {
            domaine: 'achats',
            action: 'affichePosteDeCommande'
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_achats.affichePosteDeCommande_retour(html);
                    }
                }
        );
    }
    
    affichePosteDeCommande_retour(html) {
        $("#DIV_ACH_GDA").html(html);
        g_achats.ecouteEvenements();
        $('#DIV_ACH_GDA').show();
        g_achats.ecouteEvenementsTableauAchats();
    }
    
    ecouteEvenementsTableauAchats() {
        // Ecoute des clics sur une ligne du tableau
        var selecteur = "#TBL_LISTE_ACHATS tr";
        $(selecteur).click(function () {
            g_achats.razSelectionLigne();
            $(this).addClass("w3-pale-red");
            g_achats.id = $(this).attr('id');
        });
//        $(selecteur).dblclick(function () {
//            g_achats.razSelectionLigne();
//            $(this).addClass("w3-pale-red");
//            g_achats.id = $(this).attr('id');
//            var id = g_achats.id;
//            if (id === 0) return;
//            $('#DIV_ACH_GDA').hide();
//            g_achats.gestionAchatsAfficheFormulaire(id);
//        });
        // Ecoute des clics sur les éléments du tableau de achats pour ajouter un filtre 
        $(".BTN_ACH_FILTRE").click(function() {
            var id = $(this).attr("id");
            var texte = $(this).text();
            g_achats.filtres.controleExistance(id,texte);
            g_achats.filtres.affiche();
            g_achats.ecouteBoutonsFiltre();
            g_achats.afficheListeAchatsFiltree();
        });
        // Ecoute d'un changement de valeur dans le champ Date
        $('.INP_ACH_DATE').change(function() {
            var texte = $(this).val();
            var id = $(this).attr("id");
            var m = new C_Datation(texte);
            if (m.isFormatOk()) {
                $(this).removeClass("w3-text-red");
                $(this).addClass("w3-text-black");
                g_achats.modifieValeur('datation',id,texte);
            } else {
                $(this).removeClass("w3-text-black");
                $(this).addClass("w3-text-red");
            }
        });
        // Ecoute d'un changement de valeur dans le champ Montant
        $('.INP_ACH_MONTANT').change(function() {
            var texte = $(this).val();
            var id = $(this).attr("id");
            var m = new C_Montant(texte);
            if (m.isFormatOk()) {
                $(this).removeClass("w3-text-red");
                $(this).addClass("w3-text-black");
                g_achats.modifieValeur('montant',id,texte);
            } else {
                $(this).removeClass("w3-text-black");
                $(this).addClass("w3-text-red");
            }
        });
    }
    
    gestion_achats_modifie(id) {
    var json = {
        domaine: 'achats',
        action: 'modifie',
        id: id
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'json',
                success: function (crdu) {
                    g_achats.gestion_achats_retour(crdu);
                }
            }
        );
    }
        
    gestion_achats_supprime(id) {
    var json = {
        domaine: 'achats',
        action: 'supprime',
        id: id
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'json',
                success: function (crdu) {
                    g_achats.gestion_achats_retour(crdu);
                }
            }
        );
    }
        
    gestion_achats_duplique(id) {
    var json = {
        domaine: 'achats',
        action: 'duplique',
        id: id
    };
    $.ajax(
            {
                type: 'POST',
                url: g_chemin_ajax + 'ajax.php',
                data: json,
                dataType: 'json',
                success: function (crdu) {
                    g_achats.gestion_achats_retour(crdu);
                }
            }
        );
    }
    
    gestion_achats_retour(crdu) {
        afficheModalCompteRendu(crdu);
        g_achats.razSelectionLigne();
        g_achats.afficheListeAchats();
    }
    
    gestionAchatsAfficheFormulaire(id) {
        $('#ONG_contenu').html("<h4>Op&eacuteration en cours</h4>");
        var json = {
            domaine: 'achats',
            action: 'afficheFormulaire',
            id: id
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_achats.gestionAchatsAfficheFormulaire_Retour(html);
                    }
                }
        );
    }
    
    gestionAchatsAfficheFormulaire_Retour(html) {
        $("#DIV_ACH_ACHATS").html(html);
        g_achats.ecouteEvenementsFormulaire();
    }
    
    ecouteEvenementsFormulaire() {
        $('#FRM_ACH_SUBMIT').click(function (e) {
            var donnees = $('#FRM_ACH').serializeArray();
            g_achats.traiteModification(donnees);
            e.preventDefault();
        });
        $("#FRM_ACH_ANNULE").click(function(){
            const id_memo = $("#FRM_ACH_ID_MEMO").val();
            const id_annule = $("#FRM_ACH_ID").val();
            if (id_memo === "0") {
                g_achats.annuleAchatTemporaire(id_annule);
            } else {
                g_achats.afficheListeAchats();
            }
        });
        $(".FRM_ACH_INP_SEL").change(function(){
            var texte = $(this).children("option:selected").text();
            var id = $(this).attr('id');
            
            var selecteur = "#"+id+".FRM_ACH_INP_TXT";
            $(selecteur).val(texte);
        });
        $(".FRM_ACH_INP_SEL_BLOC").change(function(){
            var id = $(this).children("option:selected").val();
            var nom_table = $(this).attr('id');
            
            g_achats.getDonneesBloc(nom_table,id);
        });
        $(".FRM_ACH_INP_TXT#Contenant_quantite").on('input', function() {
            g_achats.modifie_valeur_article_capacite();
        });
        $(".FRM_ACH_INP_TXT#Article_capacite").on('input', function() {
            g_achats.modifie_valeur_contenant_capacite();
        });
        $(".FRM_ACH_INP_TXT#Contenant_capacite").on('input', function() {
            g_achats.modifie_valeur_article_capacite();
        });
    }
    
    modifie_valeur_contenant_capacite() {
        const a_c = $(".FRM_ACH_INP_TXT#Article_capacite").val();
        const c_q = $(".FRM_ACH_INP_TXT#Contenant_quantite").val();

        var c_c = 0;
        
        if (c_q !== 0) {
             c_c = Math.floor(a_c / c_q);
        }
        
        $(".FRM_ACH_INP_TXT#Contenant_capacite").val(c_c);        
    }
    
    modifie_valeur_article_capacite() {
        const c_c = $(".FRM_ACH_INP_TXT#Contenant_capacite").val();
        const c_q = $(".FRM_ACH_INP_TXT#Contenant_quantite").val();

        const a_c = c_c * c_q;
        
        $(".FRM_ACH_INP_TXT#Article_capacite").val(a_c);        
    }
    
    traiteModification = function (donnees) {
        var json = {
            domaine: 'achats',
            action: 'traiteModification',
            donnees: donnees
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'json',
                    success: function (data) {
                        g_achats.traiteModification_retour(data);
                    }
                });
    };
    
    traiteModification_retour(data) {
        if (data.erreur === "non") {
            g_achats.afficheListeAchats();
        } else {
            $('#COU_MODAL_ERREUR_RESUME').html(data.erreur_resume);
            afficheModalCompteRenduDetail(data.erreur_detail);
            document.getElementById('COU_MODAL_ERREUR').style.display='block';
        }
    }
    
    razSelectionLigne() {
        $("#TBL_LISTE_ACHATS tr").removeClass("w3-pale-red");
        g_achats.id = 0;
    }
    
    ecouteBoutonsFiltre() {
        // Ecoute d'un clic sur un bouton du filtre pour supprimer ce filtre
        $('.BTN_ACH_FILTRE_SUPPR').click(function() {
            var id = $(this).attr('id');
            g_achats.filtres.supprimeFiltre(id);
            g_achats.filtres.affiche();
            g_achats.ecouteBoutonsFiltre();
            g_achats.afficheListeAchatsFiltree();
        });
    }
    
    modifieValeur(colonne,id_achat,valeur) {
        var json = {
            domaine: 'achats',
            action: 'modifieValeur',
            id_achat: id_achat,
            colonne: colonne,
            valeur: valeur
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'json',
                    success: function (crdu) {
                        afficheModalCompteRendu(crdu);
                    }
                });
    }

    annuleAchatTemporaire(id_annule) {
        var json = {
            domaine: 'achats',
            action: 'annuleAchatTemporaire',
            id_annule: id_annule
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'json',
                    success: function (crdu) {
                        afficheModalCompteRendu(crdu);
                        g_achats.annuleAchatTemporaire_retour();
                       
                    }
                });
    }
    
    annuleAchatTemporaire_retour() {
        g_achats.afficheListeAchats();
    }

    getDonneesBloc(nom_table,id) {
        var json = {
            domaine: 'achats',
            action: 'getDonneesBloc',
            nom_table: nom_table,
            id: id
        };
        $.ajax(
                {
                    type: 'POST',
                    url: g_chemin_ajax + 'ajax.php',
                    data: json,
                    dataType: 'json',
                    success: function (data) {
                        g_achats.getDonneesBloc_retour(data);
                       
                    }
                });
    }
    
    getDonneesBloc_retour(data) {
        for (let i = 0; i < data.length; i++) {
            var element = data[i];
            const id = element.id;
            const value = element.index;
            
            var selecteur = "#"+id+".FRM_ACH_INP_TXT";

            $(selecteur).val(value);
        }
    }
    
    afficheGraphique(num_choix,id_achat) {
        var json = {
            num_graphique: num_choix,
            id_achat: id_achat
        };
        
        const parametres = "?num_graphique="+num_choix+"&id_achat="+id_achat;
        
        const url = "https://courses:8890/graphique.php"+parametres;
        
        window.open(url, "_blank");
    }
}

class C_Montant {
    constructor (valeur) {
        this.valeur = valeur;
    }
    
    isFormatOk() {
        if (this.valeur.search(/^\d+,\d{2}€?$/i) === -1) {
            return false;
        }
        return true;
    }
}

class C_Datation {
    constructor (valeur) {
        this.valeur = valeur;
    }
    
    isFormatOk() {
        if (this.valeur.search(/^\d{2}-\d{2}-\d{4}$/i) === -1) {
            return false;
        }
        const tab = this.valeur.split("-");
        
        const dAMJ = tab[2]+"-"+tab[1]+"-"+tab[0];
        
        const d = new Date(dAMJ);
        if (isNaN(d)) {
            return false;
        }
        
        if (!this.isJourOk(tab))
        {
            return false;
        }
        
        return true;
    }
    
    isJourOk(tab_JMA) {
        const J = parseInt(tab_JMA[0]);
        const M = parseInt(tab_JMA[1]);
        const A = parseInt(tab_JMA[2]);

        if (J < 1 || J > 31) return false;
        if (M < 1 || M > 12) return false;
        
        const isB = this.isAnneeBissextile(A);
        
        if ((M===1) && J > 31) return false;
        if (M===2 && J > 29) return false;
        if (M===2 && J > 28 && !isB) return false;
        if (M===3 && J > 31) return false;
        if (M===4 & J > 30) return false;
        if (M===5 && J > 31) return false;
        if ((M===6) && (J > 30)) return false;
        if (M===7 && J > 31) return false;
        if (M===8 && J > 31) return false;
        if (M===9 && J > 30) return false;
        if (M===10 && J > 31) return false;
        if (M===11 && J > 30) return false;
        if (M===12 && J > 31) return false;
        
        return true;
    }
    
    isAnneeBissextile(A) {
        if (A % 4 !== 0) return false;
        if (A % 100 === 0 && A % 400 !== 0) return false;
        
        return true;
    }
}

/**
 * Classe pour gérer la liste de filtres
 * 
 */
class C_Filtres {
    constructor () {
        this.liste = new Array();
        this.html = "";
    }
    
    getHtml() {
        let html_total = "";
        for (let i = 0; i < g_achats.filtres.liste.length; i++) {
            var filtre = g_achats.filtres.liste[i];
            var html = filtre.getHtml();
            html_total = html_total + html;
        }
        return html_total;
    }
    

    controleExistance(filtre,valeur) {
        var filtre_nouveau = new C_Filtre(filtre,valeur);
        
        for (let i = 0; i < g_achats.filtres.liste.length; i++) {
            var filtre_ancien = g_achats.filtres.liste[i];
            if (filtre_ancien.nom_base === filtre_nouveau.nom_base) {
                filtre_ancien.valeur = filtre_nouveau.valeur;
                return;
            }
        }
       
        g_achats.filtres.liste.push(filtre_nouveau);
    }
    
    affiche() {
        const html = g_achats.filtres.getHtml();
        $('#TXT_ACH_FILTRE').html(html);
    }
    
    supprimeFiltre(nom_base) {
        for (let i = 0; i < g_achats.filtres.liste.length; i++) {
            var filtre = g_achats.filtres.liste[i];
            if (filtre.nom_base === nom_base) {
                g_achats.filtres.liste.splice(i,1);
                return;
            }
        }
    }
    
    getTableau() {
        var tab = [];
        
        for (let i = 0; i < g_achats.filtres.liste.length; i++) {
            var filtre = g_achats.filtres.liste[i];
            tab.push([filtre.nom_base,filtre.valeur]);
        }
        
        return tab;
    }
}

/**
 * Classe pour gérer un filtre
 * @type type
 */
class C_Filtre {
    constructor(filtre,valeur) {
        this.nom_base = filtre;
        this.nom_affichage = filtre;
        this.valeur = valeur;
        
        this.splitNomFiltre();
    }
    
    splitNomFiltre() {
        const tab = this.nom_base.split("@");
        
        if (tab.length === 2) {
            this.nom_base = tab[0];
            this.nom_affichage = tab[1];
        }
    }
    
    getHtml() {
        const html = "<button id='"+this.nom_base+"' class='w3-button w3-yellow w3-hover-orange w3-round w3-border w3-border-blue w3-padding-small BTN_ACH_FILTRE_SUPPR'>"+this.valeur+"</button>";
        
        return html;
    }
    
}