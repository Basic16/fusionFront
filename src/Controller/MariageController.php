<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MariageController extends AbstractController
{
    /**
     * @Route("/mariage", name="mariage")
     */
    public function mariage(): Response
    {
        return $this->render('mariage/index.html.twig', [
            'controller_name' => 'MariageController',
        ]);
    }
}
