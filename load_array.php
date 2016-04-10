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
	$js.="[\"".$pl[magazine_id]."\",\"".$pl[name]."\",\"".$pl[description]."\"]";
}
$js.="];\n";
echo $js;
?>


var maga = document.createElement('select');
maga.name = 'magazin';
maga.id = 'magazin_sel';
maga.onchange = function(){Add();};
var options_str = "";
arr_shop.forEach( function(arr_i,i,arr) {
	  options_str += '<option value="' + arr_i[0] + '">' + arr_i[1] + '</option>';
});
maga.innerHTML = options_str;

var cas = document.createElement('select');
cas.name = 'card_add_sel';
cas.id = 'card_add_sel_id';
cas.onchange = function(){Add();};
var options_str = "";
card_serial.forEach( function(arr_i,i,arr) {
	  options_str += '<option value="' + arr_i[0] + '">' + arr_i[1] + '</option>';
});
cas.innerHTML = options_str;


var cls = document.createElement('select');
cls.name = 'card_left_sel';
cls.id = 'card_left_sel_id';
cls.onchange = function(){Add();};
var options_str = "";
card_serial.forEach( function(arr_i,i,arr) {
	  options_str += '<option value="' + arr_i[0] + '">' + arr_i[1] + '</option>';
});
cls.innerHTML = options_str;

