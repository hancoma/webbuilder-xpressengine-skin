<?
$dbconn=mysql_connect("localhost","danbi","818888");
mysql_query('set names utf8',$dbconn);
$status = mysql_select_db("danbi",$dbconn);
if (!$status) {
		error("DB_ERROR");
		exit;
}


	?>