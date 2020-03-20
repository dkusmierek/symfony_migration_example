<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LegacyController extends AbstractController
{
    public function loadLegacyScript(string $requestPath, string $legacyScript): Response
    {
        $_SERVER['PHP_SELF'] = $requestPath;
        $_SERVER['SCRIPT_NAME'] = $requestPath;
        $_SERVER['SCRIPT_FILENAME'] = $legacyScript;
        $_SERVER['REQUEST_URI'] = $this->removeTrailingSlashes($_SERVER['REQUEST_URI']);

        chdir(dirname($legacyScript));

        require $legacyScript;
        /** @var \sfWebResponse $legacyResponse */
        /** @var \sfContext $sfContext */
        $legacyResponse = $sfContext->getResponse();

        return $this->prepareResponse($legacyResponse);
    }

    private function prepareResponse(\sfWebResponse $legacyResponse): Response
    {
        $response = new Response($legacyResponse->getContent(), $legacyResponse->getStatusCode());
        $response->headers->set('Content-Type', $legacyResponse->getContentType());

        return $response;
    }

    private function removeTrailingSlashes(string $path): string
    {
        return rtrim($path, '/');
    }
}
