
function init() {
    var d = new Date();
    var curr_date = d.getDate();
    var curr_month = d.getMonth() + 1;
    var curr_year = d.getFullYear();

     var table = document.createElement('table');
     table.setAttribute("border", "2");
      for (var i = 0; i < 4; i++) {
     var tr = document.createElement('tr');

     for (var j = 0; j < 6; j++) {
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
                if ( j == 5 ) { cellText = document.createElement("input");
                              cellText.type = "text";
                              cellText.size = "10";
                              cellText.value=curr_year + "-" + curr_month + "-" + curr_date;
                              cellText.name="date_"+id;
                              cellText.id  = "datepicker";
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


    var out = "<table><tr><td>остаток:</td><td>приход:</td></tr><tr><td>";
        out += document.getElementById("count_cas_id_20").value+" * 20 = " + summ_cas20 +"<br>";
        out += document.getElementById("count_cas_id_40").value+" * 40 = " + summ_cas40 +"<br>";
        out += document.getElementById("count_cas_id_75").value+" * 75 = " + summ_cas75 +"<br>";
        out += document.getElementById("count_cas_id_100").value+" * 100 = " + summ_cas100 +"<br>";
        out += "<b>Остаток:";
        out += summ_cas+"</b>";
        out += "</td><td>";
        out += document.getElementById("count_cls_id_20").value+" * 20 = " + summ_cls20 +"<br>";
        out += document.getElementById("count_cls_id_40").value+" * 40 = " + summ_cls40 +"<br>";
        out += document.getElementById("count_cls_id_75").value+" * 75 = " + summ_cls75 +"<br>";
        out += document.getElementById("count_cls_id_100").value+" * 100 = " + summ_cls100 +"<br>";
        out += "<b>Приход:";
        out += summ_cls+"</b>";
        out += "</td></tr></table>";
        var ostatok="4000";
        out += "приход:"+summ_cls20 + " + " +summ_cls40  + " + " + summ_cls75 + " + " + summ_cls100+" = " + summ_cls + "<br>";
        out += "остаток: "+summ_cas20 + " + " +summ_cas40  + " + " + summ_cas75 + " + " + summ_cas100+" = " + summ_cas + "<br>";

        var sold_shop = ostatok - summ_cas;
        var profit_shop = sold_shop*0.05;
        var profit_company_ots = sold_shop-profit_shop;
        out += "зароботок магазина: "+ ostatok + " - " + summ_cas + " = " + sold_shop +  " * 5% = " + profit_shop + "<br>";
        out += "зароботок компании ОТС: "+ ostatok + " - " + summ_cas + " = " +  sold_shop +  " - 5%(" + profit_shop + ") = " + profit_company_ots +"<br>";
        out += "<hr>";
        out += "остаток на моммент расчета: ";
        summ_global=summ_cas+summ_cls;
        out += summ_cas   +  " + " + summ_cls + " ="+ summ_global;



        out += "<br><br><button name=save_sql onclick=\"save_to_sql();\">save</button>";
        var sql= "INSERT INTO `accounting`.`cashbox` (`id`, `magazine`, `serial_left`, `count_left`, `serial_add`, `count_add`, `data_time`) VALUES"+
                " (NULL, " +
                "'"+document.getElementById("magazin_20_id").value+"', "+
                "'"+document.getElementById("cas_20_id").value+"', "+
                "'"+document.getElementById("count_cas_id_20").value+"', "+
                "'"+document.getElementById("cls_20_id").value+"', "+
                "'"+document.getElementById("count_cls_id_20").value+"', "+
                "NOW()), "+
                " (NULL, "  +
                "'"+document.getElementById("magazin_40_id").value+"', "+
                "'"+document.getElementById("cas_40_id").value+"', "+
                "'"+document.getElementById("count_cas_id_40").value+"', "+
                "'"+document.getElementById("cls_40_id").value+"', "+
                "'"+document.getElementById("count_cls_id_40").value+"', "+
                "NOW()), "+
                " (NULL, "  +
                "'"+document.getElementById("magazin_75_id").value+"', "+
                "'"+document.getElementById("cas_75_id").value+"', "+
                "'"+document.getElementById("count_cas_id_75").value+"', "+
                "'"+document.getElementById("cls_75_id").value+"', "+
                "'"+document.getElementById("count_cls_id_75").value+"', "+
                "NOW()), "+
                " (NULL, "  +
                "'"+document.getElementById("magazin_100_id").value+"', "+
                "'"+document.getElementById("cas_100_id").value+"', "+
                "'"+document.getElementById("count_cas_id_100").value+"', "+
                "'"+document.getElementById("cls_100_id").value+"', "+
                "'"+document.getElementById("count_cls_id_100").value+"', "+
                "NOW());";

        document.getElementById("calc_summ").innerHTML = out;
        document.getElementById("sql").innerHTML = sql;
}

function add_select(magazin_id,nominal_card,arr_shop,arr_card_serial){
                    var id_card="";
                    console.log("func add_select start");
                    if (nominal_card==100) { id_card = 2 };
                    if (nominal_card==75) { id_card = 3 };
                    if (nominal_card==40) { id_card = 1 };
                    if (nominal_card==20) { id_card = 4 };
                    var magazin_sel = create_select("magazin_"+nominal_card,"magazin_"+nominal_card+"_id","Add("+nominal_card+");",arr_shop,magazin_id);
                    var cas = create_select("cas_"+nominal_card,"cas_"+nominal_card+"_id","Add("+nominal_card+");",arr_card_serial,id_card);
                    var cls = create_select("cls_"+nominal_card,"cls_"+nominal_card+"_id","Add("+nominal_card+");",arr_card_serial,id_card);
                    console.log(cls);
                    document.getElementById("magazin_"+nominal_card).appendChild(magazin_sel);
                    document.getElementById("cas_"+nominal_card).appendChild(cas);
                    document.getElementById("cls_"+nominal_card).appendChild(cls);
}

function create_select(name_select,id_select,onchange_select,array,selected){
  //console.log("func create_select start");
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
  //console.log(sel);
  return sel;
}

