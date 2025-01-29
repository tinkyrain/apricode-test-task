<?php

use App\Storage\Database;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require_once 'vendor/autoload.php';

/**
 * Init Slim Application
 *
 * @return App
 * @throws Exception
 */
function initApp(): App
{
    try {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $app = AppFactory::create(); //application init

        //region twig
        $twig = Twig::create(__DIR__ . '\src\Views', ['cache' => false]);
        $app->add(TwigMiddleware::create($app, $twig));
        //endregion

        //region load env
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        //endregion

        Database::getInstance(); //create DB class instance

        (require_once __DIR__ . '/routes/routes.php')($app); //include routes

        return $app;
    } catch (Exception $e) {
        throw new Exception($e->getMessage(), 500);
    }
}