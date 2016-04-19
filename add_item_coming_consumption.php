<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once "../JsHttpRequest/JsHttpRequest.php";
$JsHttpRequest =& new JsHttpRequest("windows-1251");
?>



<div id=addtable>тут таблица с формами...</div><br>
<div id=calc_summ>calc_form</div><br>
<script language=JavaScript src=load_array.php></script>
<table border=1>
<tr>
	<td><a onclick="add_intem('add_intem'); return false;" href=#>приход расход</a></td>
	<td><A onclick="alert('only_money'); return false;" href=#>просто деньги без подсчетов</a></td>
</tr>
</table>

<div id=showtable>
</div>

<script>
/*1 = minimarket */
add_select(id_magazin,20);
add_select(id_magazin,40);
add_select(id_magazin,75);
add_select(id_magazin,100);

</script>