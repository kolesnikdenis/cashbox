<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE);
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
?>
<?
// podkluchau biblioteky JsHttpRequest
require_once "../JsHttpRequest/JsHttpRequest.php";

$JsHttpRequest =& new JsHttpRequest("windows-1251");


include "../mysql/traff_view.php3";
$dbh=DB_connect();

$commentaries = $_REQUEST['commentaries'];
$sum = $_REQUEST['sum'];
$taskk = $_REQUEST['tas'];
$seatchuser  = $_REQUEST['seatchuser'];
$savesql = $_REQUEST['savesql'];
$db = $_REQUEST['db'];
$showdiv = $_REQUEST['showdiv'];
$idstring = $_REQUEST['idstring'];
$id_user = $_SESSION['login_id'];
$set_datetime = $_REQUEST['set_datetime'];
$eierr="no";

$array_pay=array();
$global_summ=array();
$array_pay["rodnichek"]["123"]["ost"]=3650;
$array_pay["centr"]["123"]["ost"]=4520;
$array_pay["poselok"]["123"]["ost"]=4700;
$array_pay["minimarcet"]["123"]["ost"]=4490;


/* ��� ����� ���� �� ����������� ������� ������� � ���� ������ ����� �������� � ���� �� ��������� ������� ����� ������� ����� ������ ���������
������ ��������� ����� ������� ������������ ����������� ������ ������� */
/* 99 �������� ����� ���� ��� ��������� ����������� ������� �� ��������� ���� .. � ���������� ������� */
function calc_ost($left_card_count, $left_nominal ,$add_card_count,$add_nominal,$data_in,$shop_name,$id_sql){
        global $array_pay;

        $left_card_summ = $left_card_count * $left_nominal;
        $add_card_summ = $add_card_count * $add_nominal;

        $last_data= key( array_slice($array_pay[$shop_name] , -1, 1, TRUE ) );
        if ($left_card_summ != 99 ) {
                $array_pay[$shop_name][$data_in]["add"] += $add_card_summ;
                $array_pay[$shop_name][$data_in]["ost"] += $left_card_summ;
                if ($left_card_summ > 0 ) { $array_pay[$shop_name][$data_in]["descr"] .= "left card summ: ".$left_card_summ ." = ". $left_nominal . " * " . $left_card_count . "<a href=# onclick='edit_sql(".$id_sql.");'>edit</a><button type='button' onklick='javascript:void(alert('hi close'));'class='btn btn-default' data-dismiss='modal'>Close</button>\r\n";  }
                if ($add_card_summ > 0 ) { $array_pay[$shop_name][$data_in]["descr"] .= "add card summ: ".$add_card_summ ." = ". $add_nominal . " * " . $add_card_count ."<a href=# onclick='edit_sql(".$id_sql.");'>edit</a>\r\n"; }

                if ($data_in != $last_data){
                        if ( count($array_pay[$shop_name]) > 2 ) {
                                $last_last_data= key( array_slice($array_pay[$shop_name] , -3, 1, TRUE ) );
                                if ( $array_pay[$shop_name][$last_last_data]["add"] ) { $oldd_add= $array_pay[$shop_name][$last_last_data]["add"]; }
                                if ( $array_pay[$shop_name][$last_last_data]["ost"] ) { $oldd_ost=$array_pay[$shop_name][$last_last_data]["ost"]; }
                                if ( $array_pay[$shop_name][$last_data]["ost"] ) {  $old_ost= $array_pay[$shop_name][$last_data]["ost"]; }
                                $array_pay[$shop_name][$last_data]["prodal"] = $oldd_ost+$oldd_add-$old_ost;
                        }
                }
        }
        else  {
                $last_last_data= key( array_slice($array_pay[$shop_name] , -2, 1, TRUE ) );
                if ( $array_pay[$shop_name][$last_last_data]["add"] ) { $oldd_add= $array_pay[$shop_name][$last_last_data]["add"]; }
                if ( $array_pay[$shop_name][$last_last_data]["ost"] ) { $oldd_ost=$array_pay[$shop_name][$last_last_data]["ost"]; }
                if ( $array_pay[$shop_name][$last_data]["ost"] ) {  $old_ost= $array_pay[$shop_name][$last_data]["ost"]; }
                $array_pay[$shop_name][$last_data]["prodal"] = $oldd_ost+$oldd_add-$old_ost;
        }
}


