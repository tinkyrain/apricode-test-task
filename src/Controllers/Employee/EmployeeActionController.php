<?php

namespace App\Controllers\Employee;

use App\Controllers\BaseController;
use App\Providers\EmployeesProvider;
use App\Providers\TasksProvider;
use App\Validators\EmployeeValidator;
use Exception;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

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

    /**
     * Export employee task in CSV file
     *
     * @param ServerRequestInterface $obRequest
     * @param ResponseInterface $obResponse
     * @return ResponseInterface
     * @throws Exception
     */
    public function export(ServerRequestInterface $obRequest, ResponseInterface $obResponse): ResponseInterface
    {
        try {
            $obOutput = fopen('php://output', 'w');

            ob_start();
            ob_clean();

            fputcsv($obOutput, ['Сотрудник', 'Номер задачи', 'Название задачи', 'Потраченное время']);
            $arEmployeeList = EmployeesProvider::getEmployees();
            foreach ($arEmployeeList as $arEmployee) {
                $arEmployeeTasks = TasksProvider::getEmployeeTasks((int)$arEmployee['id']);
                foreach ($arEmployeeTasks as $arEmployeeTask) {
                    fputcsv($obOutput, [
                        $arEmployee['name'],
                        $arEmployeeTask['id'],
                        $arEmployeeTask['name'],
                        $arEmployeeTask['worktime'],
                    ]);
                }
            }
            fclose($obOutput);
            $strContent = ob_get_clean();
            $mixedContent = mb_convert_encoding($strContent, 'UTF-8', 'UTF-8');
            $obResponse->getBody()->write($mixedContent);
            return $obResponse->withHeader('Content-Type', 'text/csv')
                ->withHeader('Content-Disposition', 'attachment; filename="data.csv"');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}