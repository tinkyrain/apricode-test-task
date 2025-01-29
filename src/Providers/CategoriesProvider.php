<?php

namespace App\Providers;

class CategoriesProvider
{
    /**
     * This method return employee list
     *
     * @return array[]
     */
    public static function getCategories(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Category name',
            ]
        ];
    }
}