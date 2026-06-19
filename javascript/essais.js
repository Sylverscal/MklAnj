/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var g_essais;

class C_Essais {
    
    ecoute_evenements() {
        $('#BTN_DATATION').click(function(){
            document.getElementById('COU_MODAL_DATATION').style.display='block';
            g_datation = new C_Datation();
            g_datation.ecouteEvenements();
        });
    }
}