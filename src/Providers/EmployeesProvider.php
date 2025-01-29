<?php

namespace App\Providers;

use App\Storage\Database;
use Exception;

class EmployeesProvider
{
    /**
     * This method return employee list
     *
     * @return array
     * @throws Exception
     */
    public static function getEmployees(): array
    {
        try {
            $obDatabase = Database::getInstance();
            $strQuery = 'select * from employees';
            $arResult = $obDatabase->executeQuery($strQuery)?->fetchAll();
            if ($arResult === false) throw new Exception('Get employee list error!');
            return $arResult;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}