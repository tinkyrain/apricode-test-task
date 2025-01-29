<?php

use App\Controllers\Employee\EmployeeController;
use Slim\App;

return function (App $app) {
    $app->get('/', [EmployeeController::class, 'index']); //employee list
};