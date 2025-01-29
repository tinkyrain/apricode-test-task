<?php

namespace App\Providers;

use App\Storage\Database;
use Exception;

class CategoriesProvider
{
    /**
     * This method return employee list
     *
     * @return array[]
     * @throws Exception
     */
    public static function getCategories(): array
    {
        try {
            $obDatabase = Database::getInstance();
            $strQuery = 'select * from categories';
            $arResult = $obDatabase->executeQuery($strQuery)?->fetchAll();
            if ($arResult === false) throw new Exception('Get categories list error!');
            return $arResult;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}