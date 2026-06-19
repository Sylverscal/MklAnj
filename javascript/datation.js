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
        console.log(d_ahui);
        
        let d_ahui_j = d_ahui.getDay();
        console.log(d_ahui_j);
        
        let diff = g_datation.getDifferenceJoursAvecProchainVendredi(d_ahui);
        
        console.log(diff);
        
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
}