function calc_ost1($left_card_summ,$add_card_summ,$data_in,$shop_name){
        global $array_pay;
        $last_data= key( array_slice($array_pay[$shop_name] , -1, 1, TRUE ) );
        if ($left_card_summ != 99 ) {
                $array_pay[$shop_name][$data_in]["add"] += $add_card_summ;
                $array_pay[$shop_name][$data_in]["ost"] += $left_card_summ;

                if ($data_in != $last_data){
                        if ( count($array_pay[$shop_name]) > 2 ) {
                                $last_last_data= key( array_slice($array_pay[$shop_name] , -3, 1, TRUE ) );
                                if ( $array_pay[$shop_name][$last_last_data]["add"] ) { $oldd_add= $array_pay[$shop_name][$last_last_data]["add"]; }
                                if ( $array_pay[$shop_name][$last_last_data]["ost"] ) { $oldd_ost=$array_pay[$shop_name][$last_last_data]["ost"]; }
                                if ( $array_pay[$shop_name][$last_data]["ost"] ) {  $old_ost= $array_pay[$shop_name][$last_data]["ost"]; }
                                $array_pay[$shop_name][$last_data]["prodal"] = $oldd_ost+$oldd_add-$old_ost;
                        }
                }
        }
        else  {
                $last_last_data= key( array_slice($array_pay[$shop_name] , -2, 1, TRUE ) );
                if ( $array_pay[$shop_name][$last_last_data]["add"] ) { $oldd_add= $array_pay[$shop_name][$last_last_data]["add"]; }
                if ( $array_pay[$shop_name][$last_last_data]["ost"] ) { $oldd_ost=$array_pay[$shop_name][$last_last_data]["ost"]; }
                if ( $array_pay[$shop_name][$last_data]["ost"] ) {  $old_ost= $array_pay[$shop_name][$last_data]["ost"]; }
                $array_pay[$shop_name][$last_data]["prodal"] = $oldd_ost+$oldd_add-$old_ost;
        }
}


function find_last_summ($id_shop){
        global $array_pay;
        global $dbh;
        $SQL1 = "select  cashbox.id, cashbox.data_time, magazine.name, card_serial.name, cashbox.serial_left, cashbox.count_left, card_serial.name, cashbox.count_add,cashbox.serial_add,`cashbox`.`type_calculation` from  cashbox,card_serial,magazine where cashbox.magazine='".$id_shop."' and cashbox.magazine= magazine.magazine_id and card_serial.card_id = cashbox.serial_left  ORDER BY `cashbox`.`data_time` asc ";
        $res1=mysql_query($SQL1,$dbh);
        $shop_name="";
        print mysql_error();
                        print mysql_error();
                        while ($pl1=mysql_fetch_array($res1)){
                            $count_left=$pl1[count_left];
                            $count_add=$pl1[count_add];
                            if ($pl1[type_calculation] == "C" ){
                                //calc_ost1(($pl1[3] * $count_left ), ( $pl1[3] * $count_add), $pl1[data_time], $pl1[2]);
                                calc_ost($pl1[3], $count_left, $pl1[3], $count_add, $pl1[data_time], $pl1[2]);
                            }
                            if ($pl1[type_calculation] == "M" ){
                                calc_money($pl1[count_add],$pl1[data_time], $pl1[2]);
                            }
                            $shop_name=$pl1[2];
                        }
        $last_data= key( array_slice($array_pay[$shop_name] , -1, 1, TRUE ) );
        $ost = $array_pay[$shop_name][$last_data]["ost"];
        $add = $array_pay[$shop_name][$last_data]["add"];
        //echo "ost + add = $ost + $add - \$last_data: $last_data \$shop_name $shop_name\n";
        return ($ost+$add);
}


