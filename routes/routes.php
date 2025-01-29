<?php

use App\Controllers\Employee\EmployeePageController;
use Slim\App;

return function (App $app) {
    //region pages
    $app->get('/', [EmployeePageController::class, 'index']); //employee list
    $app->get('/add', [EmployeePageController::class, 'create']); //add employee
    //endregion

    //region actions

    //endregion
};