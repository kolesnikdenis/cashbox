
function init() {
     var table = document.createElement('table');
     table.setAttribute("border", "2");
      for (var i = 0; i < 4; i++) {
     var tr = document.createElement('tr');
     for (var j = 0; j < 5; j++) {
                var td = document.createElement('td');
                td.bgcolor = "#ADDDE6";
                if ( i ==0 ){ var id="20";  }
                if ( i ==1 ){ var id="40"; }
                if ( i ==2 ){ var id="75"; }
                if ( i ==3 ){ var id="100"; }
                var cellText="";
                if ( j == 0 ) { cellText= document.createElement("div");
                              cellText.setAttribute("id", "magazin_"+id); }
                if ( j == 1 ) { cellText = document.createElement("div");
                              cellText.setAttribute("id", "cas_"+id); }
                if ( j == 2 ) { cellText = document.createElement("input");
                              cellText.type = "text";
                              cellText.size = "4";
                              cellText.value="0";
                              cellText.name="count_cas_"+id;
                              cellText.id  = "count_cas_id_"+id;
                              cellText.onchange =  function(){ calc(); return; };}
                if ( j == 3 ) { cellText = document.createElement("div");
                              cellText.setAttribute("id", "cls_"+id); }
                if ( j == 4 ) { cellText = document.createElement("input");
                              cellText.type = "text";
                              cellText.size = "4";
                              cellText.value="0";
                              cellText.name="count_cls_"+id;
                              cellText.id  = "count_cls_id_"+id;
                              cellText.onchange =  function(){ calc(); return; }; }

                td.appendChild(cellText);
                tr.appendChild(td);

        }
        table.appendChild(tr);
      }
return table;
   }


function calc(){

var summ_cas20 =document.getElementById("count_cas_id_20").value * 20;
var summ_cls20 =document.getElementById("count_cls_id_20").value * 20;
var summ_cas40 =document.getElementById("count_cas_id_40").value  * 40;
var summ_cls40 =document.getElementById("count_cls_id_40").value  * 40;
var summ_cas75 =document.getElementById("count_cas_id_75").value  * 75;
var summ_cls75 =document.getElementById("count_cls_id_75").value  * 75;
var summ_cas100 =document.getElementById("count_cas_id_100").value  * 100;
var summ_cls100 =document.getElementById("count_cls_id_100").value  * 100;

var summ_cas=summ_cas20+summ_cas40+summ_cas75+summ_cas100;
var summ_cls=summ_cls20+summ_cls40+summ_cls75+summ_cls100;


var out = "<table><tr><td>�������:</td><td>������:</td></tr><tr><td>";
    out += document.getElementById("count_cas_id_20").value+" * 20 = " + summ_cas20 +"<br>";
    out += document.getElementById("count_cas_id_40").value+" * 40 = " + summ_cas40 +"<br>";
    out += document.getElementById("count_cas_id_75").value+" * 75 = " + summ_cas75 +"<br>";
    out += document.getElementById("count_cas_id_100").value+" * 100 = " + summ_cas100 +"<br>";
    out += "<b>?????:";
    out += summ_cas+"</b>";
    out += "</td><td>";
    out += document.getElementById("count_cls_id_20").value+" * 20 = " + summ_cls20 +"<br>";
    out += document.getElementById("count_cls_id_40").value+" * 40 = " + summ_cls40 +"<br>";
    out += document.getElementById("count_cls_id_75").value+" * 75 = " + summ_cls75 +"<br>";
    out += document.getElementById("count_cls_id_100").value+" * 100 = " + summ_cls100 +"<br>";
    out += "<b>?????:";
    out += summ_cls+"</b>";
    out += "</td></tr></table>";
    var ostatok="4000";
    out += "??????: "+summ_cls20 + " + " +summ_cls40  + " + " + summ_cls75 + " + " + summ_cls100+" = " + summ_cls + "<br>";
    out += "???????: "+summ_cas20 + " + " +summ_cas40  + " + " + summ_cas75 + " + " + summ_cas100+" = " + summ_cas + "<br>";

    var sold_shop = ostatok - summ_cas;
    var profit_shop = sold_shop*0.05;
    var profit_company_ots = sold_shop-profit_shop;
    out += "????????? ????????: "+ ostatok + " - " + summ_cas + " = " + sold_shop +  " * 5% = " + profit_shop + "<br>";
    out += "?????? ??? ???????: "+ ostatok + " - " + summ_cas + " = " +  sold_shop +  " - 5%(" + profit_shop + ") = " + profit_company_ots +"<br>";
    out += "<hr>";
    out += "??????? ? ????????: ";
    summ_global=summ_cas+summ_cls;
    out += summ_cas   +  " + " + summ_cls + " ="+ summ_global;
    document.getElementById("calc_summ").innerHTML = out;
}


function create_select(name_select,id_select,onchange_select,array,selected){
 console.log("func create_select start");
  var sel = document.createElement('select');
  sel.name = name_select;
  sel.id = id_select;
  sel.rrc= "tt";
  sel.onchange =  function(){ calc(); return; };
  //sel.setAttribute("onclick", onchange_select);
  var options_str = "";
  array.forEach( function(arr_i,i,arr) {
    if (arr_i[0]  == selected) {options_str += '<option value="' + arr_i[0] + '" selected>' + arr_i[1] + '</option>';}else {
  	  options_str += '<option value="' + arr_i[0] + '">' + arr_i[1] + '</option>';}
  });
  sel.innerHTML = options_str;
  console.log(sel);
  return sel;

}




var table=init();
document.getElementById("addtable").appendChild(table);  // ???????? ??????? ? ??????????)
/* magazin name, nominal */
function add_select(magazin_id,nominal_card){
  var id_card="";
  console.log("func add_select start");
  if (nominal_card==100) { id_card = 2 };
  if (nominal_card==75) { id_card = 3 };
  if (nominal_card==40) { id_card = 1 };
  if (nominal_card==20) { id_card = 4 };
  var magazin_sel = create_select("magazin_"+nominal_card,"magazin_"+nominal_card+"_id","Add("+nominal_card+");",arr_shop,magazin_id);
  var cas = create_select("cas_"+nominal_card,"cas_"+nominal_card+"_id","Add("+nominal_card+");",arr_card_serial,id_card);
  var cls = create_select("cls_"+nominal_card,"cls_"+nominal_card+"_id","Add("+nominal_card+");",arr_card_serial,id_card);
  document.getElementById("magazin_"+nominal_card).appendChild(magazin_sel);
  document.getElementById("cas_"+nominal_card).appendChild(cas);
  document.getElementById("cls_"+nominal_card).appendChild(cls);
}
