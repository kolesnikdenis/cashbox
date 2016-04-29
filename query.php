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


/* при смене даты он пересчитует остаток сколько в него попало новым остатком и если не правильно указать новый остаток будет ошибка подсчетов
скрипт посчитает новый остаток относительно поступивших данных поэтому */
/* 99 озночает смена даты для выведения глобального остатка на последнюю дату .. и глобальной продажи */

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
                /*$out .= "
				<table border=1>
					<tr bgcolor=#86be9f>
						<td>магазин</td>
						<td>номинал</td>
						<td>дата транзакции</td>
						<td>кол-во добавленных карт</td>
						<td>кол-во остатка</td>
						<td>тип операции</td>
						<td>приход</td>
						<td>остаток в магазине </td>
						<td>type</td>
					</tr>";*/
                $res=mysql_query($SQL,$dbh);
                print mysql_error();
                $ost_minik=0;
                $add_minik=0;

                while ($pl=mysql_fetch_array($res)){
                    $out.="<tr><td>".$pl[2]."</td><td>".$pl[name]."</td><td>".$pl[data_time]."</td>";
                    $count_left=$pl[count_left];
                    $count_add=$pl[count_add];
                    if ( ($count_left  > 1 )  && ( $count_add > 1 ) ) { $type = "подсчет остатка и дал карточек " ;}
                    elseif ( ( $count_left > 1 ) && ( $count_add < 1 )) { $type= "подсчет остатка"; }
                    else   { $type = "добавил карточек"; }
                    $add_card=$pl[3] . " * " .  $count_add   ." = " . ( $pl[3] * $count_add);
                    $sale_magazin=$pl[3] . " * " .  $count_left   ." = " . ($pl[3] * $count_left );

                    $name_magazine = $pl[2];
                    if ($pl[type_calculation] == "C" ){
                        //$out .= "<td>".$pl[count_add]."</td><td>".$pl[count_left]."</td><td>".$type."</td><td bgcolor=#f4c397>".$add_card."</td><td bgcolor=#a6e3f4>".$sale_magazin."</td><td>".$pl[type_calculation]."</td></tr>";
                        calc_ost1(($pl[3] * $count_left ), ( $pl[3] * $count_add), $pl[data_time], $pl[2]);
                    }
                    else {
                        //$out .= "<td>---</td><td>-----</td><td>только забрал деньги</td><td bgcolor=#f4c397>".$pl[count_add]."</td><td bgcolor=#a6e3f4>".$global_summ[$name_magazine]["summ"]."</td><td>".$pl[type_calculation]."</td></tr>";
                        calc_money($pl[count_add],$pl[data_time], $pl[2]);
                    }
                }
                //$out.="</table>";

                //подсчет конца ... сколько магаз продал
                foreach ($global_summ as $key1 => &$value1 ){
                    calc_ost1((99 * 1), ( 99 * 1), "3333", $key1);
                }

                $out .="<table border=1 width=100%><tr><td>магазин</td><td>data</td><td>ost</td><td>add</td><td>prodal</td></tr>";
                global $array_pay;
                foreach ($array_pay as $key1 =>&$value1 ) {
                    foreach ($array_pay[$key1] as $key => &$value) {
                        $out .="<tr><td>".$key1."</td><td>".$key."</td><td>".$value['ost']."</td><td>".$value['add']."</td><td>".$value['prodal']."</td></tr>";
                        /*$out.= "key1: ==" . $key1." key: " . $key ."<br>";
                        $out.= "key1: ". $key1. "= ost =" . $value['ost']." key: " . $key ."<br>";
                        $out.= "key1: ". $key1. "= add =" . $value['add']." key: " . $key ."<br>";
                        $out.= "key1: ". $key1. "= pro =<b>" . $value['prodal']." key: " . $key ."</b><br>";*/
                        $global_summ[$key1]["prodal"] += $value['prodal'];
                    }
                    $last_data= key( array_slice($array_pay[$key1] , -1, 1, TRUE ) );
                    $ost_magazin=$array_pay[$key1][$last_data]["ost"]+$array_pay[$key1][$last_data]["add"];
                    $out .="Магазин: ".$key1." за выбранный период продал на сумму: ". $global_summ[$key1]["prodal"] . " сейчас остаток в ". $key1. ":".$ost_magazin."<br>";
                }

                $out.="</table><br><Br>";


                $out.="<div id='$db-$idstring'> 0 \ <a onclick=\"del_record('$idstring','$db'); return false;\">del</a> </div>";
                $_RESULT['text'] = $out;
                $_RESULT['sql'] = $SQL;
                $_RESULT['err'] = 'no';
        }
        else
        {
                //vidod oshibok
                $_RESULT['err'] = 'yes';
                $log="<center><font color=#cc0000>бля сука ) </font></center>".$log;
                $_RESULT['log'] = $log;
        }

}

if ( $taskk == "sql_save" ) {
    $dbh=DB_connect();
    $SQL = $savesql;
    $res=mysql_query($SQL,$dbh);
    print mysql_error();
    $_RESULT['js'] = "";
    $_RESULT['text'] = "данные сохраненны<br><a href=\"#\" onclick=\"show_cashbox('o');\">переход центральную страницу</a>";
    $_RESULT['err'] = 'no';
    $_RESULT['sql'] = $savesql;
}


if ( $taskk == "add_intem" ) {
        if($eierr=="no"){
                $dbh=DB_connect(); 
				$out.="<table border=1><tr><td>название магазина</td><td>Описание Магазина</td></tr>";

				$SQL = "select  magazine_id,name,description  from  magazine ";
				$res=mysql_query($SQL,$dbh);
                print mysql_error();
                while ($pl=mysql_fetch_array($res)){
                    if ($idstring == "only_money" ) {
                        $out .=  "<tr><td><a href=\"#\" onclick=\"add_item_coming_money(".$pl[magazine_id].")\";>".$pl[name]."</a></td><td>".$pl[description]."</td></tr>";
                    }
                    else {
                        $out .=  "<tr><td><a href=\"#\" onclick=\"add_item_coming_consumption(".$pl[magazine_id].")\";>".$pl[name]."</a></td><td>".$pl[description]."</td></tr>";
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
                $log="<center><font color=#cc0000>бля сука ) </font></center>".$log;
                $_RESULT['log'] = $log;
        }

}

?>