function calc_money($prodal_magaz,$date_in,$shop_name){
       global $array_pay;
       $last_data= key( array_slice($array_pay[$shop_name] , -1, 1, TRUE ) );
       if ( $last_data != $date_in   ) {
                if ( $array_pay[$shop_name][$last_data]["ost"]  )  {
                        $last_last_data= key( array_slice($array_pay[$shop_name] , -2, 1, TRUE ) );
                        if ( $array_pay[$shop_name][$last_data]["ost"] ) {  $old_ost= $array_pay[$shop_name][$last_data]["ost"]; }
                        if ( $array_pay[$shop_name][$last_last_data]["add"] ) { $oldd_add= $array_pay[$shop_name][$last_last_data]["add"]; }
                        if ( $array_pay[$shop_name][$last_last_data]["ost"] ) { $oldd_ost=$array_pay[$shop_name][$last_last_data]["ost"]; }
                        $array_pay[$shop_name][$last_data]["prodal"] = $oldd_ost+$oldd_add-$old_ost;
                }
        }
        $last_data= key( array_slice($array_pay[$shop_name] , -1, 1, TRUE ) );
        $ost_old=$array_pay[$shop_name][$last_data]["ost"]+ $array_pay[$shop_name][$last_data]["add"];
        $ost_old-=$prodal_magaz;
        $array_pay[$shop_name][$date_in]['ost'] = $ost_old;
        $array_pay[$shop_name][$date_in]['add'] = 0;
        $array_pay[$shop_name][$date_in]['prodal'] = $prodal_magaz;
}

