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
<div id=addtable></div><br>
<script type="text/javascript">
  function a() {
    c();
    b();
}
  function b() {
    //otvet = show_cashbox('c');
  }
  function c() {
     show_cashbox('o');
     //add_select(id_magazin,20);
  }
</script>

<head>
<link href="cache_box.css" rel="stylesheet" type="text/css">
<link media="@media screen and (device-width: 800px)" rel="stylesheet" href="mobile.css" />
</head>

<body>
<div id=calc_summ></div>
<div id=sql></div>
<div id=button></div><br>
<body onload="a()">

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="http://185.43.251.89/bootstrap-3.3.6-dist/js/bootstrap.js"></script>
<script language=JavaScript src=init.js></script>
</body>

<table border=1>
<tr>
	<td><a onclick="add_intem('add_intem'); return false;" href=#>добавить карточек</a></td>
	<td><A onclick="add_intem('only_money'); return false;" href=#>только деньги</a></td>
</tr>
</table>

<div id="showtable">
</div>

<table border="1">
 <tr>
    <td bgcolor=#ffd7ba><div id=show_sql_query></div></td>
 </tr>
 <tr>
    <td><div id=show_js></div></td>
 </tr>
</table>
</body>

<?
include "down.php"
?>
