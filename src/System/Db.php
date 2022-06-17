<?php

namespace App\System;

use App\Exceptions\DbException as DbException;

class Db {
    private static $instance;
    private $user;
    private $pass;
    private $host;
    private $dbName;
    private $pdo;

    private function __construct() {
        $dbParams = (require ROOT. '/../settings/db.php')['db'];

        $this->user = $dbParams['user'];
        $this->pass = $dbParams['password'];
        $this->host = $dbParams['host'];
        $this->dbName = $dbParams['dbname'];

        try {
            $this->pdo = new \PDO(
                'mysql:dbname=' . $dbParams['dbname'] . ';host=' . $dbParams['host'],
                $dbParams['user'], $dbParams['password']
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new DbException('Ошибка при подключении к базе данных: ' . $e->getMessage());
        }
    }

    public function query(string $sql, array $params = [], $className = 'stdClass'): ?array {
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute($params);
        if ($result === false) {
            return null;
        }

        return $stmt->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getLastInsertId(): int {
        return (int) $this->pdo->lastInsertId();
    }
}