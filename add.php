<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
    <style>body{background:beige;}</style>
</head>
<form method="get" action="add_s.php">

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

// Выполняем SQL-запрос
$query_mus = "SELECT mus_name FROM museum;";
$result_mus = mysql_query($query_mus) or die('query has dont work: ' . mysql_error());

//echo "<td>Id мероприятия: <INPUT TYPE= 'text' NAME= 'show' VALUE='$show'></td><br>\n";
echo "<td>Название мероприятия: <INPUT TYPE= 'text' SIZE='50' NAME= 'name' VALUE='$col_value[show_name]'></td><br>\n";
echo "<td>Дата: <INPUT TYPE= 'date' NAME= 'start' VALUE= '$col_value[show_start]'> - <INPUT TYPE= 'date' NAME= 'end' VALUE= '$col_value[show_end]'></td><br>\n";
echo "<td>Место проведения: </td>";
echo "<select name = 'mus'>";
echo "<option value='$col_value[mus_name]'>$col_value[mus_name]</option>";
while($object = mysql_fetch_object($result_mus)){
echo "<option value='$object->mus_name'>$object->mus_name</option>";
}
echo "</select><br>";
// echo "<td>Адрес: <INPUT NAME= 'adds' VALUE= '$col_value[mus_adds]'></td><br>\n";
echo "<td>Направление: <INPUT NAME= 'style' VALUE= '$col_value[show_style]'></td><br>\n";
echo "<td>Контактное лицо: <INPUT NAME= 'pers' VALUE= '$col_value[pers_name]'></td><br>\n";
echo "<td>Телефон: <INPUT NAME= 'tel' VALUE= '$col_value[pers_tel]'></td><br>\n";
echo "<td>E-mail: <INPUT NAME= 'email' VALUE= '$col_value[pers_email]'></td><br>\n";
echo "<td><INPUT TYPE='submit' VALUE='Сохранить изменения' ></td><br>\n";
// Освобождаем память от результата
mysql_free_result($result);

// Закрываем соединение
mysql_close($link);

//header("Refresh: 0; url=http://artshows.loc");

?>
<input type=button onClick="parent.location='http://artshows.loc/index.php'" value='На главную'>
