/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var g_datation;

class C_Datation {
    ecouteEvenements() {
        $('#COU_MODAL_DATATION_SANS').click(function(){
            $('#INP_DATATION').val("-");
        });
        $('#COU_MODAL_DATATION_VENDREDI_PROCHAIN').click(function(){
            $('#INP_DATATION').val(g_datation.getDateProchainVendredi());
        });
    }
    
    getDateProchainVendredi() {
        var d_ahui = new Date();
        
        let d_ahui_j = d_ahui.getDay();
        
        let diff = g_datation.getDifferenceJoursAvecProchainVendredi(d_ahui);
        
        var d_v = new Date();
        d_v.setDate(d_ahui.getDate() + diff);
        
        
        
        return g_datation.getdateFormatee(d_v);
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
    
    getdateFormatee(d) {
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
}
