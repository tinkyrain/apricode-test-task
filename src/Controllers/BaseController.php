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
     * @param ServerRequestInterface $obRequest
     * @param ResponseInterface $obResponse
     * @param string $strTemplateName
     * @param array $arData
     * @return ResponseInterface
     */
    public function view(ServerRequestInterface $obRequest, ResponseInterface $obResponse, string $strTemplateName, array $arData = []): ResponseInterface
    {
        try {
            $obView = Twig::fromRequest($obRequest);
            return $obView->render($obResponse, $strTemplateName, $arData);
        } catch (LoaderError|RuntimeError|SyntaxError|Exception $e) {
            die('Template load error: ' . $e->getMessage());
        }
    }
}