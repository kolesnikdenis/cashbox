<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE);
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();

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


if ( $taskk == "load_array_js" ) {

    if($eierr=="no"){
        $SQL = "SELECT * FROM `card_serial` ";
        $res=mysql_query($SQL,$dbh);
        print mysql_error();
        $js="var arr_card_serial=[ ";
        $i=0;
        while ($pl=mysql_fetch_array($res)){
            $i++;
            if ($i>1) { $js .=","; }
            $js.="[\"".$pl[card_id]."\",\"".$pl[name]."\",\"".$pl[summ]."\"]";

        }
        $js.="];\n";
        $SQL = "SELECT * FROM `magazine` ";
        $res=mysql_query($SQL,$dbh);
        print mysql_error();
        $js.="var arr_shop=[ ";
        $i=0;
        while ($pl=mysql_fetch_array($res)){
            $i++;
            if ($i>1) { $js .=","; }
            $js.="[\"".$pl[magazine_id]."\",\"".$pl[name]."\",\"".$pl[description]."\"]";
        }
        $js.="];\n";
        $_RESULT['js'] = $js;
    }
    else
    {
        //vidod oshibok
        $_RESULT['err'] = 'yes';
        $log="Alert('сука бля error');";
        $_RESULT['log'] = $log;
    }
}
?>