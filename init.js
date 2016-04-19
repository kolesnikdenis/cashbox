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

                //eval(result["js"]);

                var jsElm = document.createElement("script");
                jsElm.type = "application/javascript";
                var file="http://manage.ots.kh.ua/cashbox/load_array.php";
                jsElm.src = file;
                document.getElementsByTagName('head')[0].appendChild(jsElm);
                //document.body.appendChild(jsElm);
                

                var table=init();
                document.getElementById("addtable").appendChild(table);  // ???????? ??????? ? ??????????)


                erdiv=document.getElementById("showtable");
                erdiv1=document.getElementById("show_sql_query");
                //erdiv.innerHTML=result["text"];




                erdiv.innerHTML="<!-- <div id=addtable>тут таблица с формами...</div><br>-->\
                <!--<div id=calc_summ>calc_form</div><br>\
                <div id=showtable>show table</div>-->";

                //load js


                alert(arr_shop[0][1]);
                alert(id_magazin);
                add_select(id_magazin,100);
                var jsElm1 = document.createElement("script");
                jsElm1.type = "application/javascript";
                var file1="http://manage.ots.kh.ua/cashbox/test_add.js";
                jsElm1.src = file1;
                document.getElementsByTagName('head')[0].appendChild(jsElm1);


            }


        }
    );
}

function show_cashbox(idstring,name){
        //erdiv=document.getElementById('showsqury');
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


function add_intem(idstring,name){
        //erdiv=document.getElementById('showsqury');
        //erdiv.innerHTML = "please wait ...";
        //alert("idstring"+idstring);

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
