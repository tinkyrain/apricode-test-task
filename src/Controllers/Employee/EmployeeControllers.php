<?php

use Controllers\BaseController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EmployeeControllers extends BaseController
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
            return $this->view($request, $response, 'employee_list',$arEmployeesList);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}