<?php

namespace Gaban\Php\Exercices\classes;

use PDO;
use PDOException;

class DB_connection
{
	private static DB_connection $instance;
	private PDO $pdo;

	private function __construct()
	{
		$DB_URL = getenv("db_url");
		$DB_PORT = getenv("db_port");
		$DB_USERNAME = getenv("db_username");
		$DB_PASSWORD = getenv("db_password");

		$options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
		$this->pdo = new PDO("mysql:host=$DB_URL:$DB_PORT;dbname=cash;charset=utf8mb4", $DB_USERNAME, $DB_PASSWORD, $options);
	}

	public static function get_instance(): DB_connection
	{
		if (is_null(self::$instance)) {
			self::$instance = new DB_connection();
		}

		return self::$instance;
	}

	public static function make_query($request, $params = [])
	{
		try {
			$stmt = self::$instance->pdo->prepare($request);
			$stmt->execute($params);
			$results = $stmt->fetchAll();
			if ($results) {
				return $results;
			}
		} catch (PDOException $pdoE) {
			var_dump($pdoE);
		}

		return null;
	}
}
