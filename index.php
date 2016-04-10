<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if ($db=="income") { $show ="";}
session_start();
include "top.php";
?>
<div id=addtable>11</div><br>
<script type="text/javascript">
  function a() {
    c();
    b();
}

  function b() {
    otvet = show_cashbox('c');
  }
  function c() {
     show_cashbox('o');

  }
</script>
<div id=calc_summ>calc_form</div><br>
<body onload="a()">
</body>
<h1><center><?php echo $show;?></center></h1>


<script type="text/javascript">
	function wo(url,w,h){
		width = screen.width;
		height = screen.height;
		window.open(url, 'showpicture','width='+(w)+',height='+(h)+',left=' +((width-w)/2)+',top=0,fullscreen=0,location=0,menubar=0,scrol lbars=no,status=0,to olbar=0,resizable=yes');
		return false;
	}
</script>

<META http-equiv=Content-Type content="text/html; charset=windows-1251">
<script language=JavaScript src=../JsHttpRequest/JsHttpRequest.js></script>
<script language=JavaScript src=init.js></script>
<script language=JavaScript src=load_array.php></script>
<?
$year=date('Y');
$day=date('d');
$month=date('m');
include  "../mysql/traff_view.php3";
$dbh=DB_connect();
?>

<table border=1>
<tr>
	<td><a onclick="add_intem('add_intem'); return false;" href=#>приход расход</a></td>
	<td><A onclick="alert('only_money'); return false;" href=#>просто деньги без подсчетов</a></td>
</tr>
</table>

<div id=showtable>
</div>

<table border="1">
 <tr>
 	<td bgcolor=#ffd7ba>
	<div id=show_sql_query></div>
	</td></tr><tr>
	<td><div id=show_js>show_js</div></td>
	</tr>
 
</table>


<?
include "down.php"
?>