if ( $taskk == "show_cashbox" ) {
        if($eierr=="no"){
                $dbh=DB_connect();
                $SQL = "select  cashbox.id, cashbox.data_time, magazine.name, card_serial.name, cashbox.serial_left, cashbox.count_left, card_serial.name, cashbox.count_add,cashbox.serial_add,`cashbox`.`type_calculation` from  cashbox,card_serial,magazine where cashbox.magazine= magazine.magazine_id and card_serial.card_id = cashbox.serial_left  ORDER BY `cashbox`.`data_time` asc ";
                print mysql_error();
                $out .= "
				<table border=1 class=\"show_table\">
					<tr bgcolor=#86be9f>
						<td>�������</td>
						<td>�������</td>
						<td>���� ����������</td>
						<td>���-�� ����������� ����</td>
						<td>���-�� �������</td>
						<td>��� ��������</td>
						<td>������</td>
						<td>������� � ��������</td>
						<td>type</td>
						<td>control</td>
					</tr>";
                $res=mysql_query($SQL,$dbh);
                print mysql_error();
                $ost_minik=0;
                $add_minik=0;

                while ($pl=mysql_fetch_array($res)){
                    $out.="<tr><td>".$pl[2]."</td><td>".$pl[name]."</td><td>".$pl[data_time]."</td>";
                    $count_left=$pl[count_left];
                    $count_add=$pl[count_add];
                    if ( ($count_left  > 1 )  && ( $count_add > 1 ) ) { $type = "������� ������� � ��� �������� " ;}
                    elseif ( ( $count_left > 1 ) && ( $count_add < 1 )) { $type= "������� �������"; }
                    else   { $type = "������� ��������"; }
                    $add_card=$pl[3] . " * " .  $count_add   ." = " . ( $pl[3] * $count_add);
                    $sale_magazin=$pl[3] . " * " .  $count_left   ." = " . ($pl[3] * $count_left );

                    $name_magazine = $pl[2];
                    if ($pl[type_calculation] == "C" ){
                        $out .= "<td>".$pl[count_add]."</td><td>".$pl[count_left]."</td><td>".$type."</td><td class=\"add_card\" >".$add_card."</td><td bgcolor=#a6e3f4>".$sale_magazin."</td><td>".$pl[type_calculation]."</td>";
                        //calc_ost1(($pl[3] * $count_left ), ( $pl[3] * $count_add), $pl[data_time], $pl[2]);
                        calc_ost($pl[3], $count_left, $pl[3], $count_add, $pl[data_time], $pl[2],$pl[id]);
                    }
                    else {
                        $out .= "<td>---</td><td>-----</td><td>������ ������ ������</td><td bgcolor=#f4c397>".$pl[count_add]."</td><td bgcolor=#a6e3f4>".$global_summ[$name_magazine]["summ"]."</td><td>".$pl[type_calculation]."</td>";
                        calc_money($pl[count_add],$pl[data_time], $pl[2]);
                    }
                    $out.="<td><a href=# onclick=\"edit_sql(".$pl[id].");\">edit</a> \ <a href=#>del</a></td></tr>";
                }
                $out.="</table>";

                //������� ����� ... ������� ����� ������
                foreach ($global_summ as $key1 => &$value1 ){
                                    //calc_ost1((99 * 1), ( 99 * 1), "3333", $key1);
                                    calc_ost(99,1,99,1, "3333", $key1,"");
                }

                $out .="<table border=1 width=100%><tr><td>�������</td><td>data</td><td>ost</td><td>add</td><td>prodal</td><td>descr</td><td></td></tr>";
                global $array_pay;
                $i=0;
                foreach ($array_pay as $key1 =>&$value1 ) {
                    foreach ($array_pay[$key1] as $key => &$value) {
                        $i++;
                        $out .="<tr><td>".$key1."</td><td>".$key."</td><td>".$value['ost']."</td><td>".$value['add']."</td><td>".$value['prodal'].
                        "</td><td><!-- <a href=\"javascript:void(show_message('".$key1.$i."','$value[descr]'))\"><span title=\"".$value[descr]."\">�������� ��� ��������</span><div id=".$key1.$i.">show</div></a>-->".
                        "";

                        if (strlen($value[descr]) > 5 ) {
                           $out.="
                           <button class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\".bs-example-modal-sm\" text_t=\"".$value[descr]."\">�����������</button><BR>
                           <button class=\"btn btn-primary infotext\" data-toggle=\"modal\" data-target=\".bs-example-modal-sm\" data-text=\"".$value[descr]."\">�����������</button>";
                        }

                        $out.=
                        "</td>".
                        "<td><a href=# onclick=\"edit_sql(".$pl[id].");\">edit</a> \ <a href=#>del</a></td></tr>";
                        $global_summ[$key1]["prodal"] += $value['prodal'];
                    }
                    $last_data= key( array_slice($array_pay[$key1] , -1, 1, TRUE ) );
                    $ost_magazin=$array_pay[$key1][$last_data]["ost"]+$array_pay[$key1][$last_data]["add"];
                    $out .="�������: ".$key1." �� ��������� ������ ������ �� �����: ". $global_summ[$key1]["prodal"] . " ������ ������� � ". $key1. ":".$ost_magazin."<br>";
                }

                $out.="</table><br><Br>";

                $out.='<div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                      <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                                    </div>
                                                    <div id=text_t class="modal-body">
                                                      ...
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                      <button type="button" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                  </div>
                                                </div>
                       </div> ';

                $out.="<div id='$db-$idstring'> 0 \ <a onclick=\"del_record('$idstring','$db'); return false;\">del</a> </div>";
                $_RESULT['text'] = $out;
                $_RESULT['sql'] = $SQL;
                $_RESULT['err'] = 'no';
        }
        else
        {
                //vidod oshibok
                $_RESULT['err'] = 'yes';
                $log="<center><font color=#cc0000>������</font></center>".$log;
                $_RESULT['log'] = $log;
        }

}

