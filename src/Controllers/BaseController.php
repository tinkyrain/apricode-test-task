<?php

namespace App\Controllers;

use Exception;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use SlimSession\Helper;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class BaseController
{
    protected Helper $obSession;

    public function __construct()
    {
        $this->obSession = new Helper();
    }


    /**
     * Load twig view
     *
     * @param ServerRequestInterface $obRequest
     * @param ResponseInterface $obResponse
     * @param string $strTemplateName
     * @param array $arData
     * @return ResponseInterface
     */
    protected function view(ServerRequestInterface $obRequest, ResponseInterface $obResponse, string $strTemplateName, array $arData = []): ResponseInterface
    {
        try {
            $obView = Twig::fromRequest($obRequest);
            $strView = html_entity_decode($obView->fetch($strTemplateName, $arData), ENT_QUOTES, 'UTF-8');
            $obResponse->getBody()->write($strView);
            return $obResponse->withHeader('Content-type', 'text/html');
        } catch (LoaderError|RuntimeError|SyntaxError|Exception $e) {
            die('Template load error: ' . $e->getMessage());
        }
    }

    /**
     * This method return string content template
     *
     * @param ServerRequestInterface $obRequest
     * @param string $strTemplateName
     * @param array $arData
     * @return string
     */
    protected function loadTemplate(ServerRequestInterface $obRequest, string $strTemplateName, array $arData = []): string
    {
        try {
            $obView = Twig::fromRequest($obRequest);
            return html_entity_decode($obView->fetch($strTemplateName, $arData), ENT_QUOTES, 'UTF-8');
        } catch (Exception $e) {
            die('Template load error: ' . $e->getMessage());
        }
    }

    /**
     * This method redirect on page
     *
     * @param ResponseInterface $obResponse
     * @param string $strRedirectUrl
     * @param int $intRedirectCode
     * @return ResponseInterface
     */
    protected function redirect(ResponseInterface $obResponse, string $strRedirectUrl, int $intRedirectCode = 302): ResponseInterface
    {
        try {
            return $obResponse
                ->withHeader('Location', $strRedirectUrl)
                ->withStatus($intRedirectCode);
        } catch (EXception $e) {
            die('Redirect error: ' . $e->getMessage());
        }
    }
}