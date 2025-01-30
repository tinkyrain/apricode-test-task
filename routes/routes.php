<?php

use App\Controllers\Employee\EmployeeActionController;
use App\Controllers\Employee\EmployeePageController;
use Slim\App;

return function (App $obApp) {
    //region pages
    $obApp->get('/', [EmployeePageController::class, 'index'])
        ->setName('main'); //employee list
    $obApp->get('/add', [EmployeePageController::class, 'create'])
        ->setName('add'); //add employee
    //endregion

    //region actions
    $obApp->post('/action/add', [EmployeeActionController::class, 'create'])
        ->setName('add-action'); //add employee action
    //endregion
};