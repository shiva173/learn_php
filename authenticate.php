<?php  

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('login.php');



$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);


if ($connection->connect_error) die($connection->connect_error);


if (isset($_SERVER['PHP_AUTH_USER']) && 
	isset($_SERVER['PHP_AUTH_PW'])) {

	$un_temp = mysql_entities_fix_string($connection, $_SERVER['PHP_AUTH_USER']);
	$pw_temp = mysql_entities_fix_string($connection, $_SERVER['PHP_AUTH_PW']);


	$query = "SELECT * FROM users WHERE username='$un_temp'";
	$result = $connection->query($query);
	
	if (!$result) die($connection->error);
	elseif ($result->num_rows) {

		$row = $result->fetch_array(MYSQLI_NUM);

		$result->close();


		$salt1 = "!@%&";
		$salt2 = "*^%";
		$token = hash('ripemd128', "$salt1$pw_temp$salt2");

		if ($token == $row[3]) {
			
		session_start();

		$_SESSION['username']   = $un_temp;
		$_SESSION['password']   = $pw_temp;
		$_SESSION['firstname']  = $row[0];
		$_SESSION['secondname'] = $row[1];

		echo "$row[0] $row[1] : Hello, $row[0],
		now you registration by name '$row[2]'";
		die("<p><a href=continue.php> click here for continue</a></p>");

	}

		else die("Не верная комбинация");
	} 

	else die("Не вераня комбинация");

} else {
	header('WWW-Authenticate: Basic realm="Restricted Section"');
	header('HTTP/1.0 401 Unauthorized');
	die("Введите Логин и Пароль");
}

$connection->close();


function mysql_entities_fix_string($connection, $string) {
	return htmlentities(mysql_fix_string($connection, $string));
}

function mysql_fix_string($connection, $string) {

	if (get_magic_quotes_gpc()) $string = stripslashes($string);

	return mysqli_real_escape_string($connection, $string);

}


?>