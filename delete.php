<?php

/* Переменные для соединения с базой данных */
$hostname = "localhost";
$username = "root";
$password = "";
$dbName = "art_shows";

if (!empty($_GET["show"])) 
 {
	 $show = $_GET["show"];
} 

/*создать соединение */
mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение ");

/* выбрать базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die(mysql_error());  

mysql_query ("set_client='utf8'");
mysql_query ("set character_set_results='utf8'");
mysql_query ("set collation_connection='utf8_general_ci'");
mysql_query ("SET NAMES utf8");

$query1 = "DELETE FROM show_work WHERE show_work_show_id = '$show';";
$query2 = "DELETE FROM art_show WHERE show_id = '$show'";
 
mysql_query($query1);
mysql_query($query2);

// Освобождаем память от результата
mysql_free_result($result);

// Закрываем соединение
mysql_close($link);

header("Refresh: 0; url=http://artshows.loc");

?>
