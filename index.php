<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if ($db=="income") { $show ="Финансовый Касса \ Подключения";}
session_start();
include "top.php";
?>
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
</head>
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
<script language=JavaScript src=/JsHttpRequest/JsHttpRequest.js></script>
<script language=JavaScript src=init.js></script>

<?
$year=date('Y');
$day=date('d');
$month=date('m');
include $_SERVER["DOCUMENT_ROOT"]."/mysql/traff_view.php3";
$dbh=DB_connect();
?>

<table><tr>
<td>сумма:</td><td>Комментарий</td></tr>
<tr><td><input type="hidden" id=db value="maxim"><input type=text value="" id=sum_i></td><td><input type=text  size=100 value="" id=commentaries_i> <input type=submit  id='seatchuser'   onclick="save_show_max('c'); return false;" value="подключеие"> <input type=submit  id='seatchuser'   onclick="save_show_max('k'); return false;" value="Касса"></td></tr>
</table>
<div id=showtable>
<table width=100% ><Tr><td width=100>дата</td><td width=100>автор</td><td width=100>сумма</td><td>примечание</td></Tr>

<?
$sql="select....";
?>
</table>
</div>


<div id=showsqury_o>

</div>

<?
include "down.php"
?>
