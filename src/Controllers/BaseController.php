<?php

namespace App\Controllers;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class BaseController
{
    /**
     * Load twig view
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param string $templateName
     * @param array $data
     * @return ResponseInterface
     */
    public function view(ServerRequestInterface $request, ResponseInterface $response, string $templateName, array $data = []): ResponseInterface
    {
        try {
            $view = Twig::fromRequest($request);
            return $view->render($response, $templateName, $data);
        } catch (LoaderError|RuntimeError|SyntaxError|Exception $e) {
            die('Template load error: ' . $e->getMessage());
        }
    }
}