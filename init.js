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


function Message(id_div,text) {
    this.text = text;
    this.id_div1 = id_div;


};

Message.prototype.render = function() {
    var div = document.createElement('div');
    var aClose = document.createElement('a');
    var pClose = document.createElement('p');
    pClose.innerHTML = '&times;';
    aClose.appendChild(pClose);
    div.appendChild(aClose);
    var pText = document.createElement('p');
    pText.style.whiteSpace ="normal";
    pText.innerHTML = this.text;
    div.appendChild(pText);
    var id_div2=_getElementById(this.id_div1);
    id_div2.appendChild(div);
    /*document.body.insertBefore(div,document.body.firstChild);*/
    //alert( this.text);

    div.style.backgroundColor = '#f77d71';
    div.style.fontSize = '11px';
    div.style.color = 'white';
    div.style.borderRadius = '0.6rem';
    div.style.textAlign = 'center';
    aClose.setAttribute('href', 'javascript:void(destroy("'+this.id_div1+'")) ');
    //aClose.setAttribute('href', '#');
    aClose.setAttribute('id', 'submit_dasha');
    aClose.style.color = 'white';
    aClose.style.textAlign = 'right';
    aClose.style.textAlign = 'right';
    aClose.style.textDecoration = 'none';
    aClose.style.lineHeight = '10px';
    //this.destroy();
};

Message.prototype.destroy = function() {
    function deleteMessage(del_id) {
        //alert("test");
        //document.body.removeChild(document.body.firstChild);
        //document.body.removeChild(del_id);
        alert("test"  + del_id);
        var id_div2=_getElementById(del_id);
        id_div2.innerHTML="";
    }
    submit_dasha.addEventListener("click", deleteMessage(this.id_div1), false );
    //submit_dasha.addEventListener("click", destroy(this.id_div1));
};

function show_message(id_div,in_message){
    var message = new Message(id_div,in_message);
    message.render('hello everyone!!!!')
}

function destroy(del_id){
    var id_div2=_getElementById(del_id);
    id_div2.innerHTML="";;
}
/* start */
$('.infotext').click(function() {
    var text = $(this).data("text");
    $(".modal-content").html(text);
});
/* end */

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

                erdiv=document.getElementById("showtable");
                erdiv1=document.getElementById("show_sql_query");

                //erdiv.innerHTML=result["text"];
                erdiv1.innerHTML=result["sql"];

                erdiv.innerHTML+=result["text"];
                eval(result["js"]);

                if(result["type_calculation"] == "M" ) {
                    cellText = document.createElement("input");
                    cellText.type = "text";
                    cellText.size = "4";
                    cellText.value = result["count_add"];
                    cellText.id = "add_count";
                    cellText.onchange = function () {
                        ChangeSQL();
                        return;
                    };
                    erdiv=document.getElementById("showtable");
                    erdiv.appendChild(cellText);
                }

                if(result["type_calculation"] == "C" ) {
                    cellText = document.createElement("input");
                    cellText.type = "text";
                    cellText.size = "4";
                    cellText.value = result["count_add"];
                    cellText.id = "add_count";
                    cellText.onchange = function () {
                        ChangeSQL();
                        return;
                    };
                    erdiv=document.getElementById("showtable");
                    erdiv.appendChild(cellText);
                    cellText = document.createElement("input");
                    cellText.type = "text";
                    cellText.size = "4";
                    cellText.value = result["count_left"];
                    cellText.id = "left_count";
                    cellText.onchange = function () {
                        ChangeSQL();
                        return;
                    };
                    erdiv.appendChild(cellText);
                }



                alert(result["text"]);
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
function add_item_coming_consumption(id_magazin,calc_last_summ){
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
                var table=init(calc_last_summ);
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
