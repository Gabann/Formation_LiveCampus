<?php

use Gaban\Php\Exercices\classes\DB_connection;

require_once '../../../vendor/autoload.php';

/**
 * @throws Exception
 */
function try_login(): bool
{
	if (empty($_POST["password"]) || empty($_POST["username"])) {
		throw new Exception("Missing username or password");
	}
	$username = $_POST['username'];
	$password = $_POST['password'];

	$results = DB_connection::get_instance()::make_query("SELECT id, email, role FROM users WHERE email= :email  AND password= :password",
		['email' => $username, 'password' => $password]);
	if ($results) {
		$_SESSION['connected'] = true;
		header("Location:index.php");
		return true;
	} else {
		echo 'fraud !';
		return false;
	}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		try_login();
	} catch (Exception $e) {
		echo $e;
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, initial-scale=1.0">
	<title>HTML</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
	      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<form method="post">
	<label>
		<input type="text" name="username">
	</label>
	<label>
		<input type="password" name="password">
	</label>
	<button type="submit">Submit</button>
</form>
</body>
</html>
