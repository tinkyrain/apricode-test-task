<?php

namespace App\Controllers\Employee;

use App\Controllers\BaseController;
use App\Providers\CategoriesProvider;
use App\Providers\EmployeesProvider;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SlimSession\Helper;

class EmployeePageController extends BaseController
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
            $data['header'] = $this->loadTemplate($request, 'Common/header.twig', [
                'title' => 'Список сотрудников'
            ]);
            $data['footer'] = $this->loadTemplate($request, 'Common/footer.twig');
            $data['employee_list'] = EmployeesProvider::getEmployees();

            return $this->view($request, $response, 'Pages/employee_list.twig', $data);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    /**
     * This method display add employee page
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $data['header'] = $this->loadTemplate($request, 'Common/header.twig', [
                'title' => 'Создание сотрудника'
            ]);
            $data['footer'] = $this->loadTemplate($request, 'Common/footer.twig');
            $data['categories_list'] = CategoriesProvider::getCategories();
            $data['errors'] = $this->obSession->get('add_form_errors') ?? [];
            $data['fields_value'] = $this->obSession->get('add_form_fields_value') ?? [];

            $this->obSession->delete('add_form_errors');
            $this->obSession->delete('add_form_fields_value');

            return $this->view($request, $response, 'Pages/employee_add.twig', $data);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}