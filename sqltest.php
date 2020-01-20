<?php // sqltest


ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once('login.php');


$db_server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database) or die("Ошибка " . mysli_error($db_server)); // подключение к базе

if (!$db_server) die("Cant connect at database " . mysqli_error($db_server));


//удаление данных
if (isset($_POST['delete']) && isset($_POST['isbn'])) {
	
	$isbn = get_post($db_server, 'isbn');

	$query_delete = "DELETE FROM classics WHERE isbn='$isbn'";
	
	$result_delete = mysqli_query($db_server, $query_delete) or die("Ошибка " . mysqli_error($db_server)); //выполнение запроса

	if (!$result_delete) echo "Error: cant delete data  $result";
	
}

	if (isset($_POST['author']) && 
		isset($_POST['title']) &&
		isset($_POST['category']) &&
		isset($_POST['year']) && 
		isset($_POST['isbn'])) 
	{		

	$author 	= get_post($db_server, 'author');
	$title 		= get_post($db_server, 'title');
	$category 	= get_post($db_server, 'category');
	$year 		= get_post($db_server, 'year');
	$isbn 		= get_post($db_server, 'isbn');
	
	

	$query_insert = "INSERT INTO classics (author, title, category, year, isbn) VALUES ('$author', '$title', '$category', '$year', '$isbn')";

	$result_insert = mysqli_query($db_server, $query_insert) or die("Ошибка " . mysqli_error($db_server));

	if (!$result_insert) echo "Сбой при вставке данных: $result<br>";
	
}

//Форма добавления записей 
echo <<<_END
<form action="sqltest.php" method="post"><pre>
Author 	 <input type="text" name="author">
Title 	 <input type="text" name="title">
Category <input type="text" name="category">
Year 	 <input type="text" name="year">
ISBN 	 <input type="text" name="isbn">
		 <input type="submit" value="ADD RECORD">
</pre></form>
_END;


$query_select = "SELECT * FROM classics";
// добавление данных
$result_select = mysqli_query($db_server, $query_select); 

if (!$result_select) ("Сбой при доступе к базе данных: " . mysqli_error($db_server));


$rows = mysqli_num_rows($result_select);

for ($i = 0; $i < $rows; $i++) {
	$row = mysqli_fetch_row($result_select); // хранит строки запроса в виде массива


echo <<<_END
<pre><br>
Author 		$row[0]
Title		$row[1]
Category	$row[2]
Year		$row[3]
ISBN		$row[4]
</pre>
<form action="sqltest.php" method="post">
<input type="hidden" name="delete" value="yes">
<input type="hidden" name="isbn" value="$row[4]">
<input type="submit" value="DELETE RECORD"></form>
_END;
}



mysqli_close($db_server);

function get_post($connect, $var) { //экранирование специальных симовлов  
	return mysqli_real_escape_string($connect, $_POST["$var"]);
}

?> 