<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Utilitaire\RestListing;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ListingController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/annonce/{url}", name="listing", requirements={"d"="en|fr"})
     */
    public function index(String $url, Request $request): Response
    {
        $listing = RestListing::getListing($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'), $url);

        dump($listing);

        return $this->render('listing/index.html.twig', [
            'listing' => $listing,
            'controller_name' => 'ListingController'
        ]);
    }
}
