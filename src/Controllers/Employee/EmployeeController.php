<?php

namespace App\Controllers\Employee;

use App\Controllers\BaseController;
use App\Providers\EmployeesProvider;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EmployeeController extends BaseController
{
    /**
     * This method display employee list
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $arEmployeesList = EmployeesProvider::getEmployees();
            return $this->view($request, $response, 'Pages\employee_list.twig',$arEmployeesList);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}