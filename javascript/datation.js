/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var g_datation;

class C_Datation {
    ecouteEvenements() {
        $('#COU_MODAL_DATATION_OK').click(function(){
            let d = $('#COU_MODAL_DATE_CHOISIE').text();
            $('#INP_DATATION').val(d);
        });
        $('#COU_MODAL_DATATION_SANS').click(function(){
            $('#INP_DATATION').val("-");
        });
        $('#COU_MODAL_DATATION_VENDREDI_PROCHAIN').click(function(){
            $('#INP_DATATION').val(g_datation.getdateFormateeDDMMAAAA(g_datation.getDateProchainVendredi()));
        });
        $('#COU_MODAL_DATATION_MOIS_PREC').click(function(){
            let d = g_datation.getDateMoisPrec();
            $('#COU_MODAL_DATE_CHOISIE').text(g_datation.getdateFormateeDDMMAAAA(d));
            g_datation.afficheNomMois(d);
            g_datation.afficheGrilleJours();
        });
        $('#COU_MODAL_DATATION_AHUI').click(function(){
            let d = g_datation.getDateAhui();
            $('#COU_MODAL_DATE_CHOISIE').text(g_datation.getdateFormateeDDMMAAAA(d));
            g_datation.afficheNomMois(d);
            g_datation.afficheGrilleJours();
        });
        $('#COU_MODAL_DATATION_MOIS_SUCC').click(function(){
            let d = g_datation.getDateMoisSucc();
            $('#COU_MODAL_DATE_CHOISIE').text(g_datation.getdateFormateeDDMMAAAA(d));
            g_datation.afficheNomMois(d);
            g_datation.afficheGrilleJours();
        });
    }
    
    afficheGrilleJours() {
        let datation = $('#COU_MODAL_DATE_CHOISIE').text();
        var json = {
            domaine: 'datation',
            action: 'affiche_grille_jours',
            datation: datation
        };
        $.ajax(
                {
                    type: 'POST',
                    url: 'ajax/ajax.php',
                    data: json,
                    dataType: 'html',
                    async: 'false',
                    success: function (html) {
                        g_datation.afficheGrilleJours_retour(html);
                    }
                }
        );
    }
    
    afficheGrilleJours_retour(html) {
        $('#COU_MODAL_GRILLE_JOURS').html(html);
    }
    getDateAhui() {
        var d_ahui = new Date();
        
        return d_ahui;
    }
    
    getDateMoisPrec() {
        let s_d_actuelle_text = $('#COU_MODAL_DATE_CHOISIE').text();
        
        let d_actuelle = g_datation.getDateConvertieFormatIso(s_d_actuelle_text);
        
        var d_mois_prec = new Date(d_actuelle);
        d_mois_prec.setDate(d_mois_prec.getDate() - (g_datation.getNbJoursMois(d_mois_prec)));
        
        return d_mois_prec;
    }
    
    getDateMoisSucc() {
        let s_d_actuelle_text = $('#COU_MODAL_DATE_CHOISIE').text();
        
        let d_actuelle = g_datation.getDateConvertieFormatIso(s_d_actuelle_text);
        
        var d_mois_prec = new Date(d_actuelle);
        d_mois_prec.setDate(d_mois_prec.getDate() + (g_datation.getNbJoursMois(d_mois_prec)));
        
        return d_mois_prec;
    }
    
    getDateProchainVendredi() {
        var d_ahui = new Date();
        
        let diff = g_datation.getDifferenceJoursAvecProchainVendredi(d_ahui);
        
        var d_v = new Date();
        d_v.setDate(d_ahui.getDate() + diff);
        
        return d_v;
    }
    
    getDifferenceJoursAvecProchainVendredi(d) {
        let noj_ahui = d.getDay();
        let noj_v = 5;
        
        let diff = 0;
        if (noj_ahui < noj_v) {
            diff = noj_v - noj_ahui;
        }
        if (noj_ahui === noj_v) {
            let h = d.getHours();
            
            if (h < 8) {
                diff = noj_v - noj_ahui;
            } else {
                diff = 7 - (noj_ahui - noj_v);
            }
        }
        if (noj_ahui > noj_v) {
            diff = 7 - (noj_ahui - noj_v);
        }
        
        return diff;
    }
    
    getdateFormateeDDMMAAAA(d) {
        let jj = d.getDate();
        let mm = d.getMonth()+1;
        let aaaa = d.getFullYear();
        
        let jj0 = "";
        if (jj < 10) {
            jj0 = "0";
        }
        
        let mm0 = "";
        if (mm < 10) {
            mm0 = "0";
        }
        
        let datation = jj0+jj+"-"+mm0+mm+"-"+aaaa;
        
        return datation ;
    }
    
    getDateConvertieFormatIso(s_d) {
        let tab = s_d.split("-");
        
        let s_d_iso = tab[2]+"-"+tab[1]+"-"+tab[0];
        
        let d_iso = new Date(s_d_iso);
        
        return d_iso ;
    }
    
    getNomMois(d) {
        let mm = d.getMonth();
        
        return g_datation.getListeNomsMois()[mm];
    }
    
    getNbJoursMois(d) {
        let mm = d.getMonth();
        
        let nb_jours = g_datation.getListeNbJoursMois()[mm];
        return nb_jours;
    }
    
    getListeNomsMois() {
        return ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
    }
    
    getListeNbJoursMois() {
        return [31,28,31,30,31,30,31,31,30,31,30,31];
    }
    
    afficheNomMois(d) {
        let nom_mois = g_datation.getNomMois(d)+" "+d.getFullYear();
        
        $('#COU_MODAL_MOIS').text(nom_mois);
    }
}
