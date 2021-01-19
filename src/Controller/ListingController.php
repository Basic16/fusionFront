<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListingController extends AbstractController
{
    /**
     * @Route("/annonce/{name}", name="listing",  requirements={
     *     "_locale"="en|fr"
     * }))
     */
    public function index(): Response
    {
        return $this->render('listing/index.html.twig', [
            'controller_name' => 'ListingController',
        ]);
    }
}
