<?php

namespace App\Storage;

use Exception;
use PDO;
use PDOStatement;

class Database
{
    private static ?Database $obInstance = null;
    private ?PDO $obPdo = null;
    private bool|PDOStatement $obStmt = false;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        try {
            $this->obPdo = new PDO($_ENV['DATABASE_PROVIDER'] . ':host=' . $_ENV['DATABASE_HOST'] . ';dbname=' . $_ENV['DATABASE_NAME'], $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD']);
            $this->obPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            throw new Exception('Database connection error: ' . $e->getMessage());
        }
    }

    /**
     * This method return Storage\Database instance
     *
     * @return Database
     * @throws Exception
     */
    public static function getInstance(): Database
    {
        try {
            if (is_null(self::$obInstance)) self::$obInstance = new Database();
            return self::$obInstance;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * This method execute SQL query
     *
     * @param string $strQuery
     * @param array $arParams
     * @return bool|PDOStatement
     * @throws Exception
     */
    public function executeQuery(string $strQuery, array $arParams = []): bool|PDOStatement
    {
        try {
            if ($this->obStmt) $this->obStmt = null;
            $this->obStmt = $this->obPdo->prepare($strQuery, $arParams);
            $this->obStmt->execute($arParams);
            return $this->obStmt;
        } catch (Exception $e) {
            throw new Exception('Database query error: ' . $e->getMessage());
        }
    }

    /**
     * This method fetch data obtained from the database
     *
     * @return bool|array
     * @throws Exception
     */
    public function fetchAll(): bool|array
    {
        try {
            return $this->obStmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * This method start transaction
     *
     * @return void
     * @throws Exception
     */
    public function startTransaction(): void
    {
        try {
            $this->obPdo->beginTransaction();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * This method commit changes to a transaction
     *
     * @return void
     * @throws Exception
     */
    public function commit(): void
    {
        try {
            $this->obPdo->commit();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * This method rollback changes to a transaction
     *
     * @return void
     * @throws Exception
     */
    public function rollback(): void
    {
        try {
            $this->obPdo->rollback();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * This method close Database connection
     *
     * @return void
     */
    public function close(): void
    {
        $this->obPdo = null;
    }
}