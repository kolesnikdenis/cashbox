function _getElementById(id){
  var item = null;

  if (document.getElementById){
    item = document.getElementById(id);
  } else if (document.all){
    item = document.all[id];
  } else if (document.layers){
    item = document.layers[id];
  }

  return item;
}

function add_item_coming_consumption(id_magazin){
/*
    var jsElm = document.createElement("script");
    jsElm.type = "application/javascript";
    var file="http://manage.ots.kh.ua/cashbox/load_array.php";
    jsElm.src = file;
    document.getElementsByTagName('head')[0].appendChild(jsElm);
    document.body.appendChild(jsElm);*/



    
    JsHttpRequest.query(
        "add_item_coming_consumption.php",
        {
            "db": name, "id_magazin": id_magazin, "tas": 'load_array_js'
        },
        function (result, errors) {

            //finddiv=name+"-"+idstring;
            erdiv=document.getElementById("showtable");
            erdiv.innerHTML="error \""+errors+"\"";
            if (result) {

                eval(result["js"]);


                document.getElementById("addtable").innerHTML="";
                var table=init();
                document.getElementById("addtable").appendChild(table);  // ???????? ??????? ? ??????????)

                /* magazin name, nominal */

                $(function() {
                    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
                    alert("blin2");
                });

                erdiv=document.getElementById("showtable").innerHTML="";
                erdiv1=document.getElementById("show_sql_query");
                //erdiv.innerHTML=result["text"];




                erdiv.innerHTML="<!-- <div id=addtable>тут таблица с формами...</div><br>-->\
                <!--<div id=calc_summ>calc_form</div><br>\
                <div id=showtable>show table</div>-->";

                //load js
                add_select(id_magazin,20,arr_shop,arr_card_serial);
                add_select(id_magazin,40,arr_shop,arr_card_serial);
                add_select(id_magazin,75,arr_shop,arr_card_serial);
                add_select(id_magazin,100,arr_shop,arr_card_serial);

            }


        }
    );
}

function show_cashbox(idstring,name){
        erdiv=document.getElementById('sql').innerHTML="";
        //erdiv.innerHTML = "please wait ...";
        //alert("idstring"+idstring);
        //alert("name "+ name) ;
        JsHttpRequest.query(
                "query.php",
                {
                        "db": name, "idstring": idstring, "tas": 'show_cashbox'
                },
                function (result, errors) {

                          //finddiv=name+"-"+idstring;
                          erdiv=document.getElementById("showtable");
                          erdiv.innerHTML="error \""+errors+"\"";
                          if (result) {
                                erdiv=document.getElementById("showtable");
                                erdiv1=document.getElementById("show_sql_query");
                                erdiv.innerHTML=result["text"];
                                erdiv1.innerHTML=result["sql"];

                          }

                }
        )
}

function save_to_sql(){
    sql_query=document.getElementById('sql').innerHTML;
    document.getElementById("calc_summ").innerHTML="";;
    document.getElementById("addtable").innerHTML="";;
   
    JsHttpRequest.query(
        "query.php",
        {
            "savesql": sql_query, "tas": 'sql_save'
        },
        function (result, errors) {

            //finddiv=name+"-"+idstring;
            erdiv=document.getElementById("showtable");
            erdiv.innerHTML="error \""+errors+"\"";
            if (result) {
                erdiv=document.getElementById("showtable");
                erdiv1=document.getElementById("show_sql_query");
                erdiv.innerHTML=result["text"];
                erdiv1.innerHTML=result["sql"];
                

            }

        }
    )
}


function add_intem(idstring,name){
    var jsElm = document.createElement("script");
    jsElm.type = "application/javascript";
    var file="http://manage.ots.kh.ua/cashbox/load_array.php";
    jsElm.src = file;
    document.getElementsByTagName('head')[0].appendChild(jsElm);
    document.body.appendChild(jsElm);




    document.getElementById("addtable").innerHTML="";
    document.getElementById("calc_summ").innerHTML="";
    document.getElementById("show_sql_query").innerHTML="";

        JsHttpRequest.query(
                "query.php",
                {
                        "db": name, "idstring": idstring, "tas": 'add_intem'
                },
                function (result, errors) {

                          //finddiv=name+"-"+idstring;
                          erdiv=document.getElementById("showtable");
                          erdiv.innerHTML="error \""+errors+"\"";
                          if (result) {
                                erdiv=document.getElementById("showtable");
                                erdiv1=document.getElementById("show_sql_query");
								//erdiv_js=document.getElementById("show_js");
                                erdiv.innerHTML=result["text"];
                                erdiv1.innerHTML=result["sql"];
								//erdiv_js.innerHTML=result["js"];
								//eval(result["js"]);
								//console.log(result);
								//alert("nominal:"+arr_card_serial[0][2]);
                          }

                }
        )
}
