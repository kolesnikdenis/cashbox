<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if ($db=="income") { $show ="���������� ����� \ �����������";}
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
<script language=JavaScript src=../JsHttpRequest/JsHttpRequest.js></script>
<script language=JavaScript src=init.js></script>

<?
$year=date('Y');
$day=date('d');
$month=date('m');
include  "../mysql/traff_view.php3";
$dbh=DB_connect();
?>

<table><tr>
<td>�����:</td><td>�����������</td></tr>
<tr><td><input type="hidden" id=db value="maxim"><input type=text value="" id=sum_i></td><td><input type=text  size=100 value="" id=commentaries_i> <input type=submit  id='seatchuser'   onclick="save_show_max('c'); return false;" value="����������"> <input type=submit  id='seatchuser'   onclick="save_show_max('k'); return false;" value="�����"></td></tr>
</table>
<div id=showtable>
<table width=100% ><Tr><td width=100>����</td><td width=100>�����</td><td width=100>�����</td><td>����������</td></Tr>

<?
$sql="select....";
?>
</table>
</div>
<table border="1"> <tr><td bgcolor=red><div id=show_sql_query></div></td></tr></table>


<?
include "down.php"
?>
