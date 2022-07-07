<?php

class Db
{
	public static function getConnection()
	{
		$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/params/db_params.php';
		$params = include($paramsPath);


		$dsn = "mysql:host={$params['host']};dbname={$params['db']};charset={$params['charset']}";
		$opt = [
			PDO::ATTR_ERRMODE				=> PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE 	=> PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES		=> false
		];

		try {
			$connect = new PDO($dsn, $params['user'], $params['pass'], $opt);
		} catch (Exception $e) {
			die("unable to connect: " . $e->getMessage());
		}

		return $connect;
	}
}

?>
