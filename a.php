<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
		<style>
			body{background:beige;}
	#White{

		
	}
	#Fond{
		
		padding: 20px;
		padding-top: 15;
		width: 100%;
		background-image: url("");
		background-color: #ffcc66;
		height: 100%;
	}
	.p {font-size: 11pt;}
	</style>
	
</head>
<center>

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

?>

<form method="get" action="change.php">

<?php

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
SELECT show_start,show_end,show_name,show_style,mus_name,mus_adds,pers_name,pers_tel,pers_email FROM art_show
JOIN museum on mus_id = show_mus_id
JOIN person on pers_id = show_pers_id
WHERE show_id = $show;";

$query_select = "SELECT mus_name FROM museum;";
$result_select = mysql_query($query_select) or die('query has dont work: ' . mysql_error());

$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
while ($line[] = mysql_fetch_array($result, MYSQL_ASSOC)) 
foreach ($line as $col_value) {  
		echo "<td>Id мероприятия: <INPUT TYPE= 'hidden' NAME= 'show' VALUE='$show'>$show</td><br>\n";
	    echo "<td>Название мероприятия: <INPUT TYPE= 'text' SIZE='50' NAME= 'name' VALUE='$col_value[show_name]'></td><br>\n";
        echo "<td>Дата: <INPUT TYPE= 'date' NAME= 'start' VALUE= '$col_value[show_start]'> - <INPUT TYPE= 'date' NAME= 'end' VALUE= '$col_value[show_end]'></td><br>\n";
        echo "<td>Место проведения: </td>";
        echo "<select name = 'mus'>";
        echo "<option value='$col_value[mus_name]'>$col_value[mus_name]</option>";
		while($object = mysql_fetch_object($result_select)){
		echo "<option value='$object->mus_name'>$object->mus_name</option>";
		}
		echo "</select><br>";
        // echo "<td>Адрес: <INPUT NAME= 'adds' VALUE= '$col_value[mus_adds]'></td><br>\n";
        echo "<td>Направление: <INPUT NAME= 'style' VALUE= '$col_value[show_style]'></td><br>\n";
        echo "<td>Контактное лицо: <INPUT NAME= 'pers' VALUE= '$col_value[pers_name]'></td><br>\n";
        echo "<td>Телефон: <INPUT NAME= 'tel' VALUE= '$col_value[pers_tel]'></td><br>\n";
		echo "<td>E-mail: <INPUT NAME= 'email' VALUE= '$col_value[pers_email]'></td><br>\n";
		echo "<td><INPUT TYPE='submit' VALUE='Сохранить изменения' ></td><br>\n";

    }
    


// Освобождаем память от результата
mysql_free_result($result);

// Закрываем соединение
mysql_close($link);

?>
</form>
</center>
