<?php

namespace App\Controllers\Employee;

use App\Providers\EmployeesProvider;
use App\Validators\EmployeeValidator;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use SlimSession\Helper;

class EmployeeActionController
{
    private Helper $obSession;

    public function __construct()
    {
        $this->obSession = new Helper();
    }

    /**
     * This method create employee
     *
     * @throws Exception
     * @throws Exception
     */
    public function create(ServerRequestInterface $obRequest, ResponseInterface $obResponse)
    {
        try {
            $arData = $obRequest->getParsedBody();
            $obRouteParser = RouteContext::fromRequest($obRequest)->getRouteParser();
            $arValidateError = EmployeeValidator::createValidation($arData); //validate data

            if ($arValidateError) {
                $strAddPageUrl = $obRouteParser->urlFor('add');
                $this->obSession->set('add_form_errors', $arValidateError);
                $this->obSession->set('add_form_fields_value', $arData);

                return $obResponse
                    ->withHeader('Location', $strAddPageUrl)
                    ->withStatus(302);
            }

            EmployeesProvider::createEmployee($arData);
            $strMainPageUrl = $obRouteParser->urlFor('main');
            return $obResponse
                ->withHeader('Location', $strMainPageUrl)
                ->withStatus(302);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function export()
    {

    }
}