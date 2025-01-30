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
            $strQuery = 'select id, name, phone, email, category_id from employees';
            $arResult = $obDatabase->executeQuery($strQuery)?->fetchAll();
            if ($arResult === false) throw new Exception('Get employee list error!');
            return $arResult;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * This method add employee
     *
     * @param array $arData
     * @throws Exception
     */
    public static function createEmployee(array $arData): void
    {
        try {
            $obDatabase = Database::getInstance();
            $strQuery = '
                INSERT INTO public.employees(
                name, phone, email, category_id)
                VALUES (:name, :phone, :email, :category_id)
            ';
            $obDatabase->executeQuery($strQuery, [
                ':name' => $arData['name'],
                ':phone' => $arData['phone'],
                ':email' => $arData['email'],
                ':category_id' => $arData['category']
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}