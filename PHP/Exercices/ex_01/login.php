<?php

if (!empty($_POST["password"]) && !empty($_POST["username"])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	try {
		$options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
		$pdo = new PDO("mysql:host=localhost:3306;dbname=cash;charset=utf8mb4", 'root', 'qwfpgj', $options);
		$request = "SELECT id, email, role FROM users WHERE email= :email  AND password= :password ";
		$stmt = $pdo->prepare($request);
		$stmt->execute(['email' => $username, 'password' => $password]);
		$results = $stmt->fetch();
		if ($results) {
			var_dump($results);
			echo 'connected';
			$_SESSION['connected'] = true;
			header("Location:index.php");
		} else {
			echo 'fraud !';
		}
	} catch (PDOException $pdoE) {
		var_dump($pdoE);
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