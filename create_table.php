<?php  

ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once('login.php');

$db_connect = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
/*
$query_create = "CREATE TABLE cats (
		 id SMALLINT NOT NULL AUTO_INCREMENT,
		 family VARCHAR(32) NOT NULL,
		 name VARCHAR(32) NOT NULL,
		 age TINYINT NOT NULL,
		 PRIMARY KEY (id)
		)";

$result_create = mysqli_query($db_connect, $query_create);
if (!$result_create) ("Сбой при добавлении к базе данных: " . mysqli_error($db_server));
*/




//$first = 'NULL';
//$second = "Cat";
//$third = "Barsik";
//$fourth = 4;

insert('NULL', "Lynx", "Stumpy", 4, $db_connect);


function insert($first, $second, $third, $fourth, $db_connect) {

$query_insert = "INSERT INTO cats (id, family, name, age) VALUES
('$first', '$second', '$third', '$fourth')";

$result_insert = mysqli_query($db_connect, $query_insert) or die("Ошибка при вставке данных: " . mysqli_error($db_connect));

$insertID = mysqli_insert_id($db_connect);

$query_insert_owner = "INSERT INTO owners VALUES($insertID, 'Ann', 'Smith')";

$result_insert_owner = mysqli_query($db_connect, $query_insert_owner);

return print($result_insert);

}

$query_update = "UPDATE cats SET name='Charlie' WHERE name='Charly'";
$result_update = mysqli_query($db_connect, $query_update);


$query_delete = "DELETE FROM cats WHERE name='Barsik'";
$result_delete = mysqli_query($db_connect, $query_delete);




$query_describe = "SELECT * FROM cats";

$result_describe = mysqli_query($db_connect, $query_describe);

$rows = mysqli_num_rows($result_describe);


echo "<table><tr> <th>Column</th> <th>Type</th>
	 <th>NULL</th> <th>Key</th> </tr>";


for ($i=0; $i < $rows; $i++) { 
	
	$row = mysqli_fetch_row($result_describe);

	echo "<tr>";

	for ($j = 0; $j < 4; $j++) {
	
		echo "<td>$row[$j]</td>";
	
	}
	
	echo "</tr>";		 
}

echo "</table>";

?>

