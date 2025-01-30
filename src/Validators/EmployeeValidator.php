<?php

namespace App\Validators;

use Exception;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

class EmployeeValidator
{
    private static array $arErrors = [
        'name' => [
            'length' => 'Имя сотрудника должно иметь от 1 до 255 символов',
            'notBlank' => 'Это поле обязательно для заполнения!'
        ],
        'phone' => [
            'length' => 'Номер телефона должен иметь от 1 до 12 символов',
            'notBlank' => 'Это поле обязательно для заполнения!',
            'phone' => 'Введите действительный номер телефона!'
        ],
        'email' => [
            'length' => 'Почта должна иметь от 1 до 255 символов',
            'notBlank' => 'Это поле обязательно для заполнения!',
            'email' => 'Введите действительную почту'
        ],
        'category' => [
            'notBlank' => 'Это поле обязательно для заполнения!',
        ],
    ];

    /**
     * This method validate employee create form
     *
     * @param array $arData
     * @return array
     * @throws Exception
     */
    public static function createValidation(array $arData = []): array
    {
        try {
            $arRules = [
                'name' => V::length(1, 255)->notBlank(),
                'phone' => V::length(1, 12)->notBlank()->phone(),
                'email' => V::length(1, 255)->notBlank()->email(),
                'category' => V::notBlank(),
            ];
            $arValidateErrors = [];

            foreach ($arRules as $strField => $obRule) {
                try {
                    $obRule->assert($arData[$strField]);
                } catch (NestedValidationException $e) {
                    $arMessagesList = $e->getMessages(self::$arErrors[$strField]);
                    $arValidateErrors[$strField] = array_values($arMessagesList)[0];
                }
            }

            return $arValidateErrors;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}