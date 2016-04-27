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

$global_summ_rodnik=3650; //rodnik2
$global_summ_centr=4520;//3
$global_summ_poselok=4700;//4
$global_summ_minik=4490;
$date="231";
$array_pay=array();



function calc_ost($ost_old,$left_card,$add_card,$date_in,$shop_name) {
    global $array_pay,$date;
    if ( $date == "231" ) { $date = $date_in; }
    if ( ($date != $date_in ) && ($left_card !=99 )  ){
        $ost = $array_pay[$shop_name][$date]['ost'];
        $add = $array_pay[$shop_name][$date]['add'];
        $array_pay[$shop_name][$date]['prodal'] = $ost_old-$array_pay[$shop_name][$date]['ost'];
        $ost_old = $ost + $add;
        //$add="global_summ_minik = ost + add ". $ost_old. " = ". $ost . " + ". $add ."\n";
        $date=$date_in;
    }
    else {
        $array_pay[$shop_name][$date]['prodal'] = $ost_old-$array_pay[$shop_name][$date]['ost'];
    }
    if ($left_card !=99 ){
        $array_pay[$shop_name][$date_in]['ost']+=$left_card;
        $array_pay[$shop_name][$date_in]['add']+=$add_card;
    }
    return $ost_old;
}


if ( $taskk == "show_cashbox" ) {
        if($eierr=="no"){
                $dbh=DB_connect();
                $SQL = "select  cashbox.id, cashbox.data_time, magazine.name, card_serial.name, cashbox.serial_left, cashbox.count_left, card_serial.name, cashbox.count_add,cashbox.serial_add  from  cashbox,card_serial,magazine where cashbox.magazine= magazine .magazine_id and card_serial.card_id = cashbox.serial_left  ORDER BY `cashbox`.`data_time` asc ";
                print mysql_error();
                $out .= "
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
					</tr>";
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
                  if ( strCaseCmp($pl[2], "minimarcet" ) ==0 ) {
                    global $global_summ_minik;
                    $global_summ_minik=calc_ost($global_summ_minik,($pl[3] * $count_left ), ( $pl[3] * $count_add), $pl[data_time], $pl[2]);
                    $out .= $global_summ_minik;
                  }
                  $out .= "<td>".$pl[count_add]."</td><td>".$pl[count_left]."</td><td>".$type."</td><td bgcolor=#f4c397>".$add_card."</td><td bgcolor=#a6e3f4>".$sale_magazin."</td></tr>";
                }
                $out.="</table>";
                $global_summ_minik=calc_ost($global_summ_minik,(99 * 1), ( 99 * 1), "333", "minimarcet");
                $out .= $global_summ_minik."end out<br>";
                global $array_pay;
                foreach ($array_pay["minimarcet"] as $key => &$value) {
                        $out.= $key."= ost =" . $value['ost']." key: " . $key ."<br>";
                        $out.= $key."= add =" . $value['add']." key: " . $key ."<br>";
                        $out.= $key."= pro =<b>" . $value['prodal']." key: " . $key ."</b><br>";
                        $global_summ_minik_prodal +=$value['prodal'];
                        $global_summ_minik = $value['ost']+$value['add'];
                }

                $out.="родничек продал на сумму: ".$global_summ_rodnik ."<br>".
                "ћинимаркет на сумму: ". $global_summ_minik_prodal. " сейчас остаток в минимаркете:".$global_summ_minik."<br>".
                "÷ентр на сумму: ". $global_summ_centr."<br>".
                "ѕоселок на сумму: ". $global_summ_poselok."<br>";
                //$out.="всего прибыль за выбраный период".( $global_summ_rodnik +  $global_summ_minik + $global_summ_centr + $global_summ_poselok)."<br><hr>";

                $out.="<div id='$db-$idstring'> 0 \ <a onclick=\"del_record('$idstring','$db'); return false;\">del</a> </div>";
                $_RESULT['text'] = $out;
                $_RESULT['sql'] = $SQL;
                $_RESULT['err'] = 'no';
        }
        else
        {
                //vidod oshibok
                $_RESULT['err'] = 'yes';
                $log="<center><font color=#cc0000>бл€ сука ) </font></center>".$log;
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
				$out.="<table border=1><tr><td>название магазина</td><td>ќписание ћагазина</td></tr>";

				$SQL = "select  magazine_id,name,description  from  magazine ";
				$res=mysql_query($SQL,$dbh);
                print mysql_error();
                while ($pl=mysql_fetch_array($res)){
                    $out .=  "<tr><td><a href=\"#\" onclick=\"add_item_coming_consumption(".$pl[magazine_id].")\";>".$pl[name]."</a></td><td>".$pl[description]."</td></tr>";
                }


                
                $out.="</table><br><div id=calc_add></div><br><div id=calc_left></div>";
                $out.="<div id='$db-$idstring'> 0 \ <a onclick=\"del_record('$idstring','$db'); return false;\">del</a> </div>";
                $_RESULT['text'] = $out;
                $_RESULT['sql'] = $SQL;
				$js="document.getElementById(\"select_card_add\").appendChild(cas);
document.getElementById(\"select_card_left\").appendChild(cls);
document.getElementById(\"select_magazin\").appendChild(maga);


";
				$_RESULT['js'] = $js;
                $_RESULT['text'] = $out.
                $_RESULT['err'] = 'no';
        }
        else
        {
                //vidod oshibok
                $_RESULT['err'] = 'yes';
                $log="<center><font color=#cc0000>бл€ сука ) </font></center>".$log;
                $_RESULT['log'] = $log;
        }

}

?>
