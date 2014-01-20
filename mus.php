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
	
	}
	#Left{
		font-size: 24pt;
		margin: 300px 90px;
		position: fixed;
	}
	#Right{
		float:right;
		font-size: 24pt;
		margin: 270px 90px;
	}
	.p {font-size: 11pt;}
	.d {font-size: 9pt;}
	 a{ color:green; text-decoration:none; }
	</style>
	
</head>
<p style="position: fixed;"><a href='index.php'>На главную</a></p> 
<div id="Left">
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

if (!empty($_GET["mus"])) 
 {
	 $mus = $_GET["mus"];
} 

$mus_pred = $mus-1;
$mus_next = $mus+1;


$result_count = mysql_query("SELECT count(*) FROM museum;");
$row_count = mysql_fetch_array($result_count);
$mus_count = $row_count[0]; 

if ($mus > 1) echo "<a href='mus.php?mus=$mus_pred'><</a>";

echo "</div>";
echo "<div id='Right'>";   
	                                                            
if ($mus < $mus_count) echo "<p style='position: fixed;'><a href='mus.php?mus=$mus_next'>></a></p>";

?>
</div>

<div id="Show">
<?php

// Выполняем SQL-запрос
$query = "
SELECT mus_name, mus_adds, pers_name, pers_tel, pers_email
FROM museum
JOIN person on pers_id = mus_pers_id
WHERE mus_id = $mus;";

echo "<center>";
$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
while ($line[] = mysql_fetch_array($result, MYSQL_ASSOC)) 
foreach ($line as $col_value) {  
		echo "<h1>$col_value[mus_name]</h1><br>";
        echo "<td>Адрес: $col_value[mus_adds]</td><br>";
        echo "<td>Контактное лицо: $col_value[pers_name]</td><br>";
        echo "<td>Телефон: $col_value[pers_tel]</td><br>";
		echo "<td>E-mail: $col_value[pers_email]</td><br>";
   }
echo "</center>";
echo "Выставки:<br>";

// Выполняем SQL-запрос
$query_show = "
SELECT show_id,show_name,show_start,show_end FROM art_show
JOIN museum on mus_id = show_mus_id
WHERE mus_id = $mus
ORDER BY show_start;";

echo "<font size='2'>";
$result = mysql_query($query_show) or die('query has dont work: ' . mysql_error());
while ($line1[] = mysql_fetch_array($result, MYSQL_ASSOC));
  foreach ($line1 as $col_value) {  
        echo "<br><a href='show.php?show=$col_value[show_id]'>$col_value[show_name]</a>";
        echo "<br>$col_value[show_start] - $col_value[show_end]<br>";
    }
echo "</font>";
    
// Освобождаем память от результата
mysql_free_result($result);

// Закрываем соединение
mysql_close($link);

?>
</div>


