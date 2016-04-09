<?

include "../mysql/traff_view.php3";

$dbh=DB_connect();
$SQL = "SELECT * FROM `card_serial` ";
$res=mysql_query($SQL,$dbh);
print mysql_error();
$js="var card_serial=[ ";
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
	$js.="[\"".$pl1[magazine_id]."\",\"".$pl1[name]."\",\"".$pl1[description]."\"]";
}
$js.="];\n";
echo $js;
?>