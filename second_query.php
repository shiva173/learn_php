<?php 
require_once('login.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);


$db_server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database) or die("Ошибка " . mysqli_error($db_server));

$query_select = "SELECT * FROM customers";

$result_select = mysqli_query($db_server, $query_select);


if (!$result_select) die ("Сбой при доступе к базе данных: " . mysqli_error($db_server));

$rows = mysqli_num_rows($result_select);

for ($i=0; $i < $rows; ++$i) {

	$row = mysqli_fetch_row($result_select);
	echo "$row[0] purchased ISBN $row[1]:<br>";

	$sub_query = "SELECT * FROM classics WHERE isbn='$row[1]'";
	$sub_query_result = mysqli_query($db_server, $sub_query);

	$sub_row = mysqli_fetch_row($sub_query_result);
	echo "'$sub_row[1]' by $sub_row[0]<br>";
}

// две оплезные функции для проверки полей
function mysql_entities_fix_string($string) {
	return htmlentities(mysql_fix_string($string));
}


function mysql_fix_string($string, $db_server){
	if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return mysqli_real_escape_string($connect, $_POST["$var"]);	
}
// добавление пользователя в базу данных users
$user = mysql_entities_fix_string($_POST['user']);
$pass = mysql_entities_fix_string($_POST['pass']);
$query = "SELECT * FROM users WHERE user='$user' AND pass='$pass'";


// mysqli_real_escape_string($connect, $_POST["$var"]); обязательная операция над полученными данными 

/*
PREPARE statement FROM "INSERT INTO classics VALUES(?,?,?,?,?)"; 

SET @author   = "Emily Brotn",
	@title    = "Wuthring Heights",
	@category = "Classics Fiction",
	@year     = "1847",
	@isbn     = "9780553212587";

	Подготовка запроса

EXECUTE statement USING @author,@title,@category,@year,@isbn;

DEALLOCATE PREPARE statement;
	
	Его выполнение
	
*/

 ?>