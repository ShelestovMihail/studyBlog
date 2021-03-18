<?php

namespace LiamProject\Services;

class Db
{
	private $pdo;
	private static $instance;

	private function __construct()
	{
		$dbSettings = (require __DIR__ .  '/../../settings.php')['db'];

		$this->pdo = new \PDO(
			'mysql:host=' . $dbSettings['host'] . ';dbname=' . $dbSettings['db_name'],
			$dbSettings['user'],
			$dbSettings['password']
		);

		$this->pdo->exec('SET NAMES UTF8');
	}

	public function query(string $sql, $params = [], $className = 'stdclass'): ?array
	{
		$sth = $this->pdo->prepare($sql);
		$result = $sth->execute($params);

		if (false === $result) {
			return null;
		}

		return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
	}

	public static function getInstance():self
	{
		if(self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}