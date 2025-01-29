<?php

namespace App\Validators;

use Awurth\Validator\Validator;
use Respect\Validation\Validator as V;

class EmployeeValidator
{
    private array $arErrors = [
        'name' => [
            'length' => 'Имя сотрудника должно иметь от 1 до 255 символов',
            'notBlank' => 'Это поле обязательно для заполнения!'
        ],
        'phone' => [
            'length' => 'Номер телефона должен иметь от 1 до 12 символов',
            'notBlank' => 'Это поле обязательно для заполнения!',
            'phone' => 'Введите номер телефона!'
        ],
        'email' => [
            'length' => 'Почта должна иметь от 1 до 255 символов',
            'notBlank' => 'Это поле обязательно для заполнения!',
            'email' => 'Введите почту!'
        ],
        'category' => [
            'notBlank' => 'Это поле обязательно для заполнения!',
        ],
    ];

    /**
     * This method validate create employee form
     *
     * @param $request
     * @return void
     */
    public static function createValidation($request)
    {
        $arRules = [
            'name' => V::length(1, 255)->notBlank(),
            'phone' => V::length(1, 12)->notBlank()->phone(),
            'email' => V::length(1, 12)->notBlank()->email(),
            'category' => V::notBlank(),
        ];

        $obValidator = (new V())->addRule();
        $isValid = $obValidator->isValid();
    }
}