if ( $taskk == "edit_sql" ) {
    $dbh=DB_connect();
    $type_calculation=0;
    $count_left=0;
    $count_add=0;
    $SQL = "SELECT *  FROM `cashbox` WHERE `id` ='".$idstring."'";
    $res=mysql_query($SQL,$dbh);
    print mysql_error();
    while ($pl=mysql_fetch_array($res)){
        if ($pl[type_calculation] =="C"){
            $js= "function ChangeSQL() { \r\n ".
                 "var sql=\"UPDATE `accounting`.`cashbox` SET `count_add` = '\"+document.getElementById(\"add_count\").value+\"', ".
                 "`count_left` = '\"+document.getElementById(\"left_count\").value+\"'  WHERE `cashbox`.`id` = '".$idstring. "'\";\r\n ".
                 "document.getElementById(\"show_sql_query\").innerHTML = sql;\r\n".
                 "document.getElementById(\"sql\").innerHTML = sql;\r\n ".
                 "\r\n".
                 "};";
            $count_left=$pl[count_left];
            $count_add=$pl[count_add];
            $savesql="UPDATE `accounting`.`cashbox` SET `count_add` = '".$pl[count_add]."' WHERE `cashbox`.`id` = ".$idstring;
            $type_calculation="C";
        }

        if ($pl[type_calculation] =="M"){
            $savesql="UPDATE `accounting`.`cashbox` SET `left_count` = '".$pl[left_count]."' WHERE `cashbox`.`id` = ".$idstring;
            $count_add=$pl[count_add];
            $js= "function ChangeSQL(){ \r\n ".
                  "var sql=\"UPDATE `accounting`.`cashbox` SET `count_add` = '\"+document.getElementById(\"add_count\").value+\"' ".
                  " WHERE `cashbox`.`id` = '".$idstring. "'\" ".
                  "\r\n document.getElementById(\"show_sql_query\").innerHTML = sql;\r\n ".
                  "document.getElementById(\"sql\").innerHTML = sql;\r\n ".
                  "\r\n".
                   "}";
            $type_calculation="M";
        }

    }

    $out = "<br><br><button name=save_sql onclick=\"save_to_sql();\">Save Change</button>";

    $_RESULT['count_add'] = $count_add;
    $_RESULT['count_left'] = $count_left;
    $_RESULT['type_calculation']= $type_calculation;
    $_RESULT['js'] = $js;
    $_RESULT['text'] = $out;
    $_RESULT['err'] = 'no';
    $_RESULT['sql'] = $savesql;
}


if ( $taskk == "sql_save" ) {
    $dbh=DB_connect();
    $SQL = $savesql;
    $res=mysql_query($SQL,$dbh);
    print mysql_error();
    $_RESULT['js'] = "";
    $_RESULT['text'] = "������ ����������<br><a href=\"#\" onclick=\"show_cashbox('o');\">������� ����������� ��������</a>";
    $_RESULT['err'] = 'no';
    $_RESULT['sql'] = $savesql;
}


if ( $taskk == "add_intem" ) {
        if($eierr=="no"){
                $dbh=DB_connect(); 
				$out.="<table border=1><tr><td>�������� ��������</td><td>�������� ��������</td></tr>";

				$SQL = "select  magazine_id,name,description  from  magazine ";
				$res=mysql_query($SQL,$dbh);
                print mysql_error();
                while ($pl=mysql_fetch_array($res)){
                    if ($idstring == "only_money" ) {
                        $out .=  "<tr><td><a href=\"#\" onclick=\"add_item_coming_money(".$pl[magazine_id].")\";>".$pl[name]."</a></td><td>".$pl[description]."</td></tr>";
                    }
                    else {

                        // ������� �������

                        $last_summ  = find_last_summ($pl[magazine_id]);
                        $out .=  "<tr><td><a href=\"#\" onclick=\"add_item_coming_consumption('".$pl[magazine_id]."','".$last_summ."');\";>".$pl[name]."</a></td><td>".$pl[description]."</td></tr>";
                    }
                }

                $out.="</table><br><div id=calc_add></div><br><div id=calc_left></div>";
                $out.="<div id='$db-$idstring'> 0 \ <a onclick=\"del_record('$idstring','$db'); return false;\">del</a> </div>";
                $_RESULT['text'] = $out;
                $_RESULT['sql'] = $SQL;
				$js="document.getElementById(\"select_card_add\").appendChild(cas);
document.getElementById(\"select_card_left\").appendChild(cls);
document.getElementById(\"select_magazin\").appendChild(maga);";
				$_RESULT['js'] = $js;
                $_RESULT['text'] = $out.
                $_RESULT['err'] = 'no';
        }
        else
        {
                //vidod oshibok
                $_RESULT['err'] = 'yes';
                $log="<center><font color=#cc0000>��� ���� ) </font></center>".$log;
                $_RESULT['log'] = $log;
        }

}

?>
