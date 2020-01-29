<?php  
require_once('login.php');


error_reporting(E_ALL);
ini_set('display_errors', 1);

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

if ($connection->connect_error) die($connection->connect_error);

$query_create = "CREATE TABLE users (
		 firstname VARCHAR(32) NOT NULL,
		 secondname VARCHAR(32) NOT NULL,
		 username VARCHAR(32) NOT NULL,
		 password VARCHAR(32) NOT NULL)";

$result_create = $connection->query($query_create);

if (!$result_create) die($connection->error);

$salt1 = "jgfkldjkl";
$salt2 = "@!&*";

$firstname = "John";
$secondname = "Smith";
$username = "JSmith";
$password = "secretpass";
$token = hash('ripemd128', "$salt1$password$salt2");

add_user($connection, $firstname, $secondname, $username, $token);


$firstname = "Erick";
$secondname = "Macdonald";
$username = "EMac";
$password = "secretpass";
$token = hash('ripemd128', "$salt1$password$salt2");


add_user($connection, $firstname, $secondname, $username, $token);


function add_user($connection, $fn, $sn, $un, $pw) {
	$query_insert = "INSERT INTO users VALUES('$fn', '$sn', '$un', '$pw')";
	$result_insert = $connection->query($query_insert);
	if (!$result_insert) die($connection->error);
}


//phpinfo();



?>