<?php

namespace App\Providers;

use App\Storage\Database;
use Exception;

class TasksProvider
{
    /**
     * This method return employee tasks
     *
     * @param int $intEmployeeId
     * @return array
     * @throws Exception
     */
    public static function getEmployeeTasks(int $intEmployeeId): array
    {
        try {
            $obDatabase = Database::getInstance();
            $strQuery = 'select id, name, worktime from tasks where employee_id = :id';
            $arResult = $obDatabase->executeQuery($strQuery, [
                ':id' => $intEmployeeId
            ]);
            if ($arResult === false) throw new Exception('Get tasks list error!');
            return $arResult;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}