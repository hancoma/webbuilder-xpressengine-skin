<?
$dbconn=mysql_connect("localhost","rforun","tlqkfsha123");
$status = mysql_select_db("rforun",$dbconn);
if (!$status) {
		error("DB_ERROR");
		exit;
}


	?>