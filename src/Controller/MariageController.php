<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Utilitaire\RestMariage;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MariageController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/mariage/{url}", name="mariage",  requirements={"d"="en|fr"})))
     */
    public function listingList(String $url, Request $request): Response
    {

        // GET idMariage value in url
        $mariage = RestMariage::getUnMariage($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'), $url);


        dump($mariage);



        return $this->render('mariage/index.html.twig', [
            'mariage' => $mariage,
            'controller_name' => 'MariageController',
        ]);
    }
}
