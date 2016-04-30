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

function add_item_coming_money(id_magazin){
    //alert(id_magazin);
    JsHttpRequest.query(
        "add_item_coming_consumption.php",
        {
            "db": name, "id_magazin": id_magazin, "tas": 'load_array_js'
        },
        function (result, errors) {
            erdiv=document.getElementById("showtable");
            erdiv.innerHTML="error \""+errors+"\"";
            if (result) {
                eval(result["js"]);
                create_form_money_only(id_magazin);
                //document.getElementById("sql").innerHTML = sql;
                //document.getElementById("addtable").innerHTML=out;
                $(function() {
                    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
                });


            }


        }
    );
}
function edit_sql(id_sql){
    JsHttpRequest.query(
        "query.php",
        {
            "db": name, "idstring": id_sql, "tas": 'edit_sql'
        },
        function (result, errors) {
            //finddiv=name+"-"+idstring;
            erdiv=document.getElementById("showtable");
            erdiv.innerHTML="error \""+errors+"\"";
            if (result) {
                eval(result["js"]);
                erdiv=document.getElementById("showtable");
                erdiv1=document.getElementById("show_sql_query");
                erdiv.innerHTML=result["text"];
                erdiv1.innerHTML=result["sql"];
                ChangeSQL();
                /*
                document.getElementById("addtable").innerHTML="";
                //var table=init();
                document.getElementById("addtable").appendChild(table);

                $(function() {
                    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
                });

                erdiv=document.getElementById("showtable").innerHTML="";
                erdiv1=document.getElementById("show_sql_query");

                add_select(id_magazin,20,arr_shop,arr_card_serial);
                add_select(id_magazin,40,arr_shop,arr_card_serial);
                add_select(id_magazin,75,arr_shop,arr_card_serial);
                add_select(id_magazin,100,arr_shop,arr_card_serial);
                */
            }


        }
    );
}
function add_item_coming_consumption(id_magazin){
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
                document.getElementById("addtable").appendChild(table);

                /* magazin name, nominal */

                $(function() {
                    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
                });

                erdiv=document.getElementById("showtable").innerHTML="";
                erdiv1=document.getElementById("show_sql_query");

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
                erdiv1=document.getElementById("button").innerHTML="";
                erdiv1=document.getElementById("sql").innerHTML="";
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
