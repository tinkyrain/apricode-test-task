<?php

namespace App\Controllers\Employee;

use App\Controllers\BaseController;
use App\Providers\EmployeesProvider;
use App\Validators\EmployeeValidator;
use Exception;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use SlimSession\Helper;

class EmployeeActionController extends BaseController
{
    /**
     * This method create employee
     *
     * @throws Exception
     * @throws Exception
     */
    public function create(ServerRequestInterface $obRequest, ResponseInterface $obResponse): ResponseInterface
    {
        try {
            $arData = $obRequest->getParsedBody();
            $obRouteParser = RouteContext::fromRequest($obRequest)->getRouteParser();
            $arValidateError = EmployeeValidator::createValidation($arData); //validate data

            //if errors, then redirect on add form with errors
            if ($arValidateError) {
                $strAddPageUrl = $obRouteParser->urlFor('add');
                $this->obSession->set('add_form_errors', $arValidateError);
                $this->obSession->set('add_form_fields_value', $arData);
                return $this->redirect($obResponse, $strAddPageUrl);
            }

            EmployeesProvider::createEmployee($arData);
            $strMainPageUrl = $obRouteParser->urlFor('main');
            return $this->redirect($obResponse, $strMainPageUrl);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function export()
    {

    }
}