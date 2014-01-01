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

/*создать соединение */
mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение ");

/* выбрать базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die(mysql_error());  


mysql_query ("set_client='utf8'");
mysql_query ("set character_set_results='utf8'");
mysql_query ("set collation_connection='utf8_general_ci'");
mysql_query ("SET NAMES utf8");

if (!empty($_GET["show"])) 
 {
	 $show = $_GET["show"];
} 

// Выполняем SQL-запрос
$query = "
SELECT show_start,show_end,show_name,show_style,mus_name,mus_adds,pers_name,pers_tel,pers_email FROM art_show
JOIN museum on mus_id = show_mus_id
JOIN person on pers_id = show_pers_id
WHERE show_id = $show;";

$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
while ($line[] = mysql_fetch_array($result, MYSQL_ASSOC)) 
foreach ($line as $col_value) {  
		echo "<td>Название мероприятия: $col_value[show_name]</td><br>\n";
        echo "<td>Дата: $col_value[show_start] - $col_value[show_end]</td><br>\n";
        echo "<td>Место проведения: $col_value[mus_name]</td><br>\n";
        echo "<td>Адрес: $col_value[mus_adds]</td><br>\n";
        echo "<td>Направление: $col_value[show_style]</td><br>\n";
        echo "<td>Контактное лицо: $col_value[pers_name]</td><br>\n";
        echo "<td>Телефон: $col_value[pers_tel]</td><br>\n";
		echo "<td>E-mail: $col_value[pers_email]</td><br>\n";
		echo "<td><a href='a.php?show=$show'</a>Редактировать...</td>\n";
    }
// Освобождаем память от результата
mysql_free_result($result);

// Закрываем соединение
mysql_close($link);

?>

</div>
