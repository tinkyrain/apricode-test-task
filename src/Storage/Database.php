<?php

namespace App\Storage;

use Exception;
use PDO;
use PDOStatement;

class Database
{
    private static ?Database $obInstance = null;
    private ?PDO $obPdo;
    private false|PDOStatement $obStmt;

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
     */
    public static function getInstance(): Database
    {
        if (is_null(self::$obInstance)) self::$obInstance = new Database();
        return self::$obInstance;
    }

    /**
     * This method execute SQL query
     *
     * @param string $strQuery
     * @param array $arParams
     * @return bool|PDOStatement
     */
    public function executeQuery(string $strQuery, array $arParams = []): bool|PDOStatement
    {
        if ($this->obStmt) $this->obStmt = null;
        $this->obStmt = $this->obPdo->prepare($strQuery, $arParams);
        $this->obStmt->execute($arParams);
        return $this->obStmt;
    }

    /**
     * This method fetch data obtained from the database
     *
     * @return bool|array
     */
    public function fetchAll(): bool|array
    {
        return $this->obStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This method start transaction
     *
     * @return void
     */
    public function startTransaction(): void
    {
        $this->obPdo->beginTransaction();
    }

    /**
     * This method commit changes to a transaction
     *
     * @return void
     */
    public function commit(): void
    {
        $this->obPdo->commit();
    }

    /**
     * This method rollback changes to a transaction
     *
     * @return void
     */
    public function rollback(): void
    {
        $this->obPdo->rollback();
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