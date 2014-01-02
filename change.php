<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
		<style>
	#White{
		width: 100%;
		background-color: #ffffff;
	}
	#Fond{
		padding-top: 15;
		width: 100%;
		background-image: url("");
		height: 100%;
	}
	.p {font-size: 11pt;}
	</style>
	
</head>
<div id="White">
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

// Выполняем SQL-запрос
$query = "
 UPDATE art_show 
 SET show_name = '$name',
 show_start = '$start',
 show_end = '$end',
 show_style = '$style' 
 WHERE show_id = $show;";
 
mysql_query($query);

echo $name;

// Освобождаем память от результата
mysql_free_result($result);

// Закрываем соединение
mysql_close($link);

header("Refresh: 0; url=http://artshows.loc/a.php?show=$show");
?>

</div>
