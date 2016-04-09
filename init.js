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
                                erdiv=document.getElementById("show_js");
                                erdiv1=document.getElementById("show_sql_query");
								//erdiv_js=document.getElementById("show_js");
                                erdiv.innerHTML=result["text"];
                                erdiv1.innerHTML=result["sql"];
								//erdiv_js.innerHTML=result["js"];
								console.log(result);
                          }

                }
        )
}
