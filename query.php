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

if ( $taskk == "show_cashbox" ) {
        if($eierr=="no"){
                $dbh=DB_connect();
                $SQL = "select  cashbox.id, magazine.name, card_serial.name, cashbox.count_left, card_serial.name, cashbox.count_add,cashbox.serial_add  from  cashbox,card_serial,magazine where cashbox.magazine= magazine .magazine_id and card_serial.card_id = cashbox.serial_left  ";
                print mysql_error();
                $out .= "<table border=1>";
                $res=mysql_query($SQL,$dbh);
                print mysql_error();
                while ($pl=mysql_fetch_array($res)){
                  $out.="<tr><td>".$pl[count_add]."</td><td>".$pl[date_time]."</td>";
                  $count_left=$pl[count_left];
                  $count_add=$pl[count_add];
                  elseif ( ( $count_left > 1 ) && ( $count_add < 1 )) { $type= "подсчет остатка"; }
                  if ( ($count_left  > ) 1 && ( $count_add > 1 ) ) { $type = "подсчет остатка и дал карточек " ;}
                  else   { $type = "добавил карточек"; }
                  $out .= "<td>".$pl[serial_add]."</td><Td>".$p[count_left]."</td><td>".$pl[serial_left]."</td><td>".$pl[count_add]."</td><td>".$type."</td></tr>";
                }
                $out.="</table>";
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

?>
