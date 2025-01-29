<?php

namespace App\Providers;

use App\Storage\Database;
use Exception;

class EmployeesProvider
{
    /**
     * This method return employee list
     *
     * @return array[]
     * @throws Exception
     */
    public static function getEmployees(array $data = []): array
    {
        try {
            $obDatabase = Database::getInstance();

            $strQuery = '';

        } catch (Exception $e) {
            throw new Exception("Employees Provider Error: " . $e->getMessage());
        }
    }
}