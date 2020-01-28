<?php  
require_once('login.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

$db_server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

$query_prepare = 'PREPARE statement FROM "INSERT INTO classics VALUES(?,?,?,?,?)"';
$result_prepare = mysqli_query($db_server, $query_prepare); 


$query_set_value = 'SET @author = "Emily Brontn",' .
				   '@title 		= "Wuthiring Heights",' .
				   '@category   = "Classics Fiction",' .
				   '@year       = "1847",' .
				   '@isbn       = "9780553212587"';
$result_set_value = mysqli_query($db_server, $query_set_value);

$query_execute = 'EXECUTE statement USING @author,@title,@category,@year,@isbn';
$result_execute = mysqli_query($db_server, $query_execute);

$query_complete = 'DEALOCATE PREPARE statement';
$result_complete = mysqli_query($db_server, $query_complete);


?>