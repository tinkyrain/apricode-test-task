<?php

namespace App\Validators;

use Exception;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

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
     * This method validate employee create form
     *
     * @param ServerRequestInterface $obRequest
     * @return void
     * @throws Exception
     */
    public static function createValidation(ServerRequestInterface $obRequest)
    {
        try {
            $arData = json_decode($obRequest->getBody()->getContents(), true);
            $arRules = [
                'name' => V::length(1, 255)->notBlank(),
                'phone' => V::length(1, 12)->notBlank()->phone(),
                'email' => V::length(1, 12)->notBlank()->email(),
                'category' => V::notBlank(),
            ];
            $arValidateErrors = [];

            foreach ($arRules as $strField => $obRule) {
                try {
                    $obRule->assert($arData[$strField]);
                } catch (ValidationException $e) {
                    $strRuleName = $e->getMessage();
                }
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}