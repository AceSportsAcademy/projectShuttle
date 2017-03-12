<?php

namespace Core;


use PDO;
use App\Config;

/***
 * Use base model
 *
 * PHP version 5.6
 */

abstract class Model
{
	/***
	 * Get PDO Database connection
	 *
	 * @return mixed
	 */

	protected static function getDB()
	{
		static $db = null;

		if ($db === null){
			//	$host = '127.0.0.1';
			//	$dbname = 'mvc';
			//	$username = 'root';
			//	$password = 'NEW-ROOT-PASSWORD';

				try {
				//		$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
				//		$username, $password);
				
					$dsn = 'mysql:host='.Config::DB_HOST.';dbname='.Config::DB_NAME.';charset=utf8;';

					$db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

				} catch (PDOException $e) {
					echo $e->getMessage();
				}	
		}

		return $db;
	}

}