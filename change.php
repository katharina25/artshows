<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
	</head>
	<?php

/* Переменные для соединения с базой данных */
$hostname = "localhost";
$username = "root";
$password = "";
$dbName = "art_shows";

if (!empty($_GET["show"])) 
{
	 $show  = $_GET["show"];
	 $name  = $_GET["name"];
	 $start = $_GET["start"];
	 $end   = $_GET["end"];
	 $mus   = $_GET["mus"];
	 $adds  = $_GET["adds"];
     $style = $_GET["style"];
     $pers  = $_GET["pers"];
     $tel   = $_GET["tel"];
     $email = $_GET["email"];
} 

/*создать соединение */
mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение ");

/* выбрать базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die(mysql_error());  

mysql_query ("set_client='utf8'");
mysql_query ("set character_set_results='utf8'");
mysql_query ("set collation_connection='utf8_general_ci'");
mysql_query ("SET NAMES utf8");

// выбор музея из списка
$query_mus = "
SELECT mus_id FROM museum
WHERE mus_name = '$mus';";

$result_mus = mysql_query($query_mus) or die('query has dont work: ' . mysql_error());
$row_mus = mysql_fetch_array($result_mus);
$mus_id = $row_mus[mus_id];

// изменение контактного лица
$query_pers = "
SELECT pers_id FROM person
WHERE pers_name = '$pers';";

$result_pers = mysql_query($query_pers) or die('query has dont work: ' . mysql_error());
$row_pers = mysql_fetch_array($result_pers);
$pers_id = $row_pers[pers_id];

//echo $pers_id;

if ($pers_id == NULL) {
	$result_count = mysql_query("SELECT count(*) FROM person;");
	$row_count = mysql_fetch_array($result_count);
	$pers_id = $row_count[0]+1; 
	}
	
$query_pers_change = "INSERT INTO person (pers_id,pers_name,pers_tel,pers_adds,pers_email) 
VALUES('$pers_id','$pers','$tel','отсутствует','$email');";

echo $pers_id.$pers.$tel.$email.$show;

$query_show = "
 UPDATE art_show 
 SET show_name = '$name', 
 show_style = '$style',
 show_start = '$start',
 show_end = '$end',
 show_mus_id = '$mus_id',
 show_pers_id = '$pers_id'
 WHERE show_id = '$show';";
 
$query_mus_adds = "
UPDATE museum
SET mus_adds = '$adds'
WHERE mus_id = '$mus_id';";
 
mysql_query($query_pers_change);
mysql_query($query_show);
mysql_query($query_mus_adds);

// Освобождаем память от результата
mysql_free_result($result);

// Закрываем соединение
mysql_close($link);

header("Refresh: 0; url=http://artshows.loc/a.php?show=$show");
?>
