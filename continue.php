<?php  

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();

if (isset($_SESSION['username'])) {

	$username = $_SESSION['username'];
	$password = $_SESSION['password'];
	$firstname = $_SESSION['firstname'];
	$secondname = $_SESSION['secondname'];

	destroy_session();

	echo "Welcom back ! $firstname.<br>
		 Your name: $firstname $secondname.<br>
		 Your username: '$username'
		 Your password: '$password'.";
} else echo "Pliease, for sign in <a href='authenticate.php'> click here</a>.";

	function destroy_session() {

		$_SESSION = array();

		if (session_id() != "" || isset($_COOKIE[session_name()]))

			setcookie(session_name(), '', time() - 2592000, '/');
	}

?>