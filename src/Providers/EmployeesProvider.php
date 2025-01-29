<?php

namespace App\Providers;

class EmployeesProvider
{
    /**
     * This method return employee list
     *
     * @return array[]
     */
    public static function getEmployees(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Employee Name',
                'email' => 'email@email.com',
                'phone' => '+7 (123) 456-78-90',
                'category_id' => 1
            ]
        ];
    }
}