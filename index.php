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
    //otvet = show_cashbox('c');
  }
  function c() {
     show_cashbox('o');
     //add_select(id_magazin,20);
  }
</script>
<div id=calc_summ>calc_form</div>
<div id=sql></div>
<div id=button></div><br>
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

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />

<table border=1>
<tr>
	<td><a onclick="add_intem('add_intem'); return false;" href=#>добавить карточек</a></td>
	<td><A onclick="alert('only_money'); return false;" href=#>только деньги</a></td>
</tr>
</table>

<div id=showtable>
</div>

<table border="1">
 <tr>
 	<td bgcolor=#ffd7ba>
	<div id=show_sql_query></div>
	</td></tr><tr>
	<td><div id=show_js></div></td>
	</tr>
 
</table>


<?
include "down.php"
?>
