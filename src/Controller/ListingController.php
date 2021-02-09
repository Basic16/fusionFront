<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ListingController extends AbstractController
{
    /**
     * @Route("/annonce/{url}", name="listing", requirements={"d"="en|fr"})
     */
    public function index(String $url, Request $request): Response
    {
        return $this->render('listing/index.html.twig', [
            'controller_name' => 'ListingController',
        ]);
    }
}
