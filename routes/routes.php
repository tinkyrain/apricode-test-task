<?php

use App\Controllers\Employee\EmployeeActionController;
use App\Controllers\Employee\EmployeePageController;
use Slim\App;

return function (App $app) {
    //region pages
    $app->get('/', [EmployeePageController::class, 'index'])
        ->setName('main'); //employee list
    $app->get('/add', [EmployeePageController::class, 'create'])
        ->setName('add'); //add employee
    //endregion

    //region actions
    $app->post('/action/add', [EmployeeActionController::class, 'create'])
        ->setName('add-action'); //add employee action
    //endregion
};