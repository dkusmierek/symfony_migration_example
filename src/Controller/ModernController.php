<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ModernController extends AbstractController
{
    public function indexAction(): Response
    {
        return $this->render('modern/index.html.twig', [
            'title' => "Symfony 4.4 Page",
        ]);
    }
}
