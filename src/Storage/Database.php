<?php

namespace App\Storage;

use Exception;
use PDO;
use PDOStatement;

class Database
{
    private static ?Database $instance = null;
    private ?PDO $pdo;
    private false|PDOStatement $stmt;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        try {
            $this->pdo = new PDO($_ENV['DATABASE_PROVIDER'] . ':host=' . $_ENV['DATABASE_HOST'] . ';dbname=' . $_ENV['DATABASE_NAME'], $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            throw new Exception('Database connection error: ' . $e->getMessage());
        }
    }

    /**
     * This method return Storage\Database instance
     *
     * @return Database
     */
    public static function getInstance(): Database
    {
        if (is_null(self::$instance)) self::$instance = new Database();
        return self::$instance;
    }

    /**
     * This method execute SQL query
     *
     * @param $query
     * @param $params
     * @return bool|PDOStatement
     */
    public function executeQuery($query, $params = array()): bool|PDOStatement
    {
        if ($this->stmt) $this->stmt = null;
        $this->stmt = $this->pdo->prepare($query);
        $this->stmt->execute($params);
        return $this->stmt;
    }

    /**
     * This method fetch data obtained from the database
     *
     * @return bool|array
     */
    public function fetchAll(): bool|array
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This method start transaction
     *
     * @return void
     */
    public function startTransaction(): void
    {
        $this->pdo->beginTransaction();
    }

    /**
     * This method commit changes to a transaction
     *
     * @return void
     */
    public function commit(): void
    {
        $this->pdo->commit();
    }

    /**
     * This method rollback changes to a transaction
     *
     * @return void
     */
    public function rollback(): void
    {
        $this->pdo->rollback();
    }

    /**
     * This method close Database connection
     *
     * @return void
     */
    public function close(): void
    {
        $this->pdo = null;
    }
}