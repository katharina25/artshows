<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
		<style>
    	body{
		background-image:url(fon.jpg);

		}
	#Show{
		padding: 5px;
		margin: 0px 200px;
		background:beige; 
		text-align: center;
	
	}
	#Left{
		font-size: 24pt;
		
		position: fixed;
	}
	#Right{
		font-size: 24pt;
		margin: 300px 1176px;
		position: fixed;
	}
	.p {font-size: 11pt;}
	.d {font-size: 9pt;}
	 a{ color:green; text-decoration:none; }
	</style>
	<style>
@media print
{
	
	div#Left {
		display: none;
		}
	div#Right {
		display: none;
		}
	div#Show{
		margin: 0px 0px;
		float: center;
		width: 22 cm;
		text-align: center;
	}
	lk{
		display: none;
	}
	
}

    </style>
</head>

<div id="Left">
<p style="font-size: 11pt;"><a href='index.php'>На главную</a></p> 
<p style="position: fixed; top: 92%; font-size: 11pt;"><input type="button" value="Печать" onclick="javascript:print()"></p>
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

$show_pred = $show-1;
$show_next = $show+1;

do {
$query_test1 = "SELECT show_id FROM art_show WHERE show_id = $show_pred;";
$query_test2 = "SELECT show_id FROM art_show WHERE show_id = $show_next;";

$result_test1 = mysql_query($query_test1);
$result_test2 = mysql_query($query_test2);
$row_test1 = mysql_fetch_array($result_test1);
$row_test2 = mysql_fetch_array($result_test2);

if (!$row_test1[0]) $show_pred = $show_pred-1;
if (!$row_test2[0]) $show_next = $show_next+1;
}
while (!$row_test1[0] || !$row_test2[0]);

$query_mus_show = "
SELECT show_name FROM art_show 
WHERE show_mus_id IN 
(SELECT show_mus_id FROM art_show
WHERE show_id = $show);";

$result_count = mysql_query("SELECT count(*) FROM art_show;");
$row_count = mysql_fetch_array($result_count);
$show_count = $row_count[0]; 




$query = '
SELECT show_id
FROM art_show
ORDER BY show_start';

if ($show > 1) echo "<p style='margin: 300px 90px;'> <a href='show.php?show=$show_pred'><</a></p>";

echo "</div>";
echo "<div id='Right'>";   
	                                                            
if ($show < $show_count) echo "<a href='show.php?show=$show_next'>></a>";

?>
</div>

<div id="Show">
<?php

// Выполняем SQL-запрос
$query = "
SELECT show_start,show_end,show_name,show_style,mus_id,mus_name,mus_adds,pers_name,pers_tel,pers_email FROM art_show
JOIN museum on mus_id = show_mus_id
JOIN person on pers_id = show_pers_id
WHERE show_id = $show;";

$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
while ($line[] = mysql_fetch_array($result, MYSQL_ASSOC)) 
foreach ($line as $col_value) {  
		echo "<h1>$col_value[show_name]</h1><br>";
		echo "<a href='mus.php?mus=$col_value[mus_id]'>$col_value[mus_name]</a><br>";
        echo "<td>Дата: $col_value[show_start] - $col_value[show_end]</td><br>";
        
        echo "<td>Адрес: $col_value[mus_adds]</td><br>";
        echo "<td>Направление: $col_value[show_style]</td><br>";
        echo "<td>Контактное лицо: $col_value[pers_name]</td><br>";
        echo "<td>Телефон: $col_value[pers_tel]</td><br>";
		echo "<td>E-mail: $col_value[pers_email]</td><br>";
		echo "<lk><td><a href='a.php?show=$show'</a>Редактировать...</td><br>";
		echo "<td><a href='delete.php?show=$show'</a>Удалить выставку</td><br></lk>";
    }
// Освобождаем память от результата
mysql_free_result($result);

// Закрываем соединение
mysql_close($link);

$pict = $show%40 + 1;
echo "<img src='$pict.jpg' align='center' width='640' height='360'/>";

?>
</div>


